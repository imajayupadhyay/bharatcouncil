<template>
  <div class="admin-root">

    <!-- ══ Sidebar ══ -->
    <aside class="admin-sidebar" :class="{ collapsed: sidebarCollapsed }">
      <div class="sidebar-logo">
        <img :src="'/BGC.png'" alt="BGC" class="sidebar-logo-img" />
        <span v-if="!sidebarCollapsed" class="sidebar-logo-label">Admin</span>
      </div>
      <nav class="sidebar-nav">
        <div class="nav-group-label" v-if="!sidebarCollapsed">Overview</div>
        <Link v-for="item in navItems" :key="item.id" :href="item.href" class="nav-item" :title="sidebarCollapsed ? item.label : ''">
          <span class="nav-icon" v-html="item.icon"/>
          <span v-if="!sidebarCollapsed" class="nav-label">{{ item.label }}</span>
        </Link>
      </nav>
      <button class="sidebar-toggle" @click="sidebarCollapsed = !sidebarCollapsed">
        <svg viewBox="0 0 16 16" fill="none" width="14" height="14" :class="{ flipped: sidebarCollapsed }">
          <path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
      </button>
      <div class="sidebar-footer">
        <button type="button" class="btn-logout" @click="logout">
          <svg viewBox="0 0 16 16" fill="none" width="14" height="14">
            <path d="M6 3H3a1 1 0 00-1 1v8a1 1 0 001 1h3M10 5l3 3-3 3M13 8H6" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span v-if="!sidebarCollapsed">Logout</span>
        </button>
      </div>
    </aside>

    <!-- ══ Main content ══ -->
    <main class="admin-main">

      <!-- Top bar -->
      <header class="admin-topbar">
        <div class="topbar-left">
          <h2 class="topbar-title">Intern Application #{{ application.id }}</h2>
          <div class="topbar-breadcrumb">
            <span>Admin</span>
            <span class="bc-sep">›</span>
            <Link href="/admin/intern-applications" class="bc-link">Intern Applications</Link>
            <span class="bc-sep">›</span>
            <span class="bc-active">{{ application.full_name }}</span>
          </div>
        </div>
        <div class="topbar-right">
          <div class="topbar-live">
            <span class="live-dot"/>
            <span class="live-label">System Online</span>
          </div>
          <div class="topbar-admin">
            <div class="admin-avatar">{{ admin?.name?.charAt(0)?.toUpperCase() ?? 'A' }}</div>
            <div class="admin-info">
              <span class="admin-name">{{ admin?.name ?? 'Admin' }}</span>
              <span class="admin-email">{{ admin?.email ?? '' }}</span>
            </div>
          </div>
        </div>
      </header>

      <!-- Content -->
      <div class="content-wrap" :class="{ visible: mounted }">

        <!-- Back + Status controls -->
        <div class="action-bar">
          <Link href="/admin/intern-applications" class="btn-back">
            <svg viewBox="0 0 12 12" fill="none" width="10" height="10">
              <path d="M10 6H2M6 2L2 6l4 4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
            </svg>
            Back to Intern Applications
          </Link>
          <div class="status-controls">
            <span class="status-label">Status:</span>
            <div class="status-btns">
              <button
                v-for="s in statuses"
                :key="s.value"
                class="status-btn"
                :class="[`btn-${s.value}`, { active: application.status === s.value }]"
                @click="updateStatus(s.value)"
                :disabled="application.status === s.value"
              >{{ s.label }}</button>
            </div>
          </div>
        </div>

        <!-- Profile card -->
        <div class="card card-profile">
          <div class="card-header">
            <div class="profile-avatar">{{ application.full_name.charAt(0).toUpperCase() }}</div>
            <div class="profile-info">
              <h3 class="profile-name">{{ application.full_name }}</h3>
              <p class="profile-role">{{ application.institution }} · {{ application.programme }}</p>
              <p class="profile-city">{{ application.city }}</p>
            </div>
            <div class="profile-meta">
              <div class="meta-row">
                <span class="meta-key">Email</span>
                <a :href="`mailto:${application.email}`" class="meta-val meta-link">{{ application.email }}</a>
              </div>
              <div class="meta-row">
                <span class="meta-key">Phone</span>
                <span class="meta-val">{{ application.phone }}</span>
              </div>
              <div class="meta-row">
                <span class="meta-key">Discipline</span>
                <span class="meta-val">{{ application.discipline }}</span>
              </div>
              <div class="meta-row">
                <span class="meta-key">Graduation Year</span>
                <span class="meta-val">{{ application.grad_year }}</span>
              </div>
              <div class="meta-row">
                <span class="meta-key">Applied</span>
                <span class="meta-val">{{ formatDate(application.created_at) }}</span>
              </div>
              <div class="meta-row">
                <span class="meta-key">Status</span>
                <span class="status-badge" :class="`badge-${application.status}`">{{ application.status }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Details grid -->
        <div class="sections-grid">

          <!-- Internship Preferences -->
          <div class="card">
            <div class="section-label">Internship Preferences</div>
            <div class="pref-grid">
              <div class="pref-item">
                <span class="pref-key">Research Track</span>
                <span class="pref-val">{{ application.track }}</span>
              </div>
              <div class="pref-item">
                <span class="pref-key">Cohort</span>
                <span class="pref-val">{{ application.cohort }}</span>
              </div>
              <div class="pref-item">
                <span class="pref-key">Mode</span>
                <span class="pref-val">{{ application.mode }}</span>
              </div>
              <div class="pref-item">
                <span class="pref-key">Duration</span>
                <span class="pref-val">{{ application.duration }}</span>
              </div>
            </div>
          </div>

          <!-- Statement -->
          <div class="card span-full">
            <div class="section-label">Statement</div>
            <p class="section-text">{{ application.statement }}</p>
          </div>

          <!-- Governance Problem -->
          <div class="card span-full" v-if="application.governance_problem">
            <div class="section-label">Governance Problem</div>
            <p class="section-text">{{ application.governance_problem }}</p>
          </div>

        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
  admin:       Object,
  application: Object,
})

