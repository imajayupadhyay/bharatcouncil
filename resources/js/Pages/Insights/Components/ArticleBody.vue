<template>
  <section class="article-body-section" ref="sectionEl">

    <!-- SVG bg texture -->
    <svg class="body-bg-svg" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <pattern id="ab-dots" width="36" height="36" patternUnits="userSpaceOnUse">
          <circle cx="1" cy="1" r="0.65" fill="rgba(11,28,56,0.045)"/>
        </pattern>
      </defs>
      <rect width="1440" height="900" fill="url(#ab-dots)"/>
    </svg>

    <div class="ab-container">

      <!-- ── Main grid: article + sidebar ── -->
      <div class="ab-grid">

        <!-- ═══════════════ ARTICLE PROSE ═══════════════ -->
        <article class="article-prose" :class="{ visible: revealed }">

          <!-- Dynamic content from TipTap editor -->
          <div class="article-content" v-html="post.content"></div>

          <!-- Article footer -->
          <div class="article-footer-meta">
            <div class="af-divider"/>
            <div class="af-row">
              <div class="af-author-block">
                <div class="af-avatar">{{ getInitials(post.author_name) }}</div>
                <div class="af-author-info">
                  <span class="af-name">{{ post.author_name }}</span>
                  <span class="af-bio">Bharat Governance Council</span>
                </div>
              </div>
              <div class="af-share">
                <span class="af-share-label">Share</span>
                <a v-for="s in shareLinks" :key="s.label" href="#" class="af-share-btn" :title="s.label">
                  <span v-html="s.icon"/>
                </a>
              </div>
            </div>
          </div>

        </article>

        <!-- ═══════════════ SIDEBAR ═══════════════ -->
        <aside class="article-sidebar" :class="{ visible: revealed }">

          <!-- Author card -->
          <div class="sidebar-card">
            <div class="sb-section-label">Author</div>
            <div class="sb-author">
              <div class="sb-avatar">{{ getInitials(post.author_name) }}</div>
              <div class="sb-author-details">
                <h4>{{ post.author_name }}</h4>
                <p>Bharat Governance Council</p>
              </div>
            </div>
          </div>

          <!-- Topics -->
          <div v-if="post.category" class="sidebar-card">
            <div class="sb-section-label">Category</div>
            <div class="sb-tags">
              <span class="sb-tag">{{ post.category.name }}</span>
            </div>
          </div>

          <!-- Share -->
          <div class="sidebar-card sidebar-share-card">
            <div class="sb-section-label">Share Article</div>
            <div class="sb-share-btns">
              <a v-for="s in shareLinks" :key="s.label" href="#" class="sb-share-btn">
                <span v-html="s.icon"/>
                {{ s.label }}
              </a>
            </div>
          </div>

          <!-- Reading info -->
          <div class="sidebar-card reading-info-card">
            <div class="ri-row">
              <svg viewBox="0 0 16 16" fill="none" width="13" height="13" class="ri-icon">
                <circle cx="8" cy="8" r="6.5" stroke="currentColor" stroke-width="1.2"/>
                <path d="M8 4.5v4l2.5 1.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
              </svg>
              <span class="ri-label">{{ post.read_time || 'Read' }}</span>
            </div>
            <div class="ri-row">
              <svg viewBox="0 0 16 16" fill="none" width="13" height="13" class="ri-icon">
                <rect x="2" y="2" width="12" height="12" rx="1" stroke="currentColor" stroke-width="1.2"/>
                <path d="M5 7h6M5 10h4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
              </svg>
              <span class="ri-label">{{ formatDate(post.published_at) }}</span>
            </div>
          </div>

        </aside>

      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const props = defineProps({ post: Object })

const sectionEl = ref(null)
const revealed  = ref(false)

function getInitials(name) {
  if (!name) return '?'
  return name.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase()
}

function formatDate(dateStr) {
  if (!dateStr) return ''
  const d = new Date(dateStr)
  return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
}

