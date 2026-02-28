<template>
  <section id="wwa-hero" ref="heroEl">

    <!-- ══ SVG — Institutional Compass Seal ══ -->
    <svg class="hero-svg-bg" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <!-- Diamond / argyle grid (45° crossed lines) -->
        <pattern id="wwaDiag" width="72" height="72" patternUnits="userSpaceOnUse">
          <line x1="0" y1="72" x2="72" y2="0" stroke="rgba(255,255,255,0.018)" stroke-width="0.7"/>
          <line x1="0" y1="0"  x2="72" y2="72" stroke="rgba(255,255,255,0.010)" stroke-width="0.5"/>
        </pattern>

        <!-- Glows -->
        <radialGradient id="wwaGlowSeal" cx="76%" cy="44%" r="42%">
          <stop offset="0%"   stop-color="#c9a84c" stop-opacity="0.10"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="wwaGlowL" cx="4%" cy="88%" r="32%">
          <stop offset="0%"   stop-color="#0f2347" stop-opacity="0.95"/>
          <stop offset="100%" stop-color="#0f2347" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="wwaGlowCenter" cx="42%" cy="50%" r="30%">
          <stop offset="0%"   stop-color="#162d55" stop-opacity="0.5"/>
          <stop offset="100%" stop-color="#162d55" stop-opacity="0"/>
        </radialGradient>

        <filter id="wwaBlur8"><feGaussianBlur stdDeviation="8"/></filter>
        <filter id="wwaBlur3"><feGaussianBlur stdDeviation="3"/></filter>
        <filter id="wwaBlur1"><feGaussianBlur stdDeviation="1.5"/></filter>
      </defs>

      <!-- Base diamond grid -->
      <rect width="1440" height="900" fill="url(#wwaDiag)"/>
      <!-- Glows -->
      <rect width="1440" height="900" fill="url(#wwaGlowSeal)"/>
      <rect width="1440" height="900" fill="url(#wwaGlowL)"/>
      <rect width="1440" height="900" fill="url(#wwaGlowCenter)"/>

      <!-- ══ INSTITUTIONAL COMPASS SEAL (right side) ══ -->
      <g transform="translate(1090, 430)">

        <!-- 16 radiating spokes — compass rose pattern (static, pulse opacity) -->
        <line v-for="i in 16" :key="`sp${i}`"
          x1="0" y1="0"
          :x2="340 * Math.cos((i-1) * 22.5 * Math.PI / 180)"
          :y2="340 * Math.sin((i-1) * 22.5 * Math.PI / 180)"
          stroke="rgba(201,168,76,0.05)" stroke-width="0.8"
          :class="`spoke-${((i-1) % 4) + 1}`"/>

        <!-- Spoke tips — small diamonds at end of each spoke -->
        <g v-for="i in 16" :key="`spt${i}`">
          <polygon
            :points="diamondPts(
              335 * Math.cos((i-1) * 22.5 * Math.PI / 180),
              335 * Math.sin((i-1) * 22.5 * Math.PI / 180), 3.5
            )"
            :fill="`rgba(201,168,76,${(i % 2 === 0) ? 0.35 : 0.18})`"
            :class="`spoke-${((i-1) % 4) + 1}`"/>
        </g>

        <!-- Outer octagon group (slow CW rotation) -->
        <g class="oct-outer">
          <polygon :points="octPts(290)" fill="none" stroke="rgba(201,168,76,0.06)" stroke-width="1"/>
          <polygon :points="octPts(290)" fill="none" stroke="rgba(201,168,76,0.13)" stroke-width="0.5" stroke-dasharray="5 24"/>
          <!-- Vertex markers — larger diamonds -->
          <polygon v-for="i in 8" :key="`ov${i}`"
            :points="diamondPts(
              290 * Math.cos(((i-1)*45 + 22.5) * Math.PI / 180),
              290 * Math.sin(((i-1)*45 + 22.5) * Math.PI / 180), 5
            )"
            fill="rgba(201,168,76,0.42)"/>
        </g>

        <!-- Mid octagon group (medium CCW rotation) -->
        <g class="oct-mid">
          <polygon :points="octPts(208)" fill="none" stroke="rgba(201,168,76,0.07)" stroke-width="1"/>
          <polygon :points="octPts(208)" fill="none" stroke="rgba(201,168,76,0.16)" stroke-width="0.5" stroke-dasharray="4 17"/>
          <!-- Vertex markers — small circles -->
          <circle v-for="i in 8" :key="`mv${i}`"
            :cx="208 * Math.cos(((i-1)*45 + 22.5) * Math.PI / 180)"
            :cy="208 * Math.sin(((i-1)*45 + 22.5) * Math.PI / 180)"
            r="2.5" fill="rgba(201,168,76,0.4)"/>
        </g>

        <!-- Inner octagon group (faster CW rotation) -->
        <g class="oct-inner">
          <polygon :points="octPts(125)" fill="none" stroke="rgba(201,168,76,0.09)" stroke-width="1"/>
          <polygon :points="octPts(125)" fill="none" stroke="rgba(201,168,76,0.20)" stroke-width="0.5" stroke-dasharray="2.5 10"/>
          <!-- 4 axis-aligned corner accents -->
          <line x1="-125" y1="0"  x2="-105" y2="0"  stroke="rgba(201,168,76,0.3)" stroke-width="1.5"/>
          <line x1="105"  y1="0"  x2="125"  y2="0"  stroke="rgba(201,168,76,0.3)" stroke-width="1.5"/>
          <line x1="0" y1="-125" x2="0" y2="-105" stroke="rgba(201,168,76,0.3)" stroke-width="1.5"/>
          <line x1="0" y1="105"  x2="0" y2="125"  stroke="rgba(201,168,76,0.3)" stroke-width="1.5"/>
        </g>

        <!-- Center glow layers -->
        <circle r="55"  fill="rgba(201,168,76,0.04)"  filter="url(#wwaBlur8)"/>
        <circle r="20"  fill="rgba(201,168,76,0.08)"  filter="url(#wwaBlur3)"/>
        <circle r="8"   fill="rgba(201,168,76,0.20)"  class="seal-core" filter="url(#wwaBlur1)"/>
        <circle r="3"   fill="rgba(201,168,76,0.85)"  class="seal-dot"/>
        <!-- Cross reticle at center -->
        <line x1="-18" y1="0" x2="18" y2="0" stroke="rgba(201,168,76,0.25)" stroke-width="0.8"/>
        <line x1="0" y1="-18" x2="0" y2="18" stroke="rgba(201,168,76,0.25)" stroke-width="0.8"/>
      </g>

      <!-- ══ VERTICAL SERVICE-RECORD BARS (left edge, subtle) ══ -->
      <g transform="translate(0, 0)">
        <rect v-for="(bar, i) in bars" :key="`vb${i}`"
          :x="16 + i * 20"
          :y="900 - bar.h"
          width="5"
          :height="bar.h"
          :fill="`rgba(201,168,76,${bar.o})`"
          :class="`bar-p${(i % 3) + 1}`"/>
        <!-- Baseline -->
        <line :x1="14" y1="900" :x2="14 + bars.length * 20 + 8" y2="900"
          stroke="rgba(201,168,76,0.15)" stroke-width="0.8"/>
      </g>

      <!-- ══ DIAMOND SCATTER PARTICLES ══ -->
      <polygon v-for="(d, i) in diamonds" :key="`d${i}`"
        :points="diamondPts(d.x, d.y, d.s)"
        :fill="`rgba(201,168,76,${d.o})`"
        :class="`dd-${(i % 5) + 1}`"/>

      <!-- ══ SUBTLE HORIZONTAL SCAN LINES ══ -->
      <line x1="0" y1="280" x2="820" y2="280" stroke="rgba(201,168,76,0.03)" stroke-width="0.5"/>
      <line x1="0" y1="560" x2="720" y2="560" stroke="rgba(201,168,76,0.025)" stroke-width="0.5"/>
      <line x1="0" y1="780" x2="650" y2="780" stroke="rgba(201,168,76,0.02)" stroke-width="0.5"/>

      <!-- Corner bracket — top left decorative -->
      <g opacity="0.15">
        <polyline points="0,60 0,0 60,0" fill="none" stroke="#c9a84c" stroke-width="1"/>
        <circle cx="0" cy="0" r="2" fill="#c9a84c"/>
      </g>
    </svg>

    <!-- Watermark -->
    <div class="hero-watermark" aria-hidden="true">BGC</div>

    <!-- ══ Content (same structure) ══ -->
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
        <span class="hl-plain">Where </span><em class="hl-gold">Experience</em><br>
        <span class="hl-plain">Meets </span><em class="hl-gold">Purpose</em>
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
            <span class="stat-counter">{{ stat.display }}</span><span class="stat-suffix">{{ stat.suffix }}</span>
          </div>
          <div class="stat-label">{{ stat.label }}</div>
        </div>
      </div>

      <!-- Quote -->
      <div class="hero-quote-card" :class="{ visible: revealed }">
        <div class="quote-shimmer"/>
        <div class="quote-mark">"</div>
        <blockquote class="quote-text">Decades of service taught us that governance is too important to be left only to those currently in office. Wisdom must be passed on — deliberately, urgently.</blockquote>
        <cite class="quote-cite">— Dr. Kush Verma, IAS 1979 · Chairman &amp; Co-Founder</cite>
      </div>

    </div>

    <!-- Bottom gold bar -->
    <div class="hero-gold-bar"><div class="gold-bar-shimmer"/></div>

  </section>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'

