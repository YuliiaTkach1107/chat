<template>
  <main class="max-w-3xl mx-auto p-6 space-y-4" aria-labelledby="privacy-title">
    <h1 id="privacy-title" class="text-2xl font-bold">Politique de Confidentialité</h1>

    <section aria-labelledby="types-title">
      <h2 id="types-title" class="font-semibold">Types de données collectées</h2>
      <ul class="list-disc list-inside">
        <li v-for="type in dataProcessing.types" :key="type">{{ type }}</li>
      </ul>
    </section>

    <section aria-labelledby="purpose-title">
      <h2 id="purpose-title" class="font-semibold">Finalités du traitement</h2>
      <p>{{ dataProcessing.purpose }}</p>
    </section>

    <section aria-labelledby="legal-title">
      <h2 id="legal-title" class="font-semibold">Base légale</h2>
      <p>{{ dataProcessing.legalBasis }}</p>
    </section>

    <section aria-labelledby="retention-title">
      <h2 id="retention-title" class="font-semibold">Durée de conservation</h2>
      <p>{{ dataProcessing.retention }}</p>
    </section>

    <section aria-labelledby="rights-title">
      <h2 id="rights-title"  class="font-semibold">Droits des utilisateurs</h2>
      <ul class="list-disc list-inside">
        <li v-for="right in dataProcessing.userRights" :key="right">{{ right }}</li>
      </ul>
    </section>

    <section aria-labelledby="transfer-title">
      <h2 id="transfer-title" class="font-semibold">Transferts hors UE</h2>
      <p>{{ dataProcessing.transfers }}</p>
    </section>

    <section aria-labelledby="ai-title">
      <h2 id="ai-title" class="font-semibold">Conformité AI Act</h2>
      <ul class="list-disc list-inside">
        <li>{{ dataProcessing.aiTransparency }}</li>
        <li>{{ dataProcessing.disclaimer }}</li>
        <li>Modèles utilisés : {{ dataProcessing.modelsUsed.join(', ') }}</li>
        <li>{{ dataProcessing.conversationUsage }}</li>
      </ul>
    </section>
  </main>
</template>

<script setup>
import { useHead } from '@vueuse/head'
const props = defineProps({
    dataProcessing: Object
})
// SEO
useHead({
  title: 'Politique de Confidentialité – PsyBot',
  meta: [
    {
      name: 'description',
      content: 'Découvrez comment PsyBot collecte, traite et protège vos données personnelles conformément au RGPD et à l’AI Act.'
    },
    { property: 'og:title', content: 'Politique de Confidentialité – PsyBot' },
    { property: 'og:description', content: 'Découvrez comment PsyBot collecte, traite et protège vos données personnelles conformément au RGPD et à l’AI Act.' },
    { property: 'og:type', content: 'website' },
    { property: 'og:url', content: window.location.href },
    { name: 'twitter:card', content: 'summary_large_image' }
  ]
})
</script>
