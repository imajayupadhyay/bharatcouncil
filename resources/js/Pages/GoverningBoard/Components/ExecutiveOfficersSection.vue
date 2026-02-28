<template>
  <section id="executive-officers" ref="sectionEl">
    <div class="container">

      <div class="sec-label" :class="{ visible: revealed }">
        <span class="sec-label-line"/><span class="sec-label-dot"/>
        <span class="sec-label-text">Executive Officers</span>
      </div>

      <div class="exec-header" :class="{ visible: revealed }">
        <h2 class="section-headline">Senior <em class="headline-em">Leadership</em></h2>
        <p class="section-sub">Two founding leaders who carry specific executive portfolios alongside their board responsibilities.</p>
      </div>

      <div class="exec-grid" :class="{ visible: revealed }">
        <div v-for="(officer, i) in officers" :key="i" class="exec-card" :style="`--delay: ${i * 0.12}s`">
          <!-- Top bar (expands on hover) -->
          <div class="exec-top-bar"/>

          <div class="exec-card-inner">
            <!-- Avatar -->
            <div class="exec-avatar">
              <span class="exec-initials">{{ officer.initials }}</span>
              <span class="exec-svc-badge">{{ officer.svcBadge }}</span>
              <!-- Orbiting dot -->
              <div class="exec-orbit-dot"/>
            </div>

            <!-- Info -->
            <div class="exec-info">
              <div class="exec-pos">{{ officer.position }}</div>
              <h3 class="exec-name">{{ officer.name }}</h3>
              <div class="exec-service">{{ officer.service }}</div>
              <p class="exec-bio" v-html="officer.bio"/>
              <div class="exec-tags">
                <span v-for="tag in officer.tags" :key="tag" class="exec-tag">{{ tag }}</span>
              </div>
            </div>
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

const officers = [
  {
    initials: 'SK', svcBadge: 'IFoS · 1984',
    position: 'Vice Chairman & Chief Advisor — Climate & Environment',
    name: 'Sh. Sanjay Kumar',
    service: 'Indian Forest Service, 1984 · Jharkhand Cadre (Retd.) · Founding Trustee',
    bio: 'Former <strong>Director General of Forests &amp; Special Secretary</strong>, Ministry of Environment, Forest &amp; Climate Change, Government of India — the highest forestry position in the country. Currently serves as <strong>Chief Policy Advisor to the Climate Parliament</strong>, a United Nations–affiliated international network of legislators working on climate and energy transition. As Vice Chairman of BGC, Sh. Kumar leads the Council\'s Climate &amp; Environmental Governance programme and represents BGC in multilateral forums.',
    tags: ['Climate Governance', 'Forest & Biodiversity Policy', 'Green Federalism', 'UN Climate Parliament', 'Vice Chairman'],
  },
  {
    initials: 'AG', svcBadge: 'Trustee',
    position: 'Trustee & Director — Outreach, Fellowships & Philanthropy',
    name: 'Sh. Anmol Goel',
    service: 'Social Psychologist · Educationist · Philanthropist · Founding Trustee',
    bio: 'Educationist, Social Psychologist, and Philanthropist, Sh. Anmol Goel is the key architect of <strong>BGC\'s mentorship and outreach model</strong> for younger civil servants. He brings deep expertise in human capital development and behavioural science as applied to governance institutions. As Director of Outreach, he oversees the design and execution of the annual onboarding programme for 100+ young officers, fundraising and philanthropic partnerships, and BGC\'s fellowship and internship schemes.',
    tags: ['Mentorship Design', 'Fellow & Intern Programme', 'Philanthropic Partnerships', 'Human Capital', 'Outreach Strategy'],
  },
]

let observer = null
onMounted(() => {
  observer = new IntersectionObserver(
    ([e]) => { if (e.isIntersecting) { revealed.value = true; observer.disconnect() } },
    { threshold: 0.08 }
  )
  if (sectionEl.value) observer.observe(sectionEl.value)
})
onUnmounted(() => observer?.disconnect())
</script>

<style scoped>
/* ── Section ─────────────────────────────────── */
#executive-officers {
  background: #f2f4f8;
  padding: 96px 0;
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
.exec-header {
  margin-bottom: 44px;
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.8s ease 0.15s, transform 0.8s ease 0.15s;
}
.exec-header.visible { opacity: 1; transform: translateY(0); }

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
  max-width: 58ch; font-family: 'DM Sans', sans-serif;
}

