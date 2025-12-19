<template>
  <section class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto text-center mb-12">
      <h2 class="text-4xl font-bold mb-4">Nos formules</h2>
      <p class="text-gray-600">Choisis la formule qui te convient le mieux pour ton suivi PsyBot.</p>
    </div>

    <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-8 px-4">
      <!-- Carte Free -->
      <div
        class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition transform opacity-0 translate-y-8 animate-fadeIn"
      >
        <h3 class="text-2xl font-semibold mb-2">Free 🌱</h3>
        <p class="text-gray-500 mb-4">Accès basique pour tester PsyBot.</p>
        <div class="text-3xl font-bold mb-4">0€</div>
        <ul class="text-gray-600 mb-6 space-y-2">
          <li>✅ Chat limité à 5 messages/jour</li>
          <li>✅ Accès aux conseils de base</li>
          <li>✅ Ton empathique standard</li>
        </ul>
        <button class="w-full bg-green-500 text-white rounded-lg py-2 font-semibold hover:bg-green-600 transition">
          Commencer
        </button>
      </div>

      <!-- Carte Pro -->
      <div
        class="bg-white rounded-xl shadow-lg p-6 border-2 border-green-400 transform scale-105 hover:scale-110 transition opacity-0 translate-y-8 animate-fadeIn delay-150"
      >
        <h3 class="text-2xl font-semibold mb-2">Pro 💙</h3>
        <p class="text-gray-500 mb-4">Pour un suivi quotidien et personnalisé.</p>
        <div class="text-3xl font-bold mb-4">9,99€/mois</div>
        <ul class="text-gray-600 mb-6 space-y-2">
          <li>✅ Chat illimité</li>
          <li>✅ Personnalisation complète du ton et des commandes</li>
          <li>✅ Suggestions et conseils avancés</li>
        </ul>
        <button class="w-full bg-blue-500 text-white rounded-lg py-2 font-semibold hover:bg-blue-600 transition">
          Essayer Pro
        </button>
      </div>

      <!-- Carte Enterprise -->
      <div
        class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition transform opacity-0 translate-y-8 animate-fadeIn delay-300"
      >
        <h3 class="text-2xl font-semibold mb-2">Enterprise 🌟</h3>
        <p class="text-gray-500 mb-4">Pour les thérapeutes ou coachs souhaitant PsyBot pour leurs clients.</p>
        <div class="text-3xl font-bold mb-4">29,99€/mois</div>
        <ul class="text-gray-600 mb-6 space-y-2">
          <li>✅ Gestion multi-utilisateurs</li>
          <li>✅ Rapports et statistiques</li>
          <li>✅ Priorité sur le support</li>
        </ul>
        <button class="w-full bg-purple-500 text-white rounded-lg py-2 font-semibold hover:bg-purple-600 transition">
          Contacter
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
</script>

<style scoped>
/* Анимация плавного появления карточек */
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

.delay-150 {
  animation-delay: 0.15s;
}

.delay-300 {
  animation-delay: 0.3s;
}
</style>
