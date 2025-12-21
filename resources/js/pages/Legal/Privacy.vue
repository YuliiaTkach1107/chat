<template>
  <div class="max-w-3xl mx-auto p-6 space-y-4 ">
    <h1 class="text-2xl font-bold">Politique de Confidentialité</h1>

    <section>
      <h2 class="font-semibold">Types de données collectées</h2>
      <ul class="list-disc list-inside">
        <li v-for="type in dataProcessing.types" :key="type">{{ type }}</li>
      </ul>
    </section>

    <section>
      <h2 class="font-semibold">Finalités du traitement</h2>
      <p>{{ dataProcessing.purpose }}</p>
    </section>

    <section>
      <h2 class="font-semibold">Base légale</h2>
      <p>{{ dataProcessing.legalBasis }}</p>
    </section>

    <section>
      <h2 class="font-semibold">Durée de conservation</h2>
      <p>{{ dataProcessing.retention }}</p>
    </section>

    <section>
      <h2 class="font-semibold">Droits des utilisateurs</h2>
      <ul class="list-disc list-inside">
        <li v-for="right in dataProcessing.userRights" :key="right">{{ right }}</li>
      </ul>
    </section>

    <section>
      <h2 class="font-semibold">Transferts hors UE</h2>
      <p>{{ dataProcessing.transfers }}</p>
    </section>

    <section>
      <h2 class="font-semibold">Conformité AI Act</h2>
      <ul class="list-disc list-inside">
        <li>{{ dataProcessing.aiTransparency }}</li>
        <li>{{ dataProcessing.disclaimer }}</li>
        <li>Modèles utilisés : {{ dataProcessing.modelsUsed.join(', ') }}</li>
        <li>{{ dataProcessing.conversationUsage }}</li>
      </ul>
    </section>
  </div>
</template>

<script setup>
const props = defineProps({
    dataProcessing: Object
})
</script>
