<template>
  <section id="voices" ref="sectionEl">

    <!-- SVG background -->
    <svg class="voices-bg-svg" viewBox="0 0 1440 700" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <pattern id="vDots" width="28" height="28" patternUnits="userSpaceOnUse">
          <circle cx="1" cy="1" r="0.7" fill="rgba(255,255,255,0.04)"/>
        </pattern>
        <radialGradient id="vGlow1" cx="90%" cy="10%" r="40%">
          <stop offset="0%" stop-color="#c9a84c" stop-opacity="0.07"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="vGlow2" cx="5%" cy="90%" r="35%">
          <stop offset="0%" stop-color="#162d55" stop-opacity="0.9"/>
          <stop offset="100%" stop-color="#162d55" stop-opacity="0"/>
        </radialGradient>
      </defs>
      <rect width="1440" height="700" fill="url(#vDots)"/>
      <rect width="1440" height="700" fill="url(#vGlow1)"/>
      <rect width="1440" height="700" fill="url(#vGlow2)"/>

      <!-- Decorative orbit rings top-right -->
      <g transform="translate(1340, -60)">
        <circle r="260" fill="none" stroke="rgba(201,168,76,0.05)" stroke-width="1"/>
        <circle r="180" fill="none" stroke="rgba(201,168,76,0.04)" stroke-width="1" stroke-dasharray="6 20"/>
        <circle r="100" fill="none" stroke="rgba(201,168,76,0.06)" stroke-width="1"/>
      </g>
      <!-- Bottom-left subtle rings -->
      <g transform="translate(100, 760)">
        <circle r="200" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/>
        <circle r="130" fill="none" stroke="rgba(255,255,255,0.025)" stroke-width="1"/>
      </g>
      <!-- Top separator line -->
      <line x1="0" y1="0" x2="1440" y2="0" stroke="rgba(201,168,76,0.1)" stroke-width="1"/>
    </svg>

    <div class="container">

      <!-- Header -->
      <div class="section-header" :class="{ visible: revealed }">
        <div class="section-label">
          <div class="section-tag"><span class="tag-line"/>The Community</div>
          <h2 class="section-title">Featured Voices</h2>
        </div>
        <a href="#" class="section-link">
          Meet All Members
          <svg viewBox="0 0 20 20" fill="none" width="14" height="14" class="link-arrow">
            <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
          </svg>
        </a>
      </div>

      <!-- Voices Grid -->
      <div class="voices-grid">
        <article
          v-for="(voice, i) in voices"
          :key="i"
          class="voice-card"
          :class="{ visible: revealed }"
          :style="{ transitionDelay: `${0.08 + i * 0.12}s` }"
          @mouseenter="hovered = i"
          @mouseleave="hovered = null"
        >
          <!-- Animated corner accent -->
          <div class="card-corner-tl"/>
          <div class="card-corner-br"/>

          <!-- Card glow bloom on hover -->
          <div class="card-glow-bloom" :class="{ active: hovered === i }"/>

          <!-- Avatar -->
          <div class="voice-avatar-wrap">
            <div class="avatar-ring-outer" :class="{ active: hovered === i }"/>
            <div class="avatar-ring-inner" :class="{ active: hovered === i }"/>
            <div class="voice-avatar">
              <span>{{ voice.initials }}</span>
            </div>
            <!-- Orbiting dot -->
            <div class="avatar-orbit" :class="{ active: hovered === i }">
              <span class="orbit-dot"/>
            </div>
          </div>

          <!-- Text -->
          <div class="voice-info">
            <h4>{{ voice.name }}</h4>
            <div class="voice-role">{{ voice.role }}</div>
          </div>

          <div class="voice-divider"/>

          <p class="voice-bio">{{ voice.bio }}</p>

          <!-- Tags -->
          <div class="voice-tags">
            <span v-for="tag in voice.tags" :key="tag" class="voice-tag">{{ tag }}</span>
          </div>

          <!-- Bottom read link -->
          <a href="#" class="voice-link">
            View Profile
            <svg viewBox="0 0 16 16" fill="none" width="11" height="11">
              <path d="M3 8h10M8 3l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </a>
        </article>
      </div>

      <!-- CTA -->
      <div class="voices-cta" :class="{ visible: revealed }">
        <div class="cta-line"/>
        <a href="#" class="btn-contributor">
          <span class="btn-shimmer"/>
          Join as a Contributor
          <svg viewBox="0 0 20 20" fill="none" width="14" height="14">
            <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
          </svg>
        </a>
        <div class="cta-line"/>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const sectionEl = ref(null)
