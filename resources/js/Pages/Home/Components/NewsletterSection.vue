<template>
  <section id="newsletter" ref="sectionEl">

    <!-- SVG background -->
    <svg class="nl-bg-svg" viewBox="0 0 1440 500" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <radialGradient id="nlGlow" cx="50%" cy="50%" r="50%">
          <stop offset="0%"   stop-color="#c9a84c" stop-opacity="0.08"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
        <pattern id="nlGrid" width="80" height="80" patternUnits="userSpaceOnUse">
          <path d="M 80 0 L 0 0 0 80" fill="none" stroke="rgba(255,255,255,0.025)" stroke-width="1"/>
        </pattern>
        <linearGradient id="nlTopLine" x1="0%" y1="0%" x2="100%" y2="0%">
          <stop offset="0%"   stop-color="rgba(201,168,76,0)"/>
          <stop offset="30%"  stop-color="rgba(201,168,76,0.3)"/>
          <stop offset="70%"  stop-color="rgba(201,168,76,0.3)"/>
          <stop offset="100%" stop-color="rgba(201,168,76,0)"/>
        </linearGradient>
      </defs>
      <rect width="1440" height="500" fill="url(#nlGrid)"/>
      <rect width="1440" height="500" fill="url(#nlGlow)"/>
      <rect x="0" y="0" width="1440" height="1" fill="url(#nlTopLine)"/>

      <!-- Decorative concentric rings -->
      <g transform="translate(720,250)">
        <circle r="360" fill="none" stroke="rgba(201,168,76,0.04)" stroke-width="1"/>
        <circle r="260" fill="none" stroke="rgba(201,168,76,0.05)" stroke-width="1" stroke-dasharray="3 18" class="nl-ring-1"/>
        <circle r="170" fill="none" stroke="rgba(201,168,76,0.06)" stroke-width="1"/>
        <circle r="90"  fill="none" stroke="rgba(201,168,76,0.08)" stroke-width="1" stroke-dasharray="2 10" class="nl-ring-2"/>
      </g>

      <!-- Floating particles -->
      <circle v-for="(p,i) in particles" :key="i"
        :cx="p.x" :cy="p.y" :r="p.r"
        :fill="`rgba(201,168,76,${p.o})`"
        :class="`nl-particle-${(i%4)+1}`"/>
    </svg>

    <div class="container" :class="{ visible: revealed }">

      <!-- Eyebrow -->
      <div class="nl-eyebrow">
        <span class="eyebrow-line"/>
        <span class="eyebrow-dot"/>
        <span>Weekly Intelligence</span>
        <span class="eyebrow-dot"/>
        <span class="eyebrow-line"/>
      </div>

      <!-- Heading -->
      <h2 class="nl-heading">
        Join <em>5,000+ citizens</em><br>shaping governance.
      </h2>

      <p class="nl-sub">Weekly policy digest. No noise. Unsubscribe anytime.</p>

      <!-- Form -->
      <form class="nl-form" @submit.prevent="handleSubmit">
        <div class="nl-input-wrap" :class="{ focused: inputFocused, error: showError }">
          <svg class="input-icon" viewBox="0 0 20 20" fill="none" width="16" height="16">
            <path d="M2 5l8 5 8-5M2 5h16v10H2V5Z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/>
          </svg>
          <input
            ref="inputEl"
            v-model="email"
            type="email"
            placeholder="Your email address"
            class="nl-input"
            autocomplete="email"
            @focus="inputFocused = true; showError = false"
            @blur="inputFocused = false"
          />
        </div>
        <button class="nl-btn" :class="{ loading: submitting, success: submitted }">
          <span class="btn-shimmer"/>
          <span v-if="!submitting && !submitted">Subscribe</span>
          <span v-else-if="submitting" class="btn-spinner"/>
          <span v-else class="btn-success-wrap">
            <svg viewBox="0 0 16 16" fill="none" width="14" height="14">
              <path d="M3 8l4 4 6-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Subscribed!
          </span>
        </button>
      </form>

      <Transition name="fade">
        <p v-if="showError" class="nl-error">Please enter a valid email address.</p>
      </Transition>

      <p class="nl-note">By subscribing you agree to our Privacy Policy. No spam, ever.</p>

      <!-- Social proof row -->
      <div class="nl-social-proof">
        <div class="proof-avatars">
          <div v-for="n in 5" :key="n" class="proof-avatar" :style="{ zIndex: 5 - n, left: `${(n-1) * 20}px` }">
            {{ ['PM','RK','AS','VN','BG'][n-1] }}
          </div>
        </div>
        <span class="proof-text">Joined by 5,200+ policy thinkers</span>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const sectionEl   = ref(null)
