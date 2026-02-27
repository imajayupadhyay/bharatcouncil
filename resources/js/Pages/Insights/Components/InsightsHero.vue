<template>
  <section class="insights-hero">

    <!-- ══ SVG animated background ══ -->
    <svg class="ihero-bg" viewBox="0 0 1440 480" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <pattern id="ih-grid" width="80" height="80" patternUnits="userSpaceOnUse">
          <path d="M 80 0 L 0 0 0 80" fill="none" stroke="rgba(255,255,255,0.025)" stroke-width="1"/>
        </pattern>
        <radialGradient id="ih-glow1" cx="78%" cy="25%" r="45%">
          <stop offset="0%" stop-color="#c9a84c" stop-opacity="0.10"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="ih-glow2" cx="8%" cy="85%" r="38%">
          <stop offset="0%" stop-color="#162d55" stop-opacity="0.9"/>
          <stop offset="100%" stop-color="#162d55" stop-opacity="0"/>
        </radialGradient>
        <filter id="ih-blur">
          <feGaussianBlur stdDeviation="3"/>
        </filter>
      </defs>

      <!-- Base grid -->
      <rect width="1440" height="480" fill="url(#ih-grid)"/>
      <rect width="1440" height="480" fill="url(#ih-glow1)"/>
      <rect width="1440" height="480" fill="url(#ih-glow2)"/>

      <!-- Concentric rings — right side (Ashoka-inspired) -->
      <g transform="translate(1180, 240)">
        <circle r="280" fill="none" stroke="rgba(201,168,76,0.05)" stroke-width="1"/>
        <circle r="280" fill="none" stroke="rgba(201,168,76,0.10)" stroke-width="0.5" stroke-dasharray="4 28" class="ring-slow"/>
        <circle r="195" fill="none" stroke="rgba(201,168,76,0.07)" stroke-width="1"/>
        <circle r="195" fill="none" stroke="rgba(201,168,76,0.15)" stroke-width="0.5" stroke-dasharray="3 18" class="ring-mid"/>
        <circle r="112" fill="none" stroke="rgba(201,168,76,0.09)" stroke-width="1"/>
        <circle r="112" fill="none" stroke="rgba(201,168,76,0.22)" stroke-width="0.5" stroke-dasharray="2 10" class="ring-fast"/>
        <circle r="42"  fill="rgba(201,168,76,0.03)" filter="url(#ih-blur)"/>
        <circle r="5"   fill="rgba(201,168,76,0.45)" class="core-pulse"/>
        <!-- Spoke dots -->
        <g class="ring-slow">
          <circle v-for="i in 16" :key="`d1-${i}`"
            :cx="280 * Math.cos((i-1) * 22.5 * Math.PI / 180)"
            :cy="280 * Math.sin((i-1) * 22.5 * Math.PI / 180)"
            r="1.5" fill="rgba(201,168,76,0.28)"/>
        </g>
        <g class="ring-mid">
          <circle v-for="i in 12" :key="`d2-${i}`"
            :cx="195 * Math.cos((i-1) * 30 * Math.PI / 180)"
            :cy="195 * Math.sin((i-1) * 30 * Math.PI / 180)"
            r="2" fill="rgba(201,168,76,0.35)"/>
        </g>
      </g>

      <!-- Floating particles -->
      <g>
        <circle v-for="(p, i) in particles" :key="`p${i}`"
          :cx="p.x" :cy="p.y" :r="p.r"
          :fill="`rgba(201,168,76,${p.o})`"
          :class="`pdrift-${(i % 4) + 1}`"/>
      </g>

      <!-- Diagonal accent lines — left -->
      <line x1="-20" y1="130"  x2="130"  y2="-20"  stroke="rgba(201,168,76,0.06)" stroke-width="1"/>
      <line x1="-20" y1="270"  x2="270"  y2="-20"  stroke="rgba(201,168,76,0.04)" stroke-width="1"/>
      <line x1="-20" y1="410"  x2="160"  y2="230"  stroke="rgba(201,168,76,0.03)" stroke-width="0.5"/>

      <!-- Faint watermark -->
      <text x="50%" y="94%" dominant-baseline="auto" text-anchor="middle"
        font-family="Cormorant Garamond, serif" font-size="240" font-weight="700"
        fill="rgba(255,255,255,0.013)" letter-spacing="0.06em">INSIGHTS</text>
    </svg>

    <!-- ══ Content ══ -->
    <div class="ihero-inner">

      <!-- Breadcrumb -->
      <nav class="breadcrumb" :class="{ visible: revealed }">
        <a href="/" class="bc-link">Home</a>
        <span class="bc-sep">›</span>
        <span class="bc-current">Insights</span>
      </nav>

      <!-- Eyebrow -->
      <div class="ihero-eyebrow" :class="{ visible: revealed }">
        <span class="eyebrow-line"/>
        <span class="eyebrow-dot"/>
        <span class="eyebrow-text">Bharat Governance Council</span>
        <span class="eyebrow-tag">Insights</span>
      </div>

      <!-- Headline -->
      <h1 class="ihero-headline" :class="{ visible: revealed }">
        <span class="hl-plain">Policy Insights</span><br>
        <em class="hl-gold">& Analysis</em>
      </h1>

      <!-- Sub -->
      <p class="ihero-sub" :class="{ visible: revealed }">
        Research-driven articles, explainers, and commentary on India's governance landscape.
      </p>

      <!-- Stats strip -->
      <div class="ihero-stats" :class="{ visible: revealed }">
        <div v-for="(s, i) in stats" :key="i" class="ihero-stat">
          <span class="stat-num">{{ s.num }}</span>
          <span class="stat-lbl">{{ s.lbl }}</span>
        </div>
      </div>

    </div>

    <!-- Bottom gold bar -->
    <div class="ihero-gold-bar">
      <div class="gold-shimmer"/>
    </div>

  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const revealed = ref(false)

