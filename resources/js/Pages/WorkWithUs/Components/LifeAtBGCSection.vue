<template>
  <section id="life-at-bgc" ref="sectionEl">

    <!-- ══ SVG animated background ══ -->
    <svg class="bgc-svg-bg" viewBox="0 0 1440 700" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <pattern id="lifeDots" width="28" height="28" patternUnits="userSpaceOnUse">
          <circle cx="1" cy="1" r="0.65" fill="rgba(255,255,255,0.032)"/>
        </pattern>
        <radialGradient id="lifeGlowCenter" cx="50%" cy="50%" r="50%">
          <stop offset="0%"   stop-color="#c9a84c" stop-opacity="0.06"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="lifeGlowLeft" cx="0%" cy="50%" r="40%">
          <stop offset="0%"   stop-color="#0b1c38" stop-opacity="0.7"/>
          <stop offset="100%" stop-color="#0b1c38" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="lifeGlowRight" cx="100%" cy="50%" r="40%">
          <stop offset="0%"   stop-color="#162d55" stop-opacity="0.5"/>
          <stop offset="100%" stop-color="#162d55" stop-opacity="0"/>
        </radialGradient>
        <linearGradient id="lifeLine" x1="0%" y1="0%" x2="100%" y2="0%">
          <stop offset="0%"   stop-color="rgba(201,168,76,0)"/>
          <stop offset="30%"  stop-color="rgba(201,168,76,0.22)"/>
          <stop offset="70%"  stop-color="rgba(201,168,76,0.22)"/>
          <stop offset="100%" stop-color="rgba(201,168,76,0)"/>
        </linearGradient>
        <filter id="life-blur"><feGaussianBlur stdDeviation="4"/></filter>
      </defs>

      <rect width="1440" height="700" fill="url(#lifeDots)"/>
      <rect width="1440" height="700" fill="url(#lifeGlowCenter)"/>
      <rect width="1440" height="700" fill="url(#lifeGlowLeft)"/>
      <rect width="1440" height="700" fill="url(#lifeGlowRight)"/>
      <rect x="0" y="0"   width="1440" height="1" fill="url(#lifeLine)"/>
      <rect x="0" y="699" width="1440" height="1" fill="url(#lifeLine)"/>

      <!-- Concentric rings right side -->
      <g transform="translate(1160, 350)">
        <circle r="300" fill="none" stroke="rgba(201,168,76,0.04)" stroke-width="1"/>
        <circle r="300" fill="none" stroke="rgba(201,168,76,0.07)" stroke-width="0.5" stroke-dasharray="5 35" class="ring-slow"/>
        <circle r="210" fill="none" stroke="rgba(201,168,76,0.05)" stroke-width="1"/>
        <circle r="210" fill="none" stroke="rgba(201,168,76,0.09)" stroke-width="0.5" stroke-dasharray="4 24" class="ring-mid"/>
        <circle r="125" fill="none" stroke="rgba(201,168,76,0.06)" stroke-width="1"/>
        <circle r="125" fill="none" stroke="rgba(201,168,76,0.12)" stroke-width="0.5" stroke-dasharray="3 16" class="ring-fast"/>
        <circle r="42" fill="rgba(201,168,76,0.03)" filter="url(#life-blur)"/>
        <g class="ring-slow">
          <circle v-for="i in 16" :key="`lo${i}`"
            :cx="300 * Math.cos((i-1) * 22.5 * Math.PI/180)"
            :cy="300 * Math.sin((i-1) * 22.5 * Math.PI/180)"
            r="1.5" fill="rgba(201,168,76,0.2)"/>
        </g>
        <g class="ring-mid">
          <circle v-for="i in 12" :key="`lm${i}`"
            :cx="210 * Math.cos((i-1) * 30 * Math.PI/180)"
            :cy="210 * Math.sin((i-1) * 30 * Math.PI/180)"
            r="2" fill="rgba(201,168,76,0.26)"/>
        </g>
      </g>

      <!-- Floating particles -->
      <circle v-for="(p, i) in particles" :key="`lp${i}`"
        :cx="p.x" :cy="p.y" :r="p.r"
        :fill="`rgba(201,168,76,${p.o})`"
        :class="`pd-${(i%4)+1}`"/>
    </svg>

    <!-- ══ Content ══ -->
    <div class="bgc-inner">

      <div class="bgc-header" :class="{ visible: revealed }">
        <div class="sec-label">
          <span class="sec-label-line"/><span class="sec-label-dot"/>
          <span class="sec-label-text">Life at BGC</span>
        </div>
        <h2 class="section-headline">
          A Place That Respects<br>
          <em class="headline-em">Your Intelligence</em>
        </h2>
      </div>

      <div class="bgc-grid" :class="{ visible: revealed }">

        <!-- Left: Prose + Award -->
        <div class="bgc-left">
          <div class="prose-body">
            <p>BGC is a small institution by design. We do not believe that governance research requires large teams, complex hierarchies, or expensive infrastructure. What it requires is careful thinking, deep reading, good writing, and honest conversation — and we build a culture that enables all four.</p>
            <p>We work reasonable hours. We do not celebrate busyness. We expect people to read widely, think slowly, and write carefully — not to produce output at volume. Every person at BGC, from intern to Chairman, is treated as a professional with their own intellectual dignity.</p>
            <p>BGC has a standing Committee Against Discrimination and Harassment, a formal grievance redressal mechanism, and a commitment to equal opportunity that is lived, not stated.</p>
          </div>

          <div class="award-card">
            <div class="award-card-shimmer"/>
            <span class="award-trophy">🏆</span>
            <div class="award-detail">
              <h4 class="award-title">Best Place to Work — Not for Profit</h4>
              <p class="award-body">Bharat Governance Council was recognised by <em>Economic Times Best Workplaces 2024</em> in the Not-for-Profit category — awarded for its collegial intellectual culture, commitment to staff development, transparent governance, and record of employee wellbeing.</p>
            </div>
          </div>
        </div>

        <!-- Right: Values list -->
        <div class="bgc-right">
          <ul class="values-list">
            <li v-for="(val, i) in values" :key="i" class="value-item" :style="`--delay: ${i * 0.08}s`">
              <span class="val-icon">{{ val.icon }}</span>
              <div class="val-body">
                <h4 class="val-title">{{ val.title }}</h4>
                <p class="val-desc">{{ val.desc }}</p>
              </div>
            </li>
          </ul>
        </div>

      </div>
    </div>

  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const sectionEl = ref(null)
