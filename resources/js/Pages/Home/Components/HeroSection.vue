<template>
  <section id="hero" ref="heroEl">

    <!-- ══ SVG CANVAS — full-bleed animated background ══ -->
    <svg class="hero-svg-bg" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <!-- Animated grid -->
      <defs>
        <pattern id="grid" width="90" height="90" patternUnits="userSpaceOnUse">
          <path d="M 90 0 L 0 0 0 90" fill="none" stroke="rgba(255,255,255,0.025)" stroke-width="1"/>
        </pattern>
        <radialGradient id="glow1" cx="70%" cy="20%" r="40%">
          <stop offset="0%" stop-color="#c9a84c" stop-opacity="0.10"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="glow2" cx="10%" cy="85%" r="35%">
          <stop offset="0%" stop-color="#162d55" stop-opacity="0.9"/>
          <stop offset="100%" stop-color="#162d55" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="glowCenter" cx="60%" cy="50%" r="30%">
          <stop offset="0%" stop-color="#c9a84c" stop-opacity="0.04"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
        <filter id="blur4">
          <feGaussianBlur stdDeviation="4"/>
        </filter>
        <filter id="blur2">
          <feGaussianBlur stdDeviation="2"/>
        </filter>
        <linearGradient id="lineGrad" x1="0%" y1="0%" x2="100%" y2="0%">
          <stop offset="0%" stop-color="#c9a84c" stop-opacity="0"/>
          <stop offset="50%" stop-color="#c9a84c" stop-opacity="0.6"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </linearGradient>
      </defs>

      <!-- Base grid -->
      <rect width="1440" height="900" fill="url(#grid)"/>

      <!-- Radial glows -->
      <rect width="1440" height="900" fill="url(#glow1)"/>
      <rect width="1440" height="900" fill="url(#glow2)"/>
      <rect width="1440" height="900" fill="url(#glowCenter)"/>

      <!-- ── Ashoka-inspired concentric rings (right side) ── -->
      <g class="rings-group" transform="translate(1080, 450)">
        <!-- Outer ring: slow rotate -->
        <circle r="310" fill="none" stroke="rgba(201,168,76,0.06)" stroke-width="1"/>
        <circle r="310" fill="none" stroke="rgba(201,168,76,0.12)" stroke-width="0.5" stroke-dasharray="4 28" class="ring-spin-slow"/>
        <!-- Mid ring -->
        <circle r="230" fill="none" stroke="rgba(201,168,76,0.08)" stroke-width="1"/>
        <circle r="230" fill="none" stroke="rgba(201,168,76,0.18)" stroke-width="0.5" stroke-dasharray="3 18" class="ring-spin-mid"/>
        <!-- Inner ring -->
        <circle r="155" fill="none" stroke="rgba(201,168,76,0.10)" stroke-width="1"/>
        <circle r="155" fill="none" stroke="rgba(201,168,76,0.22)" stroke-width="0.5" stroke-dasharray="2 12" class="ring-spin-fast"/>
        <!-- Core glow -->
        <circle r="68" fill="none" stroke="rgba(201,168,76,0.15)" stroke-width="1.5"/>
        <circle r="68" fill="rgba(201,168,76,0.03)" filter="url(#blur4)"/>
        <circle r="6" fill="rgba(201,168,76,0.5)" class="core-pulse" filter="url(#blur2)"/>

        <!-- Spoke dots at 24 positions (Ashoka Chakra-like) -->
        <g class="ring-spin-slow">
          <circle v-for="i in 24" :key="`s1-${i}`"
            :cx="310 * Math.cos((i-1) * 15 * Math.PI / 180)"
            :cy="310 * Math.sin((i-1) * 15 * Math.PI / 180)"
            r="1.5" fill="rgba(201,168,76,0.35)"/>
        </g>
        <g class="ring-spin-mid-rev">
          <circle v-for="i in 16" :key="`s2-${i}`"
            :cx="230 * Math.cos((i-1) * 22.5 * Math.PI / 180)"
            :cy="230 * Math.sin((i-1) * 22.5 * Math.PI / 180)"
            r="2" fill="rgba(201,168,76,0.4)"/>
        </g>
        <g class="ring-spin-fast-rev">
          <circle v-for="i in 12" :key="`s3-${i}`"
            :cx="155 * Math.cos((i-1) * 30 * Math.PI / 180)"
            :cy="155 * Math.sin((i-1) * 30 * Math.PI / 180)"
            r="2.5" fill="rgba(201,168,76,0.5)"/>
        </g>
      </g>

      <!-- ── Constellation nodes + edges ── -->
      <g class="constellation">
        <!-- Edges -->
        <line v-for="(edge, i) in constellationEdges" :key="`e${i}`"
          :x1="constellationNodes[edge[0]].x" :y1="constellationNodes[edge[0]].y"
          :x2="constellationNodes[edge[1]].x" :y2="constellationNodes[edge[1]].y"
          stroke="rgba(201,168,76,0.12)" stroke-width="0.8"
          :class="`edge-pulse-${(i % 4) + 1}`"/>
        <!-- Nodes -->
        <g v-for="(node, i) in constellationNodes" :key="`n${i}`">
          <circle :cx="node.x" :cy="node.y" r="3" fill="rgba(201,168,76,0.08)" :class="`node-float-${(i % 3) + 1}`"/>
          <circle :cx="node.x" :cy="node.y" r="1.5" fill="rgba(201,168,76,0.55)" :class="`node-float-${(i % 3) + 1}`"/>
        </g>
      </g>

      <!-- ── Floating particles ── -->
      <g class="particles">
        <circle v-for="(p, i) in particles" :key="`p${i}`"
          :cx="p.x" :cy="p.y" :r="p.r"
          :fill="`rgba(201,168,76,${p.o})`"
          :class="`particle-drift-${(i % 5) + 1}`"/>
      </g>

      <!-- ── Diagonal accent lines (left decorative) ── -->
      <line x1="-20" y1="200" x2="200" y2="-20" stroke="rgba(201,168,76,0.06)" stroke-width="1"/>
      <line x1="-20" y1="340" x2="340" y2="-20" stroke="rgba(201,168,76,0.04)" stroke-width="1"/>
      <line x1="-20" y1="480" x2="200" y2="260" stroke="rgba(201,168,76,0.03)" stroke-width="0.5"/>
    </svg>

    <!-- ══ CONTENT ══ -->
    <div class="hero-inner container">

      <!-- Eyebrow -->
      <div class="hero-eyebrow" :class="{ visible: revealed }">
        <span class="eyebrow-line"/>
        <span class="eyebrow-dot"/>
        <span class="eyebrow-text">Bharat Governance Council</span>
        <span class="eyebrow-tag">Est. 2024</span>
      </div>

      <!-- Headline -->
      <h1 class="hero-headline" :class="{ visible: revealed }">
        <span class="hl-line hl-line-1">A Community for</span><br>
        <em class="hl-line hl-line-2">Better Governance.</em>
      </h1>

      <!-- Sub -->
      <p class="hero-sub" :class="{ visible: revealed }">
        Connecting citizens, policy thinkers, and civic leaders to research,
        debate, and shape the future of India's governance.
      </p>

      <!-- Actions -->
      <div class="hero-actions" :class="{ visible: revealed }">
        <a href="#" class="btn-primary">
          <span class="btn-shimmer"/>
          Join the Council
          <svg viewBox="0 0 20 20" fill="none" width="14" height="14">
            <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
        <a href="#featured" class="btn-ghost" @click.prevent="scrollTo('featured')">
          Explore Research
          <svg viewBox="0 0 20 20" fill="none" width="14" height="14" class="arrow-icon">
            <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
      </div>

      <!-- Glass stat cards -->
      <div class="hero-glass-stats" :class="{ visible: revealed }">
        <div v-for="stat in stats" :key="stat.label" class="glass-stat">
          <div class="glass-stat-inner">
            <span class="stat-icon">{{ stat.icon }}</span>
            <div class="stat-num">
              {{ stat.prefix }}<span class="stat-counter">{{ stat.display }}</span><sup>{{ stat.suffix }}</sup>
            </div>
            <div class="stat-label">{{ stat.label }}</div>
          </div>
          <div class="glass-stat-glow"/>
        </div>
      </div>
    </div>

    <!-- Scroll indicator -->
    <div class="hero-scroll" :class="{ visible: revealed }">
      <div class="scroll-track">
        <div class="scroll-thumb"/>
      </div>
      <span class="scroll-label">Scroll</span>
    </div>

    <!-- Bottom gold bar -->
    <div class="hero-gold-bar">
      <div class="gold-bar-shimmer"/>
    </div>

  </section>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue'

