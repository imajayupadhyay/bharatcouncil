<template>
  <section id="values" ref="sectionEl">
    <div class="container">

      <div class="sec-label" :class="{ visible: revealed }">
        <span class="sec-label-line"/><span class="sec-label-dot"/>
        <span class="sec-label-text">Our Values</span>
      </div>

      <div class="values-grid" :class="{ visible: revealed }">
        <!-- Left -->
        <div class="values-left">
          <h2 class="section-headline">What BGC <em class="headline-em">Stands For</em></h2>
          <p class="values-sub">BGC does not take institutional positions on political questions. Our members retain full intellectual independence. But we are not neutral about what good governance demands — and these commitments are non-negotiable.</p>
        </div>

        <!-- Right: Values list -->
        <ul class="values-list">
          <li v-for="(val, i) in values" :key="i" class="value-item" :style="`--delay: ${i * 0.08}s`">
            <div class="val-num">{{ String(i + 1).padStart(2, '0') }}</div>
            <div class="val-body">
              <h3 class="val-title">{{ val.title }}</h3>
              <p class="val-desc">{{ val.desc }}</p>
            </div>
          </li>
        </ul>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const sectionEl = ref(null)
const revealed  = ref(false)

const values = [
  {
    title: 'Service Over Career',
    desc: 'Every founding member retired from a career of public service. BGC continues that service — without tenure anxieties, political calculations, or the distortions of office.',
  },
  {
    title: 'Practitioners Who Read, Scholars Who Serve',
    desc: 'We refuse the false divide between administrative practice and academic rigour. BGC\'s work is shaped by both, and our academic associates ensure experience is tested against evidence.',
  },
  {
    title: 'Honesty About the State',
    desc: 'Our founders governed from within the state. They know its strengths and failures intimately. BGC will not romanticise or demonise — only analyse, clearly and without fear.',
  },
  {
    title: 'The Next Generation as Our Priority',
    desc: 'BGC\'s onboarding programme for younger officers is not a side activity — it is central to our mission. The 100+ officers we mentor each year are the reason this institution exists.',
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
#values {
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

/* ── Grid ────────────────────────────────────── */
.values-grid {
  display: grid; grid-template-columns: 360px 1fr;
  gap: 80px; align-items: start;
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.85s ease 0.2s, transform 0.85s ease 0.2s;
}
.values-grid.visible { opacity: 1; transform: translateY(0); }

/* ── Left ────────────────────────────────────── */
.section-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2rem, 3.2vw, 3rem);
  font-weight: 600; color: #0b1c38;
  line-height: 1.12; margin-bottom: 20px;
}
.headline-em {
  font-style: italic;
  background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 45%, #c9a84c 100%);
  background-size: 200% auto;
  -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  background-clip: text; animation: goldShine 4s linear infinite;
}
@keyframes goldShine { 0%{background-position:0% center} 100%{background-position:200% center} }

.values-sub {
  font-size: 15px; font-weight: 300;
  color: #8a9bbf; line-height: 1.85;
  font-family: 'DM Sans', sans-serif;
}

/* ── Values List ─────────────────────────────── */
.values-list { list-style: none; }

.value-item {
  display: flex; gap: 28px; align-items: flex-start;
  padding: 24px 0;
  border-bottom: 1px solid #e8eaf0;
  cursor: default;
  transition: padding-left 0.25s;
  animation-delay: var(--delay);
}
.value-item:first-child { border-top: 1px solid #e8eaf0; }
.value-item:hover { padding-left: 10px; }

.val-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 2rem; font-weight: 600;
  color: #e8eaf0; min-width: 40px;
  padding-top: 2px; line-height: 1;
  transition: color 0.25s;
}
.value-item:hover .val-num { color: #c9a84c; }

.val-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.18rem; font-weight: 600;
  color: #0b1c38; margin-bottom: 6px;
}
.val-desc {
  font-size: 13px; font-weight: 300;
  color: #8a9bbf; line-height: 1.7;
  font-family: 'DM Sans', sans-serif;
}

/* ── Responsive ──────────────────────────────── */
@media (max-width: 1024px) {
  .values-grid { grid-template-columns: 1fr; gap: 40px; }
}
@media (max-width: 768px) {
  #values { padding: 80px 0; }
  .container { padding: 0 24px; }
  .value-item { gap: 16px; }
}
</style>
