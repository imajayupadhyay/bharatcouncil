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
          <h2 class="topbar-title">{{ isEdit ? 'Edit Admin User' : 'New Admin User' }}</h2>
          <div class="topbar-breadcrumb">
            <span>Admin</span>
            <span class="bc-sep">›</span>
            <Link href="/admin/admin-users" class="bc-link">Users</Link>
            <span class="bc-sep">›</span>
            <span class="bc-active">{{ isEdit ? 'Edit' : 'Create' }}</span>
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

        <div class="form-container">

          <!-- Form header -->
          <div class="form-header">
            <div class="form-header-icon">
              <svg viewBox="0 0 24 24" fill="none" width="22" height="22">
                <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="1.4"/>
                <path d="M2 21c0-5.52 3.13-10 7-10s7 4.48 7 10" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                <path d="M18 10v6M15 13h6" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
              </svg>
            </div>
            <div>
              <h3 class="form-header-title">{{ isEdit ? 'Update Admin Account' : 'Create Admin Account' }}</h3>
              <p class="form-header-sub">
                {{ isEdit
                  ? 'Update the details below. Leave the password fields blank to keep the existing password.'
                  : 'Fill in the details below to create a new admin account with login access.' }}
              </p>
            </div>
          </div>

          <!-- Form body -->
          <form @submit.prevent="submit" class="user-form">

            <!-- Name -->
            <div class="field-group">
              <label class="field-label" for="name">Full Name <span class="required">*</span></label>
              <input
                id="name"
                v-model="form.name"
                type="text"
                class="field-input"
                :class="{ 'field-error': errors.name }"
                placeholder="e.g. Rahul Sharma"
                autocomplete="name"
              />
              <p v-if="errors.name" class="error-msg">{{ errors.name }}</p>
            </div>

            <!-- Email -->
            <div class="field-group">
              <label class="field-label" for="email">Email Address <span class="required">*</span></label>
              <input
                id="email"
                v-model="form.email"
                type="email"
                class="field-input"
                :class="{ 'field-error': errors.email }"
                placeholder="e.g. rahul@bharatcouncil.org"
                autocomplete="email"
              />
              <p v-if="errors.email" class="error-msg">{{ errors.email }}</p>
            </div>

            <div class="field-divider">
              <span>{{ isEdit ? 'Change Password (optional)' : 'Password' }}</span>
            </div>

            <!-- Password -->
            <div class="field-group">
              <label class="field-label" for="password">
                Password <span v-if="!isEdit" class="required">*</span>
                <span v-else class="optional-tag">leave blank to keep unchanged</span>
              </label>
              <div class="password-wrap">
                <input
                  id="password"
                  v-model="form.password"
                  :type="showPassword ? 'text' : 'password'"
                  class="field-input"
                  :class="{ 'field-error': errors.password }"
                  placeholder="Minimum 8 characters"
                  autocomplete="new-password"
                />
                <button type="button" class="toggle-pw" @click="showPassword = !showPassword" tabindex="-1">
                  <svg v-if="!showPassword" viewBox="0 0 16 16" fill="none" width="14" height="14">
                    <path d="M1 8s3-5 7-5 7 5 7 5-3 5-7 5-7-5-7-5z" stroke="currentColor" stroke-width="1.2"/>
                    <circle cx="8" cy="8" r="2" stroke="currentColor" stroke-width="1.2"/>
                  </svg>
                  <svg v-else viewBox="0 0 16 16" fill="none" width="14" height="14">
                    <path d="M2 2l12 12M6.5 6.6A2 2 0 0010 10M4.2 4.3C2.8 5.3 1.8 6.7 1 8c1.5 2.5 4 5 7 5 1.2 0 2.3-.4 3.3-1M8 3c3 0 5.5 2.5 7 5a12 12 0 01-1.6 2.4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                  </svg>
                </button>
              </div>
              <p v-if="errors.password" class="error-msg">{{ errors.password }}</p>
            </div>

            <!-- Password confirmation -->
            <div class="field-group">
              <label class="field-label" for="password_confirmation">
                Confirm Password <span v-if="!isEdit" class="required">*</span>
              </label>
              <div class="password-wrap">
                <input
                  id="password_confirmation"
                  v-model="form.password_confirmation"
                  :type="showConfirm ? 'text' : 'password'"
                  class="field-input"
                  :class="{ 'field-error': errors.password_confirmation }"
                  placeholder="Re-enter password"
                  autocomplete="new-password"
                />
                <button type="button" class="toggle-pw" @click="showConfirm = !showConfirm" tabindex="-1">
                  <svg v-if="!showConfirm" viewBox="0 0 16 16" fill="none" width="14" height="14">
                    <path d="M1 8s3-5 7-5 7 5 7 5-3 5-7 5-7-5-7-5z" stroke="currentColor" stroke-width="1.2"/>
                    <circle cx="8" cy="8" r="2" stroke="currentColor" stroke-width="1.2"/>
                  </svg>
                  <svg v-else viewBox="0 0 16 16" fill="none" width="14" height="14">
                    <path d="M2 2l12 12M6.5 6.6A2 2 0 0010 10M4.2 4.3C2.8 5.3 1.8 6.7 1 8c1.5 2.5 4 5 7 5 1.2 0 2.3-.4 3.3-1M8 3c3 0 5.5 2.5 7 5a12 12 0 01-1.6 2.4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                  </svg>
                </button>
              </div>
              <p v-if="errors.password_confirmation" class="error-msg">{{ errors.password_confirmation }}</p>
            </div>

            <!-- Form actions -->
            <div class="form-actions">
              <Link href="/admin/admin-users" class="btn-back">
                <svg viewBox="0 0 14 14" fill="none" width="12" height="12">
                  <path d="M9 2L4 7l5 5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Cancel
              </Link>
              <button type="submit" class="btn-submit" :disabled="processing">
                <svg v-if="processing" class="spin-icon" viewBox="0 0 16 16" fill="none" width="14" height="14">
                  <path d="M8 2a6 6 0 100 12A6 6 0 008 2z" stroke="currentColor" stroke-width="1.4" stroke-dasharray="20" stroke-dashoffset="10"/>
                </svg>
                <svg v-else viewBox="0 0 14 14" fill="none" width="12" height="12">
                  <path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                {{ processing ? 'Saving…' : (isEdit ? 'Update User' : 'Create User') }}
              </button>
            </div>

          </form>
        </div>

      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Link, router, useForm } from '@inertiajs/vue3'

