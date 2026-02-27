<template>
  <section class="related-section" ref="sectionEl">

    <!-- SVG bg -->
    <svg class="related-bg" viewBox="0 0 1440 500" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <pattern id="ra-grid" width="80" height="80" patternUnits="userSpaceOnUse">
          <path d="M 80 0 L 0 0 0 80" fill="none" stroke="rgba(255,255,255,0.018)" stroke-width="1"/>
        </pattern>
        <radialGradient id="ra-glow1" cx="15%" cy="50%" r="40%">
          <stop offset="0%" stop-color="#c9a84c" stop-opacity="0.06"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="ra-glow2" cx="85%" cy="50%" r="35%">
          <stop offset="0%" stop-color="#162d55" stop-opacity="0.7"/>
          <stop offset="100%" stop-color="#162d55" stop-opacity="0"/>
        </radialGradient>
      </defs>
      <rect width="1440" height="500" fill="url(#ra-grid)"/>
      <rect width="1440" height="500" fill="url(#ra-glow1)"/>
      <rect width="1440" height="500" fill="url(#ra-glow2)"/>
      <line x1="0" y1="1"   x2="1440" y2="1"   stroke="rgba(201,168,76,0.08)" stroke-width="1"/>
      <line x1="0" y1="499" x2="1440" y2="499" stroke="rgba(201,168,76,0.08)" stroke-width="1"/>
    </svg>

    <div class="container">

      <!-- Header -->
      <div class="section-header" :class="{ visible: revealed }">
        <div class="section-label">
          <div class="section-tag">
            <span class="tag-line"/>
            Continue Reading
          </div>
          <h2 class="section-title">Related Articles</h2>
        </div>
        <a href="/insights" class="section-link">
          All Insights
          <svg viewBox="0 0 20 20" fill="none" width="14" height="14" class="link-arrow">
            <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
          </svg>
        </a>
      </div>

      <!-- Cards grid -->
      <div class="related-grid">
        <article
          v-for="(article, i) in relatedArticles"
          :key="article.id"
          class="related-card"
          :class="{ visible: revealed }"
          :style="{ transitionDelay: `${0.1 + i * 0.12}s` }"
          @mouseenter="hovered = i"
          @mouseleave="hovered = null"
        >
          <!-- Gold top bar -->
          <div class="card-top-bar"/>

          <!-- Glass fill on hover -->
          <div class="card-fill" :class="{ active: hovered === i }"/>

          <!-- Card number -->
          <span class="card-num">0{{ i + 1 }}</span>

          <!-- Type + read time -->
          <div class="card-type-row">
            <span class="card-cat" :class="`cat-${slug(article.category)}`">
              <span class="cat-dot"/>{{ article.category }}
            </span>
            <span class="card-read-time">{{ article.readTime }}</span>
          </div>

          <h3>{{ article.title }}</h3>
          <p>{{ article.excerpt }}</p>

          <div class="card-footer">
            <div class="card-author-row">
              <div class="card-avatar">{{ article.authorInitials }}</div>
              <span class="card-author">{{ article.author }}</span>
            </div>
            <span class="card-date">{{ article.date }}</span>
          </div>

          <a href="/insights/reforming-fiscal-federalism" class="card-read-link">
            Read Article
            <svg viewBox="0 0 16 16" fill="none" width="12" height="12">
              <path d="M3 8h10M8 3l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </a>

          <!-- Shimmer -->
          <div class="card-shimmer"/>
        </article>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const sectionEl = ref(null)
const revealed  = ref(false)
const hovered   = ref(null)

function slug(s) {
  return s.toLowerCase().replace(/[\s/&]+/g, '-').replace(/[^a-z-]/g, '')
}

const relatedArticles = [
  {
    id: 1,
    category: 'Op-Ed', readTime: '6 min',
    title: 'Municipal Finance is India\'s Forgotten Crisis',
    excerpt: 'Urban local bodies collect less than 1% of GDP in taxes. This structural deficit must change for India\'s cities to grow sustainably.',
    author: 'Vikram Nair', authorInitials: 'VN',
    date: 'Feb 8, 2025',
  },
  {
    id: 2,
    category: 'Analysis', readTime: '12 min',
    title: 'State of Digital Public Infrastructure: India 2025',
    excerpt: 'Comprehensive review of DPI adoption, trust scores, and equity gaps across 28 states and 8 union territories.',
    author: 'Raghav Krishnan', authorInitials: 'RK',
    date: 'Jan 15, 2025',
  },
  {
    id: 3,
    category: 'Policy Brief', readTime: '10 min',
    title: 'Gram Panchayats at 75: Finances, Capacity & Accountability',
    excerpt: 'A 10-state study of Panchayati Raj institutions — what genuine decentralisation requires in finance, power, and personnel.',
    author: 'BGC Research Team', authorInitials: 'BG',
    date: 'Jan 5, 2025',
  },
]

let observer = null
onMounted(() => {
  observer = new IntersectionObserver(
    ([e]) => { if (e.isIntersecting) { revealed.value = true; observer.disconnect() } },
    { threshold: 0.12 }
  )
  if (sectionEl.value) observer.observe(sectionEl.value)
})
onUnmounted(() => observer?.disconnect())
</script>

<style scoped>
/* ── Section ────────────────────────────────── */
.related-section {
  position: relative;
  background: #0b1c38;
  padding: 96px 0;
  overflow: hidden;
}
.related-bg {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}

