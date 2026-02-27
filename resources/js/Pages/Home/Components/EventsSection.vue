<template>
  <section id="events" ref="sectionEl">

    <!-- SVG background -->
    <svg class="events-bg-svg" viewBox="0 0 1440 700" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <pattern id="evtDots" width="32" height="32" patternUnits="userSpaceOnUse">
          <circle cx="1" cy="1" r="0.8" fill="rgba(11,28,56,0.18)"/>
        </pattern>
        <linearGradient id="evtFade" x1="0%" y1="0%" x2="0%" y2="100%">
          <stop offset="0%"   stop-color="#f2f4f8" stop-opacity="0"/>
          <stop offset="100%" stop-color="#e8eaf0" stop-opacity="0.5"/>
        </linearGradient>
      </defs>
      <rect width="1440" height="700" fill="url(#evtDots)"/>
      <rect width="1440" height="700" fill="url(#evtFade)"/>
      <!-- Decorative large circle -->
      <circle cx="1320" cy="80" r="220" fill="none" stroke="rgba(201,168,76,0.06)" stroke-width="1"/>
      <circle cx="1320" cy="80" r="160" fill="none" stroke="rgba(201,168,76,0.04)" stroke-width="1"/>
      <circle cx="120"  cy="620" r="160" fill="none" stroke="rgba(11,28,56,0.05)"  stroke-width="1"/>
    </svg>

    <div class="container">

      <!-- Header -->
      <div class="section-header" :class="{ visible: revealed }">
        <div class="section-label">
          <div class="section-tag"><span class="tag-line"/>Upcoming</div>
          <h2 class="section-title">Events &amp; Convenings</h2>
        </div>
        <a href="#" class="section-link">
          All Events
          <svg viewBox="0 0 20 20" fill="none" width="14" height="14" class="link-arrow">
            <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
          </svg>
        </a>
      </div>

      <!-- Events Grid -->
      <div class="events-grid">
        <article
          v-for="(ev, i) in events"
          :key="i"
          class="event-card"
          :class="{ visible: revealed }"
          :style="{ transitionDelay: `${0.1 + i * 0.13}s` }"
          @mouseenter="hovered = i"
          @mouseleave="hovered = null"
        >
          <!-- Glass border sweep -->
          <div class="card-border-sweep"/>

          <!-- Date column -->
          <div class="event-date-col">
            <!-- Mini SVG calendar backdrop -->
            <svg class="date-bg-svg" viewBox="0 0 72 120" aria-hidden="true">
              <circle cx="36" cy="60" r="50" fill="rgba(201,168,76,0.06)"/>
              <circle cx="36" cy="60" r="30" fill="rgba(201,168,76,0.04)"/>
            </svg>
            <span class="event-day">{{ ev.day }}</span>
            <span class="event-month">{{ ev.month }}</span>
            <span class="event-year">{{ ev.year }}</span>
          </div>

          <!-- Body -->
          <div class="event-body">
            <div class="event-top-row">
              <span class="event-type">{{ ev.type }}</span>
              <span class="event-badge" :class="ev.badgeClass">{{ ev.badge }}</span>
            </div>

            <h3>{{ ev.title }}</h3>
            <p>{{ ev.desc }}</p>

            <div class="event-footer">
              <div class="event-meta">
                <svg viewBox="0 0 16 16" fill="none" width="12" height="12" class="meta-icon">
                  <circle cx="8" cy="8" r="6.5" stroke="currentColor" stroke-width="1.2"/>
                  <path d="M8 4.5v4l2.5 1.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                </svg>
                <span class="event-time">{{ ev.time }}</span>
              </div>
              <button class="btn-register">
                Register
                <svg viewBox="0 0 16 16" fill="none" width="11" height="11">
                  <path d="M3 8h10M8 3l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
              </button>
            </div>
          </div>

          <!-- Bottom gold bar on hover -->
          <div class="card-bottom-bar" :class="{ active: hovered === i }"/>
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

