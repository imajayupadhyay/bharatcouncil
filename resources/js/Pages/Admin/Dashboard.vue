<template>
  <div class="admin-root">

    <!-- ══ Sidebar ══ -->
    <aside class="admin-sidebar" :class="{ collapsed: sidebarCollapsed }">

      <!-- Logo -->
      <div class="sidebar-logo">
        <img :src="'/BGC.png'" alt="BGC" class="sidebar-logo-img" />
        <span v-if="!sidebarCollapsed" class="sidebar-logo-label">Admin</span>
      </div>

      <!-- Nav -->
      <nav class="sidebar-nav">
        <div class="nav-group-label" v-if="!sidebarCollapsed">Overview</div>
        <Link
          v-for="item in navItems"
          :key="item.id"
          :href="item.href"
          class="nav-item"
          :class="{ active: item.id === 'dashboard' }"
          :title="sidebarCollapsed ? item.label : ''"
        >
          <span class="nav-icon" v-html="item.icon"/>
          <span v-if="!sidebarCollapsed" class="nav-label">{{ item.label }}</span>
          <span v-if="!sidebarCollapsed && item.badge" class="nav-badge">{{ item.badge }}</span>
        </Link>
      </nav>

      <!-- Collapse toggle -->
      <button class="sidebar-toggle" @click="sidebarCollapsed = !sidebarCollapsed" title="Toggle sidebar">
        <svg viewBox="0 0 16 16" fill="none" width="14" height="14" :class="{ flipped: sidebarCollapsed }">
          <path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
      </button>

      <!-- Logout -->
      <div class="sidebar-footer">
        <form method="POST" action="/admin/logout" @submit.prevent="logout">
          <button type="submit" class="btn-logout">
            <svg viewBox="0 0 16 16" fill="none" width="14" height="14">
              <path d="M6 3H3a1 1 0 00-1 1v8a1 1 0 001 1h3M10 5l3 3-3 3M13 8H6" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span v-if="!sidebarCollapsed">Logout</span>
          </button>
        </form>
      </div>

    </aside>

    <!-- ══ Main content ══ -->
    <main class="admin-main">

      <!-- Top bar -->
      <header class="admin-topbar">
        <div class="topbar-left">
          <h2 class="topbar-title">{{ currentSection }}</h2>
          <div class="topbar-breadcrumb">
            <span>Admin</span>
            <span class="bc-sep">›</span>
            <span class="bc-active">{{ currentSection }}</span>
          </div>
        </div>
        <div class="topbar-right">
          <!-- Live indicator -->
          <div class="topbar-live">
            <span class="live-dot"/>
            <span class="live-label">System Online</span>
          </div>
          <!-- Admin avatar -->
          <div class="topbar-admin">
            <div class="admin-avatar">
              {{ admin?.name?.charAt(0)?.toUpperCase() ?? 'A' }}
            </div>
            <div class="admin-info">
              <span class="admin-name">{{ admin?.name ?? 'Admin' }}</span>
              <span class="admin-email">{{ admin?.email ?? '' }}</span>
            </div>
          </div>
        </div>
      </header>

      <!-- Welcome banner -->
      <div class="welcome-banner" :class="{ visible: mounted }">
        <!-- SVG bg -->
        <svg class="banner-bg" viewBox="0 0 1200 160" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
          <defs>
            <radialGradient id="db-glow" cx="80%" cy="50%" r="50%">
              <stop offset="0%" stop-color="#c9a84c" stop-opacity="0.1"/>
              <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
            </radialGradient>
          </defs>
          <rect width="1200" height="160" fill="url(#db-glow)"/>
          <g opacity="0.15" transform="translate(1060, 10)">
            <polygon points="50,0 100,29 100,87 50,116 0,87 0,29" fill="none" stroke="#c9a84c" stroke-width="0.8"/>
            <circle cx="50" cy="58" r="18" fill="none" stroke="#c9a84c" stroke-width="0.6"/>
            <circle cx="50" cy="58" r="4"  fill="#c9a84c" opacity="0.5"/>
          </g>
        </svg>

        <div class="banner-content">
          <div class="banner-eyebrow">
            <span class="eyebrow-dot"/>
            Welcome back
          </div>
          <h1 class="banner-headline">
            Good {{ timeGreeting }},
            <em>{{ admin?.name ?? 'Admin' }}.</em>
          </h1>
          <p class="banner-sub">Here's what's happening with the BGC platform today.</p>
        </div>
        <div class="banner-date">
          <span class="banner-time">{{ currentTime }}</span>
          <span class="banner-date-text">{{ currentDate }}</span>
        </div>
      </div>

      <!-- Stats grid -->
      <div class="stats-grid" :class="{ visible: mounted }">
        <div
          v-for="(stat, i) in stats"
          :key="i"
          class="stat-card"
          :style="{ transitionDelay: `${0.1 + i * 0.08}s` }"
        >
          <div class="stat-card-top">
            <span class="stat-label">{{ stat.label }}</span>
            <div class="stat-icon-wrap" :class="`icon-${stat.color}`">
              <span v-html="stat.icon"/>
            </div>
          </div>
          <div class="stat-value">{{ stat.value }}</div>
          <div class="stat-change" :class="stat.trend > 0 ? 'trend-up' : 'trend-down'">
            <svg viewBox="0 0 10 10" fill="none" width="10" height="10">
              <path v-if="stat.trend > 0" d="M5 8V2M2 5l3-3 3 3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
              <path v-else d="M5 2v6M2 5l3 3 3-3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
            </svg>
            {{ Math.abs(stat.trend) }}% from last month
          </div>
        </div>
      </div>

      <!-- Bottom grid: Recent activity + Quick actions -->
      <div class="bottom-grid" :class="{ visible: mounted }">

        <!-- Recent activity -->
        <div class="panel">
          <div class="panel-header">
            <h3>Recent Activity</h3>
            <a href="#" class="panel-link">View all</a>
          </div>
          <ul class="activity-list">
            <li v-for="(act, i) in activity" :key="i" class="activity-item">
              <div class="activity-dot" :class="`dot-${act.type}`"/>
              <div class="activity-content">
                <span class="activity-text">{{ act.text }}</span>
                <span class="activity-time">{{ act.time }}</span>
              </div>
            </li>
          </ul>
        </div>

        <!-- Quick actions -->
        <div class="panel">
          <div class="panel-header">
            <h3>Quick Actions</h3>
          </div>
          <div class="quick-actions">
            <a v-for="action in quickActions" :key="action.label" href="#" class="quick-action-btn">
              <span class="qa-icon" v-html="action.icon"/>
              <span class="qa-label">{{ action.label }}</span>
              <svg viewBox="0 0 12 12" fill="none" width="10" height="10" class="qa-arrow">
                <path d="M2 6h8M6 2l4 4-4 4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
              </svg>
            </a>
          </div>
        </div>

      </div>

    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
  admin: Object,
})