const shareLinks = [
  { label: 'Twitter / X',  icon: '<svg viewBox="0 0 20 20" fill="currentColor" width="12" height="12"><path d="M16.99 2h-2.77l-3.3 4.17L7.73 2H2l5.93 8.06L2.44 18h2.77l3.55-4.49L12.38 18H18l-6.13-8.27L16.99 2z"/></svg>' },
  { label: 'LinkedIn',     icon: '<svg viewBox="0 0 20 20" fill="currentColor" width="12" height="12"><path d="M5 3a2 2 0 110 4 2 2 0 010-4zm-2 6h4v8H3V9zm6 0h3.6v1.1h.05c.5-.95 1.73-1.95 3.55-1.95C18.96 8.15 19 10.42 19 13.04V17h-3.8v-3.3c0-1.44-.5-2.42-1.75-2.42-1.29 0-1.75.89-1.75 2.42V17H9V9z"/></svg>' },
  { label: 'WhatsApp',     icon: '<svg viewBox="0 0 20 20" fill="currentColor" width="12" height="12"><path d="M10 2C5.58 2 2 5.58 2 10c0 1.52.42 2.94 1.14 4.16L2 18l3.96-1.12A7.94 7.94 0 0010 18c4.42 0 8-3.58 8-8s-3.58-8-8-8zm3.7 10.7c-.17.48-.97.92-1.33.98-.34.05-.76.07-1.22-.08-.28-.09-.64-.22-1.1-.42-1.93-.83-3.19-2.78-3.29-2.91-.1-.13-.8-1.06-.8-2.02s.5-1.43.69-1.63c.18-.19.4-.24.53-.24l.38.01c.12 0 .29-.05.45.34.17.4.58 1.42.63 1.52.05.1.08.22.02.35-.07.13-.1.21-.2.32-.1.11-.21.24-.3.33-.1.1-.2.2-.09.4.12.2.52.85 1.12 1.38.77.68 1.42.9 1.62.99.2.09.32.08.44-.05.12-.13.5-.58.63-.78.13-.2.27-.17.45-.1.18.07 1.14.54 1.34.63.2.1.33.14.38.22.05.08.05.47-.12.95z"/></svg>' },
  { label: 'Copy Link',    icon: '<svg viewBox="0 0 20 20" fill="none" width="12" height="12"><path d="M8 12.5l4-5M9.5 14l-1.5 1.5a3.5 3.5 0 01-5-5L5 9M11 6.5l1-1a3.5 3.5 0 015 5L15.5 12" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>' },
]

let observer = null
onMounted(() => {
  observer = new IntersectionObserver(
    ([e]) => { if (e.isIntersecting) { revealed.value = true; observer.disconnect() } },
    { threshold: 0.04 }
  )
  if (sectionEl.value) observer.observe(sectionEl.value)
})
onUnmounted(() => observer?.disconnect())
</script>

<style scoped>
/* ── Section ────────────────────────────────── */
.article-body-section {
  position: relative;
  background: #f2f4f8;
  padding: 80px 0 96px;
  overflow: hidden;
}
.body-bg-svg {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}

.ab-container {
  position: relative;
  z-index: 2;
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 60px;
}

/* ── Two-column grid ──────────────────────── */
.ab-grid {
  display: grid;
  grid-template-columns: 1fr 300px;
  gap: 60px;
  align-items: start;
}

/* ═══════════════════════════════════════════
   ARTICLE PROSE
═══════════════════════════════════════════ */
.article-prose {
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.8s ease, transform 0.8s ease;
}
.article-prose.visible { opacity: 1; transform: translateY(0); }

/* Lead paragraph */
.lead-para {
  font-family: 'DM Sans', sans-serif;
  font-size: 19px;
  font-weight: 400;
  color: #0b1c38;
  line-height: 1.78;
  margin-bottom: 44px;
  padding-left: 20px;
  border-left: 3px solid #c9a84c;
}

