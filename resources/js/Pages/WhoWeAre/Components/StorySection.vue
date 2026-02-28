<template>
  <section id="our-story" ref="sectionEl">
    <div class="container">

      <div class="sec-label" :class="{ visible: revealed }">
        <span class="sec-label-line"/><span class="sec-label-dot"/>
        <span class="sec-label-text">Our Story</span>
      </div>

      <div class="two-col" :class="{ visible: revealed }">
        <!-- Left: Headline + Prose -->
        <div class="col-left">
          <h2 class="section-headline">
            Born from a<br><em class="headline-em">Shared Conviction</em>
          </h2>
          <div class="prose">
            <p>Bharat Governance Council was founded in 2023 by a distinguished group of retired officers spanning the Indian Administrative Service, Indian Police Service, Indian Foreign Service, Indian Forest Service, and Indian Revenue Service — officers who, combined, have served in some of the most consequential roles in the Government of India and across its states.</p>
            <p>The founders shared a conviction: that the institutional memory, policy wisdom, and administrative experience accumulated over their combined centuries of public service should not simply retire with them. India's youngest civil servants — stepping into complex roles in a world shaped by technology, climate change, and rapid social transformation — needed structured guidance from those who had lived these challenges from the inside.</p>
            <p>BGC was thus conceived not as a conventional think tank issuing reports from a distance, but as a living bridge between seasoned governance experience and emerging administrative talent. Every year, BGC onboards 100+ younger officers into this knowledge network.</p>
          </div>
        </div>

        <!-- Right: Pullquote + Onboard box -->
        <div class="col-right">
          <div class="pull-quote">
            <div class="pull-accent"/>
            <blockquote>"India has millions of rules. What it needs is men and women who understand, beyond the rules, what governance is fundamentally for."</blockquote>
            <cite>— BGC Founding Charter, 2023</cite>
          </div>

          <div class="onboard-box">
            <div class="ob-shimmer"/>
            <div class="ob-num">100<span class="ob-plus">+</span></div>
            <div class="ob-text">
              <h4>Younger Bureaucrats Onboarded Each Year</h4>
              <p>BGC's mentorship programme connects younger IAS, IPS, IFS and allied service officers with our founding members — officers who have held the same roles and faced the same dilemmas, decades earlier.</p>
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
#our-story {
  background: #f2f4f8;
  padding: 112px 0;
}
.container { max-width: 1280px; margin: 0 auto; padding: 0 60px; }

/* ── Sec Label ───────────────────────────────── */
.sec-label {
  display: flex; align-items: center; gap: 12px;
  margin-bottom: 48px;
  opacity: 0; transform: translateY(14px);
  transition: opacity 0.7s ease 0.05s, transform 0.7s ease 0.05s;
}
.sec-label.visible { opacity: 1; transform: translateY(0); }
.sec-label-line { display: block; width: 32px; height: 1px; background: linear-gradient(90deg, transparent, #c9a84c); }
.sec-label-dot { display: block; width: 4px; height: 4px; border-radius: 50%; background: #c9a84c; box-shadow: 0 0 6px rgba(201,168,76,0.7); }
.sec-label-text { font-size: 10px; font-weight: 700; color: #c9a84c; letter-spacing: 0.28em; text-transform: uppercase; font-family: 'DM Sans', sans-serif; }

/* ── Two Col ─────────────────────────────────── */
.two-col {
  display: grid; grid-template-columns: 1fr 1fr; gap: 72px;
  align-items: start;
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.85s ease 0.2s, transform 0.85s ease 0.2s;
}
.two-col.visible { opacity: 1; transform: translateY(0); }

/* ── Headlines ───────────────────────────────── */
.section-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2rem, 3.2vw, 3rem);
  font-weight: 600; color: #0b1c38;
  line-height: 1.12; letter-spacing: -0.01em;
  margin-bottom: 28px;
}
.headline-em {
  font-style: italic;
  background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 45%, #c9a84c 100%);
  background-size: 200% auto;
  -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  background-clip: text; animation: goldShine 4s linear infinite;
}
@keyframes goldShine { 0%{background-position:0% center} 100%{background-position:200% center} }

/* ── Prose ───────────────────────────────────── */
.prose p {
  font-size: 15px; font-weight: 300;
  color: #8a9bbf; line-height: 1.88;
  font-family: 'DM Sans', sans-serif;
}
.prose p + p { margin-top: 16px; }

/* ── Pullquote ───────────────────────────────── */
.pull-quote {
  position: relative;
  padding: 28px 28px 28px 32px;
  border-left: 3px solid #c9a84c;
  background: rgba(201,168,76,0.05);
  margin-bottom: 32px;
}
.pull-accent {
  position: absolute; left: 0; top: 0; bottom: 0; width: 3px;
  background: linear-gradient(to bottom, #c9a84c, #e8cf8a);
}
.pull-quote blockquote {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.45rem; font-style: italic; font-weight: 300;
  color: #0b1c38; line-height: 1.48;
  margin-bottom: 12px;
}
.pull-quote cite {
  font-size: 10px; font-style: normal;
  letter-spacing: 0.12em; text-transform: uppercase;
  color: #8a9bbf; font-family: 'DM Mono', monospace;
}

/* ── Onboard Box ─────────────────────────────── */
.onboard-box {
  position: relative;
  background: #0b1c38;
  padding: 32px;
  display: flex; gap: 24px; align-items: center;
  overflow: hidden;
  border: 1px solid rgba(201,168,76,0.12);
}
.ob-shimmer {
  position: absolute; inset: 0;
  background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.04) 50%, transparent 60%);
  transform: translateX(-100%); transition: transform 0s;
}
.onboard-box:hover .ob-shimmer {
  transform: translateX(100%); transition: transform 0.7s ease;
}
.ob-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 4rem; font-weight: 700;
  color: #c9a84c; line-height: 1; flex-shrink: 0;
}
.ob-plus { font-size: 2.2rem; }
.ob-text h4 {
  font-size: 10px; font-weight: 700;
  letter-spacing: 0.12em; text-transform: uppercase;
  color: rgba(184,197,216,0.55); margin-bottom: 8px;
  font-family: 'DM Mono', monospace;
}
.ob-text p {
  font-size: 13px; color: rgba(245,247,250,0.65);
  font-weight: 300; line-height: 1.72;
  font-family: 'DM Sans', sans-serif;
}

/* ── Responsive ──────────────────────────────── */
@media (max-width: 1024px) {
  .two-col { grid-template-columns: 1fr; gap: 48px; }
}
@media (max-width: 768px) {
  #our-story { padding: 80px 0; }
  .container { padding: 0 24px; }
  .onboard-box { flex-direction: column; align-items: flex-start; gap: 16px; }
}
</style>
