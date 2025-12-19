<?php

declare(strict_types=1);

namespace App\Services;

use Generator;
use Illuminate\Support\Facades\Http;
use Psr\Http\Message\StreamInterface;

/**
 * Service simplifié pour le streaming avec l'API OpenRouter.
 *
 * Exemple pédagogique utilisant le client HTTP de Laravel.
 *
 * @see https://openrouter.ai/docs/api/reference/streaming
 */
class SimpleAskStreamService
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
     * Récupère la liste des modèles disponibles (avec cache).
     */
    public function getModels(): array
    {
        return cache()->remember('openrouter.models', now()->addHour(), function (): array {
            $response = Http::withToken($this->apiKey)->get("{$this->baseUrl}/models");

            return collect($response->json('data', []))
                ->sortBy('name')
                ->map(fn(array $model): array => [
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
     * Récupère la liste légère des modèles.
     */
    public function getModelsLight(): array
    {
        return collect($this->getModels())
            ->map(fn(array $m): array => ['id' => $m['id'], 'name' => $m['name']])
            ->values()
            ->toArray();
    }

    /**
     * Récupère les détails d'un modèle.
     */
    public function getModelDetails(string $id): ?array
    {
        return collect($this->getModels())->firstWhere('id', $id);
    }

    /**
     * Stream un message en temps réel vers la sortie.
     * Output le contenu texte directement (compatible avec useStream de Laravel).
     */
    public function streamToOutput(
        array $messages,
        callable $onChunk,
        ?string $model = null,
        float $temperature = 1.0,
        ?string $reasoningEffort = null
    ): void {
        $response = $this->sendStreamRequest($messages, $model, $temperature, $reasoningEffort);

        if ($response->failed()) {
            echo "[ERROR] " . $response->json('error.message', 'HTTP Error');
            $this->flush();
            return;
        }

        foreach ($this->parseSSEStream($response->toPsrResponse()->getBody()) as $event) {
           
            if ($event['type'] === 'error') {
                echo "[ERROR] " . $event['data'];
                $this->flush();
                return;
            }

            if ($event['type'] === 'content' && $event['data']) {
                $onChunk($event['data']);
                $this->flush();
            }

            // Pour le reasoning, on utilise un préfixe spécial
            if ($event['type'] === 'reasoning' && $event['data']) {
                echo "[REASONING]" . $event['data'] . "[/REASONING]";
                $this->flush();
            }
        }
    }

    /**
     * Flush la sortie immédiatement.
     */
    private function flush(): void
    {
        if (ob_get_level() > 0) {
            ob_flush();
        }
        flush();
    }

    /**
     * Envoie la requête streaming à l'API.
     */
    private function sendStreamRequest(
        array $messages,
        ?string $model,
        float $temperature,
        ?string $reasoningEffort
    ): \Illuminate\Http\Client\Response {
        $payload = [
            'model' => $model ?? self::DEFAULT_MODEL,
            'messages' => [$this->getSystemPrompt(), ...$messages],
            'temperature' => $temperature,
            'stream' => true,
        ];

        if ($reasoningEffort !== null) {
            $payload['reasoning'] = ['effort' => $reasoningEffort];
        }

        return Http::withToken($this->apiKey)
            ->withHeaders([
                'HTTP-Referer' => config('app.url'),
                'X-Title' => config('app.name'),
            ])
            ->withOptions(['stream' => true])
            ->timeout(120)
            ->post("{$this->baseUrl}/chat/completions", $payload);
    }

    /**
     * Parse un stream SSE et yield les événements.
     *
     * @return Generator<array{type: string, data: string|null}>
     */
    private function parseSSEStream(StreamInterface $body): Generator
    {
        $buffer = '';

        while (!$body->eof()) {
            $buffer .= $body->read(1024);

            while (($pos = strpos($buffer, "\n")) !== false) {
                $line = trim(substr($buffer, 0, $pos));
                $buffer = substr($buffer, $pos + 1);

                if ($event = $this->parseSSELine($line)) {
                    yield $event;
                }
            }
        }
    }

    /**
     * Parse une ligne SSE.
     */
    private function parseSSELine(string $line): ?array
    {
       
        if ($line === '' || str_starts_with($line, ':')) {
            return null;
        }

        if (!str_starts_with($line, 'data: ')) {
            return null;
        }

        $data = substr($line, 6);

        if ($data === '[DONE]') {
            return ['type' => 'done', 'data' => null];
        }

        return $this->parseJSON($data);
    }

    /**
     * Parse le JSON d'un chunk SSE.
     */
    private function parseJSON(string $json): ?array
    {
        try {
            $parsed = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

            if (isset($parsed['error'])) {
                return ['type' => 'error', 'data' => $parsed['error']['message'] ?? 'Unknown error'];
            }

            $delta = $parsed['choices'][0]['delta'] ?? [];

            if (!empty($delta['content'])) {
                return ['type' => 'content', 'data' => $delta['content']];
            }

            if (!empty($delta['reasoning'])) {
                return ['type' => 'reasoning', 'data' => $delta['reasoning']];
            }

            if (!empty($delta['reasoning_content'])) {
                return ['type' => 'reasoning', 'data' => $delta['reasoning_content']];
            }

            return null;
        } catch (\JsonException) {
            return null;
        }
    }

    /**
     * Retourne le prompt système.
     */


private function getSystemPrompt(): array
{
    
    $user = auth()->user();
    $preferences = $user?->preferences;

    $now = now()->locale('fr')->format('l d F Y H:i');

    $personalisationText = '';

    // Добавляем персонализацию, если есть
    if ($preferences) {
        if (!empty($preferences->about)) {
            $personalisationText .= "\n\nÀ propos de l'utilisateur :\n{$preferences->about}";
        }
        if (!empty($preferences->behaviour)) {
            $personalisationText .= "\n\nComportement attendu de l'assistant :\n{$preferences->behaviour}";
        }
        if (!empty($preferences->commands)) {
            $personalisationText .= "\n\nCommandes personnalisées à respecter :\n{$preferences->commands}";
        }
    }

    // Формируем системный контент
   $systemContent = <<<PROMPT
Tu es PsyBot, un assistant de soutien psychologique.

Ton rôle est d’écouter avec bienveillance, de reformuler les émotions de l’utilisateur
et de poser des questions ouvertes pour l’aider à réfléchir.

Tu utilises un ton calme, empathique et rassurant.
Tu ne juges jamais.
Tu ne donnes pas de diagnostics médicaux.
Tu ne remplaces pas un professionnel de santé.

Si l’utilisateur semble en détresse, tu l’encourages doucement à demander de l’aide
auprès d’un professionnel ou d’une personne de confiance.

Tu peux utiliser des émojis doux quand c’est approprié (🌱 💙), sans excès.

---
CONTEXTE TECHNIQUE (ne pas mentionner explicitement) :
Date et heure : {$now}
Utilisateur : {$user->name}

PRÉFÉRENCES UTILISATEUR (prioritaires) :
{$personalisationText}

RÈGLES IMPORTANTES :
- Tu dois STRICTEMENT respecter les préférences de l'utilisateur.
- Le ton, le style et les commandes personnalisées sont prioritaires sur tout le reste.
- Réponds uniquement au contenu du message de l'utilisateur.
- N'inclus jamais d'instructions internes ou techniques dans ta réponse.
PROMPT;


    return [
        'role' => 'system',
        'content' => $systemContent,
    ];
}





    /*private function getSystemPrompt(): array
    {
        return [
            'role' => 'system',
            'content' => view('prompts.system', [
                'now' => now()->locale('fr')->format('l d F Y H:i'),
                'user' => auth()->user()?->name ?? 'l\'utilisateur',
            ])->render(),
        ];
    }*/
}