<template>
  <nav :class="['site-nav', { 'nav-scrolled': scrolled, 'nav-open': menuOpen }]">
    <!-- Animated glass border line -->
    <div class="nav-glow-line" />

    <!-- Logo -->
    <a href="#" class="nav-logo" @click.prevent="scrollTo('hero')">
      <div class="logo-emblem">
        <img :src="'/BGC.png'" alt="BGC Logo" class="logo-img" />
      </div>
    </a>

    <!-- Desktop nav links -->
    <ul class="nav-links">
      <li v-for="link in navLinks" :key="link.id">
        <a :href="`#${link.id}`" class="nav-link" @click.prevent="scrollTo(link.id)">
          {{ link.label }}
          <span class="nav-link-bar" />
        </a>
      </li>
    </ul>

    <!-- CTA -->
    <div class="nav-cta">
      <a href="#" class="btn-join">
        <span>Join Council</span>
        <svg viewBox="0 0 16 16" fill="none" width="12" height="12">
          <path d="M3 8h10M8 3l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
      </a>
      <!-- Hamburger -->
      <button class="hamburger" :class="{ active: menuOpen }" @click="menuOpen = !menuOpen" aria-label="Menu">
        <span /><span /><span />
      </button>
    </div>

    <!-- Mobile drawer -->
    <Transition name="drawer">
      <div v-if="menuOpen" class="mobile-drawer">
        <ul>
          <li v-for="link in navLinks" :key="link.id">
            <a :href="`#${link.id}`" @click="scrollTo(link.id); menuOpen = false">{{ link.label }}</a>
          </li>
        </ul>
        <a href="#" class="btn-join-mobile">Join Council</a>
      </div>
    </Transition>
  </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const scrolled = ref(false)
const menuOpen = ref(false)

const navLinks = [
  { id: 'focus',       label: 'Focus Areas'  },
  { id: 'publications', label: 'Publications' },
  { id: 'events',      label: 'Events'        },
  { id: 'voices',      label: 'Council'       },
  { id: 'discussions', label: 'Discussions'   },
  { id: 'about',       label: 'About'         },
]

function onScroll() {
  scrolled.value = window.scrollY > 20
}

function scrollTo(id) {
  const el = document.getElementById(id)
  if (el) el.scrollIntoView({ behavior: 'smooth' })
}

onMounted(() => window.addEventListener('scroll', onScroll, { passive: true }))
onUnmounted(() => window.removeEventListener('scroll', onScroll))
</script>

<style scoped>
/* ── Variables ─────────────────────────────────── */
:root {
  --navy:   #0b1c38;
  --gold:   #c9a84c;
  --gold-lt:#e8cf8a;
  --silver: #b8c5d8;
  --grey-2: #8a9bbf;
}

/* ── Base nav ───────────────────────────────────── */
.site-nav {
  position: fixed;
  inset: 0 0 auto;
  z-index: 200;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 60px;
  height: 72px;

  /* Glass morphism */
  background: rgba(11, 28, 56, 0.55);
  backdrop-filter: blur(20px) saturate(160%);
  -webkit-backdrop-filter: blur(20px) saturate(160%);
  border-bottom: 1px solid rgba(201,168,76,0.10);

  transition: background 0.4s ease, box-shadow 0.4s ease, height 0.3s ease;
}

.site-nav.nav-scrolled {
  background: rgba(11, 28, 56, 0.92);
  backdrop-filter: blur(28px) saturate(180%);
  -webkit-backdrop-filter: blur(28px) saturate(180%);
  box-shadow: 0 4px 40px rgba(0,0,0,0.35), 0 1px 0 rgba(201,168,76,0.12);
  height: 64px;
}

/* Animated top border glow */
.nav-glow-line {
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 1px;
  background: linear-gradient(90deg,
    transparent 0%,
    rgba(201,168,76,0) 10%,
    rgba(201,168,76,0.5) 40%,
    rgba(232,207,138,0.8) 50%,
    rgba(201,168,76,0.5) 60%,
    rgba(201,168,76,0) 90%,
    transparent 100%
  );
  animation: glowShift 4s ease-in-out infinite;
}

@keyframes glowShift {
  0%, 100% { opacity: 0.4; transform: scaleX(0.6); }
  50%       { opacity: 1;   transform: scaleX(1); }
}

/* ── Logo ───────────────────────────────────────── */
.nav-logo {
  display: flex;
  align-items: center;
  gap: 14px;
  text-decoration: none;
  flex-shrink: 0;
}

