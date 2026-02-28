<template>
  <section id="chairman" ref="sectionEl">

    <!-- ══ SVG dot background ══ -->
    <svg class="ch-svg-bg" viewBox="0 0 1440 700" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <pattern id="chDots" width="28" height="28" patternUnits="userSpaceOnUse">
          <circle cx="1" cy="1" r="0.6" fill="rgba(255,255,255,0.028)"/>
        </pattern>
        <radialGradient id="chGlow" cx="35%" cy="50%" r="45%">
          <stop offset="0%" stop-color="#c9a84c" stop-opacity="0.05"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
      </defs>
      <rect width="1440" height="700" fill="url(#chDots)"/>
      <rect width="1440" height="700" fill="url(#chGlow)"/>
    </svg>

    <div class="container">

      <!-- Sec Label -->
      <div class="sec-label" :class="{ visible: revealed }">
        <span class="sec-label-line"/><span class="sec-label-dot"/>
        <span class="sec-label-text">Chairman</span>
      </div>

      <!-- Chairman grid -->
      <div class="chairman-grid" :class="{ visible: revealed }">

        <!-- Avatar block -->
        <div class="ch-avatar-block">
          <span class="ch-badge">Chairman</span>
          <div class="ch-avatar">
            <div class="ch-initials">KV</div>
            <div class="ch-svc">IAS · 1979 · UP Cadre</div>
            <!-- Corner accent -->
            <div class="ch-corner"/>
            <!-- Rotating rings -->
            <div class="ch-ring ch-ring-1"/>
            <div class="ch-ring ch-ring-2"/>
          </div>
        </div>

        <!-- Info -->
        <div class="ch-info">
          <div class="ch-pos">Chairman, Bharat Governance Council</div>
          <h2 class="ch-name">Dr. Kush Verma</h2>
          <div class="ch-service">Indian Administrative Service, 1979 Batch · Uttar Pradesh Cadre (Retd.)</div>
          <div class="ch-divider"/>

          <p class="ch-bio">Dr. Kush Verma is a retired IAS officer of the 1979 Batch, UP Cadre, and the founder-Chairman of Bharat Governance Council. He served as the <strong>first Director General of the National Centre for Good Governance (NCGG)</strong>, Government of India — the apex institution mandated to build administrative excellence and civil service capacity across India and partner nations. Prior to NCGG, he was <strong>Director General of the National Institute of Administrative Research (NIAR)</strong> at Lal Bahadur Shastri National Academy of Administration, Mussoorie.</p>

          <p class="ch-bio">Over a long and distinguished career, Dr. Verma served as Commissioner of the National Capital Region (UP side) and held senior positions in the Governments of India and Uttar Pradesh across rural development, tribal affairs, food security, and law &amp; order. He holds a <strong>Doctorate from Jamia Millia Islamia</strong> on 'Redesigning India's Civil Services', and is the author of <em>A-Z of The Civil Services</em> (Manas Publications, 2019).</p>

          <p class="ch-bio">As Chairman of BGC, Dr. Verma provides overall strategic leadership, sets the Council's research agenda, and personally oversees the flagship mentorship programme for younger civil servants.</p>

          <!-- Responsibilities -->
          <div class="ch-resp">
            <h4 class="ch-resp-title">Responsibilities as Chairman</h4>
            <ul class="resp-list">
              <li v-for="r in responsibilities" :key="r">
                <span class="resp-dash">—</span>
                <span>{{ r }}</span>
              </li>
            </ul>
          </div>

          <!-- Tags -->
          <div class="ch-tags">
            <span v-for="tag in tags" :key="tag" class="ch-tag">{{ tag }}</span>
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

const responsibilities = [
  'Overall strategic direction and governance of the Council',
  'Chair, Governing Board meetings and Executive Committee',
  'Lead convener, Annual Civil Governance Dialogue',
  'Oversee mentorship programme for younger IAS / IPS / IFS officers',
  'Institutional partnerships with LBSNAA, NCGG, and academic bodies',
  'Represent BGC in national and international governance forums',
]

const tags = [
  'Civil Service Reform', 'Good Governance', 'Decentralisation',
  'Administrative Ethics', 'NCGG · LBSNAA', 'Author & Scholar',
]

let observer = null
onMounted(() => {
  observer = new IntersectionObserver(
    ([e]) => { if (e.isIntersecting) { revealed.value = true; observer.disconnect() } },
    { threshold: 0.06 }
  )
  if (sectionEl.value) observer.observe(sectionEl.value)
})
onUnmounted(() => observer?.disconnect())
</script>

<style scoped>
/* ── Section ─────────────────────────────────── */
#chairman {
  position: relative;
  background: #0b1c38;
  padding: 96px 0 104px;
  overflow: hidden;
}
.ch-svg-bg {
  position: absolute; inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}
.container {
  position: relative; z-index: 2;
  max-width: 1280px; margin: 0 auto;
  padding: 0 60px;
}

