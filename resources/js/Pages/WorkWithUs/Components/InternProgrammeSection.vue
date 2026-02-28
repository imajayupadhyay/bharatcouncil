<template>
  <div class="intern-programme-wrap">

    <!-- ══ ABOUT THE PROGRAMME ══ -->
    <section id="intern-about" ref="aboutEl" class="section-light">
      <div class="container">

        <div class="sec-label" :class="{ visible: aboutVisible }">
          <span class="sec-label-line"/>
          <span class="sec-label-dot"/>
          <span class="sec-label-text">The Internship Programme</span>
        </div>

        <div class="intro-grid" :class="{ visible: aboutVisible }">
          <!-- Prose -->
          <div class="intro-prose">
            <h2 class="section-headline">
              Learn Governance<br>
              <em class="headline-em">From Inside It</em>
            </h2>
            <div class="prose-body">
              <p>BGC's internship programme is not a shadow programme. Interns here work alongside the Council's senior members — retired IAS, IPS, IFS and allied service officers — on live research, policy documents, and event outputs that are published and used.</p>
              <p>The programme is deliberately small. We accept only 15–20 interns per cohort, three cohorts a year, so that each intern receives real mentorship and carries genuine responsibility. You will read primary sources, draft policy notes, prepare comparative governance briefs, and — where appropriate — attend roundtables and working group sessions.</p>
              <p>BGC interns have gone on to the civil services, law schools, public policy programmes at leading universities, and careers in development finance. Many return as fellows. The BGC internship is an entry into a network that lasts a career.</p>
            </div>
          </div>

          <!-- Info card -->
          <div class="info-card">
            <div class="info-card-header">
              <span class="info-card-icon">◈</span>
              <h4 class="info-card-title">Programme at a Glance</h4>
            </div>
            <div class="info-rows">
              <div v-for="row in programmeDetails" :key="row.label" class="info-row">
                <span class="ir-label">{{ row.label }}</span>
                <span class="ir-val">{{ row.val }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ══ WHAT YOU'LL DO ══ -->
    <section id="intern-tasks" ref="tasksEl" class="section-grey">
      <div class="container">

        <div class="sec-label" :class="{ visible: tasksVisible }">
          <span class="sec-label-line"/>
          <span class="sec-label-dot"/>
          <span class="sec-label-text">What You'll Do</span>
        </div>

        <div class="tasks-header" :class="{ visible: tasksVisible }">
          <h2 class="section-headline">
            Real Work,<br>
            <em class="headline-em">Real Responsibility</em>
          </h2>
        </div>

        <div class="tasks-grid" :class="{ visible: tasksVisible }">
          <div v-for="(task, i) in tasks" :key="i" class="task-card" :style="`--delay: ${i * 0.07}s`">
            <div class="task-card-top">
              <span class="task-num">{{ String(i + 1).padStart(2, '0') }}</span>
              <span class="task-icon">{{ task.icon }}</span>
            </div>
            <h3 class="task-title">{{ task.title }}</h3>
            <p class="task-body">{{ task.body }}</p>
            <div class="task-bar"/>
          </div>
        </div>
      </div>
    </section>

    <!-- ══ RESEARCH TRACKS ══ -->
    <section id="intern-tracks" ref="tracksEl" class="section-light">
      <div class="container">

        <div class="sec-label" :class="{ visible: tracksVisible }">
          <span class="sec-label-line"/>
          <span class="sec-label-dot"/>
          <span class="sec-label-text">Research Tracks</span>
        </div>

        <div class="tracks-header" :class="{ visible: tracksVisible }">
          <h2 class="section-headline">Choose Your <em class="headline-em">Track</em></h2>
          <p class="section-sub">Interns are placed in one primary track based on their academic background and expressed interest. Cross-track work is encouraged.</p>
        </div>

        <div class="tracks-grid" :class="{ visible: tracksVisible }">
          <div v-for="(track, i) in tracks" :key="i" class="track-pill" :style="`--delay: ${i * 0.06}s`">
            <span class="track-emoji">{{ track.emoji }}</span>
            <span class="track-name">{{ track.name }}</span>
            <div class="track-fill"/>
          </div>
        </div>
      </div>
    </section>

  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const aboutEl      = ref(null)
const tasksEl      = ref(null)
const tracksEl     = ref(null)
const aboutVisible  = ref(false)
const tasksVisible  = ref(false)
const tracksVisible = ref(false)

const programmeDetails = [
  { label: 'Duration',         val: '8–12 weeks (negotiable for working students)' },
  { label: 'Mode',             val: 'In-office (New Delhi) · Hybrid considered' },
  { label: 'Cohort Size',      val: '15–20 per cohort' },
  { label: 'Cohorts per Year', val: 'Three (Jan, May, Sep)' },
  { label: 'Stipend',          val: '₹8,000–₹12,000 / month based on profile' },
  { label: 'Eligibility',      val: 'UG 2nd year and above · PG · Doctoral' },
  { label: 'Certificate',      val: 'Issued on completion · Signed by Chairman' },
  { label: 'Publication',      val: 'Strong interns invited to co-author work' },
]

const tasks = [
  {
    icon: '📄', title: 'Policy Research & Briefs',
    body: 'Research, draft and refine policy briefs and working papers on assigned governance themes. Work with primary government documents, judicial records, legislative debates, and secondary literature.',
  },
  {
    icon: '🔍', title: 'Comparative Analysis',
    body: 'Study how other states or countries have addressed similar governance problems. Prepare structured comparison notes that go into BGC\'s institutional knowledge base and published outputs.',
  },
  {
    icon: '📊', title: 'Data & Evidence Work',
    body: 'Source, clean, and interpret data from government databases, CAG reports, parliamentary standing committee reports, and NITI Aayog materials. Translate numbers into governance narratives.',
  },
  {
    icon: '🎤', title: 'Event & Dialogue Support',
    body: 'Assist in the preparation of BGC roundtables, policy dialogues, and public lectures — including pre-event briefing materials, rapporteuring, and post-event summaries.',
  },
  {
    icon: '✍️', title: 'Drafting & Editorial',
    body: 'Contribute to op-eds, commentary pieces, and BGC\'s public-facing newsletter. Interns with strong writing skills are actively encouraged to develop their voice under editorial mentorship.',
  },
  {
    icon: '🌐', title: 'Programme Research Support',
    body: 'Support long-running BGC research initiatives — including the Annual Governance Review, the State Capacity Monitor, and the Climate Federalism Programme — by contributing to data gathering and synthesis.',
  },
]

const tracks = [
  { emoji: '🏛️', name: 'State Capacity & Administrative Reform' },
  { emoji: '⚖️', name: 'Constitutional Law & Judicial Governance' },
  { emoji: '💰', name: 'Public Finance & Fiscal Federalism' },
  { emoji: '🌿', name: 'Climate & Environmental Governance' },
  { emoji: '🤝', name: 'Civil Services Ethics & Reform' },
  { emoji: '🌏', name: 'International Affairs & South Asia' },
  { emoji: '🏘️', name: 'Rural Development & Cooperative Law' },
  { emoji: '💻', name: 'Technology Policy & Digital Governance' },
]

let observers = []

function observe(el, setter) {
  const obs = new IntersectionObserver(
    ([e]) => { if (e.isIntersecting) { setter(true); obs.disconnect() } },
    { threshold: 0.08 }
  )
  if (el) obs.observe(el)
  observers.push(obs)
}

onMounted(() => {
  observe(aboutEl.value, v => aboutVisible.value = v)
  observe(tasksEl.value, v => tasksVisible.value = v)
  observe(tracksEl.value, v => tracksVisible.value = v)
})

onUnmounted(() => { observers.forEach(o => o.disconnect()) })
</script>

<style scoped>
/* ── Shared section base ─────────────────────── */
.intern-programme-wrap {}

.section-light { background: #f2f4f8; padding: 96px 0; }
.section-grey  { background: #e8eaf0; padding: 96px 0; }

.container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 60px;
}

/* ── Section Label ───────────────────────────── */
.sec-label {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 40px;
  opacity: 0;
  transform: translateY(14px);
  transition: opacity 0.7s ease 0.05s, transform 0.7s ease 0.05s;
}
.sec-label.visible { opacity: 1; transform: translateY(0); }

.sec-label-line {
  display: block; width: 32px; height: 1px;
  background: linear-gradient(90deg, transparent, #c9a84c);
}
.sec-label-dot {
  display: block; width: 4px; height: 4px; border-radius: 50%;
  background: #c9a84c; box-shadow: 0 0 6px rgba(201,168,76,0.7);
}
.sec-label-text {
  font-size: 10px; font-weight: 700;
  color: #c9a84c; letter-spacing: 0.28em; text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}

/* ── Headline ────────────────────────────────── */
.section-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2rem, 3.2vw, 3rem);
  font-weight: 600;
  color: #0b1c38;
  line-height: 1.12;
  letter-spacing: -0.01em;
  margin-bottom: 16px;
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
@keyframes goldShine {
  0%   { background-position: 0% center; }
  100% { background-position: 200% center; }
}

.section-sub {
  font-size: 15px; font-weight: 300;
  color: #8a9bbf; line-height: 1.8;
  max-width: 56ch;
  font-family: 'DM Sans', sans-serif;
}

/* ── About Grid ──────────────────────────────── */
.intro-grid {
  display: grid;
  grid-template-columns: 1fr 400px;
  gap: 60px;
  align-items: start;
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.8s ease 0.2s, transform 0.8s ease 0.2s;
}
.intro-grid.visible { opacity: 1; transform: translateY(0); }

.intro-prose .section-headline { margin-bottom: 28px; }

.prose-body p {
  font-size: 15px; font-weight: 300;
  color: #8a9bbf; line-height: 1.85;
  font-family: 'DM Sans', sans-serif;
}
.prose-body p + p { margin-top: 16px; }

/* ── Info Card ───────────────────────────────── */
.info-card {
  background: #0b1c38;
  padding: 36px;
  position: relative;
  overflow: hidden;
  border: 1px solid rgba(201,168,76,0.12);
}
.info-card::before {
  content: '';
  position: absolute; top: 0; left: 0;
  width: 3px; height: 100%;
  background: linear-gradient(to bottom, #c9a84c, rgba(201,168,76,0.2));
}

.info-card-header {
  display: flex; align-items: center; gap: 12px;
  margin-bottom: 28px; padding-bottom: 20px;
  border-bottom: 1px solid rgba(255,255,255,0.08);
}
.info-card-icon {
  font-size: 14px; color: rgba(201,168,76,0.6);
}
.info-card-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.2rem; font-weight: 600;
  color: #f5f7fa; margin: 0;
}

.info-rows { display: flex; flex-direction: column; gap: 12px; }
.info-row {
  display: flex; justify-content: space-between;
  align-items: flex-start; gap: 16px;
}
.ir-label {
  font-size: 9px; font-weight: 700;
  color: rgba(184,197,216,0.4);
  letter-spacing: 0.14em; text-transform: uppercase;
  font-family: 'DM Mono', monospace;
  flex-shrink: 0; margin-top: 2px;
}
.ir-val {
  font-size: 12px; color: rgba(245,247,250,0.75);
  font-weight: 300; text-align: right; line-height: 1.5;
  font-family: 'DM Sans', sans-serif;
}

/* ── Tasks ───────────────────────────────────── */
.tasks-header {
  margin-bottom: 44px;
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.8s ease 0.15s, transform 0.8s ease 0.15s;
}
.tasks-header.visible { opacity: 1; transform: translateY(0); }

.tasks-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2px;
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.8s ease 0.28s, transform 0.8s ease 0.28s;
}
.tasks-grid.visible { opacity: 1; transform: translateY(0); }

.task-card {
  background: #fff;
  padding: 32px 28px;
  position: relative;
  overflow: hidden;
  cursor: default;
  transition: transform 0.28s ease, box-shadow 0.28s ease;
  animation-delay: var(--delay);
}
.task-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 16px 40px rgba(11,28,56,0.1);
  z-index: 1;
}
.task-card-top {
  display: flex; align-items: center;
  justify-content: space-between;
  margin-bottom: 20px;
}
.task-num {
  font-family: 'DM Mono', monospace;
  font-size: 10px; font-weight: 500;
  color: rgba(201,168,76,0.5);
  letter-spacing: 0.1em;
}
.task-icon { font-size: 22px; }
.task-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.18rem; font-weight: 600;
  color: #0b1c38; margin-bottom: 10px; line-height: 1.2;
}
.task-body {
  font-size: 13px; font-weight: 300;
  color: #8a9bbf; line-height: 1.75;
  font-family: 'DM Sans', sans-serif;
}
.task-bar {
  position: absolute; bottom: 0; left: 0;
  width: 0; height: 3px;
  background: linear-gradient(90deg, #c9a84c, #e8cf8a);
  transition: width 0.35s ease;
}
.task-card:hover .task-bar { width: 100%; }

/* ── Tracks ──────────────────────────────────── */
.tracks-header {
  margin-bottom: 44px;
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.8s ease 0.15s, transform 0.8s ease 0.15s;
}
.tracks-header.visible { opacity: 1; transform: translateY(0); }

.tracks-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 12px;
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.8s ease 0.28s, transform 0.8s ease 0.28s;
}
.tracks-grid.visible { opacity: 1; transform: translateY(0); }

