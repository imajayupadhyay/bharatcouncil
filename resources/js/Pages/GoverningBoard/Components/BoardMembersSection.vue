<template>
  <section id="board-members" ref="sectionEl">
    <div class="container">

      <div class="sec-label" :class="{ visible: revealed }">
        <span class="sec-label-line"/><span class="sec-label-dot"/>
        <span class="sec-label-text">Board Members</span>
      </div>

      <div class="board-header" :class="{ visible: revealed }">
        <h2 class="section-headline">The <em class="headline-em">Full Board</em></h2>
        <p class="section-sub">Each board member holds a specific portfolio aligned with their career expertise — bringing focused, credible leadership to every domain of BGC's work.</p>
      </div>

      <div class="board-grid" :class="{ visible: revealed }">
        <div
          v-for="(member, i) in members"
          :key="i"
          class="board-card"
          :style="`--delay: ${i * 0.06}s`"
        >
          <!-- Top ribbon (expands to gold on hover) -->
          <div class="bc-ribbon"/>

          <!-- Card top: avatar + name/pos -->
          <div class="bc-top">
            <div class="bc-avatar">
              <span class="bc-initials">{{ member.initials }}</span>
              <div class="bc-avatar-glow"/>
            </div>
            <div class="bc-id">
              <div class="bc-pos">{{ member.position }}</div>
              <h4 class="bc-name">{{ member.name }}</h4>
            </div>
          </div>

          <div class="bc-service">{{ member.service }}</div>
          <div class="bc-divider"/>
          <p class="bc-bio" v-html="member.bio"/>

          <!-- Area tag -->
          <div class="bc-area">
            <span class="bc-area-line"/>
            {{ member.area }}
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

