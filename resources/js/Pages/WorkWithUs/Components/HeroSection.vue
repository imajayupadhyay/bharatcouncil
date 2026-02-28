<template>
  <section id="wwu-hero" ref="heroEl">

    <!-- ══ SVG animated background ══ -->
    <svg class="hero-svg-bg" viewBox="0 0 1440 780" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <pattern id="wwuGrid" width="90" height="90" patternUnits="userSpaceOnUse">
          <path d="M 90 0 L 0 0 0 90" fill="none" stroke="rgba(255,255,255,0.025)" stroke-width="1"/>
        </pattern>
        <radialGradient id="wwuGlow1" cx="72%" cy="40%" r="40%">
          <stop offset="0%" stop-color="#c9a84c" stop-opacity="0.09"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="wwuGlow2" cx="8%" cy="90%" r="35%">
          <stop offset="0%" stop-color="#162d55" stop-opacity="0.9"/>
          <stop offset="100%" stop-color="#162d55" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="wwuGlowC" cx="55%" cy="45%" r="32%">
          <stop offset="0%" stop-color="#c9a84c" stop-opacity="0.04"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
        <filter id="wwuBlur4"><feGaussianBlur stdDeviation="4"/></filter>
        <filter id="wwuBlur2"><feGaussianBlur stdDeviation="2"/></filter>
      </defs>

      <rect width="1440" height="780" fill="url(#wwuGrid)"/>
      <rect width="1440" height="780" fill="url(#wwuGlow1)"/>
      <rect width="1440" height="780" fill="url(#wwuGlow2)"/>
      <rect width="1440" height="780" fill="url(#wwuGlowC)"/>

      <!-- Ashoka-inspired rings (right side) -->
      <g class="rings-group" transform="translate(1100, 360)">
        <circle r="290" fill="none" stroke="rgba(201,168,76,0.06)" stroke-width="1"/>
        <circle r="290" fill="none" stroke="rgba(201,168,76,0.12)" stroke-width="0.5" stroke-dasharray="4 28" class="ring-spin-slow"/>
        <circle r="210" fill="none" stroke="rgba(201,168,76,0.08)" stroke-width="1"/>
        <circle r="210" fill="none" stroke="rgba(201,168,76,0.18)" stroke-width="0.5" stroke-dasharray="3 18" class="ring-spin-mid"/>
        <circle r="140" fill="none" stroke="rgba(201,168,76,0.10)" stroke-width="1"/>
        <circle r="140" fill="none" stroke="rgba(201,168,76,0.22)" stroke-width="0.5" stroke-dasharray="2 12" class="ring-spin-fast"/>
        <circle r="60" fill="none" stroke="rgba(201,168,76,0.15)" stroke-width="1.5"/>
        <circle r="60" fill="rgba(201,168,76,0.03)" filter="url(#wwuBlur4)"/>
        <circle r="6" fill="rgba(201,168,76,0.5)" class="core-pulse" filter="url(#wwuBlur2)"/>
        <g class="ring-spin-slow">
          <circle v-for="i in 24" :key="`s1-${i}`"
            :cx="290 * Math.cos((i-1) * 15 * Math.PI / 180)"
            :cy="290 * Math.sin((i-1) * 15 * Math.PI / 180)"
            r="1.5" fill="rgba(201,168,76,0.35)"/>
        </g>
        <g class="ring-spin-mid-rev">
          <circle v-for="i in 16" :key="`s2-${i}`"
            :cx="210 * Math.cos((i-1) * 22.5 * Math.PI / 180)"
            :cy="210 * Math.sin((i-1) * 22.5 * Math.PI / 180)"
            r="2" fill="rgba(201,168,76,0.4)"/>
        </g>
        <g class="ring-spin-fast-rev">
          <circle v-for="i in 12" :key="`s3-${i}`"
            :cx="140 * Math.cos((i-1) * 30 * Math.PI / 180)"
            :cy="140 * Math.sin((i-1) * 30 * Math.PI / 180)"
            r="2.5" fill="rgba(201,168,76,0.5)"/>
        </g>
      </g>

      <!-- Constellation nodes -->
      <g class="constellation">
        <line v-for="(edge, i) in constellationEdges" :key="`e${i}`"
          :x1="constellationNodes[edge[0]].x" :y1="constellationNodes[edge[0]].y"
          :x2="constellationNodes[edge[1]].x" :y2="constellationNodes[edge[1]].y"
          stroke="rgba(201,168,76,0.1)" stroke-width="0.7"
          :class="`edge-pulse-${(i % 4) + 1}`"/>
        <g v-for="(node, i) in constellationNodes" :key="`n${i}`">
          <circle :cx="node.x" :cy="node.y" r="3" fill="rgba(201,168,76,0.08)" :class="`node-float-${(i % 3) + 1}`"/>
          <circle :cx="node.x" :cy="node.y" r="1.5" fill="rgba(201,168,76,0.5)" :class="`node-float-${(i % 3) + 1}`"/>
        </g>
      </g>

      <!-- Floating particles -->
      <circle v-for="(p, i) in particles" :key="`p${i}`"
        :cx="p.x" :cy="p.y" :r="p.r"
        :fill="`rgba(201,168,76,${p.o})`"
        :class="`particle-drift-${(i % 5) + 1}`"/>

      <!-- Diagonal accents -->
      <line x1="-20" y1="180" x2="180" y2="-20" stroke="rgba(201,168,76,0.05)" stroke-width="1"/>
      <line x1="-20" y1="320" x2="320" y2="-20" stroke="rgba(201,168,76,0.03)" stroke-width="1"/>
    </svg>

    <!-- ══ Main Content ══ -->
    <div class="hero-inner">

      <!-- Breadcrumb -->
      <nav class="hero-breadcrumb" :class="{ visible: revealed }">
        <a href="/">Home</a>
        <span class="bc-sep">/</span>
        <span class="bc-current">Work With Us</span>
      </nav>

      <!-- Eyebrow -->
      <div class="hero-eyebrow" :class="{ visible: revealed }">
        <span class="eyebrow-line"/>
        <span class="eyebrow-dot"/>
        <span class="eyebrow-text">Opportunities at BGC</span>
        <span class="eyebrow-tag">Join Us</span>
      </div>

      <!-- Headline -->
      <h1 class="hero-headline" :class="{ visible: revealed }">
        <span class="hl-line-1">Build Your Career at the</span><br>
        <em class="hl-line-2">Heart of Indian Governance</em>
      </h1>

      <!-- Sub -->
      <p class="hero-sub" :class="{ visible: revealed }">
        BGC is a collegial, intellectually rigorous institution where capable people are trusted with
        real work that matters. Every person here has direct access to India's most experienced
        governance practitioners — and is expected to contribute, not observe.
      </p>

      <!-- Award Badge -->
      <div class="award-badge" :class="{ visible: revealed }">
        <div class="award-shimmer"/>
        <span class="award-icon">🏆</span>
        <div class="award-content">
          <strong class="award-title">Best Place to Work — Not for Profit Category</strong>
          <span class="award-sub">Economic Times Best Workplaces · 2024 · Collegial culture, intellectual freedom &amp; staff wellbeing</span>
        </div>
      </div>

    </div>

    <!-- ══ Tab Navigation ══ -->
    <div class="tab-nav" :class="{ visible: revealed }">
      <div class="tab-nav-inner">
        <button
          class="tab-btn"
          :class="{ active: activeTab === 'intern' }"
          @click="$emit('set-tab', 'intern')"
        >
          <span class="tab-num">01</span>
          <span class="tab-label">Work as an Intern</span>
          <svg class="tab-arrow" viewBox="0 0 20 20" fill="none" width="14" height="14">
            <path d="M10 4v12M5 11l5 5 5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
        <span class="tab-divider"/>
        <button
          class="tab-btn"
          :class="{ active: activeTab === 'member' }"
          @click="$emit('set-tab', 'member')"
        >
          <span class="tab-num">02</span>
          <span class="tab-label">Work as a Member</span>
          <svg class="tab-arrow" viewBox="0 0 20 20" fill="none" width="14" height="14">
            <path d="M10 4v12M5 11l5 5 5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- Bottom gold bar -->
    <div class="hero-gold-bar">
      <div class="gold-bar-shimmer"/>
    </div>

  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const props = defineProps({
  activeTab: { type: String, default: 'intern' }
})