.track-pill {
  position: relative;
  padding: 24px 20px;
  background: #fff;
  border: 1px solid #e8eaf0;
  text-align: center;
  cursor: default;
  overflow: hidden;
  transition: border-color 0.25s, transform 0.25s;
  animation-delay: var(--delay);
}
.track-pill:hover {
  border-color: rgba(201,168,76,0.4);
  transform: translateY(-3px);
}
.track-fill {
  position: absolute; inset: 0;
  background: #0b1c38;
  transform: scaleY(0);
  transform-origin: bottom;
  transition: transform 0.32s cubic-bezier(0.4, 0, 0.2, 1);
  z-index: 0;
}
.track-pill:hover .track-fill { transform: scaleY(1); }
.track-pill:hover .track-emoji,
.track-pill:hover .track-name { color: #f5f7fa; position: relative; z-index: 1; }

.track-emoji {
  display: block; font-size: 24px; margin-bottom: 12px;
  position: relative; z-index: 1;
  transition: color 0.25s;
}
.track-name {
  display: block;
  font-family: 'Cormorant Garamond', serif;
  font-size: 0.95rem; font-weight: 600;
  color: #0b1c38; line-height: 1.3;
  position: relative; z-index: 1;
  transition: color 0.25s;
}

/* ── Responsive ──────────────────────────────── */
@media (max-width: 1200px) {
  .tasks-grid  { grid-template-columns: repeat(2, 1fr); }
  .tracks-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 1024px) {
  .intro-grid  { grid-template-columns: 1fr; gap: 40px; }
  .tracks-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
  .section-light, .section-grey { padding: 72px 0; }
  .container { padding: 0 24px; }
  .tasks-grid  { grid-template-columns: 1fr; }
  .tracks-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 480px) {
  .tracks-grid { grid-template-columns: 1fr; }
  .intro-grid  { gap: 28px; }
}
</style>
