<script setup>
import { ref } from 'vue'       
import { useForm } from '@inertiajs/vue3'
import MarkdownIt from 'markdown-it'
import hljs from 'highlight.js'
import 'highlight.js/styles/github-dark.css'
import { route } from 'ziggy-js'
import { ArrowUp } from 'lucide-vue-next'

const loading = ref(false)

const props = defineProps({
  models: Array,
  selectedModel: String,
  messages: Array,
  conversation: Object,
  error: String
})

const form = useForm({ message: '', selected_model: props.selectedModel ?? '',conversation_id: props.conversation.id,   })

const md = new MarkdownIt({
  highlight(str, lang) {
    if (lang && hljs.getLanguage(lang)) {
      try { return hljs.highlight(str, { language: lang }).value } catch {} 
    }
    return ''
  }
})

// Отправка сообщения
const localMessages = ref([...props.messages])

const submit = () => {
  //if (!props.conversation?.id || !form.message.trim()) return
  if (!props.conversation?.id || !(form.message || '').trim()) return
  loading.value = true

  form.post(route('messages.store', props.conversation.id), {
    preserveScroll: true,
    onSuccess: ({ props }) => {
      localMessages.value.push({ ...props.message })
      form.reset('message')
    },
    onFinish: () => {
      loading.value = false
    },
    onError: (err) => {
      console.log(err)
      loading.value = false
    }
  })
}


// Смена модели
const changeModel = () => {
  form.post(route('model.select'), {
    preserveState: true,
    preserveScroll: true,
    onSuccess: () => console.log('Le modéle a été mis à jour')

  })
}
</script>

<template>
<div class="max-w-3xl mx-auto p-6 space-y-4">

  <!-- Ошибки -->
  <div v-if="props.error" class="p-3 bg-red-200 text-red-800 rounded">
    {{ props.error }}
  </div>

  <!-- История сообщений -->
  <div class="space-y-4">
    <div
      v-for="msg in props.messages"
      :key="msg.id"
      class="p-3 rounded"
      :class="msg.role === 'user' ? 'bg-gray-200' : 'bg-gray-100'"
      v-html="md.render(msg.content)"
    ></div>
  </div>
<div v-if="loading" class="loader">
  <span></span>
  <span></span>
  <span></span>
</div>
  <hr>

    <form @submit.prevent="changeModel">
    <input type="hidden" v-model="form.selected_model" name="selected_model">
    <input type="hidden" :value="props.conversation.id" name="conversation_id">
  <!-- Select моделей -->
  <select v-model="form.selected_model" @change="changeModel" class='w-50 focus:outline-none mb-12'>
    <option v-for="m in props.models" :key="m.id" :value="m.id">
      {{ m.name }}
    </option>
  </select>
  </form>

  <!-- Textarea + кнопка отправки -->
  <div class="fixed bottom-4 left-0 right-0 px-4">
    <div class="max-w-3xl mx-auto">
      <div class="flex items-center bg-white border rounded-xl shadow-md overflow-hidden">
        <textarea
          v-model="form.message"
          placeholder="Pose ta question..."
          class="w-full border rounded p-3 resize-none"
        ></textarea>
        <button
            type="button"
            @click="submit"
            :disabled="form.processing || !form.message.trim()"
            class="text-white bg-black rounded disabled:bg-gray-400 cursor-pointer ml-2"
            >
            <ArrowUp class="26" />
        </button>

      </div>
    </div>
  </div>

</div>
</template>

<style scoped>
textarea{
  border:0;
  height: 50px;
  padding-bottom:20px;
}
button{
  display:flex;
  justify-content: center;
  align-items: center;
  border-radius:50px;
  width:45px;
  height:40px;
  margin-right:5px;
}
textarea:focus{
  border:none;
  outline: none;
}
.loader {
  display: flex;
  gap: 6px;
  padding-left: 10px;
}

.loader span {
  width: 8px;
  height: 8px;
  background: #555;
  border-radius: 50%;
  animation: pulse 0.8s infinite ease-in-out;
}

.loader span:nth-child(2) {
  animation-delay: 0.15s;
}

.loader span:nth-child(3) {
  animation-delay: 0.3s;
}

@keyframes pulse {
  0%, 80%, 100% { transform: scale(0.4); opacity: 0.5; }
  40% { transform: scale(1); opacity: 1; }
}

</style>
