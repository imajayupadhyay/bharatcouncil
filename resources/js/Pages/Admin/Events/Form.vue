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
            :class="{ active: item.id === 'events' }"
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
          <h2 class="topbar-title">{{ isEdit ? 'Edit Event' : 'New Event' }}</h2>
          <div class="topbar-breadcrumb">
            <span>Admin</span><span class="bc-sep">›</span>
            <Link href="/admin/events" class="bc-link">Events</Link><span class="bc-sep">›</span>
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

        <Link href="/admin/events" class="back-link">
          <svg viewBox="0 0 14 14" fill="none" width="12" height="12"><path d="M9 2L4 7l5 5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
          Back to Events
        </Link>

        <form @submit.prevent="submit">
          <div class="form-grid">

            <!-- Main Column -->
            <div class="col-main">

              <!-- Title & Slug -->
              <div class="card">
                <div class="card-body">
                  <div class="form-group">
                    <input
                      v-model="form.title"
                      @input="autoSlug"
                      type="text"
                      class="title-input"
                      :class="{ error: form.errors.title }"
                      placeholder="Event Title…"
                    />
                    <span v-if="form.errors.title" class="form-error">{{ form.errors.title }}</span>
                  </div>
                  <div class="form-group mt-12">
                    <label class="form-label">Slug</label>
                    <input v-model="form.slug" type="text" class="form-input" :class="{ error: form.errors.slug }" placeholder="event-slug" />
                    <span v-if="form.errors.slug" class="form-error">{{ form.errors.slug }}</span>
                  </div>
                </div>
              </div>

              <!-- Description -->
              <div class="card">
                <div class="card-header"><h4 class="card-title">Description</h4></div>
                <div class="card-body">
                  <textarea
                    v-model="form.description"
                    class="form-textarea"
                    :class="{ error: form.errors.description }"
                    rows="4"
                    placeholder="Brief description of the event…"
                    maxlength="1000"
                  ></textarea>
                  <div class="char-count">{{ form.description?.length ?? 0 }} / 1000</div>
                  <span v-if="form.errors.description" class="form-error">{{ form.errors.description }}</span>
                </div>
              </div>

              <!-- Event Details -->
              <div class="card">
                <div class="card-header"><h4 class="card-title">Event Details</h4></div>
                <div class="card-body">
                  <div class="form-row">
                    <div class="form-group">
                      <label class="form-label">Event Type <span class="required">*</span></label>
                      <select v-model="form.event_type" class="form-select" :class="{ error: form.errors.event_type }">
                        <option v-for="t in eventTypes" :key="t" :value="t">{{ t }}</option>
                      </select>
                      <span v-if="form.errors.event_type" class="form-error">{{ form.errors.event_type }}</span>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Event Date <span class="required">*</span></label>
                      <input v-model="form.event_date" type="date" class="form-input" :class="{ error: form.errors.event_date }" />
                      <span v-if="form.errors.event_date" class="form-error">{{ form.errors.event_date }}</span>
                    </div>
                  </div>
                  <div class="form-row mt-14">
                    <div class="form-group">
                      <label class="form-label">Event Time</label>
                      <input v-model="form.event_time" type="text" class="form-input" placeholder="e.g. 10:00 AM — 1:00 PM IST" />
                    </div>
                    <div class="form-group">
                      <label class="form-label">Location</label>
                      <input v-model="form.location" type="text" class="form-input" placeholder="e.g. India Habitat Centre, New Delhi" />
                    </div>
                  </div>
                  <div class="form-group mt-14">
                    <label class="form-label">Registration URL</label>
                    <input v-model="form.registration_url" type="url" class="form-input" :class="{ error: form.errors.registration_url }" placeholder="https://…" />
                    <span v-if="form.errors.registration_url" class="form-error">{{ form.errors.registration_url }}</span>
                  </div>
                </div>
              </div>

            </div>

            <!-- Sidebar Column -->
            <div class="col-side">

              <!-- Publish -->
              <div class="card">
                <div class="card-header"><h4 class="card-title">Publish</h4></div>
                <div class="card-body">
                  <div class="form-group">
                    <label class="form-label">Status</label>
                    <div class="status-toggle">
                      <button type="button" :class="['toggle-opt', form.status === 'draft' ? 'toggle-active-draft' : '']" @click="form.status = 'draft'">Draft</button>
                      <button type="button" :class="['toggle-opt', form.status === 'published' ? 'toggle-active-pub' : '']" @click="form.status = 'published'">Published</button>
                    </div>
                  </div>
                  <div class="form-group mt-14">
                    <label class="checkbox-row">
                      <input type="checkbox" v-model="form.is_featured" class="checkbox-input" />
                      <span class="checkbox-label">Featured Event</span>
                      <span class="checkbox-hint">Highlighted on the homepage</span>
                    </label>
                  </div>
                  <div class="pub-actions">
                    <button type="submit" class="btn-publish" :disabled="submitting">
                      <svg viewBox="0 0 14 14" fill="none" width="12" height="12"><path d="M1 7l4 4 8-8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                      <span>{{ submitting ? 'Saving…' : (isEdit ? 'Update Event' : 'Save Event') }}</span>
                    </button>
                    <Link href="/admin/events" class="btn-cancel">Cancel</Link>
                  </div>
                </div>
              </div>

              <!-- Badge -->
              <div class="card">
                <div class="card-header"><h4 class="card-title">Badge</h4></div>
                <div class="card-body">
                  <div class="form-group">
                    <label class="form-label">Badge Text</label>
                    <input v-model="form.badge_text" type="text" class="form-input" placeholder="e.g. Free, Invite Only, Flagship" />
                  </div>
                  <div class="form-group mt-14">
                    <label class="form-label">Badge Style</label>
                    <div class="badge-options">
                      <label v-for="style in badgeStyles" :key="style.value" class="badge-opt" :class="{ selected: form.badge_style === style.value }">
                        <input type="radio" v-model="form.badge_style" :value="style.value" class="badge-radio" />
                        <span class="badge-preview" :class="`badge-${style.value}`">{{ style.label }}</span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Sort Order -->
              <div class="card">
                <div class="card-header"><h4 class="card-title">Display Order</h4></div>
                <div class="card-body">
                  <div class="form-group">
                    <label class="form-label">Sort Order</label>
                    <input v-model.number="form.sort_order" type="number" class="form-input" placeholder="0" />
                    <span class="form-hint">Lower numbers appear first</span>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </form>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Link, router, useForm } from '@inertiajs/vue3'
