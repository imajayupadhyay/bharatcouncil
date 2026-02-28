<template>
  <section id="gb-hero">

    <!-- ══ SVG — Governance Architecture ══ -->
    <svg class="hero-svg-bg" viewBox="0 0 1440 680" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <!-- Fine blueprint grid (30px) -->
        <pattern id="gbFine" width="30" height="30" patternUnits="userSpaceOnUse">
          <line x1="30" y1="0" x2="30" y2="30" stroke="rgba(255,255,255,0.010)" stroke-width="0.4"/>
          <line x1="0" y1="30" x2="30" y2="30" stroke="rgba(255,255,255,0.010)" stroke-width="0.4"/>
        </pattern>
        <!-- Major grid overlay (90px) -->
        <pattern id="gbMajor" width="90" height="90" patternUnits="userSpaceOnUse">
          <line x1="90" y1="0" x2="90" y2="90" stroke="rgba(255,255,255,0.020)" stroke-width="0.7"/>
          <line x1="0" y1="90" x2="90" y2="90" stroke="rgba(255,255,255,0.020)" stroke-width="0.7"/>
        </pattern>

        <!-- Glows -->
        <radialGradient id="gbGlowR" cx="82%" cy="45%" r="40%">
          <stop offset="0%"   stop-color="#c9a84c" stop-opacity="0.10"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="gbGlowL" cx="2%" cy="88%" r="34%">
          <stop offset="0%"   stop-color="#0f2347" stop-opacity="1"/>
          <stop offset="100%" stop-color="#0f2347" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="gbGlowTree" cx="78%" cy="55%" r="28%">
          <stop offset="0%"   stop-color="#c9a84c" stop-opacity="0.05"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>

        <filter id="gbBlur5"><feGaussianBlur stdDeviation="5"/></filter>
        <filter id="gbBlur2"><feGaussianBlur stdDeviation="2"/></filter>
      </defs>

      <!-- Blueprint grid layers -->
      <rect width="1440" height="680" fill="url(#gbFine)"/>
      <rect width="1440" height="680" fill="url(#gbMajor)"/>
      <!-- Glows -->
      <rect width="1440" height="680" fill="url(#gbGlowR)"/>
      <rect width="1440" height="680" fill="url(#gbGlowL)"/>
      <rect width="1440" height="680" fill="url(#gbGlowTree)"/>

      <!-- ══ ORG CHART / HIERARCHY TREE ══ -->
      <g class="org-tree">

        <!-- Connector lines (L-shaped, blueprint style) -->
        <line v-for="(c, i) in connectors" :key="`con${i}`"
          :x1="c.x1" :y1="c.y1" :x2="c.x2" :y2="c.y2"
          stroke="rgba(201,168,76,0.22)" stroke-width="0.8"
          :class="`con-${(i % 4) + 1}`"/>

        <!-- Junction dots at connection points -->
        <circle v-for="(j, i) in junctions" :key="`jn${i}`"
          :cx="j.x" :cy="j.y" r="2.2"
          fill="rgba(201,168,76,0.55)"
          :class="`jn-${(i % 3) + 1}`"/>

        <!-- ── L0: Chairman ── -->
        <g :class="`node-g-0`">
          <rect
            :x="l0.cx - NW/2" :y="l0.cy - NH/2"
            :width="NW" :height="NH"
            fill="rgba(201,168,76,0.10)"
            stroke="rgba(201,168,76,0.55)" stroke-width="1"/>
          <text :x="l0.cx" :y="l0.cy + 3" text-anchor="middle"
            font-size="9" fill="rgba(201,168,76,0.9)"
            font-family="DM Mono, monospace" font-weight="700"
            letter-spacing="1">{{ l0.label }}</text>
          <!-- Chairman label -->
          <text :x="l0.cx" :y="l0.cy - NH/2 - 6" text-anchor="middle"
            font-size="7" fill="rgba(201,168,76,0.5)"
            font-family="DM Mono, monospace" letter-spacing="0.5">CHAIRMAN</text>
        </g>

        <!-- ── L1: Executive Officers ── -->
        <g v-for="(n, i) in l1Nodes" :key="`l1n${i}`" :class="`node-g-${i + 1}`">
          <rect
            :x="n.cx - NW/2" :y="n.cy - NH/2"
            :width="NW" :height="NH"
            fill="rgba(201,168,76,0.07)"
            stroke="rgba(201,168,76,0.38)" stroke-width="0.8"/>
          <text :x="n.cx" :y="n.cy + 3" text-anchor="middle"
            font-size="9" fill="rgba(201,168,76,0.75)"
            font-family="DM Mono, monospace" font-weight="700"
            letter-spacing="1">{{ n.label }}</text>
        </g>

        <!-- ── L2: Board Members ── -->
        <g v-for="(n, i) in l2Nodes" :key="`l2n${i}`" :class="`node-g-${(i % 5) + 3}`">
          <rect
            :x="n.cx - NW/2 + 4" :y="n.cy - NH/2"
            :width="NW - 8" :height="NH"
            fill="rgba(201,168,76,0.04)"
            stroke="rgba(201,168,76,0.25)" stroke-width="0.7"/>
          <text :x="n.cx" :y="n.cy + 3" text-anchor="middle"
            font-size="8" fill="rgba(201,168,76,0.6)"
            font-family="DM Mono, monospace" font-weight="700"
            letter-spacing="0.5">{{ n.label }}</text>
        </g>

        <!-- Subtly glowing area behind the chart -->
        <ellipse cx="1195" cy="220" rx="280" ry="180"
          fill="rgba(201,168,76,0.02)" filter="url(#gbBlur5)"/>
      </g>

      <!-- ══ DOCUMENT STACK (left — charter hierarchy) ══ -->
      <g transform="translate(24, 96)" class="doc-stack" opacity="0.9">
        <rect v-for="(line, i) in docLines" :key="`dl${i}`"
          :x="line.indent"
          :y="i * 17"
          :width="line.w"
          height="1.5"
          :fill="`rgba(201,168,76,${line.o})`"
          :class="`doc-${(i % 4) + 1}`"/>
        <!-- Vertical rule on left -->
        <line x1="0" y1="0" x2="0" :y2="docLines.length * 17"
          stroke="rgba(201,168,76,0.18)" stroke-width="1"/>
        <!-- Corner mark -->
        <rect x="-4" y="-4" width="8" height="8"
          fill="none" stroke="rgba(201,168,76,0.4)" stroke-width="0.8"/>
      </g>

      <!-- ══ DRIFTING DASH PARTICLES ══ -->
      <line v-for="(d, i) in dashes" :key="`dash${i}`"
        :x1="d.x" :y1="d.y"
        :x2="d.x + d.w" :y2="d.y"
        :stroke="`rgba(201,168,76,${d.o})`"
        stroke-width="1"
        stroke-linecap="round"
        :class="`dash-${(i % 4) + 1}`"/>

      <!-- Blueprint corner marks (decorative) -->
      <g opacity="0.12">
        <polyline points="0,50 0,0 50,0"   fill="none" stroke="#c9a84c" stroke-width="1.2"/>
        <polyline points="1390,0 1440,0 1440,50" fill="none" stroke="#c9a84c" stroke-width="1.2"/>
        <polyline points="1440,630 1440,680 1390,680" fill="none" stroke="#c9a84c" stroke-width="1.2"/>
        <polyline points="50,680 0,680 0,630" fill="none" stroke="#c9a84c" stroke-width="1.2"/>
        <!-- Center crosshair -->
        <line x1="716" y1="334" x2="724" y2="334" stroke="#c9a84c" stroke-width="0.8"/>
        <line x1="720" y1="330" x2="720" y2="338" stroke="#c9a84c" stroke-width="0.8"/>
        <circle cx="720" cy="334" r="6" fill="none" stroke="#c9a84c" stroke-width="0.6"/>
      </g>
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

