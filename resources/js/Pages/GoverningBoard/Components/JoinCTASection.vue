<template>
  <section id="join-cta" ref="sectionEl">

    <!-- ══ SVG dot background ══ -->
    <svg class="cta-svg-bg" viewBox="0 0 1440 600" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <pattern id="ctaDots" width="28" height="28" patternUnits="userSpaceOnUse">
          <circle cx="1" cy="1" r="0.6" fill="rgba(255,255,255,0.026)"/>
        </pattern>
        <radialGradient id="ctaGlow" cx="50%" cy="50%" r="50%">
          <stop offset="0%"   stop-color="#c9a84c" stop-opacity="0.05"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
        <linearGradient id="ctaTopLine" x1="0%" y1="0%" x2="100%" y2="0%">
          <stop offset="0%"   stop-color="rgba(201,168,76,0)"/>
          <stop offset="30%"  stop-color="rgba(201,168,76,0.2)"/>
          <stop offset="70%"  stop-color="rgba(201,168,76,0.2)"/>
          <stop offset="100%" stop-color="rgba(201,168,76,0)"/>
        </linearGradient>
      </defs>
      <rect width="1440" height="600" fill="url(#ctaDots)"/>
      <rect width="1440" height="600" fill="url(#ctaGlow)"/>
      <rect x="0" y="0"   width="1440" height="1" fill="url(#ctaTopLine)"/>
      <rect x="0" y="599" width="1440" height="1" fill="url(#ctaTopLine)"/>
      <!-- Floating particles -->
      <circle v-for="(p, i) in particles" :key="`cp${i}`"
        :cx="p.x" :cy="p.y" :r="p.r"
        :fill="`rgba(201,168,76,${p.o})`"
        :class="`pd-${(i%4)+1}`"/>
    </svg>

    <!-- Watermark -->
    <div class="cta-watermark" aria-hidden="true">JOIN</div>

    <div class="container">

      <div class="sec-label" :class="{ visible: revealed }">
        <span class="sec-label-line"/><span class="sec-label-dot"/>
        <span class="sec-label-text">Work With Us</span>
      </div>

      <div class="cta-header" :class="{ visible: revealed }">
        <h2 class="cta-headline">
          Join the <em class="cta-em">Council's Work</em>
        </h2>
        <p class="cta-intro">BGC is built on the conviction that India's next generation of governance thinkers must be found, nurtured, and put to work. Whether you are a student, a researcher, a practitioner, or a policy voice — there is a place for you here.</p>
      </div>

      <div class="cta-grid" :class="{ visible: revealed }">
        <a
          v-for="(card, i) in ctaCards"
          :key="i"
          :href="card.href"
          class="cta-card"
          :style="`--delay: ${i * 0.08}s`"
        >
          <div class="cta-bottom-bar"/>
          <div class="cta-num">{{ String(i + 1).padStart(2, '0') }}</div>
          <div class="cta-type">{{ card.type }}</div>
          <div class="cta-title">{{ card.title }}</div>
          <div class="cta-desc">{{ card.desc }}</div>
          <div class="cta-link-row">
            <span class="cta-link-text">{{ card.cta }}</span>
            <svg viewBox="0 0 16 16" fill="none" width="13" height="13" class="cta-arrow">
              <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </a>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const sectionEl = ref(null)
const revealed  = ref(false)

const ctaCards = [
  {
    type: 'Engage as an', title: 'Intern', href: '/work-with-us',
    desc: 'Undergraduate and postgraduate students with an interest in public policy, governance, law, or administrative studies. Internships are 8–12 weeks, project-based, and mentored by a BGC board member or senior fellow. Openings across research, communications, and programme support.',
    cta: 'Apply Now',
  },
  {
    type: 'Engage as a', title: 'Fellow', href: '/work-with-us',
    desc: 'One-year residential or non-residential fellowships for mid-career professionals — academics, serving or retired officers, lawyers, or policy practitioners — to pursue a focused governance research project under BGC\'s mentorship. Fellowship holders join the BGC network permanently.',
    cta: 'Learn More',
  },
  {
    type: 'Join as a', title: 'Researcher', href: '/work-with-us',
    desc: 'Full-time or part-time research positions for doctoral scholars and policy researchers. BGC researchers work on long-horizon projects across our programme areas — state capacity, fiscal federalism, climate governance, civil service reform — with direct access to the Council\'s senior members as interlocutors.',
    cta: 'View Openings',
  },
  {
    type: 'Write as a', title: 'Contributor', href: '/work-with-us',
    desc: 'Practitioners, scholars, and informed citizens who wish to contribute essays, analysis, op-eds, or policy commentaries to BGC\'s publications. We welcome voices from across India\'s governance ecosystem — especially those with first-hand administrative or legal experience to share.',
    cta: 'Submit a Piece',
  },
]

const particles = Array.from({ length: 16 }, (_, i) => ({
  x: (i * 137.5) % 1440,
  y: (i * 97.3)  % 600,
  r: 0.6 + (i % 4) * 0.5,
  o: 0.07 + (i % 5) * 0.04,
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
#join-cta {
  position: relative;
  background: #0b1c38;
  padding: 104px 0 112px;
  overflow: hidden;
}
.cta-svg-bg {
  position: absolute; inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}
.pd-1 { animation: d1 14s ease-in-out infinite; }
.pd-2 { animation: d2 18s ease-in-out infinite 2s; }
.pd-3 { animation: d3 12s ease-in-out infinite 4s; }
.pd-4 { animation: d4 16s ease-in-out infinite 1s; }
@keyframes d1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(8px,-10px)} }
@keyframes d2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-9px,8px)} }
@keyframes d3 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(6px,12px)} }
@keyframes d4 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-10px,-8px)} }

