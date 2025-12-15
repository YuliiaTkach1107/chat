<template>
  <nav class="flex justify-between items-center p-4 bg-gray-100 border-b">
    <div class="flex gap-4">
        <Link :href="route('personnalisation.index')" class="font-semibold">
        Personnalisation
        </Link>
    </div>
  </nav>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

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
