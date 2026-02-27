<template>
  <section id="focus" ref="sectionEl">

    <!-- SVG background texture -->
    <svg class="focus-bg-svg" viewBox="0 0 1440 700" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <pattern id="focusGrid" width="80" height="80" patternUnits="userSpaceOnUse">
          <path d="M 80 0 L 0 0 0 80" fill="none" stroke="rgba(255,255,255,0.02)" stroke-width="1"/>
        </pattern>
        <radialGradient id="focusGlow1" cx="15%" cy="50%" r="40%">
          <stop offset="0%" stop-color="#c9a84c" stop-opacity="0.06"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="focusGlow2" cx="85%" cy="50%" r="35%">
          <stop offset="0%" stop-color="#162d55" stop-opacity="0.8"/>
          <stop offset="100%" stop-color="#162d55" stop-opacity="0"/>
        </radialGradient>
      </defs>
      <rect width="1440" height="700" fill="url(#focusGrid)"/>
      <rect width="1440" height="700" fill="url(#focusGlow1)"/>
      <rect width="1440" height="700" fill="url(#focusGlow2)"/>

      <!-- Subtle horizontal rule lines -->
      <line x1="0" y1="1"   x2="1440" y2="1"   stroke="rgba(201,168,76,0.08)" stroke-width="1"/>
      <line x1="0" y1="699" x2="1440" y2="699" stroke="rgba(201,168,76,0.08)" stroke-width="1"/>

      <!-- Large faint monogram -->
      <text x="50%" y="58%" dominant-baseline="middle" text-anchor="middle"
        font-family="Cormorant Garamond, serif" font-size="380" font-weight="700"
        fill="rgba(255,255,255,0.015)" letter-spacing="-0.02em">BGC</text>
    </svg>

    <div class="container">

      <!-- ── Header ── -->
      <div class="section-header" :class="{ visible: revealed }">
        <div class="section-label">
          <div class="section-tag">
            <span class="tag-line"/>
            What We Work On
          </div>
          <h2 class="section-title">Our Focus Areas</h2>
        </div>
        <a href="#" class="section-link">
          Explore All
          <svg viewBox="0 0 20 20" fill="none" width="14" height="14" class="link-arrow">
            <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
          </svg>
        </a>
      </div>

      <!-- ── Cards Grid ── -->
      <div class="focus-grid">
        <div
          v-for="(card, i) in cards"
          :key="i"
          class="focus-card"
          :class="{ visible: revealed }"
          :style="{ transitionDelay: `${0.1 + i * 0.1}s` }"
          @mouseenter="hovered = i"
          @mouseleave="hovered = null"
        >
          <!-- Glass fill that rises on hover -->
          <div class="card-fill" :class="{ active: hovered === i }"/>

          <!-- Top gold border that expands -->
          <div class="card-top-border"/>

          <!-- Icon with animated ring -->
          <div class="focus-icon-wrap">
            <div class="icon-ring-outer" :class="{ spin: hovered === i }"/>
            <div class="icon-ring-inner" :class="{ spin: hovered === i }"/>
            <div class="icon-box">
              <svg viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="1.4" v-html="card.svg"/>
            </div>
            <div class="icon-glow" :class="{ active: hovered === i }"/>
          </div>

          <!-- Number label -->
          <div class="card-number">0{{ i + 1 }}</div>

          <!-- Text content -->
          <h3>{{ card.title }}</h3>
          <p>{{ card.desc }}</p>

          <!-- Count + arrow row -->
          <div class="card-footer">
            <span class="fc-count">{{ card.count }}</span>
            <span class="fc-arrow" :class="{ active: hovered === i }">
              <svg viewBox="0 0 16 16" fill="none" width="13" height="13">
                <path d="M3 8h10M8 3l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
              </svg>
            </span>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const sectionEl = ref(null)
const revealed  = ref(false)
const hovered   = ref(null)

