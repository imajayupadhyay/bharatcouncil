<template>
  <aside class="admin-sidebar" :class="{ collapsed }">
    <div class="sidebar-logo">
      <img :src="'/BGC.png'" alt="BGC" class="sidebar-logo-img" />
      <span v-if="!collapsed" class="sidebar-logo-label">Admin</span>
    </div>

    <nav class="sidebar-nav">
      <div class="nav-group-label" v-if="!collapsed">Overview</div>
      <Link
        v-for="item in navItems" :key="item.id"
        :href="item.href" class="nav-item"
        :class="{ active: item.id === activeId }"
        :title="collapsed ? item.label : ''"
      >
        <span class="nav-icon" v-html="item.icon"/>
        <span v-if="!collapsed" class="nav-label">{{ item.label }}</span>
        <span v-if="!collapsed && item.badge" class="nav-badge">{{ item.badge }}</span>
      </Link>
    </nav>

    <button class="sidebar-toggle" @click="$emit('toggle')" title="Toggle sidebar">
      <svg viewBox="0 0 16 16" fill="none" width="14" height="14" :class="{ flipped: collapsed }">
        <path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
      </svg>
    </button>

    <div class="sidebar-footer">
      <button type="button" class="btn-logout" @click="logout">
        <svg viewBox="0 0 16 16" fill="none" width="14" height="14">
          <path d="M6 3H3a1 1 0 00-1 1v8a1 1 0 001 1h3M10 5l3 3-3 3M13 8H6" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span v-if="!collapsed">Logout</span>
      </button>
    </div>
  </aside>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import { navItems } from '@/Pages/Admin/navItems'

defineProps({
  activeId: { type: String, required: true },
  collapsed: { type: Boolean, default: false },
})

defineEmits(['toggle'])

function logout() {
  if (confirm('Are you sure you want to logout?')) {
    router.post('/admin/logout')
  }
}
</script>

<style scoped>
.admin-sidebar{width:240px;flex-shrink:0;background:#0b1c38;display:flex;flex-direction:column;border-right:1px solid rgba(201,168,76,0.12);transition:width .3s cubic-bezier(.4,0,.2,1);position:sticky;top:0;height:100vh;overflow:hidden;}
.admin-sidebar.collapsed{width:64px;}
.sidebar-logo{display:flex;align-items:center;gap:12px;padding:20px 18px;border-bottom:1px solid rgba(255,255,255,0.06);flex-shrink:0;}
.sidebar-logo-img{width:44px;height:auto;object-fit:contain;flex-shrink:0;}
.sidebar-logo-label{font-size:9px;font-weight:700;color:#c9a84c;letter-spacing:.3em;text-transform:uppercase;font-family:'DM Mono',monospace;white-space:nowrap;}

.sidebar-nav{flex:1;padding:20px 10px;display:flex;flex-direction:column;gap:2px;overflow-y:auto;overflow-x:hidden;}
.nav-group-label{font-size:8px;font-weight:700;color:rgba(138,155,191,.35);letter-spacing:.3em;text-transform:uppercase;padding:0 8px;margin-bottom:6px;white-space:nowrap;font-family:'DM Sans',sans-serif;}
.nav-item{display:flex;align-items:center;gap:12px;padding:10px 12px;color:#8a9bbf;text-decoration:none;font-size:13px;font-weight:500;position:relative;transition:color .2s,background .2s;white-space:nowrap;overflow:hidden;}
.nav-item::before{content:'';position:absolute;left:0;top:0;bottom:0;width:2px;background:linear-gradient(to bottom,#c9a84c,#e8cf8a);transform:scaleY(0);transition:transform .25s;}
.nav-item:hover{color:#e8cf8a;background:rgba(255,255,255,.04);} 
.nav-item.active{color:#e8cf8a;background:rgba(201,168,76,.08);} 
.nav-item.active::before{transform:scaleY(1);} 
.nav-icon{display:flex;align-items:center;justify-content:center;flex-shrink:0;width:16px;} 
.nav-label{flex:1;}
.nav-badge{display:inline-flex;align-items:center;justify-content:center;padding:2px 8px;border-radius:999px;background:rgba(201,168,76,.15);color:#e8cf8a;font-size:9px;font-weight:700;letter-spacing:.08em;}

.sidebar-toggle{display:flex;align-items:center;justify-content:center;width:100%;padding:12px;background:none;border:none;border-top:1px solid rgba(255,255,255,.05);color:rgba(138,155,191,.4);cursor:pointer;transition:color .2s;flex-shrink:0;}
.sidebar-toggle:hover{color:#c9a84c;}
.sidebar-toggle svg{transition:transform .3s;}
.sidebar-toggle svg.flipped{transform:rotate(180deg);} 

.sidebar-footer{padding:12px 10px;border-top:1px solid rgba(255,255,255,.05);flex-shrink:0;}
.btn-logout{display:flex;align-items:center;gap:10px;width:100%;padding:10px 12px;background:none;border:none;color:rgba(138,155,191,.5);font-size:13px;font-family:'DM Sans',sans-serif;cursor:pointer;white-space:nowrap;overflow:hidden;transition:color .2s,background .2s;}
.btn-logout:hover{color:#e74c3c;background:rgba(231,76,60,.08);} 

@media (max-width: 768px){
  .admin-sidebar{width:64px;}
  .sidebar-logo-label,.nav-label,.nav-badge,.nav-group-label,.btn-logout span{display:none;}
}
</style>