/* Key Findings Box */
.key-findings-box {
  background: #0b1c38;
  border: 1px solid rgba(201,168,76,0.25);
  padding: 32px 36px;
  margin-bottom: 52px;
  position: relative;
  overflow: hidden;
}
.key-findings-box::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 2px;
  background: linear-gradient(90deg, #c9a84c, #e8cf8a, rgba(201,168,76,0.2));
}
.kf-header {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 20px;
}
.kf-icon {
  font-size: 14px;
  color: #c9a84c;
  letter-spacing: 0.1em;
}
.kf-header h4 {
  font-family: 'DM Sans', sans-serif;
  font-size: 10px;
  font-weight: 700;
  color: #c9a84c;
  letter-spacing: 0.3em;
  text-transform: uppercase;
}
.kf-list {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 12px;
}
.kf-list li {
  font-family: 'DM Sans', sans-serif;
  font-size: 14px;
  color: #b8c5d8;
  line-height: 1.65;
  padding-left: 20px;
  position: relative;
}
.kf-list li::before {
  content: '◇';
  position: absolute;
  left: 0;
  top: 1px;
  font-size: 8px;
  color: rgba(201,168,76,0.6);
}

/* Article H2 */
.article-h2 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 32px;
  font-weight: 600;
  color: #0b1c38;
  line-height: 1.15;
  margin-bottom: 22px;
  margin-top: 52px;
  display: flex;
  align-items: baseline;
  gap: 14px;
}
.h2-num {
  font-family: 'DM Mono', monospace;
  font-size: 11px;
  font-weight: 500;
  color: #c9a84c;
  letter-spacing: 0.1em;
  padding: 3px 8px;
  border: 1px solid rgba(201,168,76,0.3);
  flex-shrink: 0;
  position: relative;
  top: -2px;
}

/* Body paragraphs */
.article-prose p,
.article-prose :deep(p) {
  font-family: 'DM Sans', sans-serif;
  font-size: 16px;
  font-weight: 300;
  color: #3a4a62;
  line-height: 1.85;
  margin-bottom: 22px;
}

/* ── Dynamic content (v-html from TipTap) ── */
.article-content :deep(h1),
.article-content :deep(h2),
.article-content :deep(h3) {
  font-family: 'Cormorant Garamond', serif;
  font-weight: 600;
  color: #0b1c38;
  line-height: 1.15;
  margin-top: 44px;
  margin-bottom: 18px;
}
.article-content :deep(h1) { font-size: 36px; }
.article-content :deep(h2) { font-size: 30px; }
.article-content :deep(h3) { font-size: 24px; }

.article-content :deep(p) {
  font-family: 'DM Sans', sans-serif;
  font-size: 16px;
  font-weight: 300;
  color: #3a4a62;
  line-height: 1.85;
  margin-bottom: 22px;
}

.article-content :deep(ul),
.article-content :deep(ol) {
  margin: 20px 0;
  padding-left: 24px;
}
.article-content :deep(li) {
  font-family: 'DM Sans', sans-serif;
  font-size: 15px;
  color: #3a4a62;
  line-height: 1.75;
  margin-bottom: 10px;
}

.article-content :deep(blockquote) {
  margin: 36px 0;
  padding: 24px 32px;
  border-left: 4px solid #c9a84c;
  background: #fff;
  box-shadow: 0 4px 24px rgba(11,28,56,0.06);
}
.article-content :deep(blockquote p) {
  font-family: 'Cormorant Garamond', serif;
  font-size: 22px;
  font-weight: 500;
  font-style: italic;
  color: #0b1c38;
  line-height: 1.55;
  margin-bottom: 0;
}

.article-content :deep(img) {
  max-width: 100%;
  height: auto;
  margin: 32px 0;
  border: 1px solid rgba(11,28,56,0.07);
  box-shadow: 0 4px 20px rgba(11,28,56,0.08);
}

.article-content :deep(a) {
  color: #c9a84c;
  text-decoration: underline;
  text-decoration-color: rgba(201,168,76,0.3);
  transition: text-decoration-color 0.2s;
}
.article-content :deep(a:hover) {
  text-decoration-color: #c9a84c;
}

.article-content :deep(strong) {
  font-weight: 600;
  color: #0b1c38;
}

.article-content :deep(em) {
  font-style: italic;
}

.article-content :deep(hr) {
  border: none;
  height: 1px;
  background: linear-gradient(90deg, rgba(11,28,56,0.12), transparent);
  margin: 40px 0;
}