const revealed  = ref(false)

const values = [
  {
    icon: '🤝',
    title: 'Flat, Collegial Culture',
    desc: 'Everyone is addressed by name. There is no unnecessary deference to rank or seniority. Ideas are evaluated on their merits — regardless of who offers them.',
  },
  {
    icon: '📚',
    title: 'Intellectual Freedom',
    desc: 'BGC takes no institutional positions on policy questions. Your analysis and conclusions are yours. We will support them, not shape them.',
  },
  {
    icon: '⏱️',
    title: 'Reasonable Hours & Flexibility',
    desc: 'We do not normalise overwork. Core hours are structured; the rest is flexible. Hybrid and remote arrangements are available for fellows and senior associates.',
  },
  {
    icon: '🌱',
    title: 'Learning & Development',
    desc: 'BGC actively supports professional development — conference travel, external training, co-authorship with senior board members, and introductions to the wider governance ecosystem.',
  },
  {
    icon: '🛡️',
    title: 'Safe & Equitable Workspace',
    desc: 'Formal POSH policy. Grievance redressal committee. Zero tolerance for discrimination on the basis of gender, caste, religion, region, or sexual orientation.',
  },
]

const particles = Array.from({ length: 20 }, (_, i) => ({
  x: (i * 137.5) % 1440,
  y: (i * 97.3)  % 700,
  r: 0.6 + (i % 4) * 0.5,
  o: 0.07 + (i % 5) * 0.05,
}))

let observer = null
onMounted(() => {
  observer = new IntersectionObserver(
    ([e]) => { if (e.isIntersecting) { revealed.value = true; observer.disconnect() } },
    { threshold: 0.08 }
  )
  if (sectionEl.value) observer.observe(sectionEl.value)
})
onUnmounted(() => observer?.disconnect())
</script>

<style scoped>
/* ── Section ─────────────────────────────────── */
#life-at-bgc {
  position: relative;
  background: #0f2347;
  padding: 112px 0;
  overflow: hidden;
}

/* ── SVG Background ──────────────────────────── */
.bgc-svg-bg {
  position: absolute; inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}

.ring-slow { animation: spinCW  50s linear infinite; transform-origin: 0 0; }
.ring-mid  { animation: spinCCW 34s linear infinite; transform-origin: 0 0; }
.ring-fast { animation: spinCW  22s linear infinite; transform-origin: 0 0; }
@keyframes spinCW  { to { transform: rotate(360deg);  } }
@keyframes spinCCW { to { transform: rotate(-360deg); } }