.container {
  position: relative;
  z-index: 2;
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 60px;
}

/* ── Header ─────────────────────────────────── */
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
.tag-line { display: block; width: 24px; height: 1px; background: #c9a84c; }
.section-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 40px;
  font-weight: 600;
  color: #fff;
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
.related-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
}

/* ── Card ───────────────────────────────────── */
.related-card {
  position: relative;
  padding: 36px 28px 28px;
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(201,168,76,0.16);
  overflow: hidden;
  cursor: pointer;
  opacity: 0;
  transform: translateY(28px);
  transition:
    opacity 0.65s ease,
    transform 0.65s ease,
    background 0.3s,
    border-color 0.3s,
    box-shadow 0.3s;
}
.related-card.visible { opacity: 1; transform: translateY(0); }
.related-card:hover {
  background: rgba(255,255,255,0.10);
  border-color: rgba(201,168,76,0.4);
  box-shadow: 0 12px 40px rgba(0,0,0,0.3);
}

/* Gold top bar */
.card-top-bar {
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 2px;
  background: linear-gradient(90deg, #c9a84c, #e8cf8a);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);
}
.related-card:hover .card-top-bar { transform: scaleX(1); }

/* Glass fill from bottom */
.card-fill {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 0%;
  background: linear-gradient(to top, rgba(201,168,76,0.07), transparent);
  transition: height 0.45s cubic-bezier(0.4,0,0.2,1);
  pointer-events: none;
}
.card-fill.active { height: 100%; }

/* Shimmer sweep */
.card-shimmer {
  position: absolute;
  inset: 0;
  background: linear-gradient(105deg, transparent 40%, rgba(201,168,76,0.05) 50%, transparent 60%);
  transform: translateX(-100%);
  pointer-events: none;
  transition: transform 0s;
}
.related-card:hover .card-shimmer {
  transform: translateX(120%);
  transition: transform 0.55s ease;
}

/* Card number */
.card-num {
  position: absolute;
  top: 18px; right: 20px;
  font-family: 'DM Mono', monospace;
  font-size: 11px;
  color: rgba(201,168,76,0.2);
  letter-spacing: 0.1em;
  transition: color 0.3s;
  z-index: 1;
}
.related-card:hover .card-num { color: rgba(201,168,76,0.5); }

/* Type row */
.card-type-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 14px;
  position: relative;
  z-index: 1;
}
.card-cat {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 9px;
  font-weight: 700;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  padding: 3px 10px;
  font-family: 'DM Sans', sans-serif;
}
.cat-analysis     { background: rgba(201,168,76,0.15); color: #e8cf8a; }
.cat-op-ed        { background: rgba(142,68,173,0.15); color: #c39bd3; }
.cat-policy-brief { background: rgba(93,173,226,0.15); color: #85c1e9; }
.cat-commentary   { background: rgba(41,128,185,0.15); color: #7fb3d3; }

.cat-dot {
  width: 4px; height: 4px;
  border-radius: 50%;
  background: currentColor;
  flex-shrink: 0;
}
.card-read-time {
  font-size: 10px;
  color: rgba(138,155,191,0.5);
  font-family: 'DM Mono', monospace;
}

/* Title */
.related-card h3 {
  position: relative;
  z-index: 1;
  font-family: 'Cormorant Garamond', serif;
  font-size: 22px;
  font-weight: 600;
  color: #fff;
  line-height: 1.25;
  margin-bottom: 12px;
  transition: color 0.25s;
}
.related-card:hover h3 { color: #e8cf8a; }

/* Excerpt */
.related-card p {
  position: relative;
  z-index: 1;
  font-size: 13px;
  color: #8a9bbf;
  line-height: 1.65;
  margin-bottom: 20px;
  font-family: 'DM Sans', sans-serif;
  flex: 1;
}

/* Footer */
.card-footer {
  position: relative;
  z-index: 1;
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 18px;
}
.card-author-row {
  display: flex;
  align-items: center;
  gap: 8px;
}
.card-avatar {
  width: 26px; height: 26px;
  border-radius: 50%;
  background: rgba(201,168,76,0.12);
  border: 1px solid rgba(201,168,76,0.28);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'DM Mono', monospace;
  font-size: 9px;
  font-weight: 700;
  color: #c9a84c;
  flex-shrink: 0;
}
.card-author {
  font-size: 12px;
  color: #8a9bbf;
  font-family: 'DM Sans', sans-serif;
}
.card-date {
  font-size: 11px;
  color: rgba(138,155,191,0.4);
  font-family: 'DM Mono', monospace;
}

/* Read link */
.card-read-link {
  position: relative;
  z-index: 1;
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 10px;
  font-weight: 600;
  color: rgba(201,168,76,0.5);
  letter-spacing: 0.16em;
  text-transform: uppercase;
  text-decoration: none;
  font-family: 'DM Sans', sans-serif;
  transition: color 0.2s, gap 0.2s;
}
.related-card:hover .card-read-link { color: #c9a84c; gap: 10px; }

/* ── Responsive ─────────────────────────────── */
@media (max-width: 1024px) {
  .container { padding: 0 32px; }
  .related-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 768px) {
  .container { padding: 0 20px; }
  .related-section { padding: 64px 0; }
  .related-grid { grid-template-columns: 1fr; }
  .section-title { font-size: 30px; }
  .section-header { flex-direction: column; align-items: flex-start; gap: 12px; }
}
</style>
