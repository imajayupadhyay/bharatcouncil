<template>
  <section id="founding-team" ref="sectionEl">

    <!-- ══ SVG background ══ -->
    <svg class="team-svg-bg" viewBox="0 0 1440 800" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <pattern id="teamDots" width="28" height="28" patternUnits="userSpaceOnUse">
          <circle cx="1" cy="1" r="0.6" fill="rgba(255,255,255,0.03)"/>
        </pattern>
        <radialGradient id="teamGlow" cx="50%" cy="30%" r="50%">
          <stop offset="0%"   stop-color="#c9a84c" stop-opacity="0.05"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
      </defs>
      <rect width="1440" height="800" fill="url(#teamDots)"/>
      <rect width="1440" height="800" fill="url(#teamGlow)"/>
      <!-- Floating particles -->
      <circle v-for="(p, i) in particles" :key="`tp${i}`"
        :cx="p.x" :cy="p.y" :r="p.r"
        :fill="`rgba(201,168,76,${p.o})`"
        :class="`pd-${(i%4)+1}`"/>
    </svg>

    <div class="container">

      <div class="sec-label" :class="{ visible: revealed }">
        <span class="sec-label-line"/><span class="sec-label-dot"/>
        <span class="sec-label-text">Founding Team &amp; Trustees</span>
      </div>

      <div class="team-header" :class="{ visible: revealed }">
        <h2 class="section-headline">The <em class="headline-em">Architects</em> of BGC</h2>
        <p class="section-sub">Between them, BGC's founders have governed districts, commanded borders, represented India abroad, conserved its forests, and reformed its revenues. This is the council they chose to build after retiring.</p>
      </div>

      <!-- ══ Chairman Card ══ -->
      <div class="chairman-card" :class="{ visible: revealed }">
        <span class="chairman-tag">Chairman &amp; Co-Founder</span>
        <div class="ch-avatar">
          <div class="ch-initials">KV</div>
          <div class="ch-service">IAS · 1979 · UP Cadre</div>
          <!-- Orbiting rings -->
          <div class="ch-ring ch-ring-1"/>
          <div class="ch-ring ch-ring-2"/>
        </div>
        <div class="ch-content">
          <div class="ch-batch">IAS 1979 · Uttar Pradesh Cadre</div>
          <h3 class="ch-name">Dr. Kush Verma</h3>
          <p class="ch-bio">A retired IAS officer of the 1979 Batch, UP Cadre, Dr. Verma served as the <strong>first Director General of the National Centre for Good Governance (NCGG)</strong>, Government of India — the apex institution for administrative excellence and civil service capacity building. Prior to that, he was Director General of the National Institute of Administrative Research (NIAR) at <strong>Lal Bahadur Shastri National Academy of Administration, Mussoorie</strong>.</p>
          <p class="ch-bio">He holds a <strong>Doctorate from Jamia Millia Islamia</strong> on 'Redesigning India's Civil Services'. He is the author of <em>A-Z of The Civil Services</em> — a widely read account of bureaucratic India.</p>
          <div class="tag-row">
            <span v-for="tag in chairmanTags" :key="tag" class="chip">{{ tag }}</span>
          </div>
        </div>
      </div>

      <!-- ══ Members Grid ══ -->
      <div class="mem-grid" :class="{ visible: revealed }">
        <div v-for="(m, i) in members" :key="i" class="mem-card" :style="`--delay: ${i * 0.06}s`">
          <span class="role-tag">{{ m.role }}</span>
          <div class="mem-avatar">
            <span class="mem-initials">{{ m.initials }}</span>
            <div class="avatar-ring"/>
          </div>
          <div class="mem-info">
            <div class="mem-service">{{ m.service }}</div>
            <h4 class="mem-name">{{ m.name }}</h4>
            <p class="mem-desc" v-html="m.desc"></p>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const sectionEl = ref(null)
const revealed  = ref(false)

const chairmanTags = [
  'Civil Service Reform', 'Good Governance', 'Decentralisation',
  'Administrative Ethics', 'NCGG · LBSNAA', 'Author',
]