const heroEl   = ref(null)
const revealed = ref(false)

/* ── Constellation data ─────────────────────── */
const constellationNodes = [
  { x: 80,  y: 180 }, { x: 180, y: 90  }, { x: 280, y: 260 },
  { x: 140, y: 380 }, { x: 320, y: 160 }, { x: 60,  y: 520 },
  { x: 240, y: 480 }, { x: 380, y: 340 }, { x: 160, y: 620 },
  { x: 400, y: 500 }, { x: 500, y: 200 }, { x: 480, y: 420 },
  { x: 560, y: 600 }, { x: 620, y: 120 }, { x: 700, y: 350 },
  { x: 640, y: 500 }, { x: 750, y: 680 }, { x: 820, y: 260 },
]
const constellationEdges = [
  [0,1],[1,4],[4,10],[10,13],[13,17],[17,14],[14,11],[11,9],
  [9,12],[12,15],[15,8],[8,6],[6,3],[3,0],[2,4],[2,7],[7,14],
  [5,3],[5,8],[16,12],[16,15],
]

/* ── Particles ──────────────────────────────── */
const particles = Array.from({ length: 36 }, (_, i) => ({
  x: (i * 137.5) % 1440,
  y: (i * 97.3)  % 900,
  r: 0.8 + (i % 4) * 0.6,
  o: 0.15 + (i % 5) * 0.08,
}))