import { navGroups } from '../navItems.js'

const props = defineProps({
  admin: Object,
  event: Object,
})

const mounted          = ref(false)
const sidebarCollapsed = ref(false)
const submitting       = ref(false)
const isEdit           = computed(() => !!props.event)

const eventTypes  = ['Roundtable', 'Webinar', 'Conference', 'Workshop', 'Summit', 'Panel Discussion']
const badgeStyles = [
  { value: 'gold', label: 'Gold' },
  { value: 'teal', label: 'Teal' },
  { value: 'navy', label: 'Navy' },
]

const form = useForm({
  title:            props.event?.title            ?? '',
  slug:             props.event?.slug             ?? '',
  description:      props.event?.description      ?? '',
  event_type:       props.event?.event_type       ?? 'Roundtable',
  badge_text:       props.event?.badge_text        ?? '',
  badge_style:      props.event?.badge_style       ?? 'gold',
  event_date:       props.event?.event_date?.substring(0, 10) ?? '',
  event_time:       props.event?.event_time        ?? '',
  location:         props.event?.location          ?? '',
  registration_url: props.event?.registration_url  ?? '',
  status:           props.event?.status            ?? 'draft',
  is_featured:      props.event?.is_featured       ?? false,
  sort_order:       props.event?.sort_order        ?? 0,
})

function autoSlug() {
  if (!isEdit.value) {
    form.slug = form.title
      .toLowerCase().trim()
      .replace(/[^a-z0-9\s-]/g, '')
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-')
  }
}

function submit() {
  submitting.value = true
  if (isEdit.value) {
    form.put(`/admin/events/${props.event.id}`, {
      onFinish: () => { submitting.value = false },
    })
  } else {
    form.post('/admin/events', {
      onFinish: () => { submitting.value = false },
    })
  }
}

function logout() { router.post('/admin/logout') }

onMounted(() => requestAnimationFrame(() => setTimeout(() => { mounted.value = true }, 60)))
</script>

