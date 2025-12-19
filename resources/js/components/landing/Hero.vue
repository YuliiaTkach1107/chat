<template>
  <section class="hero bg-blue-100 py-20 text-center">
    <h1 class="text-5xl font-bold mb-4">Bienvenue sur PsyBot 🌱💙</h1>
    <p class="text-xl mb-6">Votre assistant de soutien psychologique personnel, empathique et sûr.</p>
    <button @click="goHome" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
      Commencer maintenant
    </button>
  </section>
</template>

<script setup>

import { router } from '@inertiajs/vue3'

const goHome = () => {
  router.visit(route('conversation.index'))
}
</script>
