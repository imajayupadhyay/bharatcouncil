<template>
  <section id="publications" ref="sectionEl">

    <!-- SVG bg -->
    <svg class="pub-bg-svg" viewBox="0 0 1440 700" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <pattern id="pubGrid" width="60" height="60" patternUnits="userSpaceOnUse">
          <path d="M 60 0 L 0 0 0 60" fill="none" stroke="rgba(11,28,56,0.04)" stroke-width="1"/>
        </pattern>
      </defs>
      <rect width="1440" height="700" fill="url(#pubGrid)"/>
      <circle cx="1380" cy="680" r="260" fill="none" stroke="rgba(201,168,76,0.05)" stroke-width="1"/>
      <circle cx="60"   cy="60"  r="180" fill="none" stroke="rgba(201,168,76,0.04)" stroke-width="1"/>
    </svg>

    <div class="container">

      <!-- Header -->
      <div class="section-header" :class="{ visible: revealed }">
        <div class="section-label">
          <div class="section-tag"><span class="tag-line"/>Knowledge Base</div>
          <h2 class="section-title">Publications &amp; Research</h2>
        </div>
        <a href="#" class="section-link">
          Full Library
          <svg viewBox="0 0 20 20" fill="none" width="14" height="14" class="link-arrow">
            <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
          </svg>
        </a>
      </div>

      <!-- ── Filter Tabs ── -->
      <div class="filters-wrap" :class="{ visible: revealed }">
        <!-- Mobile scroll track -->
        <div class="filters-scroll" ref="filtersEl">
          <button
            v-for="tab in tabs"
            :key="tab.key"
            class="pub-filter"
            :class="{ active: activeTab === tab.key }"
            @click="setTab(tab.key)"
          >
            {{ tab.label }}
            <span class="tab-count">{{ getCount(tab.key) }}</span>
          </button>
        </div>
        <!-- Active ink bar -->
        <div class="tab-ink-bar" :style="inkBarStyle"/>
      </div>

      <!-- ── Cards Grid ── -->
      <TransitionGroup
        name="cards"
        tag="div"
        class="pub-grid"
      >
        <article
          v-for="pub in filteredPubs"
          :key="pub.id"
          class="pub-card"
          :class="{ visible: revealed }"
        >
          <!-- Top accent bar -->
          <div class="pub-top-bar"/>

          <!-- Type badge -->
          <div class="pub-type-row">
            <span class="pub-type" :class="`type-${pub.type.toLowerCase().replace(/\s+/g,'-').replace(/[^a-z-]/g,'')}`">
              <span class="type-dot"/>
              {{ pub.type }}
            </span>
            <span class="pub-read-time">{{ pub.readTime }}</span>
          </div>

          <h3>{{ pub.title }}</h3>
          <p>{{ pub.excerpt }}</p>

          <div class="pub-footer">
            <div class="pub-author-row">
              <div class="pub-author-avatar">{{ pub.authorInitials }}</div>
              <span class="pub-author">{{ pub.author }}</span>
            </div>
            <span class="pub-date">{{ pub.date }}</span>
          </div>

          <!-- Read arrow -->
          <a href="#" class="pub-read-link">
            Read
            <svg viewBox="0 0 16 16" fill="none" width="11" height="11">
              <path d="M3 8h10M8 3l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </a>
        </article>
      </TransitionGroup>

      <!-- Empty state -->
      <div v-if="filteredPubs.length === 0" class="pub-empty">
        <span>No publications in this category yet.</span>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, nextTick, watch } from 'vue'

const sectionEl  = ref(null)
const filtersEl  = ref(null)
const revealed   = ref(false)
const activeTab  = ref('all')
const inkBarStyle = ref({ left: '0px', width: '0px' })