const members = [
  {
    initials: 'SO',
    position: 'Director, Civil Services Mentorship & Training',
    name: 'Sh. Sunil Oberoi',
    service: 'IAS · 1984 Batch (Retd.)',
    bio: 'Worked on <strong>Civil Services Reforms with UNDP and DoPT</strong>. Government nominee on UPSC interview boards; induction and in-service trainer at LBSNAA, Mussoorie. Academic Head, 99Notes. As Director of Mentorship &amp; Training, he leads the design of BGC\'s structured learning curriculum for younger IAS and allied service officers.',
    area: 'Civil Service Reform & Ethics',
  },
  {
    initials: 'SG',
    position: 'Director, Security Governance & Policing Reform',
    name: 'Sh. Somesh Goel',
    service: 'IPS · 1984 Batch (Retd.)',
    bio: '<strong>Deputy Inspector General of Police, Himachal Pradesh (Retd.)</strong> Extensive experience in law enforcement, intelligence, and internal security in hill-state conditions. As Director of Security Governance, he leads BGC\'s work on policing reform, disaster response frameworks, and the security dimensions of democratic governance.',
    area: 'Security Governance & Law Enforcement',
  },
  {
    initials: 'MB',
    position: 'Director, International Engagement & Diplomacy',
    name: 'Sh. Manoj Kumar Bharti',
    service: 'IFS · 1988 Batch (Retd.)',
    bio: 'Former <strong>Ambassador of India to Indonesia, UAE</strong>, and <strong>Myanmar</strong>; previously Special Secretary, Ministry of External Affairs. As Director of International Engagement, he leads BGC\'s outreach to international governance networks, facilitates comparative governance learning from the Global South, and heads diplomatic knowledge-sharing programmes.',
    area: 'International Affairs & Diplomacy',
  },
  {
    initials: 'NJ',
    position: 'Director, Land Administration & State Governance',
    name: 'Sh. Nikhilesh Jha',
    service: 'IAS · 1984 Batch (Retd.)',
    bio: '<strong>Director General, Himachal Pradesh; Former Director, LAWDA</strong> (Land Acquisition, Welfare &amp; Development Authority). Deep expertise in land administration and rights, public welfare infrastructure, and hill-state governance. Leads BGC\'s research programme on land governance, federalism in hill states, and subnational administrative capacity.',
    area: 'Land Governance & Federalism',
  },
  {
    initials: 'SS',
    position: 'Director, Strategic Operations & Institutional Management',
    name: 'Sh. Sandeep Silas',
    service: 'IRTS · 1984 Batch (Retd.)',
    bio: '<strong>Indian Railway Traffic Service, 1984 Batch (Retd.)</strong> Strategist and Management Expert with decades of experience in large-scale public logistics and institutional reform. As Director of Strategic Operations, he oversees BGC\'s internal governance, programme management, and the operational efficiency of the Council\'s activities.',
    area: 'Operations & Institutional Management',
  },
  {
    initials: 'AC',
    position: 'Director, Public Finance & Revenue Policy',
    name: 'Sh. A.K. Chauhan',
    service: 'IRS · 1984 Batch (Retd.)',
    bio: '<strong>Principal Chief Commissioner of Income Tax, Madhya Pradesh (Retd.)</strong> Indian Revenue Service, 1984 Batch. A senior tax administrator with expertise in fiscal administration, revenue reform, and compliance architecture. Leads BGC\'s work on public finance governance, tax administration reform, and fiscal capacity of subnational governments.',
    area: 'Public Finance & Revenue Administration',
  },
  {
    initials: 'RD',
    position: 'Director, South Asia Affairs & Neighbourhood Policy',
    name: 'Smt. Riva Das',
    service: 'IFS · 1986 Batch (Retd.)',
    bio: 'Former <strong>High Commissioner of India to Bangladesh</strong>, Indian Foreign Service, 1986 Batch. Seasoned diplomat with deep specialisation in South Asian bilateral relations, sub-regional connectivity, and cultural diplomacy. Leads BGC\'s Neighbourhood Policy track, examining how India\'s foreign policy intersects with subnational governance and border-area administration.',
    area: 'South Asia & Neighbourhood Policy',
  },
  {
    initials: 'AS',
    position: 'Director, Rural Development & Cooperative Governance',
    name: 'Sh. Arvind Singh',
    service: 'IAS · 1988 Batch (Retd.)',
    bio: 'Managing Director, <strong>Provincial Co-operative Federation, Lucknow</strong>. IAS, 1988 Batch. Specialist in cooperative governance, agricultural finance, and rural institutional reform in Uttar Pradesh. Leads BGC\'s research on rural governance, cooperative law reform, and the institutional architecture of India\'s agriculture economy.',
    area: 'Rural Development & Cooperative Law',
  },
  {
    initials: 'SSi',
    position: 'Senior Advisor & Director, Civil Services Ethics & Selection',
    name: 'Sh. Sanjay Sinha',
    service: 'IPS · 1978 Batch (Retd.)',
    bio: 'Former <strong>Member, Union Public Service Commission (UPSC) Panel</strong>. IPS, 1978 Batch — BGC\'s most senior member by seniority of service. Brings unmatched authority on civil services selection standards, police reform, and constitutional governance. Leads BGC\'s work on civil services ethics, conduct standards, and the reform of selection processes.',
    area: 'Civil Services Ethics & UPSC Policy',
  },
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
/* ── Section ─────────────────────────────────── */
#board-members {
  background: #e8eaf0;
  padding: 96px 0 112px;
}
.container { max-width: 1280px; margin: 0 auto; padding: 0 60px; }