.cta-watermark {
  position: absolute; right: -2rem; top: 50%; transform: translateY(-50%);
  font-family: 'Cormorant Garamond', serif;
  font-size: 22rem; font-weight: 700; letter-spacing: -0.04em;
  color: rgba(255,255,255,0.018); pointer-events: none; white-space: nowrap;
  z-index: 1; line-height: 1;
}

.container {
  position: relative; z-index: 2;
  max-width: 1280px; margin: 0 auto;
  padding: 0 60px;
}

/* ── Sec Label ───────────────────────────────── */
.sec-label {
  display: flex; align-items: center; gap: 12px;
  margin-bottom: 28px;
  opacity: 0; transform: translateY(14px);
  transition: opacity 0.7s ease 0.05s, transform 0.7s ease 0.05s;
}
.sec-label.visible { opacity: 1; transform: translateY(0); }
.sec-label-line { display: block; width: 32px; height: 1px; background: linear-gradient(90deg, transparent, rgba(201,168,76,0.7)); }
.sec-label-dot { display: block; width: 4px; height: 4px; border-radius: 50%; background: #c9a84c; box-shadow: 0 0 6px rgba(201,168,76,0.7); }
.sec-label-text { font-size: 10px; font-weight: 700; color: rgba(201,168,76,0.75); letter-spacing: 0.28em; text-transform: uppercase; font-family: 'DM Sans', sans-serif; }

/* ── Header ──────────────────────────────────── */
.cta-header {
  margin-bottom: 52px;
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.8s ease 0.15s, transform 0.8s ease 0.15s;
}
.cta-header.visible { opacity: 1; transform: translateY(0); }

.cta-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2.2rem, 3.5vw, 3.4rem);
  font-weight: 600; color: #f5f7fa;
  line-height: 1.08; margin-bottom: 14px;
}
.cta-em {
  font-style: italic;
  background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 45%, #c9a84c 100%);
  background-size: 200% auto;
  -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  background-clip: text; animation: goldShine 4s linear infinite;
}
@keyframes goldShine { 0%{background-position:0% center} 100%{background-position:200% center} }

.cta-intro {
  font-size: 15px; font-weight: 300;
  color: rgba(184,197,216,0.55); line-height: 1.85;
  max-width: 60ch; font-family: 'DM Sans', sans-serif;
}

/* ── CTA Grid ────────────────────────────────── */
.cta-grid {
  display: grid; grid-template-columns: repeat(4, 1fr);
  gap: 2px;
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.85s ease 0.28s, transform 0.85s ease 0.28s;
}
.cta-grid.visible { opacity: 1; transform: translateY(0); }

/* ── CTA Card ────────────────────────────────── */
.cta-card {
  position: relative;
  background: rgba(255,255,255,0.03);
  border: 1px solid rgba(255,255,255,0.07);
  padding: 36px 28px;
  display: flex; flex-direction: column;
  text-decoration: none; color: inherit;
  overflow: hidden;
  transition: background 0.25s, border-color 0.25s, transform 0.25s;
  animation-delay: var(--delay);
}
.cta-card:hover {
  background: rgba(255,255,255,0.07);
  border-color: rgba(201,168,76,0.3);
  transform: translateY(-4px);
}

.cta-bottom-bar {
  position: absolute; bottom: 0; left: 0; right: 0; height: 2px;
  background: linear-gradient(90deg, #c9a84c, #e8cf8a);
  transform: scaleX(0); transform-origin: left;
  transition: transform 0.32s ease;
}
.cta-card:hover .cta-bottom-bar { transform: scaleX(1); }

.cta-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 4.2rem; font-weight: 700; line-height: 1;
  color: rgba(255,255,255,0.05); letter-spacing: -0.02em;
  margin-bottom: -4px;
}
.cta-type {
  font-size: 9px; font-weight: 700;
  letter-spacing: 0.22em; text-transform: uppercase;
  color: rgba(201,168,76,0.65); margin-bottom: 6px;
  font-family: 'DM Mono', monospace;
}
.cta-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.55rem; font-weight: 600;
  color: #f5f7fa; line-height: 1.15; margin-bottom: 14px;
}
.cta-desc {
  font-size: 13px; font-weight: 300;
  color: rgba(184,197,216,0.5); line-height: 1.78;
  font-family: 'DM Sans', sans-serif;
  flex: 1;
}

.cta-link-row {
  display: flex; align-items: center; gap: 8px;
  margin-top: 24px;
  font-size: 10px; font-weight: 700;
  letter-spacing: 0.14em; text-transform: uppercase;
  color: #c9a84c; font-family: 'DM Mono', monospace;
  transition: gap 0.22s;
}
.cta-card:hover .cta-link-row { gap: 14px; }
.cta-arrow { transition: transform 0.22s; flex-shrink: 0; }
.cta-card:hover .cta-arrow { transform: translateX(4px); }

/* ── Responsive ──────────────────────────────── */
@media (max-width: 1200px) { .cta-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
  #join-cta { padding: 72px 0 80px; }
  .container { padding: 0 24px; }
  .cta-grid { grid-template-columns: 1fr; }
  .cta-watermark { display: none; }
}
</style>
