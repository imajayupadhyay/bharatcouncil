<template>
  <section id="wwa-hero" ref="heroEl">

    <!-- ══ SVG animated background ══ -->
    <svg class="hero-svg-bg" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <pattern id="wwaGrid" width="90" height="90" patternUnits="userSpaceOnUse">
          <path d="M 90 0 L 0 0 0 90" fill="none" stroke="rgba(255,255,255,0.025)" stroke-width="1"/>
        </pattern>
        <radialGradient id="wwaGlow1" cx="72%" cy="35%" r="40%">
          <stop offset="0%" stop-color="#c9a84c" stop-opacity="0.09"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="wwaGlow2" cx="8%" cy="90%" r="35%">
          <stop offset="0%" stop-color="#162d55" stop-opacity="0.9"/>
          <stop offset="100%" stop-color="#162d55" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="wwaGlowC" cx="50%" cy="50%" r="35%">
          <stop offset="0%" stop-color="#c9a84c" stop-opacity="0.04"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
        <filter id="wwaBlur4"><feGaussianBlur stdDeviation="4"/></filter>
        <filter id="wwaBlur2"><feGaussianBlur stdDeviation="2"/></filter>
      </defs>

      <rect width="1440" height="900" fill="url(#wwaGrid)"/>
      <rect width="1440" height="900" fill="url(#wwaGlow1)"/>
      <rect width="1440" height="900" fill="url(#wwaGlow2)"/>
      <rect width="1440" height="900" fill="url(#wwaGlowC)"/>

      <!-- Ashoka-inspired rings (right side) -->
      <g class="rings-group" transform="translate(1080, 420)">
        <circle r="300" fill="none" stroke="rgba(201,168,76,0.06)" stroke-width="1"/>
        <circle r="300" fill="none" stroke="rgba(201,168,76,0.12)" stroke-width="0.5" stroke-dasharray="4 28" class="ring-spin-slow"/>
        <circle r="220" fill="none" stroke="rgba(201,168,76,0.08)" stroke-width="1"/>
        <circle r="220" fill="none" stroke="rgba(201,168,76,0.18)" stroke-width="0.5" stroke-dasharray="3 18" class="ring-spin-mid"/>
        <circle r="145" fill="none" stroke="rgba(201,168,76,0.10)" stroke-width="1"/>
        <circle r="145" fill="none" stroke="rgba(201,168,76,0.22)" stroke-width="0.5" stroke-dasharray="2 12" class="ring-spin-fast"/>
        <circle r="62" fill="none" stroke="rgba(201,168,76,0.15)" stroke-width="1.5"/>
        <circle r="62" fill="rgba(201,168,76,0.03)" filter="url(#wwaBlur4)"/>
        <circle r="6" fill="rgba(201,168,76,0.5)" class="core-pulse" filter="url(#wwaBlur2)"/>
        <g class="ring-spin-slow">
          <circle v-for="i in 24" :key="`s1-${i}`"
            :cx="300 * Math.cos((i-1) * 15 * Math.PI / 180)"
            :cy="300 * Math.sin((i-1) * 15 * Math.PI / 180)"
            r="1.5" fill="rgba(201,168,76,0.35)"/>
        </g>
        <g class="ring-spin-mid-rev">
          <circle v-for="i in 16" :key="`s2-${i}`"
            :cx="220 * Math.cos((i-1) * 22.5 * Math.PI / 180)"
            :cy="220 * Math.sin((i-1) * 22.5 * Math.PI / 180)"
            r="2" fill="rgba(201,168,76,0.4)"/>
        </g>
        <g class="ring-spin-fast-rev">
          <circle v-for="i in 12" :key="`s3-${i}`"
            :cx="145 * Math.cos((i-1) * 30 * Math.PI / 180)"
            :cy="145 * Math.sin((i-1) * 30 * Math.PI / 180)"
            r="2.5" fill="rgba(201,168,76,0.5)"/>
        </g>
      </g>

      <!-- Constellation nodes + edges -->
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

      <line x1="-20" y1="200" x2="200" y2="-20" stroke="rgba(201,168,76,0.05)" stroke-width="1"/>
      <line x1="-20" y1="340" x2="340" y2="-20" stroke="rgba(201,168,76,0.03)" stroke-width="1"/>
    </svg>

    <!-- Watermark -->
    <div class="hero-watermark" aria-hidden="true">BGC</div>

    <!-- ══ Content ══ -->
    <div class="hero-inner">

      <!-- Breadcrumb -->
      <nav class="hero-breadcrumb" :class="{ visible: revealed }">
        <a href="/">Home</a>
        <span class="bc-sep">/</span>
        <span class="bc-current">Who We Are</span>
      </nav>

      <!-- Eyebrow -->
      <div class="hero-eyebrow" :class="{ visible: revealed }">
        <span class="eyebrow-line"/>
        <span class="eyebrow-dot"/>
        <span class="eyebrow-text">Who We Are</span>
      </div>

      <!-- Headline -->
      <h1 class="hero-headline" :class="{ visible: revealed }">
        <span class="hl-line-1">Where </span><em class="hl-line-2">Experience</em><br>
        <span class="hl-line-1">Meets </span><em class="hl-line-2">Purpose</em>
      </h1>

      <!-- Sub -->
      <p class="hero-sub" :class="{ visible: revealed }">
        Bharat Governance Council is an independent, non-partisan institution founded in 2023 by
        distinguished retired officers of India's All India Services — dedicated to strengthening
        governance, mentoring younger civil servants, and building the intellectual infrastructure for reform.
      </p>

      <!-- Badges -->
      <div class="hero-badges" :class="{ visible: revealed }">
        <span class="badge badge-hl">Est. 2023</span>
        <span class="badge">New Delhi</span>
        <span class="badge">Non-Partisan</span>
        <span class="badge">100+ Officers Onboarded Annually</span>
      </div>

      <!-- Stats -->
      <div class="hero-stats" :class="{ visible: revealed }">
        <div v-for="stat in stats" :key="stat.label" class="glass-stat">
          <div class="stat-num">
            {{ stat.prefix }}<span class="stat-counter">{{ stat.display }}</span><span class="stat-suffix">{{ stat.suffix }}</span>
          </div>
          <div class="stat-label">{{ stat.label }}</div>
        </div>
      </div>

      <!-- Quote -->
      <div class="hero-quote-card" :class="{ visible: revealed }">
        <div class="quote-shimmer"/>
        <blockquote class="quote-text">"Decades of service taught us that governance is too important to be left only to those currently in office. Wisdom must be passed on — deliberately, urgently."</blockquote>
        <cite class="quote-cite">— Dr. Kush Verma, IAS 1979 · Chairman &amp; Co-Founder</cite>
      </div>
    </div>

    <!-- Bottom gold bar -->
    <div class="hero-gold-bar">
      <div class="gold-bar-shimmer"/>
    </div>

  </section>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'

