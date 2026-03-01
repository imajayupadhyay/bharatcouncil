<template>
  <Head>
    <title>Work With Us | Bharat Governance Council</title>
    <meta name="description" content="Join the Bharat Governance Council through our internship programme, fellowship tracks, or membership. Work on meaningful governance research and policy with India's leading thinkers." />
    <meta property="og:title" content="Work With Us | Bharat Governance Council" />
    <meta property="og:description" content="Join BGC through internships, fellowships, or membership. Work on meaningful governance research and policy with India's leading thinkers." />
    <meta property="og:type" content="website" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Work With Us | Bharat Governance Council" />
    <meta name="twitter:description" content="Internships, fellowships, and membership opportunities at the Bharat Governance Council." />
  </Head>
  <div class="page-root">
    <AppHeader />
    <main>
      <HeroSection :activeTab="activeTab" @set-tab="setTab" />
      <div id="wwu-panels">
        <Transition name="panel-fade" mode="out-in">
          <div v-if="activeTab === 'intern'" key="intern">
            <InternProgrammeSection />
            <InternEligibilitySection />
          </div>
          <div v-else key="member">
            <MembershipSection />
            <MemberFormSection />
          </div>
        </Transition>
      </div>
      <LifeAtBGCSection />
      <WorkPoliciesSection />
    </main>
    <AppFooter />
  </div>
</template>

<script setup>
import { ref, nextTick } from 'vue'
import { Head } from '@inertiajs/vue3'
import AppHeader from '@/Components/AppHeader.vue'
import AppFooter from '@/Components/AppFooter.vue'
import HeroSection from './Components/HeroSection.vue'
import InternProgrammeSection from './Components/InternProgrammeSection.vue'
import InternEligibilitySection from './Components/InternEligibilitySection.vue'
import MembershipSection from './Components/MembershipSection.vue'
import MemberFormSection from './Components/MemberFormSection.vue'
import LifeAtBGCSection from './Components/LifeAtBGCSection.vue'
import WorkPoliciesSection from './Components/WorkPoliciesSection.vue'

const activeTab = ref('intern')

function setTab(tab) {
  activeTab.value = tab
  nextTick(() => {
    document.getElementById('wwu-panels')?.scrollIntoView({ behavior: 'smooth', block: 'start' })
  })
}
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

.panel-fade-enter-active,
.panel-fade-leave-active { transition: opacity 0.3s ease, transform 0.3s ease; }
.panel-fade-enter-from,
.panel-fade-leave-to { opacity: 0; transform: translateY(12px); }
</style>
