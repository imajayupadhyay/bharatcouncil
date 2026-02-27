<template>
  <section id="discussions" ref="sectionEl">

    <!-- ══ SVG animated background ══ -->
    <svg class="disc-bg-svg" viewBox="0 0 1440 600" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <pattern id="discDots" width="28" height="28" patternUnits="userSpaceOnUse">
          <circle cx="1" cy="1" r="0.65" fill="rgba(255,255,255,0.035)"/>
        </pattern>
        <radialGradient id="discGlowCenter" cx="50%" cy="50%" r="50%">
          <stop offset="0%"   stop-color="#c9a84c" stop-opacity="0.07"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="discGlowLeft" cx="0%" cy="50%" r="40%">
          <stop offset="0%"   stop-color="#162d55" stop-opacity="0.8"/>
          <stop offset="100%" stop-color="#162d55" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="discGlowRight" cx="100%" cy="50%" r="40%">
          <stop offset="0%"   stop-color="#0b1c38" stop-opacity="0.6"/>
          <stop offset="100%" stop-color="#0b1c38" stop-opacity="0"/>
        </radialGradient>
        <linearGradient id="discTopLine" x1="0%" y1="0%" x2="100%" y2="0%">
          <stop offset="0%"   stop-color="rgba(201,168,76,0)"/>
          <stop offset="30%"  stop-color="rgba(201,168,76,0.25)"/>
          <stop offset="70%"  stop-color="rgba(201,168,76,0.25)"/>
          <stop offset="100%" stop-color="rgba(201,168,76,0)"/>
        </linearGradient>
        <filter id="disc-blur"><feGaussianBlur stdDeviation="4"/></filter>
      </defs>

      <!-- Base layers -->
      <rect width="1440" height="600" fill="url(#discDots)"/>
      <rect width="1440" height="600" fill="url(#discGlowCenter)"/>
      <rect width="1440" height="600" fill="url(#discGlowLeft)"/>
      <rect width="1440" height="600" fill="url(#discGlowRight)"/>

      <!-- Top + bottom gold lines -->
      <rect x="0" y="0"   width="1440" height="1" fill="url(#discTopLine)"/>
      <rect x="0" y="599" width="1440" height="1" fill="url(#discTopLine)"/>

      <!-- Centered concentric rings -->
      <g transform="translate(720, 300)">
        <circle r="380" fill="none" stroke="rgba(201,168,76,0.04)" stroke-width="1"/>
        <circle r="380" fill="none" stroke="rgba(201,168,76,0.07)" stroke-width="0.5" stroke-dasharray="5 35" class="ring-slow"/>
        <circle r="270" fill="none" stroke="rgba(201,168,76,0.05)" stroke-width="1"/>
        <circle r="270" fill="none" stroke="rgba(201,168,76,0.10)" stroke-width="0.5" stroke-dasharray="4 24" class="ring-mid"/>
        <circle r="165" fill="none" stroke="rgba(201,168,76,0.06)" stroke-width="1"/>
        <circle r="165" fill="none" stroke="rgba(201,168,76,0.14)" stroke-width="0.5" stroke-dasharray="3 16" class="ring-fast"/>
        <circle r="60"  fill="rgba(201,168,76,0.025)" filter="url(#disc-blur)"/>
        <!-- Spoke dots outer -->
        <g class="ring-slow">
          <circle v-for="i in 16" :key="`o${i}`"
            :cx="380 * Math.cos((i-1) * 22.5 * Math.PI/180)"
            :cy="380 * Math.sin((i-1) * 22.5 * Math.PI/180)"
            r="1.5" fill="rgba(201,168,76,0.22)"/>
        </g>
        <!-- Spoke dots mid -->
        <g class="ring-mid">
          <circle v-for="i in 12" :key="`m${i}`"
            :cx="270 * Math.cos((i-1) * 30 * Math.PI/180)"
            :cy="270 * Math.sin((i-1) * 30 * Math.PI/180)"
            r="2" fill="rgba(201,168,76,0.28)"/>
        </g>
      </g>

      <!-- Corner decoration top-left -->
      <g opacity="0.18" transform="translate(60, 40)">
        <polygon points="36,0 72,21 72,63 36,84 0,63 0,21" fill="none" stroke="#c9a84c" stroke-width="0.7"/>
        <circle cx="36" cy="42" r="10" fill="none" stroke="#c9a84c" stroke-width="0.5"/>
        <circle cx="36" cy="42" r="2.5" fill="#c9a84c" opacity="0.5"/>
      </g>
      <!-- Corner decoration bottom-right -->
      <g opacity="0.18" transform="translate(1332, 476)">
        <polygon points="36,0 72,21 72,63 36,84 0,63 0,21" fill="none" stroke="#c9a84c" stroke-width="0.7"/>
        <circle cx="36" cy="42" r="10" fill="none" stroke="#c9a84c" stroke-width="0.5"/>
        <circle cx="36" cy="42" r="2.5" fill="#c9a84c" opacity="0.5"/>
      </g>

      <!-- Floating particles -->
      <circle v-for="(p, i) in particles" :key="`p${i}`"
        :cx="p.x" :cy="p.y" :r="p.r"
        :fill="`rgba(201,168,76,${p.o})`"
        :class="`pd-${(i%4)+1}`"/>
    </svg>

    <!-- ══ Content ══ -->
    <div class="disc-inner">

      <!-- Eyebrow -->
      <div class="disc-eyebrow" :class="{ visible: revealed }">
        <span class="eyebrow-line"/>
        <span class="eyebrow-dot"/>
        <span class="eyebrow-text">Community Forum</span>
        <span class="eyebrow-tag">Open to All</span>
      </div>

      <!-- Headline -->
      <h2 class="disc-headline" :class="{ visible: revealed }">
        Shape the<br>
        <em class="headline-em">conversation.</em>
      </h2>

      <!-- Sub text -->
      <p class="disc-sub" :class="{ visible: revealed }">
        Join thousands of citizens, scholars, and civic practitioners debating
        the policies that shape India's future. Every voice matters.
      </p>

      <!-- Stats row -->
      <div class="disc-stats" :class="{ visible: revealed }">
        <div v-for="(stat, i) in communityStats" :key="i" class="disc-stat">
          <span class="stat-num">{{ stat.num }}</span>
          <span class="stat-lbl">{{ stat.lbl }}</span>
        </div>
      </div>

      <!-- Live indicator -->
      <div class="live-row" :class="{ visible: revealed }">
        <span class="live-pulse"/>
        <span class="live-text">{{ liveCount }} members active right now</span>
      </div>

      <!-- CTA buttons -->
      <div class="disc-actions" :class="{ visible: revealed }">
        <a href="#" class="btn-primary-cta">
          <span class="btn-shimmer"/>
          Join &amp; Participate
          <svg viewBox="0 0 20 20" fill="none" width="14" height="14">
            <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
          </svg>
        </a>
        <a href="#" class="btn-ghost-cta">
          Browse Discussions
          <svg viewBox="0 0 20 20" fill="none" width="14" height="14" class="ghost-arrow">
            <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
          </svg>
        </a>
      </div>

      <!-- Note -->
      <p class="disc-note" :class="{ visible: revealed }">
        Free to join &nbsp;·&nbsp; No spam &nbsp;·&nbsp; Cancel anytime
      </p>

    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const sectionEl = ref(null)