/* ── Stats with counter animation ──────────── */
const stats = reactive([
  { label: 'Members',       suffix: 'K+', prefix: '',  target: 5,   display: 0, icon: '◈' },
  { label: 'Publications',  suffix: '+',  prefix: '',  target: 120, display: 0, icon: '◇' },
  { label: 'Events Hosted', suffix: '+',  prefix: '',  target: 48,  display: 0, icon: '◆' },
])

function animateCounters() {
  stats.forEach((s, idx) => {
    const dur   = 1600 + idx * 200
    const start = performance.now()
    const tick  = (now) => {
      const t   = Math.min((now - start) / dur, 1)
      const ease = 1 - Math.pow(1 - t, 3)   // ease-out-cubic
      s.display = Math.round(ease * s.target)
      if (t < 1) requestAnimationFrame(tick)
    }
    setTimeout(() => requestAnimationFrame(tick), 400 + idx * 150)
  })
}

function scrollTo(id) {
  document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' })
}

onMounted(() => {
  // Staggered reveal after mount
  requestAnimationFrame(() => {
    setTimeout(() => {
      revealed.value = true
      animateCounters()
    }, 120)
  })
})
</script>

<style scoped>
/* ──────────────────────────────────────────────
   SECTION BASE
─────────────────────────────────────────────── */
#hero {
  position: relative;
  height: 100vh;
  min-height: 720px;
  background: #0b1c38;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

/* ──────────────────────────────────────────────
   SVG BACKGROUND
─────────────────────────────────────────────── */
.hero-svg-bg {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
}

/* ── Rings ── */
.ring-spin-slow      { animation: spinCW  40s linear infinite; transform-origin: 0 0; }
.ring-spin-mid       { animation: spinCCW 28s linear infinite; transform-origin: 0 0; }
.ring-spin-fast      { animation: spinCW  18s linear infinite; transform-origin: 0 0; }
.ring-spin-mid-rev   { animation: spinCCW 32s linear infinite; transform-origin: 0 0; }
.ring-spin-fast-rev  { animation: spinCW  22s linear infinite; transform-origin: 0 0; }

@keyframes spinCW  { from { transform: rotate(0deg);   } to { transform: rotate(360deg);  } }
@keyframes spinCCW { from { transform: rotate(0deg);   } to { transform: rotate(-360deg); } }

.core-pulse { animation: corePulse 2.4s ease-in-out infinite; }
@keyframes corePulse {
  0%,100% { r: 6; opacity: 0.5; }
  50%     { r: 14; opacity: 0.15; }
}

/* ── Constellation edges ── */
.edge-pulse-1 { animation: edgeFade 3.8s ease-in-out infinite 0.0s; }
.edge-pulse-2 { animation: edgeFade 3.8s ease-in-out infinite 0.9s; }
.edge-pulse-3 { animation: edgeFade 3.8s ease-in-out infinite 1.8s; }
.edge-pulse-4 { animation: edgeFade 3.8s ease-in-out infinite 2.7s; }
@keyframes edgeFade {
  0%,100% { opacity: 0.3; }
  50%     { opacity: 1;   }
}

