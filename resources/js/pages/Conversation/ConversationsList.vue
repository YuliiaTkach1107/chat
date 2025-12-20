<template>
  <div class="relative max-w-6xl mx-auto h-screen">

    <!-- MOBILE / TABLET: Burger Button -->
    <button
      class="lg:hidden fixed top-4 left-4 z-50 h-10 w-10 bg-card hover:bg-accent rounded-xl shadow-lg flex items-center justify-center pointer-cursor"
      @click="isOpen = !isOpen"
    >
      ☰
    </button>

    <!-- MOBILE / TABLET: Overlay -->
    <div 
      v-if="isOpen"
      class="lg:hidden fixed inset-0 bg-black/20 z-40"
      @click="isOpen = false"
    ></div>

    <!-- MOBILE / TABLET: Sidebar -->
    <aside
      class="lg:hidden fixed inset-y-0 left-0 z-50 w-72 bg-card border-r border-border flex flex-col transition-transform duration-300 ease-in-out"
      :class="{ 'translate-x-0': isOpen, '-translate-x-full': !isOpen }"
    >
      <!-- Новая беседа -->
      <div class="p-4 border-b border-border">
        <button
          @click="createConversation"
          class="flex items-center gap-2 px-4 py-2 w-full bg-gradient-to-r from-primary to-primary/80 hover:from-primary/90 hover:to-primary/70 
                 text-primary-foreground rounded-xl shadow-sm transition-all duration-200"
        >
          + Ajouter une conversation
        </button>
      </div>

      <!-- Список бесед -->
      <div class="flex-1 overflow-y-auto p-2 space-y-2">
        <div v-for="conv in conversations" :key="conv.id" class="flex items-center justify-between p-3 rounded-xl border border-border hover:shadow-md bg-card">
          <Link 
            :href="route('conversation.show', conv.id)" 
            class="flex-1 truncate text-sm text-foreground"
            @click="isOpen = false"
          >
            {{ conv.title ?? 'Nouvelle conversation' }}
          </Link>

          <div class="flex gap-1">
            <button
              @click="startEditing(conv.id, conv.title)"
              class="px-2 py-1 bg-accent/30 rounded-lg text-xs hover:bg-accent transition"
            >
              Renommer
            </button>
            <button
              @click="deleteConversation(conv.id)"
              class="px-2 py-1 bg-destructive/30 rounded-lg text-xs hover:bg-destructive text-destructive transition"
            >
              Supprimer
            </button>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <div class="p-4 border-t border-border">
        <div class="bg-gradient-to-br from-primary/10 via-accent/20 to-primary/5 rounded-2xl p-4 border border-primary/10 shadow-sm text-center">
          <div class="text-2xl mb-2">🌸</div>
          <div class="opacity-80 mb-1">Un lieu pour une conversation sincère</div>
          <div class="opacity-60">Vos mots sont en sécurité</div>
        </div>
      </div>
    </aside>

    <!-- DESKTOP -->
