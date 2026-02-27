<template>

  <!-- ══ Featured Article ══════════════════════════════════ -->
  <section class="featured-section">
    <div class="container">

      <!-- Section header -->
      <div class="section-header" :class="{ visible: featRevealed }">
        <div class="section-label">
          <div class="section-tag"><span class="tag-line"/>Editor's Pick</div>
          <h2 class="section-title">Featured Analysis</h2>
        </div>
        <span class="featured-date-meta">{{ featuredPost.date }} · {{ featuredPost.readTime }}</span>
      </div>

      <!-- Featured card -->
      <article
        class="featured-card"
        :class="{ visible: featRevealed }"
        @mouseenter="featHovered = true"
        @mouseleave="featHovered = false"
      >
        <!-- SVG background -->
        <svg class="feat-bg-svg" viewBox="0 0 1200 400" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
          <defs>
            <pattern id="il-diag" width="40" height="40" patternUnits="userSpaceOnUse" patternTransform="rotate(45)">
              <line x1="0" y1="0" x2="0" y2="40" stroke="rgba(201,168,76,0.06)" stroke-width="1"/>
            </pattern>
            <radialGradient id="il-card-glow" cx="78%" cy="18%" r="55%">
              <stop offset="0%" stop-color="#c9a84c" stop-opacity="0.09"/>
              <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
            </radialGradient>
            <linearGradient id="il-card-overlay" x1="100%" y1="0%" x2="0%" y2="100%">
              <stop offset="0%" stop-color="#0b1c38" stop-opacity="0.05"/>
              <stop offset="100%" stop-color="#0b1c38" stop-opacity="0.82"/>
            </linearGradient>
          </defs>
          <rect width="1200" height="400" fill="url(#il-diag)"/>
          <rect width="1200" height="400" fill="url(#il-card-glow)"/>
          <rect width="1200" height="400" fill="url(#il-card-overlay)"/>
          <!-- Corner emblem -->
          <g opacity="0.20" transform="translate(940, 28)">
            <polygon points="80,0 160,46 160,138 80,184 0,138 0,46" fill="none" stroke="#c9a84c" stroke-width="0.8"/>
            <polygon points="80,20 140,55 140,125 80,160 20,125 20,55" fill="none" stroke="#c9a84c" stroke-width="0.5"/>
            <circle cx="80" cy="92" r="26" fill="none" stroke="#c9a84c" stroke-width="0.7"/>
            <circle cx="80" cy="92" r="5"  fill="#c9a84c" opacity="0.6"/>
            <line x1="80" y1="20"  x2="80"  y2="66"  stroke="#c9a84c" stroke-width="0.5"/>
            <line x1="80" y1="118" x2="80"  y2="160" stroke="#c9a84c" stroke-width="0.5"/>
            <line x1="20" y1="55"  x2="54"  y2="74"  stroke="#c9a84c" stroke-width="0.5"/>
            <line x1="106" y1="110" x2="140" y2="125" stroke="#c9a84c" stroke-width="0.5"/>
          </g>
        </svg>

        <!-- Glass hover overlay -->
        <div class="feat-glass-overlay" :style="{ opacity: featHovered ? 1 : 0 }"/>

        <!-- Content -->
        <div class="feat-content">
          <div class="feat-top-row">
            <span class="feat-cat-badge">{{ featuredPost.category }}</span>
            <span class="feat-featured-tag">Featured</span>
          </div>
          <h2>{{ featuredPost.title }}</h2>
          <p>{{ featuredPost.excerpt }}</p>

          <div class="feat-tag-row">
            <span v-for="tag in featuredPost.tags" :key="tag" class="tag-pill">{{ tag }}</span>
          </div>

          <div class="feat-meta-row">
            <div class="feat-author-avatar">{{ featuredPost.authorInitials }}</div>
            <span class="feat-author">{{ featuredPost.author }}</span>
            <span class="meta-dot"/>
            <span class="feat-date">{{ featuredPost.date }}</span>
            <span class="meta-dot"/>
            <span class="feat-readtime">{{ featuredPost.readTime }}</span>
          </div>

          <a href="/insights/reforming-fiscal-federalism" class="feat-read-link">
            Read Full Analysis
            <svg viewBox="0 0 20 20" fill="none" width="12" height="12">
              <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
          </a>
        </div>
      </article>

    </div>
  </section>

  <!-- ══ Posts Listing ══════════════════════════════════════ -->
  <section class="posts-section" ref="sectionEl">

    <!-- SVG bg texture -->
    <svg class="posts-bg-svg" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <pattern id="il-dots" width="32" height="32" patternUnits="userSpaceOnUse">
          <circle cx="1" cy="1" r="0.7" fill="rgba(11,28,56,0.055)"/>
        </pattern>
      </defs>
      <rect width="1440" height="900" fill="url(#il-dots)"/>
      <circle cx="1380" cy="100"  r="220" fill="none" stroke="rgba(201,168,76,0.05)" stroke-width="1"/>
      <circle cx="60"   cy="800"  r="160" fill="none" stroke="rgba(201,168,76,0.04)" stroke-width="1"/>
    </svg>

    <div class="container">

      <!-- Header -->
      <div class="list-header" :class="{ visible: revealed }">
        <div class="section-label">
          <div class="section-tag"><span class="tag-line"/>All Articles</div>
          <h2 class="section-title">Browse Insights</h2>
        </div>
        <span class="results-count">{{ filteredPosts.length }} articles</span>
      </div>

      <!-- Filter tabs -->
      <div class="filters-wrap" :class="{ visible: revealed }">
        <div class="filters-scroll" ref="filtersEl">
          <button
            v-for="tab in tabs"
            :key="tab.key"
            class="filter-btn"
            :class="{ active: activeTab === tab.key }"
            @click="setTab(tab.key)"
          >
            {{ tab.label }}
            <span class="tab-count">{{ getCount(tab.key) }}</span>
          </button>
        </div>
        <div class="tab-ink-bar" :style="inkBarStyle"/>
      </div>

      <!-- Cards grid -->
      <TransitionGroup name="cards" tag="div" class="posts-grid">
        <article
          v-for="post in filteredPosts"
          :key="post.id"
          class="post-card"
          :class="{ visible: revealed }"
        >
          <!-- Animated top bar -->
          <div class="card-top-bar"/>

          <!-- Type row -->
          <div class="card-type-row">
            <span class="card-cat" :class="`cat-${slug(post.category)}`">
              <span class="cat-dot"/>
              {{ post.category }}
            </span>
            <span class="card-read-time">{{ post.readTime }}</span>
          </div>

          <h3>{{ post.title }}</h3>
          <p>{{ post.excerpt }}</p>

          <!-- Tags -->
          <div class="card-tag-row">
            <span v-for="tag in post.tags" :key="tag" class="tag-pill">{{ tag }}</span>
          </div>

          <!-- Footer -->
          <div class="card-footer">
            <div class="card-author-row">
              <div class="card-author-avatar">{{ post.authorInitials }}</div>
              <span class="card-author-name">{{ post.author }}</span>
            </div>
            <span class="card-date">{{ post.date }}</span>
          </div>

          <a href="/insights/reforming-fiscal-federalism" class="card-read-link">
            Read
            <svg viewBox="0 0 16 16" fill="none" width="11" height="11">
              <path d="M3 8h10M8 3l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </a>

          <!-- Shimmer sweep -->
          <div class="card-shimmer"/>
        </article>
      </TransitionGroup>

      <!-- Empty state -->
      <div v-if="filteredPosts.length === 0" class="empty-state">
        No articles in this category yet.
      </div>

      <!-- Pagination -->
      <div class="pagination" :class="{ visible: revealed }">
        <div class="pagination-info">Showing 1–{{ filteredPosts.length }} of 128 articles</div>
        <div class="pagination-pages">
          <button class="page-btn prev-btn" disabled aria-label="Previous page">
            <svg viewBox="0 0 16 16" fill="none" width="12" height="12">
              <path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </button>
          <button
            v-for="n in 5"
            :key="n"
            class="page-btn"
            :class="{ active: n === 1 }"
          >{{ n }}</button>
          <span class="page-ellipsis">…</span>
          <button class="page-btn">11</button>
          <button class="page-btn next-btn" aria-label="Next page">
            <svg viewBox="0 0 16 16" fill="none" width="12" height="12">
              <path d="M6 3l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </button>
        </div>
      </div>

    </div>
  </section>

