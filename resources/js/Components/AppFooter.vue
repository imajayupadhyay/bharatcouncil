<template>
  <footer>

    <!-- SVG top border -->
    <div class="footer-top-line">
      <svg viewBox="0 0 1440 2" preserveAspectRatio="none" height="2" width="100%" aria-hidden="true">
        <defs>
          <linearGradient id="ftLine" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="0%"   stop-color="rgba(201,168,76,0)"/>
            <stop offset="25%"  stop-color="rgba(201,168,76,0.4)"/>
            <stop offset="75%"  stop-color="rgba(201,168,76,0.4)"/>
            <stop offset="100%" stop-color="rgba(201,168,76,0)"/>
          </linearGradient>
        </defs>
        <rect width="1440" height="2" fill="url(#ftLine)"/>
      </svg>
    </div>

    <!-- SVG bg texture -->
    <svg class="footer-bg-svg" viewBox="0 0 1440 500" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <pattern id="ftDots" width="32" height="32" patternUnits="userSpaceOnUse">
          <circle cx="1" cy="1" r="0.6" fill="rgba(255,255,255,0.025)"/>
        </pattern>
      </defs>
      <rect width="1440" height="500" fill="url(#ftDots)"/>
      <circle cx="1380" cy="500" r="300" fill="none" stroke="rgba(201,168,76,0.04)" stroke-width="1"/>
      <circle cx="60"   cy="0"   r="200" fill="none" stroke="rgba(201,168,76,0.03)" stroke-width="1"/>
    </svg>

    <div class="footer-inner">

      <!-- Top grid -->
      <div class="footer-top">

        <!-- Brand col -->
        <div class="footer-brand">
          <!-- Logo emblem -->
          <div class="brand-logo">
            <svg viewBox="0 0 40 40" fill="none" width="42" height="42">
              <polygon points="20,3 37,12 37,28 20,37 3,28 3,12" fill="none" stroke="#c9a84c" stroke-width="1.2"/>
              <polygon points="20,8 32,15 32,25 20,32 8,25 8,15" fill="none" stroke="#c9a84c" stroke-width="0.6" opacity="0.5"/>
              <circle cx="20" cy="20" r="4" fill="#c9a84c"/>
            </svg>
            <div class="brand-name">
              <span class="brand-title">Bharat Governance</span>
              <span class="brand-sub">Council</span>
            </div>
          </div>

          <p class="brand-desc">A community of citizens, scholars, and practitioners committed to evidence-based governance in Bharat.</p>

          <!-- Social icons -->
          <div class="brand-socials">
            <a v-for="s in socials" :key="s.label" href="#" class="social-link" :title="s.label">
              <span v-html="s.icon"/>
            </a>
          </div>
        </div>

        <!-- Nav columns -->
        <div v-for="col in footerCols" :key="col.heading" class="footer-col">
          <h5>{{ col.heading }}</h5>
          <ul>
            <li v-for="link in col.links" :key="link">
              <a href="#">
                <span class="link-arrow-icon">›</span>
                {{ link }}
              </a>
            </li>
          </ul>
        </div>

        <!-- Newsletter mini -->
        <div class="footer-col footer-newsletter">
          <h5>Stay Updated</h5>
          <p>Get the weekly policy digest in your inbox.</p>
          <form class="mini-form" @submit.prevent="miniSubmit">
            <input
              v-model="miniEmail"
              type="email"
              placeholder="your@email.com"
              class="mini-input"
            />
            <button class="mini-btn">
              <svg viewBox="0 0 16 16" fill="none" width="13" height="13">
                <path d="M3 8h10M8 3l5 5-5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
              </svg>
            </button>
          </form>
          <p v-if="miniSent" class="mini-confirm">
            <svg viewBox="0 0 14 14" fill="none" width="12" height="12">
              <path d="M2.5 7l3.5 3.5 5.5-6.5" stroke="#2ecc71" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            You're subscribed!
          </p>
        </div>

      </div>

      <!-- Divider -->
      <div class="footer-divider"/>

      <!-- Bottom bar -->
      <div class="footer-bottom">
        <div class="footer-copy">
          © {{ year }} Bharat Governance Council
          <span class="copy-dot">·</span>
          <a href="#" class="copy-link">bharatgovernancecouncil.org</a>
        </div>
        <div class="footer-legal">
          <a href="#">Privacy Policy</a>
          <span class="copy-dot">·</span>
          <a href="#">Terms of Use</a>
          <span class="copy-dot">·</span>
          <a href="#">Contact</a>
        </div>
        <div class="footer-socials">
          <a v-for="s in socials" :key="s.label" href="#" class="footer-social-text">{{ s.label }}</a>
        </div>
      </div>

    </div>
  </footer>
