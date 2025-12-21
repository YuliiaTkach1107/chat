<template>
<section id="features" class="px-4 py-20 bg-gradient-to-b from-background to-secondary/20" aria-labelledby="features-title">
  <div class="max-w-6xl mx-auto">

    <header class="text-center mb-16">
      <h2 id='features-title' class="text-3xl sm:text-4xl font-semibold mb-4">Pourquoi choisir PsyBot ? 
        <span role="img" aria-label="étoile brillante">🌟</span>
      </h2>
      <p class="opacity-70 max-w-2xl mx-auto leading-relaxed">
        Un espace sûr et bienveillant pour parler librement et trouver du soutien
      </p>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <!-- Каждая карточка с aria-label -->
      <article
       v-for="(feature, index) in features" 
       :key="index" 
       tabindex="0"
       class="group bg-card border border-border rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all"
              :aria-label="feature.title">
        <div class="mb-4">
          <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary/20 to-accent/20 flex items-center justify-center group-hover:scale-110 transition-transform">
            <span class="text-3xl" role="img" :aria-label="feature.title">{{ feature.emoji }}</span>
          </div>
        </div>

        <h3 class="text-lg font-medium mb-2">{{ feature.title }}</h3>

        <p class="opacity-70 leading-relaxed">{{ feature.text }}</p>
      </article>
      
    </div>
  </div>
</section>
</template>
<script setup>
const features = [
  { title: 'Empathie et compréhension', text: 'Une écoute sincère et attentive à vos émotions, au-delà des mots.', emoji: '💗' },
  { title: 'Confidentialité totale', text: 'Vos conversations restent privées. Un espace sûr pour parler librement.', emoji: '🔒' },
  { title: 'Disponible 24/7', text: 'Un soutien accessible à tout moment, jour et nuit.', emoji: '🌙' },
  { title: 'Suggestions intelligentes', text: 'Des thèmes prêts à l’emploi pour commencer quand les mots manquent.', emoji: '🧠' },
  { title: 'Historique des conversations', text: 'Retrouvez vos échanges importants à tout moment.', emoji: '💬' },
  { title: 'Sans jugement', text: 'Soyez vous-même et parlez librement de ce qui compte vraiment.', emoji: '✨' }
]
</script>
