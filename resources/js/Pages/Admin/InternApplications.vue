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
        <Link
          v-for="item in navItems"
          :key="item.id"
          :href="item.href"
          class="nav-item"
          :class="{ active: item.id === 'internships' }"
          :title="sidebarCollapsed ? item.label : ''"
        >
          <span class="nav-icon" v-html="item.icon"/>
          <span v-if="!sidebarCollapsed" class="nav-label">{{ item.label }}</span>
          <span v-if="!sidebarCollapsed && item.badge" class="nav-badge">{{ item.badge }}</span>
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
          <h2 class="topbar-title">Intern Applications</h2>
          <div class="topbar-breadcrumb">
            <span>Admin</span>
            <span class="bc-sep">›</span>
            <span class="bc-active">Intern Applications</span>
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

        <!-- Filter bar -->
        <div class="filter-bar">
          <div class="filter-tabs">
            <button
              v-for="f in filterOptions"
              :key="f.value"
              class="filter-tab"
              :class="{ active: currentFilter === f.value }"
              @click="setFilter(f.value)"
            >
              {{ f.label }}
              <span class="filter-count">{{ statusCount(f.value) }}</span>
            </button>
          </div>
          <div class="total-badge">
            <svg viewBox="0 0 14 14" fill="none" width="12" height="12">
              <path d="M7 1C3.69 1 1 3.69 1 7s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm0 2.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm0 8a4.5 4.5 0 01-3.75-2.02c.02-.99 2.5-1.53 3.75-1.53s3.73.54 3.75 1.53A4.5 4.5 0 017 11.5z" fill="currentColor"/>
            </svg>
            {{ applications.total }} total
          </div>
        </div>

        <!-- Table -->
        <div class="table-panel">
          <table class="app-table" v-if="filteredData.length > 0">
            <thead>
              <tr>
                <th>#</th>
                <th>Applicant</th>
                <th>Institution</th>
                <th>Track</th>
                <th>Cohort</th>
                <th>Submitted</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="app in filteredData" :key="app.id" class="app-row">
                <td class="td-id">{{ app.id }}</td>
                <td class="td-applicant">
                  <div class="app-avatar">{{ app.full_name.charAt(0).toUpperCase() }}</div>
                  <div class="app-meta">
                    <span class="app-name">{{ app.full_name }}</span>
                    <span class="app-email">{{ app.email }}</span>
                  </div>
                </td>
                <td class="td-inst">{{ app.institution }}</td>
                <td class="td-track">{{ app.track }}</td>
                <td class="td-cohort">{{ app.cohort }}</td>
                <td class="td-date">{{ formatDate(app.created_at) }}</td>
                <td class="td-status">
                  <span class="status-badge" :class="`badge-${app.status}`">{{ app.status }}</span>
                </td>
                <td class="td-action">
                  <Link :href="`/admin/intern-applications/${app.id}`" class="btn-view">
                    View
                    <svg viewBox="0 0 12 12" fill="none" width="10" height="10">
                      <path d="M2 6h8M6 2l4 4-4 4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                    </svg>
                  </Link>
                </td>
              </tr>
            </tbody>
          </table>

          <!-- Empty state -->
          <div v-else class="empty-state">
            <svg viewBox="0 0 48 48" fill="none" width="48" height="48">
              <rect x="8" y="6" width="32" height="36" rx="2" stroke="#c9a84c" stroke-width="1.5" opacity="0.3"/>
              <path d="M16 16h16M16 22h16M16 28h10" stroke="#c9a84c" stroke-width="1.5" stroke-linecap="round" opacity="0.3"/>
            </svg>
            <p>No intern applications found{{ currentFilter !== 'all' ? ` with status "${currentFilter}"` : '' }}.</p>
          </div>
        </div>

        <!-- Pagination -->
        <div class="pagination" v-if="applications.last_page > 1">
          <Link
            v-for="page in applications.last_page"
            :key="page"
            :href="`/admin/intern-applications?page=${page}${currentFilter !== 'all' ? '&status=' + currentFilter : ''}`"
            class="page-btn"
            :class="{ active: applications.current_page === page }"
          >{{ page }}</Link>
        </div>

      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
  admin:        Object,
  applications: Object,
  filters:      Object,
})

