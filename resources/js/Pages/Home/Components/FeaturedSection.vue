<template>
  <section id="featured" ref="sectionEl">

    <div class="container">

      <!-- ── Section Header ── -->
      <div class="section-header" :class="{ visible: revealed }">
        <div class="section-label">
          <div class="section-tag">
            <span class="tag-line" />
            Latest
          </div>
          <h2 class="section-title">Featured Analysis</h2>
        </div>
        <a href="#" class="section-link">
          View All
          <svg viewBox="0 0 20 20" fill="none" width="14" height="14" class="link-arrow">
            <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
          </svg>
        </a>
      </div>

      <!-- ── Featured Grid ── -->
      <div class="featured-grid">

        <!-- Main Card -->
        <article class="feature-main" :class="{ visible: revealed }" @mouseenter="mainHovered = true" @mouseleave="mainHovered = false">
          <!-- Animated diagonal pattern SVG -->
          <svg class="card-pattern" viewBox="0 0 600 500" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
            <defs>
              <pattern id="diag" width="40" height="40" patternUnits="userSpaceOnUse" patternTransform="rotate(45)">
                <line x1="0" y1="0" x2="0" y2="40" stroke="rgba(201,168,76,0.06)" stroke-width="1"/>
              </pattern>
              <radialGradient id="cardGlow" cx="80%" cy="20%" r="60%">
                <stop offset="0%" stop-color="#c9a84c" stop-opacity="0.09"/>
                <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
              </radialGradient>
              <linearGradient id="cardOverlay" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#0b1c38" stop-opacity="0.1"/>
                <stop offset="100%" stop-color="#0b1c38" stop-opacity="0.75"/>
              </linearGradient>
            </defs>
            <rect width="600" height="500" fill="url(#diag)"/>
            <rect width="600" height="500" fill="url(#cardGlow)"/>
            <rect width="600" height="500" fill="url(#cardOverlay)"/>

            <!-- SVG corner decorative element -->
            <g opacity="0.25" transform="translate(460, 30)">
              <polygon points="60,0 120,35 120,105 60,140 0,105 0,35" fill="none" stroke="#c9a84c" stroke-width="0.8"/>
              <polygon points="60,15 105,42 105,98 60,125 15,98 15,42" fill="none" stroke="#c9a84c" stroke-width="0.5"/>
              <circle cx="60" cy="70" r="18" fill="none" stroke="#c9a84c" stroke-width="0.6"/>
              <circle cx="60" cy="70" r="4" fill="#c9a84c" opacity="0.6"/>
              <line x1="60" y1="15"  x2="60" y2="52"  stroke="#c9a84c" stroke-width="0.5"/>
              <line x1="60" y1="88"  x2="60" y2="125" stroke="#c9a84c" stroke-width="0.5"/>
              <line x1="15" y1="42"  x2="42" y2="58"  stroke="#c9a84c" stroke-width="0.5"/>
              <line x1="78" y1="82"  x2="105" y2="98" stroke="#c9a84c" stroke-width="0.5"/>
            </g>

          </svg>

          <!-- Glass hover overlay -->
          <div class="card-glass-overlay" :style="{ opacity: mainHovered ? 1 : 0 }" />

          <div class="card-content">
            <span class="feature-cat">Policy Brief</span>
            <h2>Reforming India's Fiscal Federalism: Balancing Centre–State Financial Relations</h2>
            <p>An examination of the 16th Finance Commission's mandate and what structural fiscal reforms are needed to address growing vertical and horizontal imbalances in India's federal architecture.</p>
            <div class="feature-meta">
              <div class="author-avatar">PM</div>
              <span class="feature-author">Dr. Priya Menon</span>
              <div class="feature-dot" />
              <span class="feature-date">Feb 2025</span>
              <div class="feature-dot" />
              <span class="feature-readtime">14 min read</span>
            </div>
            <a href="#" class="read-link">
              Read Analysis
              <svg viewBox="0 0 20 20" fill="none" width="12" height="12">
                <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
              </svg>
            </a>
          </div>
        </article>

        <!-- Side Stack -->
        <div class="feature-stack">
          <article
            v-for="(card, i) in sideCards"
            :key="i"
            class="feature-card"
            :class="{ visible: revealed }"
            :style="{ transitionDelay: `${0.15 + i * 0.12}s` }"
          >
            <!-- Card glow bar -->
            <div class="card-glow-bar" />

            <div class="fc-top">
              <div class="fc-cat">{{ card.cat }}</div>
              <div class="fc-readtime">{{ card.time }}</div>
            </div>
            <h3>{{ card.title }}</h3>
            <p>{{ card.excerpt }}</p>
            <div class="fc-bottom">
              <span class="fc-meta">{{ card.date }}</span>
              <a href="#" class="fc-arrow">
                <svg viewBox="0 0 16 16" fill="none" width="14" height="14">
                  <path d="M3 8h10M8 3l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
              </a>
            </div>

            <!-- Hover shimmer -->
            <div class="card-shimmer" />
          </article>
        </div>

      </div>
    </div>


  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const sectionEl  = ref(null)
