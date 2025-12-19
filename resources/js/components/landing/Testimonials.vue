<template>
  <section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto text-center mb-12">
      <h2 class="text-4xl font-bold mb-4">Témoignages</h2>
      <p class="text-gray-600">Ce que nos utilisateurs disent de PsyBot 🌱</p>
    </div>

    <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-8 px-4">
      <div
        v-for="(testi, index) in testimonials"
        :key="index"
        class="bg-gray-50 rounded-xl shadow-lg p-6 transform opacity-0 translate-y-8 animate-fadeIn hover:scale-105 transition"
        :class="`delay-${index*150}`"
      >
        <div class="flex items-center mb-4">
          <img :src="testi.avatar" alt="" class="w-12 h-12 rounded-full mr-4 border-2 border-green-300"/>
          <div>
            <h4 class="font-semibold">{{ testi.name }}</h4>
            <p class="text-sm text-gray-500">{{ testi.role }}</p>
          </div>
        </div>
        <p class="text-gray-700 italic">"{{ testi.quote }}"</p>
      </div>
    </div>
  </section>
</template>

<script setup>
const testimonials = [
  {
    name: "Sophie L.",
    role: "Étudiante",
    avatar: "https://i.pravatar.cc/150?img=12",
    quote: "PsyBot m'aide à gérer mon stress quotidien et à mieux comprendre mes émotions 🌱💙."
  },
  {
    name: "Marc D.",
    role: "Développeur",
    avatar: "https://i.pravatar.cc/150?img=32",
    quote: "J'adore les réponses empathiques de PsyBot, elles sont toujours adaptées à mon humeur."
  },
  {
    name: "Julie P.",
    role: "Coach",
    avatar: "https://i.pravatar.cc/150?img=45",
    quote: "Un outil indispensable pour mes clients, tout est clair et rassurant 💙."
  }
]
</script>

<style scoped>
@keyframes fadeIn {
  0% {
    opacity: 0;
    transform: translateY(32px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fadeIn {
  animation: fadeIn 0.6s forwards;
}

.delay-0 {
  animation-delay: 0s;
}
.delay-150 {
  animation-delay: 0.15s;
}
.delay-300 {
  animation-delay: 0.3s;
}
</style>