const cards = [
  {
    title: 'Constitutional Governance',
    desc:  'Federal structure, separation of powers, and the evolving architecture of India\'s democracy.',
    count: '24 Publications',
    svg:   '<rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 17.5h7M17.5 14v7"/>',
  },
  {
    title: 'Economic Policy',
    desc:  'Fiscal federalism, public finance, employment, and inclusive growth frameworks.',
    count: '38 Publications',
    svg:   '<path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>',
  },
  {
    title: 'Foreign Affairs',
    desc:  'India\'s strategic posture, multilateral institutions, and neighbourhood diplomacy.',
    count: '19 Publications',
    svg:   '<circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10A15.3 15.3 0 0112 2z"/>',
  },
  {
    title: 'Digital Governance',
    desc:  'DPI, data regulation, AI governance, and technology\'s role in public administration.',
    count: '31 Publications',
    svg:   '<rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>',
  },
  {
    title: 'Civic Participation',
    desc:  'Electoral reforms, decentralisation, and strengthening local self-governance.',
    count: '16 Publications',
    svg:   '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>',
  },
]

let observer = null
onMounted(() => {
  observer = new IntersectionObserver(
    ([e]) => { if (e.isIntersecting) { revealed.value = true; observer.disconnect() } },
    { threshold: 0.12 }
  )
  if (sectionEl.value) observer.observe(sectionEl.value)
})
onUnmounted(() => observer?.disconnect())
</script>

<style scoped>
/* ── Section ────────────────────────────────── */
#focus {
  position: relative;
  background: #0b1c38;
  padding: 96px 0;
  overflow: hidden;
}

.focus-bg-svg {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}

.container {
  position: relative;
  z-index: 2;
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 60px;
}

/* ── Header ─────────────────────────────────── */
.section-header {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  margin-bottom: 52px;
  opacity: 0;
  transform: translateY(18px);
  transition: opacity 0.7s ease, transform 0.7s ease;
}
.section-header.visible { opacity: 1; transform: translateY(0); }

.section-label { display: flex; flex-direction: column; gap: 10px; }

