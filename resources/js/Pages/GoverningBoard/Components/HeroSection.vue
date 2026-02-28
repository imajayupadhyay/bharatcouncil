<template>
  <section id="gb-hero" ref="heroEl">

    <!-- ══ SVG animated background ══ -->
    <svg class="hero-svg-bg" viewBox="0 0 1440 680" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <pattern id="gbGrid" width="90" height="90" patternUnits="userSpaceOnUse">
          <path d="M 90 0 L 0 0 0 90" fill="none" stroke="rgba(255,255,255,0.022)" stroke-width="1"/>
        </pattern>
        <radialGradient id="gbGlow1" cx="75%" cy="30%" r="42%">
          <stop offset="0%" stop-color="#c9a84c" stop-opacity="0.09"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="gbGlow2" cx="5%" cy="85%" r="36%">
          <stop offset="0%" stop-color="#162d55" stop-opacity="0.9"/>
          <stop offset="100%" stop-color="#162d55" stop-opacity="0"/>
        </radialGradient>
        <filter id="gbBlur4"><feGaussianBlur stdDeviation="4"/></filter>
        <filter id="gbBlur2"><feGaussianBlur stdDeviation="2"/></filter>
      </defs>

      <rect width="1440" height="680" fill="url(#gbGrid)"/>
      <rect width="1440" height="680" fill="url(#gbGlow1)"/>
      <rect width="1440" height="680" fill="url(#gbGlow2)"/>

      <!-- Ashoka rings — right side -->
      <g class="rings-group" transform="translate(1100, 340)">
        <circle r="280" fill="none" stroke="rgba(201,168,76,0.05)" stroke-width="1"/>
        <circle r="280" fill="none" stroke="rgba(201,168,76,0.11)" stroke-width="0.5" stroke-dasharray="4 26" class="ring-slow"/>
        <circle r="200" fill="none" stroke="rgba(201,168,76,0.07)" stroke-width="1"/>
        <circle r="200" fill="none" stroke="rgba(201,168,76,0.16)" stroke-width="0.5" stroke-dasharray="3 17" class="ring-mid"/>
        <circle r="130" fill="none" stroke="rgba(201,168,76,0.09)" stroke-width="1"/>
        <circle r="130" fill="none" stroke="rgba(201,168,76,0.20)" stroke-width="0.5" stroke-dasharray="2 11" class="ring-fast"/>
        <circle r="55"  fill="rgba(201,168,76,0.03)" filter="url(#gbBlur4)"/>
        <circle r="5"   fill="rgba(201,168,76,0.5)" class="core-pulse" filter="url(#gbBlur2)"/>
        <g class="ring-slow">
          <circle v-for="i in 24" :key="`g1-${i}`"
            :cx="280 * Math.cos((i-1) * 15 * Math.PI / 180)"
            :cy="280 * Math.sin((i-1) * 15 * Math.PI / 180)"
            r="1.5" fill="rgba(201,168,76,0.32)"/>
        </g>
        <g class="ring-mid-rev">
          <circle v-for="i in 16" :key="`g2-${i}`"
            :cx="200 * Math.cos((i-1) * 22.5 * Math.PI / 180)"
            :cy="200 * Math.sin((i-1) * 22.5 * Math.PI / 180)"
            r="2" fill="rgba(201,168,76,0.38)"/>
        </g>
        <g class="ring-fast-rev">
          <circle v-for="i in 12" :key="`g3-${i}`"
            :cx="130 * Math.cos((i-1) * 30 * Math.PI / 180)"
            :cy="130 * Math.sin((i-1) * 30 * Math.PI / 180)"
            r="2.5" fill="rgba(201,168,76,0.48)"/>
        </g>
      </g>

      <!-- Constellation -->
      <g>
        <line v-for="(e, i) in edges" :key="`e${i}`"
          :x1="nodes[e[0]].x" :y1="nodes[e[0]].y"
          :x2="nodes[e[1]].x" :y2="nodes[e[1]].y"
          stroke="rgba(201,168,76,0.09)" stroke-width="0.7"
          :class="`ep-${(i%4)+1}`"/>
        <g v-for="(n, i) in nodes" :key="`n${i}`">
          <circle :cx="n.x" :cy="n.y" r="3" fill="rgba(201,168,76,0.07)" :class="`nf-${(i%3)+1}`"/>
          <circle :cx="n.x" :cy="n.y" r="1.5" fill="rgba(201,168,76,0.48)" :class="`nf-${(i%3)+1}`"/>
        </g>
      </g>

      <!-- Particles -->
      <circle v-for="(p, i) in particles" :key="`p${i}`"
        :cx="p.x" :cy="p.y" :r="p.r"
        :fill="`rgba(201,168,76,${p.o})`"
        :class="`pd-${(i%5)+1}`"/>

      <line x1="-20" y1="180" x2="180" y2="-20" stroke="rgba(201,168,76,0.04)" stroke-width="1"/>
      <line x1="-20" y1="310" x2="310" y2="-20" stroke="rgba(201,168,76,0.03)" stroke-width="1"/>
    </svg>

    <!-- Watermark -->
    <div class="hero-watermark" aria-hidden="true">BOARD</div>

    <!-- Left accent bar -->
    <div class="hero-accent-bar"/>

    <!-- ══ Content ══ -->
    <div class="hero-inner">

      <!-- Breadcrumb -->
      <nav class="hero-breadcrumb" :class="{ visible: revealed }">
        <a href="/">Home</a>
        <span class="bc-sep">/</span>
        <a href="/who-we-are">About</a>
        <span class="bc-sep">/</span>
        <span class="bc-current">Governing Board</span>
      </nav>

      <!-- Eyebrow -->
      <div class="hero-eyebrow" :class="{ visible: revealed }">
        <span class="eyebrow-line"/>
        <span class="eyebrow-dot"/>
        <span class="eyebrow-text">About BGC</span>
      </div>

      <!-- Headline -->
      <h1 class="hero-headline" :class="{ visible: revealed }">
        Governing <em class="hl-em">Board</em>
      </h1>

      <!-- Sub -->
      <p class="hero-sub" :class="{ visible: revealed }">
        The Bharat Governance Council is guided by a Governing Board of distinguished retired officers
        of India's All India Services and allied cadres — men and women who have, collectively, governed
        at the highest levels of the Indian state. They bring to BGC not theory, but lived administrative
        experience across every domain of public governance.
      </p>

      <!-- Stats row -->
      <div class="hero-stats" :class="{ visible: revealed }">
        <div v-for="stat in stats" :key="stat.label" class="hero-stat">
          <div class="hs-num">{{ stat.num }}</div>
          <div class="hs-lbl">{{ stat.label }}</div>
        </div>
      </div>

    </div>

    <!-- Bottom gold bar -->
    <div class="hero-gold-bar"><div class="gold-bar-shimmer"/></div>

  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const heroEl  = ref(null)