const revealed = ref(false)

/* ── Node dimensions ── */
const NW = 48, NH = 22

/* ── L0: Chairman ── */
const l0 = { cx: 1195, cy: 68, label: 'KV' }

/* ── L1: Executive Officers ── */
const l1Nodes = [
  { cx: 1065, cy: 174, label: 'SK' },
  { cx: 1325, cy: 174, label: 'AG' },
]

/* ── L2: Board Members ── */
const l2Left = [
  { cx: 950,  cy: 298, label: 'SO' },
  { cx: 1008, cy: 298, label: 'SG' },
  { cx: 1066, cy: 298, label: 'MB' },
  { cx: 1124, cy: 298, label: 'NJ' },
]
const l2Right = [
  { cx: 1187, cy: 298, label: 'SS' },
  { cx: 1245, cy: 298, label: 'AC' },
  { cx: 1303, cy: 298, label: 'RD' },
  { cx: 1361, cy: 298, label: 'AS' },
  { cx: 1416, cy: 298, label: 'SI' },
]
const l2Nodes = [...l2Left, ...l2Right]

/* ── Connector lines ── */
const BAR_L1 = 138   // y of L0 → L1 horizontal bar
const BAR_L2 = 258   // y of L1 → L2 horizontal bars

const connectors = [
  // L0 trunk down
  { x1: 1195, y1: l0.cy + NH/2, x2: 1195, y2: BAR_L1 },
  // L0→L1 horizontal bar
  { x1: 1065, y1: BAR_L1, x2: 1325, y2: BAR_L1 },
  // Drops to L1 nodes
  { x1: 1065, y1: BAR_L1, x2: 1065, y2: l1Nodes[0].cy - NH/2 },
  { x1: 1325, y1: BAR_L1, x2: 1325, y2: l1Nodes[1].cy - NH/2 },

  // L1-left trunk
  { x1: 1065, y1: l1Nodes[0].cy + NH/2, x2: 1065, y2: BAR_L2 },
  // L2-left bar
  { x1: 950,  y1: BAR_L2, x2: 1124, y2: BAR_L2 },
  // Drops to L2-left
  { x1: 950,  y1: BAR_L2, x2: 950,  y2: l2Left[0].cy - NH/2 },
  { x1: 1008, y1: BAR_L2, x2: 1008, y2: l2Left[1].cy - NH/2 },
  { x1: 1066, y1: BAR_L2, x2: 1066, y2: l2Left[2].cy - NH/2 },
  { x1: 1124, y1: BAR_L2, x2: 1124, y2: l2Left[3].cy - NH/2 },

  // L1-right trunk
  { x1: 1325, y1: l1Nodes[1].cy + NH/2, x2: 1325, y2: BAR_L2 },
  // L2-right bar
  { x1: 1187, y1: BAR_L2, x2: 1416, y2: BAR_L2 },
  // Drops to L2-right
  { x1: 1187, y1: BAR_L2, x2: 1187, y2: l2Right[0].cy - NH/2 },
  { x1: 1245, y1: BAR_L2, x2: 1245, y2: l2Right[1].cy - NH/2 },
  { x1: 1303, y1: BAR_L2, x2: 1303, y2: l2Right[2].cy - NH/2 },
  { x1: 1361, y1: BAR_L2, x2: 1361, y2: l2Right[3].cy - NH/2 },
  { x1: 1416, y1: BAR_L2, x2: 1416, y2: l2Right[4].cy - NH/2 },
]