const mounted          = ref(false)
const sidebarCollapsed = ref(false)
const currentFilter    = ref(props.filters?.status ?? 'all')

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

const filterOptions = [
  { value: 'all',        label: 'All' },
  { value: 'pending',    label: 'Pending' },
  { value: 'reviewed',   label: 'Reviewed' },
  { value: 'shortlisted', label: 'Shortlisted' },
  { value: 'rejected',   label: 'Rejected' },
]

const filteredData = computed(() => props.applications.data ?? [])

function statusCount(status) {
  if (status === 'all') return props.applications.total ?? 0
  return (props.applications.data ?? []).filter(a => a.status === status).length
}

function setFilter(status) {
  currentFilter.value = status
  const params = status !== 'all' ? { status } : {}
  router.get('/admin/intern-applications', params, { preserveState: true, replace: true })
}

function formatDate(dateStr) {
  return new Date(dateStr).toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' })
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
  width: 240px; flex-shrink: 0;
  background: #0b1c38;
  display: flex; flex-direction: column;
  border-right: 1px solid rgba(201,168,76,0.12);
  transition: width 0.3s cubic-bezier(0.4,0,0.2,1);
  position: sticky; top: 0; height: 100vh; overflow: hidden;
}
.admin-sidebar.collapsed { width: 64px; }

.sidebar-logo {
  display: flex; align-items: center; gap: 12px;
  padding: 20px 18px;
  border-bottom: 1px solid rgba(255,255,255,0.06); flex-shrink: 0;
}
.sidebar-logo-img { width: 44px; height: auto; object-fit: contain; flex-shrink: 0; }
.sidebar-logo-label {
  font-size: 9px; font-weight: 700; color: #c9a84c;
  letter-spacing: 0.3em; text-transform: uppercase;
  font-family: 'DM Mono', monospace; white-space: nowrap;
}

