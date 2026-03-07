<template>
  <div class="admin-root">

    <!-- Sidebar -->
    <aside class="admin-sidebar" :class="{ collapsed: sidebarCollapsed }">
      <div class="sidebar-logo">
        <img :src="'/BGC.png'" alt="BGC" class="sidebar-logo-img" />
        <span v-if="!sidebarCollapsed" class="sidebar-logo-label">Admin</span>
      </div>
      <nav class="sidebar-nav">
        <template v-for="group in navGroups" :key="group.label">
          <div class="nav-group-label" v-if="!sidebarCollapsed">{{ group.label }}</div>
          <Link
            v-for="item in group.items" :key="item.id"
            :href="item.href" class="nav-item"
            :class="{ active: item.id === 'blog-categories' }"
            :title="sidebarCollapsed ? item.label : ''"
          >
            <span class="nav-icon" v-html="item.icon"/>
            <span v-if="!sidebarCollapsed" class="nav-label">{{ item.label }}</span>
          </Link>
        </template>
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

    <!-- Main -->
    <main class="admin-main">
      <header class="admin-topbar">
        <div class="topbar-left">
          <h2 class="topbar-title">{{ isEdit ? 'Edit Category' : 'New Category' }}</h2>
          <div class="topbar-breadcrumb">
            <span>Admin</span><span class="bc-sep">›</span>
            <Link href="/admin/blog/categories" class="bc-link">Categories</Link><span class="bc-sep">›</span>
            <span class="bc-active">{{ isEdit ? 'Edit' : 'Create' }}</span>
          </div>
        </div>
        <div class="topbar-right">
          <div class="topbar-live"><span class="live-dot"/><span class="live-label">System Online</span></div>
          <div class="topbar-admin">
            <div class="admin-avatar">{{ admin?.name?.charAt(0)?.toUpperCase() ?? 'A' }}</div>
            <div class="admin-info">
              <span class="admin-name">{{ admin?.name ?? 'Admin' }}</span>
              <span class="admin-email">{{ admin?.email ?? '' }}</span>
            </div>
          </div>
        </div>
      </header>

      <div class="content-wrap" :class="{ visible: mounted }">

        <!-- Back -->
        <Link href="/admin/blog/categories" class="back-link">
          <svg viewBox="0 0 14 14" fill="none" width="12" height="12"><path d="M9 2L4 7l5 5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
          Back to Categories
        </Link>

        <!-- Form -->
        <form @submit.prevent="submit" class="form-panel">
          <div class="form-header">
            <h3 class="form-title">{{ isEdit ? 'Edit Category' : 'Create Category' }}</h3>
            <p class="form-sub">{{ isEdit ? 'Update the category details below.' : 'Fill in the details to create a new blog category.' }}</p>
          </div>

          <div class="form-body">

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Name <span class="required">*</span></label>
                <input v-model="form.name" @input="autoSlug" type="text" class="form-input" :class="{ error: errors.name }" placeholder="e.g. Fiscal Policy" />
                <span v-if="errors.name" class="form-error">{{ errors.name }}</span>
              </div>
              <div class="form-group">
                <label class="form-label">Sort Order</label>
                <input v-model.number="form.sort_order" type="number" min="0" class="form-input" placeholder="0" />
                <span class="form-hint">Lower numbers appear first.</span>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">
                Slug
                <span class="label-hint">Auto-generated from name. Edit to customise.</span>
              </label>
              <div class="input-prefix-wrap">
                <span class="input-prefix">/insights/</span>
                <input v-model="form.slug" type="text" class="form-input with-prefix" :class="{ error: errors.slug }" placeholder="fiscal-policy" />
              </div>
              <span v-if="errors.slug" class="form-error">{{ errors.slug }}</span>
            </div>

            <div class="form-group">
              <label class="form-label">Description</label>
              <textarea v-model="form.description" class="form-textarea" rows="3" placeholder="Brief description of this category (optional)"></textarea>
            </div>

          </div>

          <div class="form-footer">
            <Link href="/admin/blog/categories" class="btn-ghost">Cancel</Link>
            <button type="submit" class="btn-primary" :disabled="submitting">
              <span v-if="submitting">Saving…</span>
              <span v-else>{{ isEdit ? 'Update Category' : 'Create Category' }}</span>
            </button>
          </div>

        </form>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Link, router, useForm } from '@inertiajs/vue3'
import { navGroups } from '../../navItems.js'

const props = defineProps({
  admin:    Object,
  category: Object,
})

const mounted          = ref(false)
const sidebarCollapsed = ref(false)
const submitting       = ref(false)
const isEdit           = computed(() => !!props.category)

const form = useForm({
  name:        props.category?.name        ?? '',
  slug:        props.category?.slug        ?? '',
  description: props.category?.description ?? '',
  sort_order:  props.category?.sort_order  ?? 0,
})