const mounted          = ref(false)
const sidebarCollapsed = ref(false)

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

const statuses = [
  { value: 'pending',     label: 'Pending' },
  { value: 'reviewed',    label: 'Reviewed' },
  { value: 'shortlisted', label: 'Shortlisted' },
  { value: 'rejected',    label: 'Rejected' },
]

function formatDate(dateStr) {
  return new Date(dateStr).toLocaleDateString('en-IN', { day: 'numeric', month: 'long', year: 'numeric' })
}

function updateStatus(status) {
  router.patch(`/admin/intern-applications/${props.application.id}/status`, { status })
}

function logout() {
  router.post('/admin/logout')
}

onMounted(() => {
  requestAnimationFrame(() => setTimeout(() => { mounted.value = true }, 80))
})
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap');
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'DM Sans', sans-serif; background: #f2f4f8; }
</style>

<style scoped>
.admin-root { display: flex; min-height: 100vh; background: #f2f4f8; }

/* ── Sidebar ── */
.admin-sidebar {
  width: 240px; flex-shrink: 0; background: #0b1c38;
  display: flex; flex-direction: column;
  border-right: 1px solid rgba(201,168,76,0.12);
  transition: width 0.3s cubic-bezier(0.4,0,0.2,1);
  position: sticky; top: 0; height: 100vh; overflow: hidden;
}
.admin-sidebar.collapsed { width: 64px; }
.sidebar-logo { display: flex; align-items: center; gap: 12px; padding: 20px 18px; border-bottom: 1px solid rgba(255,255,255,0.06); flex-shrink: 0; }
.sidebar-logo-img { width: 44px; height: auto; object-fit: contain; flex-shrink: 0; }
.sidebar-logo-label { font-size: 9px; font-weight: 700; color: #c9a84c; letter-spacing: 0.3em; text-transform: uppercase; font-family: 'DM Mono', monospace; white-space: nowrap; }
.sidebar-nav { flex: 1; padding: 20px 10px; display: flex; flex-direction: column; gap: 2px; overflow-y: auto; overflow-x: hidden; }
.nav-group-label { font-size: 8px; font-weight: 700; color: rgba(138,155,191,0.35); letter-spacing: 0.3em; text-transform: uppercase; font-family: 'DM Sans', sans-serif; padding: 0 8px; margin-bottom: 6px; white-space: nowrap; }
.nav-item { display: flex; align-items: center; gap: 12px; padding: 10px 12px; color: #8a9bbf; text-decoration: none; font-size: 13px; font-weight: 500; font-family: 'DM Sans', sans-serif; position: relative; transition: color 0.2s, background 0.2s; white-space: nowrap; overflow: hidden; }
.nav-item::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 2px; background: linear-gradient(to bottom, #c9a84c, #e8cf8a); transform: scaleY(0); transition: transform 0.25s; }
.nav-item:hover { color: #e8cf8a; background: rgba(255,255,255,0.04); }
.nav-item.active { color: #e8cf8a; background: rgba(201,168,76,0.08); }
.nav-item.active::before { transform: scaleY(1); }
.nav-icon { display: flex; align-items: center; justify-content: center; flex-shrink: 0; width: 16px; }
.nav-label { flex: 1; }
.sidebar-toggle { display: flex; align-items: center; justify-content: center; width: 100%; padding: 12px; background: none; border: none; border-top: 1px solid rgba(255,255,255,0.05); color: rgba(138,155,191,0.4); cursor: pointer; transition: color 0.2s; flex-shrink: 0; }
.sidebar-toggle:hover { color: #c9a84c; }
.sidebar-toggle svg { transition: transform 0.3s; }
.sidebar-toggle svg.flipped { transform: rotate(180deg); }
.sidebar-footer { padding: 12px 10px; border-top: 1px solid rgba(255,255,255,0.05); flex-shrink: 0; }
.btn-logout { display: flex; align-items: center; gap: 10px; width: 100%; padding: 10px 12px; background: none; border: none; color: rgba(138,155,191,0.5); font-size: 13px; font-family: 'DM Sans', sans-serif; cursor: pointer; white-space: nowrap; overflow: hidden; transition: color 0.2s, background 0.2s; }
.btn-logout:hover { color: #e74c3c; background: rgba(231,76,60,0.08); }

/* ── Main ── */
.admin-main { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
.admin-topbar { display: flex; align-items: center; justify-content: space-between; padding: 0 32px; height: 64px; background: #fff; border-bottom: 1px solid rgba(11,28,56,0.07); flex-shrink: 0; gap: 20px; }
.topbar-left { display: flex; flex-direction: column; gap: 2px; }
.topbar-title { font-family: 'Cormorant Garamond', serif; font-size: 20px; font-weight: 600; color: #0b1c38; line-height: 1; }
.topbar-breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 10px; color: #8a9bbf; font-family: 'DM Mono', monospace; letter-spacing: 0.06em; }
.bc-sep { color: rgba(201,168,76,0.4); }
.bc-active { color: #c9a84c; }
.bc-link { color: #8a9bbf; text-decoration: none; transition: color 0.2s; }
.bc-link:hover { color: #c9a84c; }
.topbar-right { display: flex; align-items: center; gap: 20px; }
.topbar-live { display: flex; align-items: center; gap: 7px; }
.live-dot { width: 7px; height: 7px; border-radius: 50%; background: #2ecc71; position: relative; }
.live-dot::before { content: ''; position: absolute; inset: -3px; border-radius: 50%; background: rgba(46,204,113,0.25); animation: livePulse 1.8s ease-out infinite; }
@keyframes livePulse { 0% { transform: scale(0.8); opacity: 1; } 100% { transform: scale(2.2); opacity: 0; } }
.live-label { font-size: 10px; color: rgba(46,204,113,0.7); font-family: 'DM Mono', monospace; letter-spacing: 0.06em; }
.topbar-admin { display: flex; align-items: center; gap: 10px; }
.admin-avatar { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #c9a84c, #e8cf8a); display: flex; align-items: center; justify-content: center; font-family: 'Cormorant Garamond', serif; font-size: 16px; font-weight: 700; color: #0b1c38; flex-shrink: 0; }
.admin-info { display: flex; flex-direction: column; gap: 1px; }
.admin-name { font-size: 13px; font-weight: 500; color: #0b1c38; font-family: 'DM Sans', sans-serif; text-transform: capitalize; }
.admin-email { font-size: 10px; color: #8a9bbf; font-family: 'DM Mono', monospace; }

/* ── Content ── */
.content-wrap { flex: 1; padding: 28px; overflow-y: auto; opacity: 0; transform: translateY(16px); transition: opacity 0.6s ease, transform 0.6s ease; }
.content-wrap.visible { opacity: 1; transform: translateY(0); }

/* Action bar */
.action-bar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
.btn-back { display: inline-flex; align-items: center; gap: 8px; padding: 9px 18px; background: #fff; border: 1px solid rgba(11,28,56,0.1); text-decoration: none; font-size: 10px; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; font-family: 'DM Mono', monospace; color: #8a9bbf; transition: all 0.2s; }
.btn-back:hover { border-color: #0b1c38; color: #0b1c38; }

.status-controls { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.status-label { font-size: 9px; font-weight: 700; letter-spacing: 0.2em; text-transform: uppercase; color: #8a9bbf; font-family: 'DM Mono', monospace; }
.status-btns { display: flex; gap: 4px; }
.status-btn { padding: 7px 14px; border: 1px solid rgba(11,28,56,0.1); background: #fff; font-size: 9px; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; font-family: 'DM Mono', monospace; cursor: pointer; transition: all 0.2s; color: #8a9bbf; }
.status-btn:hover:not(:disabled) { border-color: currentColor; }
.status-btn:disabled { opacity: 0.5; cursor: default; }
.status-btn.active { color: #fff; }
.btn-pending.active     { background: #c9a84c; border-color: #c9a84c; color: #0b1c38; }
.btn-reviewed.active    { background: #2980b9; border-color: #2980b9; }
.btn-shortlisted.active { background: #27ae60; border-color: #27ae60; }
.btn-rejected.active    { background: #e74c3c; border-color: #e74c3c; }

/* Cards */
.card { background: #fff; border: 1px solid rgba(11,28,56,0.07); box-shadow: 0 2px 12px rgba(11,28,56,0.04); padding: 28px; margin-bottom: 16px; }
.card-profile { padding: 0; }
.card-header { display: flex; align-items: flex-start; gap: 24px; padding: 28px; flex-wrap: wrap; }

.profile-avatar { width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, #0b1c38, #1e3a66); display: flex; align-items: center; justify-content: center; font-family: 'Cormorant Garamond', serif; font-size: 28px; font-weight: 700; color: #c9a84c; flex-shrink: 0; }
.profile-info { flex: 1; min-width: 160px; }
.profile-name { font-family: 'Cormorant Garamond', serif; font-size: 24px; font-weight: 600; color: #0b1c38; margin-bottom: 4px; }
.profile-role { font-size: 13px; color: #3a4a62; margin-bottom: 2px; }
.profile-city { font-size: 12px; color: #8a9bbf; font-family: 'DM Mono', monospace; }

.profile-meta { display: flex; flex-direction: column; gap: 10px; min-width: 220px; }
.meta-row { display: flex; align-items: flex-start; gap: 10px; }
.meta-key { font-size: 9px; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: #b8c5d8; font-family: 'DM Mono', monospace; min-width: 130px; padding-top: 2px; }
.meta-val { font-size: 12px; color: #3a4a62; font-family: 'DM Sans', sans-serif; line-height: 1.5; }
.meta-link { color: #c9a84c; text-decoration: none; }
.meta-link:hover { text-decoration: underline; }

/* Sections grid */
.sections-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.span-full { grid-column: 1 / -1; }

.section-label { font-size: 9px; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: #c9a84c; font-family: 'DM Mono', monospace; margin-bottom: 14px; }
.section-text { font-size: 14px; color: #3a4a62; line-height: 1.75; font-family: 'DM Sans', sans-serif; white-space: pre-wrap; }

/* Preferences grid */
.pref-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.pref-item { display: flex; flex-direction: column; gap: 4px; }
.pref-key { font-size: 9px; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: #b8c5d8; font-family: 'DM Mono', monospace; }
.pref-val { font-size: 13px; color: #3a4a62; font-family: 'DM Sans', sans-serif; }

/* Status badge */
.status-badge { display: inline-block; padding: 3px 10px; font-size: 9px; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; font-family: 'DM Mono', monospace; }
.badge-pending    { background: rgba(201,168,76,0.12); color: #c9a84c; }
.badge-reviewed   { background: rgba(41,128,185,0.1);  color: #2980b9; }
.badge-shortlisted{ background: rgba(39,174,96,0.12);  color: #27ae60; }
.badge-rejected   { background: rgba(231,76,60,0.1);   color: #e74c3c; }

@media (max-width: 900px) { .sections-grid { grid-template-columns: 1fr; } .span-full { grid-column: 1; } .pref-grid { grid-template-columns: 1fr; } }
@media (max-width: 768px) {
  .admin-sidebar { width: 64px; }
  .sidebar-logo-label, .nav-label, .btn-logout span { display: none; }
  .content-wrap { padding: 16px; }
  .admin-topbar { padding: 0 16px; }
  .topbar-live, .admin-info { display: none; }
  .card-header { flex-direction: column; }
}
</style>
