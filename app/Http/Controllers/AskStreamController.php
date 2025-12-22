<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Message;
use App\Services\SimpleAskService;
use App\Services\SimpleAskStreamService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Controller pour la démonstration du streaming SSE.
 *
 * Exemple pédagogique : streaming temps réel avec Laravel + Vue.
 */
class AskStreamController extends Controller
{
    public function __construct(
        private SimpleAskStreamService $streamService
    ) {
        $this->streamService = $streamService;
    }

    /**
     * Affiche la page de streaming.
     */
    public function index(Request $request): Response
    {
        $modelId = $request->input('model')
            ?? auth()->user()?->preferred_model
            ?? SimpleAskStreamService::DEFAULT_MODEL;

        return Inertia::render('AskStream/Index', [
            'models' => $this->streamService->getModelsLight(),
            'selectedModel' => $modelId,
            'selectedModelDetails' => fn () => $this->streamService->getModelDetails($modelId),
        ]);
    }

    /**
     * Endpoint de streaming.
     */
    public function stream(Request $request): StreamedResponse
    {
        set_time_limit(200);
        $validated = $request->validate([
            'message' => 'required|string',
            'model' => 'required|string',
            'temperature' => 'nullable|numeric',
            'reasoning_effort' => 'nullable|string',
            'conversation_id' => 'required|integer',
        ]);

        $messages = [
            ['role' => 'user', 'content' => $validated['message']],
        ];

        $model = $validated['model'];
        $temperature = (float) ($validated['temperature'] ?? 1.0);
        $reasoningEffort = $validated['reasoning_effort'] ?? null;
        $conversationId = $validated['conversation_id'];

        // 🔹 1. Сохраняем сообщение пользователя
        Message::create([
            'conversation_id' => $conversationId,
            'role' => 'user',
            'content' => $validated['message'],
        ]);

        // 🔹 2. Стримим ответ ассистента
        return response()->stream(
            function () use ($messages, $model, $temperature, $reasoningEffort, $conversationId) {

                $chunks = [];

                $this->streamService->streamToOutput(
                    $messages,
                    function (string $chunk) use (&$chunks) {
                        echo $chunk;  // выводим пользователю
                        flush();
                        $chunks[] = $chunk;
                    },
                    $model,
                    $temperature,
                    $reasoningEffort
                );

                // 🔹 3. После окончания стрима сохраняем полный ответ ассистента
                $fullMessage = implode('', $chunks);

                Message::create([
                    'conversation_id' => $conversationId,
                    'role' => 'assistant',
                    'content' => $fullMessage,
                ]);

                // 🔹 4. Генерация титра через SimpleAskService
                $askService = app(SimpleAskService::class);
                $title = $askService->generateTitleFromTextAI($fullMessage);

                // 🔹 5. Сохраняем титр в Conversation
                $conversation = \App\Models\Conversation::find($conversationId);
                if ($conversation && (empty($conversation->title) || $conversation->title === 'Nouvelle conversation')) {
                    $conversation->title = $title;
                    $conversation->save();
                }
            },
            headers: [
                'Content-Type' => 'text/plain; charset=utf-8',
                'Cache-Control' => 'no-cache',
            ]
        );
    }
}