const members = [
  { initials: 'SO', name: 'Sh. Sunil Oberoi', service: 'IAS · 1984 · Co-Founder', role: 'Co-Founder',
    desc: 'Worked on <strong>Civil Services Reforms with UNDP and DoPT</strong>. Government nominee on UPSC interview boards; induction trainer for new civil service entrants. Expert in ethics and administrative values.' },
  { initials: 'SG', name: 'Sh. Somesh Goel', service: 'IPS · 1984 (Retd.) · Co-Founder', role: 'Co-Founder',
    desc: '<strong>Deputy Inspector General of Police, Himachal Pradesh (Retd.)</strong> Served in law enforcement, intelligence, and internal security. Expertise in policing reform and disaster response.' },
  { initials: 'MB', name: 'Sh. Manoj Kumar Bharti', service: 'IFS · 1988 (Retd.) · Co-Founder', role: 'Co-Founder',
    desc: 'Former <strong>Ambassador of India to Indonesia, UAE</strong> and <strong>Myanmar</strong>. Previously Special Secretary, Ministry of External Affairs. Career diplomat spanning Southeast and West Asia.' },
  { initials: 'SK', name: 'Sh. Sanjay Kumar', service: 'IFoS · 1984 · Jharkhand (Retd.)', role: 'Founding Trustee',
    desc: 'Former <strong>Director General of Forests &amp; Special Secretary</strong>, MoEFCC. Currently <strong>Chief Policy Advisor, Climate Parliament</strong> (UN-affiliated). Renewable energy and forest conservation advocate.' },
  { initials: 'AG', name: 'Sh. Anmol Goel', service: 'Social Psychologist · Educationist', role: 'Founding Trustee',
    desc: 'Educationist, Social Psychologist, and Philanthropist. Key architect of BGC\'s mentorship and outreach model. Expertise in human capital development and behavioural science.' },
  { initials: 'NJ', name: 'Sh. Nikhilesh Jha', service: 'IAS · 1984 (Retd.)', role: 'Founding Trustee',
    desc: '<strong>Director General, Himachal Pradesh</strong>. Former Director, LAWDA. Extensive experience in land administration, public welfare infrastructure, and state-level governance.' },
  { initials: 'SS', name: 'Sh. Sandeep Silas', service: 'IRTS · 1984 (Retd.)', role: 'Member',
    desc: '<strong>Indian Railway Traffic Service, 1984 batch (Retd.)</strong> Strategist and Management Expert with decades of experience in large-scale public logistics and institutional reform.' },
  { initials: 'AC', name: 'Sh. A.K. Chauhan', service: 'IRS · 1984 (Retd.)', role: 'Member',
    desc: '<strong>Principal Chief Commissioner of Income Tax, Madhya Pradesh (Retd.)</strong> Senior tax administrator with expertise in fiscal administration and revenue reform.' },
  { initials: 'RD', name: 'Smt. Riva Das', service: 'IFS · 1986 (Retd.)', role: 'Member',
    desc: 'Former <strong>High Commissioner of India to Bangladesh</strong>. Seasoned diplomat with specialisation in South Asian affairs, bilateral trade, and cultural diplomacy.' },
  { initials: 'AS', name: 'Sh. Arvind Singh', service: 'IAS · 1988 (Retd.)', role: 'Member',
    desc: 'Managing Director, <strong>Provincial Co-operative Federation, Lucknow</strong>. Specialises in cooperative governance, agricultural finance, and rural institutional reform.' },
  { initials: 'SSi', name: 'Sh. Sanjay Sinha', service: 'IPS · 1978 (Retd.)', role: 'Member',
    desc: 'Former <strong>Member, Union Public Service Commission (UPSC) Panel</strong>. One of BGC\'s most senior voices on civil services selection, police reform, and constitutional governance.' },
]

const particles = Array.from({ length: 18 }, (_, i) => ({
  x: (i * 137.5) % 1440,
  y: (i * 97.3)  % 800,
  r: 0.6 + (i % 4) * 0.5,
  o: 0.06 + (i % 5) * 0.04,
}))

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
/* ── Section ─────────────────────────────────── */
#founding-team {
  position: relative;
  background: #0b1c38;
  padding: 112px 0;
  overflow: hidden;
}
.team-svg-bg {
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

.container { position: relative; z-index: 2; max-width: 1280px; margin: 0 auto; padding: 0 60px; }

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
.team-header {
  margin-bottom: 52px;
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.8s ease 0.15s, transform 0.8s ease 0.15s;
}
.team-header.visible { opacity: 1; transform: translateY(0); }

.section-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2.2rem, 3.5vw, 3.4rem);
  font-weight: 600; color: #f5f7fa;
  line-height: 1.08; margin-bottom: 16px;
}
.headline-em {
  font-style: italic;
  background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 45%, #c9a84c 100%);
  background-size: 200% auto;
  -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  background-clip: text; animation: goldShine 4s linear infinite;
}
@keyframes goldShine { 0%{background-position:0% center} 100%{background-position:200% center} }

.section-sub {
  font-size: 14px; font-weight: 300;
  color: rgba(184,197,216,0.55); line-height: 1.8;
  max-width: 62ch; font-family: 'DM Sans', sans-serif;
}

/* ── Chairman Card ───────────────────────────── */
.chairman-card {
  display: grid; grid-template-columns: 200px 1fr;
  gap: 48px; align-items: start;
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(201,168,76,0.15);
  padding: 44px;
  margin-bottom: 40px;
  position: relative;
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.85s ease 0.3s, transform 0.85s ease 0.3s;
}
.chairman-card.visible { opacity: 1; transform: translateY(0); }

.chairman-tag {
  position: absolute; top: 20px; right: 24px;
  font-size: 9px; font-weight: 700;
  letter-spacing: 0.22em; text-transform: uppercase;
  color: rgba(201,168,76,0.65);
  font-family: 'DM Mono', monospace;
}