.pd-1 { animation: d1 14s ease-in-out infinite; }
.pd-2 { animation: d2 18s ease-in-out infinite 2s; }
.pd-3 { animation: d3 12s ease-in-out infinite 4s; }
.pd-4 { animation: d4 16s ease-in-out infinite 1s; }
@keyframes d1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(8px,-10px)} }
@keyframes d2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-9px,8px)} }
@keyframes d3 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(6px,12px)} }
@keyframes d4 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-10px,-8px)} }

/* ── Inner ───────────────────────────────────── */
.bgc-inner {
  position: relative; z-index: 2;
  max-width: 1280px; margin: 0 auto;
  padding: 0 60px;
}

/* ── Header ──────────────────────────────────── */
.bgc-header {
  margin-bottom: 64px;
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.7s ease 0.05s, transform 0.7s ease 0.05s;
}
.bgc-header.visible { opacity: 1; transform: translateY(0); }

.sec-label { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; }
.sec-label-line {
  display: block; width: 32px; height: 1px;
  background: linear-gradient(90deg, transparent, rgba(201,168,76,0.7));
}
.sec-label-dot {
  display: block; width: 4px; height: 4px; border-radius: 50%;
  background: #c9a84c; box-shadow: 0 0 6px rgba(201,168,76,0.7);
}
.sec-label-text {
  font-size: 10px; font-weight: 700;
  color: rgba(201,168,76,0.75); letter-spacing: 0.28em; text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}

.section-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2.2rem, 3.5vw, 3.4rem);
  font-weight: 600; color: #f5f7fa;
  line-height: 1.08; letter-spacing: -0.01em;
}
.headline-em {
  font-style: italic;
  background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 45%, #c9a84c 100%);
  background-size: 200% auto;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  animation: goldShine 4s linear infinite;
}
@keyframes goldShine { 0%{background-position:0% center} 100%{background-position:200% center} }

/* ── Grid ────────────────────────────────────── */
.bgc-grid {
  display: grid; grid-template-columns: 1fr 1fr; gap: 72px;
  align-items: start;
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.85s ease 0.2s, transform 0.85s ease 0.2s;
}
.bgc-grid.visible { opacity: 1; transform: translateY(0); }

/* ── Left Column ─────────────────────────────── */
.prose-body { margin-bottom: 40px; }
.prose-body p {
  font-size: 15px; font-weight: 300;
  color: rgba(184,197,216,0.65); line-height: 1.88;
  font-family: 'DM Sans', sans-serif;
}
.prose-body p + p { margin-top: 16px; }

.award-card {
  position: relative;
  background: rgba(201,168,76,0.08);
  border: 1px solid rgba(201,168,76,0.22);
  padding: 28px;
  display: flex; gap: 20px; align-items: flex-start;
  overflow: hidden;
}
.award-card-shimmer {
  position: absolute; inset: 0;
  background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.04) 50%, transparent 60%);
  transform: translateX(-100%); transition: transform 0s;
}
.award-card:hover .award-card-shimmer {
  transform: translateX(100%); transition: transform 0.7s ease;
}
.award-trophy { font-size: 28px; flex-shrink: 0; }
.award-detail {}
.award-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.15rem; font-weight: 600;
  color: #c9a84c; margin-bottom: 8px;
}
.award-body {
  font-size: 13px; font-weight: 300;
  color: rgba(184,197,216,0.55); line-height: 1.7;
  font-family: 'DM Sans', sans-serif;
}
.award-body em { color: #e8cf8a; font-style: italic; }

/* ── Values List ─────────────────────────────── */
.values-list { list-style: none; display: flex; flex-direction: column; }

.value-item {
  display: flex; gap: 20px; align-items: flex-start;
  padding: 20px 0;
  border-bottom: 1px solid rgba(255,255,255,0.06);
  transition: padding-left 0.25s;
  animation-delay: var(--delay);
}
.value-item:first-child { border-top: 1px solid rgba(255,255,255,0.06); }
.value-item:hover { padding-left: 8px; }

.val-icon {
  font-size: 18px; flex-shrink: 0;
  width: 36px; text-align: center;
  margin-top: 2px;
}
.val-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.08rem; font-weight: 600;
  color: #f5f7fa; margin-bottom: 5px;
}
.val-desc {
  font-size: 13px; font-weight: 300;
  color: rgba(184,197,216,0.5); line-height: 1.7;
  font-family: 'DM Sans', sans-serif;
}

/* ── Responsive ──────────────────────────────── */
@media (max-width: 1024px) {
  .bgc-grid { grid-template-columns: 1fr; gap: 48px; }
  .bgc-inner { padding: 0 32px; }
}
@media (max-width: 768px) {
  #life-at-bgc { padding: 80px 0; }
  .bgc-inner { padding: 0 24px; }
  .award-card { flex-direction: column; gap: 12px; }
}
</style>
