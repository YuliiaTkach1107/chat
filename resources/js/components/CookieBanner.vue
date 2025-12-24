<template>
  <div v-if="!bannerHidden" 
       class="fixed bottom-0 w-full bg-accent border border-destructive p-4 flex justify-between items-center h-30"
       role="dialog"
       aria-live="polite"
       aria-label="Bannière de consentement aux cookies">
       
    <span tabindex="0">Nous utilisons des cookies pour améliorer le service. 🍪</span>
    <div class="space-x-2">
      <button @click="acceptAll" class="px-3 py-1 bg-background border border-destructive rounded hover:cursor-pointer" aria-label="Accepter tous les cookies">Accepter</button>
      <button @click="rejectAll" class="bg-destructive text-white px-3 py-1 rounded hover:cursor-pointer" aria-label="Refuser tous les cookies">Refuser</button>
      <button @click="openSettings" class="underline mr-16">Paramètres</button>
    </div>
  </div>

<!-- Модальное окно настроек -->
  <div v-if="settingsOpen" 
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
      role="dialog"
      aria-modal="true"
      aria-labelledby="cookie-settings-title"
      aria-describedby="cookie-settings-desc">
    <div class="bg-background border border-destructive  p-6 rounded-lg max-w-md w-full">
      <h2 id="cookie-settings-title" class="text-xl font-bold mb-4">Paramètres des cookies</h2>
      <p id="cookie-settings-desc" class="mb-4">Vous pouvez modifier vos préférences concernant les cookies :</p>

      <div class="mb-4">
        <label class="flex items-center gap-2">
          <input type="checkbox" v-model="functionalCookies" aria-label="Cookies fonctionnels" />
          Cookies fonctionnels (nécessaires au fonctionnement du site)
        </label>
        <label class="flex items-center gap-2 mt-2">
          <input type="checkbox" v-model="analyticsCookies" aria-label="Cookies analytiques" />
          Cookies analytiques (pour améliorer le service)
        </label>
      </div>

      <div class="flex justify-end gap-2">
        <button @click="saveSettings" 
                class="bg-destructive text-white px-4 py-2 rounded hover:bg-destructive/80"
                aria-label="Sauvegarder les paramètres des cookies"
        >
          Sauvegarder
        </button>
        <button 
          @click="closeSettings" 
          class="px-4 py-2 rounded border border-destructive"
          aria-label="Annuler et fermer la fenêtre">
            Annuler
          </button>
      </div>
    </div>
    </div>



</template>

<script setup>
import { ref,watch } from 'vue'

// Состояние баннера
const bannerHidden = ref(localStorage.getItem('cookies_banner') === 'accepted' || localStorage.getItem('cookies_banner') === 'rejected')

// Настройки
const settingsOpen = ref(false)
const functionalCookies = ref(true) // всегда включены
const analyticsCookies = ref(localStorage.getItem('cookies_analytics') === 'true')

// Методы
const acceptAll = () => {
  localStorage.setItem('cookies_banner', 'accepted')
  localStorage.setItem('cookies_analytics', 'true')
  analyticsCookies.value = true
  bannerHidden.value = true
}

const rejectAll = () => {
  localStorage.setItem('cookies_banner', 'rejected')
  localStorage.setItem('cookies_analytics', 'false')
  analyticsCookies.value = false
  bannerHidden.value = true
}

const openSettings = () => settingsOpen.value = true
const closeSettings = () => settingsOpen.value = false

const saveSettings = () => {
  localStorage.setItem('cookies_analytics', analyticsCookies.value ? 'true' : 'false')
  localStorage.setItem('cookies_banner', 'accepted')
  bannerHidden.value = true
  settingsOpen.value = false
}

// Автоматическое применение изменений при загрузке
watch(analyticsCookies, (val) => {
  // здесь можно подключить отключение/включение аналитики
  console.log('Analytics cookies:', val)
})
</script>
<style scoped>
input[type="checkbox"] {
  appearance: none;
  width: 20px;
  height: 20px;
  border: 2px solid var(--border);
  border-radius: 4px;
  position: relative;
  display: flex; /* ← добавляем */
  align-items: center;
  justify-content: center;
}


input[type="checkbox"]:checked {
  background: var(--primary);
  border-color: var(--accent);
  background-image: url("data:image/svg+xml;utf8,<svg fill='none' stroke='%23fff' stroke-width='3' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path d='M5 13l4 4L19 7'/></svg>");
  background-repeat: no-repeat;
  background-position: center;
}

</style>