/* ── Sec Label ───────────────────────────────── */
.sec-label {
  display: flex; align-items: center; gap: 12px;
  margin-bottom: 28px;
  opacity: 0; transform: translateY(14px);
  transition: opacity 0.7s ease 0.05s, transform 0.7s ease 0.05s;
}
.sec-label.visible { opacity: 1; transform: translateY(0); }
.sec-label-line { display: block; width: 32px; height: 1px; background: linear-gradient(90deg, transparent, #c9a84c); }
.sec-label-dot { display: block; width: 4px; height: 4px; border-radius: 50%; background: #c9a84c; box-shadow: 0 0 6px rgba(201,168,76,0.7); }
.sec-label-text { font-size: 10px; font-weight: 700; color: #c9a84c; letter-spacing: 0.28em; text-transform: uppercase; font-family: 'DM Sans', sans-serif; }

/* ── Header ──────────────────────────────────── */
.board-header {
  margin-bottom: 44px;
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.8s ease 0.15s, transform 0.8s ease 0.15s;
}
.board-header.visible { opacity: 1; transform: translateY(0); }

.section-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2rem, 3.2vw, 3rem);
  font-weight: 600; color: #0b1c38;
  line-height: 1.12; margin-bottom: 12px;
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
  font-size: 15px; font-weight: 300;
  color: #8a9bbf; line-height: 1.8;
  max-width: 62ch; font-family: 'DM Sans', sans-serif;
}

/* ── Board Grid ──────────────────────────────── */
.board-grid {
  display: grid; grid-template-columns: repeat(3, 1fr);
  gap: 12px;
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.85s ease 0.28s, transform 0.85s ease 0.28s;
}
.board-grid.visible { opacity: 1; transform: translateY(0); }

/* ── Board Card ──────────────────────────────── */
.board-card {
  background: #fff;
  border: 1px solid #dfe2ea;
  position: relative;
  padding: 28px 24px 24px;
  overflow: hidden;
  cursor: default;
  transition: border-color 0.25s, transform 0.28s, box-shadow 0.28s;
  animation-delay: var(--delay);
}
.board-card:hover {
  border-color: rgba(201,168,76,0.4);
  transform: translateY(-5px);
  box-shadow: 0 12px 36px rgba(11,28,56,0.09);
}

/* Ribbon */
.bc-ribbon {
  position: absolute; top: 0; left: 0; right: 0; height: 3px;
  background: #0b1c38;
  transition: background 0.28s;
}
.board-card:hover .bc-ribbon {
  background: linear-gradient(90deg, #c9a84c, #e8cf8a);
}

/* Top row */
.bc-top {
  display: flex; gap: 14px; align-items: flex-start;
  margin-bottom: 12px;
}

.bc-avatar {
  position: relative;
  width: 56px; height: 56px; border-radius: 50%;
  background: #e8eaf0;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  transition: background 0.28s;
}
.board-card:hover .bc-avatar { background: #0b1c38; }

.bc-initials {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.2rem; font-weight: 700;
  color: #0b1c38;
  transition: color 0.28s;
}
.board-card:hover .bc-initials { color: #c9a84c; }

.bc-avatar-glow {
  position: absolute; inset: -4px; border-radius: 50%;
  border: 1px solid transparent;
  transition: border-color 0.28s;
}
.board-card:hover .bc-avatar-glow { border-color: rgba(201,168,76,0.25); }

.bc-pos {
  font-size: 8px; font-weight: 700;
  letter-spacing: 0.18em; text-transform: uppercase;
  color: #c9a84c; margin-bottom: 4px; line-height: 1.4;
  font-family: 'DM Mono', monospace;
}
.bc-name {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.08rem; font-weight: 600;
  color: #0b1c38; line-height: 1.2;
}

.bc-service {
  font-size: 11px; color: #8a9bbf;
  letter-spacing: 0.05em; margin-bottom: 12px;
  font-family: 'DM Sans', sans-serif;
}

.bc-divider { height: 1px; background: #e8eaf0; margin-bottom: 12px; }

.bc-bio {
  font-size: 12px; font-weight: 300;
  color: #8a9bbf; line-height: 1.75;
  font-family: 'DM Sans', sans-serif;
}
.bc-bio :deep(strong) { color: #0b1c38; font-weight: 500; }

/* Area */
.bc-area {
  display: flex; align-items: center; gap: 8px;
  margin-top: 14px; padding-top: 12px;
  border-top: 1px solid #e8eaf0;
  font-size: 9px; font-weight: 700;
  letter-spacing: 0.12em; text-transform: uppercase;
  color: #0b1c38; font-family: 'DM Mono', monospace;
  transition: color 0.25s;
}
.board-card:hover .bc-area { color: #c9a84c; }
.bc-area-line {
  display: block; width: 14px; height: 1px;
  background: #c9a84c; flex-shrink: 0;
}

/* ── Responsive ──────────────────────────────── */
@media (max-width: 1200px) { .board-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
  #board-members { padding: 72px 0 80px; }
  .container { padding: 0 24px; }
  .board-grid { grid-template-columns: 1fr; }
}
</style>
