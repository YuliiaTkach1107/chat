<template>
  <div 
    v-if="!accepted" 
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
    role="alertdialog"
    aria-modal="true"
    aria-labelledby="ai-warning-title"
    aria-describedby="ai-warning-desc">
    <div class="bg-card border border-border p-6 rounded-lg max-w-md text-center">
      <h2 id="ai-warning-title" class="text-xl font-bold mb-4 text-foreground">⚠️ Attention</h2>

      <p id="ai-warning-desc" class="mb-4 text-muted-foreground">
        Vous interagissez avec un système d'intelligence artificielle. Les réponses peuvent comporter des erreurs et ne remplacent pas un professionnel.
      </p>

      <button
        @click="accept"
        class="bg-destructive text-destructive-foreground px-4 py-2 rounded hover:bg-destructive/80 transition"
        aria-label="Confirmer que vous avez compris l'avertissement"
      >
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