</template>

<script setup>
import { ref, computed } from 'vue'

const year      = computed(() => new Date().getFullYear())
const miniEmail = ref('')
const miniSent  = ref(false)

function miniSubmit() {
  if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(miniEmail.value)) {
    miniSent.value = true
    miniEmail.value = ''
  }
}

const footerCols = [
  {
    heading: 'Research',
    links: ['Publications', 'Policy Briefs', 'Explainers', 'Data Library'],
  },
  {
    heading: 'Community',
    links: ['Discussions', 'Events', 'Council Members', 'Become a Fellow'],
  },
  {
    heading: 'Organisation',
    links: ['About BGC', 'Our Team', 'Press Kit', 'Contact'],
  },
]

const socials = [
  { label: 'Twitter / X', icon: '<svg viewBox="0 0 20 20" fill="currentColor" width="14" height="14"><path d="M16.99 2h-2.77l-3.3 4.17L7.73 2H2l5.93 8.06L2.44 18h2.77l3.55-4.49L12.38 18H18l-6.13-8.27L16.99 2z"/></svg>' },
  { label: 'LinkedIn',    icon: '<svg viewBox="0 0 20 20" fill="currentColor" width="14" height="14"><path d="M5 3a2 2 0 110 4 2 2 0 010-4zm-2 6h4v8H3V9zm6 0h3.6v1.1h.05c.5-.95 1.73-1.95 3.55-1.95C18.96 8.15 19 10.42 19 13.04V17h-3.8v-3.3c0-1.44-.5-2.42-1.75-2.42-1.29 0-1.75.89-1.75 2.42V17H9V9z"/></svg>' },
  { label: 'YouTube',     icon: '<svg viewBox="0 0 20 20" fill="currentColor" width="14" height="14"><path d="M17.5 6s-.2-1.4-.83-1.97c-.8-.83-1.7-.84-2.1-.88C12.24 3 10 3 10 3s-2.24 0-4.57.15c-.4.04-1.3.05-2.1.88C2.7 4.6 2.5 6 2.5 6S2.3 7.6 2.3 9.2v1.5c0 1.6.2 3.2.2 3.2s.2 1.4.83 1.97c.8.83 1.84.8 2.3.89C7 16.9 10 17 10 17s2.24 0 4.57-.16c.4-.04 1.3-.06 2.1-.89.63-.57.83-1.97.83-1.97s.2-1.6.2-3.2V9.2C17.7 7.6 17.5 6 17.5 6zM8.4 12.3V7.7l5 2.3-5 2.3z"/></svg>' },
  { label: 'Telegram',    icon: '<svg viewBox="0 0 20 20" fill="currentColor" width="14" height="14"><path d="M17.84 3.15L2.47 8.86c-1.02.4-1.01.96-.19 1.21l3.84 1.2 8.88-5.6c.42-.26.8-.12.48.17l-7.17 6.47-.28 4.1c.4 0 .58-.18.8-.4l1.93-1.87 4 2.94c.74.41 1.27.2 1.45-.68l2.62-12.33c.26-1.04-.4-1.51-1.04-1.13z"/></svg>' },
]
</script>

<style scoped>
/* ── Footer ──────────────────────────────── */
footer {
  position: relative;
  background: #050e1e;
  overflow: hidden;
}

.footer-top-line { line-height: 0; }

.footer-bg-svg {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}

.footer-inner {
  position: relative;
  z-index: 2;
  max-width: 1280px;
  margin: 0 auto;
  padding: 64px 60px 40px;
}

/* ── Top grid ────────────────────────────── */
.footer-top {
  display: grid;
  grid-template-columns: 1.8fr 1fr 1fr 1fr 1.2fr;
  gap: 48px;
  margin-bottom: 52px;
}

/* ── Brand col ───────────────────────────── */
.footer-brand { display: flex; flex-direction: column; gap: 0; }

.brand-logo {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 16px;
}

.brand-name {
  display: flex;
  flex-direction: column;
  line-height: 1.15;
}
.brand-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 15px;
  font-weight: 600;
  color: #fff;
  letter-spacing: 0.02em;
}
.brand-sub {
  font-family: 'Cormorant Garamond', serif;
  font-style: italic;
  font-size: 13px;
  color: #c9a84c;
}

.brand-desc {
  font-size: 13px;
  color: #8a9bbf;
  line-height: 1.7;
  max-width: 260px;
  margin-bottom: 22px;
  font-family: 'DM Sans', sans-serif;
}

