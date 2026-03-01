<template>
  <nav :class="['site-nav', { 'nav-scrolled': scrolled, 'nav-open': menuOpen }]">

    <!-- Animated glass border line -->
    <div class="nav-glow-line"/>

    <!-- Logo -->
    <a href="/" class="nav-logo">
      <div class="logo-emblem">
        <img :src="'/BGC.png'" alt="BGC Logo" class="logo-img"/>
      </div>
    </a>

    <!-- Desktop nav links -->
    <ul class="nav-links">
      <li v-for="link in navLinks" :key="link.label">
        <a :href="link.href" class="nav-link" @click.prevent="handleNavClick(link)">
          {{ link.label }}
          <span class="nav-link-bar"/>
        </a>
      </li>

      <!-- About dropdown -->
      <li
        class="nav-item-about"
        @mouseenter="aboutOpen = true"
        @mouseleave="aboutOpen = false"
      >
        <button
          class="nav-link nav-link-btn"
          :class="{ 'link-active': aboutOpen }"
        >
          About
          <svg
            class="chevron"
            :class="{ 'chevron-open': aboutOpen }"
            viewBox="0 0 10 6"
            fill="none"
            width="9" height="9"
          >
            <path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span class="nav-link-bar"/>
        </button>

        <!-- Dropdown panel -->
        <Transition name="dropdown">
          <div v-show="aboutOpen" class="dropdown-panel">
            <div class="dropdown-gold-bar"/>
            <div class="dropdown-inner">
              <a
                v-for="item in aboutLinks"
                :key="item.href"
                :href="item.href"
                class="dropdown-item"
              >
                <div class="di-num">{{ item.num }}</div>
                <div class="di-body">
                  <span class="di-title">{{ item.label }}</span>
                  <span class="di-desc">{{ item.desc }}</span>
                </div>
                <svg class="di-arrow" viewBox="0 0 16 16" fill="none" width="13" height="13">
                  <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </a>
            </div>
          </div>
        </Transition>
      </li>
    </ul>

    <!-- CTA -->
    <div class="nav-cta">
      <a href="/work-with-us" class="btn-join">
        <span>Work With Us</span>
        <svg viewBox="0 0 16 16" fill="none" width="12" height="12">
          <path d="M3 8h10M8 3l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
      </a>
      <!-- Hamburger -->
      <button
        class="hamburger"
        :class="{ active: menuOpen }"
        @click="menuOpen = !menuOpen"
        aria-label="Menu"
      >
        <span/><span/><span/>
      </button>
    </div>

    <!-- Mobile drawer -->
    <Transition name="drawer">
      <div v-if="menuOpen" class="mobile-drawer">
        <ul>
          <li v-for="link in navLinks" :key="link.label">
            <a :href="link.href" @click="handleNavClick(link); menuOpen = false">
              {{ link.label }}
            </a>
          </li>

          <!-- About accordion -->
          <li class="mobile-about-item">
            <button
              class="mobile-about-toggle"
              @click="mobileAboutOpen = !mobileAboutOpen"
            >
              <span>About</span>
              <svg
                class="mobile-chevron"
                :class="{ 'mobile-chevron-open': mobileAboutOpen }"
                viewBox="0 0 10 6" fill="none" width="10" height="10"
              >
                <path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
              </svg>
            </button>

            <Transition name="mobile-sub">
              <ul v-if="mobileAboutOpen" class="mobile-submenu">
                <li v-for="item in aboutLinks" :key="item.href">
                  <a :href="item.href" @click="menuOpen = false">
                    <span class="ms-num">{{ item.num }}</span>
                    {{ item.label }}
                  </a>
                </li>
              </ul>
            </Transition>
          </li>
        </ul>

        <a href="/work-with-us" class="btn-join-mobile" @click="menuOpen = false">
          Work With Us
        </a>
      </div>
    </Transition>

  </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const scrolled        = ref(false)
const menuOpen        = ref(false)
const aboutOpen       = ref(false)
const mobileAboutOpen = ref(false)

const navLinks = [
  { label: 'Focus Areas',   href: '/#focus'        },
  { label: 'Publications',  href: '/#publications' },
  { label: 'Events',        href: '/#events'       },
  { label: 'Council',       href: '/#voices'       },
  { label: 'Discussions',   href: '/#discussions'  },
]