const errors = computed(() => form.errors)

function autoSlug() {
  if (!isEdit.value) {
    form.slug = form.name
      .toLowerCase()
      .trim()
      .replace(/[^a-z0-9\s-]/g, '')
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-')
  }
}

function submit() {
  submitting.value = true
  if (isEdit.value) {
    form.put(`/admin/blog/categories/${props.category.id}`, {
      onFinish: () => { submitting.value = false },
    })
  } else {
    form.post('/admin/blog/categories', {
      onFinish: () => { submitting.value = false },
    })
  }
}

function logout() { router.post('/admin/logout') }

onMounted(() => requestAnimationFrame(() => setTimeout(() => { mounted.value = true }, 60)))
</script>

<style scoped>
.admin-root{display:flex;min-height:100vh;background:#f2f4f8;font-family:'DM Sans',sans-serif;}
.admin-sidebar{width:240px;flex-shrink:0;background:#0b1c38;display:flex;flex-direction:column;border-right:1px solid rgba(201,168,76,.12);transition:width .3s cubic-bezier(.4,0,.2,1);position:sticky;top:0;height:100vh;overflow:hidden;}
.admin-sidebar.collapsed{width:64px;}
.sidebar-logo{display:flex;align-items:center;gap:12px;padding:20px 18px;border-bottom:1px solid rgba(255,255,255,.06);flex-shrink:0;}
.sidebar-logo-img{width:44px;height:auto;object-fit:contain;flex-shrink:0;}
.sidebar-logo-label{font-size:9px;font-weight:700;color:#c9a84c;letter-spacing:.3em;text-transform:uppercase;font-family:'DM Mono',monospace;white-space:nowrap;}
.sidebar-nav{flex:1;padding:20px 10px;display:flex;flex-direction:column;gap:2px;overflow-y:auto;overflow-x:hidden;}
.nav-group-label{font-size:8px;font-weight:700;color:rgba(138,155,191,.35);letter-spacing:.3em;text-transform:uppercase;padding:0 8px;margin-bottom:6px;white-space:nowrap;}
.nav-item{display:flex;align-items:center;gap:12px;padding:10px 12px;color:#8a9bbf;text-decoration:none;font-size:13px;font-weight:500;position:relative;transition:color .2s,background .2s;white-space:nowrap;overflow:hidden;}
.nav-item::before{content:'';position:absolute;left:0;top:0;bottom:0;width:2px;background:linear-gradient(to bottom,#c9a84c,#e8cf8a);transform:scaleY(0);transition:transform .25s;}
.nav-item:hover{color:#e8cf8a;background:rgba(255,255,255,.04);}
.nav-item.active{color:#e8cf8a;background:rgba(201,168,76,.08);}
.nav-item.active::before{transform:scaleY(1);}
.nav-icon{display:flex;align-items:center;justify-content:center;flex-shrink:0;width:16px;}
.nav-label{flex:1;}
.sidebar-toggle{display:flex;align-items:center;justify-content:center;width:100%;padding:12px;background:none;border:none;border-top:1px solid rgba(255,255,255,.05);color:rgba(138,155,191,.4);cursor:pointer;transition:color .2s;}
.sidebar-toggle:hover{color:#c9a84c;}
.sidebar-toggle svg{transition:transform .3s;}
.sidebar-toggle svg.flipped{transform:rotate(180deg);}
.sidebar-footer{padding:12px 10px;border-top:1px solid rgba(255,255,255,.05);flex-shrink:0;}
.btn-logout{display:flex;align-items:center;gap:10px;width:100%;padding:10px 12px;background:none;border:none;color:rgba(138,155,191,.5);font-size:13px;cursor:pointer;white-space:nowrap;overflow:hidden;transition:color .2s,background .2s;}
.btn-logout:hover{color:#e74c3c;background:rgba(231,76,60,.08);}
.admin-main{flex:1;display:flex;flex-direction:column;overflow:hidden;}
.admin-topbar{display:flex;align-items:center;justify-content:space-between;padding:0 32px;height:64px;background:#fff;border-bottom:1px solid rgba(11,28,56,.07);flex-shrink:0;gap:20px;}
.topbar-left{display:flex;flex-direction:column;gap:2px;}
.topbar-title{font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:600;color:#0b1c38;line-height:1;}
.topbar-breadcrumb{display:flex;align-items:center;gap:6px;font-size:10px;color:#8a9bbf;font-family:'DM Mono',monospace;letter-spacing:.06em;}
.bc-sep{color:rgba(201,168,76,.4);}
.bc-active{color:#c9a84c;}
.bc-link{color:#8a9bbf;text-decoration:none;}
.bc-link:hover{color:#c9a84c;}
.topbar-right{display:flex;align-items:center;gap:20px;}
.topbar-live{display:flex;align-items:center;gap:7px;}
.live-dot{width:7px;height:7px;border-radius:50%;background:#2ecc71;position:relative;}
.live-dot::before{content:'';position:absolute;inset:-3px;border-radius:50%;background:rgba(46,204,113,.25);animation:livePulse 1.8s ease-out infinite;}
@keyframes livePulse{0%{transform:scale(.8);opacity:1;}100%{transform:scale(2.2);opacity:0;}}
.live-label{font-size:10px;color:rgba(46,204,113,.7);font-family:'DM Mono',monospace;letter-spacing:.06em;}
.topbar-admin{display:flex;align-items:center;gap:10px;}
.admin-avatar{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#c9a84c,#e8cf8a);display:flex;align-items:center;justify-content:center;font-family:'Cormorant Garamond',serif;font-size:16px;font-weight:700;color:#0b1c38;flex-shrink:0;}
.admin-info{display:flex;flex-direction:column;gap:1px;}
.admin-name{font-size:13px;font-weight:500;color:#0b1c38;text-transform:capitalize;}
.admin-email{font-size:10px;color:#8a9bbf;font-family:'DM Mono',monospace;}
.content-wrap{padding:28px;max-width:820px;opacity:0;transform:translateY(12px);transition:opacity .6s,transform .6s;}
.content-wrap.visible{opacity:1;transform:translateY(0);}
.back-link{display:inline-flex;align-items:center;gap:7px;font-size:12px;color:#8a9bbf;text-decoration:none;margin-bottom:20px;font-family:'DM Sans',sans-serif;transition:color .2s;}
.back-link:hover{color:#0b1c38;}
.form-panel{background:#fff;border:1px solid rgba(11,28,56,.07);box-shadow:0 2px 12px rgba(11,28,56,.04);overflow:hidden;}
.form-header{padding:24px 28px;border-bottom:1px solid rgba(11,28,56,.07);}
.form-title{font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:600;color:#0b1c38;}
.form-sub{font-size:12px;color:#8a9bbf;margin-top:4px;}
.form-body{padding:28px;display:flex;flex-direction:column;gap:20px;}
.form-row{display:grid;grid-template-columns:1fr 160px;gap:16px;}
.form-group{display:flex;flex-direction:column;gap:6px;}
.form-label{font-size:11px;font-weight:700;color:#0b1c38;letter-spacing:.1em;text-transform:uppercase;}
.label-hint{font-size:10px;font-weight:400;color:#8a9bbf;text-transform:none;letter-spacing:0;margin-left:8px;}
.required{color:#e74c3c;}
.form-input{padding:10px 14px;border:1px solid rgba(11,28,56,.15);background:#fff;font-size:13px;font-family:'DM Sans',sans-serif;color:#0b1c38;outline:none;transition:border-color .2s,box-shadow .2s;}
.form-input:focus{border-color:#c9a84c;box-shadow:0 0 0 3px rgba(201,168,76,.1);}
.form-input.error{border-color:#e74c3c;}
.form-input.with-prefix{border-left:none;}
.form-textarea{padding:10px 14px;border:1px solid rgba(11,28,56,.15);background:#fff;font-size:13px;font-family:'DM Sans',sans-serif;color:#0b1c38;outline:none;resize:vertical;transition:border-color .2s;}
.form-textarea:focus{border-color:#c9a84c;box-shadow:0 0 0 3px rgba(201,168,76,.1);}
.input-prefix-wrap{display:flex;}
.input-prefix{display:flex;align-items:center;padding:10px 12px;background:#fafbfc;border:1px solid rgba(11,28,56,.15);border-right:none;font-size:11px;color:#8a9bbf;font-family:'DM Mono',monospace;white-space:nowrap;}
.form-error{font-size:11px;color:#e74c3c;}
.form-hint{font-size:11px;color:#8a9bbf;}
.form-footer{display:flex;align-items:center;justify-content:flex-end;gap:12px;padding:20px 28px;border-top:1px solid rgba(11,28,56,.07);background:#fafbfc;}
.btn-ghost{padding:10px 20px;background:none;border:1px solid rgba(11,28,56,.15);color:#5a6a82;font-size:12px;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;transition:border-color .2s;}
.btn-ghost:hover{border-color:rgba(11,28,56,.35);}
.btn-primary{display:inline-flex;align-items:center;gap:8px;padding:10px 24px;background:#0b1c38;color:#c9a84c;font-size:12px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;border:1px solid rgba(201,168,76,.3);cursor:pointer;transition:background .2s;}
.btn-primary:hover:not(:disabled){background:#162d55;}
.btn-primary:disabled{opacity:.6;cursor:not-allowed;}
</style>
