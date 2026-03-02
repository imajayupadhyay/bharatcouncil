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
          :class="{ active: item.id === 'homepage' }"
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
          <h2 class="topbar-title">Homepage Manager</h2>
          <div class="topbar-breadcrumb">
            <span>Admin</span><span class="bc-sep">›</span>
            <span class="bc-active">Homepage</span>
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

        <!-- Flash messages -->
        <div v-if="$page.props.flash?.success" class="flash flash-success">{{ $page.props.flash.success }}</div>
        <div v-if="$page.props.flash?.error" class="flash flash-error">{{ $page.props.flash.error }}</div>

        <div class="page-header">
          <div>
            <h1 class="page-title">Homepage Sections</h1>
            <p class="page-sub">Manage the content displayed on your public homepage. Edit each section below.</p>
          </div>
        </div>

        <!-- ══════════ HERO SECTION ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="heroOpen = !heroOpen">
            <div class="section-panel-left">
              <span class="section-num">01</span>
              <div>
                <h3 class="section-panel-title">Hero Section</h3>
                <p class="section-panel-desc">Main headline, subtext, buttons, and stat cards</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: heroOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>

          <Transition name="panel-slide">
            <div v-if="heroOpen" class="section-panel-body">
              <form @submit.prevent="saveHero">

                <!-- Eyebrow -->
                <div class="form-group-label">Eyebrow</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Eyebrow Text</label>
                    <input v-model="hero.eyebrow_text" type="text" class="form-input" placeholder="Bharat Governance Council" />
                  </div>
                  <div class="form-group">
                    <label>Eyebrow Tag</label>
                    <input v-model="hero.eyebrow_tag" type="text" class="form-input" placeholder="Est. 2024" />
                  </div>
                </div>

                <!-- Headline -->
                <div class="form-group-label">Headline</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Line 1 (plain text)</label>
                    <input v-model="hero.headline_line1" type="text" class="form-input" placeholder="A Community for" />
                  </div>
                  <div class="form-group">
                    <label>Line 2 (gold italic text)</label>
                    <input v-model="hero.headline_line2" type="text" class="form-input" placeholder="Better Governance." />
                  </div>
                </div>

                <!-- Subtext -->
                <div class="form-group">
                  <label>Subtext</label>
                  <textarea v-model="hero.subtext" class="form-input form-textarea" rows="3" placeholder="Connecting citizens, policy thinkers..."></textarea>
                </div>

                <!-- Buttons -->
                <div class="form-group-label">Action Buttons</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Primary Button Text</label>
                    <input v-model="hero.btn_primary_text" type="text" class="form-input" placeholder="Join the Council" />
                  </div>
                  <div class="form-group">
                    <label>Primary Button Link</label>
                    <input v-model="hero.btn_primary_link" type="text" class="form-input" placeholder="#" />
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Secondary Button Text</label>
                    <input v-model="hero.btn_secondary_text" type="text" class="form-input" placeholder="Explore Research" />
                  </div>
                  <div class="form-group">
                    <label>Secondary Button Link</label>
                    <input v-model="hero.btn_secondary_link" type="text" class="form-input" placeholder="#featured" />
                  </div>
                </div>

                <!-- Stats -->
                <div class="form-group-label">Stat Cards</div>
                <div v-for="(stat, i) in hero.stats" :key="i" class="stat-row">
                  <span class="stat-row-num">{{ i + 1 }}</span>
                  <div class="form-group">
                    <label>Label</label>
                    <input v-model="stat.label" type="text" class="form-input" />
                  </div>
                  <div class="form-group form-group-sm">
                    <label>Number</label>
                    <input v-model.number="stat.target" type="number" class="form-input" />
                  </div>
                  <div class="form-group form-group-sm">
                    <label>Suffix</label>
                    <input v-model="stat.suffix" type="text" class="form-input" placeholder="K+" />
                  </div>
                  <div class="form-group form-group-sm">
                    <label>Icon</label>
                    <input v-model="stat.icon" type="text" class="form-input" placeholder="◈" />
                  </div>
                </div>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetHero">Reset to Default</button>
                  <button type="submit" class="btn-save" :disabled="heroSaving">
                    {{ heroSaving ? 'Saving...' : 'Save Hero Section' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

        <!-- Placeholder panels for future sections -->
        <div class="section-panel section-panel-locked" v-for="s in upcomingSections" :key="s.num">
          <div class="section-panel-header">
            <div class="section-panel-left">
              <span class="section-num">{{ s.num }}</span>
              <div>
                <h3 class="section-panel-title">{{ s.title }}</h3>
                <p class="section-panel-desc">{{ s.desc }}</p>
              </div>
            </div>
            <span class="coming-soon-badge">Coming Soon</span>
          </div>
        </div>

      </div>
    </main>

  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import { navItems } from '../navItems.js'

const props = defineProps({
  admin:    Object,
  sections: Object,
})

const mounted          = ref(false)
const sidebarCollapsed = ref(false)
const heroOpen         = ref(true)
const heroSaving       = ref(false)

// ── Hero defaults ────────────────────────────────────────
const heroDefaults = {
  eyebrow_text:       'Bharat Governance Council',
  eyebrow_tag:        'Est. 2024',
  headline_line1:     'A Community for',
  headline_line2:     'Better Governance.',
  subtext:            'Connecting citizens, policy thinkers, and civic leaders to research, debate, and shape the future of India\'s governance.',
  btn_primary_text:   'Join the Council',
  btn_primary_link:   '#',
  btn_secondary_text: 'Explore Research',
  btn_secondary_link: '#featured',
  stats: [
    { label: 'Members',       suffix: 'K+', target: 5,   icon: '◈' },
    { label: 'Publications',  suffix: '+',  target: 120, icon: '◇' },
    { label: 'Events Hosted', suffix: '+',  target: 48,  icon: '◆' },
  ],
}

// Merge saved data over defaults
const savedHero = props.sections?.hero || {}
const hero = reactive({
  ...heroDefaults,
  ...savedHero,
  stats: savedHero.stats?.length ? savedHero.stats.map(s => ({ ...s })) : heroDefaults.stats.map(s => ({ ...s })),
})

function saveHero() {
  heroSaving.value = true
  router.put('/admin/homepage/hero', {
    data: {
      eyebrow_text:       hero.eyebrow_text,
      eyebrow_tag:        hero.eyebrow_tag,
      headline_line1:     hero.headline_line1,
      headline_line2:     hero.headline_line2,
      subtext:            hero.subtext,
      btn_primary_text:   hero.btn_primary_text,
      btn_primary_link:   hero.btn_primary_link,
      btn_secondary_text: hero.btn_secondary_text,
      btn_secondary_link: hero.btn_secondary_link,
      stats:              hero.stats,
    },
  }, {
    preserveScroll: true,
    onFinish: () => { heroSaving.value = false },
  })
}

function resetHero() {
  Object.assign(hero, {
    ...heroDefaults,
    stats: heroDefaults.stats.map(s => ({ ...s })),
  })
}

// ── Upcoming sections ────────────────────────────────────
const upcomingSections = [
  { num: '02', title: 'Featured Section',      desc: 'Featured research and spotlight content' },
  { num: '03', title: 'Focus Areas',           desc: 'Key governance focus areas and pillars' },
  { num: '04', title: 'Events Section',        desc: 'Upcoming events and programmes' },
  { num: '05', title: 'Voices Section',        desc: 'Council members and their voices' },
  { num: '06', title: 'Publications Section',  desc: 'Latest publications and reports' },
  { num: '07', title: 'Discussions Section',    desc: 'Community discussions and forums' },
  { num: '08', title: 'Newsletter Section',    desc: 'Newsletter subscription callout' },
]

function logout() { router.post('/admin/logout') }

onMounted(() => requestAnimationFrame(() => setTimeout(() => { mounted.value = true }, 60)))
</script>

<style scoped>
/* ── Layout (shared admin pattern) ── */
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

/* ── Content ── */
.content-wrap{padding:28px;opacity:0;transform:translateY(12px);transition:opacity .6s,transform .6s;overflow-y:auto;flex:1;}
.content-wrap.visible{opacity:1;transform:translateY(0);}
.flash{display:flex;align-items:center;gap:10px;padding:12px 16px;font-size:13px;margin-bottom:20px;}
.flash-success{background:rgba(39,174,96,.1);color:#27ae60;border-left:3px solid #27ae60;}
.flash-error{background:rgba(231,76,60,.1);color:#e74c3c;border-left:3px solid #e74c3c;}
.page-header{margin-bottom:28px;}
.page-title{font-family:'Cormorant Garamond',serif;font-size:26px;font-weight:600;color:#0b1c38;margin-bottom:4px;}
.page-sub{font-size:13px;color:#8a9bbf;line-height:1.5;}

/* ── Section panels ── */
.section-panel{background:#fff;border:1px solid rgba(11,28,56,.07);box-shadow:0 2px 12px rgba(11,28,56,.04);margin-bottom:12px;overflow:hidden;}
.section-panel-header{display:flex;align-items:center;justify-content:space-between;padding:18px 24px;cursor:pointer;transition:background .2s;user-select:none;}
.section-panel-header:hover{background:rgba(11,28,56,.015);}
.section-panel-left{display:flex;align-items:center;gap:16px;}
.section-num{font-family:'DM Mono',monospace;font-size:11px;font-weight:700;color:#c9a84c;letter-spacing:.1em;padding:4px 10px;border:1px solid rgba(201,168,76,.25);background:rgba(201,168,76,.06);flex-shrink:0;}
.section-panel-title{font-family:'Cormorant Garamond',serif;font-size:18px;font-weight:600;color:#0b1c38;line-height:1.2;}
.section-panel-desc{font-size:12px;color:#8a9bbf;margin-top:2px;}
.section-chevron{color:#8a9bbf;transition:transform .3s;flex-shrink:0;}
.section-chevron.open{transform:rotate(180deg);color:#c9a84c;}
.section-panel-body{padding:0 24px 24px;}

/* Panel slide transition */
.panel-slide-enter-active,.panel-slide-leave-active{transition:all .3s ease;overflow:hidden;}
.panel-slide-enter-from,.panel-slide-leave-to{opacity:0;max-height:0;padding-top:0;padding-bottom:0;}
.panel-slide-enter-to,.panel-slide-leave-from{opacity:1;max-height:2000px;}

/* ── Form styles ── */
.form-group-label{font-size:9px;font-weight:700;color:#c9a84c;letter-spacing:.25em;text-transform:uppercase;margin:20px 0 10px;padding-bottom:6px;border-bottom:1px solid rgba(201,168,76,.15);}
.form-group-label:first-child{margin-top:4px;}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.form-group{display:flex;flex-direction:column;gap:5px;margin-bottom:14px;}
.form-group label{font-size:11px;font-weight:600;color:#5a6a82;letter-spacing:.04em;}
.form-input{padding:10px 14px;border:1px solid rgba(11,28,56,.15);background:#fff;font-size:13px;font-family:'DM Sans',sans-serif;color:#0b1c38;outline:none;transition:border-color .2s,box-shadow .2s;}
.form-input:focus{border-color:#c9a84c;box-shadow:0 0 0 2px rgba(201,168,76,.12);}
.form-textarea{resize:vertical;min-height:72px;line-height:1.6;}
.form-group-sm{max-width:120px;}

/* Stat rows */
.stat-row{display:flex;align-items:flex-end;gap:12px;margin-bottom:10px;padding:12px 14px;background:rgba(11,28,56,.02);border:1px solid rgba(11,28,56,.06);}
.stat-row .form-group{margin-bottom:0;flex:1;}
.stat-row-num{font-family:'DM Mono',monospace;font-size:10px;color:rgba(201,168,76,.5);font-weight:700;flex-shrink:0;margin-bottom:8px;}

/* Form actions */
.form-actions{display:flex;align-items:center;justify-content:flex-end;gap:12px;margin-top:24px;padding-top:20px;border-top:1px solid rgba(11,28,56,.07);}
.btn-reset{padding:10px 20px;background:none;border:1px solid rgba(11,28,56,.15);color:#5a6a82;font-size:12px;font-weight:500;cursor:pointer;transition:background .2s,border-color .2s;}
.btn-reset:hover{background:rgba(11,28,56,.04);border-color:rgba(11,28,56,.25);}
.btn-save{padding:10px 28px;background:#0b1c38;color:#c9a84c;border:1px solid rgba(201,168,76,.3);font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;cursor:pointer;transition:background .2s;}
.btn-save:hover{background:#162d55;}
.btn-save:disabled{opacity:.5;cursor:not-allowed;}

/* ── Locked / upcoming sections ── */
.section-panel-locked .section-panel-header{cursor:default;}
.section-panel-locked .section-panel-header:hover{background:transparent;}
.section-panel-locked .section-panel-title{color:#8a9bbf;}
.coming-soon-badge{font-size:9px;font-weight:700;color:#8a9bbf;letter-spacing:.12em;text-transform:uppercase;padding:4px 12px;border:1px solid rgba(138,155,191,.25);background:rgba(138,155,191,.06);font-family:'DM Mono',monospace;}
</style>
