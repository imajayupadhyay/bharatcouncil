<template>
  <Head>
    <title>Bharat Governance Council | Strengthening India's Governance</title>
    <meta name="description" content="Bharat Governance Council is India's premier governance think tank fostering evidence-based policy, civic engagement, and institutional reform. Explore insights, events, and opportunities to shape India's future." />
    <meta property="og:title" content="Bharat Governance Council | Strengthening India's Governance" />
    <meta property="og:description" content="Bharat Governance Council is India's premier governance think tank fostering evidence-based policy, civic engagement, and institutional reform." />
    <meta property="og:type" content="website" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Bharat Governance Council | Strengthening India's Governance" />
    <meta name="twitter:description" content="India's premier governance think tank fostering evidence-based policy, civic engagement, and institutional reform." />
  </Head>
  <div class="page-root">
    <AppHeader />
    <main>
      <HeroSection />
      <FeaturedSection />
      <FocusSection />
      <EventsSection />
      <VoicesSection />
      <PublicationsSection />
      <DiscussionsSection />
      <NewsletterSection />
    </main>
    <AppFooter />
  </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import AppHeader from '@/Components/AppHeader.vue'
import HeroSection from './Components/HeroSection.vue'
import FeaturedSection from './Components/FeaturedSection.vue'
import FocusSection from './Components/FocusSection.vue'
import EventsSection from './Components/EventsSection.vue'
import VoicesSection from './Components/VoicesSection.vue'
import PublicationsSection from './Components/PublicationsSection.vue'
import DiscussionsSection from './Components/DiscussionsSection.vue'
import NewsletterSection from './Components/NewsletterSection.vue'
import AppFooter from '@/Components/AppFooter.vue'
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap');

:root {
  --navy:    #0b1c38;
  --navy-2:  #0f2347;
  --navy-3:  #162d55;
  --gold:    #c9a84c;
  --gold-lt: #e8cf8a;
  --silver:  #b8c5d8;
  --white:   #f5f7fa;
  --grey-1:  #e8eaf0;
  --grey-2:  #8a9bbf;
  --body-bg: #f2f4f8;
}

html { scroll-behavior: smooth; }

body {
  font-family: 'DM Sans', sans-serif;
  background: var(--body-bg);
  color: var(--navy);
  overflow-x: hidden;
}

::-webkit-scrollbar { width: 5px; }
::-webkit-scrollbar-track { background: var(--navy); }
::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 2px; }

* { box-sizing: border-box; margin: 0; padding: 0; }
</style>

<style scoped>
.page-root { min-height: 100vh; }
</style>