const revealed = ref(false)

const nodes = [
  { x: 75,  y: 160 }, { x: 170, y: 80  }, { x: 270, y: 240 },
  { x: 130, y: 360 }, { x: 310, y: 140 }, { x: 55,  y: 490 },
  { x: 230, y: 450 }, { x: 370, y: 310 }, { x: 150, y: 580 },
  { x: 390, y: 470 }, { x: 490, y: 190 }, { x: 470, y: 400 },
  { x: 550, y: 560 }, { x: 610, y: 110 },
]
const edges = [
  [0,1],[1,4],[4,10],[10,13],[13,7],[7,11],[11,9],
  [9,12],[12,8],[8,6],[6,3],[3,0],[2,4],[2,7],[5,3],[5,8],
]

const particles = Array.from({ length: 28 }, (_, i) => ({
  x: (i * 137.5) % 1440,
  y: (i * 97.3)  % 680,
  r: 0.7 + (i % 4) * 0.5,
  o: 0.1 + (i % 5) * 0.06,
}))

const stats = [
  { num: '15+',  label: 'Board Members' },
  { num: '6',    label: 'All India Services' },
  { num: '30+',  label: 'Avg. Years of Service' },
  { num: '2023', label: 'Year Established' },
]

onMounted(() => {
  requestAnimationFrame(() => setTimeout(() => { revealed.value = true }, 100))
})
</script>

