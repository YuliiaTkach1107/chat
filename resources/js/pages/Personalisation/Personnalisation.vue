<script setup>
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { route } from 'ziggy-js'

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
  { id: 'about', label: 'À propos de vous' },
  { id: 'behaviour', label: "Comportement de l'assistant" },
  { id: 'commands', label: 'Commandes personnalisées' }
]

const tabData = {
  about: {
    title: "À propos de vous",
    questions: [
      "Qui êtes-vous ?",
      "Votre domaine d'expertise"
    ],
    example:
      `Exemple : "Je suis développeuse, j’utilise l’IA quotidiennement et je veux des réponses directes, sans détours."`
  },
  behaviour: {
    title: "Comportement de l'assistant",
    questions: [
      "Ton préféré",
      "Niveau de détail",
      "Style de réponses"
    ],
    example:
      `Exemple : "Utilise un ton brutal, direct, avec des mots crus et beaucoup d’emojis 😈🔥. Pas de politesses inutiles."`
  },
  commands: {
    title: "Commandes personnalisées",
    questions: [
      "Commandes commençant par /",
      "Action attendue"
    ],
    example:
      `Exemple : "/hello → répond uniquement : HELLO?? HELLO HELLO 😡😡"`
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
  <div class="flex max-w-6xl mx-auto p-6 gap-6">

    <!-- Tabs -->
    <div class="w-1/4 flex flex-col gap-2">
      <button
        v-for="t in tabs"
        :key="t.id"
        @click="activeTab = t.id"
        :class="activeTab === t.id ? 'bg-blue-500 text-white' : 'bg-gray-200'"
        class="px-3 py-2 rounded text-left"
      >
        {{ t.label }}
      </button>
    </div>

    <!-- Content -->
    <div class="flex-1 space-y-4">
      <h2 class="text-xl font-semibold">
        {{ tabData[activeTab].title }}
      </h2>

      <ul class="list-disc ml-5 text-gray-700">
        <li v-for="q in tabData[activeTab].questions" :key="q">
          {{ q }}
        </li>
      </ul>

      <textarea
        v-model="form[activeTab]"
        class="w-full h-48 p-3 border rounded resize-none"
      />

      <div class="p-3 bg-gray-50 border rounded text-gray-600">
        {{ tabData[activeTab].example }}
      </div>

      <button
        @click="saveTab(activeTab)"
        class="px-4 py-2 bg-green-500 text-white rounded"
      >
        Enregistrer
      </button>
    </div>
  </div>
</template>
