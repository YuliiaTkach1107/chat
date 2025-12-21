<template>
  <main class="max-w-4xl mx-auto p-6 h-screen space-y-4"  aria-labelledby="ai-act-title">

    <h1 id="ai-act-title" class="text-2xl font-bold mb-4">AI Act Transparency 
      <span role="img" aria-label="oeil">
        👁️
      </span>
    </h1>
    
    <section aria-labelledby="disclaimer-title">
      <h2 id="disclaimer-title" class="text-lg font-semibold mb-2">Disclaimer</h2>
      <p>
        Vous interagissez avec un système d'intelligence artificielle. Les réponses peuvent comporter des erreurs ou hallucinations.
        Ce système ne remplace pas un professionnel qualifié.
      </p>
    </section>

    <section aria-labelledby="models-title">
      <h2 id="models-title"  class="text-lg font-semibold mb-2">Utilisation des modèles d'IA</h2>
      <p>
        Le système utilise différents modèles d'intelligence artificielle pour générer les réponses.
        L'utilisateur peut sélectionner le modèle souhaité lors de l'utilisation du chat. 
        Les modèles peuvent évoluer au fil du temps pour améliorer la qualité du service.
      </p>
    </section>

    <section aria-labelledby="conversations-title">
      <h2 id="conversations-title" class="text-lg font-semibold mb-2">Utilisation des conversations pour améliorer le service</h2>
      <p>
        Les conversations avec le système peuvent être anonymisées et utilisées pour améliorer les modèles d'IA
        et la qualité du service. Aucune donnée personnelle n'est utilisée à des fins commerciales sans consentement explicite.
      </p>
    </section>

    <section aria-labelledby="data-title">
      <h2 id="data-title" class="text-lg font-semibold mb-2">Gestion des données</h2>
      <p>
        Vous avez le droit de refuser l'utilisation de certaines données et de gérer vos choix via la politique de confidentialité.
      </p>
    </section>

  </main>
</template>

<script setup>
import { useHead } from '@vueuse/head'

useHead({
  title: 'AI Act – Transparence & Conformité | PsyBot',
  meta: [
    {
      name: 'description',
      content:
        "Page de transparence AI Act de PsyBot : informations sur l'utilisation de l'intelligence artificielle, les modèles utilisés, les limites du système et la gestion des données."
    },
    {
      property: 'og:title',
      content: 'AI Act – Transparence & Conformité | PsyBot'
    },
    {
      property: 'og:description',
      content:
        "Découvrez comment PsyBot respecte l’AI Act européen : transparence, disclaimer IA, usage des modèles et protection des données."
    },
    { property: 'og:type', content: 'website' },
    { property: 'og:url', content: window.location.href },
    { name: 'robots', content: 'index, follow' }
  ]
})
</script>