/* ── Sec Label ───────────────────────────────── */
.sec-label {
  display: flex; align-items: center; gap: 12px;
  margin-bottom: 48px;
  opacity: 0; transform: translateY(14px);
  transition: opacity 0.7s ease 0.05s, transform 0.7s ease 0.05s;
}
.sec-label.visible { opacity: 1; transform: translateY(0); }
.sec-label-line { display: block; width: 32px; height: 1px; background: linear-gradient(90deg, transparent, rgba(201,168,76,0.7)); }
.sec-label-dot { display: block; width: 4px; height: 4px; border-radius: 50%; background: #c9a84c; box-shadow: 0 0 6px rgba(201,168,76,0.7); }
.sec-label-text { font-size: 10px; font-weight: 700; color: rgba(201,168,76,0.75); letter-spacing: 0.28em; text-transform: uppercase; font-family: 'DM Sans', sans-serif; }

/* ── Grid ────────────────────────────────────── */
.chairman-grid {
  display: grid; grid-template-columns: 260px 1fr;
  gap: 60px; align-items: start;
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.85s ease 0.18s, transform 0.85s ease 0.18s;
}
.chairman-grid.visible { opacity: 1; transform: translateY(0); }

/* ── Avatar Block ────────────────────────────── */
.ch-avatar-block { position: relative; }

.ch-badge {
  position: absolute; top: -14px; left: 0; z-index: 4;
  background: #c9a84c; color: #0b1c38;
  font-size: 9px; font-weight: 700;
  letter-spacing: 0.22em; text-transform: uppercase;
  padding: 5px 14px; font-family: 'DM Mono', monospace;
}

.ch-avatar {
  position: relative;
  width: 260px; height: 300px;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.1);
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  overflow: hidden;
  z-index: 2;
}

.ch-initials {
  font-family: 'Cormorant Garamond', serif;
  font-size: 6.5rem; font-weight: 600;
  color: #f5f7fa; line-height: 1; letter-spacing: -0.03em;
}
.ch-svc {
  font-size: 9px; font-weight: 700;
  letter-spacing: 0.2em; text-transform: uppercase;
  color: #c9a84c; margin-top: 10px;
  font-family: 'DM Mono', monospace;
}

.ch-corner {
  position: absolute; bottom: -10px; right: -10px;
  width: 80px; height: 80px;
  border: 2px solid rgba(201,168,76,0.35);
  pointer-events: none;
}

.ch-ring {
  position: absolute; border-radius: 50%;
  pointer-events: none; z-index: 1;
}
.ch-ring-1 {
  width: 300px; height: 300px; top: -20px; left: -20px;
  border: 1px solid rgba(201,168,76,0.08);
  animation: spinCW 20s linear infinite;
}
.ch-ring-2 {
  width: 340px; height: 340px; top: -40px; left: -40px;
  border: 1px dashed rgba(201,168,76,0.05);
  animation: spinCCW 28s linear infinite;
}
@keyframes spinCW  { to { transform: rotate(360deg);  } }
@keyframes spinCCW { to { transform: rotate(-360deg); } }

/* ── Info ────────────────────────────────────── */
.ch-pos {
  font-size: 10px; font-weight: 700;
  letter-spacing: 0.22em; text-transform: uppercase;
  color: #c9a84c; margin-bottom: 10px;
  font-family: 'DM Mono', monospace;
}
.ch-name {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2.2rem, 3vw, 3rem);
  font-weight: 400; color: #f5f7fa;
  line-height: 1.1; margin-bottom: 8px;
}
.ch-service {
  font-size: 13px; color: rgba(184,197,216,0.45);
  letter-spacing: 0.06em; margin-bottom: 24px;
  font-family: 'DM Sans', sans-serif;
}
.ch-divider {
  width: 48px; height: 2px;
  background: linear-gradient(90deg, #c9a84c, rgba(201,168,76,0.3));
  margin-bottom: 24px;
}
.ch-bio {
  font-size: 14px; font-weight: 300;
  color: rgba(184,197,216,0.62); line-height: 1.9;
  font-family: 'DM Sans', sans-serif;
  margin-bottom: 12px;
}
.ch-bio strong { color: rgba(245,247,250,0.88); font-weight: 500; }
.ch-bio em { color: #e8cf8a; font-style: italic; }

/* ── Responsibilities ────────────────────────── */
.ch-resp {
  margin-top: 24px; border-top: 1px solid rgba(255,255,255,0.07);
  padding-top: 24px;
}
.ch-resp-title {
  font-size: 9px; font-weight: 700;
  letter-spacing: 0.2em; text-transform: uppercase;
  color: rgba(184,197,216,0.35); margin-bottom: 16px;
  font-family: 'DM Mono', monospace;
}
.resp-list { list-style: none; display: flex; flex-direction: column; gap: 8px; }
.resp-list li {
  display: flex; gap: 12px; align-items: flex-start;
  font-size: 13px; color: rgba(184,197,216,0.55);
  font-weight: 300; line-height: 1.6;
  font-family: 'DM Sans', sans-serif;
}
.resp-dash { color: #c9a84c; flex-shrink: 0; font-size: 12px; margin-top: 1px; }

/* ── Tags ────────────────────────────────────── */
.ch-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 24px; }
.ch-tag {
  font-size: 9px; font-weight: 600;
  letter-spacing: 0.1em; text-transform: uppercase;
  padding: 5px 12px;
  border: 1px solid rgba(255,255,255,0.14);
  color: rgba(255,255,255,0.45);
  font-family: 'DM Mono', monospace;
  transition: border-color 0.22s, color 0.22s;
}
.ch-tag:hover { border-color: rgba(201,168,76,0.45); color: #c9a84c; }

/* ── Responsive ──────────────────────────────── */
@media (max-width: 1024px) {
  .chairman-grid { grid-template-columns: 1fr; gap: 40px; }
  .ch-avatar { width: 100%; height: 160px; flex-direction: row; gap: 24px; }
  .ch-initials { font-size: 4rem; }
  .ch-ring-1, .ch-ring-2, .ch-corner { display: none; }
}
@media (max-width: 768px) {
  #chairman { padding: 72px 0 80px; }
  .container { padding: 0 24px; }
}
</style>
