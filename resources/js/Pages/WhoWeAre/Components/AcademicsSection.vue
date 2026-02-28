<template>
  <section id="academics" ref="sectionEl">
    <div class="container">

      <div class="sec-label" :class="{ visible: revealed }">
        <span class="sec-label-line"/><span class="sec-label-dot"/>
        <span class="sec-label-text">Academic Associates</span>
      </div>

      <div class="acad-header" :class="{ visible: revealed }">
        <h2 class="section-headline">Scholars Who <em class="headline-em">Ground Our Work</em></h2>
        <p class="section-sub">BGC's practitioner wisdom is complemented by academic associates from India's foremost universities and law schools — ensuring our research is empirically rigorous and theoretically grounded.</p>
      </div>

      <div class="acad-grid" :class="{ visible: revealed }">
        <div v-for="(acad, i) in academics" :key="i" class="acad-card" :style="`--delay: ${i * 0.06}s`">
          <div class="acad-avatar">
            <span class="acad-initials">{{ acad.initials }}</span>
          </div>
          <div class="acad-inst">{{ acad.institution }}</div>
          <h4 class="acad-name">{{ acad.name }}</h4>
          <p class="acad-spec">{{ acad.specialisation }}</p>
          <div class="acad-bar"/>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const sectionEl = ref(null)
const revealed  = ref(false)

const academics = [
  { initials: 'PK', institution: 'Jawaharlal Nehru University', name: 'Prof. Pramod Kumar Tiwari', specialisation: 'Centre for Political Studies · Indian Federalism & Democratic Theory' },
  { initials: 'SR', institution: 'University of Delhi', name: 'Dr. Sheela Ramachandran', specialisation: 'Faculty of Law · Constitutional & Administrative Law · Access to Justice' },
  { initials: 'ZA', institution: 'Jamia Millia Islamia', name: 'Prof. Zafar Ahmed Siddiqui', specialisation: 'Dept. of Political Science · Public Administration & Local Self-Governance' },
  { initials: 'VM', institution: 'IIT Bombay', name: 'Prof. Vijay Mahadevan', specialisation: 'Dept. of Humanities & Social Sciences · Technology Policy & Digital Governance' },
  { initials: 'RN', institution: 'NALSAR · Hyderabad', name: 'Prof. Rachna Nair', specialisation: 'Constitutional Law · Socio-Legal Research · NALSAR University of Law' },
  { initials: 'AK', institution: 'NALSAR · Hyderabad', name: 'Dr. Arun Krishnaswamy', specialisation: 'Environmental Law · Forest Rights Act · Comparative Constitutional Studies' },
  { initials: 'MS', institution: 'JNU · New Delhi', name: 'Dr. Meena Subramaniam', specialisation: 'Centre for the Study of Law & Governance · Social Policy & Welfare State' },
  { initials: 'DN', institution: 'University of Delhi', name: 'Prof. Devraj Narayan', specialisation: 'Dept. of Economics · Public Finance · Fiscal Federalism & Intergovernmental Transfers' },
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
#academics {
  background: #f2f4f8;
  padding: 112px 0;
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

.acad-header {
  margin-bottom: 48px;
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.8s ease 0.15s, transform 0.8s ease 0.15s;
}
.acad-header.visible { opacity: 1; transform: translateY(0); }

.section-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2rem, 3.2vw, 3rem);
  font-weight: 600; color: #0b1c38;
  line-height: 1.12; margin-bottom: 14px;
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

/* ── Grid ────────────────────────────────────── */
.acad-grid {
  display: grid; grid-template-columns: repeat(4, 1fr);
  gap: 12px;
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.85s ease 0.28s, transform 0.85s ease 0.28s;
}
.acad-grid.visible { opacity: 1; transform: translateY(0); }

.acad-card {
  padding: 28px 24px;
  background: #fff;
  border: 1px solid #e8eaf0;
  position: relative; overflow: hidden;
  transition: border-color 0.25s, box-shadow 0.25s, transform 0.25s;
  animation-delay: var(--delay);
}
.acad-card:hover {
  border-color: rgba(201,168,76,0.4);
  box-shadow: 0 8px 28px rgba(11,28,56,0.08);
  transform: translateY(-4px);
}

.acad-avatar {
  width: 48px; height: 48px; border-radius: 50%;
  background: #e8eaf0;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 16px;
  transition: background 0.25s;
}
.acad-card:hover .acad-avatar { background: #0b1c38; }
.acad-initials {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.1rem; font-weight: 700;
  color: #0b1c38; transition: color 0.25s;
}
.acad-card:hover .acad-initials { color: #c9a84c; }

.acad-inst {
  font-size: 9px; font-weight: 700;
  letter-spacing: 0.18em; text-transform: uppercase;
  color: #c9a84c; margin-bottom: 6px;
  font-family: 'DM Mono', monospace;
}
.acad-name {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.05rem; font-weight: 600;
  color: #0b1c38; line-height: 1.2;
  margin-bottom: 6px;
}
.acad-spec {
  font-size: 12px; font-weight: 300;
  color: #8a9bbf; line-height: 1.55;
  font-family: 'DM Sans', sans-serif;
}
.acad-bar {
  position: absolute; bottom: 0; left: 0;
  width: 0; height: 3px;
  background: linear-gradient(90deg, #c9a84c, #e8cf8a);
  transition: width 0.35s ease;
}
.acad-card:hover .acad-bar { width: 100%; }

/* ── Responsive ──────────────────────────────── */
@media (max-width: 1200px) { .acad-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 1024px) { .acad-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
  #academics { padding: 80px 0; }
  .container { padding: 0 24px; }
  .acad-grid { grid-template-columns: 1fr; }
}
</style>
