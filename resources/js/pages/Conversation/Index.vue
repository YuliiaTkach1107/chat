<template>
 <Sidebar/>
  <div class="flex max-w-6xl mx-auto h-screen parts">
    <!-- Список бесед слева -->
    <div class="border-r overflow-y-auto nav-bar">
      <ConversationsList :conversations="conversations" />
    </div>

    <!-- Правая часть -->
    <div class="flex-1 overflow-y-auto">
      <template v-if="activeConversation">
        <!-- Показываем Show.vue, если есть выбранная беседа -->
        <Show
          :conversation="activeConversation"
          :messages="activeConversation.messages"
          :models="models"
          :selectedModel="selectedModel"
        />
      </template>
      <template v-else>
        <!-- Заставка, если беседа не выбрана -->
        <div class="flex flex-col justify-center items-center h-full text-gray-400">
          <h1 class="text-3xl font-bold mb-4">Bienvenue dans votre chat</h1>
          <p>Sélectionnez une conversation à gauche ou créez-en une nouvelle pour commencer.</p>
        </div>
      </template>
    </div>
    </div>  
</template>

<script setup>
import ConversationsList from './ConversationsList.vue'
import Sidebar from './Navigation.vue'

const props = defineProps({
  conversations: {
    type: Array,
    default: () => []
  },
  activeConversation: {
    type: Object,
    default: null
  },
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