</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, nextTick, watch } from 'vue'

const sectionEl   = ref(null)
const filtersEl   = ref(null)
const featRevealed = ref(false)
const revealed    = ref(false)
const featHovered = ref(false)
const activeTab   = ref('all')
const inkBarStyle = ref({ left: '0px', width: '0px' })

// ── Helpers ────────────────────────────────────────────────
function slug(s) {
  return s.toLowerCase().replace(/[\s/&]+/g, '-').replace(/[^a-z-]/g, '')
}

// ── Featured post ──────────────────────────────────────────
const featuredPost = {
  category:       'Analysis',
  title:          'Reforming India\'s Fiscal Federalism: Balancing Centre–State Financial Relations',
  excerpt:        'An examination of the 16th Finance Commission\'s mandate and what structural fiscal reforms are needed to address growing vertical and horizontal imbalances in India\'s federal architecture. This piece argues for a rethinking of the divisible pool, tied grants, and devolution criteria.',
  author:         'Dr. Priya Menon',
  authorInitials: 'PM',
  date:           'Feb 12, 2025',
  readTime:       '14 min read',
  tags:           ['Fiscal Policy', 'Federalism', '16th Finance Commission'],
}

// ── Tabs ───────────────────────────────────────────────────
const tabs = [
  { key: 'all',          label: 'All'          },
  { key: 'Analysis',     label: 'Analysis'     },
  { key: 'Op-Ed',        label: 'Op-Ed'        },
  { key: 'Explainer',    label: 'Explainer'    },
  { key: 'Policy Brief', label: 'Policy Brief' },
  { key: 'Commentary',   label: 'Commentary'   },
  { key: 'Interview',    label: 'Interview'    },
]