const tabs = [
  { key: 'all',          label: 'All'          },
  { key: 'Policy Brief', label: 'Policy Brief'  },
  { key: 'Report',       label: 'Report'        },
  { key: 'Op-Ed',        label: 'Op-Ed'         },
  { key: 'Explainer',    label: 'Explainer'     },
  { key: 'Commentary',   label: 'Commentary'    },
]

const publications = [
  {
    id: 1, type: 'Policy Brief', readTime: '14 min',
    title: 'Reforming India\'s Fiscal Federalism: The 16th Finance Commission Agenda',
    excerpt: 'Structural recommendations for addressing vertical and horizontal fiscal imbalances between the Centre and states.',
    author: 'Dr. Priya Menon', authorInitials: 'PM', date: 'Feb 2025',
  },
  {
    id: 2, type: 'Report', readTime: '20 min',
    title: 'State of Digital Public Infrastructure: India 2025',
    excerpt: 'Comprehensive review of DPI adoption, trust scores, and equity gaps across 28 states and 8 UTs.',
    author: 'Raghav Krishnan', authorInitials: 'RK', date: 'Dec 2024',
  },
  {
    id: 3, type: 'Explainer', readTime: '8 min',
    title: 'India\'s New Criminal Laws: A Citizen\'s Guide to BNS, BNSS & BSA',
    excerpt: 'Plain-language breakdown of three landmark laws and what they mean for rights, procedure, and justice delivery.',
    author: 'Aditi Sharma', authorInitials: 'AS', date: 'Jan 2025',
  },
  {
    id: 4, type: 'Op-Ed', readTime: '6 min',
    title: 'Municipal Finance is India\'s Forgotten Crisis',
    excerpt: 'Urban local bodies collect less than 1% of GDP in taxes. This must change for India\'s cities to thrive.',
    author: 'Vikram Nair', authorInitials: 'VN', date: 'Jan 2025',
  },
  {
    id: 5, type: 'Commentary', readTime: '9 min',
    title: 'What BRICS Expansion Means for India\'s Strategic Calculus',
    excerpt: 'Analysing the geopolitical and economic implications of a larger BRICS grouping for India\'s foreign policy.',
    author: 'Vikram Nair', authorInitials: 'VN', date: 'Nov 2024',
  },
  {
    id: 6, type: 'Report', readTime: '18 min',
    title: 'The State of Gram Panchayats: Finances, Capacity & Accountability',
    excerpt: 'A 10-state study of Panchayati Raj institutions and what genuine decentralisation requires.',
    author: 'BGC Research Team', authorInitials: 'BG', date: 'Oct 2024',
  },
]

const filteredPubs = computed(() =>
  activeTab.value === 'all'
    ? publications
    : publications.filter(p => p.type === activeTab.value)
)

function getCount(key) {
  if (key === 'all') return publications.length
  return publications.filter(p => p.type === key).length
}

function setTab(key) {
  activeTab.value = key
  nextTick(() => updateInkBar())
}

function updateInkBar() {
  if (!filtersEl.value) return
  const activeBtn = filtersEl.value.querySelector('.pub-filter.active')
  if (!activeBtn) return
  const parentRect = filtersEl.value.getBoundingClientRect()
  const btnRect    = activeBtn.getBoundingClientRect()
  inkBarStyle.value = {
    left:  `${btnRect.left - parentRect.left}px`,
    width: `${btnRect.width}px`,
  }
}

// Scroll active tab into view on mobile
watch(activeTab, () => {
  nextTick(() => {
    const activeBtn = filtersEl.value?.querySelector('.pub-filter.active')
    activeBtn?.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' })
  })
})

let observer = null
onMounted(() => {
  observer = new IntersectionObserver(
    ([e]) => {
      if (e.isIntersecting) {
        revealed.value = true
        observer.disconnect()
        nextTick(() => updateInkBar())
      }
    },
    { threshold: 0.1 }
  )
  if (sectionEl.value) observer.observe(sectionEl.value)
  window.addEventListener('resize', updateInkBar)
})
onUnmounted(() => {
  observer?.disconnect()
  window.removeEventListener('resize', updateInkBar)
})
</script>

