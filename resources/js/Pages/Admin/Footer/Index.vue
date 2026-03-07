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
            :class="{ active: item.id === 'footer' }"
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
          <h2 class="topbar-title">Footer Manager</h2>
          <div class="topbar-breadcrumb">
            <span>Admin</span><span class="bc-sep">›</span>
            <span class="bc-active">Footer</span>
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
        <div v-if="$page.props.flash?.error"   class="flash flash-error">{{ $page.props.flash.error }}</div>

        <div class="page-header">
          <div>
            <h1 class="page-title">Footer Settings</h1>
            <p class="page-sub">Manage the global footer content displayed on every page of the website.</p>
          </div>
        </div>

        <!-- ══════════ BRAND SECTION ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="brandOpen = !brandOpen">
            <div class="section-panel-left">
              <span class="section-num">01</span>
              <div>
                <h3 class="section-panel-title">Brand & Socials</h3>
                <p class="section-panel-desc">Footer tagline and social media links</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: brandOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>
          <Transition name="panel-slide">
            <div v-if="brandOpen" class="section-panel-body">
              <form @submit.prevent="saveBrand">

                <p class="form-group-label">Brand Description</p>
                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label">Tagline / Description</label>
                    <textarea v-model="brand.description" class="form-textarea" rows="3" placeholder="A community of citizens, scholars…" />
                  </div>
                </div>

                <p class="form-group-label" style="margin-top:24px">Social Media Links</p>
                <div
                  v-for="(s, i) in brand.socials" :key="i"
                  class="array-row"
                >
                  <select v-model="s.platform" class="form-input" style="flex:0 0 160px">
                    <option value="twitter">Twitter / X</option>
                    <option value="linkedin">LinkedIn</option>
                    <option value="youtube">YouTube</option>
                    <option value="telegram">Telegram</option>
                    <option value="instagram">Instagram</option>
                    <option value="facebook">Facebook</option>
                  </select>
                  <input v-model="s.label" class="form-input" style="flex:0 0 160px" placeholder="Display label" />
                  <input v-model="s.url"   class="form-input" style="flex:1"          placeholder="https://..." />
                  <button type="button" class="btn-remove-row" @click="removeSocial(i)">
                    <svg viewBox="0 0 16 16" fill="none" width="13" height="13">
                      <path d="M3 3l10 10M13 3L3 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                  </button>
                </div>
                <button type="button" class="btn-add-row" @click="addSocial">
                  <svg viewBox="0 0 16 16" fill="none" width="13" height="13">
                    <path d="M8 3v10M3 8h10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                  </svg>
                  Add Social
                </button>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetBrand">Reset</button>
                  <button type="submit" class="btn-save" :disabled="brandSaving">
                    {{ brandSaving ? 'Saving…' : 'Save Brand & Socials' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

        <!-- ══════════ NAVIGATION COLUMNS ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="columnsOpen = !columnsOpen">
            <div class="section-panel-left">
              <span class="section-num">02</span>
              <div>
                <h3 class="section-panel-title">Navigation Columns</h3>
                <p class="section-panel-desc">Footer link columns — add, remove, reorder headings and links</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: columnsOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>
          <Transition name="panel-slide">
            <div v-if="columnsOpen" class="section-panel-body">
              <form @submit.prevent="saveColumns">

                <div
                  v-for="(col, ci) in columnsData.cols" :key="ci"
                  class="col-block"
                >
                  <div class="col-block-header">
                    <span class="col-num">Col {{ ci + 1 }}</span>
                    <input v-model="col.heading" class="form-input col-heading-input" placeholder="Column heading (e.g. Research)" />
                    <button type="button" class="btn-remove-col" @click="removeColumn(ci)" title="Remove column">
                      <svg viewBox="0 0 16 16" fill="none" width="13" height="13">
                        <path d="M3 3l10 10M13 3L3 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                      </svg>
                    </button>
                  </div>

                  <div class="col-links">
                    <div
                      v-for="(link, li) in col.links" :key="li"
                      class="array-row"
                    >
                      <input v-model="link.label" class="form-input" style="flex:1"   placeholder="Link label (e.g. Publications)" />
                      <input v-model="link.url"   class="form-input" style="flex:1"   placeholder="/path or https://…" />
                      <button type="button" class="btn-remove-row" @click="removeLink(ci, li)">
                        <svg viewBox="0 0 16 16" fill="none" width="13" height="13">
                          <path d="M3 3l10 10M13 3L3 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                      </button>
                    </div>
                    <button type="button" class="btn-add-row" @click="addLink(ci)">
                      <svg viewBox="0 0 16 16" fill="none" width="13" height="13">
                        <path d="M8 3v10M3 8h10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                      </svg>
                      Add Link
                    </button>
                  </div>
                </div>

                <button type="button" class="btn-add-col" @click="addColumn">
                  <svg viewBox="0 0 16 16" fill="none" width="13" height="13">
                    <path d="M8 3v10M3 8h10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                  </svg>
                  Add Column
                </button>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetColumns">Reset</button>
                  <button type="submit" class="btn-save" :disabled="columnsSaving">
                    {{ columnsSaving ? 'Saving…' : 'Save Navigation Columns' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

        <!-- ══════════ BOTTOM BAR ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="legalOpen = !legalOpen">
            <div class="section-panel-left">
              <span class="section-num">03</span>
              <div>
                <h3 class="section-panel-title">Bottom Bar</h3>
                <p class="section-panel-desc">Copyright text, website link, and legal/policy links</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: legalOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>
          <Transition name="panel-slide">
            <div v-if="legalOpen" class="section-panel-body">
              <form @submit.prevent="saveLegal">

                <p class="form-group-label">Copyright</p>
                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label">Organisation Name</label>
                    <input v-model="legalData.copyright_name" class="form-input" placeholder="Bharat Governance Council" />
                    <span class="form-hint">Displayed as: © 2025 [Name]</span>
                  </div>
                </div>

                <p class="form-group-label" style="margin-top:24px">Website Link</p>
                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label">Display Label</label>
                    <input v-model="legalData.website_label" class="form-input" placeholder="bharatgovernancecouncil.org" />
                  </div>
                  <div class="form-group">
                    <label class="form-label">URL</label>
                    <input v-model="legalData.website_url" class="form-input" placeholder="https://bharatgovernancecouncil.org" />
                  </div>
                </div>

                <p class="form-group-label" style="margin-top:24px">Legal Links</p>
                <div
                  v-for="(link, i) in legalData.links" :key="i"
                  class="array-row"
                >
                  <input v-model="link.label" class="form-input" style="flex:1" placeholder="Link label (e.g. Privacy Policy)" />
                  <input v-model="link.url"   class="form-input" style="flex:1" placeholder="/privacy or https://…" />
                  <button type="button" class="btn-remove-row" @click="removeLegalLink(i)">
                    <svg viewBox="0 0 16 16" fill="none" width="13" height="13">
                      <path d="M3 3l10 10M13 3L3 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                  </button>
                </div>
                <button type="button" class="btn-add-row" @click="addLegalLink">
                  <svg viewBox="0 0 16 16" fill="none" width="13" height="13">
                    <path d="M8 3v10M3 8h10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                  </svg>
                  Add Legal Link
                </button>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetLegal">Reset</button>
                  <button type="submit" class="btn-save" :disabled="legalSaving">
                    {{ legalSaving ? 'Saving…' : 'Save Bottom Bar' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

        <!-- ══════════ NEWSLETTER WIDGET ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="newsletterOpen = !newsletterOpen">
            <div class="section-panel-left">
              <span class="section-num">04</span>
              <div>
                <h3 class="section-panel-title">Newsletter Widget</h3>
                <p class="section-panel-desc">Heading and sub-text for the newsletter sign-up in the footer</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: newsletterOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>
          <Transition name="panel-slide">
            <div v-if="newsletterOpen" class="section-panel-body">
              <form @submit.prevent="saveNewsletter">

                <p class="form-group-label">Newsletter Copy</p>
                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label">Heading</label>
                    <input v-model="newsletterData.heading" class="form-input" placeholder="Stay Updated" />
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label">Sub Text</label>
                    <input v-model="newsletterData.sub" class="form-input" placeholder="Get the weekly policy digest in your inbox." />
                  </div>
                </div>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetNewsletter">Reset</button>
                  <button type="submit" class="btn-save" :disabled="newsletterSaving">
                    {{ newsletterSaving ? 'Saving…' : 'Save Newsletter Widget' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import { navGroups } from '../navItems'

const props = defineProps({
  sections: { type: Object, default: () => ({}) },
})

const page             = usePage()
const admin            = computed(() => page.props.auth?.admin)
const sidebarCollapsed = ref(false)
const mounted          = ref(false)

function logout() {
  router.post('/admin/logout')
}

function deepClone(obj) {
  return JSON.parse(JSON.stringify(obj))
}

/* ── Brand & Socials ─────────────────────────────────── */
const brandDefaults = {
  description: 'A community of citizens, scholars, and practitioners committed to evidence-based governance in Bharat.',
  socials: [
    { platform: 'twitter',  label: 'Twitter / X', url: '#' },
    { platform: 'linkedin', label: 'LinkedIn',     url: '#' },
    { platform: 'youtube',  label: 'YouTube',      url: '#' },
    { platform: 'telegram', label: 'Telegram',     url: '#' },
  ],
}
const brand        = reactive(deepClone({ ...brandDefaults, ...(props.sections?.brand ?? {}) }))
const brandOpen    = ref(true)
const brandSaving  = ref(false)
function addSocial()    { brand.socials.push({ platform: 'twitter', label: '', url: '' }) }
function removeSocial(i){ brand.socials.splice(i, 1) }
function saveBrand() {
  brandSaving.value = true
  router.put('/admin/footer/brand', { data: { ...brand } }, {
    preserveScroll: true,
    onFinish: () => (brandSaving.value = false),
  })
}
function resetBrand() { Object.assign(brand, deepClone(brandDefaults)) }

/* ── Navigation Columns ──────────────────────────────── */
const columnsDefaults = {
  cols: [
    { heading: 'Research',     links: [{ label: 'Publications', url: '#' }, { label: 'Policy Briefs', url: '#' }, { label: 'Explainers', url: '#' }, { label: 'Data Library', url: '#' }] },
    { heading: 'Community',    links: [{ label: 'Discussions', url: '#' },  { label: 'Events', url: '#' },        { label: 'Council Members', url: '#' }, { label: 'Become a Fellow', url: '#' }] },
    { heading: 'Organisation', links: [{ label: 'About BGC', url: '#' },    { label: 'Our Team', url: '#' },      { label: 'Press Kit', url: '#' }, { label: 'Contact', url: '#' }] },
  ],
}
const columnsData    = reactive(deepClone({ ...columnsDefaults, ...(props.sections?.columns ?? {}) }))
const columnsOpen    = ref(false)
const columnsSaving  = ref(false)
function addColumn()          { columnsData.cols.push({ heading: 'New Column', links: [] }) }
function removeColumn(i)      { columnsData.cols.splice(i, 1) }
function addLink(ci)          { columnsData.cols[ci].links.push({ label: '', url: '' }) }
function removeLink(ci, li)   { columnsData.cols[ci].links.splice(li, 1) }
function saveColumns() {
  columnsSaving.value = true
  router.put('/admin/footer/columns', { data: deepClone(columnsData) }, {
    preserveScroll: true,
    onFinish: () => (columnsSaving.value = false),
  })
}
function resetColumns() { Object.assign(columnsData, deepClone(columnsDefaults)) }

/* ── Bottom Bar / Legal ──────────────────────────────── */
const legalDefaults = {
  copyright_name: 'Bharat Governance Council',
  website_label:  'bharatgovernancecouncil.org',
  website_url:    '#',
  links: [
    { label: 'Privacy Policy', url: '#' },
    { label: 'Terms of Use',   url: '#' },
    { label: 'Contact',        url: '#' },
  ],
}
const legalData    = reactive(deepClone({ ...legalDefaults, ...(props.sections?.legal ?? {}) }))
const legalOpen    = ref(false)
const legalSaving  = ref(false)
function addLegalLink()    { legalData.links.push({ label: '', url: '' }) }
function removeLegalLink(i){ legalData.links.splice(i, 1) }
function saveLegal() {
  legalSaving.value = true
  router.put('/admin/footer/legal', { data: { ...legalData } }, {
    preserveScroll: true,
    onFinish: () => (legalSaving.value = false),
  })
}
function resetLegal() { Object.assign(legalData, deepClone(legalDefaults)) }

/* ── Newsletter Widget ───────────────────────────────── */
const newsletterDefaults = {
  heading: 'Stay Updated',
  sub:     'Get the weekly policy digest in your inbox.',
}
const newsletterData    = reactive({ ...newsletterDefaults, ...(props.sections?.newsletter ?? {}) })
const newsletterOpen    = ref(false)
const newsletterSaving  = ref(false)
function saveNewsletter() {
  newsletterSaving.value = true
  router.put('/admin/footer/newsletter', { data: { ...newsletterData } }, {
    preserveScroll: true,
    onFinish: () => (newsletterSaving.value = false),
  })
}
function resetNewsletter() { Object.assign(newsletterData, { ...newsletterDefaults }) }

onMounted(() => { setTimeout(() => { mounted.value = true }, 50) })
</script>

<style scoped>
/* ── Layout ──────────────────────────────────────────── */
.admin-root{display:flex;min-height:100vh;background:#0a0f1a;font-family:'DM Sans',sans-serif;}
.admin-sidebar{width:220px;flex-shrink:0;background:#07090f;border-right:1px solid rgba(255,255,255,0.05);display:flex;flex-direction:column;transition:width 0.25s ease;position:sticky;top:0;height:100vh;overflow:hidden;}
.admin-sidebar.collapsed{width:58px;}
.sidebar-logo{display:flex;align-items:center;gap:10px;padding:20px 16px 16px;border-bottom:1px solid rgba(255,255,255,0.05);flex-shrink:0;}
.sidebar-logo-img{width:32px;height:32px;object-fit:contain;flex-shrink:0;}
.sidebar-logo-label{font-size:11px;font-weight:700;color:#c9a84c;letter-spacing:0.22em;text-transform:uppercase;white-space:nowrap;}
.sidebar-nav{flex:1;overflow-y:auto;padding:12px 8px;}
.nav-group-label{font-size:9px;font-weight:700;color:rgba(138,155,191,0.35);letter-spacing:0.2em;text-transform:uppercase;padding:8px 8px 4px;}
.nav-item{display:flex;align-items:center;gap:10px;padding:9px 10px;border-radius:6px;color:rgba(138,155,191,0.6);text-decoration:none;font-size:12.5px;transition:background 0.15s,color 0.15s;white-space:nowrap;overflow:hidden;}
.nav-item:hover{background:rgba(255,255,255,0.04);color:#e8eaf0;}
.nav-item.active{background:rgba(201,168,76,0.1);color:#c9a84c;}
.nav-icon{width:16px;height:16px;flex-shrink:0;display:flex;align-items:center;justify-content:center;}
.sidebar-toggle{margin:8px;padding:8px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:6px;color:rgba(138,155,191,0.4);cursor:pointer;display:flex;align-items:center;justify-content:center;transition:color 0.15s;}
.sidebar-toggle:hover{color:#c9a84c;}
.sidebar-toggle svg{transition:transform 0.25s;}
.sidebar-toggle .flipped{transform:rotate(180deg);}
.sidebar-footer{padding:10px 8px;border-top:1px solid rgba(255,255,255,0.05);}
.btn-logout{display:flex;align-items:center;gap:8px;width:100%;padding:8px 10px;background:none;border:1px solid rgba(255,255,255,0.06);border-radius:6px;color:rgba(138,155,191,0.5);font-size:12px;cursor:pointer;transition:color 0.15s,border-color 0.15s;white-space:nowrap;overflow:hidden;}
.btn-logout:hover{color:#e87c6e;border-color:rgba(232,124,110,0.3);}

/* ── Main ────────────────────────────────────────────── */
.admin-main{flex:1;min-width:0;display:flex;flex-direction:column;}
.admin-topbar{display:flex;align-items:center;justify-content:space-between;padding:16px 32px;background:#07090f;border-bottom:1px solid rgba(255,255,255,0.05);position:sticky;top:0;z-index:10;gap:16px;}
.topbar-left{display:flex;flex-direction:column;gap:2px;}
.topbar-title{font-size:15px;font-weight:600;color:#e8eaf0;letter-spacing:-0.01em;}
.topbar-breadcrumb{display:flex;align-items:center;gap:4px;font-size:11px;color:rgba(138,155,191,0.4);}
.bc-sep{opacity:0.4;}
.bc-active{color:rgba(138,155,191,0.7);}
.topbar-right{display:flex;align-items:center;gap:16px;}
.topbar-live{display:flex;align-items:center;gap:6px;}
.live-dot{width:6px;height:6px;border-radius:50%;background:#2ecc71;box-shadow:0 0 6px rgba(46,204,113,0.5);animation:pulse 2s infinite;}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:0.5}}
.live-label{font-size:11px;color:rgba(138,155,191,0.5);font-family:'DM Mono',monospace;}
.topbar-admin{display:flex;align-items:center;gap:10px;}
.admin-avatar{width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#c9a84c,#e8cf8a);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#0b1c38;}
.admin-info{display:flex;flex-direction:column;gap:1px;}
.admin-name{font-size:12px;font-weight:600;color:#e8eaf0;}
.admin-email{font-size:10px;color:rgba(138,155,191,0.5);}

/* ── Content ─────────────────────────────────────────── */
.content-wrap{padding:32px;max-width:900px;opacity:0;transform:translateY(10px);transition:opacity 0.4s ease,transform 0.4s ease;}
.content-wrap.visible{opacity:1;transform:translateY(0);}
.page-header{margin-bottom:28px;}
.page-title{font-size:22px;font-weight:700;color:#e8eaf0;letter-spacing:-0.02em;margin-bottom:4px;}
.page-sub{font-size:13px;color:rgba(138,155,191,0.6);}

/* ── Flash ───────────────────────────────────────────── */
.flash{padding:12px 16px;border-radius:6px;font-size:13px;margin-bottom:20px;}
.flash-success{background:rgba(46,204,113,0.1);border:1px solid rgba(46,204,113,0.25);color:#2ecc71;}
.flash-error{background:rgba(231,76,60,0.1);border:1px solid rgba(231,76,60,0.25);color:#e74c3c;}

/* ── Section panels ──────────────────────────────────── */
.section-panel{background:#0d1424;border:1px solid rgba(255,255,255,0.06);border-radius:10px;margin-bottom:16px;overflow:hidden;}
.section-panel-header{display:flex;align-items:center;justify-content:space-between;padding:18px 22px;cursor:pointer;user-select:none;transition:background 0.15s;}
.section-panel-header:hover{background:rgba(255,255,255,0.02);}
.section-panel-left{display:flex;align-items:center;gap:14px;}
.section-num{font-family:'DM Mono',monospace;font-size:11px;font-weight:700;color:#c9a84c;letter-spacing:.1em;padding:4px 10px;border:1px solid rgba(201,168,76,.25);background:rgba(201,168,76,.06);flex-shrink:0;}
.section-panel-title{font-size:14px;font-weight:600;color:#e8eaf0;margin-bottom:2px;}
.section-panel-desc{font-size:12px;color:rgba(138,155,191,0.5);}
.section-chevron{color:rgba(138,155,191,0.4);transition:transform 0.25s;}
.section-chevron.open{transform:rotate(180deg);}
.section-panel-body{padding:0 22px 22px;}

/* ── Form elements ───────────────────────────────────── */
.form-group-label{font-size:10px;font-weight:700;color:rgba(201,168,76,0.7);letter-spacing:0.18em;text-transform:uppercase;margin-bottom:12px;}
.form-row{display:flex;gap:14px;margin-bottom:16px;}
.form-group{display:flex;flex-direction:column;gap:6px;flex:1;min-width:0;}
.form-label{font-size:12px;font-weight:500;color:rgba(138,155,191,0.7);}
.form-input{background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:6px;padding:9px 12px;color:#e8eaf0;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;transition:border-color 0.15s,background 0.15s;width:100%;}
.form-input:focus{border-color:rgba(201,168,76,0.4);background:rgba(255,255,255,0.06);}
.form-textarea{background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:6px;padding:9px 12px;color:#e8eaf0;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;resize:vertical;transition:border-color 0.15s;width:100%;}
.form-textarea:focus{border-color:rgba(201,168,76,0.4);}
.form-hint{font-size:11px;color:rgba(138,155,191,0.4);margin-top:2px;}
.form-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:20px;padding-top:16px;border-top:1px solid rgba(255,255,255,0.05);}
.btn-save{padding:9px 22px;background:#c9a84c;border:none;border-radius:6px;font-size:13px;font-weight:600;color:#0b1c38;cursor:pointer;transition:background 0.15s;}
.btn-save:hover{background:#e8cf8a;}
.btn-save:disabled{opacity:0.5;cursor:not-allowed;}
.btn-reset{padding:9px 18px;background:transparent;border:1px solid rgba(255,255,255,0.08);border-radius:6px;font-size:13px;color:rgba(138,155,191,0.6);cursor:pointer;transition:border-color 0.15s,color 0.15s;}
.btn-reset:hover{border-color:rgba(255,255,255,0.18);color:#e8eaf0;}

/* ── Array rows ──────────────────────────────────────── */
.array-row{display:flex;align-items:center;gap:8px;margin-bottom:8px;}
.btn-remove-row{flex-shrink:0;width:30px;height:30px;display:flex;align-items:center;justify-content:center;background:rgba(231,76,60,0.08);border:1px solid rgba(231,76,60,0.15);border-radius:6px;color:rgba(231,76,60,0.6);cursor:pointer;transition:background 0.15s,color 0.15s;}
.btn-remove-row:hover{background:rgba(231,76,60,0.15);color:#e74c3c;}
.btn-add-row{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;background:rgba(201,168,76,0.06);border:1px dashed rgba(201,168,76,0.25);border-radius:6px;color:rgba(201,168,76,0.7);font-size:12px;cursor:pointer;transition:background 0.15s,color 0.15s;margin-top:4px;margin-bottom:16px;}
.btn-add-row:hover{background:rgba(201,168,76,0.1);color:#c9a84c;}

/* ── Column blocks ───────────────────────────────────── */
.col-block{background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:8px;padding:16px;margin-bottom:14px;}
.col-block-header{display:flex;align-items:center;gap:10px;margin-bottom:14px;}
.col-num{font-family:'DM Mono',monospace;font-size:10px;color:rgba(201,168,76,0.5);letter-spacing:0.1em;flex-shrink:0;}
.col-heading-input{flex:1;}
.btn-remove-col{flex-shrink:0;width:30px;height:30px;display:flex;align-items:center;justify-content:center;background:rgba(231,76,60,0.08);border:1px solid rgba(231,76,60,0.15);border-radius:6px;color:rgba(231,76,60,0.6);cursor:pointer;transition:background 0.15s,color 0.15s;}
.btn-remove-col:hover{background:rgba(231,76,60,0.15);color:#e74c3c;}
.col-links{padding-left:8px;}
.btn-add-col{display:flex;align-items:center;gap:8px;padding:10px 18px;background:rgba(201,168,76,0.05);border:1px dashed rgba(201,168,76,0.2);border-radius:8px;color:rgba(201,168,76,0.6);font-size:13px;cursor:pointer;transition:background 0.15s,color 0.15s;width:100%;justify-content:center;margin-top:4px;margin-bottom:16px;}
.btn-add-col:hover{background:rgba(201,168,76,0.1);color:#c9a84c;}

/* ── Transitions ─────────────────────────────────────── */
.panel-slide-enter-active,.panel-slide-leave-active{transition:max-height 0.3s ease,opacity 0.25s ease;}
.panel-slide-enter-from,.panel-slide-leave-to{max-height:0;opacity:0;}
.panel-slide-enter-to,.panel-slide-leave-from{max-height:2000px;opacity:1;}
</style>