const props = defineProps({
  admin: Object,
  user:  Object,
})

const mounted          = ref(false)
const sidebarCollapsed = ref(false)
const showPassword     = ref(false)
const showConfirm      = ref(false)

const isEdit = computed(() => !!props.user)

const form = useForm({
  name:                  props.user?.name  ?? '',
  email:                 props.user?.email ?? '',
  password:              '',
  password_confirmation: '',
})

const errors    = computed(() => form.errors)
const processing = computed(() => form.processing)

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

function submit() {
  if (isEdit.value) {
    form.put(`/admin/admin-users/${props.user.id}`)
  } else {
    form.post('/admin/admin-users')
  }
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

/* Form container */
.form-container { max-width: 600px; }

/* Form header */
.form-header { display: flex; align-items: flex-start; gap: 18px; background: #0b1c38; padding: 28px 32px; margin-bottom: 0; border-top: 2px solid #c9a84c; }
.form-header-icon { width: 48px; height: 48px; background: rgba(201,168,76,0.12); border: 1px solid rgba(201,168,76,0.2); display: flex; align-items: center; justify-content: center; color: #c9a84c; flex-shrink: 0; }
.form-header-title { font-family: 'Cormorant Garamond', serif; font-size: 22px; font-weight: 600; color: #fff; margin-bottom: 6px; }
.form-header-sub { font-size: 12px; color: #8a9bbf; font-family: 'DM Sans', sans-serif; line-height: 1.6; }

/* Form */
.user-form { background: #fff; border: 1px solid rgba(11,28,56,0.07); border-top: none; box-shadow: 0 2px 12px rgba(11,28,56,0.04); padding: 32px; display: flex; flex-direction: column; gap: 24px; }

/* Field */
.field-group { display: flex; flex-direction: column; gap: 8px; }
.field-label { font-size: 10px; font-weight: 700; color: #3a4a62; letter-spacing: 0.18em; text-transform: uppercase; font-family: 'DM Sans', sans-serif; }
.required { color: #c9a84c; }
.optional-tag { font-size: 9px; font-weight: 400; color: #b8c5d8; letter-spacing: 0.06em; text-transform: none; font-family: 'DM Mono', monospace; margin-left: 6px; }
.field-input { width: 100%; padding: 12px 14px; border: 1px solid rgba(11,28,56,0.12); font-size: 14px; font-family: 'DM Sans', sans-serif; color: #0b1c38; background: #fff; outline: none; transition: border-color 0.2s, box-shadow 0.2s; }
.field-input:focus { border-color: rgba(201,168,76,0.5); box-shadow: 0 0 0 3px rgba(201,168,76,0.08); }
.field-input.field-error { border-color: rgba(231,76,60,0.5); }
.field-input::placeholder { color: #b8c5d8; }
.error-msg { font-size: 11px; color: #e74c3c; font-family: 'DM Sans', sans-serif; }

/* Password wrap */
.password-wrap { position: relative; }
.password-wrap .field-input { padding-right: 44px; }
.toggle-pw { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #b8c5d8; padding: 4px; transition: color 0.2s; }
.toggle-pw:hover { color: #c9a84c; }

/* Divider */
.field-divider { display: flex; align-items: center; gap: 12px; }
.field-divider::before, .field-divider::after { content: ''; flex: 1; height: 1px; background: rgba(11,28,56,0.07); }
.field-divider span { font-size: 9px; font-weight: 700; color: #b8c5d8; letter-spacing: 0.2em; text-transform: uppercase; font-family: 'DM Mono', monospace; white-space: nowrap; }

/* Actions */
.form-actions { display: flex; align-items: center; gap: 12px; padding-top: 8px; border-top: 1px solid rgba(11,28,56,0.06); }
.btn-back { display: inline-flex; align-items: center; gap: 8px; padding: 11px 22px; background: #fff; border: 1px solid rgba(11,28,56,0.12); font-size: 11px; font-weight: 600; letter-spacing: 0.12em; text-transform: uppercase; font-family: 'DM Sans', sans-serif; color: #8a9bbf; text-decoration: none; transition: all 0.2s; }
.btn-back:hover { border-color: rgba(11,28,56,0.25); color: #0b1c38; }
.btn-submit { display: inline-flex; align-items: center; gap: 8px; padding: 11px 28px; background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 50%, #c9a84c 100%); background-size: 200% auto; color: #0b1c38; font-size: 11px; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; font-family: 'DM Sans', sans-serif; border: none; cursor: pointer; transition: background-position 0.4s ease, transform 0.2s; box-shadow: 0 2px 12px rgba(201,168,76,0.25); }
.btn-submit:hover:not(:disabled) { background-position: right center; transform: translateY(-1px); }
.btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }
.spin-icon { animation: spin 0.8s linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }

@media (max-width: 768px) {
  .admin-sidebar { width: 64px; }
  .sidebar-logo-label, .nav-label, .btn-logout span { display: none; }
  .content-wrap { padding: 16px; }
  .admin-topbar { padding: 0 16px; }
  .topbar-live, .admin-info { display: none; }
  .user-form { padding: 20px; }
  .form-header { padding: 20px; }
}
</style>
