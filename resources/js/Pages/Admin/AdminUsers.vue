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
          v-for="item in navItems" :key="item.id"
          :href="item.href" class="nav-item"
          :class="{ active: item.id === 'admin-users' }"
          :title="sidebarCollapsed ? item.label : ''"
        >
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
          <h2 class="topbar-title">Admin Users</h2>
          <div class="topbar-breadcrumb">
            <span>Admin</span>
            <span class="bc-sep">›</span>
            <span class="bc-active">Users</span>
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

        <!-- Flash messages -->
        <div v-if="$page.props.flash?.success" class="flash flash-success">
          <svg viewBox="0 0 16 16" fill="none" width="14" height="14">
            <path d="M3 8l3.5 3.5L13 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          {{ $page.props.flash.success }}
        </div>
        <div v-if="$page.props.flash?.error" class="flash flash-error">
          <svg viewBox="0 0 16 16" fill="none" width="14" height="14">
            <path d="M8 3v5M8 11v1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
          </svg>
          {{ $page.props.flash.error }}
        </div>

        <!-- Header row -->
        <div class="page-header">
          <div class="page-header-left">
            <div class="stat-pill">
              <svg viewBox="0 0 16 16" fill="none" width="14" height="14">
                <circle cx="6" cy="5" r="2.5" stroke="#c9a84c" stroke-width="1.2"/>
                <path d="M1 13.5c0-2.76 2.24-5 5-5s5 2.24 5 5" stroke="#c9a84c" stroke-width="1.2" stroke-linecap="round"/>
                <path d="M12 8v4M10 10h4" stroke="#c9a84c" stroke-width="1.2" stroke-linecap="round"/>
              </svg>
              <span class="stat-num">{{ users.total }}</span>
              <span class="stat-lbl">Total Admin Users</span>
            </div>
          </div>
          <div class="page-header-right">
            <Link href="/admin/admin-users/create" class="btn-create">
              <svg viewBox="0 0 14 14" fill="none" width="12" height="12">
                <path d="M7 1v12M1 7h12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
              </svg>
              Add New User
            </Link>
          </div>
        </div>

        <!-- Search bar -->
        <form class="search-bar" @submit.prevent="applySearch">
          <svg viewBox="0 0 16 16" fill="none" width="14" height="14" class="search-icon">
            <circle cx="6.5" cy="6.5" r="4" stroke="currentColor" stroke-width="1.3"/>
            <path d="M10 10l3.5 3.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
          </svg>
          <input
            v-model="searchQuery"
            type="text"
            class="search-input"
            placeholder="Search by name or email…"
          />
          <button v-if="searchQuery" type="button" class="search-clear" @click="clearSearch">
            <svg viewBox="0 0 12 12" fill="none" width="10" height="10">
              <path d="M2 2l8 8M10 2L2 10" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
            </svg>
          </button>
        </form>

        <!-- Table -->
        <div class="table-panel">
          <table class="users-table" v-if="users.data.length > 0">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created</th>
                <th>You</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in users.data" :key="user.id" class="user-row">
                <td class="td-id">{{ user.id }}</td>
                <td class="td-name">
                  <div class="user-avatar-sm">{{ user.name.charAt(0).toUpperCase() }}</div>
                  <span>{{ user.name }}</span>
                </td>
                <td class="td-email">
                  <svg viewBox="0 0 14 14" fill="none" width="12" height="12" class="email-icon">
                    <path d="M1 3.5l6 4 6-4M1 3.5h12v8H1v-8Z" stroke="currentColor" stroke-width="1.1" stroke-linejoin="round"/>
                  </svg>
                  {{ user.email }}
                </td>
                <td class="td-date">{{ formatDate(user.created_at) }}</td>
                <td class="td-you">
                  <span v-if="user.id === admin.id" class="you-badge">You</span>
                </td>
                <td class="td-actions">
                  <Link :href="`/admin/admin-users/${user.id}/edit`" class="btn-action btn-edit" title="Edit">
                    <svg viewBox="0 0 14 14" fill="none" width="12" height="12">
                      <path d="M9.5 2.5l2 2L4 12H2v-2L9.5 2.5z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Edit
                  </Link>
                  <button
                    v-if="user.id !== admin.id"
                    class="btn-action btn-delete"
                    title="Delete"
                    @click="confirmDelete(user)"
                  >
                    <svg viewBox="0 0 14 14" fill="none" width="12" height="12">
                      <path d="M2 4h10M5 4V2.5h4V4M5.5 6.5v4M8.5 6.5v4M3 4l.7 7.5h6.6L11 4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

          <div v-else class="empty-state">
            <svg viewBox="0 0 48 48" fill="none" width="48" height="48">
              <circle cx="20" cy="18" r="8" stroke="#c9a84c" stroke-width="1.5" opacity="0.3"/>
              <path d="M4 42c0-8.84 7.16-16 16-16s16 7.16 16 16" stroke="#c9a84c" stroke-width="1.5" stroke-linecap="round" opacity="0.3"/>
              <path d="M36 28v12M30 34h12" stroke="#c9a84c" stroke-width="1.5" stroke-linecap="round" opacity="0.3"/>
            </svg>
            <p>No admin users found{{ filters.search ? ` matching "${filters.search}"` : '' }}.</p>
          </div>
        </div>

        <!-- Pagination -->
        <div class="pagination" v-if="users.last_page > 1">
          <Link
            v-for="page in users.last_page" :key="page"
            :href="`/admin/admin-users?page=${page}${filters.search ? '&search=' + filters.search : ''}`"
            class="page-btn"
            :class="{ active: users.current_page === page }"
          >{{ page }}</Link>
        </div>

      </div>
    </main>

    <!-- Delete confirmation modal -->
    <Transition name="modal">
      <div v-if="deleteTarget" class="modal-overlay" @click.self="deleteTarget = null">
        <div class="modal-box">
          <div class="modal-icon">
            <svg viewBox="0 0 24 24" fill="none" width="28" height="28">
              <path d="M12 9v4M12 17v.5M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" stroke="#e74c3c" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <h3 class="modal-title">Delete Admin User</h3>
          <p class="modal-text">
            Are you sure you want to delete <strong>{{ deleteTarget?.name }}</strong>?
            This action cannot be undone.
          </p>
          <div class="modal-actions">
            <button class="btn-cancel" @click="deleteTarget = null">Cancel</button>
            <button class="btn-confirm-delete" @click="executeDelete">Delete</button>
          </div>
        </div>
      </div>
    </Transition>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
  admin:   Object,
  users:   Object,
  filters: Object,
})