const aboutLinks = [
  {
    num: '01',
    label: 'Who We Are',
    desc:  'Our story, founding team & values',
    href:  '/who-we-are',
  },
  {
    num: '02',
    label: 'Governing Board',
    desc:  'Chairman, executive officers & full board',
    href:  '/governing-board',
  },
  {
    num: '03',
    label: 'Work With Us',
    desc:  'Internships, fellowships & membership',
    href:  '/work-with-us',
  },
]

function handleNavClick(link) {
  // If on homepage, smooth-scroll to section; otherwise navigate
  if (window.location.pathname === '/') {
    const id = link.href.replace('/#', '')
    document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' })
  } else {
    window.location.href = link.href
  }
}

function onScroll() {
  scrolled.value = window.scrollY > 20
}

onMounted(() => window.addEventListener('scroll', onScroll, { passive: true }))
onUnmounted(() => window.removeEventListener('scroll', onScroll))
</script>

<style scoped>
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
  background: rgba(11, 28, 56, 0.55);
  backdrop-filter: blur(20px) saturate(160%);
  -webkit-backdrop-filter: blur(20px) saturate(160%);
  border-bottom: 1px solid rgba(201,168,76,0.10);
  transition: background 0.4s ease, box-shadow 0.4s ease, height 0.3s ease;
}

.site-nav.nav-scrolled {
  background: rgba(11, 28, 56, 0.93);
  backdrop-filter: blur(28px) saturate(180%);
  -webkit-backdrop-filter: blur(28px) saturate(180%);
  box-shadow: 0 4px 40px rgba(0,0,0,0.35), 0 1px 0 rgba(201,168,76,0.12);
  height: 64px;
}

/* Animated gold glow line */
.nav-glow-line {
  position: absolute;
  top: 0; left: 0; right: 0; height: 1px;
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
  50%       { opacity: 1;   transform: scaleX(1);   }
}

/* ── Logo ───────────────────────────────────────── */
.nav-logo {
  display: flex; align-items: center; gap: 14px;
  text-decoration: none; flex-shrink: 0;
}
.logo-emblem {
  display: flex; align-items: center; justify-content: center;
}
.logo-img {
  width: 130px; height: auto; object-fit: contain;
  transition: transform 0.3s;
}
.nav-logo:hover .logo-img { animation: logoPulse 1s ease-in-out; }
@keyframes logoPulse {
  0%  { transform: rotate(0deg); }
  25% { transform: rotate(3deg); }
  75% { transform: rotate(-3deg); }
  100%{ transform: rotate(0deg); }
}

/* ── Nav links ──────────────────────────────────── */
.nav-links {
  display: flex; align-items: center;
  gap: 34px; list-style: none;
  margin: 0; padding: 0;
}

.nav-link {
  position: relative;
  font-size: 11px; font-weight: 500;
  color: #b8c5d8; text-decoration: none;
  letter-spacing: 0.14em; text-transform: uppercase;
  padding-bottom: 2px; transition: color 0.25s;
}
.nav-link-btn {
  background: none; border: none; cursor: pointer;
  font-family: 'DM Sans', sans-serif;
  display: flex; align-items: center; gap: 5px;
  padding: 0;
}
.nav-link-bar {
  position: absolute;
  bottom: -3px; left: 0;
  width: 100%; height: 1px;
  background: linear-gradient(90deg, #c9a84c, #e8cf8a);
  transform: scaleX(0); transform-origin: left;
  transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1);
  border-radius: 1px;
}
.nav-link:hover,
.nav-link-btn:hover,
.link-active {
  color: #e8cf8a !important;
}
.nav-link:hover .nav-link-bar,
.nav-link-btn:hover .nav-link-bar,
.link-active .nav-link-bar {
  transform: scaleX(1);
}

/* Chevron */
.chevron {
  color: #b8c5d8; flex-shrink: 0;
  transition: transform 0.25s ease, color 0.25s;
}
.chevron-open,
.nav-link-btn:hover .chevron {
  transform: rotate(180deg);
  color: #e8cf8a;
}

/* ── About dropdown item ─────────────────────────── */
.nav-item-about {
  position: relative;
  list-style: none;
}

/* ── Dropdown panel ──────────────────────────────── */
.dropdown-panel {
  position: absolute;
  top: calc(100% + 16px);
  left: 50%;
  transform: translateX(-50%);
  width: 340px;
  background: rgba(11, 28, 56, 0.97);
  backdrop-filter: blur(24px) saturate(180%);
  -webkit-backdrop-filter: blur(24px) saturate(180%);
  border: 1px solid rgba(201,168,76,0.18);
  box-shadow:
    0 24px 60px rgba(0,0,0,0.5),
    0 0 0 1px rgba(255,255,255,0.04) inset;
  overflow: hidden;
  z-index: 300;
}

