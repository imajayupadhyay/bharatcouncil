<template>
  <section id="wwu-hero">

    <!-- ══ SVG — Opportunity Flow ══ -->
    <svg class="hero-svg-bg" viewBox="0 0 1440 780" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <!-- Dot matrix pattern -->
        <pattern id="wwuDots" width="40" height="40" patternUnits="userSpaceOnUse">
          <circle cx="20" cy="20" r="0.85" fill="rgba(255,255,255,0.022)"/>
        </pattern>

        <!-- Glows -->
        <radialGradient id="wwuGlowHex" cx="78%" cy="46%" r="40%">
          <stop offset="0%"   stop-color="#c9a84c" stop-opacity="0.10"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="wwuGlowL" cx="0%" cy="100%" r="38%">
          <stop offset="0%"   stop-color="#0f2347" stop-opacity="1"/>
          <stop offset="100%" stop-color="#0f2347" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="wwuGlowMid" cx="40%" cy="50%" r="28%">
          <stop offset="0%"   stop-color="#162d55" stop-opacity="0.55"/>
          <stop offset="100%" stop-color="#162d55" stop-opacity="0"/>
        </radialGradient>

        <filter id="wwuBlur6"><feGaussianBlur stdDeviation="6"/></filter>
        <filter id="wwuBlur2"><feGaussianBlur stdDeviation="2"/></filter>
      </defs>

      <!-- Dot matrix base -->
      <rect width="1440" height="780" fill="url(#wwuDots)"/>
      <!-- Glows -->
      <rect width="1440" height="780" fill="url(#wwuGlowHex)"/>
      <rect width="1440" height="780" fill="url(#wwuGlowL)"/>
      <rect width="1440" height="780" fill="url(#wwuGlowMid)"/>

      <!-- ══ BEZIER FLOW LINES — animated traveling glow ══ -->
      <!-- Trail paths (dim base) -->
      <path class="flow-trail-1" d="M -50 180 C 200 100, 480 260, 750 160 S 1100 230, 1500 140" fill="none" stroke="rgba(201,168,76,0.06)" stroke-width="1"/>
      <path class="flow-trail-2" d="M -50 360 C 180 280, 440 440, 720 340 S 1050 420, 1500 300" fill="none" stroke="rgba(201,168,76,0.05)" stroke-width="1"/>
      <path class="flow-trail-3" d="M -50 540 C 220 460, 500 610, 760 510 S 1080 580, 1500 480" fill="none" stroke="rgba(201,168,76,0.04)" stroke-width="0.8"/>
      <path class="flow-trail-4" d="M -50 680 C 260 610, 520 730, 800 650 S 1120 700, 1500 620" fill="none" stroke="rgba(201,168,76,0.03)" stroke-width="0.8"/>

      <!-- Traveling glows (bright moving segment) -->
      <path class="flow-glow-1" d="M -50 180 C 200 100, 480 260, 750 160 S 1100 230, 1500 140" fill="none" stroke="rgba(201,168,76,0.55)" stroke-width="1.5" stroke-linecap="round"/>
      <path class="flow-glow-2" d="M -50 360 C 180 280, 440 440, 720 340 S 1050 420, 1500 300" fill="none" stroke="rgba(201,168,76,0.45)" stroke-width="1.5" stroke-linecap="round"/>
      <path class="flow-glow-3" d="M -50 540 C 220 460, 500 610, 760 510 S 1080 580, 1500 480" fill="none" stroke="rgba(201,168,76,0.35)" stroke-width="1.2" stroke-linecap="round"/>
      <path class="flow-glow-4" d="M -50 680 C 260 610, 520 730, 800 650 S 1120 700, 1500 620" fill="none" stroke="rgba(201,168,76,0.3)"  stroke-width="1.2" stroke-linecap="round"/>

      <!-- ══ HEXAGONAL HONEYCOMB (right side) ══ -->
      <g transform="translate(1095, 385)">
        <!-- Center glow -->
        <circle r="90" fill="rgba(201,168,76,0.04)" filter="url(#wwuBlur6)"/>

        <!-- Honeycomb cells -->
        <g v-for="(hex, i) in hexagons" :key="`h${i}`">
          <!-- Hex fill -->
          <polygon
            :points="hexPts(hex.cx, hex.cy, 34)"
            :fill="`rgba(201,168,76,${hex.fO})`"/>
          <!-- Hex border -->
          <polygon
            :points="hexPts(hex.cx, hex.cy, 34)"
            fill="none"
            :stroke="`rgba(201,168,76,${hex.sO})`"
            stroke-width="0.8"
            :class="`hx-${(i % 4) + 1}`"/>
          <!-- Center dot on some cells -->
          <circle v-if="hex.dot"
            :cx="hex.cx" :cy="hex.cy" r="2.5"
            :fill="`rgba(201,168,76,${hex.sO * 3})`"/>
        </g>

        <!-- Outer ring dots -->
        <circle v-for="i in 12" :key="`od${i}`"
          :cx="230 * Math.cos((i-1) * 30 * Math.PI / 180)"
          :cy="230 * Math.sin((i-1) * 30 * Math.PI / 180)"
          r="1.8" :fill="`rgba(201,168,76,${i % 3 === 0 ? 0.45 : 0.2})`"
          :class="`od-${(i % 3) + 1}`"/>
        <!-- Outer orbit ring -->
        <circle r="230" fill="none" stroke="rgba(201,168,76,0.06)" stroke-width="0.8" stroke-dasharray="6 18" class="hx-orbit"/>
      </g>

      <!-- ══ CROSS / PLUS PARTICLES ══ -->
      <g v-for="(c, i) in crosses" :key="`cr${i}`" :class="`cr-${(i % 4) + 1}`">
        <line :x1="c.x - c.s" :y1="c.y"       :x2="c.x + c.s" :y2="c.y"       :stroke="`rgba(201,168,76,${c.o})`" stroke-width="1"/>
        <line :x1="c.x"       :y1="c.y - c.s" :x2="c.x"       :y2="c.y + c.s" :stroke="`rgba(201,168,76,${c.o})`" stroke-width="1"/>
      </g>

      <!-- Left edge tick marks (measurement motif) -->
      <g transform="translate(0, 120)">
        <line v-for="i in 14" :key="`tk${i}`"
          x1="0" :y1="(i-1) * 40"
          :x2="(i % 4 === 0) ? 28 : (i % 2 === 0) ? 16 : 10"
          :y2="(i-1) * 40"
          :stroke="`rgba(201,168,76,${i % 4 === 0 ? 0.3 : 0.12})`"
          stroke-width="1"/>
        <line x1="2" y1="0" x2="2" :y2="13 * 40" stroke="rgba(201,168,76,0.1)" stroke-width="0.8"/>
      </g>
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
        <span class="hl-plain">Build Your Career at the</span><br>
        <em class="hl-gold">Heart of Indian Governance</em>
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
    <div class="hero-gold-bar"><div class="gold-bar-shimmer"/></div>

  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'