/* ── Constellation nodes ── */
.node-float-1 { animation: nodeFloat 6s ease-in-out infinite 0.0s; }
.node-float-2 { animation: nodeFloat 7s ease-in-out infinite 1.2s; }
.node-float-3 { animation: nodeFloat 8s ease-in-out infinite 2.4s; }
@keyframes nodeFloat {
  0%,100% { transform: translate(0,0); }
  33%     { transform: translate(3px,-4px); }
  66%     { transform: translate(-3px,2px); }
}

/* ── Particles ── */
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


/* ──────────────────────────────────────────────
   LAYOUT
─────────────────────────────────────────────── */
.hero-inner {
  position: relative;
  z-index: 2;
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 60px;
  padding-top: 72px; /* nav height */
}

/* ──────────────────────────────────────────────
   EYEBROW
─────────────────────────────────────────────── */
.hero-eyebrow {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 32px;
  opacity: 0;
  transform: translateY(16px);
  transition: opacity 0.7s ease 0.1s, transform 0.7s ease 0.1s;
}
.hero-eyebrow.visible { opacity: 1; transform: translateY(0); }

.eyebrow-line {
  display: block;
  width: 36px;
  height: 1px;
  background: linear-gradient(90deg, transparent, #c9a84c);
}
.eyebrow-dot {
  display: block;
  width: 4px; height: 4px;
  border-radius: 50%;
  background: #c9a84c;
  box-shadow: 0 0 6px rgba(201,168,76,0.8);
  animation: dotPulse 2s ease-in-out infinite;
}
@keyframes dotPulse {
  0%,100% { box-shadow: 0 0 6px rgba(201,168,76,0.8); }
  50%     { box-shadow: 0 0 14px rgba(201,168,76,1); }
}
.eyebrow-text {
  font-size: 11px;
  font-weight: 500;
  color: #c9a84c;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}
.eyebrow-tag {
  font-size: 9px;
  font-weight: 600;
  color: #0b1c38;
  background: rgba(201,168,76,0.85);
  letter-spacing: 0.2em;
  text-transform: uppercase;
  padding: 2px 8px;
  font-family: 'DM Mono', monospace;
}

/* ──────────────────────────────────────────────
   HEADLINE
─────────────────────────────────────────────── */
.hero-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(54px, 6.5vw, 96px);
  font-weight: 600;
  color: #fff;
  line-height: 1.02;
  letter-spacing: -0.01em;
  margin-bottom: 28px;
  opacity: 0;
  transform: translateY(24px);
  transition: opacity 0.8s ease 0.3s, transform 0.8s ease 0.3s;
}
.hero-headline.visible { opacity: 1; transform: translateY(0); }

.hl-line {
  display: inline-block;
}
.hl-line-1 {
  color: #fff;
}
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

/* ──────────────────────────────────────────────
   SUBTEXT
─────────────────────────────────────────────── */
.hero-sub {
  font-size: 17px;
  font-weight: 300;
  color: #b8c5d8;
  line-height: 1.75;
  max-width: 520px;
  margin-bottom: 44px;
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.8s ease 0.5s, transform 0.8s ease 0.5s;
  font-family: 'DM Sans', sans-serif;
}
.hero-sub.visible { opacity: 1; transform: translateY(0); }

/* ──────────────────────────────────────────────
   ACTION BUTTONS
─────────────────────────────────────────────── */
.hero-actions {
  display: flex;
  align-items: center;
  gap: 28px;
  margin-bottom: 64px;
  opacity: 0;
  transform: translateY(16px);
  transition: opacity 0.7s ease 0.65s, transform 0.7s ease 0.65s;
}
.hero-actions.visible { opacity: 1; transform: translateY(0); }

.btn-primary {
  position: relative;
  display: inline-flex;
  align-items: center;
  gap: 10px;
  background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 50%, #c9a84c 100%);
  background-size: 200% auto;
  color: #0b1c38;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  padding: 16px 36px;
  text-decoration: none;
  overflow: hidden;
  transition: background-position 0.5s ease, transform 0.2s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 20px rgba(201,168,76,0.3);
  font-family: 'DM Sans', sans-serif;
}
.btn-shimmer {
  position: absolute;
  inset: 0;
  background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.35) 50%, transparent 60%);
  transform: translateX(-100%);
  transition: transform 0s;
}
.btn-primary:hover .btn-shimmer {
  transform: translateX(100%);
  transition: transform 0.5s ease;
}
.btn-primary:hover {
  background-position: right center;
  transform: translateY(-3px);
  box-shadow: 0 10px 36px rgba(201,168,76,0.45);
}

