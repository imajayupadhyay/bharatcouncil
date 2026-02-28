<template>
  <section id="partners" ref="sectionEl">
    <div class="container">

      <div class="sec-label" :class="{ visible: revealed }">
        <span class="sec-label-line"/><span class="sec-label-dot"/>
        <span class="sec-label-text">Collaborators &amp; Partners</span>
      </div>

      <div class="partners-header" :class="{ visible: revealed }">
        <h2 class="section-headline">
          Supported by <em class="headline-em">Purpose-Aligned</em> Institutions
        </h2>
        <p class="section-sub">BGC collaborates with institutions that share its commitment to evidence-based governance reform and civil service excellence.</p>
      </div>

      <div class="partner-tags" :class="{ visible: revealed }">
        <span v-for="(partner, i) in partners" :key="i" class="ptag" :style="`--delay: ${i * 0.04}s`">
          {{ partner }}
        </span>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const sectionEl = ref(null)
const revealed  = ref(false)

const partners = [
  'Lal Bahadur Shastri National Academy of Administration',
  'National Centre for Good Governance',
  'Climate Parliament · United Nations',
  'Institute of Rural Management, Anand',
  'NALSAR University of Law',
  'Jawaharlal Nehru University',
  'IIT Bombay · HSS',
  'University of Delhi',
  'Jamia Millia Islamia',
  'Centre for Policy Research',
  'Indian Institute of Public Administration',
  'Azim Premji University',
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
#partners {
  background: #e8eaf0;
  padding: 112px 0 120px;
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

.partners-header {
  margin-bottom: 40px;
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.8s ease 0.15s, transform 0.8s ease 0.15s;
}
.partners-header.visible { opacity: 1; transform: translateY(0); }

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
  max-width: 60ch; font-family: 'DM Sans', sans-serif;
}

/* ── Tags ────────────────────────────────────── */
.partner-tags {
  display: flex; flex-wrap: wrap; gap: 10px;
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.85s ease 0.28s, transform 0.85s ease 0.28s;
}
.partner-tags.visible { opacity: 1; transform: translateY(0); }

.ptag {
  padding: 10px 20px;
  border: 1px solid #d4d7e0;
  background: #fff;
  font-size: 13px; font-weight: 400;
  color: #8a9bbf; line-height: 1;
  font-family: 'DM Sans', sans-serif;
  transition: border-color 0.25s, color 0.25s, background 0.25s, transform 0.25s;
  cursor: default;
  animation-delay: var(--delay);
}
.ptag:hover {
  border-color: rgba(201,168,76,0.5);
  color: #c9a84c;
  background: rgba(201,168,76,0.04);
  transform: translateY(-2px);
}

/* ── Responsive ──────────────────────────────── */
@media (max-width: 768px) {
  #partners { padding: 80px 0 88px; }
  .container { padding: 0 24px; }
}
</style>