const revealed = ref(false)

/* ── Octagon points at radius r (flat-top orientation) ── */
function octPts(r) {
  return Array.from({ length: 8 }, (_, i) => {
    const a = ((i * 45) + 22.5) * Math.PI / 180
    return `${(r * Math.cos(a)).toFixed(2)},${(r * Math.sin(a)).toFixed(2)}`
  }).join(' ')
}

/* ── Diamond (rotated square) centred at cx,cy with half-size s ── */
function diamondPts(cx, cy, s) {
  return `${cx},${cy - s} ${cx + s},${cy} ${cx},${cy + s} ${cx - s},${cy}`
}

/* ── Vertical service bars data ── */
const bars = [
  { h: 90,  o: 0.07 }, { h: 160, o: 0.05 }, { h: 70,  o: 0.08 },
  { h: 220, o: 0.06 }, { h: 110, o: 0.07 }, { h: 180, o: 0.05 },
  { h: 80,  o: 0.08 }, { h: 240, o: 0.06 }, { h: 60,  o: 0.07 },
  { h: 195, o: 0.05 }, { h: 130, o: 0.08 }, { h: 170, o: 0.06 },
  { h: 100, o: 0.07 }, { h: 210, o: 0.05 },
]

/* ── Diamond scatter particles ── */
const diamonds = Array.from({ length: 28 }, (_, i) => ({
  x: (i * 137.5) % 1440,
  y: (i * 97.3)  % 900,
  s: 2 + (i % 5) * 1.2,
  o: 0.07 + (i % 5) * 0.05,
}))