const revealed  = ref(false)
const hovered   = ref(null)

const voices = [
  {
    initials: 'PM',
    name: 'Dr. Priya Menon',
    role: 'Senior Fellow, Fiscal Policy',
    bio:  'Former Deputy Secretary, Ministry of Finance. Specialises in intergovernmental fiscal transfers and Centre-State relations.',
    tags: ['Federalism', 'Public Finance'],
  },
  {
    initials: 'RK',
    name: 'Raghav Krishnan',
    role: 'Research Director, Digital Gov.',
    bio:  'Technology policy researcher and former IIT Delhi faculty studying India\'s digital public infrastructure stack.',
    tags: ['DPI', 'AI Policy'],
  },
  {
    initials: 'AS',
    name: 'Aditi Sharma',
    role: 'Council Fellow, Constitutional Law',
    bio:  'Supreme Court advocate and constitutional scholar focusing on judicial review, federalism, and rights jurisprudence.',
    tags: ['Constitution', 'Judiciary'],
  },
  {
    initials: 'VN',
    name: 'Vikram Nair',
    role: 'Associate Fellow, Foreign Policy',
    bio:  'Retired IFS officer with postings in Washington, Beijing, and Geneva. Expert in India\'s multilateral diplomacy.',
    tags: ['Diplomacy', 'Geopolitics'],
  },
]

let observer = null
onMounted(() => {
  observer = new IntersectionObserver(
    ([e]) => { if (e.isIntersecting) { revealed.value = true; observer.disconnect() } },
    { threshold: 0.1 }
  )
  if (sectionEl.value) observer.observe(sectionEl.value)
})
onUnmounted(() => observer?.disconnect())
</script>

<style scoped>
/* ── Section ────────────────────────────────── */
#voices {
  position: relative;
  background: #0f2347;
  padding: 96px 0;
  overflow: hidden;
}

.voices-bg-svg {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}

.container {
  position: relative;
  z-index: 2;
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 60px;
}

/* ── Header ─────────────────────────────────── */
.section-header {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  margin-bottom: 52px;
  opacity: 0;
  transform: translateY(18px);
  transition: opacity 0.7s ease, transform 0.7s ease;
}
.section-header.visible { opacity: 1; transform: translateY(0); }
.section-label { display: flex; flex-direction: column; gap: 10px; }

.section-tag {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 10px;
  font-weight: 500;
  color: #c9a84c;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}
.tag-line { display: block; width: 24px; height: 1px; background: #c9a84c; }

.section-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 42px;
  font-weight: 600;
  color: #fff;
  line-height: 1.1;
}

.section-link {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 11px;
  font-weight: 500;
  color: #c9a84c;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  text-decoration: none;
  font-family: 'DM Sans', sans-serif;
  transition: gap 0.25s, color 0.2s;
}
.section-link:hover { gap: 14px; color: #e8cf8a; }
.link-arrow { transition: transform 0.25s; }
.section-link:hover .link-arrow { transform: translateX(4px); }

/* ── Grid ───────────────────────────────────── */
.voices-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin-bottom: 56px;
}

/* ── Card ───────────────────────────────────── */
.voice-card {
  position: relative;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.08);
  padding: 36px 28px 28px;
  overflow: hidden;
  cursor: pointer;
  opacity: 0;
  transform: translateY(28px);
  transition:
    opacity 0.65s ease,
    transform 0.65s ease,
    background 0.35s,
    border-color 0.35s,
    box-shadow 0.35s;
}
.voice-card.visible { opacity: 1; transform: translateY(0); }
.voice-card:hover {
  background: rgba(255,255,255,0.09);
  border-color: rgba(201,168,76,0.35);
  transform: translateY(-6px);
  box-shadow: 0 20px 50px rgba(0,0,0,0.3), 0 0 0 1px rgba(201,168,76,0.1);
}

