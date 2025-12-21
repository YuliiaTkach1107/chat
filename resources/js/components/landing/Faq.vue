<template>
  <section id="faq" class="faq py-20" aria-labelledby="faq-title">
    <div class="max-w-3xl mx-auto text-center mb-16 fade-in">
      <div class="inline-flex items-center gap-2 bg-primary/10 border border-primary/20 rounded-full px-4 py-2 mb-4">
        <span class="opacity-80">FAQ</span>
      </div>
      <h2 id="faq-title" class="text-3xl font-bold mb-4">Questions fréquentes
        <span role="img" aria-label="bulle de réflexion">💭</span>
      </h2>
      <p class="opacity-70 leading-relaxed">
        Réponses aux questions les plus populaires sur notre service
      </p>
    </div>

    <div class="max-w-3xl mx-auto space-y-4">
      <article
        v-for="(faq, index) in faqs"
        :key="index"
        class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden transition-all hover:shadow-md"
      >
      <h3>
        <!-- Question -->
        <button
          @click="toggleFAQ(index)"
          class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-primary/2 transition-colors"
          :aria-expanded="openIndex === index"
          :aria-controls="`faq-answer-${index}`"
        >
        
          <span class="font-medium">{{ faq.question }}</span>
          <div class="w-8 h-8 rounded-full bg-primary/15 flex items-center justify-center"
          >
            <span v-if="openIndex === index">−</span>
            <span v-else>+</span>
          </div>
        </button>
        </h3>

        <!-- Réponse -->
        <div
          class="px-6 overflow-hidden transition-all duration-300"
          :style="{ maxHeight: openIndex === index ? '500px' : '0', opacity: openIndex === index ? 1 : 0 }"
          :id="`faq-answer-${index}`"
          role="region"
          :aria-labelledby="`faq-question-${index}`"
        >
          <p class="opacity-80 leading-relaxed mb-3 mt-3">{{ faq.answer }}</p>
        </div>
      </article>
    </div>

    <!-- Contact -->
    <div class="mt-12 text-center bg-gradient-to-r from-accent/60 to-primary/10 border border-primary/20 rounded-2xl p-6 fade-in">
      <p class="opacity-80">
        <span class="text-2xl mr-2" role="img" aria-label="bulle de discussion">💬</span>
        Vous n'avez pas trouvé de réponse ? Écrivez-nous à
        <a href="mailto:support@psybot.com" class="text-primary hover:underline">support@psybot.com</a>
      </p>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const faqs = [
  {
    question: 'Est-ce un remplacement d’un vrai psychologue ?',
    answer: 'Non, nous ne remplaçons pas l’aide psychologique professionnelle. Notre service fournit un soutien supplémentaire pour les situations quotidiennes, lorsque vous avez besoin de parler ou de clarifier vos pensées. En cas de problèmes sérieux, nous recommandons toujours de consulter un spécialiste.'
  },
  {
    question: 'Mes conversations sont-elles confidentielles ?',
    answer: 'Absolument confidentielles. Nous utilisons le cryptage des données et personne d’autre que vous n’a accès à vos conversations. Nous ne partageons pas vos informations avec des tiers et ne les utilisons pas à des fins publicitaires.'
  },
  {
    question: 'Puis-je utiliser le service gratuitement ?',
    answer: 'Oui ! Le plan de base est entièrement gratuit et inclut des conversations illimitées avec support 24/7. Les plans payants offrent des fonctionnalités supplémentaires, comme l’historique illimité des chats et des recommandations personnalisées.'
  },
  {
    question: 'Comment fonctionne l’assistant IA ?',
    answer: 'Notre IA est formée sur des méthodes d’écoute empathique et de thérapie cognitivo-comportementale. Elle analyse vos messages et propose des réponses empathiques et soutenantes pour vous aider à comprendre vos sentiments et pensées.'
  },
  {
    question: 'Puis-je annuler mon abonnement à tout moment ?',
    answer: 'Bien sûr ! Vous pouvez annuler votre abonnement à tout moment sans pénalité. Après l’annulation, vous garderez l’accès aux fonctionnalités payantes jusqu’à la fin de la période payée, puis vous passerez automatiquement au plan gratuit.'
  },
  {
    question: 'Y a-t-il des restrictions d’âge ?',
    answer: 'Notre service est destiné aux personnes de plus de 16 ans. Pour les utilisateurs de moins de 18 ans, nous recommandons d’utiliser le service avec l’accord d’un parent ou tuteur.'
  }
]

const openIndex = ref(null)

function toggleFAQ(index) {
  openIndex.value = openIndex.value === index ? null : index
}
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
