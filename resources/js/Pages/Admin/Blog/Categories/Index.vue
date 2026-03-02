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
          :class="{ active: item.id === 'blog-categories' }"
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

    <!-- ══ Main ══ -->
    <main class="admin-main">

      <!-- Topbar -->
      <header class="admin-topbar">
        <div class="topbar-left">
          <h2 class="topbar-title">Blog Categories</h2>
          <div class="topbar-breadcrumb">
            <span>Admin</span><span class="bc-sep">›</span>
            <span>Blog</span><span class="bc-sep">›</span>
            <span class="bc-active">Categories</span>
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

      <!-- Content -->
      <div class="content-wrap" :class="{ visible: mounted }">

        <!-- Flash -->
        <div v-if="$page.props.flash?.success" class="flash flash-success">
          <svg viewBox="0 0 16 16" fill="none" width="14" height="14"><path d="M3 8l3.5 3.5L13 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          {{ $page.props.flash.success }}
        </div>
        <div v-if="$page.props.flash?.error" class="flash flash-error">
          <svg viewBox="0 0 16 16" fill="none" width="14" height="14"><path d="M8 3v5M8 11v1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
          {{ $page.props.flash.error }}
        </div>

        <!-- Header row -->
        <div class="page-header">
          <div>
            <h3 class="page-title">All Categories</h3>
            <p class="page-sub">{{ categories.length }} categories total</p>
          </div>
          <Link href="/admin/blog/categories/create" class="btn-primary">
            <svg viewBox="0 0 14 14" fill="none" width="12" height="12"><path d="M7 1v12M1 7h12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
            New Category
          </Link>
        </div>

        <!-- Table -->
        <div class="panel">
          <table class="data-table" v-if="categories.length">
            <thead>
              <tr>
                <th>Name</th>
                <th>Slug</th>
                <th>Description</th>
                <th>Posts</th>
                <th>Order</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="cat in categories" :key="cat.id">
                <td class="td-name">{{ cat.name }}</td>
                <td class="td-slug">{{ cat.slug }}</td>
                <td class="td-desc">{{ cat.description || '—' }}</td>
                <td class="td-center">{{ cat.posts_count }}</td>
                <td class="td-center">{{ cat.sort_order }}</td>
                <td class="td-actions">
                  <Link :href="`/admin/blog/categories/${cat.id}/edit`" class="btn-action btn-edit" title="Edit">
                    <svg viewBox="0 0 14 14" fill="none" width="12" height="12"><path d="M10 2l2 2-7.5 7.5H3v-2.5L10 2z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Edit
                  </Link>
                  <button @click="confirmDelete(cat)" class="btn-action btn-delete" title="Delete">
                    <svg viewBox="0 0 14 14" fill="none" width="12" height="12"><path d="M2 4h10M5 4V2h4v2M6 7v4M8 7v4M3 4l.75 7.5A1 1 0 004.75 12.5h4.5a1 1 0 001-.95L11 4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

          <div v-else class="empty-state">
            <svg viewBox="0 0 40 40" fill="none" width="40" height="40"><rect x="6" y="6" width="28" height="28" rx="2" stroke="currentColor" stroke-width="1.2"/><path d="M13 14h14M13 20h14M13 26h8" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>
            <p>No categories yet.</p>
            <Link href="/admin/blog/categories/create" class="btn-primary-sm">Create your first category</Link>
          </div>
        </div>

      </div>
    </main>

    <!-- Delete confirm modal -->
    <div v-if="deleteTarget" class="modal-overlay" @click.self="deleteTarget = null">
      <div class="modal">
        <h4 class="modal-title">Delete Category</h4>
        <p class="modal-body">Are you sure you want to delete <strong>{{ deleteTarget.name }}</strong>? This cannot be undone.</p>
        <div class="modal-actions">
          <button class="btn-ghost" @click="deleteTarget = null">Cancel</button>
          <button class="btn-danger" @click="deleteCategory">Delete</button>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import { navItems } from '../../navItems.js'

const props = defineProps({
  admin:      Object,
  categories: Array,
})

const mounted          = ref(false)
const sidebarCollapsed = ref(false)
const deleteTarget     = ref(null)

onMounted(() => requestAnimationFrame(() => setTimeout(() => { mounted.value = true }, 60)))

function confirmDelete(cat) { deleteTarget.value = cat }
function deleteCategory() {
  router.delete(`/admin/blog/categories/${deleteTarget.value.id}`, {
    onFinish: () => { deleteTarget.value = null },
  })
}
function logout() { router.post('/admin/logout') }
</script>

<style scoped>
/* ── Layout ─── */
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