<style scoped>
* { box-sizing: border-box; }
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
.admin-main{flex:1;display:flex;flex-direction:column;min-width:0;}
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
.content-wrap{padding:28px;opacity:0;transform:translateY(12px);transition:opacity .6s,transform .6s;}
.content-wrap.visible{opacity:1;transform:translateY(0);}
.back-link{display:inline-flex;align-items:center;gap:7px;font-size:12px;color:#8a9bbf;text-decoration:none;margin-bottom:20px;transition:color .2s;}
.back-link:hover{color:#0b1c38;}

/* Grid layout */
.form-grid{display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;}
@media(max-width:1100px){.form-grid{grid-template-columns:1fr;}.col-side{display:grid;grid-template-columns:1fr 1fr;gap:16px;}}
@media(max-width:640px){.col-side{grid-template-columns:1fr;}}

/* Cards */
.card{background:#fff;border:1px solid rgba(11,28,56,.07);box-shadow:0 2px 10px rgba(11,28,56,.04);margin-bottom:16px;}
.card-header{padding:16px 20px;border-bottom:1px solid rgba(11,28,56,.07);}
.card-title{font-family:'Cormorant Garamond',serif;font-size:15px;font-weight:600;color:#0b1c38;}
.card-body{padding:20px;}
.col-side .card{margin-bottom:14px;}

/* Title input */
.title-input{width:100%;padding:8px 0;border:none;border-bottom:2px solid rgba(11,28,56,.12);font-family:'Cormorant Garamond',serif;font-size:26px;font-weight:600;color:#0b1c38;outline:none;background:transparent;transition:border-color .2s;}
.title-input:focus{border-color:#c9a84c;}
.title-input.error{border-color:#e74c3c;}
.title-input::placeholder{color:#c0c8d4;}

/* Form elements */
.mt-12{margin-top:12px;}
.mt-14{margin-top:14px;}
.form-group{display:flex;flex-direction:column;gap:5px;}
.form-label{font-size:10px;font-weight:700;color:#0b1c38;letter-spacing:.12em;text-transform:uppercase;}
.required{color:#e74c3c;}
.form-input{padding:9px 12px;border:1px solid rgba(11,28,56,.15);background:#fff;font-size:13px;font-family:'DM Sans',sans-serif;color:#0b1c38;outline:none;width:100%;transition:border-color .2s,box-shadow .2s;}
.form-input:focus{border-color:#c9a84c;box-shadow:0 0 0 3px rgba(201,168,76,.1);}
.form-input.error{border-color:#e74c3c;}
.form-select{width:100%;padding:9px 12px;border:1px solid rgba(11,28,56,.15);background:#fff;font-size:13px;font-family:'DM Sans',sans-serif;color:#0b1c38;outline:none;cursor:pointer;}
.form-select:focus{border-color:#c9a84c;}
.form-select.error{border-color:#e74c3c;}
.form-textarea{width:100%;padding:10px 12px;border:1px solid rgba(11,28,56,.15);background:#fff;font-size:13px;font-family:'DM Sans',sans-serif;color:#0b1c38;outline:none;resize:vertical;transition:border-color .2s;line-height:1.6;}
.form-textarea:focus{border-color:#c9a84c;box-shadow:0 0 0 3px rgba(201,168,76,.1);}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.char-count{font-size:10px;color:#a0abc0;text-align:right;margin-top:4px;}
.form-error{font-size:11px;color:#e74c3c;}
.form-hint{font-size:10px;color:#a0abc0;margin-top:2px;}

/* Status toggle */
.status-toggle{display:flex;border:1px solid rgba(11,28,56,.15);overflow:hidden;}
.toggle-opt{flex:1;padding:9px;font-size:12px;font-weight:600;font-family:'DM Sans',sans-serif;background:none;border:none;cursor:pointer;color:#8a9bbf;transition:background .15s,color .15s;}
.toggle-opt:not(:last-child){border-right:1px solid rgba(11,28,56,.15);}
.toggle-active-draft{background:#fafbfc;color:#5a6a82;}
.toggle-active-pub{background:rgba(39,174,96,.1);color:#27ae60;}

/* Checkbox */
.checkbox-row{display:flex;flex-wrap:wrap;align-items:flex-start;gap:8px;cursor:pointer;}
.checkbox-input{width:15px;height:15px;accent-color:#c9a84c;margin-top:2px;flex-shrink:0;}
.checkbox-label{font-size:13px;color:#0b1c38;font-weight:500;}
.checkbox-hint{width:100%;font-size:11px;color:#8a9bbf;margin-left:23px;}

/* Publish actions */
.pub-actions{display:flex;flex-direction:column;gap:8px;margin-top:18px;}
.btn-publish{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:11px;background:#0b1c38;color:#c9a84c;border:1px solid rgba(201,168,76,.3);font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;cursor:pointer;transition:background .2s;}
.btn-publish:hover:not(:disabled){background:#162d55;}
.btn-publish:disabled{opacity:.6;cursor:not-allowed;}
.btn-cancel{display:flex;align-items:center;justify-content:center;width:100%;padding:10px;background:none;border:1px solid rgba(11,28,56,.12);color:#8a9bbf;font-size:12px;text-decoration:none;text-align:center;transition:border-color .2s;}
.btn-cancel:hover{border-color:rgba(11,28,56,.3);}

/* Badge options */
.badge-options{display:flex;gap:10px;flex-wrap:wrap;}
.badge-opt{display:flex;align-items:center;gap:6px;cursor:pointer;padding:4px 8px;border:1px solid rgba(11,28,56,.1);transition:border-color .2s;}
.badge-opt.selected{border-color:#c9a84c;background:rgba(201,168,76,.04);}
.badge-radio{display:none;}
.badge-preview{font-size:9px;font-weight:600;letter-spacing:.18em;text-transform:uppercase;padding:3px 10px;font-family:'DM Mono',monospace;}
.badge-gold{background:rgba(201,168,76,.12);color:#c9a84c;}
.badge-teal{background:rgba(22,160,133,.10);color:#16a085;}
.badge-navy{background:rgba(11,28,56,.08);color:#0b1c38;}
</style>