.article-content :deep(pre) {
  background: #0b1c38;
  color: #b8c5d8;
  padding: 20px 24px;
  overflow-x: auto;
  margin: 28px 0;
  font-family: 'DM Mono', monospace;
  font-size: 13px;
  line-height: 1.7;
}

.article-content :deep(code) {
  font-family: 'DM Mono', monospace;
  font-size: 13px;
  background: rgba(11,28,56,0.06);
  padding: 2px 6px;
  color: #0b1c38;
}

.article-content :deep(pre code) {
  background: none;
  padding: 0;
  color: inherit;
}

.article-content :deep(table) {
  width: 100%;
  border-collapse: collapse;
  margin: 28px 0;
  font-family: 'DM Sans', sans-serif;
  font-size: 14px;
}
.article-content :deep(th),
.article-content :deep(td) {
  padding: 10px 14px;
  border: 1px solid rgba(11,28,56,0.1);
  text-align: left;
  color: #3a4a62;
}
.article-content :deep(th) {
  background: #0b1c38;
  color: #e8cf8a;
  font-weight: 600;
  font-size: 10px;
  letter-spacing: 0.12em;
  text-transform: uppercase;
}

/* Pull quote */
.pull-quote {
  margin: 44px 0;
  padding: 28px 36px;
  position: relative;
  background: #fff;
  border: 1px solid rgba(201,168,76,0.18);
  box-shadow: 0 4px 24px rgba(11,28,56,0.06);
}
.pq-bar {
  position: absolute;
  top: 0; left: 0;
  width: 4px; height: 100%;
  background: linear-gradient(to bottom, #c9a84c, #e8cf8a);
}
.pull-quote p {
  font-family: 'Cormorant Garamond', serif !important;
  font-size: 22px !important;
  font-weight: 500 !important;
  font-style: italic;
  color: #0b1c38 !important;
  line-height: 1.55 !important;
  margin-bottom: 14px !important;
}
.pull-quote cite {
  display: block;
  font-family: 'DM Mono', monospace;
  font-size: 11px;
  color: #8a9bbf;
  letter-spacing: 0.06em;
  font-style: normal;
}

/* Data callout */
.data-callout {
  background: #fff;
  border: 1px solid rgba(11,28,56,0.07);
  padding: 28px 32px;
  margin: 44px 0;
  box-shadow: 0 2px 16px rgba(11,28,56,0.05);
}
.dc-header {
  display: flex;
  align-items: center;
  gap: 14px;
  margin-bottom: 24px;
}
.dc-label {
  font-size: 9px;
  font-weight: 700;
  color: #c9a84c;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
  white-space: nowrap;
}
.dc-rule {
  flex: 1;
  height: 1px;
  background: linear-gradient(90deg, rgba(201,168,76,0.3), transparent);
}
.dc-stats {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 24px;
}
.dc-stat {
  display: flex;
  flex-direction: column;
  gap: 6px;
}
.dc-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 34px;
  font-weight: 700;
  color: #0b1c38;
  line-height: 1;
}
.dc-desc {
  font-size: 11px;
  color: #8a9bbf;
  line-height: 1.4;
  font-family: 'DM Sans', sans-serif;
}