const revealed   = ref(false)
const mainHovered = ref(false)

const sideCards = [
  {
    cat: 'Explainer',
    title: 'What the New Criminal Laws Mean for Citizens',
    excerpt: 'A plain-language breakdown of BNS, BNSS, and BSA — and what changes in practice.',
    date: 'Jan 2025',
    time: '8 min',
  },
  {
    cat: 'Op-Ed',
    title: 'Rethinking Urban Local Body Finances in Tier-2 Cities',
    excerpt: 'Why India\'s fastest-growing cities are structurally starved of funds — and how to fix it.',
    date: 'Jan 2025',
    time: '6 min',
  },
  {
    cat: 'Report',
    title: 'State of Digital Public Infrastructure: 2025 Review',
    excerpt: 'Assessing DPI adoption, trust, and equity across India\'s 28 states.',
    date: 'Dec 2024',
    time: '12 min',
  },
]

let observer = null

onMounted(() => {
  observer = new IntersectionObserver(
    ([entry]) => { if (entry.isIntersecting) { revealed.value = true; observer.disconnect() } },
    { threshold: 0.12 }
  )
  if (sectionEl.value) observer.observe(sectionEl.value)
})

onUnmounted(() => observer?.disconnect())
</script>

<style scoped>
/* ── Section base ───────────────────────────── */
#featured {
  background: #f2f4f8;
  padding: 96px 0;
  position: relative;
}

.container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 60px;
}


/* ── Section Header ─────────────────────────── */
.section-header {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  margin-bottom: 48px;
  opacity: 0;
  transform: translateY(18px);
  transition: opacity 0.7s ease, transform 0.7s ease;
}
.section-header.visible { opacity: 1; transform: translateY(0); }

.section-label { display: flex; flex-direction: column; gap: 10px; }

.section-tag {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 10px;
  font-weight: 500;
  color: #c9a84c;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}
.tag-line {
  display: block;
  width: 24px; height: 1px;
  background: #c9a84c;
}

.section-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 42px;
  font-weight: 600;
  color: #0b1c38;
  line-height: 1.1;
}

.section-link {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 11px;
  font-weight: 500;
  color: #c9a84c;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  text-decoration: none;
  font-family: 'DM Sans', sans-serif;
  transition: gap 0.25s, color 0.2s;
}
.section-link:hover { gap: 14px; color: #e8cf8a; }
.link-arrow { transition: transform 0.25s; }
.section-link:hover .link-arrow { transform: translateX(4px); }

/* ── Grid ───────────────────────────────────── */
.featured-grid {
  display: grid;
  grid-template-columns: 1fr 380px;
  gap: 24px;
  align-items: stretch;
}

/* ── Main Card ──────────────────────────────── */
.feature-main {
  position: relative;
  background: #0b1c38;
  overflow: hidden;
  min-height: 500px;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  cursor: pointer;
  opacity: 0;
  transform: translateX(-24px);
  transition: opacity 0.8s ease 0.05s, transform 0.8s ease 0.05s, box-shadow 0.3s;
}
.feature-main.visible { opacity: 1; transform: translateX(0); }
.feature-main:hover { box-shadow: 0 20px 60px rgba(11,28,56,0.35); }

.card-pattern {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}


.card-glass-overlay {
  position: absolute;
  inset: 0;
  background: rgba(201,168,76,0.04);
  backdrop-filter: blur(2px);
  transition: opacity 0.4s ease;
  pointer-events: none;
}

.card-content {
  position: relative;
  z-index: 2;
  padding: 52px 52px 44px;
  display: flex;
  flex-direction: column;
  gap: 0;
}

.feature-cat {
  display: inline-block;
  align-self: flex-start;
  font-size: 10px;
  font-weight: 700;
  color: #0b1c38;
  background: #c9a84c;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  padding: 4px 14px;
  margin-bottom: 22px;
  font-family: 'DM Sans', sans-serif;
}

.card-content h2 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 36px;
  font-weight: 600;
  color: #fff;
  line-height: 1.15;
  margin-bottom: 18px;
}

