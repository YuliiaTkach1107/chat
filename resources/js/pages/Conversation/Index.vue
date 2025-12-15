<template>
  <div class="flex max-w-6xl mx-auto h-screen parts">
    <!-- Список бесед слева -->
    <div class="border-r overflow-y-auto nav-bar">
      <ConversationsList :conversations="conversations" />
    </div>

    <!-- Правая часть: приветственный экран -->
    <div class="flex-1 flex flex-col justify-center items-center text-gray-400">
      <h1 class="text-3xl font-bold mb-4">Bienvenue dans votre chat</h1>
      <p>Sélectionnez une conversation à gauche ou créez-en une nouvelle pour commencer.</p>
    </div>
  </div>
</template>

<script setup>
import ConversationsList from './ConversationsList.vue'

const props = defineProps({
  conversations: {
    type: Array,
    default: () => []
  }
})
</script>

<style scoped>
/* Чтобы правая часть занимала всю высоту */
html, body, #app {
  height: 100%;
}
.parts{
  display:grid;
  grid-template-columns: 30% 70%;
}
.nav-bar{
  background-color:rgb(193, 221, 246);
  height:100%;
}
</style>