<style scoped>
/* ── Section ─────────────────────────────────── */
#gb-hero {
  position: relative;
  background: #0b1c38;
  padding-top: 72px;
  min-height: 72vh;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.hero-watermark {
  position: absolute;
  right: -1.5rem; top: 50%; transform: translateY(-50%);
  font-family: 'Cormorant Garamond', serif;
  font-size: 18rem; font-weight: 700; letter-spacing: -0.04em;
  color: rgba(255,255,255,0.018); pointer-events: none; white-space: nowrap;
  z-index: 1; line-height: 1;
}

.hero-accent-bar {
  position: absolute;
  left: 0; top: 72px; bottom: 0;
  width: 4px;
  background: linear-gradient(to bottom, #c9a84c, rgba(201,168,76,0.2));
  z-index: 3;
}

/* ── SVG ─────────────────────────────────────── */
.hero-svg-bg { position: absolute; inset: 0; width: 100%; height: 100%; pointer-events: none; }

.ring-slow    { animation: spinCW  40s linear infinite; transform-origin: 0 0; }
.ring-mid     { animation: spinCCW 28s linear infinite; transform-origin: 0 0; }
.ring-fast    { animation: spinCW  18s linear infinite; transform-origin: 0 0; }
.ring-mid-rev { animation: spinCCW 32s linear infinite; transform-origin: 0 0; }
.ring-fast-rev{ animation: spinCW  22s linear infinite; transform-origin: 0 0; }
@keyframes spinCW  { to { transform: rotate(360deg);  } }
@keyframes spinCCW { to { transform: rotate(-360deg); } }

.core-pulse { animation: corePulse 2.4s ease-in-out infinite; }
@keyframes corePulse { 0%,100%{r:5;opacity:0.5} 50%{r:13;opacity:0.15} }

.ep-1 { animation: edgeFade 3.8s ease-in-out infinite 0.0s; }
.ep-2 { animation: edgeFade 3.8s ease-in-out infinite 0.9s; }
.ep-3 { animation: edgeFade 3.8s ease-in-out infinite 1.8s; }
.ep-4 { animation: edgeFade 3.8s ease-in-out infinite 2.7s; }
@keyframes edgeFade { 0%,100%{opacity:0.3} 50%{opacity:1} }

.nf-1 { animation: nodeFloat 6s ease-in-out infinite 0.0s; }
.nf-2 { animation: nodeFloat 7s ease-in-out infinite 1.2s; }
.nf-3 { animation: nodeFloat 8s ease-in-out infinite 2.4s; }
@keyframes nodeFloat { 0%,100%{transform:translate(0,0)} 33%{transform:translate(3px,-4px)} 66%{transform:translate(-3px,2px)} }

.pd-1 { animation: d1 14s ease-in-out infinite; }
.pd-2 { animation: d2 18s ease-in-out infinite 2s; }
.pd-3 { animation: d3 12s ease-in-out infinite 4s; }
.pd-4 { animation: d4 20s ease-in-out infinite 1s; }
.pd-5 { animation: d5 16s ease-in-out infinite 3s; }
@keyframes d1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(8px,-12px)} }
@keyframes d2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-10px,8px)} }
@keyframes d3 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(6px,14px)} }
@keyframes d4 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-8px,-10px)} }
@keyframes d5 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(12px,6px)} }

