<template>
  <footer class="bg-gradient-to-b from-secondary/20 to-secondary/40 border-t border-border px-4 py-12">
    <div class="max-w-6xl mx-auto">

      <div class="grid md:grid-cols-4 gap-8 mb-8">

        <!-- About -->
        <div>
          <h2 class="sr-only">Pied de page</h2>

          <div class="flex items-center gap-2 mb-4">
            <span class="w-6 h-6 text-primary" role="img" aria-label="coeur">❤️</span>
            <h3>PsyBot</h3>
          </div>

          <p class="opacity-70 leading-relaxed mb-4">
            Soutien psychologique quand vous en avez besoin 
            <span role="img" aria-label="coeur jaune">💛</span>
          </p>

          <div class="flex gap-3">
            <a href="#faq" class="w-10 h-10 rounded-full bg-primary/10 hover:bg-primary/20 
                                 flex items-center justify-center transition-colors">
              <span aria-hidden="true">💬</span>
            </a>
            <a href="#about" class="w-10 h-10 rounded-full bg-primary/10 hover:bg-primary/20 
                                  flex items-center justify-center transition-colors">
              <span aria-hidden='true'>🐦</span>
            </a>
          </div>
        </div>

        <!-- Product -->
        <div>
          <h4 class="mb-4">Produit</h4>
          <ul class="space-y-3 opacity-70">
            <li>
              <a href="#features" class="hover:text-primary transition-colors">Fonctionnalités</a>
            </li>
            <li>
              <a href="#tarifs" class="hover:text-primary transition-colors">Tarifs</a>
            </li>
            <li>
              <a href="#testimonials" class="hover:text-primary transition-colors">Avis</a>
            </li>
            <li>
              <a href="#faq" class="hover:text-primary transition-colors">FAQ</a>
            </li>
          </ul>
        </div>

        <!-- Company -->
        <div>
          <h4 class="mb-4">Entreprise</h4>
          <ul class="space-y-3 opacity-70">
            <li>
              <a href="#about" class="hover:text-primary transition-colors">À propos</a>
            </li>
          </ul>
        </div>

        <!-- Support -->
        <div>
          <h4 class="mb-4">Support</h4>
          <ul class="space-y-3 opacity-70">
            <li>
              <a href="mailto:support@psybot.com" class="hover:text-primary transition-colors flex items-center gap-2">
                <span role="img" aria-label="email">📧</span> 
                support@psybot.com
              </a>
            </li>
            <li>
              <a href="#faq" class="hover:text-primary transition-colors">Centre d'aide</a>
            </li>
            <li>
              <Link :href="route('legal.terms')" class="hover:text-primary transition-colors">Conditions d'utilisation </Link>
            </li>
          </ul>
        </div>
      </div>

      <div class="pt-8 border-t border-border/50 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
  <!-- Левая часть -->
  <div class="flex flex-col w-full md:w-auto">

    <p class="opacity-60 text-sm">
      © 2025 PsyBot. Tous droits réservés. Fait avec 
      <span role="img" aria-label="coeur jaune">💛</span>
      </p>

      <p class="opacity-60 text-sm">
      <Link :href="route('legal.mentions')" class="underline hover:text-primary transition-colors">Mentions légales</Link> | 
      <Link :href="route('legal.privacy')" class="underline hover:text-primary transition-colors">Politique de confidentialité</Link>
      <span title="AI Act Transparency"></span>
      </p>

    <p class="opacity-60 text-sm pt-4">
      Vous interagissez avec une IA. Les réponses peuvent comporter des erreurs et ne remplacent pas un professionnel.
      <Link :href="route('legal.ai-act')" class="underline hover:text-primary transition-colors">En savoir plus</Link>
    </p>
  </div>

  <!-- Правая часть -->
  <div class="flex items-center gap-2 opacity-60 mt-4 md:mt-0 w-full md:w-auto">
    <span role="img" aria-label="bulle de discussion">💬</span>
    <span class="text-sm">Disponible 24/7 pour votre soutien</span>
  </div>
  
</div>
    </div>
  </footer>
</template>

<script setup>
import {Link} from '@inertiajs/vue3'
import { route } from 'ziggy-js'
</script>