.card-content p {
  font-size: 15px;
  font-weight: 300;
  color: #b8c5d8;
  line-height: 1.7;
  margin-bottom: 28px;
  font-family: 'DM Sans', sans-serif;
}

.feature-meta {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 24px;
  flex-wrap: wrap;
}

.author-avatar {
  width: 30px; height: 30px;
  border-radius: 50%;
  background: rgba(201,168,76,0.15);
  border: 1px solid rgba(201,168,76,0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Cormorant Garamond', serif;
  font-size: 12px;
  font-weight: 600;
  color: #c9a84c;
}

.feature-author {
  font-size: 12px;
  color: #8a9bbf;
  letter-spacing: 0.06em;
  font-family: 'DM Sans', sans-serif;
}
.feature-date,
.feature-readtime {
  font-size: 11px;
  color: rgba(138,155,191,0.5);
  font-family: 'DM Mono', monospace;
}
.feature-dot {
  width: 3px; height: 3px;
  background: #8a9bbf;
  border-radius: 50%;
  opacity: 0.5;
}

.read-link {
  align-self: flex-start;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-size: 11px;
  font-weight: 600;
  color: #c9a84c;
  letter-spacing: 0.16em;
  text-transform: uppercase;
  text-decoration: none;
  font-family: 'DM Sans', sans-serif;
  border-bottom: 1px solid rgba(201,168,76,0.25);
  padding-bottom: 3px;
  transition: color 0.2s, border-color 0.2s, gap 0.2s;
}
.read-link:hover { color: #e8cf8a; border-color: #e8cf8a; gap: 12px; }

/* ── Side Stack ─────────────────────────────── */
.feature-stack {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.feature-card {
  position: relative;
  background: #fff;
  padding: 26px 28px;
  border-left: 3px solid transparent;
  overflow: hidden;
  cursor: pointer;
  flex: 1;
  opacity: 0;
  transform: translateX(20px);
  transition:
    opacity 0.7s ease,
    transform 0.7s ease,
    border-color 0.25s,
    box-shadow 0.25s;
}
.feature-card.visible { opacity: 1; transform: translateX(0); }

.feature-card:hover {
  border-left-color: #c9a84c;
  box-shadow: 6px 0 28px rgba(11,28,56,0.09);
}

/* Shimmer sweep on hover */
.card-shimmer {
  position: absolute;
  inset: 0;
  background: linear-gradient(105deg, transparent 40%, rgba(201,168,76,0.06) 50%, transparent 60%);
  transform: translateX(-100%);
  pointer-events: none;
  transition: transform 0s;
}
.feature-card:hover .card-shimmer {
  transform: translateX(120%);
  transition: transform 0.55s ease;
}

/* Gold top glow bar that expands on hover */
.card-glow-bar {
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 2px;
  background: linear-gradient(90deg, #c9a84c, #e8cf8a);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
}
.feature-card:hover .card-glow-bar { transform: scaleX(1); }

.fc-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 12px;
}

.fc-cat {
  font-size: 9px;
  font-weight: 700;
  color: #c9a84c;
  letter-spacing: 0.28em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}

.fc-readtime {
  font-size: 10px;
  color: #aab;
  font-family: 'DM Mono', monospace;
}

.feature-card h3 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 21px;
  font-weight: 600;
  color: #0b1c38;
  line-height: 1.25;
  margin-bottom: 10px;
}

.feature-card p {
  font-size: 13px;
  color: #6b7a94;
  line-height: 1.65;
  margin-bottom: 16px;
  font-family: 'DM Sans', sans-serif;
}

.fc-bottom {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.fc-meta {
  font-size: 11px;
  color: #aab;
  font-family: 'DM Mono', monospace;
}

.fc-arrow {
  display: flex;
  align-items: center;
  color: rgba(201,168,76,0.4);
  text-decoration: none;
  transition: color 0.2s, transform 0.2s;
}
.feature-card:hover .fc-arrow {
  color: #c9a84c;
  transform: translateX(4px);
}

/* ── Responsive ─────────────────────────────── */
@media (max-width: 1024px) {
  .container { padding: 0 32px; }
  .featured-grid { grid-template-columns: 1fr; }
  .feature-main { min-height: 420px; }
}

@media (max-width: 768px) {
  .container { padding: 0 20px; }
  #featured { padding: 64px 0; }
  .section-title { font-size: 32px; }
  .card-content { padding: 32px 28px; }
  .card-content h2 { font-size: 26px; }
}
</style>