const heroEl   = ref(null)
const revealed = ref(false)

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

const particles = Array.from({ length: 36 }, (_, i) => ({
  x: (i * 137.5) % 1440,
  y: (i * 97.3)  % 900,
  r: 0.8 + (i % 4) * 0.6,
  o: 0.12 + (i % 5) * 0.07,
}))

const stats = reactive([
  { label: 'Year Founded',        suffix: '',  prefix: '', target: 2023, display: 0 },
  { label: 'Young Officers / Year', suffix: '+', prefix: '', target: 100,  display: 0 },
  { label: 'Founding Members',    suffix: '+', prefix: '', target: 15,   display: 0 },
])

function animateCounters() {
  stats.forEach((s, idx) => {
    const dur   = 1600 + idx * 200
    const start = performance.now()
    const tick  = (now) => {
      const t    = Math.min((now - start) / dur, 1)
      const ease = 1 - Math.pow(1 - t, 3)
      s.display = Math.round(ease * s.target)
      if (t < 1) requestAnimationFrame(tick)
    }
    setTimeout(() => requestAnimationFrame(tick), 500 + idx * 150)
  })
}

onMounted(() => {
  requestAnimationFrame(() => {
    setTimeout(() => {
      revealed.value = true
      animateCounters()
    }, 120)
  })
})
</script>