const events = [
  {
    day: '14', month: 'Mar', year: '2025',
    type: 'Roundtable',
    badge: 'Invite Only', badgeClass: 'badge-gold',
    title: 'Electoral Finance Reform: Lessons from Global Democracies',
    desc:  'A closed-door dialogue with former Election Commission officials, legal scholars, and comparative politics researchers.',
    time:  '10:00 AM — 1:00 PM IST',
  },
  {
    day: '22', month: 'Mar', year: '2025',
    type: 'Webinar',
    badge: 'Free', badgeClass: 'badge-teal',
    title: 'Governing AI in the Public Sector: A Policy Framework for India',
    desc:  'Exploring how Indian ministries can deploy AI responsibly with robust accountability structures.',
    time:  '5:00 PM — 6:30 PM IST',
  },
  {
    day: '05', month: 'Apr', year: '2025',
    type: 'Annual Conference',
    badge: 'Flagship', badgeClass: 'badge-navy',
    title: 'Bharat Governance Summit 2025 — New Delhi',
    desc:  'Our flagship annual gathering bringing together 300+ policymakers, academics, and civic leaders.',
    time:  'All Day · India Habitat Centre',
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
#events {
  position: relative;
  background: #f2f4f8;
  padding: 96px 0;
  overflow: hidden;
}

.events-bg-svg {
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
.events-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

/* ── Card ───────────────────────────────────── */
.event-card {
  position: relative;
  background: #fff;
  display: flex;
  overflow: hidden;
  border: 1px solid rgba(11,28,56,0.07);
  box-shadow: 0 2px 16px rgba(11,28,56,0.06);
  cursor: pointer;
  opacity: 0;
  transform: translateY(28px);
  transition:
    opacity 0.65s ease,
    transform 0.65s ease,
    box-shadow 0.3s,
    border-color 0.3s;
}
.event-card.visible { opacity: 1; transform: translateY(0); }
.event-card:hover {
  box-shadow: 0 16px 48px rgba(11,28,56,0.13);
  border-color: rgba(201,168,76,0.3);
  transform: translateY(-5px);
}

/* Glass border sweep on hover */
.card-border-sweep {
  position: absolute;
  inset: 0;
  border: 1px solid rgba(201,168,76,0);
  transition: border-color 0.35s;
  pointer-events: none;
  z-index: 3;
}
.event-card:hover .card-border-sweep { border-color: rgba(201,168,76,0.25); }

/* Bottom gold bar that grows */
.card-bottom-bar {
  position: absolute;
  bottom: 0; left: 0;
  height: 3px;
  width: 0%;
  background: linear-gradient(90deg, #c9a84c, #e8cf8a);
  transition: width 0.45s cubic-bezier(0.4,0,0.2,1);
  z-index: 4;
}
.card-bottom-bar.active { width: 100%; }

/* ── Date column ────────────────────────────── */
.event-date-col {
  position: relative;
  background: #0b1c38;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 28px 18px;
  min-width: 80px;
  overflow: hidden;
  flex-shrink: 0;
}

.date-bg-svg {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}

.event-day {
  position: relative;
  z-index: 1;
  font-family: 'Cormorant Garamond', serif;
  font-size: 42px;
  font-weight: 700;
  color: #c9a84c;
  line-height: 1;
}
.event-month {
  position: relative;
  z-index: 1;
  font-size: 10px;
  color: #8a9bbf;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  margin-top: 5px;
  font-family: 'DM Sans', sans-serif;
}
.event-year {
  position: relative;
  z-index: 1;
  font-size: 10px;
  color: rgba(138,155,191,0.4);
  letter-spacing: 0.1em;
  margin-top: 3px;
  font-family: 'DM Mono', monospace;
}

/* ── Event body ─────────────────────────────── */
.event-body {
  padding: 24px 26px;
  flex: 1;
  display: flex;
  flex-direction: column;
}

.event-top-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 12px;
}

.event-type {
  font-size: 9px;
  font-weight: 700;
  color: #c9a84c;
  letter-spacing: 0.28em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}

/* Badges */
.event-badge {
  font-size: 9px;
  font-weight: 600;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  padding: 3px 10px;
  font-family: 'DM Mono', monospace;
}
.badge-gold  { background: rgba(201,168,76,0.12); color: #c9a84c; }
.badge-teal  { background: rgba(22,160,133,0.10); color: #16a085; }
.badge-navy  { background: rgba(11,28,56,0.08);   color: #0b1c38; }

.event-card h3 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 20px;
  font-weight: 600;
  color: #0b1c38;
  line-height: 1.3;
  margin-bottom: 10px;
  transition: color 0.2s;
}
.event-card:hover h3 { color: #0f2347; }

.event-card p {
  font-size: 13px;
  color: #6b7a94;
  line-height: 1.65;
  margin-bottom: 20px;
  flex: 1;
  font-family: 'DM Sans', sans-serif;
}

/* ── Footer ─────────────────────────────────── */
.event-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: auto;
}

.event-meta {
  display: flex;
  align-items: center;
  gap: 6px;
}
.meta-icon { color: #8a9bbf; flex-shrink: 0; }
.event-time {
  font-size: 11px;
  color: #8a9bbf;
  font-family: 'DM Mono', monospace;
}

.btn-register {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 10px;
  font-weight: 700;
  color: #0b1c38;
  background: linear-gradient(135deg, #c9a84c, #e8cf8a);
  background-size: 200% auto;
  padding: 8px 16px;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  border: none;
  cursor: pointer;
  font-family: 'DM Sans', sans-serif;
  transition: background-position 0.4s, transform 0.2s, box-shadow 0.2s;
  box-shadow: 0 2px 10px rgba(201,168,76,0.2);
}
.btn-register:hover {
  background-position: right center;
  transform: translateY(-1px);
  box-shadow: 0 6px 18px rgba(201,168,76,0.35);
}

/* ── Responsive ─────────────────────────────── */
@media (max-width: 1024px) {
  .container { padding: 0 32px; }
  .events-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 768px) {
  .container { padding: 0 20px; }
  #events { padding: 64px 0; }
  .events-grid { grid-template-columns: 1fr; }
  .section-title { font-size: 32px; }
}
</style>
