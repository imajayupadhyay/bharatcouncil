<template>
  <div class="admin-root">

    <!-- Sidebar -->
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
          :class="{ active: item.id === 'blog-posts' }"
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

    <!-- Main -->
    <main class="admin-main">

      <header class="admin-topbar">
        <div class="topbar-left">
          <h2 class="topbar-title">Blog Posts</h2>
          <div class="topbar-breadcrumb">
            <span>Admin</span><span class="bc-sep">›</span>
            <span>Blog</span><span class="bc-sep">›</span>
            <span class="bc-active">Posts</span>
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

        <!-- Flash -->
        <div v-if="$page.props.flash?.success" class="flash flash-success">
          <svg viewBox="0 0 16 16" fill="none" width="14" height="14"><path d="M3 8l3.5 3.5L13 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          {{ $page.props.flash.success }}
        </div>
        <div v-if="$page.props.flash?.error" class="flash flash-error">
          <svg viewBox="0 0 16 16" fill="none" width="14" height="14"><path d="M8 3v5M8 11v1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
          {{ $page.props.flash.error }}
        </div>

        <!-- Header + Filters row -->
        <div class="page-header">
          <div>
            <h3 class="page-title">All Posts</h3>
            <p class="page-sub">{{ posts.total }} posts total</p>
          </div>
          <Link href="/admin/blog/posts/create" class="btn-primary">
            <svg viewBox="0 0 14 14" fill="none" width="12" height="12"><path d="M7 1v12M1 7h12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
            New Post
          </Link>
        </div>

        <!-- Filters -->
        <div class="filters-bar">
          <input
            v-model="search"
            type="text"
            class="filter-input"
            placeholder="Search by title or author…"
            @keyup.enter="applyFilters"
          />
          <select v-model="statusFilter" class="filter-select" @change="applyFilters">
            <option value="">All Statuses</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
          </select>
          <select v-model="categoryFilter" class="filter-select" @change="applyFilters">
            <option value="">All Categories</option>
            <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
          </select>
          <button class="btn-filter" @click="applyFilters">Filter</button>
          <button v-if="hasActiveFilters" class="btn-clear" @click="clearFilters">Clear</button>
        </div>

        <!-- Table -->
        <div class="panel">
          <table class="data-table" v-if="posts.data.length">
            <thead>
              <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Author</th>
                <th>Status</th>
                <th>Featured</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="post in posts.data" :key="post.id">
                <td class="td-title">
                  <div class="post-title">{{ post.title }}</div>
                  <div class="post-slug">{{ post.slug }}</div>
                </td>
                <td>
                  <span v-if="post.category" class="tag-category">{{ post.category.name }}</span>
                  <span v-else class="td-na">—</span>
                </td>
                <td class="td-author">{{ post.author_name }}</td>
                <td>
                  <span class="status-badge" :class="`status-${post.status}`">{{ post.status }}</span>
                </td>
                <td class="td-center">
                  <span v-if="post.is_featured" class="featured-star" title="Featured">★</span>
                  <span v-else class="td-na">—</span>
                </td>
                <td class="td-date">{{ formatDate(post.created_at) }}</td>
                <td class="td-actions">
                  <Link :href="`/admin/blog/posts/${post.id}/edit`" class="btn-action btn-edit" title="Edit">
                    <svg viewBox="0 0 14 14" fill="none" width="12" height="12"><path d="M10 2l2 2-7.5 7.5H3v-2.5L10 2z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Edit
                  </Link>
                  <button @click="confirmDelete(post)" class="btn-action btn-delete">
                    <svg viewBox="0 0 14 14" fill="none" width="12" height="12"><path d="M2 4h10M5 4V2h4v2M6 7v4M8 7v4M3 4l.75 7.5A1 1 0 004.75 12.5h4.5a1 1 0 001-.95L11 4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

          <div v-else class="empty-state">
            <svg viewBox="0 0 40 40" fill="none" width="40" height="40"><rect x="6" y="6" width="28" height="28" rx="2" stroke="currentColor" stroke-width="1.2"/><path d="M13 14h14M13 20h14M13 26h8" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>
            <p>No posts found.</p>
            <Link href="/admin/blog/posts/create" class="btn-primary-sm">Write your first post</Link>
          </div>

          <!-- Pagination -->
          <div v-if="posts.last_page > 1" class="pagination">
            <Link
              v-for="link in posts.links"
              :key="link.label"
              :href="link.url ?? '#'"
              class="page-link"
              :class="{ active: link.active, disabled: !link.url }"
              v-html="link.label"
            />
          </div>
        </div>

      </div>
    </main>

    <!-- Delete modal -->
    <div v-if="deleteTarget" class="modal-overlay" @click.self="deleteTarget = null">
      <div class="modal">
        <h4 class="modal-title">Delete Post</h4>
        <p class="modal-body">Are you sure you want to delete <strong>"{{ deleteTarget.title }}"</strong>? This cannot be undone.</p>
        <div class="modal-actions">
          <button class="btn-ghost" @click="deleteTarget = null">Cancel</button>
          <button class="btn-danger" @click="deletePost">Delete</button>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import { navItems } from '../../navItems.js'