/* Main */
.admin-main{flex:1;display:flex;flex-direction:column;overflow:hidden;}
.admin-topbar{display:flex;align-items:center;justify-content:space-between;padding:0 32px;height:64px;background:#fff;border-bottom:1px solid rgba(11,28,56,.07);flex-shrink:0;gap:20px;}
.topbar-left{display:flex;flex-direction:column;gap:2px;}
.topbar-title{font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:600;color:#0b1c38;line-height:1;}
.topbar-breadcrumb{display:flex;align-items:center;gap:6px;font-size:10px;color:#8a9bbf;font-family:'DM Mono',monospace;letter-spacing:.06em;}
.bc-sep{color:rgba(201,168,76,.4);}
.bc-active{color:#c9a84c;}
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

/* Content */
.content-wrap{padding:28px;opacity:0;transform:translateY(12px);transition:opacity .6s,transform .6s;}
.content-wrap.visible{opacity:1;transform:translateY(0);}

/* Flash */
.flash{display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:0;font-size:13px;font-family:'DM Sans',sans-serif;margin-bottom:20px;}
.flash-success{background:rgba(39,174,96,.1);color:#27ae60;border-left:3px solid #27ae60;}
.flash-error{background:rgba(231,76,60,.1);color:#e74c3c;border-left:3px solid #e74c3c;}

/* Page header */
.page-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;}
.page-title{font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:600;color:#0b1c38;}
.page-sub{font-size:12px;color:#8a9bbf;margin-top:3px;}

/* Buttons */
.btn-primary{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#0b1c38;color:#c9a84c;font-size:12px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;text-decoration:none;border:1px solid rgba(201,168,76,.3);transition:background .2s,border-color .2s;}
.btn-primary:hover{background:#162d55;border-color:rgba(201,168,76,.6);}
.btn-primary-sm{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:#0b1c38;color:#c9a84c;font-size:11px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;text-decoration:none;margin-top:12px;border:1px solid rgba(201,168,76,.3);transition:background .2s;}
.btn-primary-sm:hover{background:#162d55;}

/* Panel / Table */
.panel{background:#fff;border:1px solid rgba(11,28,56,.07);box-shadow:0 2px 12px rgba(11,28,56,.04);overflow:hidden;}
.data-table{width:100%;border-collapse:collapse;font-size:13px;font-family:'DM Sans',sans-serif;}
.data-table th{padding:12px 16px;text-align:left;font-size:10px;font-weight:700;color:#8a9bbf;letter-spacing:.14em;text-transform:uppercase;background:#fafbfc;border-bottom:1px solid rgba(11,28,56,.07);}
.data-table td{padding:14px 16px;border-bottom:1px solid rgba(11,28,56,.05);color:#3a4a62;vertical-align:middle;}
.data-table tr:last-child td{border-bottom:none;}
.data-table tr:hover td{background:rgba(11,28,56,.02);}
.td-name{font-weight:600;color:#0b1c38;}
.td-slug{font-family:'DM Mono',monospace;font-size:11px;color:#8a9bbf;}
.td-desc{max-width:240px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#5a6a82;}
.td-center{text-align:center;}
.td-actions{display:flex;align-items:center;gap:8px;}
.btn-action{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;font-size:11px;font-weight:500;font-family:'DM Sans',sans-serif;border:1px solid;cursor:pointer;text-decoration:none;transition:background .2s,color .2s;}
.btn-edit{color:#2980b9;border-color:rgba(41,128,185,.3);background:rgba(41,128,185,.06);}
.btn-edit:hover{background:rgba(41,128,185,.14);}
.btn-delete{color:#e74c3c;border-color:rgba(231,76,60,.3);background:rgba(231,76,60,.06);}
.btn-delete:hover{background:rgba(231,76,60,.14);}

/* Empty state */
.empty-state{display:flex;flex-direction:column;align-items:center;justify-content:center;padding:60px 20px;color:#8a9bbf;gap:12px;font-size:13px;}

/* Modal */
.modal-overlay{position:fixed;inset:0;background:rgba(11,28,56,.6);display:flex;align-items:center;justify-content:center;z-index:500;backdrop-filter:blur(2px);}
.modal{background:#fff;width:400px;max-width:90vw;padding:28px;border-top:2px solid #e74c3c;}
.modal-title{font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:600;color:#0b1c38;margin-bottom:10px;}
.modal-body{font-size:13px;color:#5a6a82;line-height:1.6;margin-bottom:24px;}
.modal-actions{display:flex;justify-content:flex-end;gap:10px;}
.btn-ghost{padding:9px 18px;background:none;border:1px solid rgba(11,28,56,.15);color:#5a6a82;font-size:12px;cursor:pointer;transition:border-color .2s;}
.btn-ghost:hover{border-color:rgba(11,28,56,.35);}
.btn-danger{padding:9px 18px;background:#e74c3c;border:1px solid #e74c3c;color:#fff;font-size:12px;font-weight:600;cursor:pointer;transition:background .2s;}
.btn-danger:hover{background:#c0392b;}
</style>
