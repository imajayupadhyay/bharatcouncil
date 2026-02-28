<template>
  <section id="mandate" ref="sectionEl">
    <div class="container">

      <div class="sec-label" :class="{ visible: revealed }">
        <span class="sec-label-line"/><span class="sec-label-dot"/>
        <span class="sec-label-text">What We Do</span>
      </div>

      <div class="mandate-header" :class="{ visible: revealed }">
        <h2 class="section-headline">Our <em class="headline-em">Mandate</em></h2>
      </div>

      <div class="mandate-grid" :class="{ visible: revealed }">
        <div v-for="(item, i) in mandates" :key="i" class="mand-card" :style="`--delay: ${i * 0.07}s`">
          <div class="mand-num">{{ String(i + 1).padStart(2, '0') }}</div>
          <h3 class="mand-title">{{ item.title }}</h3>
          <p class="mand-body">{{ item.body }}</p>
          <div class="mand-fill"/>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const sectionEl = ref(null)
const revealed  = ref(false)

const mandates = [
  { title: 'Mentoring Young Civil Servants', body: 'Our flagship programme onboards 100+ younger IAS, IPS, IFS and allied officers each year into structured mentorship with our founding members — veterans who held the same roles and faced the same dilemmas, decades earlier.' },
  { title: 'Governance Research', body: 'BGC produces practitioner-led research on India\'s most urgent governance challenges — state capacity, public finance, federalism, civil service reform — grounded in administrative experience, not just academic theory.' },
  { title: 'Policy Dialogue', body: 'Through curated roundtables, working groups, and deliberative forums, BGC convenes serving and retired officers, academics, and civil society to produce actionable consensus on governance questions that resist political resolution.' },
  { title: 'Institutional Memory', body: 'We systematically document the administrative wisdom — decision frameworks, ethical dilemmas, case studies — of India\'s senior civil servants, creating a living archive for future generations of officers.' },
  { title: 'Climate & Environmental Governance', body: 'With a former DG Forests and a UN Climate Parliament advisor among our founders, BGC has a dedicated track on India\'s climate governance architecture, forest rights, and green federalism.' },
  { title: 'Global Engagement', body: 'Our diplomatic founders enable substantive engagement with international governance networks — connecting India\'s domestic governance challenges to comparative experiences from the Global South and multilateral institutions.' },
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
#mandate {
  background: #e8eaf0;
  padding: 112px 0;
}
.container { max-width: 1280px; margin: 0 auto; padding: 0 60px; }

/* ── Sec Label ───────────────────────────────── */
.sec-label {
  display: flex; align-items: center; gap: 12px;
  margin-bottom: 28px;
  opacity: 0; transform: translateY(14px);
  transition: opacity 0.7s ease 0.05s, transform 0.7s ease 0.05s;
}
.sec-label.visible { opacity: 1; transform: translateY(0); }
.sec-label-line { display: block; width: 32px; height: 1px; background: linear-gradient(90deg, transparent, #c9a84c); }
.sec-label-dot { display: block; width: 4px; height: 4px; border-radius: 50%; background: #c9a84c; box-shadow: 0 0 6px rgba(201,168,76,0.7); }
.sec-label-text { font-size: 10px; font-weight: 700; color: #c9a84c; letter-spacing: 0.28em; text-transform: uppercase; font-family: 'DM Sans', sans-serif; }

.mandate-header {
  margin-bottom: 48px;
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.8s ease 0.15s, transform 0.8s ease 0.15s;
}
.mandate-header.visible { opacity: 1; transform: translateY(0); }

.section-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2rem, 3.2vw, 3rem);
  font-weight: 600; color: #0b1c38;
  line-height: 1.12; margin-bottom: 14px;
}
.headline-em {
  font-style: italic;
  background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 45%, #c9a84c 100%);
  background-size: 200% auto;
  -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  background-clip: text; animation: goldShine 4s linear infinite;
}
@keyframes goldShine { 0%{background-position:0% center} 100%{background-position:200% center} }

/* ── Grid ────────────────────────────────────── */
.mandate-grid {
  display: grid; grid-template-columns: repeat(3, 1fr);
  gap: 2px;
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.85s ease 0.28s, transform 0.85s ease 0.28s;
}
.mandate-grid.visible { opacity: 1; transform: translateY(0); }

.mand-card {
  background: #fff;
  padding: 40px 28px;
  position: relative; overflow: hidden;
  cursor: default;
  transition: box-shadow 0.28s;
  animation-delay: var(--delay);
}
.mand-card:hover { box-shadow: 0 16px 44px rgba(11,28,56,0.1); z-index: 1; }

.mand-fill {
  position: absolute; inset: 0;
  background: #0b1c38;
  transform: scaleY(0); transform-origin: bottom;
  transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
  z-index: 0;
}
.mand-card:hover .mand-fill { transform: scaleY(1); }

.mand-card:hover .mand-num { color: rgba(255,255,255,0.04) !important; }
.mand-card:hover .mand-title { color: #f5f7fa; }
.mand-card:hover .mand-body { color: rgba(184,197,216,0.7); }

.mand-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 4.5rem; font-weight: 700; line-height: 1;
  color: rgba(11,28,56,0.05); letter-spacing: -0.02em;
  margin-bottom: -6px;
  position: relative; z-index: 1;
  transition: color 0.3s;
}
.mand-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.3rem; font-weight: 600;
  color: #0b1c38; margin-bottom: 12px;
  position: relative; z-index: 1;
  transition: color 0.3s;
}
.mand-body {
  font-size: 13px; font-weight: 300;
  color: #8a9bbf; line-height: 1.78;
  font-family: 'DM Sans', sans-serif;
  position: relative; z-index: 1;
  transition: color 0.3s;
}

/* ── Responsive ──────────────────────────────── */
@media (max-width: 1024px) { .mandate-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
  #mandate { padding: 80px 0; }
  .container { padding: 0 24px; }
  .mandate-grid { grid-template-columns: 1fr; }
}
</style>
