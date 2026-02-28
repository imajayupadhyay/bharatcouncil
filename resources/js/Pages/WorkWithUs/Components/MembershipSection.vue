<template>
  <div class="membership-wrap">

    <!-- ══ ABOUT MEMBERSHIP ══ -->
    <section id="membership-about" ref="aboutEl" class="section-light">
      <div class="container">

        <div class="sec-label" :class="{ visible: aboutVisible }">
          <span class="sec-label-line"/><span class="sec-label-dot"/>
          <span class="sec-label-text">BGC Membership</span>
        </div>

        <div class="intro-grid" :class="{ visible: aboutVisible }">
          <div class="intro-prose">
            <h2 class="section-headline">
              Join the Council<br>as a <em class="headline-em">Member</em>
            </h2>
            <div class="prose-body">
              <p>BGC membership is extended to individuals who bring a meaningful and distinct perspective to India's governance conversation — whether as researchers, practitioners, retired officials, legal experts, educators, or civil society leaders.</p>
              <p>Becoming a BGC member is not a transactional arrangement. Members are expected to contribute intellectually — through participation in working groups, co-authorship of research outputs, mentorship of younger staff and interns, and attendance at the Council's deliberative forums. In return, BGC offers access to its network of senior practitioners, publishing platforms, and institutional resources.</p>
              <p>Membership is by invitation or application. All applications are reviewed by the Executive Committee and require endorsement by at least one existing Board or Senior Member. We are particularly eager to hear from women, professionals from smaller cities and states, and those working at the intersection of governance and disciplines underrepresented at Indian think tanks.</p>
            </div>
          </div>

          <div class="info-card">
            <div class="info-card-header">
              <span class="info-card-icon">◇</span>
              <h4 class="info-card-title">Membership at a Glance</h4>
            </div>
            <div class="info-rows">
              <div v-for="row in membershipDetails" :key="row.label" class="info-row">
                <span class="ir-label">{{ row.label }}</span>
                <span class="ir-val">{{ row.val }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ══ MEMBERSHIP TYPES ══ -->
    <section id="membership-types" ref="typesEl" class="section-grey">
      <div class="container">

        <div class="sec-label" :class="{ visible: typesVisible }">
          <span class="sec-label-line"/><span class="sec-label-dot"/>
          <span class="sec-label-text">Types of Membership</span>
        </div>

        <div class="types-header" :class="{ visible: typesVisible }">
          <h2 class="section-headline">Three Paths to <em class="headline-em">Membership</em></h2>
        </div>

        <div class="types-grid" :class="{ visible: typesVisible }">
          <div v-for="(type, i) in memberTypes" :key="i" class="mtype-card" :style="`--delay: ${i * 0.1}s`">
            <div class="mt-num">{{ String(i + 1).padStart(2, '0') }}</div>
            <h3 class="mt-title">{{ type.title }}</h3>
            <p class="mt-body">{{ type.body }}</p>
            <span class="mt-tenure">{{ type.tenure }}</span>
            <div class="mt-fill"/>
          </div>
        </div>
      </div>
    </section>

    <!-- ══ WHAT YOU GAIN ══ -->
    <section id="membership-offer" ref="offerEl" class="section-light">
      <div class="container">

        <div class="sec-label" :class="{ visible: offerVisible }">
          <span class="sec-label-line"/><span class="sec-label-dot"/>
          <span class="sec-label-text">What BGC Offers Members</span>
        </div>

        <div class="offer-header" :class="{ visible: offerVisible }">
          <h2 class="section-headline">What You <em class="headline-em">Gain</em></h2>
        </div>

        <div class="offer-grid" :class="{ visible: offerVisible }">
          <div v-for="(item, i) in offerItems" :key="i" class="offer-item" :style="`--delay: ${i * 0.07}s`">
            <div class="offer-item-top">
              <span class="offer-num">{{ String(i + 1).padStart(2, '0') }}</span>
              <div class="offer-gold-bar"/>
            </div>
            <h4 class="offer-title">{{ item.title }}</h4>
            <p class="offer-body">{{ item.body }}</p>
          </div>
        </div>
      </div>
    </section>

  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const aboutEl = ref(null)
const typesEl = ref(null)
const offerEl = ref(null)
const aboutVisible = ref(false)
const typesVisible = ref(false)
const offerVisible = ref(false)

const membershipDetails = [
  { label: 'Types',              val: 'Research Fellow · Senior Fellow · Associate Member' },
  { label: 'Tenure',             val: '1-year, renewable; Senior Fellows 3-year' },
  { label: 'Mode',               val: 'Residential (Delhi) or non-residential' },
  { label: 'Min. Commitment',    val: '1 publication + 4 events per year' },
  { label: 'Remuneration',       val: 'Fellows: Honorarium + project support. Associates: Nominal.' },
  { label: 'Review Process',     val: 'Application → EC Review → Board Endorsement' },
  { label: 'Timeline',           val: '4–8 weeks from submission to decision' },
]

const memberTypes = [
  {
    title: 'Research Fellow',
    body: 'For researchers, academics, and policy practitioners with a defined research project. Fellows receive institutional affiliation, office access, publishing support, and direct access to BGC\'s Board for input and engagement. Expected to produce at least one substantive output per year and participate actively in BGC\'s programme calendar.',
    tenure: '1-year, renewable · Full institutional support',
  },
  {
    title: 'Senior Fellow',
    body: 'For highly experienced practitioners — typically retired officers, senior academics, or former constitutional office-holders — who wish to contribute to BGC\'s work in a sustained advisory and intellectual capacity. Senior Fellows chair working groups, co-author flagship publications, and mentor Research Fellows and interns.',
    tenure: '3-year tenure · Honorarium · Leadership role',
  },
  {
    title: 'Associate Member',
    body: 'For engaged citizens, professionals, and students who wish to be part of the BGC network without a formal research commitment. Associate Members attend BGC events, receive publications and the Council digest, and are invited to working group sessions in their area of expertise. Nominal annual fee applies.',
    tenure: 'Annual renewal · Open to all backgrounds',
  },
]

const offerItems = [
  {
    title: 'Access to Senior Practitioners',
    body: 'Every BGC member has direct access to the Council\'s founding members — retired IAS, IPS, IFS, and allied service officers with decades of governance experience. This is not a notional benefit; it is the reason BGC exists.',
  },
  {
    title: 'Publishing Platform',
    body: 'BGC publishes working papers, policy briefs, opinion pieces, and an annual governance review. Fellows are actively supported to place their work in both BGC\'s own publications and in external journals and media outlets.',
  },
  {
    title: 'Peer Network',
    body: 'BGC\'s membership spans civil servants, lawyers, academics, development practitioners, and public intellectuals. Being part of the network means access to people who matter across every dimension of India\'s governance ecosystem.',
  },
  {
    title: 'Office & Institutional Resources',
    body: 'Residential Fellows have access to BGC\'s New Delhi office, research library, and institutional databases including PRS Legislative Research, Manupatra, and select international policy databases.',
  },
  {
    title: 'Event Participation',
    body: 'BGC\'s calendar includes intimate roundtables, working group sessions, public lectures, and the Annual Civil Governance Dialogue. Members are central participants — not peripheral attendees.',
  },
  {
    title: 'Long-term Affiliation',
    body: 'BGC alumni and former members remain associated with the institution permanently. We actively support former members in their subsequent careers through references, introductions, and continued collaboration.',
  },
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
  observe(typesEl.value, v => typesVisible.value = v)
  observe(offerEl.value, v => offerVisible.value = v)
})
onUnmounted(() => observers.forEach(o => o.disconnect()))
</script>