const mounted          = ref(false)
const sidebarCollapsed = ref(false)
const currentTime      = ref('')
const currentDate      = ref('')

// ── Nav items ─────────────────────────────────────────────
const navItems = [
  {
    id: 'dashboard', label: 'Dashboard', href: '/admin/dashboard',
    icon: '<svg viewBox="0 0 16 16" fill="none" width="16" height="16"><rect x="1.5" y="1.5" width="5.5" height="5.5" rx="0.5" stroke="currentColor" stroke-width="1.2"/><rect x="9" y="1.5" width="5.5" height="5.5" rx="0.5" stroke="currentColor" stroke-width="1.2"/><rect x="1.5" y="9" width="5.5" height="5.5" rx="0.5" stroke="currentColor" stroke-width="1.2"/><rect x="9" y="9" width="5.5" height="5.5" rx="0.5" stroke="currentColor" stroke-width="1.2"/></svg>',
  },
  {
    id: 'applications', label: 'Applications', href: '/admin/applications',
    icon: '<svg viewBox="0 0 16 16" fill="none" width="16" height="16"><rect x="2" y="1.5" width="12" height="13" rx="1" stroke="currentColor" stroke-width="1.2"/><path d="M5 5.5h6M5 8h6M5 10.5h4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>',
  },
  {
    id: 'internships', label: 'Internships', href: '/admin/intern-applications',
    icon: '<svg viewBox="0 0 16 16" fill="none" width="16" height="16"><path d="M4 6V4a4 4 0 118 0v2M2 6h12v8a1 1 0 01-1 1H3a1 1 0 01-1-1V6z" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/><circle cx="8" cy="10" r="1.5" stroke="currentColor" stroke-width="1.2"/></svg>',
  },
  {
    id: 'newsletters', label: 'Newsletter', href: '/admin/newsletters',
    icon: '<svg viewBox="0 0 16 16" fill="none" width="16" height="16"><path d="M1 4l7 5 7-5M1 4h14v10H1V4Z" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/></svg>',
  },
  {
    id: 'admin-users', label: 'Admin Users', href: '/admin/admin-users',
    icon: '<svg viewBox="0 0 16 16" fill="none" width="16" height="16"><circle cx="6" cy="5" r="2.5" stroke="currentColor" stroke-width="1.2"/><path d="M1 13.5c0-2.76 2.24-5 5-5s5 2.24 5 5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/><path d="M12 8v4M10 10h4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>',
  },
]