const inputEl     = ref(null)
const revealed    = ref(false)
const email       = ref('')
const inputFocused = ref(false)
const submitting  = ref(false)
const submitted   = ref(false)
const showError   = ref(false)

const particles = Array.from({ length: 20 }, (_, i) => ({
  x: 80 + (i * 173) % 1280,
  y: 40 + (i * 97)  % 420,
  r: 0.8 + (i % 3) * 0.5,
  o: 0.12 + (i % 4) * 0.06,
}))

async function handleSubmit() {
  const valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)
  if (!valid) { showError.value = true; return }
  submitting.value = true
  try {
    await window.axios.post('/newsletter/subscribe', { email: email.value, source: 'homepage' })
    submitted.value = true
    email.value = ''
  } catch {
    showError.value = true
  } finally {
    submitting.value = false
  }
}

let observer = null
onMounted(() => {
  observer = new IntersectionObserver(
    ([e]) => { if (e.isIntersecting) { revealed.value = true; observer.disconnect() } },
    { threshold: 0.15 }
  )
  if (sectionEl.value) observer.observe(sectionEl.value)
})
onUnmounted(() => observer?.disconnect())
</script>

<style scoped>
/* ── Section ─────────────────────────────── */
#newsletter {
  position: relative;
  background: #0b1c38;
  padding: 100px 60px;
  overflow: hidden;
  text-align: center;
}

.nl-bg-svg {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}

.nl-ring-1 { animation: nlSpin 35s linear infinite; transform-origin: 0 0; }
.nl-ring-2 { animation: nlSpin 22s linear infinite reverse; transform-origin: 0 0; }
@keyframes nlSpin { to { transform: rotate(360deg); } }

.nl-particle-1 { animation: drift1 14s ease-in-out infinite; }
.nl-particle-2 { animation: drift2 18s ease-in-out infinite 2s; }
.nl-particle-3 { animation: drift3 12s ease-in-out infinite 1s; }
.nl-particle-4 { animation: drift4 16s ease-in-out infinite 3s; }
@keyframes drift1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(6px,-10px)} }
@keyframes drift2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-8px,7px)} }
@keyframes drift3 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(5px,12px)} }
@keyframes drift4 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-7px,-8px)} }

/* ── Content ─────────────────────────────── */
.container {
  position: relative;
  z-index: 2;
  max-width: 640px;
  margin: 0 auto;
  opacity: 0;
  transform: translateY(24px);
  transition: opacity 0.8s ease, transform 0.8s ease;
}
.container.visible { opacity: 1; transform: translateY(0); }