// ── Posts ──────────────────────────────────────────────────
const posts = [
  {
    id: 1, category: 'Op-Ed', readTime: '6 min',
    title: 'Municipal Finance is India\'s Forgotten Crisis',
    excerpt: 'Urban local bodies collect less than 1% of GDP in taxes. This structural deficit must change for India\'s cities to grow sustainably.',
    author: 'Vikram Nair', authorInitials: 'VN',
    date: 'Feb 8, 2025', tags: ['Urban Governance', 'Finance'],
  },
  {
    id: 2, category: 'Explainer', readTime: '8 min',
    title: 'India\'s New Criminal Laws: A Citizen\'s Guide to BNS, BNSS & BSA',
    excerpt: 'Plain-language breakdown of three landmark laws replacing the IPC, CrPC, and Evidence Act — and what changes in practice.',
    author: 'Aditi Sharma', authorInitials: 'AS',
    date: 'Jan 28, 2025', tags: ['Criminal Law', 'Citizens\' Rights'],
  },
  {
    id: 3, category: 'Commentary', readTime: '9 min',
    title: 'What BRICS Expansion Means for India\'s Strategic Calculus',
    excerpt: 'Analysing geopolitical and economic implications of a larger BRICS grouping for India\'s multi-alignment foreign policy posture.',
    author: 'Arjun Krishnamurthy', authorInitials: 'AK',
    date: 'Jan 20, 2025', tags: ['Foreign Policy', 'BRICS'],
  },
  {
    id: 4, category: 'Analysis', readTime: '12 min',
    title: 'State of Digital Public Infrastructure: India 2025',
    excerpt: 'Comprehensive review of DPI adoption, trust scores, and equity gaps across 28 states and 8 union territories.',
    author: 'Raghav Krishnan', authorInitials: 'RK',
    date: 'Jan 15, 2025', tags: ['Digital India', 'DPI'],
  },
  {
    id: 5, category: 'Policy Brief', readTime: '10 min',
    title: 'Gram Panchayats at 75: Finances, Capacity & Accountability',
    excerpt: 'A 10-state study of Panchayati Raj institutions — what genuine decentralisation requires in terms of finance, power, and personnel.',
    author: 'BGC Research Team', authorInitials: 'BG',
    date: 'Jan 5, 2025', tags: ['Panchayati Raj', 'Decentralisation'],
  },
  {
    id: 6, category: 'Explainer', readTime: '7 min',
    title: 'How India\'s Data Protection Law Will Work in Practice',
    excerpt: 'The DPDP Act 2023 is being implemented. Here\'s what it means for citizens, companies, and the government.',
    author: 'Sonal Mehta', authorInitials: 'SM',
    date: 'Dec 28, 2024', tags: ['Data Protection', 'Digital Rights'],
  },
  {
    id: 7, category: 'Interview', readTime: '11 min',
    title: '"India\'s Judiciary Needs a Docket Management Revolution"',
    excerpt: 'Former Law Commission member Dr. Rashmi Sinha on case backlogs, court digitisation, and the road ahead for judicial reform.',
    author: 'BGC Editorial', authorInitials: 'BE',
    date: 'Dec 18, 2024', tags: ['Judiciary', 'Legal Reform'],
  },
  {
    id: 8, category: 'Op-Ed', readTime: '5 min',
    title: 'The MGNREGA Debate We\'re Not Having',
    excerpt: 'Employment guarantee schemes are dismissed too quickly by technocrats. A more honest reckoning of what works and what doesn\'t.',
    author: 'Kavya Reddy', authorInitials: 'KR',
    date: 'Dec 10, 2024', tags: ['Employment', 'Rural Policy'],
  },
  {
    id: 9, category: 'Analysis', readTime: '16 min',
    title: 'The Centre-State Battle Over GST Compensation',
    excerpt: 'Five years after GST\'s rollout, outstanding compensation claims are creating a new fault line in cooperative federalism.',
    author: 'Dr. Priya Menon', authorInitials: 'PM',
    date: 'Nov 30, 2024', tags: ['GST', 'Fiscal Policy'],
  },
  {
    id: 10, category: 'Commentary', readTime: '8 min',
    title: 'Regulation by Notification: India\'s Quiet Governance Problem',
    excerpt: 'Major policy shifts are increasingly made through executive orders and notifications, bypassing legislative scrutiny entirely.',
    author: 'Arjun Krishnamurthy', authorInitials: 'AK',
    date: 'Nov 22, 2024', tags: ['Executive Power', 'Legislature'],
  },
  {
    id: 11, category: 'Policy Brief', readTime: '13 min',
    title: 'Making India\'s Competition Law Fit for the Digital Age',
    excerpt: 'The Competition Amendment Act 2023 is a start, but digital markets demand a fundamentally different antitrust approach.',
    author: 'Sonal Mehta', authorInitials: 'SM',
    date: 'Nov 12, 2024', tags: ['Competition Law', 'Digital Markets'],
  },
  {
    id: 12, category: 'Explainer', readTime: '9 min',
    title: 'Understanding India\'s New Telecom Act: What Changed?',
    excerpt: 'The Telecommunications Act 2023 replaces a 138-year-old law. We break down the key changes for citizens and businesses.',
    author: 'Aditi Sharma', authorInitials: 'AS',
    date: 'Oct 30, 2024', tags: ['Telecom', 'Regulation'],
  },
]

