<template>
  <section id="testimonials" class="px-4 py-20 bg-gradient-to-b from-secondary/20 to-background" aria-labelledby="testimonials-title">
    <div class="max-w-6xl mx-auto">

      <!-- Заголовок -->
      <div class="text-center mb-16 fade-in">
        <div class="inline-flex items-center gap-2 bg-primary/10 border border-primary/20 rounded-full px-4 py-2 mb-4">
          <span class="opacity-80">Témoignages</span>
        </div>

        <h2 class="mb-4" id="testimonials-title">Ce que disent nos utilisateurs  
          <span role="img" aria-label="bulle de discussion">💬</span>
        </h2>

        <p class="opacity-70 max-w-2xl mx-auto leading-relaxed">
          Histoires de personnes qui ont trouvé soutien et compréhension
        </p>
      </div>

      <!-- Карточки отзывов -->
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <article
          v-for="(testi, index) in testimonials"
          :key="index"
          tabindex="0"
          class="bg-card border border-border rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all transform hover:-translate-y-2 fade-in"
          :style="{ animationDelay: `${index * 0.1}s` }"
          :aria-label="`Témoignage de ${testi.name}`"
        >

          <!-- Рейтинг -->
          <div class="flex items-center gap-1 mb-4" :aria-label="`Note : ${testi.rating} sur 5`">
            <span v-for="i in testi.rating" 
            :key="i" 
            class="text-primary text-lg"
            aria-label="étoile">
            ⭐
            </span>
          </div>

          <!-- Текст отзыва -->
          <blockquote class="opacity-80 leading-relaxed mb-6 italic">"{{ testi.quote }}"</blockquote>

          <!-- Пользователь -->
          <div class="flex items-center gap-3">
            <div
              class="w-12 h-12 rounded-full bg-gradient-to-br from-primary/20 to-accent/20 
                     flex items-center justify-center text-2xl"
              role="img"
              :aria-label="`avatar de ${testi.name}`"
            >
              {{ testi.avatar }}
            </div>

            <div>
              <div class="font-medium">{{ testi.name }}</div>
              <div class="opacity-60">{{ testi.role }}</div>
            </div>

          </div>
        </article>
      </div>

      <!-- Средний рейтинг -->
      <div class="mt-16 text-center fade-in">
        <div class="bg-gradient-to-r from-accent/60 to-primary/10 border border-primary/20 
                    rounded-3xl p-8 inline-block"
              aria-label="Note moyenne 4.9 sur 5 basée sur 2847 avis">
          <p class="opacity-80">
            <span class="text-3xl mr-3" aria-hidden="true">⭐</span>
            Note moyenne : <strong class="text-primary">4,9/5</strong> basée sur 2,847 avis
          </p>
        </div>
      </div>
      
    </div>
  </section>
</template>

<script setup>
const testimonials = [
  {
    name: "Sophie L.",
    role: "Étudiante",
    avatar: "👩‍🎓",
    quote: "PsyBot m'aide à gérer mon stress quotidien et à mieux comprendre mes émotions 🌱💙.",
    rating: 5
  },
  {
    name: "Marc D.",
    role: "Développeur",
    avatar: "👨‍💻",
    quote: "J'adore les réponses empathiques de PsyBot, elles sont toujours adaptées à mon humeur.",
    rating: 5
  },
  {
    name: "Julie P.",
    role: "Coach",
    avatar: "👩‍⚕️",
    quote: "Un outil indispensable pour mes clients, tout est clair et rassurant 💙.",
    rating: 5
  },
  {
    name: "Alexandre K.",
    role: "Entrepreneur",
    avatar: "👨‍💼",
    quote: "Disponible 24/7 — un vrai secours ! Je peux demander de l'aide même à 3h du matin 🌙",
    rating: 5
  },
  {
    name: "Elena M.",
    role: "Designer",
    avatar: "👩‍🎨",
    quote: "Interface la plus chaleureuse que j'aie vue. Les couleurs et émojis créent une vraie sensation de soin ✨",
    rating: 5
  },
  {
    name: "Dmitry V.",
    role: "Enseignant",
    avatar: "👨‍🏫",
    quote: "Aide à comprendre les émotions complexes après une journée difficile. Je me sens entendu et compris 🤗",
    rating: 5
  }
]
</script>

<style scoped>
.fade-in {
  opacity: 0;
  transform: translateY(20px);
  animation: fadeInUp 0.6s forwards;
}

@keyframes fadeInUp {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