<style scoped>
/* ── Sections ────────────────────────────────── */
.section-light { background: #f2f4f8; padding: 96px 0; }
.section-grey  { background: #e8eaf0; padding: 96px 0; }

.container { max-width: 1280px; margin: 0 auto; padding: 0 60px; }

/* ── Sec Label ───────────────────────────────── */
.sec-label {
  display: flex; align-items: center; gap: 12px;
  margin-bottom: 40px;
  opacity: 0; transform: translateY(14px);
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

/* ── Headlines ───────────────────────────────── */
.section-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2rem, 3.2vw, 3rem);
  font-weight: 600; color: #0b1c38;
  line-height: 1.12; letter-spacing: -0.01em; margin-bottom: 16px;
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
@keyframes goldShine { 0%{background-position:0% center} 100%{background-position:200% center} }

/* ── Intro Grid ──────────────────────────────── */
.intro-grid {
  display: grid; grid-template-columns: 1fr 400px; gap: 60px;
  align-items: start;
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.8s ease 0.2s, transform 0.8s ease 0.2s;
}
.intro-grid.visible { opacity: 1; transform: translateY(0); }

.intro-prose .section-headline { margin-bottom: 24px; }
.prose-body p {
  font-size: 15px; font-weight: 300; color: #8a9bbf;
  line-height: 1.85; font-family: 'DM Sans', sans-serif;
}
.prose-body p + p { margin-top: 16px; }

/* ── Info Card ───────────────────────────────── */
.info-card {
  background: #0b1c38; padding: 36px;
  border: 1px solid rgba(201,168,76,0.12);
  position: relative; overflow: hidden;
}
.info-card::before {
  content: ''; position: absolute; top: 0; left: 0;
  width: 3px; height: 100%;
  background: linear-gradient(to bottom, #c9a84c, rgba(201,168,76,0.2));
}
.info-card-header {
  display: flex; align-items: center; gap: 12px;
  margin-bottom: 28px; padding-bottom: 20px;
  border-bottom: 1px solid rgba(255,255,255,0.08);
}
.info-card-icon { font-size: 14px; color: rgba(201,168,76,0.6); }
.info-card-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.2rem; font-weight: 600; color: #f5f7fa; margin: 0;
}
.info-rows { display: flex; flex-direction: column; gap: 12px; }
.info-row { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; }
.ir-label {
  font-size: 9px; font-weight: 700;
  color: rgba(184,197,216,0.4); letter-spacing: 0.14em; text-transform: uppercase;
  font-family: 'DM Mono', monospace; flex-shrink: 0; margin-top: 2px;
}
.ir-val {
  font-size: 12px; color: rgba(245,247,250,0.75);
  font-weight: 300; text-align: right; line-height: 1.5;
  font-family: 'DM Sans', sans-serif;
}

/* ── Membership Types ────────────────────────── */
.types-header {
  margin-bottom: 44px;
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.8s ease 0.15s, transform 0.8s ease 0.15s;
}
.types-header.visible { opacity: 1; transform: translateY(0); }

.types-grid {
  display: grid; grid-template-columns: repeat(3, 1fr); gap: 2px;
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.8s ease 0.28s, transform 0.8s ease 0.28s;
}
.types-grid.visible { opacity: 1; transform: translateY(0); }

.mtype-card {
  background: #fff; padding: 36px 28px;
  position: relative; overflow: hidden;
  cursor: default; transition: box-shadow 0.28s;
}
.mtype-card:hover { box-shadow: 0 20px 50px rgba(11,28,56,0.12); z-index: 1; }

.mt-fill {
  position: absolute; inset: 0;
  background: #0b1c38;
  transform: scaleY(0); transform-origin: bottom;
  transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
  z-index: 0;
}
.mtype-card:hover .mt-fill { transform: scaleY(1); }
.mtype-card:hover .mt-num,
.mtype-card:hover .mt-title,
.mtype-card:hover .mt-body { color: rgba(245,247,250,0.85); position: relative; z-index: 1; }
.mtype-card:hover .mt-num { color: rgba(255,255,255,0.04) !important; }
.mtype-card:hover .mt-tenure {
  background: rgba(255,255,255,0.08);
  color: rgba(201,168,76,0.7);
  position: relative; z-index: 1;
}

.mt-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 4.5rem; font-weight: 700; line-height: 1;
  color: rgba(11,28,56,0.06); letter-spacing: -0.02em;
  margin-bottom: -8px; transition: color 0.3s;
}
.mt-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.3rem; font-weight: 600;
  color: #0b1c38; margin-bottom: 12px; line-height: 1.2;
  position: relative; z-index: 1; transition: color 0.3s;
}
.mt-body {
  font-size: 13px; font-weight: 300;
  color: #8a9bbf; line-height: 1.8;
  font-family: 'DM Sans', sans-serif;
  position: relative; z-index: 1; transition: color 0.3s;
}
.mt-tenure {
  display: inline-block; margin-top: 16px;
  font-size: 9px; font-weight: 700;
  letter-spacing: 0.1em; text-transform: uppercase;
  background: #e8eaf0; color: #8a9bbf;
  padding: 4px 10px;
  font-family: 'DM Mono', monospace;
  position: relative; z-index: 1;
  transition: background 0.3s, color 0.3s;
}

