<template>
  <div class="admin-login-root">

    <!-- Animated background -->
    <svg class="login-bg" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <pattern id="al-grid" width="80" height="80" patternUnits="userSpaceOnUse">
          <path d="M 80 0 L 0 0 0 80" fill="none" stroke="rgba(255,255,255,0.022)" stroke-width="1"/>
        </pattern>
        <radialGradient id="al-glow1" cx="70%" cy="20%" r="50%">
          <stop offset="0%" stop-color="#c9a84c" stop-opacity="0.09"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="al-glow2" cx="15%" cy="80%" r="45%">
          <stop offset="0%" stop-color="#162d55" stop-opacity="0.9"/>
          <stop offset="100%" stop-color="#162d55" stop-opacity="0"/>
        </radialGradient>
      </defs>
      <rect width="1440" height="900" fill="url(#al-grid)"/>
      <rect width="1440" height="900" fill="url(#al-glow1)"/>
      <rect width="1440" height="900" fill="url(#al-glow2)"/>
      <!-- Concentric rings -->
      <g transform="translate(1150, 450)">
        <circle r="320" fill="none" stroke="rgba(201,168,76,0.05)" stroke-width="1"/>
        <circle r="320" fill="none" stroke="rgba(201,168,76,0.08)" stroke-width="0.5" stroke-dasharray="4 28" class="ring-slow"/>
        <circle r="220" fill="none" stroke="rgba(201,168,76,0.06)" stroke-width="1"/>
        <circle r="220" fill="none" stroke="rgba(201,168,76,0.12)" stroke-width="0.5" stroke-dasharray="3 18" class="ring-mid"/>
        <circle r="120" fill="none" stroke="rgba(201,168,76,0.07)" stroke-width="1"/>
      </g>
      <!-- Left diagonal lines -->
      <line x1="-20" y1="200"  x2="200"  y2="-20"  stroke="rgba(201,168,76,0.05)" stroke-width="1"/>
      <line x1="-20" y1="400"  x2="400"  y2="-20"  stroke="rgba(201,168,76,0.03)" stroke-width="1"/>
    </svg>

    <!-- Login card -->
    <div class="login-card" :class="{ visible: mounted }">

      <!-- Top gold bar -->
      <div class="card-top-bar"/>

      <!-- Logo -->
      <div class="login-logo">
        <img :src="'/BGC.png'" alt="BGC" class="login-logo-img" />
      </div>

      <!-- Heading -->
      <div class="login-heading">
        <div class="login-eyebrow">
          <span class="eyebrow-dot"/>
          <span>Admin Portal</span>
        </div>
        <h1>Secure Access</h1>
        <p>Sign in to the Bharat Governance Council admin panel.</p>
      </div>

      <!-- Error banner -->
      <div v-if="form.errors.email" class="error-banner">
        <svg viewBox="0 0 16 16" fill="none" width="13" height="13" class="error-icon">
          <circle cx="8" cy="8" r="6.5" stroke="currentColor" stroke-width="1.3"/>
          <path d="M8 5v3.5M8 11v.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
        </svg>
        {{ form.errors.email }}
      </div>

      <!-- Form -->
      <form class="login-form" @submit.prevent="submit">

        <!-- Email -->
        <div class="field-group">
          <label for="email" class="field-label">Email Address</label>
          <div class="field-wrap" :class="{ 'field-error': form.errors.email, 'field-focus': focusedField === 'email' }">
            <svg viewBox="0 0 16 16" fill="none" width="14" height="14" class="field-icon">
              <rect x="1.5" y="3.5" width="13" height="9" rx="1" stroke="currentColor" stroke-width="1.2"/>
              <path d="M1.5 5.5l6.5 4 6.5-4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
            </svg>
            <input
              id="email"
              v-model="form.email"
              type="email"
              placeholder="admin@example.com"
              class="field-input"
              autocomplete="email"
              @focus="focusedField = 'email'"
              @blur="focusedField = null"
            />
          </div>
        </div>

        <!-- Password -->
        <div class="field-group">
          <label for="password" class="field-label">Password</label>
          <div class="field-wrap" :class="{ 'field-focus': focusedField === 'password' }">
            <svg viewBox="0 0 16 16" fill="none" width="14" height="14" class="field-icon">
              <rect x="3" y="7" width="10" height="7" rx="1" stroke="currentColor" stroke-width="1.2"/>
              <path d="M5 7V5a3 3 0 016 0v2" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
              <circle cx="8" cy="10.5" r="1" fill="currentColor"/>
            </svg>
            <input
              id="password"
              v-model="form.password"
              :type="showPassword ? 'text' : 'password'"
              placeholder="Enter your password"
              class="field-input"
              autocomplete="current-password"
              @focus="focusedField = 'password'"
              @blur="focusedField = null"
            />
            <button type="button" class="toggle-pw" @click="showPassword = !showPassword" tabindex="-1">
              <svg v-if="!showPassword" viewBox="0 0 16 16" fill="none" width="13" height="13">
                <path d="M1 8s2.5-5 7-5 7 5 7 5-2.5 5-7 5-7-5-7-5z" stroke="currentColor" stroke-width="1.2"/>
                <circle cx="8" cy="8" r="2" stroke="currentColor" stroke-width="1.2"/>
              </svg>
              <svg v-else viewBox="0 0 16 16" fill="none" width="13" height="13">
                <path d="M2 2l12 12M6.5 6.6A2 2 0 0010 10M1 8s2-4 7-4c1.2 0 2.3.3 3.2.8M15 8s-.8 1.7-2.5 3" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
              </svg>
            </button>
          </div>
        </div>

        <!-- Remember me -->
        <div class="remember-row">
          <label class="remember-label">
            <input v-model="form.remember" type="checkbox" class="remember-checkbox" />
            <span class="remember-box">
              <svg v-if="form.remember" viewBox="0 0 10 10" fill="none" width="10" height="10">
                <path d="M1.5 5l3 3L9 2" stroke="#0b1c38" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
            <span>Keep me signed in</span>
          </label>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-login" :class="{ loading: form.processing }" :disabled="form.processing">
          <span class="btn-shimmer"/>
          <svg v-if="form.processing" class="spinner" viewBox="0 0 20 20" fill="none" width="16" height="16">
            <circle cx="10" cy="10" r="7" stroke="currentColor" stroke-width="2" stroke-dasharray="32" stroke-dashoffset="12"/>
          </svg>
          <span>{{ form.processing ? 'Signing in…' : 'Sign In' }}</span>
          <svg v-if="!form.processing" viewBox="0 0 16 16" fill="none" width="13" height="13">
            <path d="M3 8h10M8 3l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
          </svg>
        </button>

      </form>

      <!-- Footer note -->
      <p class="login-note">
        Restricted access · Bharat Governance Council
      </p>

    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useForm } from '@inertiajs/vue3'

