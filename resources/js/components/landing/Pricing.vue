<template>
  <section class="px-4 py-20 bg-gradient-to-b from-background to-secondary/20">
    <div class="max-w-6xl mx-auto">
      <!-- Заголовок -->
      <div class="text-center mb-16 fade-in">
        <div class="inline-flex items-center gap-2 bg-primary/10 border border-primary/20 rounded-full px-4 py-2 mb-4">
          <span class="opacity-80">Tarifs</span>
        </div>
        <h2 class="mb-4" id='tarifs'>Choisissez votre plan 💛</h2>
        <p class="opacity-70 max-w-2xl mx-auto leading-relaxed">
          Commencez par le plan gratuit ou choisissez une formule avec plus de fonctionnalités
        </p>
      </div>

      <!-- Карточки тарифов -->
      <div class="grid md:grid-cols-3 gap-6">
        <div
          v-for="(plan, index) in plans"
          :key="index"
          class="relative bg-card border rounded-3xl p-8 shadow-sm hover:shadow-xl transition-all transform hover:-translate-y-2 fade-in"
          :class="plan.popular ? 'border-primary/40 shadow-lg' : 'border-border'"
        >
          <!-- Популярный план -->
          <div
            v-if="plan.popular"
            class="absolute -top-4 left-1/2 -translate-x-1/2 bg-gradient-to-r from-primary to-primary/80 
                  text-primary-foreground px-6 py-2 rounded-full shadow-lg"
          >
            <span>Populaire 🌟</span>
          </div>

          <div class="text-center mb-6">
            <div class="text-5xl mb-4">{{ plan.emoji }}</div>
            <h3 class="mb-2">{{ plan.name }}</h3>
            <p class="opacity-60 mb-4">{{ plan.description }}</p>
            <div class="mb-2">
              <span class="text-4xl font-bold text-primary">{{ plan.price }}</span>
              <span v-if="plan.period" class="opacity-60 ml-1">{{ plan.period }}</span>
            </div>
          </div>

          <ul class="space-y-3 mb-8">
            <li
              v-for="(feature, i) in plan.features"
              :key="i"
              class="flex items-start gap-3"
            >
              <div class="w-5 h-5 rounded-full bg-primary/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg class="w-3 h-3 text-primary" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 011.414-1.414L8.414 12.586l7.879-7.879a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
              </div>
              <span class="opacity-80">{{ feature }}</span>
            </li>
          </ul>

          <button
            class="w-full py-4 rounded-full transition-all text-white bg-gradient-to-r from-primary to-primary/80 shadow-lg hover:shadow-xl"
          >
            {{ plan.price === 'Gratuit' ? 'Commencer gratuitement' : 'Choisir ce plan' }}
          </button>
        </div>
      </div>

      <!-- Промо -->
      <div class="mt-12 text-center fade-in">
        <p class="opacity-60">🎁 Premier mois de tout plan payant à -50%</p>
      </div>
    </div>
  </section>
</template>

<script setup>
const plans = [
  {
    name: 'Basique',
    emoji: '🌱',
    price: 'Gratuit',
    description: 'Pour commencer votre parcours',
    features: [
      'Conversations illimitées',
      'Support de base 24/7',
      'Historique des chats 7 jours',
      'Sujets prêts pour conversation',
      'Application mobile'
    ],
    popular: false
  },
  {
    name: 'Confort',
    emoji: '💫',
    price: '4,90€',
    period: '/mois',
    description: 'Choix le plus populaire',
    features: [
      'Tout du plan Basique',
      'Support prioritaire',
      'Historique illimité des chats',
      'Recommandations personnalisées',
      'Exportation des conversations',
      'Sujets de réflexion',
      'Sans publicité'
    ],
    popular: true
  },
  {
    name: 'Premium',
    emoji: '✨',
    price: '9,90€',
    period: '/mois',
    description: 'Prendre soin de soi au maximum',
    features: [
      'Tout du plan Confort',
      'Analyse avancée des émotions',
      'Exercices personnalisés',
      'Rapports hebdomadaires',
      'Messages vocaux',
      'Intégration calendrier',
      'Accès aux webinaires'
    ],
    popular: false
  }
]
</script>

<style scoped>
.fade-in {
  opacity: 0;
  transform: translateY(20px);
  animation: fadeInUp 0.6s forwards;
}

.fade-in:nth-child(1) { animation-delay: 0s; }
.fade-in:nth-child(2) { animation-delay: 0.1s; }
.fade-in:nth-child(3) { animation-delay: 0.2s; }
.fade-in:nth-child(4) { animation-delay: 0.3s; }

@keyframes fadeInUp {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