const stats = [
  { num: '128', lbl: 'Articles'  },
  { num: '24',  lbl: 'Authors'   },
  { num: '8',   lbl: 'Topics'    },
  { num: '5K+', lbl: 'Readers'   },
]

const particles = Array.from({ length: 24 }, (_, i) => ({
  x: (i * 137.5) % 1440,
  y: (i * 83.7)  % 480,
  r: 0.6 + (i % 4) * 0.5,
  o: 0.1 + (i % 5) * 0.06,
}))

onMounted(() => {
  requestAnimationFrame(() => setTimeout(() => { revealed.value = true }, 80))
})
</script>

<style scoped>
/* ── Section ────────────────────────────────── */
.insights-hero {
  position: relative;
  background: #0b1c38;
  min-height: 460px;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  overflow: hidden;
  padding-top: 72px;
}

.ihero-bg {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}

/* ── Ring animations ──────────────────────── */
.ring-slow { animation: spinCW  42s linear infinite; transform-origin: 0 0; }
.ring-mid  { animation: spinCCW 30s linear infinite; transform-origin: 0 0; }
.ring-fast { animation: spinCW  19s linear infinite; transform-origin: 0 0; }

@keyframes spinCW  { from { transform: rotate(0deg);   } to { transform: rotate(360deg);  } }
@keyframes spinCCW { from { transform: rotate(0deg);   } to { transform: rotate(-360deg); } }

.core-pulse { animation: corePulse 2.5s ease-in-out infinite; }
@keyframes corePulse {
  0%,100% { r: 5;  opacity: 0.45; }
  50%     { r: 14; opacity: 0.12; }
}

/* Particle drift */
.pdrift-1 { animation: drift1 14s ease-in-out infinite; }
.pdrift-2 { animation: drift2 18s ease-in-out infinite 2s; }
.pdrift-3 { animation: drift3 12s ease-in-out infinite 4s; }
.pdrift-4 { animation: drift4 16s ease-in-out infinite 1s; }
@keyframes drift1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(8px,-10px)} }
@keyframes drift2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-8px,8px)} }
@keyframes drift3 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(6px,12px)} }
@keyframes drift4 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-10px,-8px)} }

/* ── Inner layout ─────────────────────────── */
.ihero-inner {
  position: relative;
  z-index: 2;
  max-width: 1280px;
  margin: 0 auto;
  width: 100%;
  padding: 52px 60px 64px;
}