<style scoped>
/* ── Section ─────────────────────────────────── */
#wwa-hero {
  position: relative;
  min-height: 100vh;
  background: #0b1c38;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding-top: 72px;
}

.hero-watermark {
  position: absolute;
  right: -2rem; top: 50%; transform: translateY(-50%);
  font-family: 'Cormorant Garamond', serif;
  font-size: 16rem; font-weight: 700; letter-spacing: -0.05em;
  color: rgba(255,255,255,0.015); pointer-events: none; white-space: nowrap;
  z-index: 1;
}

/* ── SVG Background ──────────────────────────── */
.hero-svg-bg {
  position: absolute; inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}

.ring-spin-slow     { animation: spinCW  40s linear infinite; transform-origin: 0 0; }
.ring-spin-mid      { animation: spinCCW 28s linear infinite; transform-origin: 0 0; }
.ring-spin-fast     { animation: spinCW  18s linear infinite; transform-origin: 0 0; }
.ring-spin-mid-rev  { animation: spinCCW 32s linear infinite; transform-origin: 0 0; }
.ring-spin-fast-rev { animation: spinCW  22s linear infinite; transform-origin: 0 0; }
@keyframes spinCW  { to { transform: rotate(360deg);  } }
@keyframes spinCCW { to { transform: rotate(-360deg); } }

.core-pulse { animation: corePulse 2.4s ease-in-out infinite; }
@keyframes corePulse { 0%,100%{r:6;opacity:0.5} 50%{r:14;opacity:0.15} }

.edge-pulse-1 { animation: edgeFade 3.8s ease-in-out infinite 0.0s; }
.edge-pulse-2 { animation: edgeFade 3.8s ease-in-out infinite 0.9s; }
.edge-pulse-3 { animation: edgeFade 3.8s ease-in-out infinite 1.8s; }
.edge-pulse-4 { animation: edgeFade 3.8s ease-in-out infinite 2.7s; }
@keyframes edgeFade { 0%,100%{opacity:0.3} 50%{opacity:1} }

.node-float-1 { animation: nodeFloat 6s ease-in-out infinite 0.0s; }
.node-float-2 { animation: nodeFloat 7s ease-in-out infinite 1.2s; }
.node-float-3 { animation: nodeFloat 8s ease-in-out infinite 2.4s; }
@keyframes nodeFloat { 0%,100%{transform:translate(0,0)} 33%{transform:translate(3px,-4px)} 66%{transform:translate(-3px,2px)} }

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

/* ── Inner ───────────────────────────────────── */
.hero-inner {
  position: relative; z-index: 2;
  max-width: 1280px; margin: 0 auto;
  padding: 48px 60px 72px;
  width: 100%;
}