.sidebar-nav {
  flex: 1; padding: 20px 10px;
  display: flex; flex-direction: column; gap: 2px;
  overflow-y: auto; overflow-x: hidden;
}
.nav-group-label {
  font-size: 8px; font-weight: 700;
  color: rgba(138,155,191,0.35); letter-spacing: 0.3em; text-transform: uppercase;
  font-family: 'DM Sans', sans-serif; padding: 0 8px; margin-bottom: 6px; white-space: nowrap;
}
.nav-item {
  display: flex; align-items: center; gap: 12px; padding: 10px 12px;
  color: #8a9bbf; text-decoration: none;
  font-size: 13px; font-weight: 500; font-family: 'DM Sans', sans-serif;
  position: relative; transition: color 0.2s, background 0.2s;
  white-space: nowrap; overflow: hidden;
}
.nav-item::before {
  content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 2px;
  background: linear-gradient(to bottom, #c9a84c, #e8cf8a); transform: scaleY(0);
  transition: transform 0.25s;
}
.nav-item:hover { color: #e8cf8a; background: rgba(255,255,255,0.04); }
.nav-item.active { color: #e8cf8a; background: rgba(201,168,76,0.08); }
.nav-item.active::before { transform: scaleY(1); }
.nav-icon { display: flex; align-items: center; justify-content: center; flex-shrink: 0; width: 16px; }
.nav-label { flex: 1; }
.nav-badge {
  font-size: 9px; font-family: 'DM Mono', monospace;
  color: #c9a84c; background: rgba(201,168,76,0.15); padding: 2px 6px; border-radius: 10px; flex-shrink: 0;
}

.sidebar-toggle {
  display: flex; align-items: center; justify-content: center;
  width: 100%; padding: 12px; background: none; border: none;
  border-top: 1px solid rgba(255,255,255,0.05);
  color: rgba(138,155,191,0.4); cursor: pointer; transition: color 0.2s; flex-shrink: 0;
}
.sidebar-toggle:hover { color: #c9a84c; }
.sidebar-toggle svg { transition: transform 0.3s; }
.sidebar-toggle svg.flipped { transform: rotate(180deg); }

.sidebar-footer { padding: 12px 10px; border-top: 1px solid rgba(255,255,255,0.05); flex-shrink: 0; }
.btn-logout {
  display: flex; align-items: center; gap: 10px; width: 100%; padding: 10px 12px;
  background: none; border: none; color: rgba(138,155,191,0.5);
  font-size: 13px; font-family: 'DM Sans', sans-serif; cursor: pointer;
  white-space: nowrap; overflow: hidden; transition: color 0.2s, background 0.2s;
}
.btn-logout:hover { color: #e74c3c; background: rgba(231,76,60,0.08); }

/* ── Main ── */
.admin-main { flex: 1; display: flex; flex-direction: column; overflow: hidden; }

.admin-topbar {
  display: flex; align-items: center; justify-content: space-between;
  padding: 0 32px; height: 64px; background: #fff;
  border-bottom: 1px solid rgba(11,28,56,0.07); flex-shrink: 0; gap: 20px;
}
.topbar-left { display: flex; flex-direction: column; gap: 2px; }
.topbar-title { font-family: 'Cormorant Garamond', serif; font-size: 20px; font-weight: 600; color: #0b1c38; line-height: 1; }
.topbar-breadcrumb {
  display: flex; align-items: center; gap: 6px;
  font-size: 10px; color: #8a9bbf; font-family: 'DM Mono', monospace; letter-spacing: 0.06em;
}
.bc-sep { color: rgba(201,168,76,0.4); }
.bc-active { color: #c9a84c; }
.topbar-right { display: flex; align-items: center; gap: 20px; }
.topbar-live { display: flex; align-items: center; gap: 7px; }
.live-dot { width: 7px; height: 7px; border-radius: 50%; background: #2ecc71; position: relative; }
.live-dot::before {
  content: ''; position: absolute; inset: -3px; border-radius: 50%;
  background: rgba(46,204,113,0.25); animation: livePulse 1.8s ease-out infinite;
}
@keyframes livePulse { 0% { transform: scale(0.8); opacity: 1; } 100% { transform: scale(2.2); opacity: 0; } }
.live-label { font-size: 10px; color: rgba(46,204,113,0.7); font-family: 'DM Mono', monospace; letter-spacing: 0.06em; }
.topbar-admin { display: flex; align-items: center; gap: 10px; }
.admin-avatar {
  width: 36px; height: 36px; border-radius: 50%;
  background: linear-gradient(135deg, #c9a84c, #e8cf8a);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Cormorant Garamond', serif; font-size: 16px; font-weight: 700; color: #0b1c38; flex-shrink: 0;
}
.admin-info { display: flex; flex-direction: column; gap: 1px; }
.admin-name { font-size: 13px; font-weight: 500; color: #0b1c38; font-family: 'DM Sans', sans-serif; text-transform: capitalize; }
.admin-email { font-size: 10px; color: #8a9bbf; font-family: 'DM Mono', monospace; }

/* ── Content ── */
.content-wrap {
  flex: 1; padding: 28px; overflow-y: auto;
  opacity: 0; transform: translateY(16px);
  transition: opacity 0.6s ease, transform 0.6s ease;
}
.content-wrap.visible { opacity: 1; transform: translateY(0); }

/* Filter bar */
.filter-bar {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 20px; gap: 16px; flex-wrap: wrap;
}
.filter-tabs { display: flex; gap: 4px; }
.filter-tab {
  display: flex; align-items: center; gap: 8px;
  padding: 8px 16px; background: #fff; border: 1px solid rgba(11,28,56,0.08);
  font-size: 11px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase;
  color: #8a9bbf; font-family: 'DM Mono', monospace; cursor: pointer;
  transition: all 0.2s;
}
.filter-tab:hover { border-color: rgba(201,168,76,0.3); color: #0b1c38; }
.filter-tab.active { background: #0b1c38; color: #e8cf8a; border-color: #0b1c38; }
.filter-count {
  font-size: 9px; background: rgba(201,168,76,0.15); color: #c9a84c;
  padding: 1px 6px; border-radius: 8px; font-family: 'DM Mono', monospace;
}
.filter-tab.active .filter-count { background: rgba(201,168,76,0.2); }
.total-badge {
  display: flex; align-items: center; gap: 6px;
  font-size: 11px; color: #8a9bbf; font-family: 'DM Mono', monospace;
}

/* Table */
.table-panel {
  background: #fff; border: 1px solid rgba(11,28,56,0.07);
  box-shadow: 0 2px 12px rgba(11,28,56,0.04); overflow: hidden;
}
.app-table { width: 100%; border-collapse: collapse; }
.app-table thead tr { border-bottom: 2px solid rgba(11,28,56,0.06); }
.app-table th {
  padding: 14px 16px; text-align: left;
  font-size: 9px; font-weight: 700; letter-spacing: 0.2em; text-transform: uppercase;
  color: #8a9bbf; font-family: 'DM Mono', monospace; white-space: nowrap;
}
.app-row { border-bottom: 1px solid rgba(11,28,56,0.04); transition: background 0.2s; }
.app-row:last-child { border-bottom: none; }
.app-row:hover { background: rgba(11,28,56,0.02); }
.app-table td { padding: 14px 16px; font-family: 'DM Sans', sans-serif; font-size: 13px; color: #3a4a62; }

.td-id { font-family: 'DM Mono', monospace; font-size: 11px; color: #b8c5d8; width: 40px; }
.td-applicant { display: flex; align-items: center; gap: 12px; min-width: 200px; }
.app-avatar {
  width: 32px; height: 32px; border-radius: 50%;
  background: linear-gradient(135deg, #0b1c38, #1e3a66);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Cormorant Garamond', serif; font-size: 14px; font-weight: 700;
  color: #c9a84c; flex-shrink: 0;
}
.app-meta { display: flex; flex-direction: column; gap: 2px; }
.app-name { font-weight: 500; color: #0b1c38; }
.app-email { font-size: 11px; color: #8a9bbf; font-family: 'DM Mono', monospace; }
.td-inst { font-size: 12px; max-width: 180px; line-height: 1.4; }
.td-track { font-size: 12px; max-width: 180px; line-height: 1.4; }
.td-cohort { font-size: 12px; white-space: nowrap; }
.td-date { font-size: 11px; font-family: 'DM Mono', monospace; color: #8a9bbf; white-space: nowrap; }

/* Status badges */
.status-badge {
  display: inline-block; padding: 3px 10px; border-radius: 2px;
  font-size: 9px; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase;
  font-family: 'DM Mono', monospace;
}
.badge-pending    { background: rgba(201,168,76,0.12); color: #c9a84c; }
.badge-reviewed   { background: rgba(41,128,185,0.1);  color: #2980b9; }
.badge-shortlisted{ background: rgba(39,174,96,0.12);  color: #27ae60; }
.badge-rejected   { background: rgba(231,76,60,0.1);   color: #e74c3c; }

.btn-view {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 7px 14px; background: #0b1c38;
  color: #f5f7fa; text-decoration: none;
  font-size: 9px; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase;
  font-family: 'DM Mono', monospace; transition: background 0.2s;
}
.btn-view:hover { background: #c9a84c; color: #0b1c38; }

/* Empty state */
.empty-state {
  display: flex; flex-direction: column; align-items: center;
  justify-content: center; gap: 16px; padding: 80px 32px;
  color: #b8c5d8; font-size: 14px; font-family: 'DM Sans', sans-serif;
}

/* Pagination */
.pagination { display: flex; gap: 4px; margin-top: 16px; justify-content: center; }
.page-btn {
  display: flex; align-items: center; justify-content: center;
  width: 36px; height: 36px; background: #fff;
  border: 1px solid rgba(11,28,56,0.08); text-decoration: none;
  font-size: 12px; font-family: 'DM Mono', monospace; color: #8a9bbf;
  transition: all 0.2s;
}
.page-btn:hover { border-color: rgba(201,168,76,0.3); color: #0b1c38; }
.page-btn.active { background: #0b1c38; color: #e8cf8a; border-color: #0b1c38; }

@media (max-width: 768px) {
  .admin-sidebar { width: 64px; }
  .sidebar-logo-label, .nav-label, .nav-badge, .nav-group-label, .btn-logout span { display: none; }
  .content-wrap { padding: 16px; }
  .admin-topbar { padding: 0 16px; }
  .topbar-live, .admin-info { display: none; }
  .app-table { display: block; overflow-x: auto; }
}
</style>