const props = defineProps({
  admin:      Object,
  posts:      Object,
  categories: Array,
  filters:    Object,
})

const mounted          = ref(false)
const sidebarCollapsed = ref(false)
const deleteTarget     = ref(null)
const search           = ref(props.filters?.search ?? '')
const statusFilter     = ref(props.filters?.status ?? '')
const categoryFilter   = ref(props.filters?.category ?? '')

const hasActiveFilters = computed(() =>
  search.value || statusFilter.value || categoryFilter.value
)

function applyFilters() {
  router.get('/admin/blog/posts', {
    search:   search.value || undefined,
    status:   statusFilter.value || undefined,
    category: categoryFilter.value || undefined,
  }, { preserveState: true, replace: true })
}

function clearFilters() {
  search.value         = ''
  statusFilter.value   = ''
  categoryFilter.value = ''
  router.get('/admin/blog/posts', {}, { replace: true })
}

function formatDate(dateStr) {
  return new Date(dateStr).toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' })
}

function confirmDelete(post) { deleteTarget.value = post }
function deletePost() {
  router.delete(`/admin/blog/posts/${deleteTarget.value.id}`, {
    onFinish: () => { deleteTarget.value = null },
  })
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
.content-wrap{padding:28px;opacity:0;transform:translateY(12px);transition:opacity .6s,transform .6s;}
.content-wrap.visible{opacity:1;transform:translateY(0);}
.flash{display:flex;align-items:center;gap:10px;padding:12px 16px;font-size:13px;margin-bottom:20px;}
.flash-success{background:rgba(39,174,96,.1);color:#27ae60;border-left:3px solid #27ae60;}
.flash-error{background:rgba(231,76,60,.1);color:#e74c3c;border-left:3px solid #e74c3c;}
.page-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px;}
.page-title{font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:600;color:#0b1c38;}
.page-sub{font-size:12px;color:#8a9bbf;margin-top:3px;}
.btn-primary{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#0b1c38;color:#c9a84c;font-size:12px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;text-decoration:none;border:1px solid rgba(201,168,76,.3);transition:background .2s;}
.btn-primary:hover{background:#162d55;}
.btn-primary-sm{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:#0b1c38;color:#c9a84c;font-size:11px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;text-decoration:none;margin-top:12px;border:1px solid rgba(201,168,76,.3);}
.filters-bar{display:flex;align-items:center;gap:10px;margin-bottom:16px;flex-wrap:wrap;}
.filter-input{flex:1;min-width:200px;padding:9px 14px;border:1px solid rgba(11,28,56,.15);background:#fff;font-size:13px;font-family:'DM Sans',sans-serif;color:#0b1c38;outline:none;transition:border-color .2s;}
.filter-input:focus{border-color:#c9a84c;}
.filter-select{padding:9px 14px;border:1px solid rgba(11,28,56,.15);background:#fff;font-size:13px;font-family:'DM Sans',sans-serif;color:#0b1c38;outline:none;cursor:pointer;}
.btn-filter{padding:9px 18px;background:#0b1c38;color:#c9a84c;border:none;font-size:12px;font-weight:600;cursor:pointer;letter-spacing:.06em;text-transform:uppercase;transition:background .2s;}
.btn-filter:hover{background:#162d55;}
.btn-clear{padding:9px 14px;background:none;border:1px solid rgba(231,76,60,.3);color:#e74c3c;font-size:12px;cursor:pointer;transition:background .2s;}
.btn-clear:hover{background:rgba(231,76,60,.08);}
.panel{background:#fff;border:1px solid rgba(11,28,56,.07);box-shadow:0 2px 12px rgba(11,28,56,.04);overflow:hidden;}
.data-table{width:100%;border-collapse:collapse;font-size:13px;font-family:'DM Sans',sans-serif;}
.data-table th{padding:12px 16px;text-align:left;font-size:10px;font-weight:700;color:#8a9bbf;letter-spacing:.14em;text-transform:uppercase;background:#fafbfc;border-bottom:1px solid rgba(11,28,56,.07);}
.data-table td{padding:13px 16px;border-bottom:1px solid rgba(11,28,56,.05);color:#3a4a62;vertical-align:middle;}
.data-table tr:last-child td{border-bottom:none;}
.data-table tr:hover td{background:rgba(11,28,56,.015);}
.post-title{font-weight:600;color:#0b1c38;font-size:13px;line-height:1.3;}
.post-slug{font-family:'DM Mono',monospace;font-size:10px;color:#8a9bbf;margin-top:2px;}
.tag-category{display:inline-block;padding:3px 9px;background:rgba(201,168,76,.1);color:#9a7a2e;font-size:10px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;border:1px solid rgba(201,168,76,.25);}
.td-na{color:#c0c8d4;}
.td-author{font-size:12px;}
.td-center{text-align:center;}
.td-date{font-size:11px;color:#8a9bbf;font-family:'DM Mono',monospace;white-space:nowrap;}
.status-badge{display:inline-block;padding:3px 10px;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;}
.status-published{background:rgba(39,174,96,.12);color:#27ae60;border:1px solid rgba(39,174,96,.25);}
.status-draft{background:rgba(138,155,191,.12);color:#5a6a82;border:1px solid rgba(138,155,191,.25);}
.featured-star{color:#c9a84c;font-size:16px;}
.td-actions{display:flex;align-items:center;gap:8px;}
.btn-action{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;font-size:11px;font-weight:500;font-family:'DM Sans',sans-serif;border:1px solid;cursor:pointer;text-decoration:none;transition:background .2s;}
.btn-edit{color:#2980b9;border-color:rgba(41,128,185,.3);background:rgba(41,128,185,.06);}
.btn-edit:hover{background:rgba(41,128,185,.14);}
.btn-delete{color:#e74c3c;border-color:rgba(231,76,60,.3);background:rgba(231,76,60,.06);}
.btn-delete:hover{background:rgba(231,76,60,.14);}
.empty-state{display:flex;flex-direction:column;align-items:center;justify-content:center;padding:60px 20px;color:#8a9bbf;gap:12px;font-size:13px;}
.pagination{display:flex;align-items:center;gap:4px;padding:16px;border-top:1px solid rgba(11,28,56,.07);}
.page-link{display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:32px;padding:0 8px;font-size:12px;color:#5a6a82;text-decoration:none;border:1px solid rgba(11,28,56,.1);transition:background .2s,color .2s;}
.page-link.active{background:#0b1c38;color:#c9a84c;border-color:#0b1c38;}
.page-link.disabled{opacity:.4;pointer-events:none;}
.page-link:not(.active):not(.disabled):hover{background:rgba(201,168,76,.08);color:#0b1c38;}
.modal-overlay{position:fixed;inset:0;background:rgba(11,28,56,.6);display:flex;align-items:center;justify-content:center;z-index:500;backdrop-filter:blur(2px);}
.modal{background:#fff;width:420px;max-width:90vw;padding:28px;border-top:2px solid #e74c3c;}
.modal-title{font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:600;color:#0b1c38;margin-bottom:10px;}
.modal-body{font-size:13px;color:#5a6a82;line-height:1.6;margin-bottom:24px;}
.modal-actions{display:flex;justify-content:flex-end;gap:10px;}
.btn-ghost{padding:9px 18px;background:none;border:1px solid rgba(11,28,56,.15);color:#5a6a82;font-size:12px;cursor:pointer;}
.btn-danger{padding:9px 18px;background:#e74c3c;border:1px solid #e74c3c;color:#fff;font-size:12px;font-weight:600;cursor:pointer;}
.btn-danger:hover{background:#c0392b;}
</style>
