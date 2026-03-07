<template>
  <Head>
    <title>{{ seo.meta_title || 'Who We Are | Bharat Governance Council' }}</title>
    <meta name="description" :content="seo.meta_description || 'Learn about the Bharat Governance Council — our story, founding team, values, and mandate to strengthen democratic governance, institutional integrity, and public policy in India.'" />
    <meta v-if="seo.meta_keywords" name="keywords" :content="seo.meta_keywords" />
    <meta property="og:title" :content="seo.meta_title || 'Who We Are | Bharat Governance Council'" />
    <meta property="og:description" :content="seo.meta_description || 'Our story, founding team, values, and mandate to strengthen democratic governance, institutional integrity, and public policy in India.'" />
    <meta property="og:type" content="website" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" :content="seo.meta_title || 'Who We Are | Bharat Governance Council'" />
    <meta name="twitter:description" :content="seo.meta_description || 'Our story, founding team, values, and mandate to strengthen democratic governance and public policy in India.'" />
  </Head>
  <div class="page-root">
    <AppHeader />
    <main>
      <HeroSection :data="sections?.hero" />
      <StorySection :data="sections?.story" />
      <FoundingTeamSection :data="sections?.founding_team" />
      <AcademicsSection :data="sections?.academics" />
      <MandateSection :data="sections?.mandate" />
      <ImpactSection :data="sections?.impact" />
      <ValuesSection :data="sections?.values" />
      <PartnersSection :data="sections?.partners" />
    </main>
    <AppFooter />
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { Head } from '@inertiajs/vue3'
import AppHeader from '@/Components/AppHeader.vue'
import AppFooter from '@/Components/AppFooter.vue'
import HeroSection from './Components/HeroSection.vue'
import StorySection from './Components/StorySection.vue'
import FoundingTeamSection from './Components/FoundingTeamSection.vue'
import AcademicsSection from './Components/AcademicsSection.vue'
import MandateSection from './Components/MandateSection.vue'
import ImpactSection from './Components/ImpactSection.vue'
import ValuesSection from './Components/ValuesSection.vue'
import PartnersSection from './Components/PartnersSection.vue'

const props = defineProps({
  sections: Object,
})

const seo = computed(() => props.sections?.seo ?? {})
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
