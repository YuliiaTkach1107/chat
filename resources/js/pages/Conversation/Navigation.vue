<template>
  <div class="flex-1 flex flex-col">
    <!-- Header -->
    <header class="fixed top-0 left-0 w-full border-b border-border bg-card px-4 py-4 sm:px-6 md:px-8 lg:px-6 z-50">
      <div class="max-w-7xl flex flex-col sm:flex-row items-center sm:justify-between gap-4 sm:gap-6 lg:flex-row lg:gap-10 sm:m-auto">
        
        <!-- Навигация -->
        <nav class="flex gap-4 sm:gap-6 w-full sm:w-auto justify-center sm:justify-start lg:justify-start">
          <Link :href="route('personnalisation.index')" class="font-semibold text-primary">
            <Settings class="w-5 h-5 sm:w-6 sm:h-6 lg:w-6 lg:h-6 text-primary sm:ml-15" />
          </Link>
          <Link :href="route('landing')" class="font-semibold text-primary">
            <Home class="w-5 h-5 sm:w-6 sm:h-6 lg:w-6 lg:h-6 text-primary" />
          </Link>
        </nav>

        <!-- Заголовок -->
        <div class="text-center sm:text-left mt-2 sm:mt-0 lg:text-left">
          <h1 class="text-primary text-lg sm:text-xl lg:text-2xl font-semibold">
            Un soutien psychologique
          </h1>
          <p class="opacity-60 mt-1 text-xs sm:text-sm lg:text-base">
            Un espace sûr pour la conversation
          </p>
        </div>

      </div>
    </header>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { Settings, Home } from 'lucide-vue-next'

const props = defineProps({
  models: Array,
  selectedModel: String
})

const form = useForm({ selected_model: props.selectedModel ?? '' })
const selectedModel = ref(props.selectedModel)

const changeModel = () => {
  form.post(route('model.select'), { selected_model: selectedModel.value }, {
    preserveState: true,
    onSuccess: () => console.log('Modèle changé')
  })
}
</script>

<style scoped>
html, body, #app {
  overflow: hidden !important;
}
</style>