.brand-socials {
  display: flex;
  gap: 8px;
}
.social-link {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 32px; height: 32px;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.08);
  color: #8a9bbf;
  text-decoration: none;
  transition: background 0.2s, border-color 0.2s, color 0.2s, transform 0.2s;
}
.social-link:hover {
  background: rgba(201,168,76,0.12);
  border-color: rgba(201,168,76,0.3);
  color: #c9a84c;
  transform: translateY(-2px);
}

/* ── Nav cols ────────────────────────────── */
.footer-col h5 {
  font-size: 10px;
  font-weight: 600;
  color: #c9a84c;
  letter-spacing: 0.28em;
  text-transform: uppercase;
  margin-bottom: 18px;
  font-family: 'DM Sans', sans-serif;
}

.footer-col ul {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.footer-col a {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  color: #8a9bbf;
  text-decoration: none;
  font-family: 'DM Sans', sans-serif;
  transition: color 0.2s, gap 0.2s;
}
.footer-col a:hover { color: #e8cf8a; gap: 9px; }

.link-arrow-icon {
  color: rgba(201,168,76,0.3);
  font-size: 14px;
  line-height: 1;
  transition: color 0.2s, transform 0.2s;
}
.footer-col a:hover .link-arrow-icon {
  color: #c9a84c;
  transform: translateX(2px);
}

/* ── Newsletter mini ─────────────────────── */
.footer-newsletter p {
  font-size: 12px;
  color: #8a9bbf;
  line-height: 1.6;
  margin-bottom: 14px;
  font-family: 'DM Sans', sans-serif;
}

.mini-form {
  display: flex;
  gap: 0;
  margin-bottom: 10px;
}
.mini-input {
  flex: 1;
  padding: 10px 14px;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(201,168,76,0.2);
  border-right: none;
  color: #fff;
  font-family: 'DM Sans', sans-serif;
  font-size: 12px;
  outline: none;
  transition: border-color 0.2s, background 0.2s;
}
.mini-input:focus {
  border-color: rgba(201,168,76,0.5);
  background: rgba(255,255,255,0.08);
}
.mini-input::placeholder { color: #8a9bbf; }

.mini-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 38px;
  background: #c9a84c;
  border: 1px solid #c9a84c;
  color: #0b1c38;
  cursor: pointer;
  transition: background 0.2s;
  flex-shrink: 0;
}
.mini-btn:hover { background: #e8cf8a; }

.mini-confirm {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 11px;
  color: #2ecc71;
  font-family: 'DM Mono', monospace;
}

/* ── Divider ─────────────────────────────── */
.footer-divider {
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.06) 20%, rgba(255,255,255,0.06) 80%, transparent);
  margin-bottom: 28px;
}

/* ── Bottom bar ──────────────────────────── */
.footer-bottom {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
}

.footer-copy {
  font-size: 12px;
  color: rgba(138,155,191,0.35);
  letter-spacing: 0.06em;
  font-family: 'DM Mono', monospace;
  display: flex;
  align-items: center;
  gap: 8px;
  flex-wrap: wrap;
}
.copy-dot { opacity: 0.4; }
.copy-link {
  color: rgba(138,155,191,0.35);
  text-decoration: none;
  transition: color 0.2s;
}
.copy-link:hover { color: #c9a84c; }

.footer-legal {
  display: flex;
  align-items: center;
  gap: 8px;
  flex-wrap: wrap;
}
.footer-legal a {
  font-size: 11px;
  color: rgba(138,155,191,0.3);
  text-decoration: none;
  font-family: 'DM Sans', sans-serif;
  transition: color 0.2s;
}
.footer-legal a:hover { color: #c9a84c; }

.footer-socials {
  display: flex;
  gap: 20px;
  flex-wrap: wrap;
}
.footer-social-text {
  font-size: 11px;
  color: rgba(138,155,191,0.3);
  text-decoration: none;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
  transition: color 0.2s;
}
.footer-social-text:hover { color: #c9a84c; }

/* ── Responsive ──────────────────────────── */
@media (max-width: 1100px) {
  .footer-top { grid-template-columns: 1.4fr 1fr 1fr 1fr; }
  .footer-newsletter { grid-column: 1 / -1; }
}
@media (max-width: 768px) {
  .footer-inner { padding: 48px 20px 32px; }
  .footer-top {
    grid-template-columns: 1fr 1fr;
    gap: 32px;
  }
  .footer-brand { grid-column: 1 / -1; }
  .footer-newsletter { grid-column: 1 / -1; }
  .footer-bottom { flex-direction: column; align-items: flex-start; gap: 16px; }
}
@media (max-width: 480px) {
  .footer-top { grid-template-columns: 1fr; }
}
</style>
