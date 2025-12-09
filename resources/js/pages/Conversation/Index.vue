<template>
  <div class="max-w-6xl mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Conversations</h1>

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
      <li v-for="conv in conversations" :key="conv.id">
        <Link
          :href="route('conversation.show', conv.id)"
          class="block p-3 rounded border hover:shadow-sm flex justify-between items-start"
        >
          <div>
            <!-- Название беседы -->
            <div class="font-medium text-lg cursor-pointer">
              {{ conv.title ?? 'Nouvelle conversation' }}
            </div>
            </div>
          <!-- Дата обновления -->
          <div class="text-sm text-gray-500">
            {{ formatDate(conv.updated_at) }}
          </div>
        </Link>
        <button @click="deleteConversation(conv.id)">
          Supprimer
         </button>
      </li>
    </ul>
  </div>
</template>

<script setup>
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
</script>
