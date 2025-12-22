<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;

/**
 * Service simplifié pour communiquer avec l'API OpenRouter.
 *
 * Exemple pédagogique utilisant le client HTTP de Laravel.
 */
class SimpleAskService
{
    public const DEFAULT_MODEL = 'openai/gpt-5-mini';

    private string $apiKey;

    private string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.openrouter.api_key');
        $this->baseUrl = rtrim(config('services.openrouter.base_url', 'https://openrouter.ai/api/v1'), '/');
    }

    /**
     * Récupère la liste des modèles disponibles.
     *
     * @return array<int, array{
     *     id: string,
     *     name: string,
     *     description: string,
     *     context_length: int,
     *     max_completion_tokens: int,
     *     input_modalities: array<string>,
     *     output_modalities: array<string>,
     *     supported_parameters: array<string>
     * }>
     */
    public function getModels(): array
    {
        return cache()->remember('openrouter.models', now()->addHour(), function (): array {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$this->apiKey,
            ])->get($this->baseUrl.'/models');

            return collect($response->json('data', []))
                ->sortBy('name')
                ->map(fn (array $model): array => [
                    'id' => $model['id'],
                    'name' => $model['name'],
                    'description' => $model['description'] ?? '',
                    'context_length' => $model['context_length'] ?? 0,
                    'max_completion_tokens' => $model['top_provider']['max_completion_tokens'] ?? 0,
                    'input_modalities' => $model['architecture']['input_modalities'] ?? [],
                    'output_modalities' => $model['architecture']['output_modalities'] ?? [],
                    'supported_parameters' => $model['supported_parameters'] ?? [],
                ])
                ->values()
                ->toArray();
        });
    }

    /**
     * Envoie un message et retourne la réponse du modèle.
     *
     * @param array<int, array{
     *     role: 'assistant'|'system'|'tool'|'user',
     *     content: array<int, array{
     *         type: 'image_url'|'text',
     *         text?: string,
     *         image_url?: array{url: string, detail?: string}
     *     }>|string
     * }> $messages
     */
    public function sendMessage(array $messages, ?string $model = null, float $temperature = 1.0): string
    {
        $model = $model ?? self::DEFAULT_MODEL;
        $messages = [$this->getSystemPrompt(), ...$messages];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->apiKey,
            'Content-Type' => 'application/json',
            'HTTP-Referer' => config('app.url'),
            'X-Title' => config('app.name'),
        ])
            ->timeout(120)
            ->post($this->baseUrl.'/chat/completions', [
                'model' => $model,
                'messages' => $messages,
                'temperature' => $temperature,
            ]);

        // Gestion des erreurs
        if ($response->failed()) {
            $error = $response->json('error.message', 'Erreur inconnue');
            throw new \RuntimeException("Erreur API: {$error}");
        }

        return $response->json('choices.0.message.content', '');
    }

    // Новый метод для генерации заголовка
    /*public function generateTitle(string $botText): string
    {
        // Простейший вариант — взять первые 5–7 слов ответа
        $words = explode(' ', strip_tags($botText));
        $title = implode(' ', array_slice($words, 0, 7));

        // Можно обрезать и добавить "..." если длиннее
        if (count($words) > 7) {
            $title .= '...';
        }

        return $title;
    }*/
    /*  public function generateTitleFromTextAI(string $botText): string
{
    // Промпт, который просит AI сделать короткий информативный заголовок
    $prompt = "Génère un titre très court et clair (3-6 mots) pour résumer cette conversation : \"$botText\"";

    // Отправляем запрос к AI, **только с этим текстом**, без всей истории сообщений
    $response = $this->sendMessage([
      [
          'role' => 'user',
          'content' => [['type' => 'text', 'text' => $prompt]]
      ]
    ], self::DEFAULT_MODEL);

    // Чистим и возвращаем результат
    return trim($response) ?: "Nouvelle conversation";
}
*/
    /**
     * Retourne le prompt système.
     *
     * @return array{role: 'system', content: string}
     */
    private function getSystemPrompt(): array
    {
        $user = auth()->user();
        $preferences = $user?->preferences;

        $now = now()->locale('fr')->format('l d F Y H:i');

        $personalisationText = '';

        if ($preferences) {
            if ($preferences->about) {
                $personalisationText .= "\n\nÀ propos de l'utilisateur :\n{$preferences->about}";
            }

            if ($preferences->behaviour) {
                $personalisationText .= "\n\nComportement attendu de l'assistant :\n{$preferences->behaviour}";
            }

            if ($preferences->commands) {
                $personalisationText .= "\n\nCommandes personnalisées à respecter :\n{$preferences->commands}";
            }
        }

        $systemContent = <<<PROMPT
Tu es un assistant conversationnel.

Date et heure : {$now}
Utilisateur : {$user->name}

{$personalisationText}

IMPORTANT :
- Tu dois STRICTEMENT respecter les préférences de l'utilisateur.
- Le ton, le style et les commandes personnalisées sont prioritaires sur tout le reste.
PROMPT;

        return [
            'role' => 'system',
            'content' => $systemContent,
        ];
    }

    public function generateTitleFromTextAI(string $botText): string
    {
        $system = $this->getSystemPrompt(); // 👈 ТОТ ЖЕ САМЫЙ

        $userPrompt = <<<PROMPT
Génère un titre très court et clair (3-6 mots) pour résumer cette conversation : \"$botText\

Règles :
- Utilise STRICTEMENT la même langue que celle du message
- Ne dis rien d'autre que le titre
- Pas de guillemets, pas d'explications

Message :
{$botText}
PROMPT;

        $response = $this->sendMessage([
            $system,
            [
                'role' => 'user',
                'content' => [
                    ['type' => 'text', 'text' => $userPrompt],
                ],
            ],
        ], self::DEFAULT_MODEL);

        return trim($response) ?: 'Nouvelle conversation';
    }
}
