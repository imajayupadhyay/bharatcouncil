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
          :class="{ active: item.id === 'header' }"
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
          <h2 class="topbar-title">Header / Navigation Manager</h2>
          <div class="topbar-breadcrumb">
            <span>Admin</span><span class="bc-sep">›</span>
            <span class="bc-active">Header</span>
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
            <h1 class="page-title">Header & Navigation</h1>
            <p class="page-sub">Drag to reorder menu items. Add sub-items to create dropdown menus. Changes apply site-wide instantly.</p>
          </div>
        </div>


        <!-- ══════════ LOGO ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="logoOpen = !logoOpen">
            <div class="section-panel-left">
              <span class="section-num">01</span>
              <div>
                <h3 class="section-panel-title">Site Logo</h3>
                <p class="section-panel-desc">Upload a new logo or enter a URL — displayed in the header and footer</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: logoOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>
          <Transition name="panel-slide">
            <div v-if="logoOpen" class="section-panel-body">

              <!-- Current logo preview -->
              <div class="logo-preview-row">
                <div class="logo-preview-box">
                  <img :src="currentLogoUrl" alt="Current Logo" class="logo-preview-img" />
                </div>
                <div class="logo-preview-meta">
                  <p class="logo-preview-label">Current Logo</p>
                  <p class="logo-preview-url">{{ currentLogoUrl }}</p>
                  <span v-if="logoData.isCustom" class="logo-custom-badge">Custom upload</span>
                  <span v-else class="logo-default-badge">Default</span>
                </div>
              </div>

              <!-- Upload zone -->
              <p class="form-group-label" style="margin-top:20px">Upload New Logo</p>
              <div
                class="upload-zone"
                :class="{ dragover: logoDragOver }"
                @dragover.prevent="logoDragOver = true"
                @dragleave="logoDragOver = false"
                @drop.prevent="onLogoDrop"
                @click="$refs.logoFileInput.click()"
              >
                <input
                  ref="logoFileInput"
                  type="file"
                  accept="image/png,image/jpeg,image/jpg,image/svg+xml,image/webp"
                  style="display:none"
                  @change="onLogoFileChange"
                />
                <template v-if="!logoUploadPreview">
                  <svg viewBox="0 0 40 40" fill="none" width="32" height="32">
                    <rect x="4" y="10" width="32" height="22" rx="3" stroke="rgba(201,168,76,0.35)" stroke-width="1.4"/>
                    <path d="M14 22l4-5 4 5 3-3 4 5" stroke="rgba(201,168,76,0.5)" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="13" cy="17" r="2" fill="rgba(201,168,76,0.3)"/>
                  </svg>
                  <p class="upload-hint">
                    <strong>Click to browse</strong> or drag &amp; drop<br>
                    <span>PNG, JPG, SVG, WebP — max 2 MB</span>
                  </p>
                </template>
                <div v-else class="upload-preview-wrap" @click.stop>
                  <img :src="logoUploadPreview" class="upload-preview-img" alt="Preview" />
                  <span class="upload-preview-name">{{ logoUploadFile?.name }}</span>
                </div>
              </div>

              <div v-if="logoUploadPreview" class="upload-actions">
                <button type="button" class="btn-reset" @click="clearLogoUpload">Clear</button>
                <button type="button" class="btn-save" :disabled="logoUploading" @click="uploadLogo">
                  {{ logoUploading ? 'Uploading…' : 'Upload & Set Logo' }}
                </button>
              </div>

              <!-- OR manual URL -->
              <div class="logo-or-divider"><span>or enter a URL / path directly</span></div>

              <p class="form-group-label">Manual Logo URL</p>
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label">Image URL or path (e.g. /BGC.png or https://…)</label>
                  <input v-model="logoData.manualUrl" class="form-input" placeholder="/BGC.png" />
                </div>
              </div>
              <div class="form-actions">
                <button type="button" class="btn-reset" @click="logoData.manualUrl = '/BGC.png'">Reset to Default</button>
                <button type="button" class="btn-save" :disabled="logoUrlSaving" @click="saveLogoUrl">
                  {{ logoUrlSaving ? 'Saving…' : 'Set Logo URL' }}
                </button>
              </div>

            </div>
          </Transition>
        </div>

        <!-- ══════════ NAVIGATION ITEMS ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="navOpen = !navOpen">
            <div class="section-panel-left">
              <span class="section-num">02</span>
              <div>
                <h3 class="section-panel-title">Navigation Items</h3>
                <p class="section-panel-desc">Drag to reorder · Toggle type between Link and Dropdown · Add sub-items for mega menus</p>
              </div>
            </div>
            <div style="display:flex;align-items:center;gap:12px;">
              <span class="item-count-badge">{{ navData.items.length }} items</span>
              <svg class="section-chevron" :class="{ open: navOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
                <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
              </svg>
            </div>
          </div>

          <Transition name="panel-slide">
            <div v-if="navOpen" class="section-panel-body">

              <!-- Drop hint -->
              <div class="dnd-hint">
                <svg viewBox="0 0 16 16" fill="none" width="12" height="12">
                  <path d="M3 4h10M3 8h10M3 12h10" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                </svg>
                Drag the <strong>≡</strong> handle to reorder items
              </div>

              <!-- Nav item cards -->
              <div class="nav-builder">
                <div
                  v-for="(item, i) in navData.items" :key="item.id"
                  class="nav-card"
                  :class="{
                    'drag-over':  dragOverIndex === i && dragFromIndex !== i,
                    'is-dragging': dragFromIndex === i,
                  }"
                  @dragover.prevent="dragOverIndex = i"
                  @dragleave="dragOverIndex = null"
                  @drop.prevent="doDrop(i)"
                >
                  <!-- Card header row -->
                  <div class="card-row">

                    <!-- Drag handle -->
                    <div
                      class="drag-handle"
                      draggable="true"
                      @dragstart="startDrag(i, $event)"
                      @dragend="endDrag"
                      title="Drag to reorder"
                    >
                      <svg viewBox="0 0 16 16" fill="none" width="14" height="14">
                        <path d="M5 4h6M5 8h6M5 12h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                      </svg>
                    </div>

                    <!-- Type pill -->
                    <span class="type-pill" :class="item.type">
                      {{ item.type === 'dropdown' ? '▾ Dropdown' : '→ Link' }}
                    </span>

                    <!-- Label -->
                    <div class="card-field">
                      <span class="field-label">Label</span>
                      <input v-model="item.label" class="form-input" placeholder="e.g. Focus Areas" />
                    </div>

                    <!-- Href (only for link type) -->
                    <div class="card-field" v-if="item.type === 'link'">
                      <span class="field-label">URL / Anchor</span>
                      <input v-model="item.href" class="form-input" placeholder="/#section or /path" />
                    </div>

                    <!-- Type toggle -->
                    <select v-model="item.type" class="form-input type-select" @change="onTypeChange(item)">
                      <option value="link">Link</option>
                      <option value="dropdown">Dropdown</option>
                    </select>

                    <!-- Expand (for dropdown) -->
                    <button
                      v-if="item.type === 'dropdown'"
                      type="button"
                      class="btn-expand"
                      :class="{ open: expandedIndex === i }"
                      @click="toggleExpand(i)"
                      :title="expandedIndex === i ? 'Collapse' : 'Edit sub-items'"
                    >
                      <svg viewBox="0 0 16 16" fill="none" width="13" height="13">
                        <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                      </svg>
                      <span>{{ item.children?.length ?? 0 }} sub-items</span>
                    </button>

                    <!-- Remove -->
                    <button type="button" class="btn-remove-card" @click="removeItem(i)" title="Remove item">
                      <svg viewBox="0 0 16 16" fill="none" width="13" height="13">
                        <path d="M3 3l10 10M13 3L3 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                      </svg>
                    </button>

                  </div>

                  <!-- Sub-items area (dropdown only, when expanded) -->
                  <Transition name="sub-slide">
                    <div v-if="item.type === 'dropdown' && expandedIndex === i" class="sub-area">

                      <div class="sub-area-header">
                        <span class="sub-area-label">Sub-items (dropdown entries)</span>
                        <span class="sub-dnd-hint">Drag ≡ to reorder</span>
                      </div>

                      <div
                        v-for="(child, ci) in item.children" :key="child.id"
                        class="child-card"
                        :class="{
                          'drag-over': childDragOver === `${i}-${ci}` && childDragFrom !== `${i}-${ci}`,
                          'is-dragging': childDragFrom === `${i}-${ci}`,
                        }"
                        @dragover.prevent="childDragOver = `${i}-${ci}`"
                        @dragleave="childDragOver = null"
                        @drop.prevent.stop="doChildDrop(i, ci)"
                      >
                        <!-- Child drag handle -->
                        <div
                          class="drag-handle small"
                          draggable="true"
                          @dragstart.stop="startChildDrag(i, ci, $event)"
                          @dragend.stop="endChildDrag"
                          title="Drag to reorder"
                        >
                          <svg viewBox="0 0 16 16" fill="none" width="12" height="12">
                            <path d="M5 5h6M5 8h6M5 11h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                          </svg>
                        </div>

                        <!-- Num badge -->
                        <div class="child-num-wrap">
                          <span class="field-label">No.</span>
                          <input v-model="child.num" class="form-input num-input" placeholder="01" maxlength="3" />
                        </div>

                        <!-- Label -->
                        <div class="card-field">
                          <span class="field-label">Label</span>
                          <input v-model="child.label" class="form-input" placeholder="Who We Are" />
                        </div>

                        <!-- Desc -->
                        <div class="card-field child-desc-field">
                          <span class="field-label">Description</span>
                          <input v-model="child.desc" class="form-input" placeholder="Short description shown in dropdown" />
                        </div>

                        <!-- Href -->
                        <div class="card-field">
                          <span class="field-label">URL</span>
                          <input v-model="child.href" class="form-input" placeholder="/page-path" />
                        </div>

                        <!-- Remove child -->
                        <button type="button" class="btn-remove-card small" @click="removeChild(i, ci)" title="Remove sub-item">
                          <svg viewBox="0 0 16 16" fill="none" width="12" height="12">
                            <path d="M3 3l10 10M13 3L3 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                          </svg>
                        </button>

                      </div>

                      <!-- Empty state -->
                      <div v-if="!item.children?.length" class="sub-empty">
                        No sub-items yet — click Add Sub-item to build the dropdown menu
                      </div>

                      <button type="button" class="btn-add-row" @click="addChild(i)">
                        <svg viewBox="0 0 16 16" fill="none" width="12" height="12">
                          <path d="M8 3v10M3 8h10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Add Sub-item
                      </button>

                    </div>
                  </Transition>

                </div>

                <!-- Empty state -->
                <div v-if="!navData.items.length" class="builder-empty">
                  <svg viewBox="0 0 40 40" fill="none" width="36" height="36">
                    <rect x="4" y="14" width="32" height="4" rx="2" stroke="rgba(201,168,76,0.4)" stroke-width="1.5"/>
                    <rect x="4" y="22" width="24" height="4" rx="2" stroke="rgba(201,168,76,0.25)" stroke-width="1.5"/>
                    <rect x="4" y="30" width="18" height="4" rx="2" stroke="rgba(201,168,76,0.15)" stroke-width="1.5"/>
                  </svg>
                  <p>No navigation items yet.<br>Click <strong>Add Nav Item</strong> to start building.</p>
                </div>

              </div>

              <!-- Add item + actions -->
              <button type="button" class="btn-add-col" @click="addItem">
                <svg viewBox="0 0 16 16" fill="none" width="13" height="13">
                  <path d="M8 3v10M3 8h10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                Add Nav Item
              </button>

              <div class="form-actions">
                <button type="button" class="btn-reset" @click="resetNav">Reset to Defaults</button>
                <button type="button" class="btn-save" :disabled="navSaving" @click="saveNav">
                  {{ navSaving ? 'Saving…' : 'Save Navigation' }}
                </button>
              </div>

            </div>
          </Transition>
        </div>

        <!-- ══════════ CTA BUTTON ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="ctaOpen = !ctaOpen">
            <div class="section-panel-left">
              <span class="section-num">03</span>
              <div>
                <h3 class="section-panel-title">CTA Button</h3>
                <p class="section-panel-desc">The action button displayed on the right of the navigation bar</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: ctaOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>
          <Transition name="panel-slide">
            <div v-if="ctaOpen" class="section-panel-body">
              <form @submit.prevent="saveCta">
                <p class="form-group-label">Button Details</p>
                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label">Button Label</label>
                    <input v-model="ctaData.label" class="form-input" placeholder="Work With Us" />
                  </div>
                  <div class="form-group">
                    <label class="form-label">Button URL</label>
                    <input v-model="ctaData.href" class="form-input" placeholder="/work-with-us" />
                  </div>
                </div>
                <div class="cta-preview">
                  <span class="cta-preview-label">Preview:</span>
                  <span class="cta-preview-btn">
                    {{ ctaData.label || 'Work With Us' }}
                    <svg viewBox="0 0 16 16" fill="none" width="10" height="10" style="display:inline-block;vertical-align:middle;margin-left:4px">
                      <path d="M3 8h10M8 3l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                  </span>
                </div>
                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetCta">Reset</button>
                  <button type="submit" class="btn-save" :disabled="ctaSaving">
                    {{ ctaSaving ? 'Saving…' : 'Save CTA Button' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

        <!-- ══════════ LIVE PREVIEW HINT ══════════ -->
        <div class="preview-hint-card">
          <svg viewBox="0 0 16 16" fill="none" width="14" height="14">
            <circle cx="8" cy="8" r="6.5" stroke="#c9a84c" stroke-width="1.2"/>
            <path d="M8 7v4M8 5.5v.5" stroke="#c9a84c" stroke-width="1.4" stroke-linecap="round"/>
          </svg>
          <span>Changes are saved to the database immediately and will reflect on the live site. Open the frontend in another tab to preview.</span>
        </div>

      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import { navItems } from '../navItems'

const props = defineProps({
  sections: { type: Object, default: () => ({}) },
})

const page             = usePage()
const admin            = computed(() => page.props.auth?.admin)
const sidebarCollapsed = ref(false)
const mounted          = ref(false)

function logout() { router.post('/admin/logout') }

function uid() { return Math.random().toString(36).slice(2, 9) }

function deepClone(obj) { return JSON.parse(JSON.stringify(obj)) }

/* ── Defaults ──────────────────────────────────────────── */
const navDefaults = {
  items: [
    { id: uid(), type: 'link',     label: 'Focus Areas',  href: '/#focus',        children: [] },
    { id: uid(), type: 'link',     label: 'Publications', href: '/#publications', children: [] },
    { id: uid(), type: 'link',     label: 'Events',       href: '/#events',       children: [] },
    { id: uid(), type: 'link',     label: 'Council',      href: '/#voices',       children: [] },
    { id: uid(), type: 'link',     label: 'Discussions',  href: '/#discussions',  children: [] },
    { id: uid(), type: 'link',     label: 'Insights',     href: '/insights',      children: [] },
    {
      id: uid(), type: 'dropdown', label: 'About', href: '#',
      children: [
        { id: uid(), num: '01', label: 'Who We Are',      desc: 'Our story, founding team & values',         href: '/who-we-are'      },
        { id: uid(), num: '02', label: 'Governing Board', desc: 'Chairman, executive officers & full board',  href: '/governing-board' },
        { id: uid(), num: '03', label: 'Work With Us',    desc: 'Internships, fellowships & membership',     href: '/work-with-us'    },
      ],
    },
  ],
}

const ctaDefaults = {
  label: 'Work With Us',
  href:  '/work-with-us',
}

/* ── State ─────────────────────────────────────────────── */
// Merge saved data with defaults, ensuring every item has an id
function hydrateItems(savedItems, defaultItems) {
  if (!savedItems?.length) return deepClone(defaultItems)
  return savedItems.map(item => ({
    ...item,
    id:       item.id || uid(),
    children: (item.children || []).map(c => ({ ...c, id: c.id || uid() })),
  }))
}

const navData   = reactive({
  items: hydrateItems(props.sections?.navigation?.items, navDefaults.items),
})
const ctaData   = reactive({ ...ctaDefaults, ...(props.sections?.cta ?? {}) })


/* ── Logo ──────────────────────────────────────────────── */
const logoOpen      = ref(true)
const logoDragOver  = ref(false)
const logoUploading = ref(false)
const logoUrlSaving = ref(false)
const logoUploadFile    = ref(null)
const logoUploadPreview = ref(null)
const logoFileInput     = ref(null)

const logoData = reactive({
  manualUrl: props.sections?.logo?.url || '/BGC.png',
  isCustom:  !!props.sections?.logo?.stored_path,
})

const currentLogoUrl = computed(() =>
  props.sections?.logo?.url || logoData.manualUrl || '/BGC.png'
)

function onLogoFileChange(e) {
  const file = e.target.files?.[0]
  if (!file) return
  logoUploadFile.value    = file
  logoUploadPreview.value = URL.createObjectURL(file)
}

function onLogoDrop(e) {
  logoDragOver.value = false
  const file = e.dataTransfer?.files?.[0]
  if (!file || !file.type.startsWith('image/')) return
  logoUploadFile.value    = file
  logoUploadPreview.value = URL.createObjectURL(file)
}

function clearLogoUpload() {
  logoUploadFile.value    = null
  logoUploadPreview.value = null
  if (logoFileInput.value) logoFileInput.value.value = ''
}

function uploadLogo() {
  if (!logoUploadFile.value) return
  logoUploading.value = true
  const formData = new FormData()
  formData.append('logo', logoUploadFile.value)
  formData.append('_method', 'POST')
  router.post('/admin/header/upload-logo', formData, {
    forceFormData: true,
    preserveScroll: true,
    onSuccess: () => { clearLogoUpload() },
    onFinish:  () => { logoUploading.value = false },
  })
}

function saveLogoUrl() {
  logoUrlSaving.value = true
  router.put('/admin/header/logo', { data: { url: logoData.manualUrl, stored_path: null, isCustom: false } }, {
    preserveScroll: true,
    onFinish: () => (logoUrlSaving.value = false),
  })
}

const navOpen   = ref(true)
const ctaOpen   = ref(false)
const navSaving = ref(false)
const ctaSaving = ref(false)

/* ── Expand/collapse ──────────────────────────────────── */
const expandedIndex = ref(null)
function toggleExpand(i) {
  expandedIndex.value = expandedIndex.value === i ? null : i
}

/* ── Type change ──────────────────────────────────────── */
function onTypeChange(item) {
  if (item.type === 'dropdown') {
    if (!item.children) item.children = []
    item.href = '#'
  } else {
    item.children = []
  }
}

/* ── Top-level drag & drop ────────────────────────────── */
const dragFromIndex  = ref(null)
const dragOverIndex  = ref(null)

function startDrag(index, e) {
  dragFromIndex.value = index
  e.dataTransfer.effectAllowed = 'move'
}
function endDrag() {
  dragFromIndex.value = null
  dragOverIndex.value = null
}
function doDrop(toIndex) {
  if (dragFromIndex.value === null || dragFromIndex.value === toIndex) {
    dragOverIndex.value = null
    return
  }
  const items = navData.items
  const [moved] = items.splice(dragFromIndex.value, 1)
  items.splice(toIndex, 0, moved)
  // Adjust expandedIndex if open
  if (expandedIndex.value === dragFromIndex.value) {
    expandedIndex.value = toIndex
  } else if (expandedIndex.value !== null) {
    expandedIndex.value = null
  }
  dragFromIndex.value = null
  dragOverIndex.value = null
}

/* ── Child drag & drop ────────────────────────────────── */
const childDragFrom = ref(null)
const childDragOver = ref(null)

function startChildDrag(pi, ci, e) {
  childDragFrom.value = `${pi}-${ci}`
  e.dataTransfer.effectAllowed = 'move'
}
function endChildDrag() {
  childDragFrom.value = null
  childDragOver.value = null
}
function doChildDrop(toPi, toCi) {
  if (!childDragFrom.value) { childDragOver.value = null; return }
  const [fromPi, fromCi] = childDragFrom.value.split('-').map(Number)
  if (fromPi !== toPi || fromCi === toCi) { childDragOver.value = null; childDragFrom.value = null; return }
  const children = navData.items[toPi].children
  const [moved] = children.splice(fromCi, 1)
  children.splice(toCi, 0, moved)
  childDragFrom.value = null
  childDragOver.value = null
}

/* ── CRUD: top-level items ───────────────────────────── */
function addItem() {
  navData.items.push({ id: uid(), type: 'link', label: 'New Item', href: '/', children: [] })
}
function removeItem(i) {
  navData.items.splice(i, 1)
  if (expandedIndex.value === i) expandedIndex.value = null
}

/* ── CRUD: children ──────────────────────────────────── */
function addChild(pi) {
  const n = (navData.items[pi].children?.length ?? 0) + 1
  navData.items[pi].children.push({
    id:    uid(),
    num:   String(n).padStart(2, '0'),
    label: '',
    desc:  '',
    href:  '/',
  })
}
function removeChild(pi, ci) {
  navData.items[pi].children.splice(ci, 1)
}

/* ── Save / Reset ────────────────────────────────────── */
function saveNav() {
  navSaving.value = true
  router.put('/admin/header/navigation', { data: deepClone(navData) }, {
    preserveScroll: true,
    onFinish: () => (navSaving.value = false),
  })
}
function resetNav() {
  navData.items = hydrateItems(null, navDefaults.items)
  expandedIndex.value = null
}

function saveCta() {
  ctaSaving.value = true
  router.put('/admin/header/cta', { data: { ...ctaData } }, {
    preserveScroll: true,
    onFinish: () => (ctaSaving.value = false),
  })
}
function resetCta() { Object.assign(ctaData, deepClone(ctaDefaults)) }

onMounted(() => { setTimeout(() => { mounted.value = true }, 50) })
</script>

<style scoped>
/* ── Layout ───────────────────────────────────────────── */
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

/* ── Main ─────────────────────────────────────────────── */
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

/* ── Content ──────────────────────────────────────────── */
.content-wrap{padding:32px;max-width:1100px;opacity:0;transform:translateY(10px);transition:opacity 0.4s ease,transform 0.4s ease;}
.content-wrap.visible{opacity:1;transform:translateY(0);}
.page-header{margin-bottom:28px;}
.page-title{font-size:22px;font-weight:700;color:#e8eaf0;letter-spacing:-0.02em;margin-bottom:4px;}
.page-sub{font-size:13px;color:rgba(138,155,191,0.6);}

/* ── Flash ────────────────────────────────────────────── */
.flash{padding:12px 16px;border-radius:6px;font-size:13px;margin-bottom:20px;}
.flash-success{background:rgba(46,204,113,0.1);border:1px solid rgba(46,204,113,0.25);color:#2ecc71;}
.flash-error{background:rgba(231,76,60,0.1);border:1px solid rgba(231,76,60,0.25);color:#e74c3c;}

/* ── Section panels ───────────────────────────────────── */
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

.item-count-badge{font-family:'DM Mono',monospace;font-size:10px;color:rgba(201,168,76,0.6);background:rgba(201,168,76,0.07);border:1px solid rgba(201,168,76,0.2);padding:3px 10px;border-radius:20px;}

/* ── Form ─────────────────────────────────────────────── */
.form-group-label{font-size:10px;font-weight:700;color:rgba(201,168,76,0.7);letter-spacing:0.18em;text-transform:uppercase;margin-bottom:12px;}
.form-row{display:flex;gap:14px;margin-bottom:16px;}
.form-group{display:flex;flex-direction:column;gap:6px;flex:1;min-width:0;}
.form-label{font-size:12px;font-weight:500;color:rgba(138,155,191,0.7);}
.form-input{background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:6px;padding:8px 11px;color:#e8eaf0;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;transition:border-color 0.15s,background 0.15s;width:100%;box-sizing:border-box;}
.form-input:focus{border-color:rgba(201,168,76,0.4);background:rgba(255,255,255,0.06);}
.form-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:20px;padding-top:16px;border-top:1px solid rgba(255,255,255,0.05);}
.btn-save{padding:9px 22px;background:#c9a84c;border:none;border-radius:6px;font-size:13px;font-weight:600;color:#0b1c38;cursor:pointer;transition:background 0.15s;}
.btn-save:hover{background:#e8cf8a;}
.btn-save:disabled{opacity:0.5;cursor:not-allowed;}
.btn-reset{padding:9px 18px;background:transparent;border:1px solid rgba(255,255,255,0.08);border-radius:6px;font-size:13px;color:rgba(138,155,191,0.6);cursor:pointer;transition:border-color 0.15s,color 0.15s;}
.btn-reset:hover{border-color:rgba(255,255,255,0.18);color:#e8eaf0;}

/* ── DnD hint ─────────────────────────────────────────── */
.dnd-hint{display:flex;align-items:center;gap:7px;font-size:11px;color:rgba(138,155,191,0.4);background:rgba(255,255,255,0.02);border:1px dashed rgba(255,255,255,0.06);border-radius:6px;padding:8px 14px;margin-bottom:16px;}
.dnd-hint strong{color:rgba(201,168,76,0.7);}

/* ── Nav builder ──────────────────────────────────────── */
.nav-builder{display:flex;flex-direction:column;gap:8px;margin-bottom:12px;}

/* Nav card */
.nav-card{background:rgba(255,255,255,0.025);border:1px solid rgba(255,255,255,0.07);border-radius:8px;overflow:hidden;transition:border-color 0.15s,box-shadow 0.15s;}
.nav-card.drag-over{border-color:rgba(201,168,76,0.5);box-shadow:0 0 0 2px rgba(201,168,76,0.12);background:rgba(201,168,76,0.04);}
.nav-card.is-dragging{opacity:0.4;border-style:dashed;}

/* Card header row */
.card-row{display:flex;align-items:center;gap:8px;padding:11px 14px;flex-wrap:wrap;}

/* Drag handle */
.drag-handle{display:flex;align-items:center;justify-content:center;width:28px;height:28px;flex-shrink:0;color:rgba(138,155,191,0.3);cursor:grab;border-radius:5px;transition:color 0.15s,background 0.15s;}
.drag-handle:hover{color:#c9a84c;background:rgba(201,168,76,0.08);}
.drag-handle:active{cursor:grabbing;}
.drag-handle.small{width:24px;height:24px;}

/* Type pill */
.type-pill{flex-shrink:0;font-family:'DM Mono',monospace;font-size:10px;font-weight:700;letter-spacing:0.08em;padding:4px 10px;border-radius:20px;white-space:nowrap;}
.type-pill.link{background:rgba(46,204,113,0.08);border:1px solid rgba(46,204,113,0.2);color:rgba(46,204,113,0.8);}
.type-pill.dropdown{background:rgba(201,168,76,0.08);border:1px solid rgba(201,168,76,0.2);color:rgba(201,168,76,0.9);}

/* Card field */
.card-field{display:flex;flex-direction:column;gap:3px;flex:1;min-width:120px;}
.field-label{font-size:9px;font-weight:700;color:rgba(138,155,191,0.4);letter-spacing:0.15em;text-transform:uppercase;}

/* Type select */
.type-select{flex:0 0 120px;cursor:pointer;}

/* Expand button */
.btn-expand{display:inline-flex;align-items:center;gap:6px;flex-shrink:0;padding:6px 12px;background:rgba(201,168,76,0.06);border:1px solid rgba(201,168,76,0.18);border-radius:6px;color:rgba(201,168,76,0.7);font-size:11px;cursor:pointer;transition:background 0.15s,color 0.15s;white-space:nowrap;}
.btn-expand:hover,.btn-expand.open{background:rgba(201,168,76,0.12);color:#c9a84c;}
.btn-expand svg{transition:transform 0.25s;}
.btn-expand.open svg{transform:rotate(180deg);}

/* Remove card btn */
.btn-remove-card{flex-shrink:0;width:30px;height:30px;display:flex;align-items:center;justify-content:center;background:rgba(231,76,60,0.07);border:1px solid rgba(231,76,60,0.15);border-radius:6px;color:rgba(231,76,60,0.5);cursor:pointer;transition:background 0.15s,color 0.15s;}
.btn-remove-card:hover{background:rgba(231,76,60,0.15);color:#e74c3c;}
.btn-remove-card.small{width:26px;height:26px;}

/* ── Sub-items area ───────────────────────────────────── */
.sub-area{border-top:1px solid rgba(255,255,255,0.05);padding:14px 14px 14px 42px;background:rgba(0,0,0,0.15);}
.sub-area-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;}
.sub-area-label{font-size:10px;font-weight:700;color:rgba(201,168,76,0.6);letter-spacing:0.18em;text-transform:uppercase;}
.sub-dnd-hint{font-size:10px;color:rgba(138,155,191,0.3);}

/* Child card */
.child-card{display:flex;align-items:center;gap:8px;padding:10px 12px;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.05);border-radius:6px;margin-bottom:7px;flex-wrap:wrap;transition:border-color 0.15s;}
.child-card.drag-over{border-color:rgba(201,168,76,0.45);background:rgba(201,168,76,0.04);}
.child-card.is-dragging{opacity:0.35;border-style:dashed;}

.child-num-wrap{display:flex;flex-direction:column;gap:3px;flex:0 0 60px;}
.num-input{text-align:center;font-family:'DM Mono',monospace;font-size:12px;padding:8px 6px;}
.child-desc-field{flex:1.5;}

/* Empty states */
.sub-empty{text-align:center;padding:16px;font-size:12px;color:rgba(138,155,191,0.3);font-style:italic;}
.builder-empty{text-align:center;padding:40px 20px;display:flex;flex-direction:column;align-items:center;gap:12px;}
.builder-empty p{font-size:13px;color:rgba(138,155,191,0.35);line-height:1.7;}
.builder-empty strong{color:rgba(201,168,76,0.6);}

/* Add buttons */
.btn-add-row{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;background:rgba(201,168,76,0.06);border:1px dashed rgba(201,168,76,0.25);border-radius:6px;color:rgba(201,168,76,0.7);font-size:12px;cursor:pointer;transition:background 0.15s,color 0.15s;margin-top:4px;}
.btn-add-row:hover{background:rgba(201,168,76,0.1);color:#c9a84c;}
.btn-add-col{display:flex;align-items:center;gap:8px;padding:10px 18px;background:rgba(201,168,76,0.04);border:1px dashed rgba(201,168,76,0.2);border-radius:8px;color:rgba(201,168,76,0.6);font-size:13px;cursor:pointer;transition:background 0.15s,color 0.15s;width:100%;justify-content:center;margin-top:4px;margin-bottom:4px;}
.btn-add-col:hover{background:rgba(201,168,76,0.09);color:#c9a84c;}

/* ── CTA Preview ──────────────────────────────────────── */
.cta-preview{display:flex;align-items:center;gap:12px;margin-top:4px;margin-bottom:4px;padding:12px 16px;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.05);border-radius:8px;}
.cta-preview-label{font-size:11px;color:rgba(138,155,191,0.4);font-family:'DM Mono',monospace;}
.cta-preview-btn{display:inline-flex;align-items:center;background:linear-gradient(135deg,#c9a84c,#e8cf8a);color:#0b1c38;font-size:10px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;padding:8px 18px;border-radius:2px;}

/* ── Preview hint card ────────────────────────────────── */
.preview-hint-card{display:flex;align-items:flex-start;gap:10px;padding:14px 18px;background:rgba(201,168,76,0.04);border:1px solid rgba(201,168,76,0.12);border-radius:8px;font-size:12px;color:rgba(138,155,191,0.55);line-height:1.6;margin-top:4px;}
.preview-hint-card svg{flex-shrink:0;margin-top:1px;}

/* ── Transitions ──────────────────────────────────────── */
.panel-slide-enter-active,.panel-slide-leave-active{transition:max-height 0.3s ease,opacity 0.25s ease;}
.panel-slide-enter-from,.panel-slide-leave-to{max-height:0;opacity:0;}
.panel-slide-enter-to,.panel-slide-leave-from{max-height:3000px;opacity:1;}

.sub-slide-enter-active,.sub-slide-leave-active{transition:max-height 0.25s ease,opacity 0.2s ease;}
.sub-slide-enter-from,.sub-slide-leave-to{max-height:0;opacity:0;}
.sub-slide-enter-to,.sub-slide-leave-from{max-height:1000px;opacity:1;}

/* ── Logo panel ───────────────────────────────────────── */
.logo-preview-row{display:flex;align-items:center;gap:20px;padding:16px;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:8px;margin-bottom:4px;}
.logo-preview-box{width:160px;height:60px;display:flex;align-items:center;justify-content:center;background:rgba(11,28,56,0.6);border:1px solid rgba(255,255,255,0.07);border-radius:6px;flex-shrink:0;padding:8px;}
.logo-preview-img{max-width:100%;max-height:100%;object-fit:contain;}
.logo-preview-meta{display:flex;flex-direction:column;gap:6px;}
.logo-preview-label{font-size:11px;font-weight:700;color:rgba(138,155,191,0.5);letter-spacing:0.12em;text-transform:uppercase;}
.logo-preview-url{font-size:12px;color:rgba(138,155,191,0.7);font-family:'DM Mono',monospace;word-break:break-all;}
.logo-custom-badge{display:inline-block;font-size:10px;font-weight:700;color:rgba(46,204,113,0.8);background:rgba(46,204,113,0.08);border:1px solid rgba(46,204,113,0.2);padding:2px 10px;border-radius:20px;letter-spacing:0.08em;}
.logo-default-badge{display:inline-block;font-size:10px;font-weight:700;color:rgba(138,155,191,0.5);background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);padding:2px 10px;border-radius:20px;letter-spacing:0.08em;}

/* Upload zone */
.upload-zone{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;padding:28px 20px;background:rgba(201,168,76,0.02);border:1.5px dashed rgba(201,168,76,0.2);border-radius:8px;cursor:pointer;transition:background 0.2s,border-color 0.2s;text-align:center;min-height:110px;}
.upload-zone:hover,.upload-zone.dragover{background:rgba(201,168,76,0.06);border-color:rgba(201,168,76,0.45);}
.upload-hint{font-size:13px;color:rgba(138,155,191,0.5);line-height:1.6;margin:0;}
.upload-hint strong{color:rgba(201,168,76,0.7);}
.upload-hint span{font-size:11px;color:rgba(138,155,191,0.35);}
.upload-preview-wrap{display:flex;flex-direction:column;align-items:center;gap:8px;}
.upload-preview-img{max-height:60px;max-width:200px;object-fit:contain;border-radius:4px;border:1px solid rgba(255,255,255,0.08);}
.upload-preview-name{font-size:11px;color:rgba(138,155,191,0.5);font-family:'DM Mono',monospace;}
.upload-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:12px;}

/* OR divider */
.logo-or-divider{display:flex;align-items:center;gap:12px;margin:20px 0 16px;color:rgba(138,155,191,0.3);font-size:11px;letter-spacing:0.1em;text-transform:uppercase;}
.logo-or-divider::before,.logo-or-divider::after{content:'';flex:1;height:1px;background:rgba(255,255,255,0.06);}

</style>
