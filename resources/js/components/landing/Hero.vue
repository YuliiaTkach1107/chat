<template>
  <section class="relative overflow-hidden px-4 py-20 lg:py-32">
    <!-- Background gradient -->
    <div class="absolute inset-0 bg-gradient-to-br from-accent/40 via-background to-secondary/30 -z-10"></div>

    <div class="max-w-6xl mx-auto">
      <div class="grid lg:grid-cols-2 gap-12 items-center">
        
        <!-- Левая часть -->
        <div class="text-left">
          <div class="inline-flex items-center gap-2 bg-primary/10 border border-primary/20 rounded-full px-4 py-2 mb-6">
            <span class="text-primary">✨</span>
            <span class="opacity-80">Votre assistant personnel</span>
          </div>

          <h1 class="text-4xl sm:text-5xl font-bold mb-6 leading-tight">
            Un soutien psychologique,
            <span class="block text-primary mt-2">
              quand vous en avez besoin 💛
            </span>
          </h1>

          <p class="opacity-80 mb-8 leading-relaxed max-w-lg">
            Un espace sûr pour parler de vos émotions et de vos préoccupations.
            Nous sommes là pour vous écouter — sans jugement, à toute heure du jour et de la nuit.
          </p>

          <!-- ОДНА кнопка -->
          <button
            @click="goHome"
            class="bg-gradient-to-r from-primary to-primary/80 text-primary-foreground 
                   px-8 py-4 rounded-full shadow-lg hover:shadow-xl transition-all
                   flex items-center gap-2 cursor-pointer"
          >
            💬 Commencer la conversation
          </button>

          <!-- Иконки -->
          <div class="mt-10 flex flex-wrap gap-6 opacity-70">
            <div class="flex items-center gap-2">
              <span class="text-2xl">🔒</span>
              <span>Confidentiel</span>
            </div>
            <div class="flex items-center gap-2">
              <span class="text-2xl">🤗</span>
              <span>Sans jugement</span>
            </div>
            <div class="flex items-center gap-2">
              <span class="text-2xl">🌟</span>
              <span>24h/24 et 7j/7</span>
            </div>
          </div>
        </div>

        <!-- Правая часть (иллюстрация чата) -->
        <div class="relative hidden lg:block">
          <div class="relative bg-gradient-to-br from-card to-accent/30 rounded-3xl p-8 shadow-2xl border border-border">
            <div class="space-y-4">

              <!-- Сообщение пользователя -->
              <div class="bg-background/80 rounded-2xl p-4 shadow-sm">
                <div class="flex items-center gap-3 ">
                  <div class="w-10 h-10 rounded-full bg-primary text-white 
                      flex items-center justify-center 
                      flex-shrink-0 leading-none text-xl">
                    😊
                  </div>
                  <p class="opacity-80">
                    J’ai du mal à gérer le stress…
                  </p>
                </div>
              </div>

              <!-- Ответ ассистента -->
              <div class="bg-primary/5 rounded-2xl p-4 shadow-sm border border-primary/10">
                <div class="flex items-start gap-3">
                 <div class="w-10 h-10 rounded-full bg-primary text-white 
                      flex items-center justify-center 
                      flex-shrink-0 leading-none text-xl">
                       🤗
                </div>
                  <p class="opacity-80 pl-2">
                    Je comprends… Trouvons ensemble des moyens de faire face à cela 💙
                  </p>
                </div>
              </div>

              <!-- typing -->
              <div class="flex items-center gap-2 px-4 py-3">
                <div class="flex gap-1.5">
                  <span class="w-2.5 h-2.5 rounded-full bg-primary animate-pulse"></span>
                  <span class="w-2.5 h-2.5 rounded-full bg-primary animate-pulse delay-150"></span>
                  <span class="w-2.5 h-2.5 rounded-full bg-primary animate-pulse delay-300"></span>
                </div>
                <span class="opacity-60 text-sm">écrit…</span>
              </div>
            </div>
          </div>

          <!-- декор -->
          <div class="absolute -top-4 -right-4 text-6xl">🌸</div>
          <div class="absolute -bottom-4 -left-4 text-5xl">💫</div>
        </div>

      </div>
    </div>
  </section>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

const goHome = () => {
  router.visit(route('conversation.index'))
}
</script>

