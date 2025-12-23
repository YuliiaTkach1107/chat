<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Conversation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ConversationSecurityTest extends DuskTestCase
{
    public function testUserCannotAccessAnotherUsersConversation()
    {
        // 👤 User A — владелец беседы
        $userA = User::factory()->create();
        $conversation = Conversation::factory()->create([
            'user_id' => $userA->id,
        ]);

        // 👤 User B — посторонний пользователь
        $userB = User::factory()->create();

        $this->browse(function (Browser $browser) use ($userB, $conversation) {
            $browser->loginAs($userB)
                    ->visit("/chat/{$conversation->id}")
                    ->pause(1000)
                    ->assertSee('403')

                    // Вариант 1: редирект (самый частый случай)
                    ->assertDontSee('Zone de conversation');

            // Дополнительно (по желанию):
            // ->assertPathIs('/chat');
        });
    }
}