defineEmits(['set-tab'])

const heroEl  = ref(null)
const revealed = ref(false)

const constellationNodes = [
  { x: 80,  y: 160 }, { x: 180, y: 80  }, { x: 280, y: 240 },
  { x: 140, y: 360 }, { x: 320, y: 140 }, { x: 60,  y: 480 },
  { x: 240, y: 450 }, { x: 380, y: 310 }, { x: 160, y: 580 },
  { x: 400, y: 460 }, { x: 500, y: 180 }, { x: 480, y: 400 },
  { x: 560, y: 560 }, { x: 620, y: 110 }, { x: 700, y: 320 },
  { x: 640, y: 470 }, { x: 750, y: 640 }, { x: 820, y: 240 },
]
const constellationEdges = [
  [0,1],[1,4],[4,10],[10,13],[13,17],[17,14],[14,11],[11,9],
  [9,12],[12,15],[15,8],[8,6],[6,3],[3,0],[2,4],[2,7],[7,14],
  [5,3],[5,8],[16,12],[16,15],
]

const particles = Array.from({ length: 32 }, (_, i) => ({
  x: (i * 137.5) % 1440,
  y: (i * 97.3)  % 780,
  r: 0.8 + (i % 4) * 0.6,
  o: 0.12 + (i % 5) * 0.07,
}))

