<template>
  <nav class="bg-gray-100 p-4 rounded space-y-2">
    <ul class="space-y-1">
      <li>
        <button @click="$emit('select-section','profile')" 
                class="w-full text-left px-3 py-2 hover:bg-gray-200 rounded">
          À propos de vous
        </button>
      </li>
      <li>
        <button @click="$emit('select-section','assistant')" 
                class="w-full text-left px-3 py-2 hover:bg-gray-200 rounded">
          Comportement de l'assistant
        </button>
      </li>
      <li>
        <button @click="$emit('select-section','commands')" 
                class="w-full text-left px-3 py-2 hover:bg-gray-200 rounded">
          Commandes personnalisées
        </button>
      </li>
    </ul>
  </nav>
</template>

<script setup>
defineEmits(['select-section'])
</script>