.ch-avatar {
  position: relative;
  width: 200px; height: 200px;
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 4px;
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  flex-shrink: 0;
}
.ch-initials {
  font-family: 'Cormorant Garamond', serif;
  font-size: 4rem; font-weight: 600;
  color: #f5f7fa; line-height: 1;
}
.ch-service {
  font-size: 9px; font-weight: 700;
  letter-spacing: 0.2em; text-transform: uppercase;
  color: #c9a84c; margin-top: 8px;
  font-family: 'DM Mono', monospace;
}
.ch-ring {
  position: absolute; border-radius: 50%;
  border: 1px solid rgba(201,168,76,0.12);
  pointer-events: none;
}
.ch-ring-1 { width: 240px; height: 240px; top: -20px; left: -20px; animation: spinCW 20s linear infinite; }
.ch-ring-2 { width: 280px; height: 280px; top: -40px; left: -40px; animation: spinCCW 28s linear infinite; border-style: dashed; border-color: rgba(201,168,76,0.06); }
@keyframes spinCW  { to { transform: rotate(360deg); } }
@keyframes spinCCW { to { transform: rotate(-360deg); } }

.ch-batch {
  font-size: 9px; font-weight: 700;
  letter-spacing: 0.18em; text-transform: uppercase;
  color: #c9a84c; margin-bottom: 10px;
  font-family: 'DM Mono', monospace;
}
.ch-name {
  font-family: 'Cormorant Garamond', serif;
  font-size: 2.2rem; font-weight: 500;
  color: #f5f7fa; line-height: 1.15;
  margin-bottom: 16px;
}
.ch-bio {
  font-size: 14px; font-weight: 300;
  color: rgba(184,197,216,0.6); line-height: 1.85;
  font-family: 'DM Sans', sans-serif;
  margin-bottom: 8px;
}
.ch-bio strong { color: rgba(245,247,250,0.85); font-weight: 500; }
.ch-bio em { color: #e8cf8a; font-style: italic; }

.tag-row { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 16px; }
.chip {
  font-size: 9px; font-weight: 500;
  letter-spacing: 0.08em; text-transform: uppercase;
  padding: 4px 12px;
  border: 1px solid rgba(255,255,255,0.14);
  color: rgba(255,255,255,0.48);
  font-family: 'DM Mono', monospace;
  transition: border-color 0.22s, color 0.22s;
}
.chip:hover { border-color: rgba(201,168,76,0.4); color: #c9a84c; }

/* ── Members Grid ────────────────────────────── */
.mem-grid {
  display: grid; grid-template-columns: repeat(3, 1fr);
  gap: 2px;
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.85s ease 0.45s, transform 0.85s ease 0.45s;
}
.mem-grid.visible { opacity: 1; transform: translateY(0); }

.mem-card {
  background: rgba(255,255,255,0.03);
  border: 1px solid rgba(255,255,255,0.06);
  padding: 28px 24px;
  display: flex; gap: 18px; align-items: flex-start;
  position: relative;
  transition: background 0.25s, border-color 0.25s;
  animation-delay: var(--delay);
}
.mem-card:hover {
  background: rgba(255,255,255,0.07);
  border-color: rgba(201,168,76,0.15);
}

.role-tag {
  position: absolute; top: 12px; right: 14px;
  font-size: 8px; font-weight: 700;
  letter-spacing: 0.18em; text-transform: uppercase;
  color: rgba(201,168,76,0.55);
  font-family: 'DM Mono', monospace;
}

.mem-avatar {
  position: relative;
  width: 58px; height: 58px; border-radius: 50%;
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.1);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.mem-initials {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.25rem; font-weight: 600;
  color: #c9a84c;
}
.avatar-ring {
  position: absolute; inset: -6px;
  border-radius: 50%;
  border: 1px solid rgba(201,168,76,0.08);
  opacity: 0;
  transition: opacity 0.3s, transform 0.3s;
}
.mem-card:hover .avatar-ring {
  opacity: 1;
  animation: spinCW 10s linear infinite;
}

.mem-info { flex: 1; min-width: 0; }
.mem-service {
  font-size: 9px; font-weight: 700;
  letter-spacing: 0.16em; text-transform: uppercase;
  color: #c9a84c; margin-bottom: 5px;
  font-family: 'DM Mono', monospace;
}
.mem-name {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.05rem; font-weight: 600;
  color: #f5f7fa; line-height: 1.2;
  margin-bottom: 8px;
}
.mem-desc {
  font-size: 12px; font-weight: 300;
  color: rgba(184,197,216,0.48); line-height: 1.65;
  font-family: 'DM Sans', sans-serif;
}
.mem-desc :deep(strong) { color: rgba(245,247,250,0.75); font-weight: 500; }

/* ── Responsive ──────────────────────────────── */
@media (max-width: 1200px) {
  .mem-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 1024px) {
  .chairman-card { grid-template-columns: 1fr; gap: 28px; }
  .ch-avatar { width: 140px; height: 140px; }
  .ch-initials { font-size: 3rem; }
  .ch-ring-1, .ch-ring-2 { display: none; }
}
@media (max-width: 768px) {
  #founding-team { padding: 80px 0; }
  .container { padding: 0 24px; }
  .mem-grid { grid-template-columns: 1fr; }
  .chairman-card { padding: 28px; }
}
</style>