/* Inline note */
.inline-note {
  display: flex;
  gap: 0;
  margin: 40px 0;
  background: rgba(201,168,76,0.05);
  border: 1px solid rgba(201,168,76,0.18);
}
.note-bar {
  width: 3px;
  background: linear-gradient(to bottom, #c9a84c, #e8cf8a);
  flex-shrink: 0;
}
.note-content {
  padding: 20px 24px;
}
.note-label {
  display: block;
  font-size: 9px;
  font-weight: 700;
  color: #c9a84c;
  letter-spacing: 0.28em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
  margin-bottom: 10px;
}
.note-content p {
  font-family: 'DM Sans', sans-serif;
  font-size: 14px;
  color: #4a5a74;
  line-height: 1.7;
  margin-bottom: 0 !important;
}

/* Ordered list */
.article-ol {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 18px;
  margin: 28px 0 40px;
  counter-reset: article-ol;
}
.article-ol li {
  counter-increment: article-ol;
  font-family: 'DM Sans', sans-serif;
  font-size: 15px;
  font-weight: 300;
  color: #3a4a62;
  line-height: 1.75;
  padding-left: 48px;
  position: relative;
}
.article-ol li::before {
  content: counter(article-ol, decimal-leading-zero);
  position: absolute;
  left: 0;
  top: 0;
  font-family: 'DM Mono', monospace;
  font-size: 11px;
  font-weight: 500;
  color: #c9a84c;
  background: rgba(201,168,76,0.1);
  border: 1px solid rgba(201,168,76,0.25);
  width: 30px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  letter-spacing: 0.04em;
}
.article-ol li strong {
  font-weight: 600;
  color: #0b1c38;
}

/* Article footer */
.article-footer-meta {
  margin-top: 64px;
}
.af-divider {
  height: 1px;
  background: linear-gradient(90deg, rgba(11,28,56,0.12), transparent);
  margin-bottom: 36px;
}
.af-row {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 32px;
  flex-wrap: wrap;
}
.af-author-block {
  display: flex;
  align-items: flex-start;
  gap: 16px;
  flex: 1;
}
.af-avatar {
  width: 52px; height: 52px;
  border-radius: 50%;
  background: rgba(201,168,76,0.12);
  border: 1.5px solid rgba(201,168,76,0.35);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Cormorant Garamond', serif;
  font-size: 18px;
  font-weight: 600;
  color: #c9a84c;
  flex-shrink: 0;
}
.af-author-info { display: flex; flex-direction: column; gap: 6px; }
.af-name {
  font-size: 16px;
  font-weight: 600;
  color: #0b1c38;
  font-family: 'DM Sans', sans-serif;
}
.af-bio {
  font-size: 13px;
  color: #6b7a94;
  line-height: 1.6;
  max-width: 420px;
  font-family: 'DM Sans', sans-serif;
}
.af-share {
  display: flex;
  align-items: center;
  gap: 8px;
  flex-shrink: 0;
}
.af-share-label {
  font-size: 9px;
  font-weight: 700;
  color: #8a9bbf;
  letter-spacing: 0.28em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}
.af-share-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 32px; height: 32px;
  background: rgba(11,28,56,0.06);
  border: 1px solid rgba(11,28,56,0.1);
  color: #8a9bbf;
  text-decoration: none;
  transition: background 0.2s, border-color 0.2s, color 0.2s, transform 0.2s;
}
.af-share-btn:hover {
  background: rgba(201,168,76,0.1);
  border-color: rgba(201,168,76,0.3);
  color: #c9a84c;
  transform: translateY(-2px);
}

/* ═══════════════════════════════════════════
   SIDEBAR
═══════════════════════════════════════════ */
.article-sidebar {
  position: sticky;
  top: calc(72px + 24px);
  display: flex;
  flex-direction: column;
  gap: 16px;
  opacity: 0;
  transform: translateX(16px);
  transition: opacity 0.8s ease 0.2s, transform 0.8s ease 0.2s;
}
.article-sidebar.visible { opacity: 1; transform: translateX(0); }

.sidebar-card {
  background: #fff;
  border: 1px solid rgba(11,28,56,0.07);
  padding: 22px 20px;
  box-shadow: 0 2px 12px rgba(11,28,56,0.04);
}

.sb-section-label {
  font-size: 9px;
  font-weight: 700;
  color: #c9a84c;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
  margin-bottom: 16px;
  display: flex;
  align-items: center;
  gap: 8px;
}
.sb-section-label::after {
  content: '';
  flex: 1;
  height: 1px;
  background: rgba(201,168,76,0.2);
}

