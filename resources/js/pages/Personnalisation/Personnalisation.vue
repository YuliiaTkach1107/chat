<script setup>
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { route } from 'ziggy-js'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  preferences: Object
})

const activeTab = ref('about')

const form = ref({
  about: props.preferences?.about ?? '',
  behaviour: props.preferences?.behaviour ?? '',
  commands: props.preferences?.commands ?? ''
})

const tabs = [
  { id: 'about', label: 'À propos de vous', emoji: '👤' },
  { id: 'behaviour', label: "Comportement de l'assistant", emoji: '🤗' },
  { id: 'commands', label: 'Commandes personnalisées', emoji: '⚡' }
]

const tabData = {
  about: {
    title: 'À propos de vous',
    questions: [
      'Qui êtes-vous ?',
      'Quels sont vos principaux défis ou préoccupations ?',
      'Que souhaitez-vous obtenir de l’assistant ?'
    ],
    example: 'Exemple : "Je suis étudiante stressée par les examens, je cherche des conseils pour gérer l’anxiété et améliorer mon bien-être mental."'
  },
  behaviour: {
    title: "Comportement de l'assistant",
    questions: [
      'Ton préféré',
      'Niveau de détail',
      'Style de réponses'
    ],
    example: 'Exemple : "Répond de manière bienveillante, encourageante, avec des conseils pratiques et des emojis apaisants 🌿💛."'
  },
  commands: {
    title: 'Commandes personnalisées',
    questions: [
      'Commandes commençant par /',
      'Action attendue'
    ],
    example: 'Exemple : "/respire → guide-moi dans un exercice de respiration pour réduire le stress."'
  }
}

function saveTab(tab) {
  Inertia.post(route('personnalisation.update'), {
    tab,
    value: form.value[tab]
  })
}
</script>

<template>
  <div class="max-w-6xl mx-auto p-6">

    <!-- Back link -->
    <div class="mb-6">
      <Link :href="route('conversation.index')" class="font-semibold text-primary">
          ← Conversations
        </Link>
    </div>
    <!-- Header -->
    <div class="mb-8">
      <div class="inline-flex items-center gap-2 bg-primary/10 border border-primary/20 rounded-full px-4 py-2 mb-4">
        <span class="opacity-80">Paramètres</span>
      </div>
      <h2 class="mb-2 text-2xl font-semibold">Personnalisation</h2>
      <p class="opacity-70 leading-relaxed">
        Racontez à l’assistant qui vous êtes pour qu’il puisse mieux vous aider et fournir des conseils adaptés.
      </p>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">

      <!-- Sidebar Tabs -->
      <div class="w-full lg:w-1/4 flex flex-col gap-3">
        <button
          v-for="(tab, index) in tabs"
          :key="tab.id"
          @click="activeTab = tab.id"
          class="group relative px-5 py-4 rounded-2xl text-left transition-all overflow-hidden flex items-center gap-3 hover:cursor-pointer"
          :class="activeTab === tab.id
            ? 'text-white shadow-lg  bg-primary'
            : 'bg-primary/2 hover:bg-primary/8 border border-primary/20'"
        >
          <div class="text-2xl flex-shrink-0">
            {{ tab.emoji }}
          </div>
          <div class="flex-1 font-medium" :class="activeTab !== tab.id ? 'opacity-80' : ''">
            {{ tab.label }}
          </div>
          <div v-if="activeTab === tab.id" class="absolute right-4">
            <div class="w-2 h-2 rounded-full bg-white"></div>
          </div>
        </button>
      </div>

      <!-- Tab Content -->
      <div class="flex-1 space-y-6">

        <!-- Questions Panel -->
        <div class="bg-primary/20 border border-primary/20 border rounded-2xl p-5 shadow-sm">
          <h3 class="mb-3 font-semibold">{{ tabData[activeTab].title }}</h3>
          <ul class="space-y-2">
            <li v-for="(q, idx) in tabData[activeTab].questions" :key="idx" class="flex items-start gap-2 opacity-80">
              <span class="text-yellow-500 mt-1">•</span>
              <span>{{ q }}</span>
            </li>
          </ul>
        </div>

        <!-- Textarea -->
        <div>
          <label class="block mb-2 opacity-70 ">Votre réponse</label>
          <textarea
            v-model="form[activeTab]"
            placeholder="Écrivez ici..."
            class="w-full h-48 p-4 bg-primary/2 border border-primary/20 rounded-2xl resize-none
                   focus:outline-none focus:ring-2 focus:ring-orange-200 transition-all leading-relaxed"
          />
        </div>

        <!-- Example -->
        <div class="bg-primary/2 border border-primary/20 rounded-2xl p-5">
          <div class="flex items-center gap-2 mb-2 opacity-70">
            <span class="text-xl">💡</span>
            <span class="font-medium">Exemple</span>
          </div>
          <p class="opacity-70 leading-relaxed italic">{{ tabData[activeTab].example }}</p>
        </div>

        <!-- Save Button -->
        <button
          @click="saveTab(activeTab)"
          class="w-full sm:w-auto px-8 py-4 bg-primary
                 text-white rounded-full shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2 cursor-pointer"
        >
          Enregistrer
        </button>

      </div>
    </div>
  </div>
  
</template>

<style scoped>
/* Слегка смягчаем тени и градиенты для Figma-подобного стиля */
</style>