const mounted      = ref(false)
const showPassword = ref(false)
const focusedField = ref(null)

const form = useForm({
  email:    '',
  password: '',
  remember: false,
})

function submit() {
  form.post('/admin/bgc-secure-login', {
    onFinish: () => form.reset('password'),
  })
}

onMounted(() => {
  requestAnimationFrame(() => setTimeout(() => { mounted.value = true }, 60))
})
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap');
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'DM Sans', sans-serif; }
</style>

<style scoped>
/* ── Root ─────────────────────────────────── */
.admin-login-root {
  min-height: 100vh;
  background: #0b1c38;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 40px 20px;
  position: relative;
  overflow: hidden;
}

.login-bg {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}

.ring-slow { animation: spinCW  44s linear infinite; transform-origin: 0 0; }
.ring-mid  { animation: spinCCW 30s linear infinite; transform-origin: 0 0; }
@keyframes spinCW  { to { transform: rotate(360deg);  } }
@keyframes spinCCW { to { transform: rotate(-360deg); } }

/* ── Card ─────────────────────────────────── */
.login-card {
  position: relative;
  z-index: 2;
  width: 100%;
  max-width: 440px;
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(201,168,76,0.2);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  padding: 44px 40px 36px;
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.7s ease, transform 0.7s ease;
}
.login-card.visible { opacity: 1; transform: translateY(0); }

/* Gold top bar */
.card-top-bar {
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, #c9a84c, #e8cf8a, rgba(201,168,76,0.2));
}

/* ── Logo ─────────────────────────────────── */
.login-logo {
  display: flex;
  justify-content: center;
  margin-bottom: 28px;
}
.login-logo-img {
  width: 100px;
  height: auto;
  object-fit: contain;
}