onMounted(() => {
  requestAnimationFrame(() => {
    setTimeout(() => { revealed.value = true }, 100)
  })
})
</script>

<style scoped>
/* ── Section ─────────────────────────────────── */
#wwu-hero {
  position: relative;
  background: #0b1c38;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding-top: 72px; /* nav height */
  min-height: 86vh;
}

/* ── SVG Background ──────────────────────────── */
.hero-svg-bg {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}

/* Rings */
.rings-group { }
.ring-spin-slow     { animation: spinCW  40s linear infinite; transform-origin: 0 0; }
.ring-spin-mid      { animation: spinCCW 28s linear infinite; transform-origin: 0 0; }
.ring-spin-fast     { animation: spinCW  18s linear infinite; transform-origin: 0 0; }
.ring-spin-mid-rev  { animation: spinCCW 32s linear infinite; transform-origin: 0 0; }
.ring-spin-fast-rev { animation: spinCW  22s linear infinite; transform-origin: 0 0; }
@keyframes spinCW  { to { transform: rotate(360deg);  } }
@keyframes spinCCW { to { transform: rotate(-360deg); } }

.core-pulse { animation: corePulse 2.4s ease-in-out infinite; }
@keyframes corePulse {
  0%,100% { r: 6;  opacity: 0.5;  }
  50%     { r: 14; opacity: 0.15; }
}

/* Constellation */
.edge-pulse-1 { animation: edgeFade 3.8s ease-in-out infinite 0.0s; }
.edge-pulse-2 { animation: edgeFade 3.8s ease-in-out infinite 0.9s; }
.edge-pulse-3 { animation: edgeFade 3.8s ease-in-out infinite 1.8s; }
.edge-pulse-4 { animation: edgeFade 3.8s ease-in-out infinite 2.7s; }
@keyframes edgeFade { 0%,100%{opacity:0.3} 50%{opacity:1} }

.node-float-1 { animation: nodeFloat 6s ease-in-out infinite 0.0s; }
.node-float-2 { animation: nodeFloat 7s ease-in-out infinite 1.2s; }
.node-float-3 { animation: nodeFloat 8s ease-in-out infinite 2.4s; }
@keyframes nodeFloat {
  0%,100%{transform:translate(0,0)} 33%{transform:translate(3px,-4px)} 66%{transform:translate(-3px,2px)}
}

/* Particles */
.particle-drift-1 { animation: drift1 14s ease-in-out infinite; }
.particle-drift-2 { animation: drift2 18s ease-in-out infinite 2s; }
.particle-drift-3 { animation: drift3 12s ease-in-out infinite 4s; }
.particle-drift-4 { animation: drift4 20s ease-in-out infinite 1s; }
.particle-drift-5 { animation: drift5 16s ease-in-out infinite 3s; }
@keyframes drift1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(8px,-12px)} }
@keyframes drift2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-10px,8px)} }
@keyframes drift3 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(6px,14px)} }
@keyframes drift4 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-8px,-10px)} }
@keyframes drift5 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(12px,6px)} }