/* ── Stats with counter animation ── */
const stats = reactive([
  { label: 'Year Founded',          suffix: '',  target: 2023, display: 0 },
  { label: 'Young Officers / Year', suffix: '+', target: 100,  display: 0 },
  { label: 'Founding Members',      suffix: '+', target: 15,   display: 0 },
])

function animateCounters() {
  stats.forEach((s, idx) => {
    const dur   = 1600 + idx * 200
    const start = performance.now()
    const tick  = (now) => {
      const t    = Math.min((now - start) / dur, 1)
      const ease = 1 - Math.pow(1 - t, 3)
      s.display  = Math.round(ease * s.target)
      if (t < 1) requestAnimationFrame(tick)
    }
    setTimeout(() => requestAnimationFrame(tick), 500 + idx * 150)
  })
}

onMounted(() => {
  requestAnimationFrame(() => setTimeout(() => {
    revealed.value = true
    animateCounters()
  }, 120))
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

/* ── SVG ─────────────────────────────────────── */
.hero-svg-bg {
  position: absolute; inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}

/* Watermark */
.hero-watermark {
  position: absolute;
  right: -2rem; top: 50%; transform: translateY(-50%);
  font-family: 'Cormorant Garamond', serif;
  font-size: 16rem; font-weight: 700; letter-spacing: -0.05em;
  color: rgba(255,255,255,0.014); pointer-events: none; white-space: nowrap;
  z-index: 1;
}

/* ── SEAL ANIMATIONS ─────────────────────────── */
/* Octagons — slow rotation (very different speeds from homepage rings) */
.oct-outer { animation: sealCW  90s linear infinite; transform-origin: 0 0; }
.oct-mid   { animation: sealCCW 65s linear infinite; transform-origin: 0 0; }
.oct-inner { animation: sealCW  40s linear infinite; transform-origin: 0 0; }
@keyframes sealCW  { to { transform: rotate(360deg);  } }
@keyframes sealCCW { to { transform: rotate(-360deg); } }

/* Spoke pulse — sequential group fade */
.spoke-1 { animation: spokeFade 5s ease-in-out infinite 0.00s; }
.spoke-2 { animation: spokeFade 5s ease-in-out infinite 1.25s; }
.spoke-3 { animation: spokeFade 5s ease-in-out infinite 2.50s; }
.spoke-4 { animation: spokeFade 5s ease-in-out infinite 3.75s; }
@keyframes spokeFade { 0%,100%{opacity:0.4} 50%{opacity:1} }

/* Center pulse */
.seal-core { animation: coreGlow 3s ease-in-out infinite; }
@keyframes coreGlow { 0%,100%{opacity:0.2} 50%{opacity:0.7} }

.seal-dot { animation: dotPulse 2.2s ease-in-out infinite; }
@keyframes dotPulse { 0%,100%{opacity:0.9} 50%{opacity:0.2} }

/* ── BAR ANIMATIONS ──────────────────────────── */
.bar-p1 { animation: barFade 7s ease-in-out infinite 0s; }
.bar-p2 { animation: barFade 9s ease-in-out infinite 2.5s; }
.bar-p3 { animation: barFade 6s ease-in-out infinite 1.2s; }
@keyframes barFade { 0%,100%{opacity:1} 50%{opacity:0.2} }

/* ── DIAMOND PARTICLE ANIMATIONS ─────────────── */
.dd-1 { animation: dd1 15s ease-in-out infinite; }
.dd-2 { animation: dd2 19s ease-in-out infinite 2s; }
.dd-3 { animation: dd3 13s ease-in-out infinite 4s; }
.dd-4 { animation: dd4 17s ease-in-out infinite 1s; }
.dd-5 { animation: dd5 21s ease-in-out infinite 3s; }
@keyframes dd1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(9px,-11px)} }
@keyframes dd2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-8px,10px)} }
@keyframes dd3 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(11px,8px)} }
@keyframes dd4 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-10px,-7px)} }
@keyframes dd5 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(6px,13px)} }