/* ── Junction dots ── */
const junctions = [
  { x: 1195, y: BAR_L1 },
  { x: 1065, y: BAR_L1 }, { x: 1325, y: BAR_L1 },
  { x: 1065, y: BAR_L2 }, { x: 1325, y: BAR_L2 },
  ...l2Left.map(n  => ({ x: n.cx,  y: BAR_L2 })),
  ...l2Right.map(n => ({ x: n.cx,  y: BAR_L2 })),
]

/* ── Document stack (left side) ── */
const docLines = [
  { indent: 0,  w: 130, o: 0.28 }, // Title
  { indent: 0,  w: 85,  o: 0.18 }, // Subtitle
  { indent: 14, w: 105, o: 0.13 }, // Body line
  { indent: 14, w: 65,  o: 0.11 },
  { indent: 14, w: 118, o: 0.13 },
  { indent: 14, w: 78,  o: 0.11 },
  { indent: 0,  w: 100, o: 0.18 }, // Section heading
  { indent: 14, w: 88,  o: 0.12 },
  { indent: 14, w: 115, o: 0.13 },
  { indent: 28, w: 70,  o: 0.09 }, // Sub-body
  { indent: 28, w: 90,  o: 0.09 },
  { indent: 28, w: 55,  o: 0.09 },
  { indent: 14, w: 102, o: 0.12 },
  { indent: 0,  w: 95,  o: 0.18 }, // Section
  { indent: 14, w: 75,  o: 0.12 },
  { indent: 14, w: 108, o: 0.13 },
]

