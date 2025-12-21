<template>
  <main class="max-w-4xl mx-auto p-6 space-y-6 h-screen" 
        aria-labelledby="terms-title">

    <h1 id="terms-title" class="text-3xl font-bold mb-4">Conditions d'utilisation</h1>

    <section aria-labelledby="intro-title">
      <h2 id="intro-title" class="sr-only">Introduction</h2>
      <p>
      Bienvenue sur PsyBot. En utilisant notre service, vous acceptez les présentes conditions d'utilisation.
      Merci de lire attentivement ces conditions avant d'utiliser l'application.
      </p>
    </section>

    <section aria-labelledby="use-title">
      <h2 id="use-title" class="text-2xl font-semibold mt-6">1. Utilisation du service</h2>
    <p>
      L'utilisateur s'engage à utiliser le service de manière responsable et conformément aux lois applicables.
      PsyBot fournit un assistant IA à but éducatif et psychologique, mais ne remplace pas un professionnel.
    </p>
    </section>

    <section aria-labelledby="liability-title">
      <h2 id="liability-title" class="text-2xl font-semibold mt-6">2. Limitation de responsabilité</h2>
    <p>
      Les informations fournies par PsyBot sont à titre informatif uniquement. PsyBot ne peut être tenu responsable
      des décisions ou actions prises par l'utilisateur sur la base des réponses de l'assistant.
    </p>
    </section>

    <section aria-labelledby="ip-title">
      <h2 id="ip-title" class="text-2xl font-semibold mt-6">3. Propriété intellectuelle</h2>
    <p>
      Tout contenu généré par PsyBot reste la propriété de PsyBot, sauf indication contraire.
      L'utilisateur ne peut pas reproduire, distribuer ou exploiter commercialement le contenu sans autorisation.
    </p>
    </section>
  

    <section aria-labelledby="changes-title">
      <h2 id="changes-title" class="text-2xl font-semibold mt-6">4. Modifications des conditions</h2>
    <p>
      PsyBot se réserve le droit de modifier ces conditions à tout moment. Les utilisateurs seront informés
      des changements via l'application ou par email si nécessaire.
    </p>
    </section>

    <section aria-labelledby="contact-title">
      <h2 id="contact-title" class="text-2xl font-semibold mt-6">5. Contact</h2>
    <p>
      Pour toute question concernant ces conditions d'utilisation, veuillez contacter :
      <a href="mailto:support@psybot.example" 
         class="underline text-blue-600"  
         aria-label="Envoyer un email au support PsyBot">
         support@psybot.example
      </a>
    </p>
    </section>
  </main>
</template>

<script setup>
import { useHead } from '@vueuse/head'

useHead({
  title: "Conditions d'utilisation – PsyBot",
  meta: [
    {
      name: 'description',
      content:
        "Consultez les conditions d'utilisation de PsyBot : règles d’usage, responsabilités, propriété intellectuelle et informations légales."
    },
    { property: 'og:title', content: "Conditions d'utilisation – PsyBot" },
    {
      property: 'og:description',
      content:
        "Conditions d'utilisation de PsyBot concernant l’accès au service, la responsabilité et la propriété intellectuelle."
    },
    { property: 'og:type', content: 'website' },
    { property: 'og:url', content: window.location.href },
    { name: 'robots', content: 'index, follow' }
  ]
})
</script>

<style scoped>
h1, h2 {
  color: #1f2937; /* gris foncé */
}
a:hover {
  text-decoration: underline;
}
</style>