/* Corner accents — thin gold L-shapes */
.card-corner-tl,
.card-corner-br {
  position: absolute;
  width: 18px; height: 18px;
  pointer-events: none;
  transition: width 0.35s, height 0.35s, opacity 0.35s;
  opacity: 0.4;
}
.card-corner-tl {
  top: 0; left: 0;
  border-top: 1.5px solid #c9a84c;
  border-left: 1.5px solid #c9a84c;
}
.card-corner-br {
  bottom: 0; right: 0;
  border-bottom: 1.5px solid #c9a84c;
  border-right: 1.5px solid #c9a84c;
}
.voice-card:hover .card-corner-tl,
.voice-card:hover .card-corner-br {
  width: 32px; height: 32px;
  opacity: 1;
}

/* Gold radial bloom behind avatar */
.card-glow-bloom {
  position: absolute;
  top: -40px; left: 50%;
  transform: translateX(-50%);
  width: 200px; height: 200px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(201,168,76,0.12) 0%, transparent 70%);
  opacity: 0;
  transition: opacity 0.4s ease;
  pointer-events: none;
}
.card-glow-bloom.active { opacity: 1; }

/* ── Avatar ─────────────────────────────────── */
.voice-avatar-wrap {
  position: relative;
  width: 72px; height: 72px;
  margin: 0 auto 20px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.avatar-ring-outer,
.avatar-ring-inner {
  position: absolute;
  border-radius: 50%;
  transition: transform 0.6s ease, border-color 0.35s, opacity 0.35s;
}
.avatar-ring-outer {
  inset: -10px;
  border: 1px solid rgba(201,168,76,0.15);
}
.avatar-ring-inner {
  inset: -4px;
  border: 1px solid rgba(201,168,76,0.25);
}
.avatar-ring-outer.active {
  border-color: rgba(201,168,76,0.45);
  animation: spinCW 10s linear infinite;
}
.avatar-ring-inner.active {
  border-color: rgba(201,168,76,0.6);
  animation: spinCCW 7s linear infinite;
}

@keyframes spinCW  { to { transform: rotate(360deg); } }
@keyframes spinCCW { to { transform: rotate(-360deg); } }

.voice-avatar {
  position: relative;
  z-index: 2;
  width: 64px; height: 64px;
  border-radius: 50%;
  background: linear-gradient(135deg, #162d55, #0b1c38);
  border: 2px solid rgba(201,168,76,0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: border-color 0.3s, box-shadow 0.3s;
}
.voice-card:hover .voice-avatar {
  border-color: rgba(201,168,76,0.7);
  box-shadow: 0 0 20px rgba(201,168,76,0.2);
}
.voice-avatar span {
  font-family: 'Cormorant Garamond', serif;
  font-size: 22px;
  font-weight: 600;
  color: #c9a84c;
}

/* Orbiting dot */
.avatar-orbit {
  position: absolute;
  inset: -10px;
  border-radius: 50%;
  opacity: 0;
  transition: opacity 0.3s;
}
.avatar-orbit.active {
  opacity: 1;
  animation: orbitSpin 3s linear infinite;
}
@keyframes orbitSpin { to { transform: rotate(360deg); } }

.orbit-dot {
  position: absolute;
  top: 3px; left: 50%;
  transform: translateX(-50%);
  width: 5px; height: 5px;
  border-radius: 50%;
  background: #c9a84c;
  box-shadow: 0 0 6px rgba(201,168,76,0.8);
}

/* ── Text ───────────────────────────────────── */
.voice-info { text-align: center; margin-bottom: 16px; }

.voice-info h4 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 21px;
  font-weight: 600;
  color: #fff;
  margin-bottom: 5px;
  transition: color 0.2s;
}
.voice-card:hover .voice-info h4 { color: #e8cf8a; }

.voice-role {
  font-size: 11px;
  color: #c9a84c;
  letter-spacing: 0.1em;
  font-family: 'DM Sans', sans-serif;
  opacity: 0.8;
}

.voice-divider {
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(201,168,76,0.2), transparent);
  margin-bottom: 16px;
}

.voice-bio {
  font-size: 13px;
  color: #8a9bbf;
  line-height: 1.7;
  margin-bottom: 18px;
  font-family: 'DM Sans', sans-serif;
}

/* ── Tags ───────────────────────────────────── */
.voice-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
  margin-bottom: 20px;
}
.voice-tag {
  font-size: 9px;
  color: #8a9bbf;
  border: 1px solid rgba(138,155,191,0.2);
  padding: 4px 10px;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
  transition: color 0.2s, border-color 0.2s, background 0.2s;
}
.voice-card:hover .voice-tag {
  color: #c9a84c;
  border-color: rgba(201,168,76,0.35);
  background: rgba(201,168,76,0.06);
}

/* ── Profile link ───────────────────────────── */
.voice-link {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 10px;
  font-weight: 600;
  color: rgba(201,168,76,0.5);
  letter-spacing: 0.16em;
  text-transform: uppercase;
  text-decoration: none;
  font-family: 'DM Sans', sans-serif;
  transition: color 0.25s, gap 0.25s;
}
.voice-card:hover .voice-link { color: #c9a84c; gap: 10px; }

/* ── CTA ────────────────────────────────────── */
.voices-cta {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 36px;
  opacity: 0;
  transform: translateY(16px);
  transition: opacity 0.7s ease 0.5s, transform 0.7s ease 0.5s;
}
.voices-cta.visible { opacity: 1; transform: translateY(0); }

.cta-line {
  flex: 1;
  max-width: 200px;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(201,168,76,0.25));
}
.cta-line:last-child {
  background: linear-gradient(90deg, rgba(201,168,76,0.25), transparent);
}

.btn-contributor {
  position: relative;
  display: inline-flex;
  align-items: center;
  gap: 10px;
  background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 50%, #c9a84c 100%);
  background-size: 200% auto;
  color: #0b1c38;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  padding: 16px 40px;
  text-decoration: none;
  overflow: hidden;
  font-family: 'DM Sans', sans-serif;
  transition: background-position 0.5s ease, transform 0.2s, box-shadow 0.3s;
  box-shadow: 0 4px 20px rgba(201,168,76,0.25);
}
.btn-shimmer {
  position: absolute;
  inset: 0;
  background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.3) 50%, transparent 60%);
  transform: translateX(-100%);
}
.btn-contributor:hover .btn-shimmer {
  transform: translateX(100%);
  transition: transform 0.5s ease;
}
.btn-contributor:hover {
  background-position: right center;
  transform: translateY(-2px);
  box-shadow: 0 10px 32px rgba(201,168,76,0.4);
}

/* ── Responsive ─────────────────────────────── */
@media (max-width: 1024px) {
  .container { padding: 0 32px; }
  .voices-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
  .container { padding: 0 20px; }
  #voices { padding: 64px 0; }
  .section-title { font-size: 32px; }
  .voices-grid { grid-template-columns: 1fr 1fr; gap: 12px; }
}
@media (max-width: 480px) {
  .voices-grid { grid-template-columns: 1fr; }
}
</style>