/* ── Heading ──────────────────────────────── */
.login-heading {
  text-align: center;
  margin-bottom: 28px;
}
.login-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 9px;
  font-weight: 600;
  color: #c9a84c;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
  margin-bottom: 10px;
}
.eyebrow-dot {
  width: 5px; height: 5px;
  border-radius: 50%;
  background: #c9a84c;
  box-shadow: 0 0 6px rgba(201,168,76,0.8);
  animation: dotPulse 2s ease-in-out infinite;
}
@keyframes dotPulse {
  0%,100% { box-shadow: 0 0 6px rgba(201,168,76,0.8); }
  50%     { box-shadow: 0 0 14px rgba(201,168,76,1); }
}
.login-heading h1 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 34px;
  font-weight: 600;
  color: #fff;
  line-height: 1.1;
  margin-bottom: 8px;
}
.login-heading p {
  font-size: 13px;
  color: #8a9bbf;
  font-family: 'DM Sans', sans-serif;
}

/* ── Error banner ─────────────────────────── */
.error-banner {
  display: flex;
  align-items: center;
  gap: 8px;
  background: rgba(231,76,60,0.12);
  border: 1px solid rgba(231,76,60,0.3);
  color: #e74c3c;
  font-size: 12px;
  font-family: 'DM Sans', sans-serif;
  padding: 10px 14px;
  margin-bottom: 20px;
}
.error-icon { flex-shrink: 0; }

/* ── Form ─────────────────────────────────── */
.login-form {
  display: flex;
  flex-direction: column;
  gap: 18px;
}

.field-group { display: flex; flex-direction: column; gap: 7px; }

.field-label {
  font-size: 10px;
  font-weight: 600;
  color: #8a9bbf;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}

.field-wrap {
  display: flex;
  align-items: center;
  gap: 0;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(201,168,76,0.18);
  transition: border-color 0.2s, background 0.2s;
}
.field-wrap.field-focus {
  border-color: rgba(201,168,76,0.55);
  background: rgba(255,255,255,0.08);
}
.field-wrap.field-error {
  border-color: rgba(231,76,60,0.5);
}

.field-icon {
  color: rgba(201,168,76,0.4);
  margin: 0 12px;
  flex-shrink: 0;
  transition: color 0.2s;
}
.field-wrap.field-focus .field-icon { color: #c9a84c; }

.field-input {
  flex: 1;
  padding: 12px 12px 12px 0;
  background: transparent;
  border: none;
  outline: none;
  font-size: 14px;
  color: #fff;
  font-family: 'DM Sans', sans-serif;
}
.field-input::placeholder { color: rgba(138,155,191,0.4); }

.toggle-pw {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 38px; height: 38px;
  background: none;
  border: none;
  color: rgba(138,155,191,0.4);
  cursor: pointer;
  flex-shrink: 0;
  transition: color 0.2s;
}
.toggle-pw:hover { color: #c9a84c; }

/* Remember me */
.remember-row { margin-top: -4px; }
.remember-label {
  display: inline-flex;
  align-items: center;
  gap: 9px;
  cursor: pointer;
  font-size: 12px;
  color: #8a9bbf;
  font-family: 'DM Sans', sans-serif;
  user-select: none;
}
.remember-checkbox { display: none; }
.remember-box {
  width: 16px; height: 16px;
  border: 1px solid rgba(201,168,76,0.3);
  background: rgba(255,255,255,0.04);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  transition: background 0.2s, border-color 0.2s;
}
.remember-checkbox:checked + .remember-box {
  background: #c9a84c;
  border-color: #c9a84c;
}

/* Submit button */
.btn-login {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 9px;
  background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 50%, #c9a84c 100%);
  background-size: 200% auto;
  color: #0b1c38;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  padding: 15px;
  border: none;
  cursor: pointer;
  overflow: hidden;
  font-family: 'DM Sans', sans-serif;
  transition: background-position 0.5s, transform 0.2s, box-shadow 0.3s, opacity 0.2s;
  box-shadow: 0 4px 20px rgba(201,168,76,0.25);
  margin-top: 4px;
}
.btn-login:hover:not(:disabled) {
  background-position: right center;
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(201,168,76,0.4);
}
.btn-login:disabled { opacity: 0.7; cursor: not-allowed; }

.btn-shimmer {
  position: absolute;
  inset: 0;
  background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.32) 50%, transparent 60%);
  transform: translateX(-100%);
}
.btn-login:hover:not(:disabled) .btn-shimmer {
  transform: translateX(100%);
  transition: transform 0.5s ease;
}

.spinner { animation: spin 0.8s linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }

/* Note */
.login-note {
  text-align: center;
  font-size: 10px;
  color: rgba(138,155,191,0.28);
  font-family: 'DM Mono', monospace;
  letter-spacing: 0.06em;
  margin-top: 22px;
}
</style>