defineProps({
  activeTab: { type: String, default: 'intern' }
})
defineEmits(['set-tab'])

const revealed = ref(false)

/* ── Hexagon points (flat-top) ── */
function hexPts(cx, cy, r) {
  return Array.from({ length: 6 }, (_, i) => {
    const a = i * 60 * Math.PI / 180
    return `${(cx + r * Math.cos(a)).toFixed(1)},${(cy + r * Math.sin(a)).toFixed(1)}`
  }).join(' ')
}

/* ── Honeycomb grid — flat-top hexagons ── */
const hexagons = (() => {
  const r = 36          // hex radius
  const xStep = r * 1.5       // horizontal step between column centres
  const yStep = r * Math.sqrt(3) // vertical step between row centres
  const cols = 7, rows = 5
  const items = []

  for (let col = 0; col < cols; col++) {
    for (let row = 0; row < rows; row++) {
      const cx = (col - (cols - 1) / 2) * xStep
      const cy = (row - (rows - 1) / 2) * yStep + (col % 2 === 0 ? 0 : yStep / 2)
      const dist = Math.sqrt(cx * cx + cy * cy)
      if (dist < 215) {
        const closeness = 1 - dist / 215
        items.push({
          cx, cy,
          fO: 0.01 + closeness * 0.05,
          sO: 0.06 + closeness * 0.18,
          dot: dist < 90,
        })
      }
    }
  }
  return items
})()

/* ── Cross particles ── */
const crosses = Array.from({ length: 22 }, (_, i) => ({
  x: (i * 157.3) % 1440,
  y: (i * 89.7)  % 780,
  s: 3 + (i % 4) * 2,
  o: 0.06 + (i % 5) * 0.04,
}))