// ── Stats ──────────────────────────────────────────────────
const stats = [
  {
    label: 'Total Articles', value: '128',  trend: 12, color: 'gold',
    icon: '<svg viewBox="0 0 16 16" fill="none" width="16" height="16"><rect x="2" y="2" width="12" height="12" rx="1" stroke="currentColor" stroke-width="1.2"/><path d="M5 6h6M5 9h4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>',
  },
  {
    label: 'Community Members', value: '5,241', trend: 8, color: 'blue',
    icon: '<svg viewBox="0 0 16 16" fill="none" width="16" height="16"><circle cx="6" cy="5.5" r="2.5" stroke="currentColor" stroke-width="1.2"/><path d="M1 13.5c0-2.76 2.24-5 5-5s5 2.24 5 5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/><path d="M11 7a2.5 2.5 0 000-5M15 13.5c0-2.76-1.34-5-3-5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>',
  },
  {
    label: 'Events This Month', value: '3', trend: -1, color: 'green',
    icon: '<svg viewBox="0 0 16 16" fill="none" width="16" height="16"><rect x="1.5" y="3.5" width="13" height="11" rx="1" stroke="currentColor" stroke-width="1.2"/><path d="M5 1.5v4M11 1.5v4M1.5 7.5h13" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>',
  },
  {
    label: 'Discussions', value: '840', trend: 22, color: 'purple',
    icon: '<svg viewBox="0 0 16 16" fill="none" width="16" height="16"><path d="M1 1h14v10H9l-4 4V11H1V1z" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/></svg>',
  },
]

// ── Activity feed ──────────────────────────────────────────
const activity = [
  { type: 'gold',   text: 'New article published: "Reforming India\'s Fiscal Federalism"', time: '2 mins ago'  },
  { type: 'blue',   text: '14 new members joined the community',                           time: '1 hour ago'  },
  { type: 'green',  text: 'Event registration opened: BGC Summit 2025',                    time: '3 hours ago' },
  { type: 'purple', text: 'New discussion started on Electoral Finance Reform',             time: '5 hours ago' },
  { type: 'gold',   text: 'Article draft saved: "State of Digital Public Infrastructure"', time: '1 day ago'   },
]