/* ── Hero Inner ─────────────────────────────── */
.hero-inner {
  position: relative;
  z-index: 2;
  max-width: 1280px;
  margin: 0 auto;
  padding: 48px 60px 56px;
  width: 100%;
}

/* ── Breadcrumb ─────────────────────────────── */
.hero-breadcrumb {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 40px;
  opacity: 0;
  transition: opacity 0.6s ease 0.05s;
}
.hero-breadcrumb.visible { opacity: 1; }
.hero-breadcrumb a {
  font-size: 11px;
  font-family: 'DM Sans', sans-serif;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: rgba(184,197,216,0.45);
  text-decoration: none;
  transition: color 0.2s;
}
.hero-breadcrumb a:hover { color: rgba(184,197,216,0.8); }
.bc-sep {
  font-size: 10px;
  color: rgba(184,197,216,0.25);
}
.bc-current {
  font-size: 11px;
  font-family: 'DM Sans', sans-serif;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: rgba(201,168,76,0.75);
}

/* ── Eyebrow ─────────────────────────────────── */
.hero-eyebrow {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 28px;
  opacity: 0;
  transform: translateY(16px);
  transition: opacity 0.7s ease 0.12s, transform 0.7s ease 0.12s;
}
.hero-eyebrow.visible { opacity: 1; transform: translateY(0); }

.eyebrow-line {
  display: block; width: 36px; height: 1px;
  background: linear-gradient(90deg, transparent, #c9a84c);
}
.eyebrow-dot {
  display: block; width: 4px; height: 4px; border-radius: 50%;
  background: #c9a84c;
  box-shadow: 0 0 6px rgba(201,168,76,0.8);
  animation: dotPulse 2s ease-in-out infinite;
}
@keyframes dotPulse {
  0%,100% { box-shadow: 0 0 6px rgba(201,168,76,0.8); }
  50%     { box-shadow: 0 0 14px rgba(201,168,76,1); }
}
.eyebrow-text {
  font-size: 11px; font-weight: 500;
  color: #c9a84c; letter-spacing: 0.3em; text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}
.eyebrow-tag {
  font-size: 9px; font-weight: 600;
  color: #0b1c38; background: rgba(201,168,76,0.85);
  letter-spacing: 0.2em; text-transform: uppercase;
  padding: 2px 8px; font-family: 'DM Mono', monospace;
}

/* ── Headline ─────────────────────────────────── */
.hero-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(48px, 5.8vw, 88px);
  font-weight: 600;
  color: #fff;
  line-height: 1.05;
  letter-spacing: -0.01em;
  margin-bottom: 24px;
  opacity: 0;
  transform: translateY(24px);
  transition: opacity 0.8s ease 0.28s, transform 0.8s ease 0.28s;
}
.hero-headline.visible { opacity: 1; transform: translateY(0); }

.hl-line-1 { display: inline-block; color: #fff; }
.hl-line-2 {
  font-style: italic;
  background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 45%, #c9a84c 100%);
  background-size: 200% auto;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  animation: goldShine 4s linear infinite;
}
@keyframes goldShine {
  0%   { background-position: 0% center; }
  100% { background-position: 200% center; }
}

/* ── Sub ─────────────────────────────────────── */
.hero-sub {
  font-size: 16px; font-weight: 300;
  color: #b8c5d8; line-height: 1.8;
  max-width: 600px; margin-bottom: 40px;
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.8s ease 0.44s, transform 0.8s ease 0.44s;
  font-family: 'DM Sans', sans-serif;
}
.hero-sub.visible { opacity: 1; transform: translateY(0); }

/* ── Award Badge ─────────────────────────────── */
.award-badge {
  position: relative;
  display: inline-flex;
  align-items: center;
  gap: 16px;
  background: rgba(201,168,76,0.08);
  border: 1px solid rgba(201,168,76,0.25);
  padding: 16px 24px;
  overflow: hidden;
  opacity: 0;
  transform: translateY(16px);
  transition: opacity 0.7s ease 0.6s, transform 0.7s ease 0.6s;
}
.award-badge.visible { opacity: 1; transform: translateY(0); }
.award-badge:hover { border-color: rgba(201,168,76,0.45); background: rgba(201,168,76,0.12); }

.award-shimmer {
  position: absolute; inset: 0;
  background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.06) 50%, transparent 60%);
  transform: translateX(-100%);
  transition: transform 0s;
}
.award-badge:hover .award-shimmer {
  transform: translateX(100%); transition: transform 0.6s ease;
}

