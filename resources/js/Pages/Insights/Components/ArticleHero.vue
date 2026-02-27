<template>
  <section class="article-hero">

    <!-- ══ SVG animated background ══ -->
    <svg class="ah-bg" viewBox="0 0 1440 560" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <pattern id="ah-grid" width="80" height="80" patternUnits="userSpaceOnUse">
          <path d="M 80 0 L 0 0 0 80" fill="none" stroke="rgba(255,255,255,0.022)" stroke-width="1"/>
        </pattern>
        <radialGradient id="ah-glow1" cx="80%" cy="20%" r="50%">
          <stop offset="0%" stop-color="#c9a84c" stop-opacity="0.11"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="ah-glow2" cx="5%" cy="90%" r="40%">
          <stop offset="0%" stop-color="#162d55" stop-opacity="0.9"/>
          <stop offset="100%" stop-color="#162d55" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="ah-glow3" cx="45%" cy="55%" r="30%">
          <stop offset="0%" stop-color="#c9a84c" stop-opacity="0.03"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
        <filter id="ah-blur"><feGaussianBlur stdDeviation="3"/></filter>
        <filter id="ah-blur2"><feGaussianBlur stdDeviation="6"/></filter>
      </defs>

      <rect width="1440" height="560" fill="url(#ah-grid)"/>
      <rect width="1440" height="560" fill="url(#ah-glow1)"/>
      <rect width="1440" height="560" fill="url(#ah-glow2)"/>
      <rect width="1440" height="560" fill="url(#ah-glow3)"/>

      <!-- Concentric rings — right -->
      <g transform="translate(1200, 280)">
        <circle r="300" fill="none" stroke="rgba(201,168,76,0.05)" stroke-width="1"/>
        <circle r="300" fill="none" stroke="rgba(201,168,76,0.09)" stroke-width="0.5" stroke-dasharray="4 30" class="ring-slow"/>
        <circle r="210" fill="none" stroke="rgba(201,168,76,0.07)" stroke-width="1"/>
        <circle r="210" fill="none" stroke="rgba(201,168,76,0.13)" stroke-width="0.5" stroke-dasharray="3 20" class="ring-mid"/>
        <circle r="120" fill="none" stroke="rgba(201,168,76,0.09)" stroke-width="1"/>
        <circle r="120" fill="none" stroke="rgba(201,168,76,0.18)" stroke-width="0.5" stroke-dasharray="2 12" class="ring-fast"/>
        <circle r="46" fill="rgba(201,168,76,0.03)" filter="url(#ah-blur)"/>
        <circle r="5"  fill="rgba(201,168,76,0.5)" class="core-pulse"/>
        <g class="ring-slow">
          <circle v-for="i in 16" :key="`a${i}`"
            :cx="300 * Math.cos((i-1) * 22.5 * Math.PI/180)"
            :cy="300 * Math.sin((i-1) * 22.5 * Math.PI/180)"
            r="1.5" fill="rgba(201,168,76,0.28)"/>
        </g>
        <g class="ring-mid">
          <circle v-for="i in 12" :key="`b${i}`"
            :cx="210 * Math.cos((i-1) * 30 * Math.PI/180)"
            :cy="210 * Math.sin((i-1) * 30 * Math.PI/180)"
            r="2" fill="rgba(201,168,76,0.32)"/>
        </g>
      </g>

      <!-- Floating particles -->
      <circle v-for="(p, i) in particles" :key="`p${i}`"
        :cx="p.x" :cy="p.y" :r="p.r"
        :fill="`rgba(201,168,76,${p.o})`"
        :class="`pd-${(i%4)+1}`"/>

      <!-- Diagonal left lines -->
      <line x1="-20" y1="150"  x2="150"  y2="-20" stroke="rgba(201,168,76,0.06)" stroke-width="1"/>
      <line x1="-20" y1="300"  x2="300"  y2="-20" stroke="rgba(201,168,76,0.04)" stroke-width="1"/>
      <line x1="-20" y1="450"  x2="180"  y2="250" stroke="rgba(201,168,76,0.03)" stroke-width="0.5"/>
    </svg>

    <!-- ══ Content ══ -->
    <div class="ah-inner">

      <!-- Breadcrumb -->
      <nav class="breadcrumb" :class="{ visible: revealed }">
        <a href="/" class="bc-link">Home</a>
        <span class="bc-sep">›</span>
        <a href="/insights" class="bc-link">Insights</a>
        <span class="bc-sep">›</span>
        <span class="bc-current">Fiscal Federalism</span>
      </nav>

      <!-- Category + meta row -->
      <div class="ah-meta-row" :class="{ visible: revealed }">
        <span class="cat-badge">Analysis</span>
        <span class="meta-divider"/>
        <span class="meta-item">
          <svg viewBox="0 0 16 16" fill="none" width="11" height="11" class="meta-icon">
            <circle cx="8" cy="8" r="6.5" stroke="currentColor" stroke-width="1.2"/>
            <path d="M8 4.5v4l2.5 1.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
          </svg>
          14 min read
        </span>
        <span class="meta-divider"/>
        <span class="meta-item">Feb 12, 2025</span>
        <span class="meta-divider"/>
        <span class="meta-item peer-reviewed">
          <svg viewBox="0 0 14 14" fill="none" width="10" height="10">
            <path d="M2.5 7l3.5 3.5 5.5-6.5" stroke="#2ecc71" stroke-width="1.5" stroke-linecap="round"/>
          </svg>
          Peer Reviewed
        </span>
      </div>

      <!-- Headline -->
      <h1 class="ah-headline" :class="{ visible: revealed }">
        Reforming India's Fiscal Federalism:<br>
        <em class="headline-em">Balancing Centre–State Financial Relations</em>
      </h1>

      <!-- Excerpt -->
      <p class="ah-excerpt" :class="{ visible: revealed }">
        An examination of the 16th Finance Commission's mandate and what structural fiscal
        reforms are needed to address growing vertical and horizontal imbalances in
        India's federal architecture.
      </p>

      <!-- Author row -->
      <div class="ah-author-row" :class="{ visible: revealed }">
        <div class="author-avatar-lg">PM</div>
        <div class="author-info">
          <span class="author-name">Dr. Priya Menon</span>
          <span class="author-title">Senior Fellow, Economic Policy · BGC</span>
        </div>
        <div class="ah-actions">
          <button class="action-btn" title="Bookmark">
            <svg viewBox="0 0 20 20" fill="none" width="14" height="14">
              <path d="M5 3h10a1 1 0 011 1v13l-6-3.5L4 17V4a1 1 0 011-1z" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
          <button class="action-btn" title="Share">
            <svg viewBox="0 0 20 20" fill="none" width="14" height="14">
              <circle cx="15" cy="4" r="2" stroke="currentColor" stroke-width="1.4"/>
              <circle cx="5" cy="10" r="2" stroke="currentColor" stroke-width="1.4"/>
              <circle cx="15" cy="16" r="2" stroke="currentColor" stroke-width="1.4"/>
              <path d="M7 9l6-3.5M7 11l6 3.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
            </svg>
          </button>
          <a href="/insights" class="back-link">
            <svg viewBox="0 0 16 16" fill="none" width="12" height="12">
              <path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            All Insights
          </a>
        </div>
      </div>

    </div>

    <!-- Bottom gold bar -->
    <div class="ah-gold-bar"><div class="gold-shimmer"/></div>

  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const revealed = ref(false)