<style scoped>
/* ── Section ────────────────────────────────── */
#publications {
  position: relative;
  background: #f2f4f8;
  padding: 96px 0;
  overflow: hidden;
}

.pub-bg-svg {
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
  margin-bottom: 40px;
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

/* ── Filters ────────────────────────────────── */
.filters-wrap {
  position: relative;
  margin-bottom: 40px;
  opacity: 0;
  transform: translateY(14px);
  transition: opacity 0.7s ease 0.15s, transform 0.7s ease 0.15s;
}
.filters-wrap.visible { opacity: 1; transform: translateY(0); }

.filters-scroll {
  display: flex;
  gap: 4px;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: none;
  padding-bottom: 2px;
  /* Fade edges on mobile */
  -webkit-mask-image: linear-gradient(90deg, transparent 0%, #000 4%, #000 96%, transparent 100%);
  mask-image: linear-gradient(90deg, transparent 0%, #000 4%, #000 96%, transparent 100%);
}
.filters-scroll::-webkit-scrollbar { display: none; }

.pub-filter {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  flex-shrink: 0;
  font-size: 11px;
  font-weight: 500;
  color: #8a9bbf;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  padding: 9px 20px;
  background: transparent;
  border: 1px solid rgba(11,28,56,0.1);
  cursor: pointer;
  font-family: 'DM Sans', sans-serif;
  transition: color 0.25s, background 0.25s, border-color 0.25s;
  white-space: nowrap;
  position: relative;
}
.pub-filter:hover {
  color: #0b1c38;
  background: rgba(11,28,56,0.04);
  border-color: rgba(11,28,56,0.2);
}
.pub-filter.active {
  color: #e8cf8a;
  background: #0b1c38;
  border-color: #0b1c38;
}

.tab-count {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 18px;
  height: 18px;
  padding: 0 5px;
  font-size: 9px;
  font-weight: 700;
  border-radius: 20px;
  background: rgba(201,168,76,0.15);
  color: #c9a84c;
  font-family: 'DM Mono', monospace;
  letter-spacing: 0;
  transition: background 0.25s, color 0.25s;
}
.pub-filter.active .tab-count {
  background: rgba(201,168,76,0.25);
  color: #e8cf8a;
}

/* Sliding ink bar under active tab */
.tab-ink-bar {
  position: absolute;
  bottom: 0;
  height: 2px;
  background: linear-gradient(90deg, #c9a84c, #e8cf8a);
  transition: left 0.32s cubic-bezier(0.4,0,0.2,1), width 0.32s cubic-bezier(0.4,0,0.2,1);
  border-radius: 1px;
}

/* ── Grid ───────────────────────────────────── */
.pub-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  min-height: 200px;
}

/* ── Card ───────────────────────────────────── */
.pub-card {
  position: relative;
  background: #fff;
  padding: 32px 30px 28px;
  border: 1px solid rgba(11,28,56,0.07);
  box-shadow: 0 2px 12px rgba(11,28,56,0.05);
  display: flex;
  flex-direction: column;
  cursor: pointer;
  transition:
    border-color 0.25s,
    transform 0.25s,
    box-shadow 0.25s;
}
.pub-card:hover {
  border-color: rgba(201,168,76,0.35);
  transform: translateY(-4px);
  box-shadow: 0 12px 36px rgba(11,28,56,0.1);
}

/* Animated top border */
.pub-top-bar {
  position: absolute;
  top: 0; left: 0;
  height: 3px;
  width: 100%;
  background: linear-gradient(90deg, rgba(232,207,138,0.3), rgba(201,168,76,0.3));
  transform-origin: left;
  transition: background 0.3s;
}
.pub-card:hover .pub-top-bar {
  background: linear-gradient(90deg, #c9a84c, #e8cf8a);
}

/* Type row */
.pub-type-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 16px;
}

.pub-type {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 9px;
  font-weight: 700;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  padding: 4px 12px;
  font-family: 'DM Sans', sans-serif;
  background: #e8eaf0;
  color: #0b1c38;
}
/* Type colour variants */
.type-policy-brief { background: rgba(201,168,76,0.12); color: #8a6a1a; }
.type-report        { background: rgba(22,45,85,0.1);   color: #0f2347; }
.type-explainer     { background: rgba(22,160,133,0.1); color: #0e6b58; }
.type-op-ed         { background: rgba(142,68,173,0.1); color: #6c3483; }
.type-commentary    { background: rgba(41,128,185,0.1); color: #1a5276; }

.type-dot {
  width: 5px; height: 5px;
  border-radius: 50%;
  background: currentColor;
  flex-shrink: 0;
}

.pub-read-time {
  font-size: 10px;
  color: #aab;
  font-family: 'DM Mono', monospace;
}

/* Text */
.pub-card h3 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 21px;
  font-weight: 600;
  color: #0b1c38;
  line-height: 1.25;
  margin-bottom: 12px;
  transition: color 0.2s;
}
.pub-card:hover h3 { color: #0f2347; }

.pub-card p {
  font-size: 13px;
  color: #6b7a94;
  line-height: 1.65;
  flex: 1;
  margin-bottom: 20px;
  font-family: 'DM Sans', sans-serif;
}

/* Footer */
.pub-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 16px;
}

.pub-author-row {
  display: flex;
  align-items: center;
  gap: 8px;
}
.pub-author-avatar {
  width: 26px; height: 26px;
  border-radius: 50%;
  background: rgba(11,28,56,0.08);
  border: 1px solid rgba(201,168,76,0.25);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'DM Mono', monospace;
  font-size: 9px;
  font-weight: 700;
  color: #c9a84c;
  flex-shrink: 0;
}
.pub-author {
  font-size: 12px;
  color: #0b1c38;
  font-weight: 500;
  font-family: 'DM Sans', sans-serif;
}
.pub-date {
  font-size: 11px;
  color: #aab;
  font-family: 'DM Mono', monospace;
}

/* Read link */
.pub-read-link {
  align-self: flex-start;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 10px;
  font-weight: 600;
  color: rgba(201,168,76,0.5);
  letter-spacing: 0.16em;
  text-transform: uppercase;
  text-decoration: none;
  font-family: 'DM Sans', sans-serif;
  transition: color 0.2s, gap 0.2s;
}
.pub-card:hover .pub-read-link { color: #c9a84c; gap: 9px; }

/* ── Empty state ────────────────────────────── */
.pub-empty {
  grid-column: 1 / -1;
  text-align: center;
  padding: 60px 0;
  font-family: 'DM Sans', sans-serif;
  font-size: 14px;
  color: #8a9bbf;
}

/* ── Card transition (filter switch) ───────── */
.cards-enter-active {
  transition: opacity 0.35s ease, transform 0.35s ease;
}
.cards-leave-active {
  transition: opacity 0.2s ease, transform 0.2s ease;
  position: absolute;
  pointer-events: none;
}
.cards-enter-from { opacity: 0; transform: translateY(14px); }
.cards-leave-to   { opacity: 0; transform: translateY(-8px);  }
.cards-move       { transition: transform 0.35s ease; }

/* ── Responsive ─────────────────────────────── */
@media (max-width: 1024px) {
  .container { padding: 0 32px; }
  .pub-grid  { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
  .container { padding: 0 20px; }
  #publications { padding: 64px 0; }
  .section-title { font-size: 32px; }
  .section-header { flex-direction: column; align-items: flex-start; gap: 16px; }
  .pub-grid { grid-template-columns: 1fr; }
  /* Give filters breathing room on small screens */
  .filters-scroll { padding: 0 20px 2px; margin: 0 -20px; }
  .filters-wrap { margin-left: 0; margin-right: 0; }
}
</style>
