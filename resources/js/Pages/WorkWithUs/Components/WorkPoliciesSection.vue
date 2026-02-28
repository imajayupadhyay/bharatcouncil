<template>
  <section id="work-policies" ref="sectionEl" class="policies-section">
    <div class="container">

      <!-- Header -->
      <div class="policies-header" :class="{ visible: revealed }">
        <div class="sec-label">
          <span class="sec-label-line"/><span class="sec-label-dot"/>
          <span class="sec-label-text">Work Policies</span>
        </div>
        <div class="header-row">
          <div class="header-left">
            <h2 class="section-headline">
              How We <em class="headline-em">Work</em>
            </h2>
            <p class="section-sub">BGC's work policies are designed to attract and retain people who value substance over form.</p>
          </div>
        </div>
      </div>

      <!-- Policies Grid -->
      <div class="policies-grid" :class="{ visible: revealed }">
        <div v-for="(policy, i) in policies" :key="i" class="policy-card" :style="`--delay: ${i * 0.07}s`">
          <div class="policy-card-top">
            <span class="policy-icon">{{ policy.icon }}</span>
            <span class="policy-num">{{ String(i + 1).padStart(2, '0') }}</span>
          </div>
          <h3 class="policy-title">{{ policy.title }}</h3>
          <p class="policy-body">{{ policy.body }}</p>
          <div class="policy-border"/>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const sectionEl = ref(null)
const revealed  = ref(false)

const policies = [
  {
    icon: '📋',
    title: 'Equal Opportunity Policy',
    body: 'BGC is an equal opportunity institution. Selection and evaluation are based solely on merit, demonstrated capability, and fit. No discrimination on the basis of gender, caste, religion, region, language, disability, or sexual orientation is tolerated.',
  },
  {
    icon: '🔒',
    title: 'Confidentiality & Data Policy',
    body: 'All staff and fellows sign confidentiality agreements covering policy deliberations and internal working documents. Personal data collected during applications is processed under BGC\'s Privacy Policy and is never shared with third parties.',
  },
  {
    icon: '💸',
    title: 'Transparent Remuneration',
    body: 'BGC publishes its remuneration bands for all categories of staff and fellows annually. We pay fairly relative to the not-for-profit sector and do not discriminate in pay on grounds of gender or background.',
  },
  {
    icon: '🛡️',
    title: 'POSH & Anti-Harassment Policy',
    body: 'BGC has a formal Prevention of Sexual Harassment (POSH) policy, a constituted Internal Complaints Committee, and a documented grievance redressal process. All complaints are investigated promptly and confidentially.',
  },
  {
    icon: '✍️',
    title: 'Intellectual Property & Publication',
    body: 'Research produced at BGC is attributed to the individual author(s). BGC retains institutional rights for republication and use. Fellows and researchers retain the right to publish independently — subject to standard notification to BGC\'s communications team.',
  },
  {
    icon: '🌿',
    title: 'Leave & Wellbeing',
    body: 'Full-time staff receive 24 days earned leave, 12 casual leave days, and 12 public holidays annually. BGC provides medical insurance for all full-time employees and fellows. Maternity and paternity leave policies exceed statutory requirements.',
  },
]

let observer = null
onMounted(() => {
  observer = new IntersectionObserver(
    ([e]) => { if (e.isIntersecting) { revealed.value = true; observer.disconnect() } },
    { threshold: 0.08 }
  )
  if (sectionEl.value) observer.observe(sectionEl.value)
})
onUnmounted(() => observer?.disconnect())
</script>

<style scoped>
/* ── Section ─────────────────────────────────── */
.policies-section {
  background: #f2f4f8;
  padding: 112px 0 120px;
}

.container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 60px;
}

/* ── Header ──────────────────────────────────── */
.policies-header {
  margin-bottom: 60px;
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.7s ease 0.05s, transform 0.7s ease 0.05s;
}
.policies-header.visible { opacity: 1; transform: translateY(0); }

.sec-label { display: flex; align-items: center; gap: 12px; margin-bottom: 24px; }
.sec-label-line {
  display: block; width: 32px; height: 1px;
  background: linear-gradient(90deg, transparent, #c9a84c);
}
.sec-label-dot {
  display: block; width: 4px; height: 4px; border-radius: 50%;
  background: #c9a84c; box-shadow: 0 0 6px rgba(201,168,76,0.7);
}
.sec-label-text {
  font-size: 10px; font-weight: 700;
  color: #c9a84c; letter-spacing: 0.28em; text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}

.header-row { display: flex; align-items: flex-end; justify-content: space-between; gap: 32px; }
.header-left {}

.section-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2.2rem, 3.5vw, 3.2rem);
  font-weight: 600; color: #0b1c38;
  line-height: 1.08; letter-spacing: -0.01em;
  margin-bottom: 12px;
}
.headline-em {
  font-style: italic;
  background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 45%, #c9a84c 100%);
  background-size: 200% auto;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  animation: goldShine 4s linear infinite;
}
@keyframes goldShine { 0%{background-position:0% center} 100%{background-position:200% center} }

.section-sub {
  font-size: 15px; font-weight: 300;
  color: #8a9bbf; line-height: 1.8;
  max-width: 52ch; font-family: 'DM Sans', sans-serif;
}

/* ── Policies Grid ───────────────────────────── */
.policies-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2px;
  opacity: 0; transform: translateY(28px);
  transition: opacity 0.85s ease 0.2s, transform 0.85s ease 0.2s;
}
.policies-grid.visible { opacity: 1; transform: translateY(0); }

.policy-card {
  background: #fff;
  padding: 36px 28px;
  position: relative;
  overflow: hidden;
  cursor: default;
  transition: transform 0.28s ease, box-shadow 0.28s ease;
  animation-delay: var(--delay);
}
.policy-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 48px rgba(11,28,56,0.1);
  z-index: 1;
}

.policy-card-top {
  display: flex; align-items: center;
  justify-content: space-between;
  margin-bottom: 20px;
}
.policy-icon { font-size: 26px; }
.policy-num {
  font-family: 'DM Mono', monospace;
  font-size: 10px; font-weight: 500;
  color: rgba(201,168,76,0.4); letter-spacing: 0.1em;
}

.policy-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.15rem; font-weight: 600;
  color: #0b1c38; margin-bottom: 12px; line-height: 1.2;
}
.policy-body {
  font-size: 13px; font-weight: 300;
  color: #8a9bbf; line-height: 1.78;
  font-family: 'DM Sans', sans-serif;
}

.policy-border {
  position: absolute;
  bottom: 0; left: 0;
  width: 0; height: 3px;
  background: linear-gradient(90deg, #c9a84c, #e8cf8a);
  transition: width 0.38s ease;
}
.policy-card:hover .policy-border { width: 100%; }

/* ── Responsive ──────────────────────────────── */
@media (max-width: 1200px) {
  .policies-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
  .policies-section { padding: 80px 0 88px; }
  .container { padding: 0 24px; }
  .policies-grid { grid-template-columns: 1fr; }
  .header-row { flex-direction: column; gap: 0; }
}
</style>
