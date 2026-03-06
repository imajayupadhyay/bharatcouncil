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

        <!-- ══════════ SEO SETTINGS ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="seoOpen = !seoOpen">
            <div class="section-panel-left">
              <span class="section-num">SEO</span>
              <div>
                <h3 class="section-panel-title">SEO Settings</h3>
                <p class="section-panel-desc">Meta title, description, and keywords for search engines</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: seoOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>
          <Transition name="panel-slide">
            <div v-if="seoOpen" class="section-panel-body">
              <form @submit.prevent="saveSeo">
                <p class="form-group-label">Search Engine Optimisation</p>
                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label">Meta Title</label>
                    <input v-model="seo.meta_title" class="form-input" type="text" placeholder="Page title shown in browser tab and search results" maxlength="70" />
                    <span class="form-hint">Recommended: 50–60 characters &nbsp;({{ seo.meta_title?.length ?? 0 }}/70)</span>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label">Meta Description</label>
                    <textarea v-model="seo.meta_description" class="form-textarea" rows="3" placeholder="Brief description of the page shown in search results" maxlength="160" />
                    <span class="form-hint">Recommended: 150–160 characters &nbsp;({{ seo.meta_description?.length ?? 0 }}/160)</span>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label">Keywords</label>
                    <input v-model="seo.meta_keywords" class="form-input" type="text" placeholder="e.g. governance, policy, India, BGC (comma-separated)" />
                    <span class="form-hint">Comma-separated keywords for search engine context.</span>
                  </div>
                </div>
                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetSeo">Reset</button>
                  <button type="submit" class="btn-save" :disabled="seoSaving">
                    {{ seoSaving ? 'Saving…' : 'Save SEO Settings' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
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

        <!-- ══════════ FEATURED SECTION ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="featuredOpen = !featuredOpen">
            <div class="section-panel-left">
              <span class="section-num">02</span>
              <div>
                <h3 class="section-panel-title">Featured Section</h3>
                <p class="section-panel-desc">Section heading and badge — articles are pulled automatically from your latest blog posts</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: featuredOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>

          <Transition name="panel-slide">
            <div v-if="featuredOpen" class="section-panel-body">
              <form @submit.prevent="saveFeatured">

                <!-- Header -->
                <div class="form-group-label">Section Header</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Badge Text</label>
                    <input v-model="featured.badge_text" type="text" class="form-input" placeholder="Latest" />
                  </div>
                  <div class="form-group">
                    <label>Section Title</label>
                    <input v-model="featured.section_title" type="text" class="form-input" placeholder="Featured Analysis" />
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <label>View All Link Text</label>
                    <input v-model="featured.link_text" type="text" class="form-input" placeholder="View All" />
                  </div>
                  <div class="form-group">
                    <label>View All Link URL</label>
                    <input v-model="featured.link_url" type="text" class="form-input" placeholder="/insights" />
                  </div>
                </div>

                <!-- Info box -->
                <div class="info-box">
                  <span class="info-icon">i</span>
                  <p>The main featured card and 3 side articles are automatically pulled from your latest published blog posts. The most recent featured post appears as the main card, and the next 3 posts fill the side stack.</p>
                </div>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetFeatured">Reset to Default</button>
                  <button type="submit" class="btn-save" :disabled="featuredSaving">
                    {{ featuredSaving ? 'Saving...' : 'Save Featured Section' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

        <!-- ══════════ FOCUS AREAS SECTION ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="focusOpen = !focusOpen">
            <div class="section-panel-left">
              <span class="section-num">03</span>
              <div>
                <h3 class="section-panel-title">Focus Areas</h3>
                <p class="section-panel-desc">Section heading and the 5 focus-area cards with titles, descriptions, counts and links</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: focusOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>

          <Transition name="panel-slide">
            <div v-if="focusOpen" class="section-panel-body">
              <form @submit.prevent="saveFocus">

                <!-- Header -->
                <div class="form-group-label">Section Header</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Badge Text</label>
                    <input v-model="focus.badge_text" type="text" class="form-input" placeholder="What We Work On" />
                  </div>
                  <div class="form-group">
                    <label>Section Title</label>
                    <input v-model="focus.section_title" type="text" class="form-input" placeholder="Our Focus Areas" />
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Link Text</label>
                    <input v-model="focus.link_text" type="text" class="form-input" placeholder="Explore All" />
                  </div>
                  <div class="form-group">
                    <label>Link URL</label>
                    <input v-model="focus.link_url" type="text" class="form-input" placeholder="#" />
                  </div>
                </div>

                <!-- Cards -->
                <div class="form-group-label">Focus Area Cards</div>
                <div v-for="(card, i) in focus.cards" :key="i" class="card-edit-block">
                  <div class="card-edit-header">
                    <span class="card-edit-num">Card {{ i + 1 }}</span>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Title</label>
                      <input v-model="card.title" type="text" class="form-input" />
                    </div>
                    <div class="form-group">
                      <label>Count Label</label>
                      <input v-model="card.count" type="text" class="form-input" placeholder="24 Publications" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <textarea v-model="card.desc" class="form-input form-textarea" rows="2"></textarea>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Link URL</label>
                      <input v-model="card.link" type="text" class="form-input" placeholder="#" />
                    </div>
                    <div class="form-group">
                      <label>Icon SVG (inner path)</label>
                      <input v-model="card.svg" type="text" class="form-input form-input-mono" placeholder="<path d=&quot;...&quot;/>" />
                    </div>
                  </div>
                </div>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetFocus">Reset to Default</button>
                  <button type="submit" class="btn-save" :disabled="focusSaving">
                    {{ focusSaving ? 'Saving...' : 'Save Focus Section' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

        <!-- ══════════ EVENTS SECTION ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="eventsOpen = !eventsOpen">
            <div class="section-panel-left">
              <span class="section-num">04</span>
              <div>
                <h3 class="section-panel-title">Events Section</h3>
                <p class="section-panel-desc">Section heading and link — event cards are pulled automatically from your published events</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: eventsOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>

          <Transition name="panel-slide">
            <div v-if="eventsOpen" class="section-panel-body">
              <form @submit.prevent="saveEvents">

                <div class="form-group-label">Section Header</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Badge Text</label>
                    <input v-model="eventsData.badge_text" type="text" class="form-input" placeholder="Upcoming" />
                  </div>
                  <div class="form-group">
                    <label>Section Title</label>
                    <input v-model="eventsData.section_title" type="text" class="form-input" placeholder="Events & Convenings" />
                  </div>
                </div>
                <div class="info-box">
                  <span class="info-icon">i</span>
                  <p>The event cards are automatically pulled from your latest published upcoming events. Manage events from the <a href="/admin/events" style="color:#c9a84c;">Events</a> page.</p>
                </div>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetEvents">Reset to Default</button>
                  <button type="submit" class="btn-save" :disabled="eventsSaving">
                    {{ eventsSaving ? 'Saving...' : 'Save Events Section' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

        <!-- ══════════ VOICES SECTION ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="voicesOpen = !voicesOpen">
            <div class="section-panel-left">
              <span class="section-num">05</span>
              <div>
                <h3 class="section-panel-title">Voices Section</h3>
                <p class="section-panel-desc">Section heading and featured community member cards</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: voicesOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>

          <Transition name="panel-slide">
            <div v-if="voicesOpen" class="section-panel-body">
              <form @submit.prevent="saveVoices">

                <div class="form-group-label">Section Header</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Badge Text</label>
                    <input v-model="voicesData.badge_text" type="text" class="form-input" placeholder="The Community" />
                  </div>
                  <div class="form-group">
                    <label>Section Title</label>
                    <input v-model="voicesData.section_title" type="text" class="form-input" placeholder="Featured Voices" />
                  </div>
                </div>

                <!-- Voice Cards -->
                <div class="form-group-label">Voice Cards</div>
                <div v-for="(voice, i) in voicesData.voices" :key="i" class="card-edit-block">
                  <div class="card-edit-header">
                    <span class="card-edit-num">Voice {{ i + 1 }}</span>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Name</label>
                      <input v-model="voice.name" type="text" class="form-input" />
                    </div>
                    <div class="form-group">
                      <label>Initials</label>
                      <input v-model="voice.initials" type="text" class="form-input" placeholder="PM" maxlength="3" />
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Role</label>
                      <input v-model="voice.role" type="text" class="form-input" />
                    </div>
                    <div class="form-group">
                      <label>Tags (comma-separated)</label>
                      <input v-model="voice.tagsStr" type="text" class="form-input" placeholder="Federalism, Public Finance" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Bio</label>
                    <textarea v-model="voice.bio" class="form-input form-textarea" rows="2"></textarea>
                  </div>
                </div>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetVoices">Reset to Default</button>
                  <button type="submit" class="btn-save" :disabled="voicesSaving">
                    {{ voicesSaving ? 'Saving...' : 'Save Voices Section' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

        <!-- ══════════ PUBLICATIONS SECTION ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="publicationsOpen = !publicationsOpen">
            <div class="section-panel-left">
              <span class="section-num">06</span>
              <div>
                <h3 class="section-panel-title">Publications Section</h3>
                <p class="section-panel-desc">Section heading — posts are pulled automatically from blog categories (Policy Brief, Report, Op-Ed, Explainer, Commentary)</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: publicationsOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>

          <Transition name="panel-slide">
            <div v-if="publicationsOpen" class="section-panel-body">
              <form @submit.prevent="savePublications">

                <div class="form-group-label">Section Header</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Badge Text</label>
                    <input v-model="publicationsData.badge_text" type="text" class="form-input" placeholder="Knowledge Base" />
                  </div>
                  <div class="form-group">
                    <label>Section Title</label>
                    <input v-model="publicationsData.section_title" type="text" class="form-input" placeholder="Publications & Research" />
                  </div>
                </div>

                <div class="info-box">
                  <span class="info-icon">i</span>
                  <p>Publication cards and filter tabs are automatically generated from your blog posts in the categories: Policy Brief, Report, Op-Ed, Explainer, and Commentary. Manage posts from the <a href="/admin/blog/posts" style="color:#c9a84c;">Blog Posts</a> page.</p>
                </div>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetPublications">Reset to Default</button>
                  <button type="submit" class="btn-save" :disabled="publicationsSaving">
                    {{ publicationsSaving ? 'Saving...' : 'Save Publications Section' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

        <!-- ══════════ DISCUSSIONS SECTION ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="discussionsOpen = !discussionsOpen">
            <div class="section-panel-left">
              <span class="section-num">07</span>
              <div>
                <h3 class="section-panel-title">Discussions Section</h3>
                <p class="section-panel-desc">Community forum CTA — headline, subtext, stats, and buttons</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: discussionsOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>

          <Transition name="panel-slide">
            <div v-if="discussionsOpen" class="section-panel-body">
              <form @submit.prevent="saveDiscussions">

                <div class="form-group-label">Eyebrow</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Eyebrow Text</label>
                    <input v-model="discussionsData.eyebrow_text" type="text" class="form-input" placeholder="Community Forum" />
                  </div>
                  <div class="form-group">
                    <label>Eyebrow Tag</label>
                    <input v-model="discussionsData.eyebrow_tag" type="text" class="form-input" placeholder="Open to All" />
                  </div>
                </div>

                <div class="form-group-label">Headline</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Line 1 (plain)</label>
                    <input v-model="discussionsData.headline_line1" type="text" class="form-input" placeholder="Shape the" />
                  </div>
                  <div class="form-group">
                    <label>Line 2 (gold italic)</label>
                    <input v-model="discussionsData.headline_line2" type="text" class="form-input" placeholder="conversation." />
                  </div>
                </div>

                <div class="form-group">
                  <label>Subtext</label>
                  <textarea v-model="discussionsData.subtext" class="form-input form-textarea" rows="2"></textarea>
                </div>

                <div class="form-group-label">Action Buttons</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Primary Button Text</label>
                    <input v-model="discussionsData.btn_primary_text" type="text" class="form-input" />
                  </div>
                  <div class="form-group">
                    <label>Primary Button Link</label>
                    <input v-model="discussionsData.btn_primary_link" type="text" class="form-input" />
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Secondary Button Text</label>
                    <input v-model="discussionsData.btn_secondary_text" type="text" class="form-input" />
                  </div>
                  <div class="form-group">
                    <label>Secondary Button Link</label>
                    <input v-model="discussionsData.btn_secondary_link" type="text" class="form-input" />
                  </div>
                </div>

                <div class="form-group-label">Stats</div>
                <div v-for="(stat, i) in discussionsData.stats" :key="i" class="stat-row">
                  <span class="stat-row-num">{{ i + 1 }}</span>
                  <div class="form-group">
                    <label>Number</label>
                    <input v-model="stat.num" type="text" class="form-input" />
                  </div>
                  <div class="form-group">
                    <label>Label</label>
                    <input v-model="stat.lbl" type="text" class="form-input" />
                  </div>
                </div>

                <div class="form-group">
                  <label>Footer Note</label>
                  <input v-model="discussionsData.note" type="text" class="form-input" />
                </div>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetDiscussions">Reset to Default</button>
                  <button type="submit" class="btn-save" :disabled="discussionsSaving">
                    {{ discussionsSaving ? 'Saving...' : 'Save Discussions Section' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

        <!-- ══════════ NEWSLETTER SECTION ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="newsletterOpen = !newsletterOpen">
            <div class="section-panel-left">
              <span class="section-num">08</span>
              <div>
                <h3 class="section-panel-title">Newsletter Section</h3>
                <p class="section-panel-desc">Newsletter subscription callout — heading, subtext, and social proof</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: newsletterOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>

          <Transition name="panel-slide">
            <div v-if="newsletterOpen" class="section-panel-body">
              <form @submit.prevent="saveNewsletter">

                <div class="form-group-label">Eyebrow &amp; Heading</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Eyebrow Text</label>
                    <input v-model="newsletterData.eyebrow_text" type="text" class="form-input" placeholder="Weekly Intelligence" />
                  </div>
                  <div class="form-group">
                    <label>Heading Prefix</label>
                    <input v-model="newsletterData.heading_line1" type="text" class="form-input" placeholder="Join" />
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Heading Emphasis (gold italic)</label>
                    <input v-model="newsletterData.heading_em" type="text" class="form-input" placeholder="5,000+ citizens" />
                  </div>
                  <div class="form-group">
                    <label>Heading Line 2</label>
                    <input v-model="newsletterData.heading_line2" type="text" class="form-input" placeholder="shaping governance." />
                  </div>
                </div>
                <div class="form-group">
                  <label>Subtext</label>
                  <input v-model="newsletterData.subtext" type="text" class="form-input" placeholder="Weekly policy digest. No noise. Unsubscribe anytime." />
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Note</label>
                    <input v-model="newsletterData.note" type="text" class="form-input" />
                  </div>
                  <div class="form-group">
                    <label>Social Proof Text</label>
                    <input v-model="newsletterData.proof_text" type="text" class="form-input" placeholder="Joined by 5,200+ policy thinkers" />
                  </div>
                </div>

                <div class="info-box">
                  <span class="info-icon">i</span>
                  <p>The subscribe form is already functional. Subscribers are stored and can be viewed from the <a href="/admin/newsletters" style="color:#c9a84c;">Newsletter</a> page.</p>
                </div>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetNewsletter">Reset to Default</button>
                  <button type="submit" class="btn-save" :disabled="newsletterSaving">
                    {{ newsletterSaving ? 'Saving...' : 'Save Newsletter Section' }}
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
const featuredOpen     = ref(false)
const featuredSaving   = ref(false)
const focusOpen        = ref(false)
const focusSaving      = ref(false)
const eventsOpen       = ref(false)
const eventsSaving     = ref(false)
const voicesOpen         = ref(false)
const voicesSaving       = ref(false)
const publicationsOpen   = ref(false)
const publicationsSaving = ref(false)
const discussionsOpen    = ref(false)
const discussionsSaving  = ref(false)
const newsletterOpen     = ref(false)
const newsletterSaving   = ref(false)

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

// ── Featured defaults ────────────────────────────────────
const featuredDefaults = {
  badge_text:    'Latest',
  section_title: 'Featured Analysis',
  link_text:     'View All',
  link_url:      '/insights',
}

const savedFeatured = props.sections?.featured || {}
const featured = reactive({ ...featuredDefaults, ...savedFeatured })

function saveFeatured() {
  featuredSaving.value = true
  router.put('/admin/homepage/featured', {
    data: {
      badge_text:    featured.badge_text,
      section_title: featured.section_title,
      link_text:     featured.link_text,
      link_url:      featured.link_url,
    },
  }, {
    preserveScroll: true,
    onFinish: () => { featuredSaving.value = false },
  })
}

function resetFeatured() {
  Object.assign(featured, { ...featuredDefaults })
}

// ── Focus defaults ───────────────────────────────────────
const focusDefaults = {
  badge_text:    'What We Work On',
  section_title: 'Our Focus Areas',
  link_text:     'Explore All',
  link_url:      '#',
  cards: [
    {
      title: 'Constitutional Governance',
      desc:  'Federal structure, separation of powers, and the evolving architecture of India\'s democracy.',
      count: '24 Publications',
      link:  '#',
      svg:   '<rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 17.5h7M17.5 14v7"/>',
    },
    {
      title: 'Economic Policy',
      desc:  'Fiscal federalism, public finance, employment, and inclusive growth frameworks.',
      count: '38 Publications',
      link:  '#',
      svg:   '<path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>',
    },
    {
      title: 'Foreign Affairs',
      desc:  'India\'s strategic posture, multilateral institutions, and neighbourhood diplomacy.',
      count: '19 Publications',
      link:  '#',
      svg:   '<circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10A15.3 15.3 0 0112 2z"/>',
    },
    {
      title: 'Digital Governance',
      desc:  'DPI, data regulation, AI governance, and technology\'s role in public administration.',
      count: '31 Publications',
      link:  '#',
      svg:   '<rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>',
    },
    {
      title: 'Civic Participation',
      desc:  'Electoral reforms, decentralisation, and strengthening local self-governance.',
      count: '16 Publications',
      link:  '#',
      svg:   '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>',
    },
  ],
}

const savedFocus = props.sections?.focus || {}
const focus = reactive({
  ...focusDefaults,
  ...savedFocus,
  cards: savedFocus.cards?.length
    ? savedFocus.cards.map(c => ({ ...c }))
    : focusDefaults.cards.map(c => ({ ...c })),
})

function saveFocus() {
  focusSaving.value = true
  router.put('/admin/homepage/focus', {
    data: {
      badge_text:    focus.badge_text,
      section_title: focus.section_title,
      link_text:     focus.link_text,
      link_url:      focus.link_url,
      cards:         focus.cards,
    },
  }, {
    preserveScroll: true,
    onFinish: () => { focusSaving.value = false },
  })
}

function resetFocus() {
  Object.assign(focus, {
    ...focusDefaults,
    cards: focusDefaults.cards.map(c => ({ ...c })),
  })
}

// ── Events defaults ──────────────────────────────────────
const eventsDefaults = {
  badge_text:    'Upcoming',
  section_title: 'Events & Convenings',
  link_text:     'All Events',
  link_url:      '#',
}

const savedEvents = props.sections?.events || {}
const eventsData = reactive({ ...eventsDefaults, ...savedEvents })

function saveEvents() {
  eventsSaving.value = true
  router.put('/admin/homepage/events', {
    data: {
      badge_text:    eventsData.badge_text,
      section_title: eventsData.section_title,
      link_text:     eventsData.link_text,
      link_url:      eventsData.link_url,
    },
  }, {
    preserveScroll: true,
    onFinish: () => { eventsSaving.value = false },
  })
}

function resetEvents() {
  Object.assign(eventsData, { ...eventsDefaults })
}

// ── Voices defaults ──────────────────────────────────────
const voicesDefaults = {
  badge_text:    'The Community',
  section_title: 'Featured Voices',
  voices: [
    { initials: 'PM', name: 'Dr. Priya Menon', role: 'Senior Fellow, Fiscal Policy', bio: 'Former Deputy Secretary, Ministry of Finance. Specialises in intergovernmental fiscal transfers and Centre-State relations.', tagsStr: 'Federalism, Public Finance' },
    { initials: 'RK', name: 'Raghav Krishnan', role: 'Research Director, Digital Gov.', bio: 'Technology policy researcher and former IIT Delhi faculty studying India\'s digital public infrastructure stack.', tagsStr: 'DPI, AI Policy' },
    { initials: 'AS', name: 'Aditi Sharma', role: 'Council Fellow, Constitutional Law', bio: 'Supreme Court advocate and constitutional scholar focusing on judicial review, federalism, and rights jurisprudence.', tagsStr: 'Constitution, Judiciary' },
    { initials: 'VN', name: 'Vikram Nair', role: 'Associate Fellow, Foreign Policy', bio: 'Retired IFS officer with postings in Washington, Beijing, and Geneva. Expert in India\'s multilateral diplomacy.', tagsStr: 'Diplomacy, Geopolitics' },
  ],
}

function voiceFromSaved(v) {
  return {
    ...v,
    tagsStr: Array.isArray(v.tags) ? v.tags.join(', ') : (v.tagsStr || ''),
  }
}

const savedVoices = props.sections?.voices || {}
const voicesData = reactive({
  badge_text:    savedVoices.badge_text    || voicesDefaults.badge_text,
  section_title: savedVoices.section_title || voicesDefaults.section_title,
  voices: savedVoices.voices?.length
    ? savedVoices.voices.map(v => voiceFromSaved(v))
    : voicesDefaults.voices.map(v => ({ ...v })),
})

function saveVoices() {
  voicesSaving.value = true
  router.put('/admin/homepage/voices', {
    data: {
      badge_text:    voicesData.badge_text,
      section_title: voicesData.section_title,
      voices: voicesData.voices.map(v => ({
        initials: v.initials,
        name:     v.name,
        role:     v.role,
        bio:      v.bio,
        tags:     v.tagsStr.split(',').map(t => t.trim()).filter(Boolean),
      })),
    },
  }, {
    preserveScroll: true,
    onFinish: () => { voicesSaving.value = false },
  })
}

function resetVoices() {
  Object.assign(voicesData, {
    ...voicesDefaults,
    voices: voicesDefaults.voices.map(v => ({ ...v })),
  })
}

// ── Publications defaults ────────────────────────────────
const publicationsDefaults = {
  badge_text:    'Knowledge Base',
  section_title: 'Publications & Research',
}

const savedPublications = props.sections?.publications || {}
const publicationsData = reactive({ ...publicationsDefaults, ...savedPublications })

function savePublications() {
  publicationsSaving.value = true
  router.put('/admin/homepage/publications', {
    data: {
      badge_text:    publicationsData.badge_text,
      section_title: publicationsData.section_title,
    },
  }, {
    preserveScroll: true,
    onFinish: () => { publicationsSaving.value = false },
  })
}

function resetPublications() {
  Object.assign(publicationsData, { ...publicationsDefaults })
}

// ── Discussions defaults ─────────────────────────────────
const discussionsDefaults = {
  eyebrow_text:       'Community Forum',
  eyebrow_tag:        'Open to All',
  headline_line1:     'Shape the',
  headline_line2:     'conversation.',
  subtext:            'Join thousands of citizens, scholars, and civic practitioners debating the policies that shape India\u2019s future. Every voice matters.',
  btn_primary_text:   'Join & Participate',
  btn_primary_link:   '#',
  btn_secondary_text: 'Browse Discussions',
  btn_secondary_link: '#',
  note:               'Free to join \u00a0·\u00a0 No spam \u00a0·\u00a0 Cancel anytime',
  stats: [
    { num: '5,200+', lbl: 'Members' },
    { num: '840+',   lbl: 'Discussions' },
    { num: '12K+',   lbl: 'Comments' },
    { num: '48+',    lbl: 'Topics' },
  ],
}

const savedDiscussions = props.sections?.discussions || {}
const discussionsData = reactive({
  ...discussionsDefaults,
  ...savedDiscussions,
  stats: savedDiscussions.stats?.length
    ? savedDiscussions.stats.map(s => ({ ...s }))
    : discussionsDefaults.stats.map(s => ({ ...s })),
})

function saveDiscussions() {
  discussionsSaving.value = true
  router.put('/admin/homepage/discussions', {
    data: { ...discussionsData, stats: discussionsData.stats },
  }, {
    preserveScroll: true,
    onFinish: () => { discussionsSaving.value = false },
  })
}

function resetDiscussions() {
  Object.assign(discussionsData, {
    ...discussionsDefaults,
    stats: discussionsDefaults.stats.map(s => ({ ...s })),
  })
}

// ── Newsletter defaults ─────────────────────────────────
const newsletterDefaults = {
  eyebrow_text:  'Weekly Intelligence',
  heading_line1: 'Join',
  heading_em:    '5,000+ citizens',
  heading_line2: 'shaping governance.',
  subtext:       'Weekly policy digest. No noise. Unsubscribe anytime.',
  note:          'By subscribing you agree to our Privacy Policy. No spam, ever.',
  proof_text:    'Joined by 5,200+ policy thinkers',
}

const savedNewsletter = props.sections?.newsletter || {}
const newsletterData = reactive({ ...newsletterDefaults, ...savedNewsletter })

function saveNewsletter() {
  newsletterSaving.value = true
  router.put('/admin/homepage/newsletter', {
    data: { ...newsletterData },
  }, {
    preserveScroll: true,
    onFinish: () => { newsletterSaving.value = false },
  })
}

function resetNewsletter() {
  Object.assign(newsletterData, { ...newsletterDefaults })
}

function logout() { router.post('/admin/logout') }

const seoDefaults = {
  meta_title:       'Bharat Governance Council | Strengthening India\'s Governance',
  meta_description: 'Bharat Governance Council is India\'s premier governance think tank fostering evidence-based policy, civic engagement, and institutional reform.',
  meta_keywords:    'governance, policy, India, BGC, think tank, civic engagement',
}
const savedSeo  = props.sections?.seo ?? {}
const seo       = reactive({ ...seoDefaults, ...savedSeo })
const seoOpen   = ref(false)
const seoSaving = ref(false)
function saveSeo() {
  seoSaving.value = true
  router.put('/admin/homepage/seo', { data: { ...seo } }, {
    preserveScroll: true,
    onFinish: () => (seoSaving.value = false),
  })
}
function resetSeo() { Object.assign(seo, { ...seoDefaults }) }

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

/* ── Card edit blocks ── */
.card-edit-block{padding:16px 18px;background:rgba(11,28,56,.02);border:1px solid rgba(11,28,56,.08);margin-bottom:12px;}
.card-edit-block:last-of-type{margin-bottom:0;}
.card-edit-header{display:flex;align-items:center;gap:10px;margin-bottom:12px;}
.card-edit-num{font-family:'DM Mono',monospace;font-size:10px;font-weight:700;color:#c9a84c;letter-spacing:.1em;padding:3px 8px;border:1px solid rgba(201,168,76,.25);background:rgba(201,168,76,.06);}
.form-input-mono{font-family:'DM Mono',monospace;font-size:11px;}

/* ── Info box ── */
.info-box{display:flex;align-items:flex-start;gap:12px;padding:14px 18px;background:rgba(41,128,185,.06);border:1px solid rgba(41,128,185,.18);margin-top:18px;}
.info-box .info-icon{display:flex;align-items:center;justify-content:center;width:20px;height:20px;border-radius:50%;background:rgba(41,128,185,.15);color:#2980b9;font-size:11px;font-weight:700;font-family:'DM Mono',monospace;flex-shrink:0;margin-top:1px;}
.info-box p{font-size:12px;color:#5a6a82;line-height:1.6;}
</style>