<div class="hidden lg:flex h-screen max-w-6xl mx-auto pt-35 px-4">

  <!-- колонка -->
  <div class="flex flex-col w-full">

    <!-- Кнопка создания новой беседы -->
    <div class="mb-4 flex gap-2">
      <button
        @click="createConversation"
        class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-primary to-primary/80 hover:from-primary/90 hover:to-primary/70 
               text-primary-foreground rounded-xl shadow-sm transition-all duration-200 hover:cursor-pointer"
      >
        + Ajouter une conversation
      </button>
    </div>

    <!-- СКРОЛЛИМЫЙ СПИСОК -->
    <div class="flex-1 overflow-y-auto">
      <ul class="space-y-2 pr-1">
        <li v-for="conv in conversations" :key="conv.id">

          <!-- режим редактирования -->
          <div v-if="editingId === conv.id" class="flex gap-2 items-center">
            <input 
              v-model="editingTitle" 
              class="border border-border p-2 rounded-lg flex-1 focus:outline-none focus:ring-2 focus:ring-primary transition"
            />
            <button @click="saveTitle(conv.id)" class="px-3 py-1 text-white bg-primary rounded-lg">Save</button>
            <button @click="cancelEditing" class="px-3 py-1 bg-primary/10 rounded-lg">Cancel</button>
          </div>

          <!-- обычный режим -->
          <div v-else class="flex items-center justify-between p-3 rounded-xl border border-border hover:shadow-md transition-all bg-card">
            <Link 
              :href="route('conversation.show', conv.id)" 
              class="flex-1 flex justify-between items-center gap-4 text-sm text-foreground"
            >
              <span class="truncate font-medium">
                {{ conv.title ?? 'Nouvelle conversation' }}
              </span>
              <span class="text-xs text-muted-foreground">
                {{ formatDate(conv.updated_at) }}
              </span>
            </Link>

            <div class="relative">
              <button 
                class="px-2 py-1 text-muted-foreground hover:text-foreground"
                @click="conv.showMenu = !conv.showMenu"
              >
                ⋮
              </button>

              <div 
                v-if="conv.showMenu"
                class="absolute right-0 mt-2 w-36 bg-card border border-border rounded-xl shadow-lg z-10"
              >
                <button 
                  @click="startEditing(conv.id, conv.title); conv.showMenu = false" 
                  class="w-full text-left px-3 py-2 hover:bg-accent/50 rounded-lg"
                >
                  Renommer
                </button>
                <button 
                  @click="deleteConversation(conv.id); conv.showMenu = false" 
                  class="w-full text-left px-3 py-2 hover:bg-destructive/50 text-destructive rounded-lg"
                >
                  Supprimer
                </button>
              </div>
            </div>
          </div>

        </li>
      </ul>
    </div>

    <!-- FOOTER (всегда внизу) -->
    <div class="p-4 border-t border-border mt-4">
      <div class="bg-gradient-to-br from-primary/10 via-accent/20 to-primary/5 rounded-2xl p-4 border border-primary/10 shadow-sm text-center">
        <div class="text-2xl mb-2">🌸</div>
        <div class="opacity-80 mb-1">Un lieu pour une conversation sincère</div>
        <div class="opacity-60">Vos mots sont en sécurité</div>
      </div>
    </div>

  </div>
</div>

  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

const props = defineProps({
  conversations: {
    type: Array,
    default: () => []
  }
})

const isOpen = ref(false)
const editingId = ref(null)
const editingTitle = ref('')

// Создание новой беседы
function createConversation() {
  Inertia.post(route('conversation.store'))
}

// Удаление беседы
function deleteConversation(id) {
  if (confirm('Voulez-vous vraiment supprimer la conversation?')) {
    Inertia.delete(route('conversation.destroy', id), { preserveScroll: false, preserveState: true })
  }
}

// Редактирование
function startEditing(id, title) {
  editingId.value = id
  editingTitle.value = title
}

function cancelEditing() {
  editingId.value = null
  editingTitle.value = ''
}

function saveTitle(id) {
  if (!editingTitle.value.trim()) return
  Inertia.put(route('conversation.update', id), { title: editingTitle.value }, {
    onSuccess: () => {
      editingId.value = null
      editingTitle.value = ''
    }
  })
}

// Форматирование даты
function formatDate(dateStr) {
  if (!dateStr) return ''
  return new Date(dateStr).toLocaleString()
}
</script>

<style scoped>
html, body, #app {
  height: 100%;
  overflow: hidden; 
}

/* Плавные hover и transition для кнопок */
button, .hover\:shadow-md:hover {
  transition: all 0.2s ease-in-out;
}

/* Градиенты */
.bg-gradient-to-r {
  background-image: linear-gradient(to right, var(--primary), rgba(232,168,124,0.8));
}
.hover\:from-primary\/90:hover {
  background-image: linear-gradient(to right, rgba(232,168,124,0.9), rgba(232,168,124,0.7));
}
.hover\:to-primary\/70:hover {
  background-image: linear-gradient(to right, var(--primary), rgba(232,168,124,0.7));
}
</style>