// ── Quick actions ──────────────────────────────────────────
const quickActions = [
  { label: 'Publish New Article',   icon: '<svg viewBox="0 0 14 14" fill="none" width="14" height="14"><path d="M7 1v12M1 7h12" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>' },
  { label: 'Create Event',          icon: '<svg viewBox="0 0 14 14" fill="none" width="14" height="14"><rect x="1" y="2.5" width="12" height="10" rx="1" stroke="currentColor" stroke-width="1.2"/><path d="M4.5 1v3M9.5 1v3M1 6.5h12" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>' },
  { label: 'Manage Members',        icon: '<svg viewBox="0 0 14 14" fill="none" width="14" height="14"><circle cx="5" cy="4.5" r="2.5" stroke="currentColor" stroke-width="1.2"/><path d="M1 12c0-2.21 1.79-4 4-4s4 1.79 4 4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/><path d="M10 6l2 2-2 2M12 8H9" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>' },
  { label: 'Site Settings',         icon: '<svg viewBox="0 0 14 14" fill="none" width="14" height="14"><circle cx="7" cy="7" r="2" stroke="currentColor" stroke-width="1.2"/><path d="M7 1v2M7 11v2M1 7h2M11 7h2M2.93 2.93l1.41 1.41M9.66 9.66l1.41 1.41M2.93 11.07l1.41-1.41M9.66 4.34l1.41-1.41" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>' },
]

// ── Computed ───────────────────────────────────────────────
const currentSection = computed(() => 'Dashboard')

const timeGreeting = computed(() => {
  const h = new Date().getHours()
  if (h < 12) return 'Morning'
  if (h < 17) return 'Afternoon'
  return 'Evening'
})

// ── Clock ──────────────────────────────────────────────────
let clockTimer = null

function updateClock() {
  const now = new Date()
  currentTime.value = now.toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit' })
  currentDate.value = now.toLocaleDateString('en-IN', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })
}

function logout() {
  router.post('/admin/logout')
}

onMounted(() => {
  updateClock()
  clockTimer = setInterval(updateClock, 60000)
  requestAnimationFrame(() => setTimeout(() => { mounted.value = true }, 80))
})

onUnmounted(() => clearInterval(clockTimer))
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap');
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'DM Sans', sans-serif; background: #f2f4f8; }
</style>

<style scoped>
/* ── Root layout ──────────────────────────── */
.admin-root {
  display: flex;
  min-height: 100vh;
  background: #f2f4f8;
}

/* ════════════════════════════════════════════
   SIDEBAR
════════════════════════════════════════════ */
.admin-sidebar {
  width: 240px;
  flex-shrink: 0;
  background: #0b1c38;
  display: flex;
  flex-direction: column;
  border-right: 1px solid rgba(201,168,76,0.12);
  transition: width 0.3s cubic-bezier(0.4,0,0.2,1);
  position: sticky;
  top: 0;
  height: 100vh;
  overflow: hidden;
}
.admin-sidebar.collapsed { width: 64px; }

/* Logo */
.sidebar-logo {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 20px 18px;
  border-bottom: 1px solid rgba(255,255,255,0.06);
  flex-shrink: 0;
}
.sidebar-logo-img {
  width: 44px;
  height: auto;
  object-fit: contain;
  flex-shrink: 0;
}
.sidebar-logo-label {
  font-size: 9px;
  font-weight: 700;
  color: #c9a84c;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  font-family: 'DM Mono', monospace;
  white-space: nowrap;
}

