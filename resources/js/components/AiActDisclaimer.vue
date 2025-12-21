<template>
  <div v-if="!accepted" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg max-w-md text-center">
      <h2 class="text-xl font-bold mb-4">⚠️ Attention</h2>
      <p class="mb-4">
        Vous interagissez avec un système d'intelligence artificielle. Les réponses peuvent comporter des erreurs et ne remplacent pas un professionnel.
      </p>
      <button @click="accept" class="bg-destructive text-white px-4 py-2 rounded hover:bg-accent-dark">
        J'ai compris
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const accepted = ref(localStorage.getItem('ai_act_accepted') === 'true')

const accept = () => {
  localStorage.setItem('ai_act_accepted', 'true')
  accepted.value = true
}
</script>
