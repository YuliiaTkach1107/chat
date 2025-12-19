<template>
  <div class="flex flex-col h-screen">
    <!-- Навигация сверху -->
    <Sidebar/>

    <div class="flex flex-1 overflow-hidden">
      <!-- Список бесед слева -->
      <div class="border-r overflow-y-auto w-1/3">
        <ConversationsList :conversations="conversations" />
      </div>

      <!-- Правая часть -->
      <div class="flex-1 overflow-y-auto">
        <slot /> <!-- Сюда будут рендериться Show.vue или заставка -->
      </div>
    </div>
  </div>
</template>

<script setup>
import Sidebar from '../Navigation.vue'
import ConversationsList from '../ConversationsList.vue'

const props = defineProps({
  conversations: { type: Array, default: () => [] },
})
</script>

<style scoped>
/* Полная высота */
html, body, #app {
  height: 100%;
}
</style>
