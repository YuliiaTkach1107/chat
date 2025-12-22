<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { Sun, Moon } from 'lucide-vue-next'

const isDark = ref(false)

onMounted(() => {
  isDark.value = document.documentElement.classList.contains('dark')
})

function toggleTheme() {
  isDark.value = !isDark.value
  document.documentElement.classList.toggle('dark', isDark.value)
  localStorage.setItem('theme', isDark.value ? 'dark' : 'light')
}
</script>

<template>
  <button
    @click="toggleTheme"
    class="p-2 rounded-full transition-colors"
    :aria-pressed="isDark"
    :aria-label="isDark ? 'Activer le mode clair' : 'Activer le mode sombre'"
    :title="isDark ? 'Mode clair' : 'Mode sombre'"
  >
    <!-- Светлая тема → показываем ЛУНУ -->
    <Moon v-if="!isDark" class="w-6 h-6 text-primary" />

    <!-- Тёмная тема → показываем СОЛНЦЕ -->
    <Sun v-else class="w-6 h-6 text-primary" />
  </button>
</template>
