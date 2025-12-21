<template>
  <main class="max-w-3xl mx-auto p-6 h-screen" 
        aria-labelledby="legal-title">

   <h1 id="legal-title" class="text-2xl font-bold mb-6"> Mentions légales </h1>
    <!-- Éditeur -->
    <section aria-labelledby="editor-title">
      <h2 id="editor-title" class="text-lg font-semibold mb-1">Éditeur</h2>
      <p>{{ editor.name }}</p>
    </section>

    <!-- Hébergeur -->
    <section aria-labelledby="host-title">
      <h2 id="host-title" class="text-lg font-semibold mb-1">Hébergeur</h2>
      <p>{{ editor.host }}</p>
    </section>

    <!-- Directeur -->
    <section aria-labelledby="director-title">
      <h2 id="director-title" class="text-lg font-semibold mb-1">Directeur de publication</h2>
      <p>{{ editor.publicationDirector }}</p>
    </section>

    <!-- Contact -->
    <section aria-labelledby="contact-title">
      <h2 id="contact-title" class="text-lg font-semibold mb-1">Contact</h2>
      <p>
        <a 
          :href="'mailto:' + editor.contact"
          class="text-primary underline hover:text-primary/80 focus:outline-none focus:ring-4 focus:ring-primary/40"
          aria-label="Envoyer un email à l'adresse de contact"
        >
          {{ editor.contact }}
        </a>
      </p>
    </section>
  </main>
</template>

<script setup>
import { useHead } from '@vueuse/head'
const props = defineProps({
    editor: Object
})
useHead({
  title: 'Mentions légales – PsyBot',
  meta: [
    {
      name: 'description',
      content:
        'Consultez les mentions légales de PsyBot : informations sur l’éditeur, l’hébergeur et les responsables du site.'
    },
    { property: 'og:title', content: 'Mentions légales – PsyBot' },
    {
      property: 'og:description',
      content:
        'Informations légales concernant PsyBot, son éditeur, son hébergeur et les responsabilités éditoriales.'
    },
    { property: 'og:type', content: 'website' },
    { property: 'og:url', content: window.location.href },
    { name: 'robots', content: 'index, follow' }
  ]
})
</script>