const particles = Array.from({ length: 20 }, (_, i) => ({
  x: (i * 137.5) % 1440,
  y: (i * 97.3)  % 560,
  r: 0.6 + (i % 4) * 0.5,
  o: 0.1 + (i % 5) * 0.06,
}))

onMounted(() => {
  requestAnimationFrame(() => setTimeout(() => { revealed.value = true }, 80))
})
</script>

<style scoped>
/* ── Section ────────────────────────────────── */
.article-hero {
  position: relative;
  background: #0b1c38;
  min-height: 540px;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  overflow: hidden;
  padding-top: 74px; /* nav + progress bar */
}

.ah-bg {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}

/* ── Ring animations ──────────────────────── */
.ring-slow { animation: spinCW  44s linear infinite; transform-origin: 0 0; }
.ring-mid  { animation: spinCCW 30s linear infinite; transform-origin: 0 0; }
.ring-fast { animation: spinCW  19s linear infinite; transform-origin: 0 0; }
@keyframes spinCW  { to { transform: rotate(360deg);  } }
@keyframes spinCCW { to { transform: rotate(-360deg); } }
.core-pulse { animation: corePulse 2.6s ease-in-out infinite; }
@keyframes corePulse { 0%,100% { r: 5; opacity: 0.5; } 50% { r: 14; opacity: 0.12; } }
.pd-1 { animation: d1 14s ease-in-out infinite; }
.pd-2 { animation: d2 18s ease-in-out infinite 2s; }
.pd-3 { animation: d3 12s ease-in-out infinite 4s; }
.pd-4 { animation: d4 16s ease-in-out infinite 1s; }
@keyframes d1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(7px,-10px)} }
@keyframes d2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-9px,8px)} }
@keyframes d3 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(6px,12px)} }
@keyframes d4 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-8px,-9px)} }

/* ── Inner ────────────────────────────────── */
.ah-inner {
  position: relative;
  z-index: 2;
  max-width: 1280px;
  margin: 0 auto;
  width: 100%;
  padding: 48px 60px 60px;
}