.btn-ghost {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  font-size: 11px;
  font-weight: 500;
  color: #b8c5d8;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  text-decoration: none;
  transition: color 0.25s;
  font-family: 'DM Sans', sans-serif;
}
.btn-ghost:hover { color: #e8cf8a; }
.arrow-icon { transition: transform 0.25s ease; }
.btn-ghost:hover .arrow-icon { transform: translateX(5px); }

/* ──────────────────────────────────────────────
   GLASS STAT CARDS
─────────────────────────────────────────────── */
.hero-glass-stats {
  display: flex;
  gap: 16px;
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.8s ease 0.85s, transform 0.8s ease 0.85s;
}
.hero-glass-stats.visible { opacity: 1; transform: translateY(0); }

.glass-stat {
  position: relative;
  flex: 1;
  max-width: 180px;
  padding: 22px 24px 20px;
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(201,168,76,0.15);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  overflow: hidden;
  cursor: default;
  transition: background 0.3s, border-color 0.3s, transform 0.25s;
}
.glass-stat:hover {
  background: rgba(255,255,255,0.08);
  border-color: rgba(201,168,76,0.35);
  transform: translateY(-4px);
}
.glass-stat-inner { position: relative; z-index: 1; }
.glass-stat-glow {
  position: absolute;
  inset: 0;
  background: radial-gradient(circle at 50% 100%, rgba(201,168,76,0.12) 0%, transparent 70%);
  opacity: 0;
  transition: opacity 0.3s;
}
.glass-stat:hover .glass-stat-glow { opacity: 1; }

.stat-icon {
  display: block;
  font-size: 13px;
  color: rgba(201,168,76,0.5);
  margin-bottom: 10px;
  letter-spacing: 0.1em;
}
.stat-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 44px;
  font-weight: 700;
  color: #fff;
  line-height: 1;
  margin-bottom: 8px;
}
.stat-counter { display: inline-block; }
.stat-num sup {
  font-size: 20px;
  color: #c9a84c;
  vertical-align: super;
  margin-left: 2px;
}
.stat-label {
  font-size: 10px;
  color: #8a9bbf;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}

/* ──────────────────────────────────────────────
   SCROLL INDICATOR
─────────────────────────────────────────────── */
.hero-scroll {
  position: absolute;
  bottom: 36px;
  left: 60px;
  z-index: 3;
  display: flex;
  align-items: center;
  gap: 14px;
  opacity: 0;
  transition: opacity 0.6s ease 1.2s;
}
.hero-scroll.visible { opacity: 1; }

.scroll-track {
  width: 1px;
  height: 52px;
  background: rgba(201,168,76,0.15);
  position: relative;
  overflow: hidden;
}
.scroll-thumb {
  position: absolute;
  top: 0; left: 0;
  width: 1px;
  background: linear-gradient(to bottom, transparent, #c9a84c, transparent);
  animation: scrollThumb 2s ease-in-out infinite;
}
@keyframes scrollThumb {
  0%   { height: 0%;  top: 0%; }
  50%  { height: 60%; top: 20%; }
  100% { height: 0%;  top: 100%; }
}
.scroll-label {
  font-size: 9px;
  color: #8a9bbf;
  letter-spacing: 0.28em;
  text-transform: uppercase;
  writing-mode: vertical-rl;
  font-family: 'DM Mono', monospace;
}

/* ──────────────────────────────────────────────
   BOTTOM GOLD BAR
─────────────────────────────────────────────── */
.hero-gold-bar {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg,
    #c9a84c 0%,
    #e8cf8a 30%,
    rgba(201,168,76,0.15) 70%,
    transparent 100%
  );
  overflow: hidden;
}
.gold-bar-shimmer {
  position: absolute;
  inset: 0;
  background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.6) 50%, transparent 100%);
  animation: barShimmer 3s ease-in-out infinite;
}
@keyframes barShimmer {
  0%   { transform: translateX(-100%); }
  100% { transform: translateX(400%); }
}

/* ──────────────────────────────────────────────
   RESPONSIVE
─────────────────────────────────────────────── */
@media (max-width: 1024px) {
  .hero-inner { padding: 0 32px; padding-top: 72px; }
  .rings-group { display: none; }
  .hero-scroll { left: 32px; }
}

@media (max-width: 768px) {
  .hero-inner { padding: 0 20px; padding-top: 72px; }
  .hero-glass-stats { flex-wrap: wrap; }
  .glass-stat { max-width: calc(50% - 8px); flex: none; }
  .hero-actions { flex-direction: column; align-items: flex-start; gap: 16px; }
  .hero-scroll { display: none; }
}
</style>
