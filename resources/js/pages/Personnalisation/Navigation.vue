<template>
  <nav class="bg-gray-100 p-4 rounded space-y-2" aria-label="Menu de personnalisation">
    <ul class="space-y-1" role="list">
      <li role="listitem">
        <button @click="$emit('select-section','profile')" 
                class="w-full text-left px-3 py-2 hover:bg-gray-200 rounded"
                aria-label="Section À propos de vous">
          À propos de vous
        </button>
      </li>
      <li role="listitem">
        <button @click="$emit('select-section','assistant')" 
                class="w-full text-left px-3 py-2 hover:bg-gray-200 rounded"
                aria-label="Section Comportement de l'assistant">
          Comportement de l'assistant
        </button>
      </li>
      <li role="listitem">
        <button @click="$emit('select-section','commands')" 
                class="w-full text-left px-3 py-2 hover:bg-gray-200 rounded"
                aria-label="Section Commandes personnalisées">
          Commandes personnalisées
        </button>
      </li>
    </ul>
  </nav>
</template>

<script setup>
defineEmits(['select-section'])
</script>