/* ── Drifting dash particles ── */
const dashes = Array.from({ length: 22 }, (_, i) => ({
  x: (i * 173.7) % 1440,
  y: (i * 91.3)  % 680,
  w: 8 + (i % 6) * 7,
  o: 0.05 + (i % 5) * 0.04,
}))

/* ── Stats ── */
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
  color: rgba(255,255,255,0.016); pointer-events: none; white-space: nowrap;
  z-index: 1; line-height: 1;
}

.hero-accent-bar {
  position: absolute;
  left: 0; top: 72px; bottom: 0; width: 4px;
  background: linear-gradient(to bottom, #c9a84c, rgba(201,168,76,0.2));
  z-index: 3;
}

/* ── SVG ─────────────────────────────────────── */
.hero-svg-bg {
  position: absolute; inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}

/* ── ORG TREE ANIMATIONS ─────────────────────── */
/* Connector lines — staggered opacity pulse */
.con-1 { animation: conPulse 5s ease-in-out infinite 0.0s; }
.con-2 { animation: conPulse 5s ease-in-out infinite 1.2s; }
.con-3 { animation: conPulse 5s ease-in-out infinite 2.4s; }
.con-4 { animation: conPulse 5s ease-in-out infinite 3.6s; }
@keyframes conPulse { 0%,100%{opacity:0.4} 50%{opacity:1} }

/* Junction dots */
.jn-1 { animation: jnPulse 3.5s ease-in-out infinite 0.0s; }
.jn-2 { animation: jnPulse 3.5s ease-in-out infinite 1.1s; }
.jn-3 { animation: jnPulse 3.5s ease-in-out infinite 2.2s; }
@keyframes jnPulse { 0%,100%{opacity:0.4} 50%{opacity:1} }

/* Node groups — staggered glow */
.node-g-0 { animation: nodeGlow 4s ease-in-out infinite 0.0s; }
.node-g-1 { animation: nodeGlow 4s ease-in-out infinite 0.6s; }
.node-g-2 { animation: nodeGlow 4s ease-in-out infinite 1.2s; }
.node-g-3 { animation: nodeGlow 4s ease-in-out infinite 1.8s; }
.node-g-4 { animation: nodeGlow 4s ease-in-out infinite 2.4s; }
.node-g-5 { animation: nodeGlow 4s ease-in-out infinite 3.0s; }
.node-g-6 { animation: nodeGlow 4s ease-in-out infinite 3.6s; }
.node-g-7 { animation: nodeGlow 4s ease-in-out infinite 0.3s; }
@keyframes nodeGlow { 0%,100%{opacity:0.55} 50%{opacity:1} }

/* ── DOCUMENT STACK ANIMATIONS ───────────────── */
.doc-1 { animation: docFade 6s ease-in-out infinite 0.0s; }
.doc-2 { animation: docFade 6s ease-in-out infinite 1.5s; }
.doc-3 { animation: docFade 6s ease-in-out infinite 3.0s; }
.doc-4 { animation: docFade 6s ease-in-out infinite 4.5s; }
@keyframes docFade { 0%,100%{opacity:0.6} 50%{opacity:1} }

/* ── DASH PARTICLE ANIMATIONS ────────────────── */
.dash-1 { animation: dashD1 18s ease-in-out infinite; }
.dash-2 { animation: dashD2 22s ease-in-out infinite 3s; }
.dash-3 { animation: dashD3 16s ease-in-out infinite 6s; }
.dash-4 { animation: dashD4 20s ease-in-out infinite 1s; }
@keyframes dashD1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(14px,-8px)} }
@keyframes dashD2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-10px,12px)} }
@keyframes dashD3 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(16px,6px)} }
@keyframes dashD4 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-12px,-10px)} }

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
  font-size: 11px; font-weight: 500; color: #c9a84c;
  letter-spacing: 0.3em; text-transform: uppercase;
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
  margin-right: 44px; cursor: default;
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
  .hero-watermark { display: none; }
  .org-tree { display: none; }
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
