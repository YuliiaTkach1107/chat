<script setup>
import { useForm } from '@inertiajs/vue3'
import MarkdownIt from 'markdown-it'
import hljs from 'highlight.js'
import 'highlight.js/styles/github-dark.css' 
import { route } from 'ziggy-js'
import { ArrowUp } from 'lucide-vue-next';

const props = defineProps({
  models: Array, selectedModel: String, message: String, response: String, error: String
})
const form = useForm({ message: props.message ?? '', model: props.selectedModel })
const submit = () => { form.post(route('ask.post')) }


const md = new MarkdownIt({
    highlight: function (str, lang) {
        if (lang && hljs.getLanguage(lang)) {
            try {
                return hljs.highlight(str, { language: lang }).value
            } catch (__) {}
        }
        return '' // use external default escaping
    }
})

</script>

<template>
<div class="max-w-3xl mx-auto p-6 space-y-4">

    <!-- Ошибки -->
    <div v-if="props.error" class="p-3 bg-red-200 text-red-800 rounded">
        {{ props.error }}
    </div>
<div class="fixed bottom-4 left-0 right-0 px-4">
  <div class="max-w-3xl mx-auto">
    <div class="flex items-center bg-white border rounded-xl shadow-md overflow-hidden">
    <!-- Textarea для ввода сообщения -->
    <textarea
        v-model="form.message"
        placeholder="Pose ta question..."
        class="w-full border rounded p-3 resize-none"
        
        
    ></textarea>

     <!-- Кнопка отправки -->
    <button
        @click="submit"
        :disabled="form.processing || !form.message.trim()"
        class="text-white bg-black rounded disabled:bg-gray-400 cursor-pointer"
    >
        <Arrow-up class="26" />
    </button>
        </div>
    </div>
</div>

    <!-- Select для моделей -->
    <select v-model="form.model" class='w-50 focus:outline-none'>
        <option
            v-for="m in props.models"
            :key="m.id"
            :value="m.id"
        >
            {{ m.name }}
        </option>
    </select>
<hr>
   
    <!-- Блок для ответа с Markdown -->
    <div
        v-if="props.response"
        class="prose dark:prose-invert prose-slate max-w-none p-4 bg-gray-100 rounded"
        v-html="md.render(props.response)"
    ></div>

</div>
</template>
<style>
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
</style>