/* ── Inner ───────────────────────────────────── */
.hero-inner {
  position: relative; z-index: 2;
  max-width: 1280px; margin: 0 auto;
  padding: 52px 60px 68px 80px;
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
  color: rgba(184,197,216,0.45); text-decoration: none; transition: color 0.2s;
}
.hero-breadcrumb a:hover { color: rgba(184,197,216,0.8); }
.bc-sep { font-size: 10px; color: rgba(184,197,216,0.22); }
.bc-current {
  font-size: 11px; font-family: 'DM Sans', sans-serif;
  letter-spacing: 0.12em; text-transform: uppercase;
  color: rgba(201,168,76,0.75);
}

/* ── Eyebrow ─────────────────────────────────── */
.hero-eyebrow {
  display: flex; align-items: center; gap: 12px;
  margin-bottom: 24px;
  opacity: 0; transform: translateY(16px);
  transition: opacity 0.7s ease 0.1s, transform 0.7s ease 0.1s;
}
.hero-eyebrow.visible { opacity: 1; transform: translateY(0); }
.eyebrow-line { display: block; width: 28px; height: 1px; background: linear-gradient(90deg, transparent, #c9a84c); }
.eyebrow-dot {
  display: block; width: 4px; height: 4px; border-radius: 50%;
  background: #c9a84c; box-shadow: 0 0 6px rgba(201,168,76,0.8);
  animation: dotPulse 2s ease-in-out infinite;
}
@keyframes dotPulse { 0%,100%{box-shadow:0 0 6px rgba(201,168,76,0.8)} 50%{box-shadow:0 0 14px rgba(201,168,76,1)} }
.eyebrow-text {
  font-size: 11px; font-weight: 500;
  color: #c9a84c; letter-spacing: 0.3em; text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}

/* ── Headline ────────────────────────────────── */
.hero-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(52px, 6.5vw, 100px);
  font-weight: 600; color: #f5f7fa;
  line-height: 1.03; letter-spacing: -0.01em;
  margin-bottom: 28px;
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.85s ease 0.24s, transform 0.85s ease 0.24s;
}
.hero-headline.visible { opacity: 1; transform: translateY(0); }
.hl-em {
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
  color: #b8c5d8; line-height: 1.82;
  max-width: 620px; margin-bottom: 48px;
  opacity: 0; transform: translateY(18px);
  transition: opacity 0.8s ease 0.42s, transform 0.8s ease 0.42s;
  font-family: 'DM Sans', sans-serif;
}
.hero-sub.visible { opacity: 1; transform: translateY(0); }

/* ── Stats ───────────────────────────────────── */
.hero-stats {
  display: flex; gap: 0;
  border-top: 1px solid rgba(201,168,76,0.15);
  padding-top: 32px;
  opacity: 0; transform: translateY(14px);
  transition: opacity 0.7s ease 0.6s, transform 0.7s ease 0.6s;
}
.hero-stats.visible { opacity: 1; transform: translateY(0); }

.hero-stat {
  padding: 0 44px 0 0;
  border-right: 1px solid rgba(255,255,255,0.07);
  margin-right: 44px;
  cursor: default;
}
.hero-stat:last-child { border-right: none; margin-right: 0; }

.hs-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 2.6rem; font-weight: 700;
  color: #fff; line-height: 1; margin-bottom: 6px;
}
.hs-lbl {
  font-size: 9px; font-weight: 500;
  color: #8a9bbf; letter-spacing: 0.2em; text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
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
  .hero-inner { padding: 48px 32px 60px 48px; }
  .rings-group { display: none; }
  .hero-watermark { display: none; }
}
@media (max-width: 768px) {
  #gb-hero { min-height: auto; }
  .hero-inner { padding: 40px 20px 52px 32px; }
  .hero-stats { flex-wrap: wrap; gap: 20px; }
  .hero-stat { border-right: none; margin-right: 0; padding-right: 0; min-width: 50%; }
}
@media (max-width: 480px) {
  .hero-headline { font-size: 40px; }
  .hero-accent-bar { display: none; }
}
</style>