/* ── Eyebrow ─────────────────────────────── */
.nl-eyebrow {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  margin-bottom: 28px;
  font-size: 10px;
  font-weight: 500;
  color: #c9a84c;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}
.eyebrow-line {
  display: block;
  width: 28px; height: 1px;
  background: linear-gradient(90deg, transparent, #c9a84c);
}
.eyebrow-line:last-child {
  background: linear-gradient(90deg, #c9a84c, transparent);
}
.eyebrow-dot {
  display: block;
  width: 3px; height: 3px;
  border-radius: 50%;
  background: #c9a84c;
  opacity: 0.6;
}

/* ── Heading ─────────────────────────────── */
.nl-heading {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(36px, 5vw, 58px);
  font-weight: 600;
  color: #fff;
  line-height: 1.1;
  margin-bottom: 18px;
}
.nl-heading em {
  font-style: italic;
  background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 50%, #c9a84c 100%);
  background-size: 200% auto;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  animation: goldShine 4s linear infinite;
}
@keyframes goldShine {
  0%   { background-position: 0% center; }
  100% { background-position: 200% center; }
}

.nl-sub {
  font-size: 16px;
  font-weight: 300;
  color: #b8c5d8;
  margin-bottom: 40px;
  line-height: 1.6;
  font-family: 'DM Sans', sans-serif;
}

/* ── Form ────────────────────────────────── */
.nl-form {
  display: flex;
  align-items: stretch;
  max-width: 520px;
  margin: 0 auto 14px;
  gap: 0;
}

.nl-input-wrap {
  flex: 1;
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 0 18px;
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(201,168,76,0.22);
  border-right: none;
  transition: border-color 0.25s, background 0.25s;
}
.nl-input-wrap.focused {
  background: rgba(255,255,255,0.09);
  border-color: rgba(201,168,76,0.55);
}
.nl-input-wrap.error { border-color: rgba(231,76,60,0.6); }

.input-icon { color: rgba(201,168,76,0.45); flex-shrink: 0; }

.nl-input {
  flex: 1;
  padding: 16px 0;
  background: transparent;
  border: none;
  outline: none;
  color: #fff;
  font-family: 'DM Sans', sans-serif;
  font-size: 14px;
  font-weight: 300;
}
.nl-input::placeholder { color: #8a9bbf; }

.nl-btn {
  position: relative;
  overflow: hidden;
  background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 50%, #c9a84c 100%);
  background-size: 200% auto;
  color: #0b1c38;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  padding: 0 32px;
  border: none;
  cursor: pointer;
  font-family: 'DM Sans', sans-serif;
  display: flex;
  align-items: center;
  gap: 8px;
  white-space: nowrap;
  min-width: 140px;
  justify-content: center;
  transition: background-position 0.5s, transform 0.2s, box-shadow 0.3s;
  box-shadow: 0 4px 18px rgba(201,168,76,0.25);
}
.nl-btn:hover {
  background-position: right center;
  transform: translateY(-1px);
  box-shadow: 0 8px 28px rgba(201,168,76,0.4);
}
.nl-btn.success {
  background: linear-gradient(135deg, #27ae60, #2ecc71);
  background-size: 200% auto;
}

.btn-shimmer {
  position: absolute;
  inset: 0;
  background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.3) 50%, transparent 60%);
  transform: translateX(-100%);
}
.nl-btn:hover .btn-shimmer {
  transform: translateX(100%);
  transition: transform 0.5s ease;
}

/* Spinner */
.btn-spinner {
  width: 16px; height: 16px;
  border: 2px solid rgba(11,28,56,0.3);
  border-top-color: #0b1c38;
  border-radius: 50%;
  animation: spin 0.7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

.btn-success-wrap {
  display: flex;
  align-items: center;
  gap: 6px;
}

/* Error */
.nl-error {
  font-size: 12px;
  color: #e74c3c;
  margin-bottom: 8px;
  font-family: 'DM Sans', sans-serif;
}
.fade-enter-active, .fade-leave-active { transition: opacity 0.3s; }
.fade-enter-from, .fade-leave-to { opacity: 0; }

.nl-note {
  font-size: 11px;
  color: rgba(138,155,191,0.35);
  margin-bottom: 36px;
  font-family: 'DM Mono', monospace;
  letter-spacing: 0.04em;
}

/* ── Social proof ─────────────────────────── */
.nl-social-proof {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 18px;
}

.proof-avatars {
  position: relative;
  height: 32px;
  width: 100px;
}
.proof-avatar {
  position: absolute;
  top: 0;
  width: 32px; height: 32px;
  border-radius: 50%;
  background: linear-gradient(135deg, #162d55, #0b1c38);
  border: 2px solid rgba(201,168,76,0.35);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'DM Mono', monospace;
  font-size: 9px;
  font-weight: 700;
  color: #c9a84c;
}

.proof-text {
  font-size: 12px;
  color: rgba(138,155,191,0.5);
  font-family: 'DM Sans', sans-serif;
}

/* ── Responsive ───────────────────────────── */
@media (max-width: 768px) {
  #newsletter { padding: 72px 20px; }
  .nl-form { flex-direction: column; }
  .nl-input-wrap { border-right: 1px solid rgba(201,168,76,0.22); border-bottom: none; padding: 0 16px; }
  .nl-btn { padding: 16px 32px; min-width: unset; }
}
</style>
