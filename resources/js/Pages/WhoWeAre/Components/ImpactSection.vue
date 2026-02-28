<template>
  <section id="impact" ref="sectionEl">

    <!-- ══ SVG background ══ -->
    <svg class="impact-svg-bg" viewBox="0 0 1440 400" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <pattern id="impDots" width="32" height="32" patternUnits="userSpaceOnUse">
          <circle cx="1" cy="1" r="0.5" fill="rgba(11,28,56,0.08)"/>
        </pattern>
        <linearGradient id="impLine" x1="0%" y1="0%" x2="100%" y2="0%">
          <stop offset="0%"   stop-color="rgba(11,28,56,0)"/>
          <stop offset="30%"  stop-color="rgba(11,28,56,0.12)"/>
          <stop offset="70%"  stop-color="rgba(11,28,56,0.12)"/>
          <stop offset="100%" stop-color="rgba(11,28,56,0)"/>
        </linearGradient>
      </defs>
      <rect width="1440" height="400" fill="url(#impDots)"/>
      <rect x="0" y="0"   width="1440" height="1" fill="url(#impLine)"/>
      <rect x="0" y="399" width="1440" height="1" fill="url(#impLine)"/>
      <!-- Floating particles -->
      <circle v-for="(p, i) in particles" :key="`ip${i}`"
        :cx="p.x" :cy="p.y" :r="p.r"
        :fill="`rgba(11,28,56,${p.o})`"
        :class="`pd-${(i%4)+1}`"/>
    </svg>

    <div class="container">

      <div class="sec-label" :class="{ visible: revealed }">
        <span class="sec-label-line"/><span class="sec-label-dot"/>
        <span class="sec-label-text">Impact Since 2023</span>
      </div>

      <div class="impact-header" :class="{ visible: revealed }">
        <h2 class="section-headline">Measuring <em class="headline-em">What Matters</em></h2>
      </div>

      <div class="impact-grid" :class="{ visible: revealed }">
        <div v-for="(item, i) in impactStats" :key="i" class="impact-item" :style="`--delay: ${i * 0.08}s`">
          <div class="imp-num">{{ item.num }}</div>
          <div class="imp-lbl">{{ item.label }}</div>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const sectionEl = ref(null)
const revealed  = ref(false)

const impactStats = [
  { num: '100+', label: 'Young Officers Onboarded Per Year' },
  { num: '15+',  label: 'Founding Members Across 6 Services' },
  { num: '8',    label: 'Academic Partner Institutions' },
  { num: '30+',  label: 'Avg. Years Service per Founder' },
  { num: '6',    label: 'All India Services Represented' },
]

const particles = Array.from({ length: 12 }, (_, i) => ({
  x: (i * 137.5) % 1440,
  y: (i * 53.7)  % 400,
  r: 0.5 + (i % 3) * 0.4,
  o: 0.06 + (i % 4) * 0.03,
}))

let observer = null
onMounted(() => {
  observer = new IntersectionObserver(
    ([e]) => { if (e.isIntersecting) { revealed.value = true; observer.disconnect() } },
    { threshold: 0.2 }
  )
  if (sectionEl.value) observer.observe(sectionEl.value)
})
onUnmounted(() => observer?.disconnect())
</script>

<style scoped>
#impact {
  position: relative;
  background: linear-gradient(135deg, #c9a84c 0%, #d4b35e 50%, #c9a84c 100%);
  padding: 96px 0;
  overflow: hidden;
}
.impact-svg-bg {
  position: absolute; inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}
.pd-1 { animation: d1 14s ease-in-out infinite; }
.pd-2 { animation: d2 18s ease-in-out infinite 2s; }
.pd-3 { animation: d3 12s ease-in-out infinite 4s; }
.pd-4 { animation: d4 16s ease-in-out infinite 1s; }
@keyframes d1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(8px,-10px)} }
@keyframes d2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-9px,8px)} }
@keyframes d3 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(6px,12px)} }
@keyframes d4 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-10px,-8px)} }

.container { position: relative; z-index: 2; max-width: 1280px; margin: 0 auto; padding: 0 60px; }

/* ── Sec Label ───────────────────────────────── */
.sec-label {
  display: flex; align-items: center; gap: 12px;
  margin-bottom: 20px;
  opacity: 0; transform: translateY(14px);
  transition: opacity 0.7s ease 0.05s, transform 0.7s ease 0.05s;
}
.sec-label.visible { opacity: 1; transform: translateY(0); }
.sec-label-line { display: block; width: 32px; height: 1px; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.7)); }
.sec-label-dot { display: block; width: 4px; height: 4px; border-radius: 50%; background: #fff; box-shadow: 0 0 6px rgba(255,255,255,0.5); }
.sec-label-text { font-size: 10px; font-weight: 700; color: rgba(255,255,255,0.8); letter-spacing: 0.28em; text-transform: uppercase; font-family: 'DM Sans', sans-serif; }

.impact-header {
  margin-bottom: 52px;
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.8s ease 0.15s, transform 0.8s ease 0.15s;
}
.impact-header.visible { opacity: 1; transform: translateY(0); }

.section-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2.2rem, 3.5vw, 3.4rem);
  font-weight: 600; color: #0b1c38;
  line-height: 1.08;
}
.headline-em {
  font-style: italic; color: #fff;
}

/* ── Grid ────────────────────────────────────── */
.impact-grid {
  display: grid; grid-template-columns: repeat(5, 1fr);
  gap: 24px;
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.85s ease 0.3s, transform 0.85s ease 0.3s;
}
.impact-grid.visible { opacity: 1; transform: translateY(0); }

.impact-item {
  text-align: center;
  padding: 20px 12px;
  border-radius: 2px;
  background: rgba(255,255,255,0.1);
  backdrop-filter: blur(8px);
  transition: background 0.25s, transform 0.25s;
  animation-delay: var(--delay);
}
.impact-item:hover {
  background: rgba(255,255,255,0.22);
  transform: translateY(-4px);
}

.imp-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 3.4rem; font-weight: 700;
  color: #0b1c38; line-height: 1;
  margin-bottom: 10px;
}
.imp-lbl {
  font-size: 10px; font-weight: 500;
  letter-spacing: 0.1em; text-transform: uppercase;
  color: rgba(11,28,56,0.6); line-height: 1.5;
  font-family: 'DM Sans', sans-serif;
}

/* ── Responsive ──────────────────────────────── */
@media (max-width: 1024px) { .impact-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 768px) {
  #impact { padding: 72px 0; }
  .container { padding: 0 24px; }
  .impact-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 480px) { .impact-grid { grid-template-columns: 1fr; } }
</style>