onMounted(() => {
  requestAnimationFrame(() => setTimeout(() => { revealed.value = true }, 100))
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
  padding-top: 72px;
  min-height: 86vh;
}

/* ── SVG ─────────────────────────────────────── */
.hero-svg-bg {
  position: absolute; inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}

/* ── FLOW LINE ANIMATIONS ────────────────────── */
/* Trail paths — static (no animation needed, they're the dim base) */

/* Traveling glow segments */
.flow-glow-1 { stroke-dasharray: 60 1540; animation: flowMove 10s linear infinite; }
.flow-glow-2 { stroke-dasharray: 50 1540; animation: flowMove 13s linear infinite 3.5s; }
.flow-glow-3 { stroke-dasharray: 40 1540; animation: flowMove 16s linear infinite 7s; }
.flow-glow-4 { stroke-dasharray: 35 1540; animation: flowMove 19s linear infinite 5s; }

@keyframes flowMove {
  0%   { stroke-dashoffset: 1600; }
  100% { stroke-dashoffset: -100; }
}

/* ── HONEYCOMB ANIMATIONS ────────────────────── */
.hx-1 { animation: hexPulse 4s ease-in-out infinite 0.0s; }
.hx-2 { animation: hexPulse 4s ease-in-out infinite 1.0s; }
.hx-3 { animation: hexPulse 4s ease-in-out infinite 2.0s; }
.hx-4 { animation: hexPulse 4s ease-in-out infinite 3.0s; }
@keyframes hexPulse { 0%,100%{opacity:0.5} 50%{opacity:1} }

.hx-orbit { animation: orbitSpin 35s linear infinite; transform-origin: 0 0; }
@keyframes orbitSpin { to { transform: rotate(360deg); } }

/* Outer orbit dots */
.od-1 { animation: odPulse 3s ease-in-out infinite 0.0s; }
.od-2 { animation: odPulse 3s ease-in-out infinite 1.0s; }
.od-3 { animation: odPulse 3s ease-in-out infinite 2.0s; }
@keyframes odPulse { 0%,100%{opacity:0.3;r:1.8} 50%{opacity:1;r:3} }

/* ── CROSS PARTICLE ANIMATIONS ───────────────── */
.cr-1 { animation: crDrift1 16s ease-in-out infinite; }
.cr-2 { animation: crDrift2 20s ease-in-out infinite 2s; }
.cr-3 { animation: crDrift3 14s ease-in-out infinite 5s; }
.cr-4 { animation: crDrift4 18s ease-in-out infinite 1s; }
@keyframes crDrift1 { 0%,100%{transform:translate(0,0) rotate(0deg)}  50%{transform:translate(9px,-8px)  rotate(45deg)} }
@keyframes crDrift2 { 0%,100%{transform:translate(0,0) rotate(0deg)}  50%{transform:translate(-7px,10px) rotate(-30deg)} }
@keyframes crDrift3 { 0%,100%{transform:translate(0,0) rotate(0deg)}  50%{transform:translate(11px,7px)  rotate(60deg)} }
@keyframes crDrift4 { 0%,100%{transform:translate(0,0) rotate(0deg)}  50%{transform:translate(-9px,-6px) rotate(-45deg)} }

/* ── Hero Inner ─────────────────────────────── */
.hero-inner {
  position: relative; z-index: 2;
  max-width: 1280px; margin: 0 auto;
  padding: 48px 60px 56px;
  width: 100%;
}

/* ── Breadcrumb ──────────────────────────────── */
.hero-breadcrumb {
  display: flex; align-items: center; gap: 8px;
  margin-bottom: 40px;
  opacity: 0; transition: opacity 0.6s ease 0.05s;
}
.hero-breadcrumb.visible { opacity: 1; }
.hero-breadcrumb a {
  font-size: 11px; font-family: 'DM Sans', sans-serif;
  letter-spacing: 0.12em; text-transform: uppercase;
  color: rgba(184,197,216,0.45); text-decoration: none;
  transition: color 0.2s;
}
.hero-breadcrumb a:hover { color: rgba(184,197,216,0.8); }
.bc-sep { font-size: 10px; color: rgba(184,197,216,0.25); }
.bc-current {
  font-size: 11px; font-family: 'DM Sans', sans-serif;
  letter-spacing: 0.12em; text-transform: uppercase;
  color: rgba(201,168,76,0.75);
}

/* ── Eyebrow ─────────────────────────────────── */
.hero-eyebrow {
  display: flex; align-items: center; gap: 12px;
  margin-bottom: 28px;
  opacity: 0; transform: translateY(16px);
  transition: opacity 0.7s ease 0.12s, transform 0.7s ease 0.12s;
}
.hero-eyebrow.visible { opacity: 1; transform: translateY(0); }
.eyebrow-line { display: block; width: 36px; height: 1px; background: linear-gradient(90deg, transparent, #c9a84c); }
.eyebrow-dot {
  display: block; width: 4px; height: 4px; border-radius: 50%;
  background: #c9a84c; box-shadow: 0 0 6px rgba(201,168,76,0.8);
  animation: dotPulse 2s ease-in-out infinite;
}
@keyframes dotPulse { 0%,100%{box-shadow:0 0 6px rgba(201,168,76,0.8)} 50%{box-shadow:0 0 14px rgba(201,168,76,1)} }
.eyebrow-text {
  font-size: 11px; font-weight: 500; color: #c9a84c;
  letter-spacing: 0.3em; text-transform: uppercase;
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
  font-weight: 600; color: #f5f7fa;
  line-height: 1.05; letter-spacing: -0.01em;
  margin-bottom: 24px;
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.8s ease 0.28s, transform 0.8s ease 0.28s;
}
.hero-headline.visible { opacity: 1; transform: translateY(0); }
.hl-plain { display: inline-block; color: #f5f7fa; }
.hl-gold {
  font-style: italic;
  background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 45%, #c9a84c 100%);
  background-size: 200% auto;
  -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  background-clip: text; animation: goldShine 4s linear infinite;
}
@keyframes goldShine { 0%{background-position:0% center} 100%{background-position:200% center} }

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
  display: inline-flex; align-items: center; gap: 16px;
  background: rgba(201,168,76,0.08);
  border: 1px solid rgba(201,168,76,0.25);
  padding: 16px 24px; overflow: hidden;
  opacity: 0; transform: translateY(16px);
  transition: opacity 0.7s ease 0.6s, transform 0.7s ease 0.6s;
}
.award-badge.visible { opacity: 1; transform: translateY(0); }
.award-badge:hover { border-color: rgba(201,168,76,0.45); background: rgba(201,168,76,0.12); }
.award-shimmer {
  position: absolute; inset: 0;
  background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.06) 50%, transparent 60%);
  transform: translateX(-100%); transition: transform 0s;
}
.award-badge:hover .award-shimmer { transform: translateX(100%); transition: transform 0.6s ease; }
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
  max-width: 1280px; margin: 0 auto;
  padding: 0 60px; display: flex; gap: 2px;
}
.tab-btn {
  flex: 1; display: flex; align-items: center; gap: 16px;
  padding: 22px 32px;
  background: rgba(255,255,255,0.025);
  border: none; border-bottom: 3px solid transparent;
  cursor: pointer; text-align: left;
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.3rem; font-weight: 600;
  color: rgba(245,247,250,0.38); letter-spacing: 0.01em;
  transition: all 0.25s ease;
}
.tab-btn:hover:not(.active) {
  background: rgba(255,255,255,0.05);
  color: rgba(245,247,250,0.65);
}
.tab-btn.active {
  background: rgba(201,168,76,0.05);
  color: #f5f7fa; border-bottom-color: #c9a84c;
}
.tab-num {
  font-size: 10px; font-weight: 700;
  letter-spacing: 0.22em; text-transform: uppercase;
  color: #c9a84c; font-family: 'DM Mono', monospace; flex-shrink: 0;
}
.tab-label { flex: 1; }
.tab-arrow {
  margin-left: auto; opacity: 0; transform: translateY(-4px);
  transition: opacity 0.25s, transform 0.25s; color: #c9a84c;
}
.tab-btn.active .tab-arrow,
.tab-btn:hover .tab-arrow { opacity: 1; transform: translateY(0); }
.tab-divider {
  display: block; width: 1px;
  background: rgba(255,255,255,0.06); align-self: stretch;
}

/* ── Bottom gold bar ─────────────────────────── */
.hero-gold-bar {
  position: absolute; bottom: 0; left: 0; right: 0; height: 3px;
  background: linear-gradient(90deg, #c9a84c 0%, #e8cf8a 30%, rgba(201,168,76,0.15) 70%, transparent 100%);
  overflow: hidden;
}
.gold-bar-shimmer {
  position: absolute; inset: 0;
  background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.6) 50%, transparent 100%);
  animation: barShimmer 3s ease-in-out infinite;
}
@keyframes barShimmer { 0%{transform:translateX(-100%)} 100%{transform:translateX(400%)} }

/* ── Responsive ──────────────────────────────── */
@media (max-width: 1024px) {
  .hero-inner { padding: 48px 32px 56px; }
  .tab-nav-inner { padding: 0 32px; }
}
@media (max-width: 768px) {
  #wwu-hero { min-height: auto; }
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