const revealed  = ref(false)
const liveCount = ref(18)

const communityStats = [
  { num: '5,200+', lbl: 'Members'     },
  { num: '840+',   lbl: 'Discussions' },
  { num: '12K+',   lbl: 'Comments'    },
  { num: '48+',    lbl: 'Topics'      },
]

const particles = Array.from({ length: 20 }, (_, i) => ({
  x: (i * 137.5) % 1440,
  y: (i * 97.3)  % 600,
  r: 0.6 + (i % 4) * 0.5,
  o: 0.08 + (i % 5) * 0.05,
}))

let liveTimer = null
let observer  = null

onMounted(() => {
  // Animate live count subtly
  liveTimer = setInterval(() => {
    const delta = Math.floor(Math.random() * 3) - 1
    liveCount.value = Math.max(12, Math.min(30, liveCount.value + delta))
  }, 4000)

  observer = new IntersectionObserver(
    ([e]) => { if (e.isIntersecting) { revealed.value = true; observer.disconnect() } },
    { threshold: 0.1 }
  )
  if (sectionEl.value) observer.observe(sectionEl.value)
})

onUnmounted(() => {
  observer?.disconnect()
  clearInterval(liveTimer)
})
</script>

<style scoped>
/* ── Section ────────────────────────────────── */
#discussions {
  position: relative;
  background: #162d55;
  padding: 112px 0;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 560px;
}