/* ── Breadcrumb ──────────────────────────────── */
.hero-breadcrumb {
  display: flex; align-items: center; gap: 8px;
  margin-bottom: 36px;
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
  transition: opacity 0.7s ease 0.1s, transform 0.7s ease 0.1s;
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

/* ── Headline ────────────────────────────────── */
.hero-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(50px, 6vw, 92px);
  font-weight: 600; color: #fff;
  line-height: 1.04; letter-spacing: -0.01em;
  margin-bottom: 28px;
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.8s ease 0.25s, transform 0.8s ease 0.25s;
}
.hero-headline.visible { opacity: 1; transform: translateY(0); }
.hl-line-1 { color: #fff; }
.hl-line-2 {
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
  color: #b8c5d8; line-height: 1.85;
  max-width: 580px; margin-bottom: 32px;
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.8s ease 0.42s, transform 0.8s ease 0.42s;
  font-family: 'DM Sans', sans-serif;
}
.hero-sub.visible { opacity: 1; transform: translateY(0); }

/* ── Badges ──────────────────────────────────── */
.hero-badges {
  display: flex; flex-wrap: wrap; gap: 8px;
  margin-bottom: 40px;
  opacity: 0; transform: translateY(16px);
  transition: opacity 0.7s ease 0.55s, transform 0.7s ease 0.55s;
}
.hero-badges.visible { opacity: 1; transform: translateY(0); }
.badge {
  padding: 5px 14px;
  border: 1px solid rgba(255,255,255,0.12);
  font-size: 9px; font-weight: 500;
  letter-spacing: 0.12em; text-transform: uppercase;
  color: rgba(184,197,216,0.55);
  font-family: 'DM Mono', monospace;
}
.badge-hl {
  background: rgba(201,168,76,0.15);
  border-color: rgba(201,168,76,0.35);
  color: #c9a84c; font-weight: 700;
}

/* ── Stats ───────────────────────────────────── */
.hero-stats {
  display: flex; gap: 16px;
  margin-bottom: 44px;
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.8s ease 0.68s, transform 0.8s ease 0.68s;
}
.hero-stats.visible { opacity: 1; transform: translateY(0); }

.glass-stat {
  padding: 22px 28px 20px;
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(201,168,76,0.15);
  backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
  transition: background 0.3s, border-color 0.3s, transform 0.25s;
  cursor: default;
}
.glass-stat:hover {
  background: rgba(255,255,255,0.08);
  border-color: rgba(201,168,76,0.35);
  transform: translateY(-4px);
}
.stat-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 42px; font-weight: 700;
  color: #fff; line-height: 1; margin-bottom: 8px;
}
.stat-counter { display: inline-block; }
.stat-suffix { font-size: 20px; color: #c9a84c; vertical-align: super; margin-left: 2px; }
.stat-label {
  font-size: 9px; color: #8a9bbf;
  letter-spacing: 0.22em; text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}

/* ── Quote Card ──────────────────────────────── */
.hero-quote-card {
  position: relative;
  max-width: 640px;
  padding: 28px 32px;
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(201,168,76,0.15);
  border-left: 3px solid #c9a84c;
  overflow: hidden;
  opacity: 0; transform: translateY(16px);
  transition: opacity 0.7s ease 0.82s, transform 0.7s ease 0.82s;
}
.hero-quote-card.visible { opacity: 1; transform: translateY(0); }
.quote-shimmer {
  position: absolute; inset: 0;
  background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.04) 50%, transparent 60%);
  transform: translateX(-100%); transition: transform 0s;
}
.hero-quote-card:hover .quote-shimmer {
  transform: translateX(100%); transition: transform 0.7s ease;
}
.quote-text {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.2rem; font-style: italic; font-weight: 300;
  color: rgba(245,247,250,0.75); line-height: 1.55;
  margin-bottom: 12px;
}
.quote-cite {
  font-size: 10px; font-style: normal;
  letter-spacing: 0.12em; text-transform: uppercase;
  color: rgba(184,197,216,0.4); font-family: 'DM Mono', monospace;
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
  .hero-inner { padding: 48px 32px 72px; }
  .rings-group { display: none; }
  .hero-watermark { display: none; }
}
@media (max-width: 768px) {
  #wwa-hero { min-height: auto; }
  .hero-inner { padding: 40px 20px 56px; }
  .hero-stats { flex-wrap: wrap; }
  .glass-stat { flex: none; min-width: calc(50% - 8px); }
  .hero-badges { gap: 6px; }
}
@media (max-width: 480px) {
  .hero-headline { font-size: 38px; }
}
</style>
