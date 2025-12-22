<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class LegalController extends Controller
{
    public function mentions()
    {
        return Inertia::render('Legal/Mentions', [
            'editor' => [
                'name' => 'PsyBot Inc.',
                'host' => 'OVH Cloud',
                'publicationDirector' => 'Julia Tkachenko',
                'contact' => 'contact@example.com',
            ],
        ]);
    }

    public function privacy()
    {
        return Inertia::render('Legal/Privacy', [
            'dataProcessing' => [
                'types' => ['Nom', 'Email', 'Messages utilisateurs'],
                'purpose' => 'Fournir un assistant psychologique via LLM',
                'legalBasis' => 'Consentement explicite',
                'retention' => '30 jours',
                'userRights' => ['Accès', 'Rectification', 'Suppression', 'Portabilité'],
                'transfers' => 'Pas de transfert hors UE',
                'aiTransparency' => 'L’utilisateur interagit avec une IA',
                'disclaimer' => 'Les réponses peuvent contenir des erreurs, ne remplacent pas un professionnel.',
                'modelsUsed' => ['GPT-5-mini', 'GPT-4o'],
                'conversationUsage' => 'Les conversations peuvent être utilisées pour améliorer le service',
            ],
        ]);
    }

    public function terms()
    {
        return Inertia::render('Legal/Terms');
    }
}
