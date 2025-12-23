<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PersonalizationTest extends DuskTestCase
{
    public function testUserCanSwitchBetweenPersonalizationTabs()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/personnalisation')
                ->waitForText('Personnalisation', 5)

                // По умолчанию открыт "À propos de vous"
                ->assertSee('À propos de vous')
                ->assertSee('Qui êtes-vous ?')

                // Переключаемся на "Comportement"
                ->click('button[aria-controls="panel-behaviour"]')
                ->pause(300)
                ->assertSee("Comportement de l'assistant")
                ->assertSee('Ton préféré')

                // Переключаемся на "Commandes"
                ->click('button[aria-controls="panel-commands"]')
                ->pause(300)
                ->assertSee('Commandes personnalisées')
                ->assertSee('Commandes commençant par /');
        });
    }

public function testUserCanSaveTextForEachTab()
{
    $user = User::factory()->create();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/personnalisation')
            ->waitFor('#user-response', 5)

            // TAB: about
            ->type('#user-response', 'Je suis étudiante')
            ->press('button[aria-label="Enregistrer votre réponse"]')
            ->pause(500)

            // TAB: behaviour
            ->click('button[aria-controls="panel-behaviour"]')
            ->pause(300)
            ->type('#user-response', 'Sois bienveillant')
            ->press('button[aria-label="Enregistrer votre réponse"]')
            ->pause(500)

            // Возвращаемся в about
            ->click('button[aria-controls="panel-about"]')
            ->pause(300)
            ->assertInputValue('#user-response', 'Je suis étudiante');
    });
}

public function testSaveButtonIsVisibleAndClickable()
{
    $user = User::factory()->create();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/personnalisation')
            ->waitFor('button[aria-label="Enregistrer votre réponse"]', 5)
            ->assertVisible('button[aria-label="Enregistrer votre réponse"]')
            ->assertEnabled('button[aria-label="Enregistrer votre réponse"]');
    });
}
}