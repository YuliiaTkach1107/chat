<template>
  <div class="landing-page font-sans">

    <!-- Header (SEO + accessibilité) -->
    <header role="banner">
      <Hero />
    </header>

    <!-- Main content -->
    <main id="main-content" role="main">
      <section aria-labelledby="features-title">
        <Features />
      </section>
      <section aria-labelledby="pricing-title">
        <Pricing />
      </section>
      <section aria-labelledby="testimonials-title">
        <Testimonials />
      </section>
      <section aria-labelledby="faq-title">
        <FAQ />
      </section>
      <section aria-labelledby="about-title">
        <About />
      </section>
    </main>
    
    <!-- Footer -->
    <footer role="contentinfo">
      <Footer />
    </footer>
     <ThemeToggle class="theme-toggle-fixed"  />
    <!-- RGPD -->
    <CookieBanner />
  </div>
</template>

<script setup>
import Hero from '@/Components/landing/Hero.vue'
import Features from '@/Components/landing/Features.vue'
import Pricing from '@/Components/landing/Pricing.vue'
import Testimonials from '@/Components/landing/Testimonials.vue'
import FAQ from '@/Components/landing/Faq.vue'
import About from '@/Components/landing/About.vue'
import Footer from '@/Components/landing/Footer.vue'
import CookieBanner from '@/Components/CookieBanner.vue'
import { useHead } from '@vueuse/head'
import ThemeToggle from '@/components/ThemeToggle.vue'

useHead({
  title: 'PsyBot — Soutien psychologique en ligne 24/7',
  meta: [
    { name: 'description', content: 'PsyBot offre un espace sûr pour parler de vos émotions et obtenir un soutien psychologique accessible à tous, à tout moment.' },
    
    // Open Graph
    { property: 'og:title', content: 'PsyBot — Soutien psychologique en ligne 24/7' },
    { property: 'og:description', content: 'Un espace sûr pour parler de vos émotions et obtenir un soutien psychologique accessible à tous, à tout moment.' },
    { property: 'og:type', content: 'website' },
    { property: 'og:url', content: 'https://votresite.com/' },
    { property: 'og:image', content: 'https://votresite.com/preview.jpg' },

    // Twitter Card
    { name: 'twitter:card', content: 'summary_large_image' },
    { name: 'twitter:title', content: 'PsyBot — Soutien psychologique en ligne 24/7' },
    { name: 'twitter:description', content: 'Un espace sûr pour parler de vos émotions et obtenir un soutien psychologique accessible à tous, à tout moment.' },
    { name: 'twitter:image', content: 'https://votresite.com/preview.jpg' }
  ],
  script: [
    {
      type: 'application/ld+json',
      children: JSON.stringify({
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "PsyBot",
        "url": "https://votresite.com/",
        "potentialAction": {
          "@type": "SearchAction",
          "target": "https://votresite.com/?s={search_term_string}",
          "query-input": "required name=search_term_string"
        }
      })
    }
  ]
})
</script>

<style scoped>
body {
  margin: 0;
}
.landing-page {
  display: flex;
  flex-direction: column;
}

.theme-toggle-fixed {
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 50;
  background: var(--card);
  border: 1px solid var(--border);
  width: 48px;
  height: 48px;
  border-radius: 9999px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  transition: background 0.2s, transform 0.2s;
}

.theme-toggle-fixed:hover {
  background: var(--accent);
  transform: scale(1.05);
}


</style>