/* ── Grid ────────────────────────────────────── */
.exec-grid {
  display: grid; grid-template-columns: repeat(2, 1fr);
  gap: 2px;
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.85s ease 0.28s, transform 0.85s ease 0.28s;
}
.exec-grid.visible { opacity: 1; transform: translateY(0); }

/* ── Card ────────────────────────────────────── */
.exec-card {
  position: relative;
  background: #fff;
  overflow: hidden;
  transition: transform 0.28s ease, box-shadow 0.28s ease;
  animation-delay: var(--delay);
}
.exec-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 52px rgba(11,28,56,0.1);
  z-index: 1;
}

.exec-top-bar {
  height: 3px;
  background: #0b1c38;
  transition: background 0.28s;
}
.exec-card:hover .exec-top-bar {
  background: linear-gradient(90deg, #c9a84c, #e8cf8a);
}

.exec-card-inner {
  display: grid; grid-template-columns: 100px 1fr;
  gap: 28px; align-items: start;
  padding: 36px 32px;
}

/* ── Avatar ──────────────────────────────────── */
.exec-avatar {
  position: relative;
  width: 90px; height: 90px;
  border-radius: 3px;
  background: #e8eaf0;
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  flex-shrink: 0;
  transition: background 0.28s;
}
.exec-card:hover .exec-avatar { background: #0b1c38; }

.exec-initials {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.9rem; font-weight: 700;
  color: #0b1c38; line-height: 1;
  transition: color 0.28s;
}
.exec-card:hover .exec-initials { color: #c9a84c; }

.exec-svc-badge {
  font-size: 8px; font-weight: 700;
  letter-spacing: 0.14em; text-transform: uppercase;
  color: #8a9bbf; margin-top: 5px;
  font-family: 'DM Mono', monospace;
  transition: color 0.28s;
}
.exec-card:hover .exec-svc-badge { color: rgba(201,168,76,0.6); }

.exec-orbit-dot {
  position: absolute; inset: -8px; border-radius: 50%;
  border: 1px solid transparent;
  transition: border-color 0.3s;
}
.exec-card:hover .exec-orbit-dot {
  border-color: rgba(201,168,76,0.2);
  animation: spinCW 10s linear infinite;
}
@keyframes spinCW { to { transform: rotate(360deg); } }

/* ── Info ────────────────────────────────────── */
.exec-pos {
  font-size: 9px; font-weight: 700;
  letter-spacing: 0.2em; text-transform: uppercase;
  color: #c9a84c; margin-bottom: 6px;
  font-family: 'DM Mono', monospace;
}
.exec-name {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.45rem; font-weight: 600;
  color: #0b1c38; line-height: 1.2; margin-bottom: 4px;
}
.exec-service {
  font-size: 12px; color: #8a9bbf;
  letter-spacing: 0.05em; margin-bottom: 16px;
  font-family: 'DM Sans', sans-serif;
}
.exec-bio {
  font-size: 13px; font-weight: 300;
  color: #8a9bbf; line-height: 1.78;
  font-family: 'DM Sans', sans-serif;
  margin-bottom: 16px;
}
.exec-bio :deep(strong) { color: #0b1c38; font-weight: 500; }

.exec-tags {
  display: flex; flex-wrap: wrap; gap: 6px;
  padding-top: 14px; border-top: 1px solid #e8eaf0;
}
.exec-tag {
  display: inline-block;
  font-size: 9px; font-weight: 600;
  letter-spacing: 0.1em; text-transform: uppercase;
  background: #e8eaf0; color: #8a9bbf;
  padding: 4px 10px;
  font-family: 'DM Mono', monospace;
  transition: background 0.22s, color 0.22s;
}
.exec-card:hover .exec-tag {
  background: rgba(201,168,76,0.1); color: #c9a84c;
}

/* ── Responsive ──────────────────────────────── */
@media (max-width: 1024px) { .exec-grid { grid-template-columns: 1fr; } }
@media (max-width: 768px) {
  #executive-officers { padding: 72px 0; }
  .container { padding: 0 24px; }
  .exec-card-inner { grid-template-columns: 1fr; gap: 20px; }
}
</style>