.section-tag {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 10px;
  font-weight: 500;
  color: #c9a84c;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}
.tag-line { display: block; width: 24px; height: 1px; background: #c9a84c; }

.section-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 42px;
  font-weight: 600;
  color: #fff;
  line-height: 1.1;
}

.section-link {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 11px;
  font-weight: 500;
  color: #c9a84c;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  text-decoration: none;
  font-family: 'DM Sans', sans-serif;
  transition: gap 0.25s, color 0.2s;
}
.section-link:hover { gap: 14px; color: #e8cf8a; }
.link-arrow { transition: transform 0.25s; }
.section-link:hover .link-arrow { transform: translateX(4px); }

/* ── Grid ───────────────────────────────────── */
.focus-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 14px;
}

/* ── Card ───────────────────────────────────── */
.focus-card {
  position: relative;
  padding: 40px 28px 32px;
  background: rgba(255,255,255,0.07);
  border: 1px solid rgba(201,168,76,0.18);
  box-shadow: 0 4px 24px rgba(0,0,0,0.25), inset 0 1px 0 rgba(255,255,255,0.05);
  overflow: hidden;
  cursor: pointer;
  opacity: 0;
  transform: translateY(28px);
  transition:
    opacity 0.65s ease,
    transform 0.65s ease,
    background 0.3s,
    border-color 0.3s,
    box-shadow 0.3s;
}
.focus-card.visible { opacity: 1; transform: translateY(0); }
.focus-card:hover {
  background: rgba(255,255,255,0.11);
  border-color: rgba(201,168,76,0.45);
  box-shadow: 0 12px 40px rgba(0,0,0,0.35), 0 0 0 1px rgba(201,168,76,0.12), inset 0 1px 0 rgba(255,255,255,0.08);
}

/* ── Glass fill rises from bottom ── */
.card-fill {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 0%;
  background: linear-gradient(to top, rgba(201,168,76,0.08), rgba(201,168,76,0.02));
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
  transition: height 0.45s cubic-bezier(0.4, 0, 0.2, 1);
  pointer-events: none;
}
.card-fill.active { height: 100%; }

/* ── Top border expands left → right ── */
.card-top-border {
  position: absolute;
  top: 0; left: 0;
  width: 100%; height: 2px;
  background: linear-gradient(90deg, #c9a84c, #e8cf8a);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
.focus-card:hover .card-top-border { transform: scaleX(1); }

/* ── Icon ───────────────────────────────────── */
.focus-icon-wrap {
  position: relative;
  width: 52px; height: 52px;
  margin-bottom: 26px;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1;
}

.icon-ring-outer,
.icon-ring-inner {
  position: absolute;
  border-radius: 50%;
  border: 1px solid rgba(201,168,76,0.18);
  transition: border-color 0.3s;
}
.icon-ring-outer {
  inset: -8px;
  animation: ringPulse 4s ease-in-out infinite;
}
.icon-ring-inner {
  inset: -2px;
  border-color: rgba(201,168,76,0.28);
}
.icon-ring-outer.spin {
  animation: ringPulse 4s ease-in-out infinite, spinCW 12s linear infinite;
  border-color: rgba(201,168,76,0.35);
}
.icon-ring-inner.spin {
  animation: spinCCW 8s linear infinite;
  border-color: rgba(201,168,76,0.45);
}

@keyframes ringPulse {
  0%,100% { opacity: 0.5; transform: scale(1); }
  50%     { opacity: 1;   transform: scale(1.05); }
}
@keyframes spinCW  { to { transform: rotate(360deg); } }
@keyframes spinCCW { to { transform: rotate(-360deg); } }

.icon-box {
  position: relative;
  z-index: 2;
  width: 44px; height: 44px;
  border: 1px solid rgba(201,168,76,0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(201,168,76,0.1);
  transition: background 0.3s, border-color 0.3s;
}
.focus-card:hover .icon-box {
  background: rgba(201,168,76,0.2);
  border-color: rgba(201,168,76,0.7);
}
.icon-box svg { width: 20px; height: 20px; }

.icon-glow {
  position: absolute;
  inset: -12px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(201,168,76,0.2) 0%, transparent 70%);
  opacity: 0;
  transition: opacity 0.4s;
  pointer-events: none;
}
.icon-glow.active { opacity: 1; }

/* ── Card number ────────────────────────────── */
.card-number {
  position: absolute;
  top: 20px; right: 22px;
  font-family: 'DM Mono', monospace;
  font-size: 11px;
  color: rgba(201,168,76,0.2);
  letter-spacing: 0.1em;
  transition: color 0.3s;
  z-index: 1;
}
.focus-card:hover .card-number { color: rgba(201,168,76,0.5); }

/* ── Text ───────────────────────────────────── */
.focus-card h3 {
  position: relative;
  z-index: 1;
  font-family: 'Cormorant Garamond', serif;
  font-size: 21px;
  font-weight: 600;
  color: #fff;
  margin-bottom: 12px;
  line-height: 1.2;
  transition: color 0.25s;
}
.focus-card:hover h3 { color: #e8cf8a; }

.focus-card p {
  position: relative;
  z-index: 1;
  font-size: 13px;
  color: #a8b8d0;
  line-height: 1.7;
  margin-bottom: 28px;
  font-family: 'DM Sans', sans-serif;
}

/* ── Footer ─────────────────────────────────── */
.card-footer {
  position: relative;
  z-index: 1;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.fc-count {
  font-size: 10px;
  color: #c9a84c;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
  opacity: 0.7;
  transition: opacity 0.25s;
}
.focus-card:hover .fc-count { opacity: 1; }

.fc-arrow {
  display: flex;
  align-items: center;
  color: rgba(201,168,76,0.3);
  transform: translateX(0);
  transition: color 0.25s, transform 0.25s;
}
.fc-arrow.active {
  color: #c9a84c;
  transform: translateX(5px);
}

/* ── Responsive ─────────────────────────────── */
@media (max-width: 1200px) {
  .focus-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 768px) {
  .container { padding: 0 20px; }
  #focus { padding: 64px 0; }
  .focus-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; }
  .section-title { font-size: 32px; }
}
@media (max-width: 480px) {
  .focus-grid { grid-template-columns: 1fr; }
}
</style>