const mounted          = ref(false)
const sidebarCollapsed = ref(false)
const searchQuery      = ref(props.filters?.search ?? '')
const deleteTarget     = ref(null)

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

function applySearch() {
  const params = searchQuery.value ? { search: searchQuery.value } : {}
  router.get('/admin/admin-users', params, { preserveState: true, replace: true })
}

function clearSearch() {
  searchQuery.value = ''
  router.get('/admin/admin-users', {}, { preserveState: true, replace: true })
}

function formatDate(dateStr) {
  return new Date(dateStr).toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' })
}

function confirmDelete(user) {
  deleteTarget.value = user
}

function executeDelete() {
  if (!deleteTarget.value) return
  router.delete(`/admin/admin-users/${deleteTarget.value.id}`, {
    onFinish: () => { deleteTarget.value = null },
  })
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
.admin-sidebar { width: 240px; flex-shrink: 0; background: #0b1c38; display: flex; flex-direction: column; border-right: 1px solid rgba(201,168,76,0.12); transition: width 0.3s cubic-bezier(0.4,0,0.2,1); position: sticky; top: 0; height: 100vh; overflow: hidden; }
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

/* Flash */
.flash { display: flex; align-items: center; gap: 10px; padding: 12px 18px; margin-bottom: 20px; font-size: 13px; font-family: 'DM Sans', sans-serif; border-left: 3px solid; }
.flash-success { background: rgba(39,174,96,0.08); color: #27ae60; border-color: #27ae60; }
.flash-error   { background: rgba(231,76,60,0.08);  color: #e74c3c; border-color: #e74c3c; }

/* Page header */
.page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; gap: 16px; flex-wrap: wrap; }
.page-header-left { display: flex; align-items: center; gap: 12px; }

/* Stat pill */
.stat-pill { display: flex; align-items: center; gap: 10px; background: #fff; border: 1px solid rgba(11,28,56,0.07); padding: 14px 20px; box-shadow: 0 2px 12px rgba(11,28,56,0.04); }
.stat-num { font-family: 'Cormorant Garamond', serif; font-size: 28px; font-weight: 700; color: #0b1c38; line-height: 1; }
.stat-lbl { font-size: 10px; font-weight: 600; color: #8a9bbf; letter-spacing: 0.14em; text-transform: uppercase; font-family: 'DM Sans', sans-serif; }

/* Create button */
.btn-create { display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 50%, #c9a84c 100%); background-size: 200% auto; color: #0b1c38; font-size: 10px; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; padding: 11px 22px; text-decoration: none; font-family: 'DM Sans', sans-serif; transition: background-position 0.4s ease, transform 0.2s; box-shadow: 0 2px 12px rgba(201,168,76,0.25); }
.btn-create:hover { background-position: right center; transform: translateY(-1px); }

/* Search */
.search-bar { display: flex; align-items: center; gap: 10px; background: #fff; border: 1px solid rgba(11,28,56,0.08); padding: 0 16px; margin-bottom: 16px; height: 44px; }
.search-icon { color: #b8c5d8; flex-shrink: 0; }
.search-input { flex: 1; border: none; outline: none; font-size: 13px; font-family: 'DM Sans', sans-serif; color: #0b1c38; background: transparent; }
.search-input::placeholder { color: #b8c5d8; }
.search-clear { display: flex; align-items: center; justify-content: center; background: none; border: none; cursor: pointer; color: #b8c5d8; padding: 2px; transition: color 0.2s; }
.search-clear:hover { color: #e74c3c; }

/* Table */
.table-panel { background: #fff; border: 1px solid rgba(11,28,56,0.07); box-shadow: 0 2px 12px rgba(11,28,56,0.04); overflow: hidden; }
.users-table { width: 100%; border-collapse: collapse; }
.users-table thead tr { border-bottom: 2px solid rgba(11,28,56,0.06); }
.users-table th { padding: 14px 20px; text-align: left; font-size: 9px; font-weight: 700; letter-spacing: 0.2em; text-transform: uppercase; color: #8a9bbf; font-family: 'DM Mono', monospace; white-space: nowrap; }
.user-row { border-bottom: 1px solid rgba(11,28,56,0.04); transition: background 0.2s; }
.user-row:last-child { border-bottom: none; }
.user-row:hover { background: rgba(11,28,56,0.02); }
.users-table td { padding: 13px 20px; font-family: 'DM Sans', sans-serif; font-size: 13px; color: #3a4a62; }

.td-id { font-family: 'DM Mono', monospace; font-size: 11px; color: #b8c5d8; width: 40px; }
.td-name { display: flex; align-items: center; gap: 10px; font-weight: 500; color: #0b1c38; }
.user-avatar-sm { width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, #c9a84c, #e8cf8a); display: flex; align-items: center; justify-content: center; font-family: 'Cormorant Garamond', serif; font-size: 13px; font-weight: 700; color: #0b1c38; flex-shrink: 0; }
.td-email { display: flex; align-items: center; gap: 8px; color: #3a4a62; }
.email-icon { color: #c9a84c; flex-shrink: 0; }
.td-date { font-size: 11px; font-family: 'DM Mono', monospace; color: #8a9bbf; white-space: nowrap; }
.td-you { width: 60px; }
.you-badge { display: inline-block; padding: 3px 9px; font-size: 9px; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; font-family: 'DM Mono', monospace; background: rgba(201,168,76,0.12); color: #c9a84c; }

/* Actions */
.td-actions { display: flex; align-items: center; gap: 8px; }
.btn-action { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; font-size: 10px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; font-family: 'DM Mono', monospace; text-decoration: none; border: 1px solid; cursor: pointer; transition: all 0.2s; }
.btn-edit   { color: #2980b9; border-color: rgba(41,128,185,0.25); background: rgba(41,128,185,0.06); }
.btn-edit:hover { background: rgba(41,128,185,0.12); border-color: rgba(41,128,185,0.4); }
.btn-delete { color: #e74c3c; border-color: rgba(231,76,60,0.25); background: rgba(231,76,60,0.06); }
.btn-delete:hover { background: rgba(231,76,60,0.12); border-color: rgba(231,76,60,0.4); }

/* Empty state */
.empty-state { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 16px; padding: 80px 32px; color: #b8c5d8; font-size: 14px; font-family: 'DM Sans', sans-serif; }

/* Pagination */
.pagination { display: flex; gap: 4px; margin-top: 16px; justify-content: center; }
.page-btn { display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: #fff; border: 1px solid rgba(11,28,56,0.08); text-decoration: none; font-size: 12px; font-family: 'DM Mono', monospace; color: #8a9bbf; transition: all 0.2s; }
.page-btn:hover { border-color: rgba(201,168,76,0.3); color: #0b1c38; }
.page-btn.active { background: #0b1c38; color: #e8cf8a; border-color: #0b1c38; }

/* Modal */
.modal-overlay { position: fixed; inset: 0; background: rgba(11,28,56,0.6); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 500; padding: 20px; }
.modal-box { background: #fff; width: 100%; max-width: 400px; padding: 36px 32px 28px; border-top: 3px solid #e74c3c; box-shadow: 0 24px 60px rgba(11,28,56,0.25); }
.modal-icon { display: flex; justify-content: center; margin-bottom: 20px; }
.modal-title { font-family: 'Cormorant Garamond', serif; font-size: 22px; font-weight: 600; color: #0b1c38; text-align: center; margin-bottom: 10px; }
.modal-text { font-size: 13px; color: #3a4a62; font-family: 'DM Sans', sans-serif; text-align: center; line-height: 1.6; margin-bottom: 28px; }
.modal-text strong { color: #0b1c38; font-weight: 600; }
.modal-actions { display: flex; gap: 10px; }
.btn-cancel { flex: 1; padding: 11px; background: #fff; border: 1px solid rgba(11,28,56,0.12); font-size: 11px; font-weight: 600; letter-spacing: 0.12em; text-transform: uppercase; font-family: 'DM Sans', sans-serif; color: #8a9bbf; cursor: pointer; transition: all 0.2s; }
.btn-cancel:hover { border-color: rgba(11,28,56,0.25); color: #0b1c38; }
.btn-confirm-delete { flex: 1; padding: 11px; background: #e74c3c; border: none; font-size: 11px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; font-family: 'DM Sans', sans-serif; color: #fff; cursor: pointer; transition: background 0.2s; }
.btn-confirm-delete:hover { background: #c0392b; }

/* Modal transition */
.modal-enter-active, .modal-leave-active { transition: opacity 0.2s ease; }
.modal-enter-from, .modal-leave-to { opacity: 0; }
.modal-enter-active .modal-box, .modal-leave-active .modal-box { transition: transform 0.2s ease; }
.modal-enter-from .modal-box, .modal-leave-to .modal-box { transform: scale(0.95) translateY(-8px); }

@media (max-width: 768px) {
  .admin-sidebar { width: 64px; }
  .sidebar-logo-label, .nav-label, .btn-logout span { display: none; }
  .content-wrap { padding: 16px; }
  .admin-topbar { padding: 0 16px; }
  .topbar-live, .admin-info { display: none; }
  .page-header { flex-direction: column; align-items: flex-start; }
  .td-email, .td-date { display: none; }
}
</style>
