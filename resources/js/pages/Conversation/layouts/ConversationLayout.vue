<template>
  <div class="flex flex-col">
    <!-- Навигация сверху -->
    <Sidebar/>

    <div class="flex flex-1 overflow-hidden h-screen ">
      <!-- Список бесед слева -->
      <div class="border-r overflow-y-auto lg:w-1/3 ">
        <ConversationsList :conversations="conversations" />
      </div>
     <!-- Правая часть -->
      <div class="flex-1 overflow-hidden h-screen">
        <slot />
      
      </div>
    </div>
  </div>
 
 
</template>

<script setup>
import { onMounted, onUnmounted } from 'vue'
import Sidebar from '../Navigation.vue'
import ConversationsList from '../ConversationsList.vue'
import ThemeToggle from '@/components/ThemeToggle.vue'

const props = defineProps({
  conversations: { type: Array, default: () => [] },
})


</script>

<style scoped>

</style>
