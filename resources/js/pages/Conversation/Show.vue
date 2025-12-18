<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import MarkdownIt from 'markdown-it'
import hljs from 'highlight.js'
import 'highlight.js/styles/github-dark.css'
import { route } from 'ziggy-js'
import { ArrowUp } from 'lucide-vue-next'
import ConversationsList from './ConversationsList.vue'
import Sidebar from './Navigation.vue'
import { useStream } from '@laravel/stream-vue'
import { router } from '@inertiajs/vue3'


const loading = ref(false)
const streamingAssistantMessage = ref(null)


const props = defineProps({
  models: Array,
  selectedModel: String,
  messages: Array,
  conversation: Object,
  error: String,
  conversations: {
    type: Array,
    default: () => []
  }
})

// Форма
const form = useForm({
  message: '',
  selected_model: props.selectedModel ?? '',
  conversation_id: props.conversation.id
})

const md = new MarkdownIt({
  html: false,
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
  if (!props.conversation?.id || !(form.message || '').trim()) return

  // 🔹 1. Сообщение пользователя
  const userMessage = {
    id: Date.now(), // временный id
    role: 'user',
    content: form.message
  }
  localMessages.value.push(userMessage)

  // 🔹 2. Отменяем предыдущий стрим, если есть
  if (isStreaming.value) cancel()

  loading.value = true

  // 🔹 3. Сообщение ассистента (для стрима)
  const assistantMessage = {
    id: 'streaming-assistant',
    role: 'assistant',
    content: ''
  }
  localMessages.value.push(assistantMessage)
  streamingAssistantMessage.value = assistantMessage

  // 🔹 4. Отправка запроса
  send({
    message: form.message,
    model: form.selected_model,
    conversation_id: props.conversation.id
  })

  // 🔹 5. Сброс формы
  form.reset('message')
}


// Смена модели
const changeModel = () => {
  form.post(route('model.select'), {
    preserveState: true,
    preserveScroll: true,
    onSuccess: () => console.log('Модель обновлена')
  })
}

// Стриминг

const { data, isFetching, isStreaming, send, cancel } = useStream('/ask-stream', {
  
  onData: (chunk) => {
    if (!streamingAssistantMessage.value) return
    //console.log('Chunk received:', chunk)
    //console.log('Before append:', streamingAssistantMessage.value?.content)
    streamingAssistantMessage.value.content += chunk.replace(/\[REASONING\][\s\S]*?\[\/REASONING\]/g, '');
    //console.log('After append:', streamingAssistantMessage.value?.content)

  },
  onFinish: () => {
  streamingAssistantMessage.value = null
  loading.value = false

  router.reload({
    only: ['conversations'],
    preserveState: false,
    preserveScroll: true,
  })
},
  onError: (err) => {
    console.error('Erreur de streaming:', err)
    loading.value = false
    cancel()
  }
})

// Парсинг reasoning
const streamedContent = computed(() => {
  if (!data.value) return ''
  return data.value.replace(/\[REASONING\][\s\S]*?\[\/REASONING\]/g, '').trim()
 
})

const streamedReasoning = computed(() => {
  if (!data.value) return ''
  const matches = data.value.match(/\[REASONING\]([\s\S]*?)\[\/REASONING\]/g)
  if (!matches) return ''
  return matches.map(m =>
    m.replace(/\[REASONING\]/g, '').replace(/\[\/REASONING\]/g, '')
  ).join('')
})



</script>

<template>
  <Sidebar/>
  <div class='parts'>
    <div class='nav-bar h-screen'>
      <ConversationsList :conversations='props.conversations'/>
    </div>

    <div class="max-w-3xl mx-auto p-6 space-y-4">

      <!-- Ошибки -->
      <div v-if="props.error" class="p-3 bg-red-200 text-red-800 rounded">
        {{ props.error }}
      </div>

      <form @submit.prevent="changeModel">
        <input type="hidden" v-model="form.selected_model" name="selected_model">
        <input type="hidden" :value="props.conversation.id" name="conversation_id">
        <select v-model="form.selected_model" @change="changeModel" class='w-50 focus:outline-none'>
          <option v-for="m in props.models" :key="m.id" :value="m.id">
            {{ m.name }}
          </option>
        </select>
      </form>

      <hr>

      <!-- История сообщений -->
<div class="space-y-4 mb-20">
  <div
    v-for="msg in localMessages"
    :key="msg.id"
    class="p-3 rounded"
    :class="msg.role === 'user' ? 'bg-gray-200' : 'bg-gray-100'"
  >
    <div class="prose" v-html="md.render(msg.content)"></div>
  </div>
</div>

<div v-if="loading" class="loader">
  <span></span>
  <span></span>
  <span></span>
</div>

      <!-- Textarea + кнопка отправки -->
      <div class="fixed bottom-4 left-[calc(33.333%+24px)] right-4">
        <div class="max-w-3xl">
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
  margin:10px 0 10px 0;
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
.parts{
  display:grid;
  grid-template-columns: 30% 70%;
}
.nav-bar{
  background-color:rgb(193, 221, 246);
  height:100%;
}
</style>
