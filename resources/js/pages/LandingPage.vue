<template>
  <div class="landing-page font-sans">
    <Hero />
    <Features />
    <Pricing />
    <Testimonials />
    <Faq />
    <About />
    <Footer />
  </div>
</template>

<script setup>
import Hero from '@/Components/landing/Hero.vue'
import Features from '@/Components/landing/Features.vue'
import Pricing from '@/Components/landing/Pricing.vue'
import Testimonials from '@/Components/landing/Testimonials.vue'
import FAQ from '@/Components/landing/FAQ.vue'
import About from '@/Components/landing/About.vue'
import Footer from '@/Components/landing/Footer.vue'
</script>

<style scoped>
body {
  margin: 0;
}
.landing-page {
  display: flex;
  flex-direction: column;
  gap: 8rem;
}
</style>
