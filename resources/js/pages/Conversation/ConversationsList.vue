<template>
  <div class="max-w-6xl mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Vos chats</h1>

    <!-- Кнопка создания новой беседы -->
    <div class="mb-4 flex gap-2">
      <button
        @click="createConversation"
        class="px-4 py-2 bg-blue-600 text-white"
      >
        Ajouter une conversation
      </button>
    </div>

    <!-- Список бесед -->
    <ul class="space-y-2">
     <li v-for="conv in conversations" :key="conv.id" class="flex items-center justify-between">
  <div v-if="editingId === conv.id" class="flex gap-2 items-center">
    <input v-model="editingTitle" class="border p-1 rounded" />
    <button @click="saveTitle(conv.id)" class="px-2 py-1 bg-green-300 rounded">Save</button>
    <button @click="cancelEditing" class="px-2 py-1 bg-gray-300 rounded">Cancel</button>
  </div>
  <div v-else class="flex gap-2 items-center">
    <Link :href="route('conversation.show', conv.id)" class="block p-3 rounded border hover:shadow-sm flex justify-between items-start">
      <div class=" text-sm cursor-pointer mr-4">
        {{ conv.title ?? 'Nouvelle conversation' }}
      </div>
      <div class="text-sm text-gray-500 m-auto">
        {{ formatDate(conv.updated_at) }}
      </div>
    </Link>
    <div class="relative">
  <!-- Кнопка с тремя точками -->
  <button 
    class="px-2 py-1 text-gray-500 hover:text-gray-700 focus:outline-none"
    @click="conv.showMenu = !conv.showMenu"
  >
    ⋮
  </button>

  <!-- Меню -->
  <div 
    v-if="conv.showMenu"
    class="absolute right-0 mt-2 w-32 bg-white border rounded shadow-lg z-10"
  >
    <button 
      @click="startEditing(conv.id, conv.title); conv.showMenu = false" 
      class="w-full text-left px-3 py-2 hover:bg-gray-100"
    >
      Renommer
    </button>
    <button 
      @click="deleteConversation(conv.id); conv.showMenu = false" 
      class="w-full text-left px-3 py-2 hover:bg-red-100 text-red-600"
    >
      Supprimer
    </button>
  </div>
</div>

  </div>
</li>

    </ul>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const props = defineProps({
  conversations: {
    type: Array,
    default: () => []
  }
});

// Форматирование даты
function formatDate(dateStr) {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleString();
}

// Создание новой беседы
function createConversation() {
  Inertia.post(route('conversation.store'));
}

function deleteConversation(id) {
  if (confirm('Voulez-vous vraiment supprimer la conversation?')) {
    Inertia.delete(route('conversation.destroy',id))
  }
}

const editingId = ref(null)
const editingTitle = ref('')

// Начало редактирования
function startEditing(id, title) {
  editingId.value = id
  editingTitle.value = title
}

// Отмена редактирования
function cancelEditing() {
  editingId.value = null
  editingTitle.value = ''
}

// Сохранение нового названия
function saveTitle(id) {
  if (!editingTitle.value.trim()) return

  Inertia.put(route('conversation.update', id), { title: editingTitle.value }, {
    onSuccess: () => {
      editingId.value = null
      editingTitle.value = ''
    }
  })
  }
</script>