/* Author card */
.sb-author {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 12px;
}
.sb-avatar {
  width: 40px; height: 40px;
  border-radius: 50%;
  background: rgba(201,168,76,0.12);
  border: 1px solid rgba(201,168,76,0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Cormorant Garamond', serif;
  font-size: 14px;
  font-weight: 600;
  color: #c9a84c;
  flex-shrink: 0;
}
.sb-author-details h4 {
  font-size: 14px;
  font-weight: 600;
  color: #0b1c38;
  font-family: 'DM Sans', sans-serif;
  margin-bottom: 2px;
}
.sb-author-details p {
  font-size: 11px;
  color: #8a9bbf;
  font-family: 'DM Mono', monospace;
}
.sb-author-bio {
  font-size: 12px;
  color: #6b7a94;
  line-height: 1.6;
  margin-bottom: 14px;
  font-family: 'DM Sans', sans-serif;
}
.sb-author-social {
  display: flex;
  gap: 6px;
}
.sb-social-link {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 28px; height: 28px;
  background: rgba(11,28,56,0.05);
  border: 1px solid rgba(11,28,56,0.08);
  color: #8a9bbf;
  text-decoration: none;
  transition: background 0.2s, color 0.2s, border-color 0.2s;
}
.sb-social-link:hover {
  background: rgba(201,168,76,0.1);
  border-color: rgba(201,168,76,0.3);
  color: #c9a84c;
}

/* TOC */
.toc-list {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 2px;
}
.toc-link {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 12px;
  color: #6b7a94;
  text-decoration: none;
  font-family: 'DM Sans', sans-serif;
  padding: 7px 0;
  border-bottom: 1px solid rgba(11,28,56,0.05);
  transition: color 0.2s, gap 0.2s;
}
.toc-link:hover { color: #0b1c38; gap: 14px; }
.toc-num {
  font-family: 'DM Mono', monospace;
  font-size: 9px;
  color: rgba(201,168,76,0.5);
  flex-shrink: 0;
}
.toc-link:hover .toc-num { color: #c9a84c; }

/* Tags */
.sb-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
}
.sb-tag {
  font-size: 9px;
  font-weight: 500;
  color: rgba(201,168,76,0.7);
  background: rgba(201,168,76,0.08);
  border: 1px solid rgba(201,168,76,0.2);
  padding: 4px 9px;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
  cursor: pointer;
  transition: background 0.2s, color 0.2s;
}
.sb-tag:hover {
  background: rgba(201,168,76,0.15);
  color: #c9a84c;
}

/* Share card */
.sb-share-btns {
  display: flex;
  flex-direction: column;
  gap: 6px;
}
.sb-share-btn {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  font-size: 11px;
  font-weight: 500;
  color: #6b7a94;
  text-decoration: none;
  padding: 8px 12px;
  background: rgba(11,28,56,0.03);
  border: 1px solid rgba(11,28,56,0.07);
  font-family: 'DM Sans', sans-serif;
  transition: color 0.2s, background 0.2s, border-color 0.2s;
}
.sb-share-btn:hover {
  color: #0b1c38;
  background: rgba(201,168,76,0.07);
  border-color: rgba(201,168,76,0.2);
}

/* Reading info */
.reading-info-card { padding: 16px 20px; }
.ri-row {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 6px 0;
  border-bottom: 1px solid rgba(11,28,56,0.05);
}
.ri-row:last-child { border-bottom: none; }
.ri-icon { color: #c9a84c; flex-shrink: 0; }
.ri-label {
  font-size: 12px;
  color: #6b7a94;
  font-family: 'DM Sans', sans-serif;
}

/* ═══════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════ */
@media (max-width: 1100px) {
  .ab-container { padding: 0 32px; }
  .ab-grid { grid-template-columns: 1fr 260px; gap: 40px; }
  .dc-stats { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 900px) {
  .ab-grid { grid-template-columns: 1fr; }
  .article-sidebar {
    position: static;
    opacity: 1; transform: none;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
  }
}
@media (max-width: 768px) {
  .ab-container { padding: 0 20px; }
  .article-body-section { padding: 56px 0 64px; }
  .lead-para { font-size: 17px; }
  .dc-stats { grid-template-columns: repeat(2, 1fr); gap: 16px; }
  .dc-num { font-size: 26px; }
  .article-sidebar { grid-template-columns: 1fr; }
  .af-row { flex-direction: column; }
}
</style>