// ── Filter logic ───────────────────────────────────────────
const filteredPosts = computed(() =>
  activeTab.value === 'all'
    ? posts
    : posts.filter(p => p.category === activeTab.value)
)

function getCount(key) {
  if (key === 'all') return posts.length
  return posts.filter(p => p.category === key).length
}

function setTab(key) {
  activeTab.value = key
  nextTick(() => updateInkBar())
}

function updateInkBar() {
  if (!filtersEl.value) return
  const activeBtn  = filtersEl.value.querySelector('.filter-btn.active')
  if (!activeBtn) return
  const parentRect = filtersEl.value.getBoundingClientRect()
  const btnRect    = activeBtn.getBoundingClientRect()
  inkBarStyle.value = {
    left:  `${btnRect.left - parentRect.left}px`,
    width: `${btnRect.width}px`,
  }
}

watch(activeTab, () => {
  nextTick(() => {
    const activeBtn = filtersEl.value?.querySelector('.filter-btn.active')
    activeBtn?.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' })
  })
})

// ── Observers ─────────────────────────────────────────────
let observer = null

onMounted(() => {
  // Featured section — reveal immediately (above the fold)
  requestAnimationFrame(() => setTimeout(() => { featRevealed.value = true }, 100))

  // Posts section — reveal on scroll
  observer = new IntersectionObserver(
    ([e]) => {
      if (e.isIntersecting) {
        revealed.value = true
        observer.disconnect()
        nextTick(() => updateInkBar())
      }
    },
    { threshold: 0.06 }
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
/* ═══════════════════════════════════════════
   SHARED
═══════════════════════════════════════════ */
.container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 60px;
  position: relative;
  z-index: 2;
}

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
  color: #0b1c38;
  line-height: 1.1;
}

/* Tag pill — shared between featured & cards */
.tag-pill {
  font-size: 9px;
  font-weight: 500;
  color: rgba(201,168,76,0.75);
  background: rgba(201,168,76,0.08);
  border: 1px solid rgba(201,168,76,0.20);
  padding: 3px 9px;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
  transition: background 0.2s, color 0.2s;
}

/* ═══════════════════════════════════════════
   FEATURED SECTION
═══════════════════════════════════════════ */
.featured-section {
  background: #f2f4f8;
  padding: 80px 0 0;
}

.section-header {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  margin-bottom: 32px;
  opacity: 0;
  transform: translateY(18px);
  transition: opacity 0.7s ease, transform 0.7s ease;
}
.section-header.visible { opacity: 1; transform: translateY(0); }

.featured-date-meta {
  font-size: 11px;
  color: #8a9bbf;
  font-family: 'DM Mono', monospace;
  letter-spacing: 0.08em;
}

/* ── Featured card ───────────────────────── */
.featured-card {
  position: relative;
  background: #0b1c38;
  overflow: hidden;
  min-height: 380px;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  cursor: pointer;
  opacity: 0;
  transform: translateY(22px);
  transition: opacity 0.85s ease 0.12s, transform 0.85s ease 0.12s, box-shadow 0.35s;
}
.featured-card.visible { opacity: 1; transform: translateY(0); }
.featured-card:hover { box-shadow: 0 28px 72px rgba(11,28,56,0.42); }

.feat-bg-svg {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}

.feat-glass-overlay {
  position: absolute;
  inset: 0;
  background: rgba(201,168,76,0.04);
  backdrop-filter: blur(2px);
  transition: opacity 0.4s ease;
  pointer-events: none;
}

.feat-content {
  position: relative;
  z-index: 2;
  padding: 52px 60px 48px;
  max-width: 800px;
}

.feat-top-row {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 20px;
}

.feat-cat-badge {
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

.feat-featured-tag {
  font-size: 10px;
  font-weight: 600;
  color: #c9a84c;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  padding: 4px 10px;
  border: 1px solid rgba(201,168,76,0.3);
  font-family: 'DM Mono', monospace;
}

.feat-content h2 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 38px;
  font-weight: 600;
  color: #fff;
  line-height: 1.15;
  margin-bottom: 16px;
}

.feat-content p {
  font-size: 15px;
  font-weight: 300;
  color: #b8c5d8;
  line-height: 1.78;
  margin-bottom: 22px;
  font-family: 'DM Sans', sans-serif;
}

.feat-tag-row {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin-bottom: 26px;
}

.feat-meta-row {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 26px;
  flex-wrap: wrap;
}

.feat-author-avatar {
  width: 30px; height: 30px;
  border-radius: 50%;
  background: rgba(201,168,76,0.15);
  border: 1px solid rgba(201,168,76,0.35);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Cormorant Garamond', serif;
  font-size: 12px;
  font-weight: 600;
  color: #c9a84c;
  flex-shrink: 0;
}

.feat-author {
  font-size: 12px;
  color: #8a9bbf;
  letter-spacing: 0.06em;
  font-family: 'DM Sans', sans-serif;
}

.feat-date,
.feat-readtime {
  font-size: 11px;
  color: rgba(138,155,191,0.55);
  font-family: 'DM Mono', monospace;
}

.meta-dot {
  width: 3px; height: 3px;
  background: #8a9bbf;
  border-radius: 50%;
  opacity: 0.5;
  flex-shrink: 0;
}

.feat-read-link {
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
  border-bottom: 1px solid rgba(201,168,76,0.28);
  padding-bottom: 3px;
  transition: color 0.2s, border-color 0.2s, gap 0.2s;
}
.feat-read-link:hover { color: #e8cf8a; border-color: #e8cf8a; gap: 13px; }

/* ═══════════════════════════════════════════
   POSTS SECTION
═══════════════════════════════════════════ */
.posts-section {
  background: #f2f4f8;
  padding: 72px 0 88px;
  position: relative;
  overflow: hidden;
}

.posts-bg-svg {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}

/* ── List header ─────────────────────────── */
.list-header {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  margin-bottom: 36px;
  opacity: 0;
  transform: translateY(18px);
  transition: opacity 0.7s ease 0.05s, transform 0.7s ease 0.05s;
}
.list-header.visible { opacity: 1; transform: translateY(0); }

.results-count {
  font-size: 11px;
  color: #8a9bbf;
  font-family: 'DM Mono', monospace;
  letter-spacing: 0.08em;
}

/* ── Filter tabs ─────────────────────────── */
.filters-wrap {
  position: relative;
  margin-bottom: 48px;
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
  -webkit-mask-image: linear-gradient(90deg, transparent 0%, #000 4%, #000 96%, transparent 100%);
  mask-image: linear-gradient(90deg, transparent 0%, #000 4%, #000 96%, transparent 100%);
}
.filters-scroll::-webkit-scrollbar { display: none; }

.filter-btn {
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
  border: 1px solid rgba(11,28,56,0.10);
  cursor: pointer;
  font-family: 'DM Sans', sans-serif;
  transition: color 0.25s, background 0.25s, border-color 0.25s;
  white-space: nowrap;
}
.filter-btn:hover {
  color: #0b1c38;
  background: rgba(11,28,56,0.04);
  border-color: rgba(11,28,56,0.20);
}
.filter-btn.active {
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
.filter-btn.active .tab-count {
  background: rgba(201,168,76,0.25);
  color: #e8cf8a;
}

/* Animated ink bar under active tab */
.tab-ink-bar {
  position: absolute;
  bottom: 0;
  height: 2px;
  background: linear-gradient(90deg, #c9a84c, #e8cf8a);
  transition: left 0.32s cubic-bezier(0.4,0,0.2,1), width 0.32s cubic-bezier(0.4,0,0.2,1);
  border-radius: 1px;
}

/* ── Grid ────────────────────────────────── */
.posts-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  min-height: 220px;
  position: relative;
}

/* ── Post card ───────────────────────────── */
.post-card {
  position: relative;
  background: #fff;
  padding: 30px 28px 26px;
  border: 1px solid rgba(11,28,56,0.07);
  box-shadow: 0 2px 12px rgba(11,28,56,0.05);
  display: flex;
  flex-direction: column;
  cursor: pointer;
  overflow: hidden;
  transition:
    border-color 0.25s,
    transform 0.25s,
    box-shadow 0.25s;
}
.post-card:hover {
  border-color: rgba(201,168,76,0.35);
  transform: translateY(-5px);
  box-shadow: 0 16px 44px rgba(11,28,56,0.10);
}

/* Gold top bar that expands on hover */
.card-top-bar {
  position: absolute;
  top: 0; left: 0;
  height: 3px;
  width: 100%;
  background: linear-gradient(90deg, rgba(201,168,76,0.25), rgba(232,207,138,0.25));
  transform-origin: left;
  transition: background 0.3s;
}
.post-card:hover .card-top-bar {
  background: linear-gradient(90deg, #c9a84c, #e8cf8a);
}

/* Shimmer sweep on hover */
.card-shimmer {
  position: absolute;
  inset: 0;
  background: linear-gradient(105deg, transparent 40%, rgba(201,168,76,0.05) 50%, transparent 60%);
  transform: translateX(-100%);
  pointer-events: none;
  transition: transform 0s;
}
.post-card:hover .card-shimmer {
  transform: translateX(120%);
  transition: transform 0.55s ease;
}

/* Type row */
.card-type-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 14px;
}

.card-cat {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 9px;
  font-weight: 700;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  padding: 4px 11px;
  font-family: 'DM Sans', sans-serif;
  background: #e8eaf0;
  color: #0b1c38;
}
/* Category colour variants */
.cat-analysis     { background: rgba(201,168,76,0.12); color: #7a5c15; }
.cat-op-ed        { background: rgba(142,68,173,0.10); color: #6c3483; }
.cat-explainer    { background: rgba(22,160,133,0.10); color: #0e6b58; }
.cat-policy-brief { background: rgba(22,45,85,0.10);   color: #0f2347; }
.cat-commentary   { background: rgba(41,128,185,0.10); color: #1a5276; }
.cat-interview    { background: rgba(231,76,60,0.10);  color: #922b21; }

.cat-dot {
  width: 5px; height: 5px;
  border-radius: 50%;
  background: currentColor;
  flex-shrink: 0;
}

.card-read-time {
  font-size: 10px;
  color: #aab;
  font-family: 'DM Mono', monospace;
}

/* Title */
.post-card h3 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 22px;
  font-weight: 600;
  color: #0b1c38;
  line-height: 1.25;
  margin-bottom: 10px;
  transition: color 0.2s;
}
.post-card:hover h3 { color: #0f2347; }

/* Excerpt */
.post-card p {
  font-size: 13px;
  color: #6b7a94;
  line-height: 1.68;
  flex: 1;
  margin-bottom: 16px;
  font-family: 'DM Sans', sans-serif;
}

/* Tag row */
.card-tag-row {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
  margin-bottom: 18px;
}
.post-card:hover .tag-pill {
  background: rgba(201,168,76,0.13);
  color: #c9a84c;
}

/* Card footer */
.card-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 14px;
}

.card-author-row {
  display: flex;
  align-items: center;
  gap: 8px;
}

.card-author-avatar {
  width: 26px; height: 26px;
  border-radius: 50%;
  background: rgba(11,28,56,0.07);
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

.card-author-name {
  font-size: 12px;
  color: #0b1c38;
  font-weight: 500;
  font-family: 'DM Sans', sans-serif;
}

.card-date {
  font-size: 11px;
  color: #aab;
  font-family: 'DM Mono', monospace;
}

/* Read link */
.card-read-link {
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
.post-card:hover .card-read-link { color: #c9a84c; gap: 9px; }

/* ── Empty state ─────────────────────────── */
.empty-state {
  grid-column: 1 / -1;
  text-align: center;
  padding: 64px 0;
  font-family: 'DM Sans', sans-serif;
  font-size: 14px;
  color: #8a9bbf;
}

/* ── Pagination ──────────────────────────── */
.pagination {
  margin-top: 64px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 16px;
  opacity: 0;
  transform: translateY(12px);
  transition: opacity 0.7s ease 0.25s, transform 0.7s ease 0.25s;
}
.pagination.visible { opacity: 1; transform: translateY(0); }

.pagination-info {
  font-size: 12px;
  color: #8a9bbf;
  font-family: 'DM Mono', monospace;
  letter-spacing: 0.06em;
}

.pagination-pages {
  display: flex;
  align-items: center;
  gap: 4px;
}

.page-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 36px; height: 36px;
  font-size: 12px;
  font-weight: 500;
  color: #8a9bbf;
  background: transparent;
  border: 1px solid rgba(11,28,56,0.10);
  cursor: pointer;
  font-family: 'DM Mono', monospace;
  transition: color 0.2s, background 0.2s, border-color 0.2s;
}
.page-btn:hover:not(:disabled) {
  color: #0b1c38;
  background: rgba(11,28,56,0.05);
  border-color: rgba(11,28,56,0.20);
}
.page-btn.active {
  background: #0b1c38;
  border-color: #0b1c38;
  color: #c9a84c;
}
.page-btn:disabled {
  opacity: 0.28;
  cursor: not-allowed;
}

.page-ellipsis {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 36px;
  font-size: 14px;
  color: rgba(138,155,191,0.45);
}

/* ── Card transition (filter) ────────────── */
.cards-enter-active { transition: opacity 0.35s ease, transform 0.35s ease; }
.cards-leave-active {
  transition: opacity 0.2s ease, transform 0.2s ease;
  position: absolute;
  pointer-events: none;
}
.cards-enter-from { opacity: 0; transform: translateY(14px); }
.cards-leave-to   { opacity: 0; transform: translateY(-8px);  }
.cards-move       { transition: transform 0.35s ease; }

/* ═══════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════ */
@media (max-width: 1024px) {
  .container { padding: 0 32px; }
  .posts-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
  .container { padding: 0 20px; }
  .featured-section { padding: 56px 0 0; }
  .posts-section { padding: 56px 0 64px; }
  .feat-content { padding: 32px 24px 36px; }
  .feat-content h2 { font-size: 26px; }
  .section-title { font-size: 30px; }
  .section-header,
  .list-header { flex-direction: column; align-items: flex-start; gap: 12px; }
  .posts-grid { grid-template-columns: 1fr; }
  .pagination { flex-direction: column; align-items: flex-start; }
  .filters-scroll { padding: 0 20px 2px; margin: 0 -20px; }
}
</style>