/* ── Breadcrumb ───────────────────────────── */
.breadcrumb {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 28px;
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
.bc-sep  { font-size: 12px; color: rgba(201,168,76,0.3); }
.bc-current { font-size: 11px; color: #c9a84c; letter-spacing: 0.1em; font-family: 'DM Sans', sans-serif; }

/* ── Meta row ─────────────────────────────── */
.ah-meta-row {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 10px;
  margin-bottom: 28px;
  opacity: 0;
  transform: translateY(14px);
  transition: opacity 0.7s ease 0.18s, transform 0.7s ease 0.18s;
}
.ah-meta-row.visible { opacity: 1; transform: translateY(0); }

.cat-badge {
  display: inline-block;
  font-size: 10px;
  font-weight: 700;
  color: #0b1c38;
  background: #c9a84c;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  padding: 4px 14px;
  font-family: 'DM Sans', sans-serif;
}
.meta-divider {
  width: 1px; height: 14px;
  background: rgba(201,168,76,0.2);
}
.meta-item {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 11px;
  color: #8a9bbf;
  font-family: 'DM Mono', monospace;
  letter-spacing: 0.06em;
}
.meta-icon { color: #8a9bbf; flex-shrink: 0; }
.peer-reviewed {
  color: rgba(46,204,113,0.7);
  gap: 5px;
}

/* ── Headline ─────────────────────────────── */
.ah-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(34px, 4.2vw, 60px);
  font-weight: 600;
  color: #fff;
  line-height: 1.1;
  letter-spacing: -0.01em;
  margin-bottom: 22px;
  max-width: 860px;
  opacity: 0;
  transform: translateY(22px);
  transition: opacity 0.8s ease 0.3s, transform 0.8s ease 0.3s;
}
.ah-headline.visible { opacity: 1; transform: translateY(0); }

.headline-em {
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

/* ── Excerpt ──────────────────────────────── */
.ah-excerpt {
  font-size: 17px;
  font-weight: 300;
  color: #b8c5d8;
  line-height: 1.72;
  max-width: 680px;
  margin-bottom: 44px;
  opacity: 0;
  transform: translateY(16px);
  transition: opacity 0.8s ease 0.44s, transform 0.8s ease 0.44s;
  font-family: 'DM Sans', sans-serif;
}
.ah-excerpt.visible { opacity: 1; transform: translateY(0); }

/* ── Author row ───────────────────────────── */
.ah-author-row {
  display: flex;
  align-items: center;
  gap: 16px;
  flex-wrap: wrap;
  opacity: 0;
  transform: translateY(14px);
  transition: opacity 0.7s ease 0.58s, transform 0.7s ease 0.58s;
}
.ah-author-row.visible { opacity: 1; transform: translateY(0); }

.author-avatar-lg {
  width: 44px; height: 44px;
  border-radius: 50%;
  background: rgba(201,168,76,0.15);
  border: 1.5px solid rgba(201,168,76,0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Cormorant Garamond', serif;
  font-size: 16px;
  font-weight: 600;
  color: #c9a84c;
  flex-shrink: 0;
  box-shadow: 0 0 14px rgba(201,168,76,0.12);
}
.author-info {
  display: flex;
  flex-direction: column;
  gap: 3px;
}
.author-name {
  font-size: 14px;
  font-weight: 500;
  color: #fff;
  font-family: 'DM Sans', sans-serif;
}
.author-title {
  font-size: 11px;
  color: #8a9bbf;
  font-family: 'DM Mono', monospace;
  letter-spacing: 0.04em;
}

.ah-actions {
  margin-left: auto;
  display: flex;
  align-items: center;
  gap: 8px;
}
.action-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 36px; height: 36px;
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(201,168,76,0.18);
  color: #8a9bbf;
  cursor: pointer;
  transition: background 0.2s, border-color 0.2s, color 0.2s;
}
.action-btn:hover {
  background: rgba(201,168,76,0.12);
  border-color: rgba(201,168,76,0.35);
  color: #c9a84c;
}
.back-link {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 10px;
  font-weight: 600;
  color: #8a9bbf;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  text-decoration: none;
  font-family: 'DM Sans', sans-serif;
  border: 1px solid rgba(255,255,255,0.1);
  padding: 8px 16px;
  transition: color 0.2s, border-color 0.2s, background 0.2s;
}
.back-link:hover {
  color: #c9a84c;
  border-color: rgba(201,168,76,0.3);
  background: rgba(201,168,76,0.06);
}

/* ── Bottom gold bar ──────────────────────── */
.ah-gold-bar {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, #c9a84c 0%, #e8cf8a 30%, rgba(201,168,76,0.15) 70%, transparent 100%);
  overflow: hidden;
}
.gold-shimmer {
  position: absolute;
  inset: 0;
  background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.6) 50%, transparent 100%);
  animation: shimmer 3s ease-in-out infinite;
}
@keyframes shimmer {
  0%   { transform: translateX(-100%); }
  100% { transform: translateX(400%); }
}

/* ── Responsive ───────────────────────────── */
@media (max-width: 1024px) {
  .ah-inner { padding: 44px 32px 52px; }
}
@media (max-width: 768px) {
  .article-hero { min-height: 440px; }
  .ah-inner { padding: 36px 20px 44px; }
  .ah-actions { margin-left: 0; width: 100%; }
}
</style>
