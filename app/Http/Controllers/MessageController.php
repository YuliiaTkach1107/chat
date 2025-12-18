<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Services\SimpleAskService;
use Inertia\Inertia;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Conversation $conversation)
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created message and get bot response.
     */
     public function store(Request $request, Conversation $conversation, \App\Services\SimpleAskService $chatService)
{
    ini_set('max_execution_time', 120);
    // Проверка прав пользователя
    abort_if($conversation->user_id !== auth()->id(), 403);

    // Валидация
    $request->validate([
        'message' => 'required|string',
        'model' => 'sometimes|string',
    ]);

    // 1. Сохраняем сообщение пользователя
    $userMessage = $conversation->messages()->create([
        'user_id' => auth()->id(),
        'role' => 'user',
        'content' => $request->message,
    ]);

    $botMessage = null;
    $error = null;

    try {
        // 2. Формируем массив сообщений для API
        $messagesForAPI = $conversation->messages()
            ->orderBy('created_at')
            ->get()
            ->map(fn($m) => [
                'role' => $m->role === 'assistant' ? 'assistant' : $m->role,
                'content' => [['type' => 'text', 'text' => $m->content]], // оборачиваем в массив для API
            ])
            ->toArray();

        // 3. Получаем ответ от бота
        $botText = $chatService->sendMessage(
            $messagesForAPI, 
            $request->model ?? $conversation->selected_model
        );
       \Log::info('Bot text:', [$botText]);

        // 4. Сохраняем ответ бота
        $botMessage = $conversation->messages()->create([
            'user_id' => null,
            'role' => 'assistant',
            'content' => $botText,
        ]);
        // Если заголовок ещё пустой, генерируем автоматически
if (empty($conversation->title) || $conversation->title === 'Nouvelle conversation') {
    $conversation->title = $chatService->generateTitleFromTextAI($botText);
    $conversation->save();
    \Log::info('Generated AI title:', [$conversation->title]);
}
    } catch (\Exception $e) {
        $error = $e->getMessage();
    }

    // 5. Загружаем модели для фронта
    $askService = app(\App\Services\SimpleAskService::class);
    $models = $askService->getModels(); 


    // 6. Перенаправляем на show с обновленной беседой
    $conversation->load(['messages' => fn($q) => $q->orderBy('created_at','asc')]);
    

    return redirect()->route('conversation.show', $conversation);

}




    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