/* ── Inner layout ────────────────────────────── */
.hero-inner {
  position: relative; z-index: 2;
  max-width: 1280px; margin: 0 auto;
  padding: 52px 60px 76px;
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
.bc-sep { font-size: 10px; color: rgba(184,197,216,0.22); }
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
.eyebrow-line {
  display: block; width: 36px; height: 1px;
  background: linear-gradient(90deg, transparent, #c9a84c);
}
.eyebrow-dot {
  display: block; width: 4px; height: 4px; border-radius: 50%;
  background: #c9a84c; box-shadow: 0 0 6px rgba(201,168,76,0.8);
  animation: eyeDot 2s ease-in-out infinite;
}
@keyframes eyeDot {
  0%,100%{box-shadow:0 0 6px rgba(201,168,76,0.8)}
  50%    {box-shadow:0 0 14px rgba(201,168,76,1)}
}
.eyebrow-text {
  font-size: 11px; font-weight: 500; color: #c9a84c;
  letter-spacing: 0.3em; text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}

/* ── Headline ────────────────────────────────── */
.hero-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(52px, 6.2vw, 96px);
  font-weight: 600; color: #f5f7fa;
  line-height: 1.04; letter-spacing: -0.01em;
  margin-bottom: 28px;
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.85s ease 0.25s, transform 0.85s ease 0.25s;
}
.hero-headline.visible { opacity: 1; transform: translateY(0); }
.hl-plain { color: #f5f7fa; }
.hl-gold {
  font-style: italic;
  background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 45%, #c9a84c 100%);
  background-size: 200% auto;
  -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  background-clip: text; animation: goldShine 4s linear infinite;
}
@keyframes goldShine {
  0%  { background-position: 0%   center; }
  100%{ background-position: 200% center; }
}

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
  transition: opacity 0.7s ease 0.56s, transform 0.7s ease 0.56s;
}
.hero-badges.visible { opacity: 1; transform: translateY(0); }
.badge {
  padding: 5px 14px;
  border: 1px solid rgba(255,255,255,0.11);
  font-size: 9px; font-weight: 500;
  letter-spacing: 0.12em; text-transform: uppercase;
  color: rgba(184,197,216,0.52);
  font-family: 'DM Mono', monospace;
}
.badge-hl {
  background: rgba(201,168,76,0.12);
  border-color: rgba(201,168,76,0.32);
  color: #c9a84c; font-weight: 700;
}

/* ── Stats ───────────────────────────────────── */
.hero-stats {
  display: flex; gap: 12px;
  margin-bottom: 44px;
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.8s ease 0.70s, transform 0.8s ease 0.70s;
}
.hero-stats.visible { opacity: 1; transform: translateY(0); }

.glass-stat {
  padding: 20px 28px 18px;
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(201,168,76,0.14);
  backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
  transition: background 0.3s, border-color 0.3s, transform 0.25s;
  cursor: default;
}
.glass-stat:hover {
  background: rgba(255,255,255,0.07);
  border-color: rgba(201,168,76,0.32);
  transform: translateY(-4px);
}
.stat-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 40px; font-weight: 700;
  color: #fff; line-height: 1; margin-bottom: 7px;
}
.stat-counter { display: inline-block; }
.stat-suffix { font-size: 18px; color: #c9a84c; vertical-align: super; margin-left: 1px; }
.stat-label {
  font-size: 9px; color: #8a9bbf;
  letter-spacing: 0.22em; text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}

/* ── Quote Card ──────────────────────────────── */
.hero-quote-card {
  position: relative;
  max-width: 600px;
  padding: 28px 32px;
  background: rgba(255,255,255,0.035);
  border: 1px solid rgba(201,168,76,0.14);
  border-left: 3px solid #c9a84c;
  overflow: hidden;
  opacity: 0; transform: translateY(16px);
  transition: opacity 0.7s ease 0.85s, transform 0.7s ease 0.85s;
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
.quote-mark {
  font-family: 'Cormorant Garamond', serif;
  font-size: 3.5rem; font-weight: 700; line-height: 1;
  color: rgba(201,168,76,0.25); margin-bottom: -8px; margin-top: -8px;
}
.quote-text {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.15rem; font-style: italic; font-weight: 300;
  color: rgba(245,247,250,0.72); line-height: 1.58;
  margin-bottom: 14px;
}
.quote-cite {
  font-size: 10px; font-style: normal;
  letter-spacing: 0.12em; text-transform: uppercase;
  color: rgba(184,197,216,0.38); font-family: 'DM Mono', monospace;
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
  .hero-inner { padding: 48px 32px 68px; }
  .hero-watermark { display: none; }
}
@media (max-width: 768px) {
  #wwa-hero { min-height: auto; }
  .hero-inner { padding: 40px 20px 52px; }
  .hero-stats { flex-wrap: wrap; }
  .glass-stat { flex: none; min-width: calc(50% - 6px); }
  .hero-badges { gap: 6px; }
}
@media (max-width: 480px) {
  .hero-headline { font-size: 40px; }
}
</style>