/* ── Breadcrumb ───────────────────────────── */
.breadcrumb {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 36px;
  opacity: 0;
  transform: translateY(12px);
  transition: opacity 0.6s ease 0.05s, transform 0.6s ease 0.05s;
}
.breadcrumb.visible { opacity: 1; transform: translateY(0); }

.bc-link {
  font-size: 11px;
  color: #8a9bbf;
  text-decoration: none;
  letter-spacing: 0.1em;
  font-family: 'DM Sans', sans-serif;
  transition: color 0.2s;
}
.bc-link:hover { color: #c9a84c; }

.bc-sep {
  font-size: 13px;
  color: rgba(201,168,76,0.3);
}
.bc-current {
  font-size: 11px;
  color: #c9a84c;
  letter-spacing: 0.1em;
  font-family: 'DM Sans', sans-serif;
}

/* ── Eyebrow ──────────────────────────────── */
.ihero-eyebrow {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 26px;
  opacity: 0;
  transform: translateY(16px);
  transition: opacity 0.7s ease 0.18s, transform 0.7s ease 0.18s;
}
.ihero-eyebrow.visible { opacity: 1; transform: translateY(0); }

.eyebrow-line {
  display: block;
  width: 32px; height: 1px;
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
  letter-spacing: 0.28em;
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

/* ── Headline ─────────────────────────────── */
.ihero-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(44px, 5.8vw, 80px);
  font-weight: 600;
  line-height: 1.05;
  letter-spacing: -0.01em;
  margin-bottom: 22px;
  opacity: 0;
  transform: translateY(22px);
  transition: opacity 0.8s ease 0.3s, transform 0.8s ease 0.3s;
}
.ihero-headline.visible { opacity: 1; transform: translateY(0); }

.hl-plain { color: #fff; }

.hl-gold {
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

/* ── Sub ──────────────────────────────────── */
.ihero-sub {
  font-size: 16px;
  font-weight: 300;
  color: #b8c5d8;
  line-height: 1.75;
  max-width: 480px;
  margin-bottom: 48px;
  opacity: 0;
  transform: translateY(18px);
  transition: opacity 0.8s ease 0.44s, transform 0.8s ease 0.44s;
  font-family: 'DM Sans', sans-serif;
}
.ihero-sub.visible { opacity: 1; transform: translateY(0); }

/* ── Stats strip ──────────────────────────── */
.ihero-stats {
  display: flex;
  align-items: center;
  gap: 0;
  opacity: 0;
  transform: translateY(16px);
  transition: opacity 0.7s ease 0.6s, transform 0.7s ease 0.6s;
}
.ihero-stats.visible { opacity: 1; transform: translateY(0); }

.ihero-stat {
  display: flex;
  flex-direction: column;
  gap: 5px;
  padding: 0 40px 0 0;
  position: relative;
}
.ihero-stat + .ihero-stat {
  padding-left: 40px;
  border-left: 1px solid rgba(201,168,76,0.18);
}

.stat-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 34px;
  font-weight: 700;
  color: #fff;
  line-height: 1;
}
.stat-lbl {
  font-size: 9px;
  color: #8a9bbf;
  letter-spacing: 0.26em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}

/* ── Bottom gold bar ──────────────────────── */
.ihero-gold-bar {
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
.gold-shimmer {
  position: absolute;
  inset: 0;
  background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.6) 50%, transparent 100%);
  animation: barShimmer 3s ease-in-out infinite;
}
@keyframes barShimmer {
  0%   { transform: translateX(-100%); }
  100% { transform: translateX(400%); }
}

/* ── Responsive ───────────────────────────── */
@media (max-width: 1024px) {
  .ihero-inner { padding: 48px 32px 56px; }
}
@media (max-width: 768px) {
  .insights-hero { min-height: 400px; }
  .ihero-inner { padding: 40px 20px 48px; }
  .ihero-stats { gap: 0; flex-wrap: wrap; }
  .ihero-stat { padding: 0 20px 0 0; }
  .ihero-stat + .ihero-stat { padding-left: 20px; }
}
</style>