/* Gold top bar */
.dropdown-gold-bar {
  height: 2px;
  background: linear-gradient(90deg, #c9a84c, #e8cf8a, #c9a84c);
  background-size: 200% auto;
  animation: goldShine 3s linear infinite;
}
@keyframes goldShine {
  0%   { background-position: 0% center; }
  100% { background-position: 200% center; }
}

.dropdown-inner { padding: 8px; }

/* ── Dropdown item ───────────────────────────────── */
.dropdown-item {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 14px 16px;
  text-decoration: none;
  position: relative;
  overflow: hidden;
  transition: background 0.22s;
  border-radius: 2px;
}
.dropdown-item::before {
  content: '';
  position: absolute; left: 0; top: 0; bottom: 0; width: 2px;
  background: #c9a84c;
  transform: scaleY(0); transform-origin: top;
  transition: transform 0.22s ease;
}
.dropdown-item:hover {
  background: rgba(201,168,76,0.06);
}
.dropdown-item:hover::before { transform: scaleY(1); }

/* Numbered circle */
.di-num {
  width: 28px; height: 28px; border-radius: 50%;
  background: rgba(201,168,76,0.1);
  border: 1px solid rgba(201,168,76,0.2);
  display: flex; align-items: center; justify-content: center;
  font-size: 9px; font-weight: 700;
  color: #c9a84c; letter-spacing: 0.05em;
  font-family: 'DM Mono', monospace;
  flex-shrink: 0;
  transition: background 0.22s, border-color 0.22s;
}
.dropdown-item:hover .di-num {
  background: rgba(201,168,76,0.18);
  border-color: rgba(201,168,76,0.45);
}

/* Content */
.di-body {
  flex: 1; display: flex; flex-direction: column; gap: 2px;
}
.di-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.05rem; font-weight: 600;
  color: #f5f7fa; line-height: 1.15;
  transition: color 0.22s;
}
.dropdown-item:hover .di-title { color: #e8cf8a; }
.di-desc {
  font-size: 11px; font-weight: 300;
  color: rgba(184,197,216,0.45); letter-spacing: 0.02em;
  font-family: 'DM Sans', sans-serif;
}

/* Arrow */
.di-arrow {
  color: rgba(201,168,76,0.35);
  flex-shrink: 0;
  transform: translateX(-4px);
  opacity: 0;
  transition: transform 0.22s ease, opacity 0.22s ease, color 0.22s;
}
.dropdown-item:hover .di-arrow {
  transform: translateX(0);
  opacity: 1;
  color: #c9a84c;
}

/* Dropdown transition */
.dropdown-enter-active {
  transition: opacity 0.2s ease, transform 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}
.dropdown-leave-active {
  transition: opacity 0.15s ease, transform 0.15s ease;
}
.dropdown-enter-from,
.dropdown-leave-to {
  opacity: 0;
  transform: translateX(-50%) translateY(-8px);
}

/* ── CTA button ─────────────────────────────────── */
.nav-cta { display: flex; align-items: center; gap: 16px; }

.btn-join {
  display: inline-flex; align-items: center; gap: 8px;
  background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 50%, #c9a84c 100%);
  background-size: 200% auto;
  color: #0b1c38;
  font-size: 10px; font-weight: 700;
  letter-spacing: 0.18em; text-transform: uppercase;
  padding: 10px 22px; border: none; cursor: pointer;
  text-decoration: none; position: relative; overflow: hidden;
  transition: background-position 0.4s ease, transform 0.2s ease, box-shadow 0.3s ease;
  box-shadow: 0 2px 12px rgba(201,168,76,0.25);
  font-family: 'DM Sans', sans-serif;
}
.btn-join::before {
  content: ''; position: absolute; inset: 0;
  background: rgba(255,255,255,0.12); opacity: 0; transition: opacity 0.25s;
}
.btn-join:hover {
  background-position: right center;
  transform: translateY(-2px);
  box-shadow: 0 6px 24px rgba(201,168,76,0.4);
}
.btn-join:hover::before { opacity: 1; }

/* ── Hamburger ──────────────────────────────────── */
.hamburger {
  display: none; flex-direction: column; gap: 5px;
  padding: 4px; background: none; border: none; cursor: pointer;
}
.hamburger span {
  display: block; width: 22px; height: 1.5px;
  background: #b8c5d8; transition: all 0.3s; transform-origin: center;
}
.hamburger.active span:nth-child(1) { transform: translateY(6.5px) rotate(45deg); }
.hamburger.active span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.hamburger.active span:nth-child(3) { transform: translateY(-6.5px) rotate(-45deg); }

/* ── Mobile drawer ──────────────────────────────── */
.mobile-drawer {
  position: fixed;
  top: 72px; left: 0; right: 0;
  background: rgba(11, 28, 56, 0.98);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-bottom: 1px solid rgba(201,168,76,0.15);
  padding: 20px 24px 28px;
  display: flex; flex-direction: column; gap: 0;
}

.mobile-drawer > ul {
  list-style: none; margin: 0; padding: 0;
  display: flex; flex-direction: column;
}

.mobile-drawer > ul > li > a {
  display: block;
  font-size: 12px; font-weight: 500;
  color: #b8c5d8; text-decoration: none;
  letter-spacing: 0.14em; text-transform: uppercase;
  padding: 13px 0;
  border-bottom: 1px solid rgba(255,255,255,0.05);
  transition: color 0.2s;
}
.mobile-drawer > ul > li > a:hover { color: #e8cf8a; }

/* Mobile about accordion */
.mobile-about-item { list-style: none; }

.mobile-about-toggle {
  width: 100%;
  display: flex; align-items: center; justify-content: space-between;
  background: none; border: none; cursor: pointer;
  font-size: 12px; font-weight: 500;
  color: #b8c5d8; letter-spacing: 0.14em; text-transform: uppercase;
  padding: 13px 0;
  border-bottom: 1px solid rgba(255,255,255,0.05);
  font-family: 'DM Sans', sans-serif;
  transition: color 0.2s;
}
.mobile-about-toggle:hover { color: #e8cf8a; }

.mobile-chevron {
  color: #b8c5d8; transition: transform 0.25s ease, color 0.25s;
}
.mobile-chevron-open { transform: rotate(180deg); color: #c9a84c; }

/* Mobile submenu */
.mobile-submenu {
  list-style: none; margin: 0; padding: 0;
  background: rgba(201,168,76,0.04);
  border-left: 2px solid rgba(201,168,76,0.25);
  margin-left: 4px;
}
.mobile-submenu li a {
  display: flex; align-items: center; gap: 10px;
  font-size: 11px; font-weight: 500;
  color: rgba(184,197,216,0.7); text-decoration: none;
  letter-spacing: 0.12em; text-transform: uppercase;
  padding: 11px 16px;
  border-bottom: 1px solid rgba(255,255,255,0.04);
  transition: color 0.2s, background 0.2s;
}
.mobile-submenu li a:hover {
  color: #e8cf8a;
  background: rgba(201,168,76,0.06);
}
.ms-num {
  font-size: 9px; font-weight: 700;
  color: #c9a84c; letter-spacing: 0.1em;
  font-family: 'DM Mono', monospace;
}

/* Mobile submenu transition */
.mobile-sub-enter-active,
.mobile-sub-leave-active { transition: all 0.25s ease; }
.mobile-sub-enter-from,
.mobile-sub-leave-to { opacity: 0; transform: translateY(-6px); }

/* Mobile join button */
.btn-join-mobile {
  margin-top: 20px;
  display: block; text-align: center;
  background: linear-gradient(135deg, #c9a84c, #e8cf8a);
  color: #0b1c38;
  font-size: 11px; font-weight: 700;
  letter-spacing: 0.18em; text-transform: uppercase;
  padding: 13px 28px; text-decoration: none;
  font-family: 'DM Sans', sans-serif;
}

/* Drawer transition */
.drawer-enter-active,
.drawer-leave-active { transition: all 0.32s cubic-bezier(0.4, 0, 0.2, 1); }
.drawer-enter-from,
.drawer-leave-to    { opacity: 0; transform: translateY(-12px); }

/* ── Responsive ─────────────────────────────────── */
@media (max-width: 1024px) {
  .site-nav  { padding: 0 32px; }
  .nav-links { gap: 22px; }
}

@media (max-width: 768px) {
  .site-nav  { padding: 0 20px; }
  .nav-links { display: none; }
  .hamburger { display: flex; }
}
</style>
