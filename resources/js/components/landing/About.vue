<template>
  <section id="about" class="px-4 py-20 bg-gradient-to-b from-background to-secondary/20" aria-labelledby="about-title">
    <div class="max-w-6xl mx-auto">
      <div class="grid lg:grid-cols-2 gap-12 items-center">
        <!-- Левая часть: контент -->
        <div class="fade-in-left">
          <div class="inline-flex items-center gap-2 bg-primary/10 border border-primary/20 rounded-full px-4 py-2 mb-6">
            <span class="opacity-80">À propos</span>
          </div>

          <h2  id="about-title" class="mb-6 text-4xl font-bold" >
            Nous créons un espace sûr pour votre esprit 
            <span role="img" aria-label="coeur jaune">💛</span>
          </h2>

          <p class="opacity-80 leading-relaxed mb-6">
            Notre mission est de rendre le soutien psychologique accessible à tous ceux qui en ont besoin.
            Nous croyons que chaque personne mérite d’être écoutée et comprise.
          </p>

          <p class="opacity-80 leading-relaxed mb-8">
            L’équipe PsyBot est composée de psychologues, développeurs et designers,
            unis par un objectif commun : aider les gens à se sentir mieux et à surmonter les difficultés de la vie.
          </p>

          <div class="space-y-4">
            <div class="flex items-start gap-4">
              <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary/20 to-accent/20 flex items-center justify-center flex-shrink-0">
                <span role="img" aria-label="coeur">❤️</span>
              </div>
              <div class="flex-1">
                <h4 class="mb-2 font-semibold">Empathie</h4>
                <p class="opacity-70">
                  Nous comprenons l’importance d’être écouté. Chaque réponse est créée avec soin et attention.
                </p>
              </div>
            </div>

            <div class="flex items-start gap-4">
              <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary/20 to-accent/20 flex items-center justify-center flex-shrink-0">
                <span role="img" aria-label="groupe de personnes">👥</span>
              </div>
              <div class="flex-1">
                <h4 class="mb-2 font-semibold">Accessibilité</h4>
                <p class="opacity-70">
                  Le soutien ne doit pas être un luxe. Nous le rendons disponible pour tous, 24/7.
                </p>
              </div>
            </div>

            <div class="flex items-start gap-4">
              <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary/20 to-accent/20 flex items-center justify-center flex-shrink-0">
                <span role="img" aria-label="cible">🎯</span>
              </div>
              <div class="flex-1">
                <h4 class="mb-2 font-semibold">Qualité</h4>
                <p class="opacity-70">
                  Notre IA est formée par des experts utilisant des méthodes psychologiques éprouvées.
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Statistiques -->
        <div class="fade-in-right relative">
          <div class="grid grid-cols-2 gap-4">
            <article class="bg-gradient-to-br from-card to-accent/30 border border-border rounded-2xl p-6 shadow-lg text-center"
                     aria-label="Plus de dix mille utilisateurs">
              <div class="text-4xl mb-2" role="img" aria-label="étoile">🌟</div>
              <div class="text-3xl font-bold text-primary mb-1">10,000+</div>
              <div class="opacity-70">Utilisateurs</div>
            </article>

            <article class="bg-gradient-to-br from-card to-accent/30 border border-border rounded-2xl p-6 shadow-lg text-center"
                     aria-label="Plus de cinquante mille conversations">
              <div class="text-4xl mb-2" role="img" aria-label="bulle de discussion">💬</div>
              <div class="text-3xl font-bold text-primary mb-1">50,000+</div>
              <div class="opacity-70">Conversations</div>
            </article>

            <article class="bg-gradient-to-br from-card to-accent/30 border border-border rounded-2xl p-6 shadow-lg text-center"
                     aria-label="Note moyenne de 4.9 sur 5">
              <div class="text-4xl mb-2" role="img" aria-label="étoile">⭐</div>
              <div class="text-3xl font-bold text-primary mb-1">4.9/5</div>
              <div class="opacity-70">Note</div>
            </article>

            <article class="bg-gradient-to-br from-card to-accent/30 border border-border rounded-2xl p-6 shadow-lg text-center"
                     aria-label="Présent dans plus de quinze pays">
              <div class="text-4xl mb-2" role="img" aria-label="globe">🌍</div>
              <div class="text-3xl font-bold text-primary mb-1">15+</div>
              <div class="opacity-70">Pays</div>
            </article>
          </div>

          <!-- Анимационные элементы -->
          <div class="absolute -top-8 -right-8 text-6xl animate-bounce-slow" aria-hidden="true">🦋</div>
          <div class="absolute -bottom-8 -left-8 text-5xl animate-bounce-slow-delay" aria-hidden="true">🌸</div>
        </div>
      </div>

      <!-- Блок подвала -->
      <div class="mt-16 bg-gradient-to-r from-primary/10 via-accent/20 to-primary/10 border border-primary/20 rounded-3xl p-8 text-center">
        <p class="opacity-80 leading-relaxed max-w-3xl mx-auto">
          <span class="text-3xl mr-3" role="img" aria-label="coeur bleu">💙</span>
          Nous nous améliorons continuellement pour vous offrir le meilleur soutien.
          Vos retours nous aident à devenir meilleurs.
        </p>
      </div>
    </div>
  </section>
</template>

<style scoped>
.fade-in-left {
  opacity: 0;
  transform: translateX(-30px);
  animation: fadeInLeft 0.6s forwards;
}
.fade-in-right {
  opacity: 0;
  transform: translateX(30px);
  animation: fadeInRight 0.6s forwards;
}
@keyframes fadeInLeft {
  to {
    opacity: 1;
    transform: translateX(0);
  }
}
@keyframes fadeInRight {
  to {
    opacity: 1;
    transform: translateX(0);
  }
}
.animate-bounce-slow {
  animation: bounce 5s infinite alternate;
}
.animate-bounce-slow-delay {
  animation: bounce 5s infinite alternate 1s;
}
@keyframes bounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}
</style>