.disc-bg-svg {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}

/* Ring animations */
.ring-slow { animation: spinCW  50s linear infinite; transform-origin: 0 0; }
.ring-mid  { animation: spinCCW 34s linear infinite; transform-origin: 0 0; }
.ring-fast { animation: spinCW  22s linear infinite; transform-origin: 0 0; }
@keyframes spinCW  { to { transform: rotate(360deg);  } }
@keyframes spinCCW { to { transform: rotate(-360deg); } }

/* Particle drift */
.pd-1 { animation: d1 14s ease-in-out infinite; }
.pd-2 { animation: d2 18s ease-in-out infinite 2s; }
.pd-3 { animation: d3 12s ease-in-out infinite 4s; }
.pd-4 { animation: d4 16s ease-in-out infinite 1s; }
@keyframes d1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(8px,-10px)} }
@keyframes d2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-9px,8px)} }
@keyframes d3 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(6px,12px)} }
@keyframes d4 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-10px,-8px)} }

/* ── Inner — centered column ──────────────── */
.disc-inner {
  position: relative;
  z-index: 2;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  max-width: 820px;
  padding: 0 40px;
  width: 100%;
}

/* ── Eyebrow ──────────────────────────────── */
.disc-eyebrow {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  margin-bottom: 30px;
  opacity: 0;
  transform: translateY(16px);
  transition: opacity 0.7s ease 0.05s, transform 0.7s ease 0.05s;
}
.disc-eyebrow.visible { opacity: 1; transform: translateY(0); }

.eyebrow-line {
  display: block;
  width: 28px; height: 1px;
  background: linear-gradient(90deg, transparent, #c9a84c);
}
.eyebrow-dot {
  display: block;
  width: 5px; height: 5px;
  border-radius: 50%;
  background: #c9a84c;
  box-shadow: 0 0 8px rgba(201,168,76,0.9);
  animation: dotPulse 2s ease-in-out infinite;
}
@keyframes dotPulse {
  0%,100% { box-shadow: 0 0 6px rgba(201,168,76,0.8); }
  50%     { box-shadow: 0 0 16px rgba(201,168,76,1); }
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
  letter-spacing: 0.18em;
  text-transform: uppercase;
  padding: 2px 9px;
  font-family: 'DM Mono', monospace;
}

/* ── Headline ─────────────────────────────── */
.disc-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(52px, 7vw, 96px);
  font-weight: 600;
  color: #fff;
  line-height: 1.02;
  letter-spacing: -0.01em;
  margin-bottom: 24px;
  opacity: 0;
  transform: translateY(24px);
  transition: opacity 0.85s ease 0.2s, transform 0.85s ease 0.2s;
}
.disc-headline.visible { opacity: 1; transform: translateY(0); }

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

/* ── Sub text ─────────────────────────────── */
.disc-sub {
  font-size: 17px;
  font-weight: 300;
  color: #b8c5d8;
  line-height: 1.75;
  max-width: 580px;
  margin-bottom: 52px;
  opacity: 0;
  transform: translateY(18px);
  transition: opacity 0.8s ease 0.35s, transform 0.8s ease 0.35s;
  font-family: 'DM Sans', sans-serif;
}
.disc-sub.visible { opacity: 1; transform: translateY(0); }

/* ── Stats row ────────────────────────────── */
.disc-stats {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0;
  margin-bottom: 36px;
  opacity: 0;
  transform: translateY(16px);
  transition: opacity 0.8s ease 0.48s, transform 0.8s ease 0.48s;
}
.disc-stats.visible { opacity: 1; transform: translateY(0); }

.disc-stat {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 5px;
  padding: 0 40px;
  position: relative;
}
.disc-stat + .disc-stat::before {
  content: '';
  position: absolute;
  left: 0; top: 50%;
  transform: translateY(-50%);
  width: 1px; height: 36px;
  background: rgba(201,168,76,0.2);
}