.award-icon { font-size: 22px; flex-shrink: 0; }
.award-content { display: flex; flex-direction: column; gap: 4px; }
.award-title {
  display: block; font-size: 11px; font-weight: 700;
  letter-spacing: 0.08em; text-transform: uppercase;
  color: #c9a84c; font-family: 'DM Sans', sans-serif;
}
.award-sub {
  font-size: 12px; color: rgba(184,197,216,0.6);
  font-weight: 300; font-family: 'DM Sans', sans-serif;
}

/* ── Tab Navigation ──────────────────────────── */
.tab-nav {
  position: relative; z-index: 2;
  border-top: 1px solid rgba(255,255,255,0.07);
  opacity: 0; transform: translateY(12px);
  transition: opacity 0.7s ease 0.76s, transform 0.7s ease 0.76s;
}
.tab-nav.visible { opacity: 1; transform: translateY(0); }

.tab-nav-inner {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 60px;
  display: flex;
  gap: 2px;
}

.tab-btn {
  flex: 1;
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 22px 32px;
  background: rgba(255,255,255,0.025);
  border: none;
  border-bottom: 3px solid transparent;
  cursor: pointer;
  text-align: left;
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.3rem;
  font-weight: 600;
  color: rgba(245,247,250,0.38);
  letter-spacing: 0.01em;
  transition: all 0.25s ease;
  position: relative;
  overflow: hidden;
}
.tab-btn:hover:not(.active) {
  background: rgba(255,255,255,0.05);
  color: rgba(245,247,250,0.65);
}
.tab-btn.active {
  background: rgba(201,168,76,0.05);
  color: #f5f7fa;
  border-bottom-color: #c9a84c;
}
.tab-num {
  font-size: 10px; font-weight: 700;
  letter-spacing: 0.22em; text-transform: uppercase;
  color: #c9a84c; font-family: 'DM Mono', monospace;
  flex-shrink: 0;
}
.tab-label { flex: 1; }
.tab-arrow {
  margin-left: auto;
  opacity: 0;
  transform: translateY(-4px);
  transition: opacity 0.25s, transform 0.25s;
  color: #c9a84c;
}
.tab-btn.active .tab-arrow,
.tab-btn:hover .tab-arrow {
  opacity: 1; transform: translateY(0);
}
.tab-divider {
  display: block;
  width: 1px;
  background: rgba(255,255,255,0.06);
  align-self: stretch;
}

/* ── Bottom gold bar ─────────────────────────── */
.hero-gold-bar {
  position: absolute;
  bottom: 0; left: 0; right: 0; height: 3px;
  background: linear-gradient(90deg, #c9a84c 0%, #e8cf8a 30%, rgba(201,168,76,0.15) 70%, transparent 100%);
  overflow: hidden;
}
.gold-bar-shimmer {
  position: absolute; inset: 0;
  background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.6) 50%, transparent 100%);
  animation: barShimmer 3s ease-in-out infinite;
}
@keyframes barShimmer {
  0%   { transform: translateX(-100%); }
  100% { transform: translateX(400%); }
}

/* ── Responsive ──────────────────────────────── */
@media (max-width: 1024px) {
  .hero-inner { padding: 48px 32px 56px; }
  .tab-nav-inner { padding: 0 32px; }
  .rings-group { display: none; }
}
@media (max-width: 768px) {
  #wwu-hero { min-height: auto; padding-top: 72px; }
  .hero-inner { padding: 40px 20px 48px; }
  .tab-nav-inner { padding: 0; flex-direction: column; gap: 0; }
  .tab-btn { font-size: 1.1rem; padding: 18px 20px; }
  .tab-divider { width: 100%; height: 1px; align-self: auto; }
  .award-badge { flex-direction: column; align-items: flex-start; gap: 10px; }
}
@media (max-width: 480px) {
  .hero-headline { font-size: 38px; }
  .eyebrow-tag { display: none; }
}
</style>
