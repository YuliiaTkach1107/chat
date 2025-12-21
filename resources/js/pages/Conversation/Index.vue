<template>
 <ConversationLayout 
  :conversations="conversations">
  <div class="flex max-w-6xl mx-auto h-screen">
    <!-- Partie droite -->
    <div class="flex-1 overflow-y-auto" >
      <template v-if="activeConversation">
        <!-- Affiche Show.vue si une conversation est sélectionnée -->
        <Show
          :conversation="activeConversation"
          :messages="activeConversation.messages"
          :models="models"
          :selectedModel="selectedModel"
        />
      </template>
      <template v-else>
        <!-- Écran d'accueil si aucune conversation n'est sélectionnée -->
  <div class="flex flex-col justify-center items-center h-screen px-4 overflow-y-auto text-center space-y-6 pb-10 pt-140 lg:pt-70">
    <!-- Emoji et message de bienvenue -->
    <div class="text-6xl sm:text-7xl md:text-8xl mb-4 pt-6">🫂</div>
    <h2 class="text-2xl sm:text-3xl md:text-4xl font-semibold text-primary mb-2">
      Heureux de vous voir ici
    </h2>
    <p class="text-sm sm:text-base md:text-lg opacity-70 max-w-md sm:max-w-lg md:max-w-xl leading-relaxed mx-auto mb-8">
      Parfois, nous avons tous besoin de parler à quelqu'un. Je suis ici pour vous écouter, 
      sans précipitation ni jugement. Partagez ce que vous ressentez.
    </p>

    <!-- Fonctionnalités -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10 w-full max-w-4xl">
      <div
        v-for="(feature, index) in features"
        :key="index"
        class="bg-card border border-border rounded-2xl p-4 sm:p-5 shadow-sm hover:shadow-md transition-shadow flex flex-col items-center gap-2"
      >
        <div class="text-3xl sm:text-4xl mb-1">{{ feature.emoji }}</div>
        <div class="font-medium text-base sm:text-lg">{{ feature.title }}</div>
        <div class="text-sm sm:text-base opacity-60">{{ feature.description }}</div>
      </div>
    </div>

    <!-- Astuce -->
    <div class="bg-gradient-to-r from-accent/60 to-accent/40 border border-primary/20 rounded-2xl p-4 sm:p-5 max-w-xl mx-auto">
      <p class="text-sm sm:text-base opacity-80">
        <span class="text-xl mr-2">💭</span>
        Il n'y a pas de bonnes ou mauvaises réponses. Dites simplement ce que vous ressentez
      </p>
    </div>
  </div>
      </template>
    </div>
    </div>  
     <AiActDisclaimer />
 </ConversationLayout>
</template>

<script setup>
import ConversationLayout from './layouts/ConversationLayout.vue'
import { useForm } from '@inertiajs/vue3'
import Show from './Show.vue'
import AiActDisclaimer from '@/Components/AiActDisclaimer.vue'

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


const features = [
  { emoji: '💗', title: 'Avec chaleur', description: 'Compréhension et attention' },
  { emoji: '🤗', title: 'En sécurité', description: 'C’est votre espace' },
  { emoji: '🌟', title: 'Toujours là', description: 'Quand vous en avez besoin' },
  { emoji: '✨', title: 'Sans jugement', description: 'Soyez vous-même' },
];

const form = useForm({
  message: ''
})

const submit = () => {
  if (!form.message.trim()) return

  form.post(route('conversation.store'))
}
</script>

<style scoped>
/* Pour que la partie droite occupe toute la hauteur */
html, body, #app {
  height: 100%;
}
</style>