.logo-emblem {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}

.logo-img {
  width: 130px;
  height: auto;
  object-fit: contain;
  transition: transform 0.3s;
}

.nav-logo:hover .logo-img {
  animation: logoPulse 1s ease-in-out;
}

@keyframes logoPulse {
  0%   { transform: rotate(0deg); }
  25%  { transform: rotate(3deg); }
  75%  { transform: rotate(-3deg); }
  100% { transform: rotate(0deg); }
}


/* ── Nav links ──────────────────────────────────── */
.nav-links {
  display: flex;
  gap: 34px;
  list-style: none;
  margin: 0; padding: 0;
}

.nav-link {
  position: relative;
  font-size: 11px;
  font-weight: 500;
  color: #b8c5d8;
  text-decoration: none;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  padding-bottom: 2px;
  transition: color 0.25s;
}

.nav-link-bar {
  position: absolute;
  bottom: -3px; left: 0;
  width: 100%; height: 1px;
  background: linear-gradient(90deg, #c9a84c, #e8cf8a);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1);
  border-radius: 1px;
}

.nav-link:hover {
  color: #e8cf8a;
}

.nav-link:hover .nav-link-bar {
  transform: scaleX(1);
}

/* ── CTA button ─────────────────────────────────── */
.nav-cta {
  display: flex;
  align-items: center;
  gap: 16px;
}

.btn-join {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 50%, #c9a84c 100%);
  background-size: 200% auto;
  color: #0b1c38;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  padding: 10px 22px;
  border: none;
  cursor: pointer;
  text-decoration: none;
  position: relative;
  overflow: hidden;
  transition: background-position 0.4s ease, transform 0.2s ease, box-shadow 0.3s ease;
  box-shadow: 0 2px 12px rgba(201,168,76,0.25);
}

.btn-join::before {
  content: '';
  position: absolute;
  inset: 0;
  background: rgba(255,255,255,0.12);
  opacity: 0;
  transition: opacity 0.25s;
}

.btn-join:hover {
  background-position: right center;
  transform: translateY(-2px);
  box-shadow: 0 6px 24px rgba(201,168,76,0.4);
}

.btn-join:hover::before { opacity: 1; }

/* ── Hamburger ──────────────────────────────────── */
.hamburger {
  display: none;
  flex-direction: column;
  gap: 5px;
  padding: 4px;
  background: none;
  border: none;
  cursor: pointer;
}

.hamburger span {
  display: block;
  width: 22px;
  height: 1.5px;
  background: #b8c5d8;
  transition: all 0.3s;
  transform-origin: center;
}

.hamburger.active span:nth-child(1) { transform: translateY(6.5px) rotate(45deg); }
.hamburger.active span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.hamburger.active span:nth-child(3) { transform: translateY(-6.5px) rotate(-45deg); }

/* ── Mobile drawer ──────────────────────────────── */
.mobile-drawer {
  position: fixed;
  top: 72px;
  left: 0; right: 0;
  background: rgba(11, 28, 56, 0.97);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-bottom: 1px solid rgba(201,168,76,0.15);
  padding: 24px 32px 32px;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.mobile-drawer ul {
  list-style: none;
  margin: 0; padding: 0;
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.mobile-drawer ul a {
  display: block;
  font-size: 12px;
  font-weight: 500;
  color: #b8c5d8;
  text-decoration: none;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  padding: 12px 0;
  border-bottom: 1px solid rgba(255,255,255,0.05);
  transition: color 0.2s;
}

.mobile-drawer ul a:hover { color: #e8cf8a; }

.btn-join-mobile {
  margin-top: 16px;
  display: inline-block;
  background: linear-gradient(135deg, #c9a84c, #e8cf8a);
  color: #0b1c38;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  padding: 13px 28px;
  text-decoration: none;
  text-align: center;
}

/* Drawer transition */
.drawer-enter-active,
.drawer-leave-active { transition: all 0.32s cubic-bezier(0.4, 0, 0.2, 1); }
.drawer-enter-from,
.drawer-leave-to    { opacity: 0; transform: translateY(-12px); }

/* ── Responsive ─────────────────────────────────── */
@media (max-width: 1024px) {
  .site-nav { padding: 0 32px; }
  .nav-links { gap: 22px; }
}

@media (max-width: 768px) {
  .site-nav { padding: 0 20px; }
  .nav-links { display: none; }
  .hamburger { display: flex; }
  .logo-wordmark { display: none; }
}
</style>