/* Nav */
.sidebar-nav {
  flex: 1;
  padding: 20px 10px;
  display: flex;
  flex-direction: column;
  gap: 2px;
  overflow-y: auto;
  overflow-x: hidden;
}
.nav-group-label {
  font-size: 8px;
  font-weight: 700;
  color: rgba(138,155,191,0.35);
  letter-spacing: 0.3em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
  padding: 0 8px;
  margin-bottom: 6px;
  white-space: nowrap;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 10px 12px;
  color: #8a9bbf;
  text-decoration: none;
  font-size: 13px;
  font-weight: 500;
  font-family: 'DM Sans', sans-serif;
  border-radius: 0;
  position: relative;
  transition: color 0.2s, background 0.2s;
  white-space: nowrap;
  overflow: hidden;
}
.nav-item::before {
  content: '';
  position: absolute;
  left: 0; top: 0; bottom: 0;
  width: 2px;
  background: linear-gradient(to bottom, #c9a84c, #e8cf8a);
  transform: scaleY(0);
  transition: transform 0.25s;
}
.nav-item:hover { color: #e8cf8a; background: rgba(255,255,255,0.04); }
.nav-item.active {
  color: #e8cf8a;
  background: rgba(201,168,76,0.08);
}
.nav-item.active::before { transform: scaleY(1); }

.nav-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  width: 16px;
}
.nav-label { flex: 1; }
.nav-badge {
  font-size: 9px;
  font-family: 'DM Mono', monospace;
  color: #c9a84c;
  background: rgba(201,168,76,0.15);
  padding: 2px 6px;
  border-radius: 10px;
  flex-shrink: 0;
}

/* Collapse toggle */
.sidebar-toggle {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  padding: 12px;
  background: none;
  border: none;
  border-top: 1px solid rgba(255,255,255,0.05);
  color: rgba(138,155,191,0.4);
  cursor: pointer;
  transition: color 0.2s;
  flex-shrink: 0;
}
.sidebar-toggle:hover { color: #c9a84c; }
.sidebar-toggle svg { transition: transform 0.3s; }
.sidebar-toggle svg.flipped { transform: rotate(180deg); }

/* Sidebar footer */
.sidebar-footer {
  padding: 12px 10px;
  border-top: 1px solid rgba(255,255,255,0.05);
  flex-shrink: 0;
}
.btn-logout {
  display: flex;
  align-items: center;
  gap: 10px;
  width: 100%;
  padding: 10px 12px;
  background: none;
  border: none;
  color: rgba(138,155,191,0.5);
  font-size: 13px;
  font-family: 'DM Sans', sans-serif;
  cursor: pointer;
  white-space: nowrap;
  overflow: hidden;
  transition: color 0.2s, background 0.2s;
}
.btn-logout:hover {
  color: #e74c3c;
  background: rgba(231,76,60,0.08);
}

/* ════════════════════════════════════════════
   MAIN CONTENT
════════════════════════════════════════════ */
.admin-main {
  flex: 1;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

/* Top bar */
.admin-topbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 32px;
  height: 64px;
  background: #fff;
  border-bottom: 1px solid rgba(11,28,56,0.07);
  flex-shrink: 0;
  gap: 20px;
}

.topbar-left { display: flex; flex-direction: column; gap: 2px; }
.topbar-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 20px;
  font-weight: 600;
  color: #0b1c38;
  line-height: 1;
}
.topbar-breadcrumb {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 10px;
  color: #8a9bbf;
  font-family: 'DM Mono', monospace;
  letter-spacing: 0.06em;
}
.bc-sep { color: rgba(201,168,76,0.4); }
.bc-active { color: #c9a84c; }

.topbar-right {
  display: flex;
  align-items: center;
  gap: 20px;
}

.topbar-live {
  display: flex;
  align-items: center;
  gap: 7px;
}
.live-dot {
  width: 7px; height: 7px;
  border-radius: 50%;
  background: #2ecc71;
  position: relative;
}
.live-dot::before {
  content: '';
  position: absolute;
  inset: -3px;
  border-radius: 50%;
  background: rgba(46,204,113,0.25);
  animation: livePulse 1.8s ease-out infinite;
}
@keyframes livePulse {
  0%   { transform: scale(0.8); opacity: 1; }
  100% { transform: scale(2.2); opacity: 0; }
}
.live-label {
  font-size: 10px;
  color: rgba(46,204,113,0.7);
  font-family: 'DM Mono', monospace;
  letter-spacing: 0.06em;
}

.topbar-admin { display: flex; align-items: center; gap: 10px; }
.admin-avatar {
  width: 36px; height: 36px;
  border-radius: 50%;
  background: linear-gradient(135deg, #c9a84c, #e8cf8a);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Cormorant Garamond', serif;
  font-size: 16px;
  font-weight: 700;
  color: #0b1c38;
  flex-shrink: 0;
}
.admin-info { display: flex; flex-direction: column; gap: 1px; }
.admin-name {
  font-size: 13px;
  font-weight: 500;
  color: #0b1c38;
  font-family: 'DM Sans', sans-serif;
  text-transform: capitalize;
}
.admin-email {
  font-size: 10px;
  color: #8a9bbf;
  font-family: 'DM Mono', monospace;
}

/* Main scroll area */
.admin-main > * { flex-shrink: 0; }
.welcome-banner,
.stats-grid,
.bottom-grid {
  opacity: 0;
  transform: translateY(16px);
  transition: opacity 0.7s ease, transform 0.7s ease;
}
.welcome-banner.visible,
.stats-grid.visible,
.bottom-grid.visible {
  opacity: 1;
  transform: translateY(0);
}
.stats-grid { transition-delay: 0.1s; }
.bottom-grid { transition-delay: 0.2s; }

/* Content padding wrapper */
.welcome-banner,
.stats-grid,
.bottom-grid { margin: 0; }

.welcome-banner { margin: 24px 28px 0; }
.stats-grid     { margin: 20px 28px 0; }
.bottom-grid    { margin: 20px 28px 24px; }

/* Welcome banner */
.welcome-banner {
  position: relative;
  background: #0b1c38;
  overflow: hidden;
  padding: 32px 40px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  border: 1px solid rgba(201,168,76,0.15);
}
.welcome-banner::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 2px;
  background: linear-gradient(90deg, #c9a84c, #e8cf8a, rgba(201,168,76,0.2));
}

.banner-bg {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}

.banner-content { position: relative; z-index: 1; }
.banner-eyebrow {
  display: flex;
  align-items: center;
  gap: 7px;
  font-size: 9px;
  font-weight: 600;
  color: #c9a84c;
  letter-spacing: 0.28em;
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
.banner-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: 34px;
  font-weight: 600;
  color: #fff;
  line-height: 1.1;
  margin-bottom: 6px;
}
.banner-headline em {
  font-style: italic;
  color: #c9a84c;
}
.banner-sub {
  font-size: 13px;
  color: #8a9bbf;
  font-family: 'DM Sans', sans-serif;
}
.banner-date {
  position: relative;
  z-index: 1;
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 4px;
}
.banner-time {
  font-family: 'Cormorant Garamond', serif;
  font-size: 40px;
  font-weight: 700;
  color: rgba(201,168,76,0.5);
  line-height: 1;
  letter-spacing: -0.02em;
}
.banner-date-text {
  font-size: 10px;
  color: rgba(138,155,191,0.4);
  font-family: 'DM Mono', monospace;
  letter-spacing: 0.06em;
  text-align: right;
}

/* Stats grid */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 14px;
}

.stat-card {
  background: #fff;
  border: 1px solid rgba(11,28,56,0.07);
  padding: 22px 22px 18px;
  box-shadow: 0 2px 12px rgba(11,28,56,0.04);
  transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
  opacity: 0;
  transform: translateY(12px);
}
.stats-grid.visible .stat-card {
  opacity: 1;
  transform: translateY(0);
  transition: opacity 0.6s ease, transform 0.6s ease, border-color 0.25s, box-shadow 0.25s;
}
.stat-card:hover {
  border-color: rgba(201,168,76,0.3);
  transform: translateY(-3px);
  box-shadow: 0 8px 28px rgba(11,28,56,0.08);
}

.stat-card-top {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 12px;
}
.stat-label {
  font-size: 10px;
  font-weight: 600;
  color: #8a9bbf;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}
.stat-icon-wrap {
  width: 30px; height: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.icon-gold   { background: rgba(201,168,76,0.12); color: #c9a84c; }
.icon-blue   { background: rgba(41,128,185,0.1);  color: #2980b9; }
.icon-green  { background: rgba(39,174,96,0.1);   color: #27ae60; }
.icon-purple { background: rgba(142,68,173,0.1);  color: #8e44ad; }

.stat-value {
  font-family: 'Cormorant Garamond', serif;
  font-size: 36px;
  font-weight: 700;
  color: #0b1c38;
  line-height: 1;
  margin-bottom: 8px;
}
.stat-change {
  display: flex;
  align-items: center;
  gap: 5px;
  font-size: 11px;
  font-family: 'DM Sans', sans-serif;
}
.trend-up   { color: #27ae60; }
.trend-down { color: #e74c3c; }

/* Bottom grid */
.bottom-grid {
  display: grid;
  grid-template-columns: 1.4fr 1fr;
  gap: 14px;
}

.panel {
  background: #fff;
  border: 1px solid rgba(11,28,56,0.07);
  box-shadow: 0 2px 12px rgba(11,28,56,0.04);
  overflow: hidden;
}

.panel-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 18px 22px;
  border-bottom: 1px solid rgba(11,28,56,0.06);
}
.panel-header h3 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 18px;
  font-weight: 600;
  color: #0b1c38;
}
.panel-link {
  font-size: 10px;
  color: #c9a84c;
  text-decoration: none;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
  font-weight: 500;
  transition: color 0.2s;
}
.panel-link:hover { color: #e8cf8a; }

/* Activity list */
.activity-list {
  list-style: none;
  padding: 8px 0;
}
.activity-item {
  display: flex;
  align-items: flex-start;
  gap: 14px;
  padding: 12px 22px;
  border-bottom: 1px solid rgba(11,28,56,0.04);
  transition: background 0.2s;
}
.activity-item:last-child { border-bottom: none; }
.activity-item:hover { background: rgba(11,28,56,0.02); }

.activity-dot {
  width: 7px; height: 7px;
  border-radius: 50%;
  flex-shrink: 0;
  margin-top: 5px;
}
.dot-gold   { background: #c9a84c; }
.dot-blue   { background: #2980b9; }
.dot-green  { background: #27ae60; }
.dot-purple { background: #8e44ad; }

.activity-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 3px;
}
.activity-text {
  font-size: 13px;
  color: #3a4a62;
  font-family: 'DM Sans', sans-serif;
  line-height: 1.4;
}
.activity-time {
  font-size: 10px;
  color: #aab;
  font-family: 'DM Mono', monospace;
}

/* Quick actions */
.quick-actions {
  display: flex;
  flex-direction: column;
  padding: 8px 0;
}
.quick-action-btn {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 13px 22px;
  color: #3a4a62;
  text-decoration: none;
  font-size: 13px;
  font-family: 'DM Sans', sans-serif;
  border-bottom: 1px solid rgba(11,28,56,0.04);
  transition: background 0.2s, color 0.2s;
}
.quick-action-btn:last-child { border-bottom: none; }
.quick-action-btn:hover {
  background: rgba(201,168,76,0.05);
  color: #0b1c38;
}
.qa-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 28px; height: 28px;
  background: rgba(201,168,76,0.08);
  color: #c9a84c;
  flex-shrink: 0;
}
.qa-label { flex: 1; }
.qa-arrow {
  color: rgba(201,168,76,0.3);
  transition: color 0.2s, transform 0.2s;
}
.quick-action-btn:hover .qa-arrow {
  color: #c9a84c;
  transform: translateX(3px);
}

/* ── Responsive ───────────────────────────── */
@media (max-width: 1200px) {
  .stats-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 900px) {
  .bottom-grid { grid-template-columns: 1fr; }
  .banner-date { display: none; }
}
@media (max-width: 768px) {
  .admin-sidebar { width: 64px; }
  .sidebar-logo-label, .nav-label, .nav-badge, .nav-group-label, .btn-logout span { display: none; }
  .welcome-banner { padding: 24px 20px; }
  .welcome-banner, .stats-grid, .bottom-grid { margin-left: 16px; margin-right: 16px; }
  .admin-topbar { padding: 0 16px; }
  .topbar-live, .admin-info { display: none; }
}
</style>
