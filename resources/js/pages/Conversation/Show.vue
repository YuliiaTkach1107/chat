<script setup>
import { ref, computed, nextTick } from 'vue'
import { useForm } from '@inertiajs/vue3'
import MarkdownIt from 'markdown-it'
import hljs from 'highlight.js'
import 'highlight.js/styles/github-dark.css'
import { route } from 'ziggy-js'
import { ArrowUp } from 'lucide-vue-next'
import { useStream } from '@laravel/stream-vue'
import { router } from '@inertiajs/vue3'
import ConversationLayout from './layouts/ConversationLayout.vue'

const streamingAssistantMessage = ref(null)
const props = defineProps({
  models: Array,
  selectedModel: String,
  messages: Array,
  conversation: Object,
  error: String,
  conversations: { type: Array, default: () => [] },
})

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

const localMessages = ref([...props.messages])
const messagesContainer = ref(null)

const scrollToBottom = () => {
  nextTick(() => {
    if (messagesContainer.value) {
      messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight
    }
  })
}

const submit = () => {
  if (!props.conversation?.id || !(form.message || '').trim()) return

  const userMessage = {
    id: Date.now(),
    role: 'user',
    content: form.message
  }
  localMessages.value.push(userMessage)

  if (isStreaming.value) cancel()

  const assistantMessage = {
    id: 'assistant-' + Date.now(), // уникальный ключ
    role: 'assistant',
    content: '',
    isStreaming: true // флаг для отображения лоадера
  }
  localMessages.value.push(assistantMessage)
  streamingAssistantMessage.value = assistantMessage

  send({
    message: form.message,
    model: form.selected_model,
    conversation_id: props.conversation.id
  })

  scrollToBottom()
  form.reset('message')
}

const changeModel = () => {
  form.post(route('model.select'), {
    preserveState: true,
    preserveScroll: true,
  })
}

const { data, isFetching, isStreaming, send, cancel } = useStream('/ask-stream', {
  onData: (chunk) => {
    if (!streamingAssistantMessage.value) return
    streamingAssistantMessage.value.content += chunk.replace(/\[REASONING\][\s\S]*?\[\/REASONING\]/g, '')
    scrollToBottom()
  },
  onFinish: () => {
    if (streamingAssistantMessage.value) {
      streamingAssistantMessage.value.isStreaming = false
      streamingAssistantMessage.value = null
    }
    router.reload({
      only: ['conversations'],
      preserveState: false,
      preserveScroll: true,
    })
  },
  onError: () => {
    if (streamingAssistantMessage.value) {
      streamingAssistantMessage.value.isStreaming = false
      streamingAssistantMessage.value = null
    }
    cancel()
  }
})

const isStreamingMessage = (msg) => msg.isStreaming 

</script>

<template>
  <ConversationLayout :conversations="conversations">
    <div class="max-w-6xl mx-auto px-4 pb-32 overflow-hidden  pt-43 lg:pt-27">
      <div v-if="props.error" class="p-3 bg-red-200 text-red-800 rounded">
        {{ props.error }}
      </div>

      <form @submit.prevent="changeModel">
        <input type="hidden" v-model="form.selected_model" name="selected_model">
        <input type="hidden" :value="props.conversation.id" name="conversation_id">
        <select v-model="form.selected_model" @change="changeModel" class='w-50 focus:outline-none'>
          <option v-for="m in props.models" :key="m.id" :value="m.id">{{ m.name }}</option>
        </select>
      </form>

      <hr>

      <!-- Сообщения -->
      <div ref="messagesContainer" class="overflow-y-auto max-h-[70vh] max-w-[100vw] space-y-4 scroll-smooth">
        <div v-for="msg in localMessages" :key="msg.id" class="chat-message" :class="{ assistant: msg.role === 'assistant' }">
          <div class="avatar">
            <span v-if="msg.role === 'assistant'">🤗</span>
            <span v-else>😊</span>
          </div>
          <div class="content">
            <div class="author">{{ msg.role === 'assistant' ? '💭 Votre assistant' : '✨ Vous' }}</div>
            <div class="text prose prose-sm">
              <div v-html="md.render(msg.content)" />
              <div v-if="msg.isStreaming" class="typing"><span></span><span></span><span></span></div>
            </div>
          </div>
        </div>
      </div>

      <div class="chat-input">
        <textarea v-model="form.message" @keydown.enter.prevent="submit" placeholder="Pose ta question..." />
        <button @click="submit" :disabled="form.processing || !form.message.trim()" class='cursor-pointer'>➤</button>
      </div>
    </div>
  </ConversationLayout>
</template>

<style scoped>
/* остальной CSS оставил без изменений */
</style>


<style scoped>
/* ===== Chat message (как в Figma / React) ===== */

.chat-message {
  display: flex;
  gap: 16px;
  padding: 24px 16px;
}

.chat-message.assistant {
  background: rgb(232, 168, 124, 0.1);
}
.avatar {
  width: 40px;
  height: 40px;
  border-radius: 9999px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 2px 6px rgba(0,0,0,.1);
  font-size: 20px;
  background: linear-gradient(135deg, #fae2d3, #e6c9b5cc);
}

.chat-message:not(.assistant) .avatar {
  background: linear-gradient(135deg, #E8A87C, #e8a87ccc);
  
}

.content {
  flex: 1;
}

.author {
  opacity: 0.6;
  font-size: 14px;
  margin-bottom: 6px;
}


/* ===== Typing animation ===== */

.typing {
  display: flex;
  gap: 6px;
}

.typing span {
  width: 10px;
  height: 10px;
  background: #E8A87C;
  border-radius: 9999px;
  opacity: .3;
  animation: typing 1.2s infinite;
}

.typing span:nth-child(2) { animation-delay: .2s }
.typing span:nth-child(3) { animation-delay: .4s }

@keyframes typing {
  0%,80%,100% { opacity: .3 }
  40% { opacity: 1 }
}

/* ===== Input ===== */

.chat-input {
  position: fixed;
  bottom: 16px;
  left: calc(33.333% + 24px);
  right: 16px;
  display: flex;
  gap: 8px;
  background: white;
  border-radius: 16px;
  box-shadow: 0 8px 24px rgba(0,0,0,.12);
  padding: 10px;
  align-items: center;
  height: 55px; 
}

.chat-input textarea {
  flex: 1;
  resize: none;
  border: none;
  outline: none; 
}
.chat-input textarea::placeholder {
  padding-top:8px;
  }

.chat-input button {
  width: 44px;
  height: 44px;
  border-radius: 9999px;
  border: none;
  background: #E8A87C;
  color: white;
  font-size: 18px;
}
.chat-input button:disabled {
  background: rgb(232, 168, 124,0.5);
  cursor: not-allowed;
}


/* Mobile / Tablet (≤1024px) */
@media (max-width: 1024px) {
  .chat-input {
    left: 16px;       /* отступ от края */
    right: 16px;      /* отступ от края */
    bottom: 16px;     /* от нижнего края */
    top: auto;        /* не фиксируем сверху */
    width: auto; 
  }
}
</style>