/* ── Offer Grid ──────────────────────────────── */
.offer-header {
  margin-bottom: 44px;
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.8s ease 0.15s, transform 0.8s ease 0.15s;
}
.offer-header.visible { opacity: 1; transform: translateY(0); }

.offer-grid {
  display: grid; grid-template-columns: repeat(2, 1fr); gap: 2px;
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.8s ease 0.28s, transform 0.8s ease 0.28s;
}
.offer-grid.visible { opacity: 1; transform: translateY(0); }

.offer-item {
  background: #fff; padding: 32px 28px;
  position: relative; overflow: hidden;
  transition: transform 0.28s, box-shadow 0.28s;
  animation-delay: var(--delay);
}
.offer-item::before {
  content: ''; position: absolute;
  left: 0; top: 0; bottom: 0; width: 3px;
  background: #e8eaf0;
  transition: background 0.28s;
}
.offer-item:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 36px rgba(11,28,56,0.09);
}
.offer-item:hover::before { background: linear-gradient(to bottom, #c9a84c, #e8cf8a); }

.offer-item-top {
  display: flex; align-items: center; gap: 12px;
  margin-bottom: 16px;
}
.offer-num {
  font-family: 'DM Mono', monospace;
  font-size: 10px; font-weight: 500;
  color: rgba(201,168,76,0.5); letter-spacing: 0.1em;
}
.offer-gold-bar {
  flex: 1; height: 1px;
  background: linear-gradient(90deg, rgba(201,168,76,0.2), transparent);
}
.offer-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.15rem; font-weight: 600;
  color: #0b1c38; margin-bottom: 10px;
}
.offer-body {
  font-size: 13px; font-weight: 300;
  color: #8a9bbf; line-height: 1.75;
  font-family: 'DM Sans', sans-serif;
}

/* ── Responsive ──────────────────────────────── */
@media (max-width: 1200px) {
  .types-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 1024px) {
  .intro-grid { grid-template-columns: 1fr; gap: 40px; }
}
@media (max-width: 768px) {
  .section-light, .section-grey { padding: 72px 0; }
  .container { padding: 0 24px; }
  .types-grid { grid-template-columns: 1fr; }
  .offer-grid { grid-template-columns: 1fr; }
}
</style>
