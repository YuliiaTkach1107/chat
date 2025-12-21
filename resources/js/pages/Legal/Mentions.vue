<template>
  <div class="max-w-3xl mx-auto p-6 h-screen">
    <h1 class="text-2xl font-bold mb-4">Mentions Légales</h1>
    <p><strong>Éditeur :</strong> {{ editor.name }}</p>
    <p><strong>Hébergeur :</strong> {{ editor.host }}</p>
    <p><strong>Directeur de publication :</strong> {{ editor.publicationDirector }}</p>
    <p><strong>Contact :</strong> <a :href="'mailto:' + editor.contact">{{ editor.contact }}</a></p>
  </div>
</template>

<script setup>
const props = defineProps({
    editor: Object
})
</script>