.stat-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 40px;
  font-weight: 700;
  color: #fff;
  line-height: 1;
  letter-spacing: -0.01em;
}
.stat-lbl {
  font-size: 9px;
  color: #8a9bbf;
  letter-spacing: 0.28em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}

/* ── Live indicator ───────────────────────── */
.live-row {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  margin-bottom: 44px;
  opacity: 0;
  transform: translateY(12px);
  transition: opacity 0.7s ease 0.6s, transform 0.7s ease 0.6s;
}
.live-row.visible { opacity: 1; transform: translateY(0); }

.live-pulse {
  position: relative;
  width: 8px; height: 8px;
  border-radius: 50%;
  background: #2ecc71;
  flex-shrink: 0;
}
.live-pulse::before {
  content: '';
  position: absolute;
  inset: -4px;
  border-radius: 50%;
  background: rgba(46,204,113,0.28);
  animation: livePulse 1.8s ease-out infinite;
}
@keyframes livePulse {
  0%   { transform: scale(0.8); opacity: 1; }
  100% { transform: scale(2.4); opacity: 0; }
}
.live-text {
  font-size: 12px;
  color: rgba(138,155,191,0.6);
  font-family: 'DM Mono', monospace;
  letter-spacing: 0.04em;
}

/* ── Action buttons ───────────────────────── */
.disc-actions {
  display: flex;
  align-items: center;
  gap: 20px;
  margin-bottom: 22px;
  opacity: 0;
  transform: translateY(14px);
  transition: opacity 0.7s ease 0.72s, transform 0.7s ease 0.72s;
}
.disc-actions.visible { opacity: 1; transform: translateY(0); }

/* Primary gold button */
.btn-primary-cta {
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
  padding: 17px 40px;
  text-decoration: none;
  overflow: hidden;
  font-family: 'DM Sans', sans-serif;
  transition: background-position 0.5s ease, transform 0.2s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 24px rgba(201,168,76,0.28);
}
.btn-shimmer {
  position: absolute;
  inset: 0;
  background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.32) 50%, transparent 60%);
  transform: translateX(-100%);
  transition: transform 0s;
}
.btn-primary-cta:hover .btn-shimmer {
  transform: translateX(100%);
  transition: transform 0.52s ease;
}
.btn-primary-cta:hover {
  background-position: right center;
  transform: translateY(-3px);
  box-shadow: 0 10px 38px rgba(201,168,76,0.42);
}

/* Ghost button */
.btn-ghost-cta {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  font-size: 11px;
  font-weight: 500;
  color: #b8c5d8;
  letter-spacing: 0.16em;
  text-transform: uppercase;
  text-decoration: none;
  border: 1px solid rgba(255,255,255,0.12);
  padding: 16px 32px;
  font-family: 'DM Sans', sans-serif;
  transition: color 0.25s, border-color 0.25s, background 0.25s;
}
.btn-ghost-cta:hover {
  color: #e8cf8a;
  border-color: rgba(201,168,76,0.4);
  background: rgba(201,168,76,0.06);
}
.ghost-arrow { transition: transform 0.25s; }
.btn-ghost-cta:hover .ghost-arrow { transform: translateX(4px); }

/* ── Note ─────────────────────────────────── */
.disc-note {
  font-size: 11px;
  color: rgba(138,155,191,0.32);
  font-family: 'DM Mono', monospace;
  letter-spacing: 0.06em;
  opacity: 0;
  transition: opacity 0.6s ease 0.88s;
}
.disc-note.visible { opacity: 1; }

/* ── Responsive ───────────────────────────── */
@media (max-width: 1024px) {
  .disc-stat { padding: 0 28px; }
}
@media (max-width: 768px) {
  #discussions { padding: 80px 0; min-height: auto; }
  .disc-inner { padding: 0 24px; }
  .disc-stats { flex-wrap: wrap; gap: 20px 0; }
  .disc-stat { padding: 0 20px; min-width: 50%; }
  .disc-stat + .disc-stat::before { display: none; }
  .disc-actions { flex-direction: column; gap: 12px; width: 100%; }
  .btn-primary-cta,
  .btn-ghost-cta { width: 100%; justify-content: center; }
}
@media (max-width: 480px) {
  .disc-stat { min-width: 100%; }
  .eyebrow-tag { display: none; }
}
</style>
