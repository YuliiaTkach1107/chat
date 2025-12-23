<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Conversation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ChatTest extends DuskTestCase
{
    /**
     * Тест базовой отправки сообщения и получения стрима
     */
    public function testUserCanSendMessageWithoutStreaming()
{
    $user = User::factory()->create();
    $conversation = Conversation::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->browse(function (Browser $browser) use ($user, $conversation) {
        $browser->loginAs($user)
                ->visit("/chat/{$conversation->id}")
                ->waitFor('#chat-message', 5)
                ->assertSee('Zone de conversation')

                // Ввод сообщения
                ->type('#chat-message', 'Bonjour, test message')
                ->press('button[aria-label="Envoyer le message"]')

                // ✅ Проверяем ТОЛЬКО сообщение пользователя
                ->waitForText('Bonjour, test message', 5)
                ->assertSee('✨ Vous');
    });
}


    /**
     * Тест смены модели
     */
    public function testUserCanChangeModel()
    {
        $user = User::factory()->create();
        $conversation = Conversation::factory()->create(['user_id' => $user->id]);

        $this->browse(function (Browser $browser) use ($user, $conversation) {
            $browser->loginAs($user)
                    ->visit("/chat/{$conversation->id}")
                    ->waitFor('select[aria-label="Sélectionner un modèle IA"]', 5)
                    
                    // Проверяем текущую модель
                    ->assertSelected('select[aria-label="Sélectionner un modèle IA"]', 'openai/gpt-5-mini')
                    
                    // Меняем модель
                    ->select('select[aria-label="Sélectionner un modèle IA"]', 'openai/gpt-4o')
                    ->pause(1000)
                    
                    // Проверяем, что модель изменилась
                    ->assertSelected('select[aria-label="Sélectionner un modèle IA"]', 'openai/gpt-4o');
        });
    }

    /**
     * Тест множественной отправки сообщений
     */
    public function testMultipleMessagesStreaming()
    {
        $user = User::factory()->create();
        $conversation = Conversation::factory()->create(['user_id' => $user->id]);

        $this->browse(function (Browser $browser) use ($user, $conversation) {
            $browser->loginAs($user)
                    ->visit("/chat/{$conversation->id}")
                    ->waitFor('#chat-message', 5);

            // Первое сообщение
            $browser->type('#chat-message', 'Première question')
                    ->press('button[aria-label="Envoyer le message"]')
                    ->waitForText('Première question', 5)
                    ->waitForText('💭 Votre assistant', 10)
                    ->waitUntilMissing('.typing', 15);

            // Второе сообщение
            $browser->type('#chat-message', 'Deuxième question')
                    ->press('button[aria-label="Envoyer le message"]')
                    ->waitForText('Deuxième question', 5)
                    ->pause(2000)
                    ->waitUntilMissing('.typing', 15);

            // Проверяем, что оба сообщения на странице
            $browser->assertSee('Première question')
                    ->assertSee('Deuxième question');
        });
    }

    /**
     * Тест отключения кнопки отправки во время стриминга
     */
    public function testSubmitButtonDisabledDuringStreaming()
    {
        $user = User::factory()->create();
        $conversation = Conversation::factory()->create(['user_id' => $user->id]);

        $this->browse(function (Browser $browser) use ($user, $conversation) {
            $browser->loginAs($user)
                    ->visit("/chat/{$conversation->id}")
                    ->waitFor('#chat-message', 5)
                    ->type('#chat-message', 'Test message')
                    ->press('button[aria-label="Envoyer le message"]')
                    
                    // Проверяем, что кнопка отключена сразу после отправки
                    ->assertDisabled('button[aria-label="Envoyer le message"]')
                    
                    // Ждем завершения стриминга
                    ->waitUntilMissing('.typing', 15)
                    
                    // Проверяем, что кнопка снова активна (поле пустое)
                    ->assertDisabled('button[aria-label="Envoyer le message"]');
        });
    }

    /**
     * Тест автопрокрутки при стриминге
     */
    public function testAutoScrollDuringStreaming()
    {
        $user = User::factory()->create();
        $conversation = Conversation::factory()->create(['user_id' => $user->id]);

        $this->browse(function (Browser $browser) use ($user, $conversation) {
            $browser->loginAs($user)
                    ->visit("/chat/{$conversation->id}")
                    ->waitFor('#chat-message', 5)
                    ->type('#chat-message', 'Message qui génère une longue réponse')
                    ->press('button[aria-label="Envoyer le message"]')
                    ->waitForText('💭 Votre assistant', 10)
                    
                    // Проверяем, что контейнер прокручен вниз
                    ->pause(2000)
                    ->script('
                        const container = document.querySelector(".messages");
                        return container.scrollTop + container.clientHeight >= container.scrollHeight - 50;
                    ');
        });
    }

    /**
     * Тест отправки Enter
     */
    public function testSubmitWithEnterKey()
    {
        $user = User::factory()->create();
        $conversation = Conversation::factory()->create(['user_id' => $user->id]);

        $this->browse(function (Browser $browser) use ($user, $conversation) {
            $browser->loginAs($user)
                    ->visit("/chat/{$conversation->id}")
                    ->waitFor('#chat-message', 5)
                    ->type('#chat-message', 'Test avec Enter')
                    ->keys('#chat-message', '{enter}')
                    ->waitForText('Test avec Enter', 5)
                    ->waitForText('💭 Votre assistant', 10);
        });
    }

    /**
     * Тест пустого сообщения (кнопка должна быть отключена)
     */
    public function testEmptyMessageCannotBeSent()
    {
        $user = User::factory()->create();
        $conversation = Conversation::factory()->create(['user_id' => $user->id]);

        $this->browse(function (Browser $browser) use ($user, $conversation) {
            $browser->loginAs($user)
                    ->visit("/chat/{$conversation->id}")
                    ->waitFor('#chat-message', 5)
                    
                    // Кнопка должна быть отключена при пустом поле
                    ->assertDisabled('button[aria-label="Envoyer le message"]')
                    
                    // Вводим пробелы
                    ->type('#chat-message', '   ')
                    ->assertDisabled('button[aria-label="Envoyer le message"]')
                    
                    // Вводим текст
                    ->type('#chat-message', 'Hello')
                    ->assertEnabled('button[aria-label="Envoyer le message"]');
        });
    }
}