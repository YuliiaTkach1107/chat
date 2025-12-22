<template>
 <ConversationLayout 
  :conversations="conversations">

  <main class="flex max-w-6xl mx-auto h-screen"
        aria-labelledby="conversation-main-title">

    <h1 id="conversation-main-title" class="sr-only">
        Zone de conversation
    </h1>

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
         <section class="flex flex-col justify-center items-center h-screen px-4 overflow-y-auto text-center space-y-6 pb-10 pt-160 lg:pt-70 md:pt-70"
                  aria-labelledby="welcome-title">
    <!-- Emoji et message de bienvenue -->
          <div class="text-6xl sm:text-7xl md:text-8xl mb-4 pt-6" 
              role="img"
              aria-label="Deux personnes se prenant dans les bras">
              🫂
          </div>

          <h2 id="welcome-title" 
              class="text-2xl sm:text-3xl md:text-4xl font-semibold text-primary mb-2">
            Heureux de vous voir ici
          </h2>
          <p class="text-sm sm:text-base md:text-lg opacity-70 max-w-md sm:max-w-lg md:max-w-xl leading-relaxed mx-auto mb-8">
            Parfois, nous avons tous besoin de parler à quelqu'un. Je suis ici pour vous écouter, 
            sans précipitation ni jugement. Partagez ce que vous ressentez.
          </p>

    <!-- Fonctionnalités -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10 w-full max-w-4xl"
         aria-label="Fonctionnalités principales">
      <article
        v-for="(feature, index) in features"
        :key="index"
        tabindex="0"
        class="bg-card border border-border rounded-2xl p-4 sm:p-5 shadow-sm hover:shadow-md transition-shadow flex flex-col items-center gap-2"
        :aria-label="feature.title"
      >
        <div class="text-3xl sm:text-4xl mb-1" 
             role="img"
             :aria-label="feature.title">
             {{ feature.emoji }}
        </div>
        <div class="font-medium text-base sm:text-lg">{{ feature.title }}</div>
        <div class="text-sm sm:text-base opacity-60">{{ feature.description }}</div>
      </article>
    </div>

    <!-- Astuce -->
    <div class="bg-gradient-to-r from-accent/60 to-accent/40 border border-primary/20 rounded-2xl p-4 sm:p-5 max-w-xl mx-auto"
         aria-label="Astuce de conversation">
      <p class="text-sm sm:text-base opacity-80">
        <span class="text-xl mr-2" role="img" aria-label="bulle de pensée">💭</span>
        Il n'y a pas de bonnes ou mauvaises réponses. Dites simplement ce que vous ressentez
      </p>
    </div>
  </section>
      </template>
    </div>
    <ThemeToggle class="theme-toggle-fixed"  />
    </main>  
     <AiActDisclaimer />
 </ConversationLayout>
</template>

<script setup>
import ConversationLayout from './layouts/ConversationLayout.vue'
import { useForm } from '@inertiajs/vue3'
import Show from './Show.vue'
import AiActDisclaimer from '@/Components/AiActDisclaimer.vue'
import { useHead } from '@vueuse/head'
import ThemeToggle from '@/components/ThemeToggle.vue'


const props = defineProps({
  conversations: {
    type: Array,
    default: () => []
  },
  activeConversation: {
    type: Object,
    default: null
  },
  meta: Object
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

useHead({
  title: props.meta.title,
  meta: [
    { name: 'description', content: props.meta.description },
    { property: 'og:title', content: props.meta.title },
    { property: 'og:description', content: props.meta.description },
    { property: 'og:type', content: 'website' },
    { property: 'og:url', content: props.meta.url },
    { name: 'twitter:card', content: 'summary_large_image' }
  ]
})
</script>

<style scoped>
/* Pour que la partie droite occupe toute la hauteur */
html, body, #app {
  height: 100%;
}

.theme-toggle-fixed {
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 50;
  background: var(--card);
  border: 1px solid var(--border);
  width: 48px;
  height: 48px;
  border-radius: 9999px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  transition: background 0.2s, transform 0.2s;
}

.theme-toggle-fixed:hover {
  background: var(--accent);
  transform: scale(1.05);
}

</style>
