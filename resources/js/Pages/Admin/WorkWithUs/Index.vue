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
            :class="{ active: item.id === 'work-with-us' }"
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
          <h2 class="topbar-title">Work With Us Manager</h2>
          <div class="topbar-breadcrumb">
            <span>Admin</span><span class="bc-sep">›</span>
            <span class="bc-active">Work With Us</span>
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
            <h1 class="page-title">Work With Us Sections</h1>
            <p class="page-sub">Manage the content displayed on the Work With Us page. Edit each section below.</p>
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
                <p class="section-panel-desc">Eyebrow, headline, sub-text, award badge, and tab labels</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: heroOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>
          <Transition name="panel-slide">
            <div v-if="heroOpen" class="section-panel-body">
              <form @submit.prevent="saveHero">
                <div class="form-group-label">Eyebrow</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Eyebrow Text</label>
                    <input v-model="hero.eyebrow_text" type="text" class="form-input" placeholder="Opportunities at BGC" />
                  </div>
                  <div class="form-group">
                    <label>Eyebrow Tag</label>
                    <input v-model="hero.eyebrow_tag" type="text" class="form-input" placeholder="Join Us" />
                  </div>
                </div>
                <div class="form-group-label">Headline</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Headline Line 1 (plain)</label>
                    <input v-model="hero.headline_plain" type="text" class="form-input" placeholder="Build Your Career at the" />
                  </div>
                  <div class="form-group">
                    <label>Headline Line 2 (gold italic)</label>
                    <input v-model="hero.headline_gold" type="text" class="form-input" placeholder="Heart of Indian Governance" />
                  </div>
                </div>
                <div class="form-group-label">Sub-text</div>
                <div class="form-group">
                  <label>Body Paragraph</label>
                  <textarea v-model="hero.subtext" class="form-input form-textarea" rows="4" placeholder="BGC is a collegial..."></textarea>
                </div>
                <div class="form-group-label">Award Badge</div>
                <div class="form-group">
                  <label>Award Title</label>
                  <input v-model="hero.award_title" type="text" class="form-input" placeholder="Best Place to Work — Not for Profit Category" />
                </div>
                <div class="form-group">
                  <label>Award Sub-text</label>
                  <input v-model="hero.award_sub" type="text" class="form-input" placeholder="Economic Times Best Workplaces · 2024 · ..." />
                </div>
                <div class="form-group-label">Tab Labels</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Tab 1 Label (Intern)</label>
                    <input v-model="hero.tab1_label" type="text" class="form-input" placeholder="Work as an Intern" />
                  </div>
                  <div class="form-group">
                    <label>Tab 2 Label (Member)</label>
                    <input v-model="hero.tab2_label" type="text" class="form-input" placeholder="Work as a Member" />
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

        <!-- ══════════ TAB NAVIGATION ══════════ -->
        <div class="tab-switcher">
          <button
            class="tab-sw-btn"
            :class="{ active: activeTab === 'intern' }"
            @click="activeTab = 'intern'"
          >
            <svg viewBox="0 0 16 16" fill="none" width="14" height="14">
              <path d="M4 6V4a4 4 0 118 0v2M2 6h12v8a1 1 0 01-1 1H3a1 1 0 01-1-1V6z" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/>
            </svg>
            Work as an Intern
          </button>
          <button
            class="tab-sw-btn"
            :class="{ active: activeTab === 'member' }"
            @click="activeTab = 'member'"
          >
            <svg viewBox="0 0 16 16" fill="none" width="14" height="14">
              <circle cx="8" cy="5" r="2.5" stroke="currentColor" stroke-width="1.2"/>
              <path d="M3 13.5c0-2.76 2.24-5 5-5s5 2.24 5 5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
            </svg>
            Work as a Member
          </button>
        </div>

        <!-- ══════════ WORK AS AN INTERN PANELS ══════════ -->
        <div v-if="activeTab === 'intern'">

          <!-- Panel 02: Intern Programme -->
          <div class="section-panel">
            <div class="section-panel-header" @click="programmeOpen = !programmeOpen">
              <div class="section-panel-left">
                <span class="section-num">02</span>
                <div>
                  <h3 class="section-panel-title">Intern Programme</h3>
                  <p class="section-panel-desc">About the programme, What You'll Do tasks, and Research Tracks</p>
                </div>
              </div>
              <svg class="section-chevron" :class="{ open: programmeOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
                <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
              </svg>
            </div>
            <Transition name="panel-slide">
              <div v-if="programmeOpen" class="section-panel-body">
                <form @submit.prevent="saveProgramme">

                  <!-- ── About the Programme ── -->
                  <div class="form-group-label">About the Programme</div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Section Label</label>
                      <input v-model="programme.about_label" type="text" class="form-input" placeholder="The Internship Programme" />
                    </div>
                    <div class="form-group">
                      <label>Info Card Title</label>
                      <input v-model="programme.info_card_title" type="text" class="form-input" placeholder="Programme at a Glance" />
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Headline Line 1 (plain)</label>
                      <input v-model="programme.about_headline_plain" type="text" class="form-input" placeholder="Learn Governance" />
                    </div>
                    <div class="form-group">
                      <label>Headline Line 2 (gold italic)</label>
                      <input v-model="programme.about_headline_gold" type="text" class="form-input" placeholder="From Inside It" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Prose Paragraph 1</label>
                    <textarea v-model="programme.prose_p1" class="form-input form-textarea" rows="3"></textarea>
                  </div>
                  <div class="form-group">
                    <label>Prose Paragraph 2</label>
                    <textarea v-model="programme.prose_p2" class="form-input form-textarea" rows="3"></textarea>
                  </div>
                  <div class="form-group">
                    <label>Prose Paragraph 3</label>
                    <textarea v-model="programme.prose_p3" class="form-input form-textarea" rows="3"></textarea>
                  </div>

                  <!-- Programme Details Rows -->
                  <div class="form-group-label" style="margin-top:8px">Programme Details (Info Card Rows)</div>
                  <div v-for="(row, i) in programme.programme_details" :key="i" class="array-row">
                    <div class="array-row-fields">
                      <div class="form-group" style="flex:0 0 180px">
                        <label>Label</label>
                        <input v-model="row.label" type="text" class="form-input" placeholder="Duration" />
                      </div>
                      <div class="form-group" style="flex:1">
                        <label>Value</label>
                        <input v-model="row.val" type="text" class="form-input" placeholder="8–12 weeks" />
                      </div>
                    </div>
                    <button type="button" class="btn-remove-row" @click="programme.programme_details.splice(i, 1)" title="Remove">
                      <svg viewBox="0 0 16 16" fill="none" width="12" height="12"><path d="M3 3l10 10M13 3L3 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    </button>
                  </div>
                  <button type="button" class="btn-add-row" @click="programme.programme_details.push({ label: '', val: '' })">
                    + Add Detail Row
                  </button>

                  <!-- ── What You'll Do ── -->
                  <div class="form-group-label" style="margin-top:20px">What You'll Do</div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Section Label</label>
                      <input v-model="programme.tasks_label" type="text" class="form-input" placeholder="What You'll Do" />
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Headline Line 1 (plain)</label>
                      <input v-model="programme.tasks_headline_plain" type="text" class="form-input" placeholder="Real Work," />
                    </div>
                    <div class="form-group">
                      <label>Headline Line 2 (gold italic)</label>
                      <input v-model="programme.tasks_headline_gold" type="text" class="form-input" placeholder="Real Responsibility" />
                    </div>
                  </div>

                  <!-- Tasks Array -->
                  <div v-for="(task, i) in programme.tasks" :key="i" class="member-card">
                    <div class="member-card-header">
                      <span class="member-card-num">Task {{ i + 1 }}</span>
                      <button type="button" class="btn-remove-card" @click="programme.tasks.splice(i, 1)">Remove</button>
                    </div>
                    <div class="form-row">
                      <div class="form-group">
                        <label>Icon (emoji)</label>
                        <input v-model="task.icon" type="text" class="form-input" placeholder="📄" />
                      </div>
                      <div class="form-group">
                        <label>Title</label>
                        <input v-model="task.title" type="text" class="form-input" placeholder="Policy Research & Briefs" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Body Text</label>
                      <textarea v-model="task.body" class="form-input form-textarea" rows="2"></textarea>
                    </div>
                  </div>
                  <button type="button" class="btn-add-card" @click="programme.tasks.push({ icon: '', title: '', body: '' })">
                    + Add Task
                  </button>

                  <!-- ── Research Tracks ── -->
                  <div class="form-group-label" style="margin-top:20px">Research Tracks</div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Section Label</label>
                      <input v-model="programme.tracks_label" type="text" class="form-input" placeholder="Research Tracks" />
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Headline Line 1 (plain)</label>
                      <input v-model="programme.tracks_headline_plain" type="text" class="form-input" placeholder="Choose Your" />
                    </div>
                    <div class="form-group">
                      <label>Headline Line 2 (gold italic)</label>
                      <input v-model="programme.tracks_headline_gold" type="text" class="form-input" placeholder="Track" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Sub-text</label>
                    <textarea v-model="programme.tracks_sub" class="form-input form-textarea" rows="2"></textarea>
                  </div>

                  <!-- Tracks Array -->
                  <div v-for="(track, i) in programme.tracks" :key="i" class="array-row">
                    <div class="array-row-fields">
                      <div class="form-group" style="flex:0 0 100px">
                        <label>Emoji</label>
                        <input v-model="track.emoji" type="text" class="form-input" placeholder="🏛️" />
                      </div>
                      <div class="form-group" style="flex:1">
                        <label>Track Name</label>
                        <input v-model="track.name" type="text" class="form-input" placeholder="State Capacity & Administrative Reform" />
                      </div>
                    </div>
                    <button type="button" class="btn-remove-row" @click="programme.tracks.splice(i, 1)" title="Remove">
                      <svg viewBox="0 0 16 16" fill="none" width="12" height="12"><path d="M3 3l10 10M13 3L3 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    </button>
                  </div>
                  <button type="button" class="btn-add-row" @click="programme.tracks.push({ emoji: '', name: '' })">
                    + Add Track
                  </button>

                  <div class="form-actions">
                    <button type="button" class="btn-reset" @click="resetProgramme">Reset to Default</button>
                    <button type="submit" class="btn-save" :disabled="programmeSaving">
                      {{ programmeSaving ? 'Saving...' : 'Save Intern Programme' }}
                    </button>
                  </div>
                </form>
              </div>
            </Transition>
          </div>

          <!-- Panel 03: Eligibility -->
          <div class="section-panel">
            <div class="section-panel-header" @click="eligOpen = !eligOpen">
              <div class="section-panel-left">
                <span class="section-num">03</span>
                <div>
                  <h3 class="section-panel-title">Eligibility & Expectations</h3>
                  <p class="section-panel-desc">Who we're looking for — "You should bring" and "We do not look for" lists</p>
                </div>
              </div>
              <svg class="section-chevron" :class="{ open: eligOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
                <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
              </svg>
            </div>
            <Transition name="panel-slide">
              <div v-if="eligOpen" class="section-panel-body">
                <form @submit.prevent="saveElig">

                  <div class="form-group-label">Section Header</div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Section Label</label>
                      <input v-model="elig.label" type="text" class="form-input" placeholder="Eligibility & Expectations" />
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Headline Line 1 (plain)</label>
                      <input v-model="elig.headline" type="text" class="form-input" placeholder="Who We're" />
                    </div>
                    <div class="form-group">
                      <label>Headline Line 2 (gold italic)</label>
                      <input v-model="elig.headline_gold" type="text" class="form-input" placeholder="Looking For" />
                    </div>
                  </div>

                  <!-- You Should Bring -->
                  <div class="form-group-label" style="margin-top:8px">
                    "You Should Bring" Column
                  </div>
                  <div class="form-group">
                    <label>Column Title</label>
                    <input v-model="elig.should_bring_title" type="text" class="form-input" placeholder="You should bring" />
                  </div>
                  <div v-for="(item, i) in elig.should_bring" :key="`sb-${i}`" class="array-row">
                    <div class="array-row-fields">
                      <div class="form-group" style="flex:1">
                        <label>Item {{ i + 1 }}</label>
                        <textarea v-model="elig.should_bring[i]" class="form-input form-textarea" rows="2"></textarea>
                      </div>
                    </div>
                    <button type="button" class="btn-remove-row" @click="elig.should_bring.splice(i, 1)" title="Remove">
                      <svg viewBox="0 0 16 16" fill="none" width="12" height="12"><path d="M3 3l10 10M13 3L3 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    </button>
                  </div>
                  <button type="button" class="btn-add-row" @click="elig.should_bring.push('')">
                    + Add Item
                  </button>

                  <!-- We Do Not Look For -->
                  <div class="form-group-label" style="margin-top:20px">
                    "We Do Not Look For" Column
                  </div>
                  <div class="form-group">
                    <label>Column Title</label>
                    <input v-model="elig.do_not_need_title" type="text" class="form-input" placeholder="We do not look for" />
                  </div>
                  <div v-for="(item, i) in elig.do_not_need" :key="`dn-${i}`" class="array-row">
                    <div class="array-row-fields">
                      <div class="form-group" style="flex:1">
                        <label>Item {{ i + 1 }}</label>
                        <textarea v-model="elig.do_not_need[i]" class="form-input form-textarea" rows="2"></textarea>
                      </div>
                    </div>
                    <button type="button" class="btn-remove-row" @click="elig.do_not_need.splice(i, 1)" title="Remove">
                      <svg viewBox="0 0 16 16" fill="none" width="12" height="12"><path d="M3 3l10 10M13 3L3 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    </button>
                  </div>
                  <button type="button" class="btn-add-row" @click="elig.do_not_need.push('')">
                    + Add Item
                  </button>

                  <!-- Application Form Header Text -->
                  <div class="form-group-label" style="margin-top:20px">Application Form Header</div>
                  <div class="form-group">
                    <label>Form Sub-text</label>
                    <textarea v-model="elig.form_sub" class="form-input form-textarea" rows="2"
                      placeholder="Fill in the form below. We review applications on a rolling basis..."></textarea>
                  </div>

                  <div class="form-actions">
                    <button type="button" class="btn-reset" @click="resetElig">Reset to Default</button>
                    <button type="submit" class="btn-save" :disabled="eligSaving">
                      {{ eligSaving ? 'Saving...' : 'Save Eligibility Section' }}
                    </button>
                  </div>
                </form>
              </div>
            </Transition>
          </div>

        </div><!-- /intern tab -->

        <!-- ══════════ WORK AS A MEMBER PANELS ══════════ -->
        <div v-if="activeTab === 'member'">

          <!-- Panel 04: Membership -->
          <div class="section-panel">
            <div class="section-panel-header" @click="membershipOpen = !membershipOpen">
              <div class="section-panel-left">
                <span class="section-num">04</span>
                <div>
                  <h3 class="section-panel-title">Membership Section</h3>
                  <p class="section-panel-desc">About membership, membership types, and what members gain</p>
                </div>
              </div>
              <svg class="section-chevron" :class="{ open: membershipOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
                <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
              </svg>
            </div>
            <Transition name="panel-slide">
              <div v-if="membershipOpen" class="section-panel-body">
                <form @submit.prevent="saveMembership">

                  <!-- ── About Membership ── -->
                  <div class="form-group-label">About Membership</div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Section Label</label>
                      <input v-model="membership.about_label" type="text" class="form-input" placeholder="BGC Membership" />
                    </div>
                    <div class="form-group">
                      <label>Info Card Title</label>
                      <input v-model="membership.info_card_title" type="text" class="form-input" placeholder="Membership at a Glance" />
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Headline Line 1 (plain)</label>
                      <input v-model="membership.about_headline_plain" type="text" class="form-input" placeholder="Join the Council" />
                    </div>
                    <div class="form-group">
                      <label>Headline Line 2 (gold italic)</label>
                      <input v-model="membership.about_headline_gold" type="text" class="form-input" placeholder="as a Member" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Prose Paragraph 1</label>
                    <textarea v-model="membership.prose_p1" class="form-input form-textarea" rows="3"></textarea>
                  </div>
                  <div class="form-group">
                    <label>Prose Paragraph 2</label>
                    <textarea v-model="membership.prose_p2" class="form-input form-textarea" rows="3"></textarea>
                  </div>
                  <div class="form-group">
                    <label>Prose Paragraph 3</label>
                    <textarea v-model="membership.prose_p3" class="form-input form-textarea" rows="3"></textarea>
                  </div>

                  <!-- Membership Details Rows -->
                  <div class="form-group-label" style="margin-top:8px">Membership Details (Info Card Rows)</div>
                  <div v-for="(row, i) in membership.membership_details" :key="i" class="array-row">
                    <div class="array-row-fields">
                      <div class="form-group" style="flex:0 0 180px">
                        <label>Label</label>
                        <input v-model="row.label" type="text" class="form-input" placeholder="Types" />
                      </div>
                      <div class="form-group" style="flex:1">
                        <label>Value</label>
                        <input v-model="row.val" type="text" class="form-input" placeholder="Research Fellow · Senior Fellow · Associate Member" />
                      </div>
                    </div>
                    <button type="button" class="btn-remove-row" @click="membership.membership_details.splice(i, 1)" title="Remove">
                      <svg viewBox="0 0 16 16" fill="none" width="12" height="12"><path d="M3 3l10 10M13 3L3 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    </button>
                  </div>
                  <button type="button" class="btn-add-row" @click="membership.membership_details.push({ label: '', val: '' })">
                    + Add Detail Row
                  </button>

                  <!-- ── Membership Types ── -->
                  <div class="form-group-label" style="margin-top:20px">Membership Types</div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Section Label</label>
                      <input v-model="membership.types_label" type="text" class="form-input" placeholder="Types of Membership" />
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Headline Line 1 (plain)</label>
                      <input v-model="membership.types_headline_plain" type="text" class="form-input" placeholder="Three Paths to" />
                    </div>
                    <div class="form-group">
                      <label>Headline Line 2 (gold italic)</label>
                      <input v-model="membership.types_headline_gold" type="text" class="form-input" placeholder="Membership" />
                    </div>
                  </div>

                  <div v-for="(type, i) in membership.member_types" :key="i" class="member-card">
                    <div class="member-card-header">
                      <span class="member-card-num">Type {{ i + 1 }}</span>
                      <button type="button" class="btn-remove-card" @click="membership.member_types.splice(i, 1)">Remove</button>
                    </div>
                    <div class="form-group">
                      <label>Title</label>
                      <input v-model="type.title" type="text" class="form-input" placeholder="Research Fellow" />
                    </div>
                    <div class="form-group">
                      <label>Body Text</label>
                      <textarea v-model="type.body" class="form-input form-textarea" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                      <label>Tenure Tag</label>
                      <input v-model="type.tenure" type="text" class="form-input" placeholder="1-year, renewable · Full institutional support" />
                    </div>
                  </div>
                  <button type="button" class="btn-add-card" @click="membership.member_types.push({ title: '', body: '', tenure: '' })">
                    + Add Membership Type
                  </button>

                  <!-- ── What You Gain ── -->
                  <div class="form-group-label" style="margin-top:20px">What You Gain</div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Section Label</label>
                      <input v-model="membership.offer_label" type="text" class="form-input" placeholder="What BGC Offers Members" />
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Headline Line 1 (plain)</label>
                      <input v-model="membership.offer_headline_plain" type="text" class="form-input" placeholder="What You" />
                    </div>
                    <div class="form-group">
                      <label>Headline Line 2 (gold italic)</label>
                      <input v-model="membership.offer_headline_gold" type="text" class="form-input" placeholder="Gain" />
                    </div>
                  </div>

                  <div v-for="(item, i) in membership.offer_items" :key="i" class="member-card">
                    <div class="member-card-header">
                      <span class="member-card-num">Offer Item {{ i + 1 }}</span>
                      <button type="button" class="btn-remove-card" @click="membership.offer_items.splice(i, 1)">Remove</button>
                    </div>
                    <div class="form-group">
                      <label>Title</label>
                      <input v-model="item.title" type="text" class="form-input" placeholder="Access to Senior Practitioners" />
                    </div>
                    <div class="form-group">
                      <label>Body Text</label>
                      <textarea v-model="item.body" class="form-input form-textarea" rows="2"></textarea>
                    </div>
                  </div>
                  <button type="button" class="btn-add-card" @click="membership.offer_items.push({ title: '', body: '' })">
                    + Add Offer Item
                  </button>

                  <div class="form-actions">
                    <button type="button" class="btn-reset" @click="resetMembership">Reset to Default</button>
                    <button type="submit" class="btn-save" :disabled="membershipSaving">
                      {{ membershipSaving ? 'Saving...' : 'Save Membership Section' }}
                    </button>
                  </div>
                </form>
              </div>
            </Transition>
          </div>

          <!-- Panel 05: Member Form -->
          <div class="section-panel">
            <div class="section-panel-header" @click="memberFormOpen = !memberFormOpen">
              <div class="section-panel-left">
                <span class="section-num">05</span>
                <div>
                  <h3 class="section-panel-title">Member Application Form</h3>
                  <p class="section-panel-desc">Form header, step labels, and reflective questions text</p>
                </div>
              </div>
              <svg class="section-chevron" :class="{ open: memberFormOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
                <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
              </svg>
            </div>
            <Transition name="panel-slide">
              <div v-if="memberFormOpen" class="section-panel-body">
                <form @submit.prevent="saveMemberForm">

                  <!-- Form Header -->
                  <div class="form-group-label">Form Header</div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Section Label</label>
                      <input v-model="memberForm.form_label" type="text" class="form-input" placeholder="Member Application" />
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Headline Line 1 (plain)</label>
                      <input v-model="memberForm.headline_plain" type="text" class="form-input" placeholder="Tell Us About" />
                    </div>
                    <div class="form-group">
                      <label>Headline Line 2 (gold italic)</label>
                      <input v-model="memberForm.headline_gold" type="text" class="form-input" placeholder="Yourself" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Form Sub-text</label>
                    <textarea v-model="memberForm.form_sub" class="form-input form-textarea" rows="3"></textarea>
                  </div>

                  <!-- Step Labels -->
                  <div class="form-group-label" style="margin-top:8px">Progress Step Labels</div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Step 1 Label</label>
                      <input v-model="memberForm.step1_label" type="text" class="form-input" placeholder="Profile" />
                    </div>
                    <div class="form-group">
                      <label>Step 2 Label</label>
                      <input v-model="memberForm.step2_label" type="text" class="form-input" placeholder="Your Thinking" />
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Step 3 Label</label>
                      <input v-model="memberForm.step3_label" type="text" class="form-input" placeholder="Final Details" />
                    </div>
                  </div>

                  <!-- Step 2 Sub-text -->
                  <div class="form-group-label" style="margin-top:8px">Step 2 — "Your Thinking" Sub-text</div>
                  <div class="form-group">
                    <label>Sub-text</label>
                    <textarea v-model="memberForm.step2_sub" class="form-input form-textarea" rows="2"></textarea>
                  </div>

                  <!-- Questions -->
                  <div class="form-group-label" style="margin-top:8px">Reflective Questions (Step 2)</div>
                  <div v-for="(q, i) in memberForm.questions" :key="i" class="member-card">
                    <div class="member-card-header">
                      <span class="member-card-num">Question {{ i + 1 }}</span>
                      <button type="button" class="btn-remove-card" @click="memberForm.questions.splice(i, 1)">Remove</button>
                    </div>
                    <div class="form-group">
                      <label>Category Label</label>
                      <input v-model="q.category" type="text" class="form-input" placeholder="Governance Challenge" />
                    </div>
                    <div class="form-group">
                      <label>Question Text</label>
                      <textarea v-model="q.text" class="form-input form-textarea" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                      <label>Answer Hint / Placeholder</label>
                      <textarea v-model="q.hint" class="form-input form-textarea" rows="2"></textarea>
                    </div>
                  </div>
                  <button type="button" class="btn-add-card" @click="memberForm.questions.push({ category: '', text: '', hint: '' })">
                    + Add Question
                  </button>

                  <div class="form-actions">
                    <button type="button" class="btn-reset" @click="resetMemberForm">Reset to Default</button>
                    <button type="submit" class="btn-save" :disabled="memberFormSaving">
                      {{ memberFormSaving ? 'Saving...' : 'Save Member Form' }}
                    </button>
                  </div>
                </form>
              </div>
            </Transition>
          </div>

        </div>

        <!-- ══════════ LIFE AT BGC (outside tabs) ══════════ -->
        <div class="tab-section-divider">
          <span>Sections outside tabs</span>
        </div>

        <div class="section-panel">
          <div class="section-panel-header" @click="lifeOpen = !lifeOpen">
            <div class="section-panel-left">
              <span class="section-num">06</span>
              <div>
                <h3 class="section-panel-title">Life at BGC</h3>
                <p class="section-panel-desc">Headline, prose paragraphs, award card, and values list</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: lifeOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>
          <Transition name="panel-slide">
            <div v-if="lifeOpen" class="section-panel-body">
              <form @submit.prevent="saveLife">

                <!-- Section Header -->
                <div class="form-group-label">Section Header</div>
                <div class="form-group">
                  <label>Section Label</label>
                  <input v-model="life.label" type="text" class="form-input" placeholder="Life at BGC" />
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Headline Line 1 (plain)</label>
                    <input v-model="life.headline_plain" type="text" class="form-input" placeholder="A Place That Respects" />
                  </div>
                  <div class="form-group">
                    <label>Headline Line 2 (gold italic)</label>
                    <input v-model="life.headline_gold" type="text" class="form-input" placeholder="Your Intelligence" />
                  </div>
                </div>

                <!-- Prose -->
                <div class="form-group-label" style="margin-top:8px">Prose Paragraphs</div>
                <div class="form-group">
                  <label>Paragraph 1</label>
                  <textarea v-model="life.prose_p1" class="form-input form-textarea" rows="3"></textarea>
                </div>
                <div class="form-group">
                  <label>Paragraph 2</label>
                  <textarea v-model="life.prose_p2" class="form-input form-textarea" rows="3"></textarea>
                </div>
                <div class="form-group">
                  <label>Paragraph 3</label>
                  <textarea v-model="life.prose_p3" class="form-input form-textarea" rows="3"></textarea>
                </div>

                <!-- Award Card -->
                <div class="form-group-label" style="margin-top:8px">Award Card</div>
                <div class="form-group">
                  <label>Award Title</label>
                  <input v-model="life.award_title" type="text" class="form-input" placeholder="Best Place to Work — Not for Profit" />
                </div>
                <div class="form-group">
                  <label>Award Body Text</label>
                  <textarea v-model="life.award_body" class="form-input form-textarea" rows="3"></textarea>
                </div>

                <!-- Values List -->
                <div class="form-group-label" style="margin-top:8px">Values List</div>
                <div v-for="(val, i) in life.values" :key="i" class="member-card">
                  <div class="member-card-header">
                    <span class="member-card-num">Value {{ i + 1 }}</span>
                    <button type="button" class="btn-remove-card" @click="life.values.splice(i, 1)">Remove</button>
                  </div>
                  <div class="form-row">
                    <div class="form-group" style="flex:0 0 120px">
                      <label>Icon (emoji)</label>
                      <input v-model="val.icon" type="text" class="form-input" placeholder="🤝" />
                    </div>
                    <div class="form-group" style="flex:1">
                      <label>Title</label>
                      <input v-model="val.title" type="text" class="form-input" placeholder="Flat, Collegial Culture" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <textarea v-model="val.desc" class="form-input form-textarea" rows="2"></textarea>
                  </div>
                </div>
                <button type="button" class="btn-add-card" @click="life.values.push({ icon: '', title: '', desc: '' })">
                  + Add Value
                </button>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetLife">Reset to Default</button>
                  <button type="submit" class="btn-save" :disabled="lifeSaving">
                    {{ lifeSaving ? 'Saving...' : 'Save Life at BGC' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

        <!-- ══════════ WORK POLICIES (outside tabs) ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="policiesOpen = !policiesOpen">
            <div class="section-panel-left">
              <span class="section-num">07</span>
              <div>
                <h3 class="section-panel-title">Work Policies</h3>
                <p class="section-panel-desc">Headline, sub-text, and policies cards (icon, title, body)</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: policiesOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>
          <Transition name="panel-slide">
            <div v-if="policiesOpen" class="section-panel-body">
              <form @submit.prevent="savePolicies">

                <!-- Section Header -->
                <div class="form-group-label">Section Header</div>
                <div class="form-group">
                  <label>Section Label</label>
                  <input v-model="policies.label" type="text" class="form-input" placeholder="Work Policies" />
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Headline Line 1 (plain)</label>
                    <input v-model="policies.headline_plain" type="text" class="form-input" placeholder="How We" />
                  </div>
                  <div class="form-group">
                    <label>Headline Line 2 (gold italic)</label>
                    <input v-model="policies.headline_gold" type="text" class="form-input" placeholder="Work" />
                  </div>
                </div>
                <div class="form-group">
                  <label>Sub-text</label>
                  <textarea v-model="policies.sub" class="form-input form-textarea" rows="2"
                    placeholder="BGC's work policies are designed to attract and retain people who value substance over form."></textarea>
                </div>

                <!-- Policies Cards -->
                <div class="form-group-label" style="margin-top:8px">Policy Cards</div>
                <div v-for="(policy, i) in policies.items" :key="i" class="member-card">
                  <div class="member-card-header">
                    <span class="member-card-num">Policy {{ i + 1 }}</span>
                    <button type="button" class="btn-remove-card" @click="policies.items.splice(i, 1)">Remove</button>
                  </div>
                  <div class="form-row">
                    <div class="form-group" style="flex:0 0 120px">
                      <label>Icon (emoji)</label>
                      <input v-model="policy.icon" type="text" class="form-input" placeholder="📋" />
                    </div>
                    <div class="form-group" style="flex:1">
                      <label>Title</label>
                      <input v-model="policy.title" type="text" class="form-input" placeholder="Equal Opportunity Policy" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Body Text</label>
                    <textarea v-model="policy.body" class="form-input form-textarea" rows="3"></textarea>
                  </div>
                </div>
                <button type="button" class="btn-add-card" @click="policies.items.push({ icon: '', title: '', body: '' })">
                  + Add Policy
                </button>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetPolicies">Reset to Default</button>
                  <button type="submit" class="btn-save" :disabled="policiesSaving">
                    {{ policiesSaving ? 'Saving...' : 'Save Work Policies' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

      </div><!-- /content-wrap -->
    </main>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import { navGroups } from '../navItems.js'

const props = defineProps({
  sections: { type: Object, default: () => ({}) },
})

const page   = usePage()
const admin  = computed(() => page.props.auth?.admin)

const sidebarCollapsed = ref(false)
const mounted          = ref(false)
const activeTab        = ref('intern')

onMounted(() => { setTimeout(() => { mounted.value = true }, 50) })

function logout() {
  router.post('/admin/logout')
}

/* ────────────────────────────────────────────
   HERO
──────────────────────────────────────────── */
const heroDefaults = {
  eyebrow_text:   'Opportunities at BGC',
  eyebrow_tag:    'Join Us',
  headline_plain: 'Build Your Career at the',
  headline_gold:  'Heart of Indian Governance',
  subtext:        'BGC is a collegial, intellectually rigorous institution where capable people are trusted with real work that matters. Every person here has direct access to India\'s most experienced governance practitioners — and is expected to contribute, not observe.',
  award_title:    'Best Place to Work — Not for Profit Category',
  award_sub:      'Economic Times Best Workplaces · 2024 · Collegial culture, intellectual freedom & staff wellbeing',
  tab1_label:     'Work as an Intern',
  tab2_label:     'Work as a Member',
}
const hero       = reactive({ ...heroDefaults, ...(props.sections?.hero ?? {}) })
const heroOpen   = ref(false)
const heroSaving = ref(false)

function saveHero() {
  heroSaving.value = true
  router.put('/admin/work-with-us/hero', { data: { ...hero } }, {
    preserveScroll: true,
    onFinish: () => { heroSaving.value = false },
  })
}
function resetHero() { Object.assign(hero, heroDefaults) }

/* ────────────────────────────────────────────
   INTERN PROGRAMME
──────────────────────────────────────────── */
const programmeDefaults = {
  about_label:          'The Internship Programme',
  about_headline_plain: 'Learn Governance',
  about_headline_gold:  'From Inside It',
  prose_p1: 'BGC\'s internship programme is not a shadow programme. Interns here work alongside the Council\'s senior members — retired IAS, IPS, IFS and allied service officers — on live research, policy documents, and event outputs that are published and used.',
  prose_p2: 'The programme is deliberately small. We accept only 15–20 interns per cohort, three cohorts a year, so that each intern receives real mentorship and carries genuine responsibility. You will read primary sources, draft policy notes, prepare comparative governance briefs, and — where appropriate — attend roundtables and working group sessions.',
  prose_p3: 'BGC interns have gone on to the civil services, law schools, public policy programmes at leading universities, and careers in development finance. Many return as fellows. The BGC internship is an entry into a network that lasts a career.',
  info_card_title: 'Programme at a Glance',
  programme_details: [
    { label: 'Duration',         val: '8–12 weeks (negotiable for working students)' },
    { label: 'Mode',             val: 'In-office (New Delhi) · Hybrid considered' },
    { label: 'Cohort Size',      val: '15–20 per cohort' },
    { label: 'Cohorts per Year', val: 'Three (Jan, May, Sep)' },
    { label: 'Stipend',          val: '₹8,000–₹12,000 / month based on profile' },
    { label: 'Eligibility',      val: 'UG 2nd year and above · PG · Doctoral' },
    { label: 'Certificate',      val: 'Issued on completion · Signed by Chairman' },
    { label: 'Publication',      val: 'Strong interns invited to co-author work' },
  ],
  tasks_label:          'What You\'ll Do',
  tasks_headline_plain: 'Real Work,',
  tasks_headline_gold:  'Real Responsibility',
  tasks: [
    { icon: '📄', title: 'Policy Research & Briefs',   body: 'Research, draft and refine policy briefs and working papers on assigned governance themes. Work with primary government documents, judicial records, legislative debates, and secondary literature.' },
    { icon: '🔍', title: 'Comparative Analysis',       body: 'Study how other states or countries have addressed similar governance problems. Prepare structured comparison notes that go into BGC\'s institutional knowledge base and published outputs.' },
    { icon: '📊', title: 'Data & Evidence Work',       body: 'Source, clean, and interpret data from government databases, CAG reports, parliamentary standing committee reports, and NITI Aayog materials. Translate numbers into governance narratives.' },
    { icon: '🎤', title: 'Event & Dialogue Support',   body: 'Assist in the preparation of BGC roundtables, policy dialogues, and public lectures — including pre-event briefing materials, rapporteuring, and post-event summaries.' },
    { icon: '✍️', title: 'Drafting & Editorial',       body: 'Contribute to op-eds, commentary pieces, and BGC\'s public-facing newsletter. Interns with strong writing skills are actively encouraged to develop their voice under editorial mentorship.' },
    { icon: '🌐', title: 'Programme Research Support', body: 'Support long-running BGC research initiatives — including the Annual Governance Review, the State Capacity Monitor, and the Climate Federalism Programme — by contributing to data gathering and synthesis.' },
  ],
  tracks_label:          'Research Tracks',
  tracks_headline_plain: 'Choose Your',
  tracks_headline_gold:  'Track',
  tracks_sub:   'Interns are placed in one primary track based on their academic background and expressed interest. Cross-track work is encouraged.',
  tracks: [
    { emoji: '🏛️', name: 'State Capacity & Administrative Reform' },
    { emoji: '⚖️', name: 'Constitutional Law & Judicial Governance' },
    { emoji: '💰', name: 'Public Finance & Fiscal Federalism' },
    { emoji: '🌿', name: 'Climate & Environmental Governance' },
    { emoji: '🤝', name: 'Civil Services Ethics & Reform' },
    { emoji: '🌏', name: 'International Affairs & South Asia' },
    { emoji: '🏘️', name: 'Rural Development & Cooperative Law' },
    { emoji: '💻', name: 'Technology Policy & Digital Governance' },
  ],
}

function deepClone(obj) {
  return JSON.parse(JSON.stringify(obj))
}

const programme      = reactive(deepClone({ ...programmeDefaults, ...(props.sections?.intern_programme ?? {}) }))
const programmeOpen  = ref(false)
const programmeSaving = ref(false)

function saveProgramme() {
  programmeSaving.value = true
  router.put('/admin/work-with-us/intern_programme', { data: { ...programme } }, {
    preserveScroll: true,
    onFinish: () => { programmeSaving.value = false },
  })
}
function resetProgramme() { Object.assign(programme, deepClone(programmeDefaults)) }

/* ────────────────────────────────────────────
   INTERN ELIGIBILITY
──────────────────────────────────────────── */
const eligDefaults = {
  label:          'Eligibility & Expectations',
  headline:       'Who We\'re',
  headline_gold:  'Looking For',
  should_bring_title: 'You should bring',
  should_bring: [
    'Enrolment in a recognised UG, PG, or doctoral programme in public policy, law, political science, economics, or related fields',
    'Strong reading habits and the ability to synthesise complex documents',
    'Clear, structured written English (Hindi-language submissions also accepted)',
    'Genuine curiosity about how India\'s government actually functions',
    'Willingness to work independently with minimal supervision',
    'Prior exposure to governance or civil society is valued but not required',
  ],
  do_not_need_title: 'We do not look for',
  do_not_need: [
    'Specific CGPA or academic rank — we care more about the quality of your thinking than your grade sheet',
    'Prior publications or research experience — we are happy to be your first substantive research experience',
    'Attendance at prestigious institutions — we actively recruit from state universities and lesser-known colleges',
    'A fixed political or ideological orientation — BGC is non-partisan and welcomes diverse perspectives',
  ],
  form_sub: 'Fill in the form below. We review applications on a rolling basis. Strong applications hear from us within 10 working days. All fields marked * are required.',
}

const elig      = reactive(deepClone({ ...eligDefaults, ...(props.sections?.intern_eligibility ?? {}) }))
const eligOpen  = ref(false)
const eligSaving = ref(false)

function saveElig() {
  eligSaving.value = true
  router.put('/admin/work-with-us/intern_eligibility', { data: { ...elig } }, {
    preserveScroll: true,
    onFinish: () => { eligSaving.value = false },
  })
}
function resetElig() { Object.assign(elig, deepClone(eligDefaults)) }

/* ────────────────────────────────────────────
   MEMBERSHIP
──────────────────────────────────────────── */
const membershipDefaults = {
  about_label:          'BGC Membership',
  about_headline_plain: 'Join the Council',
  about_headline_gold:  'as a Member',
  prose_p1: 'BGC membership is extended to individuals who bring a meaningful and distinct perspective to India\'s governance conversation — whether as researchers, practitioners, retired officials, legal experts, educators, or civil society leaders.',
  prose_p2: 'Becoming a BGC member is not a transactional arrangement. Members are expected to contribute intellectually — through participation in working groups, co-authorship of research outputs, mentorship of younger staff and interns, and attendance at the Council\'s deliberative forums. In return, BGC offers access to its network of senior practitioners, publishing platforms, and institutional resources.',
  prose_p3: 'Membership is by invitation or application. All applications are reviewed by the Executive Committee and require endorsement by at least one existing Board or Senior Member. We are particularly eager to hear from women, professionals from smaller cities and states, and those working at the intersection of governance and disciplines underrepresented at Indian think tanks.',
  info_card_title: 'Membership at a Glance',
  membership_details: [
    { label: 'Types',           val: 'Research Fellow · Senior Fellow · Associate Member' },
    { label: 'Tenure',          val: '1-year, renewable; Senior Fellows 3-year' },
    { label: 'Mode',            val: 'Residential (Delhi) or non-residential' },
    { label: 'Min. Commitment', val: '1 publication + 4 events per year' },
    { label: 'Remuneration',    val: 'Fellows: Honorarium + project support. Associates: Nominal.' },
    { label: 'Review Process',  val: 'Application → EC Review → Board Endorsement' },
    { label: 'Timeline',        val: '4–8 weeks from submission to decision' },
  ],
  types_label:          'Types of Membership',
  types_headline_plain: 'Three Paths to',
  types_headline_gold:  'Membership',
  member_types: [
    {
      title: 'Research Fellow',
      body: 'For researchers, academics, and policy practitioners with a defined research project. Fellows receive institutional affiliation, office access, publishing support, and direct access to BGC\'s Board for input and engagement. Expected to produce at least one substantive output per year and participate actively in BGC\'s programme calendar.',
      tenure: '1-year, renewable · Full institutional support',
    },
    {
      title: 'Senior Fellow',
      body: 'For highly experienced practitioners — typically retired officers, senior academics, or former constitutional office-holders — who wish to contribute to BGC\'s work in a sustained advisory and intellectual capacity. Senior Fellows chair working groups, co-author flagship publications, and mentor Research Fellows and interns.',
      tenure: '3-year tenure · Honorarium · Leadership role',
    },
    {
      title: 'Associate Member',
      body: 'For engaged citizens, professionals, and students who wish to be part of the BGC network without a formal research commitment. Associate Members attend BGC events, receive publications and the Council digest, and are invited to working group sessions in their area of expertise. Nominal annual fee applies.',
      tenure: 'Annual renewal · Open to all backgrounds',
    },
  ],
  offer_label:          'What BGC Offers Members',
  offer_headline_plain: 'What You',
  offer_headline_gold:  'Gain',
  offer_items: [
    { title: 'Access to Senior Practitioners',  body: 'Every BGC member has direct access to the Council\'s founding members — retired IAS, IPS, IFS, and allied service officers with decades of governance experience. This is not a notional benefit; it is the reason BGC exists.' },
    { title: 'Publishing Platform',             body: 'BGC publishes working papers, policy briefs, opinion pieces, and an annual governance review. Fellows are actively supported to place their work in both BGC\'s own publications and in external journals and media outlets.' },
    { title: 'Peer Network',                    body: 'BGC\'s membership spans civil servants, lawyers, academics, development practitioners, and public intellectuals. Being part of the network means access to people who matter across every dimension of India\'s governance ecosystem.' },
    { title: 'Office & Institutional Resources', body: 'Residential Fellows have access to BGC\'s New Delhi office, research library, and institutional databases including PRS Legislative Research, Manupatra, and select international policy databases.' },
    { title: 'Event Participation',             body: 'BGC\'s calendar includes intimate roundtables, working group sessions, public lectures, and the Annual Civil Governance Dialogue. Members are central participants — not peripheral attendees.' },
    { title: 'Long-term Affiliation',           body: 'BGC alumni and former members remain associated with the institution permanently. We actively support former members in their subsequent careers through references, introductions, and continued collaboration.' },
  ],
}

const membership      = reactive(deepClone({ ...membershipDefaults, ...(props.sections?.membership ?? {}) }))
const membershipOpen  = ref(false)
const membershipSaving = ref(false)

function saveMembership() {
  membershipSaving.value = true
  router.put('/admin/work-with-us/membership', { data: { ...membership } }, {
    preserveScroll: true,
    onFinish: () => { membershipSaving.value = false },
  })
}
function resetMembership() { Object.assign(membership, deepClone(membershipDefaults)) }

/* ────────────────────────────────────────────
   MEMBER FORM
──────────────────────────────────────────── */
const memberFormDefaults = {
  form_label:     'Member Application',
  headline_plain: 'Tell Us About',
  headline_gold:  'Yourself',
  form_sub:       'A three-step application. Be thorough — our Executive Committee reads every application in full. There are no shortcuts, and there is no right or wrong answer to the reflective questions.',
  step1_label:    'Profile',
  step2_label:    'Your Thinking',
  step3_label:    'Final Details',
  step2_sub:      'Four questions. There are no right answers — only honest or generic ones. Be specific. Draw on your actual experience. We read these carefully and weight them heavily.',
  questions: [
    {
      category: 'Governance Challenge',
      text: '"Describe one governance problem in India that you believe is misunderstood — where conventional wisdom or popular diagnosis is, in your view, wrong or incomplete. What is actually going on?"',
      hint: 'Be specific. Name the problem, describe what is usually said about it, explain why you think that is inadequate, and offer your own framing. Aim for 300–400 words.',
    },
    {
      category: 'Your Contribution',
      text: '"What specific knowledge, experience, or perspective do you bring to BGC that is difficult to find elsewhere? Why are you the right person to work on the problem or theme you have described?"',
      hint: 'Do not be modest, but also do not be vague. Tell us something concrete — a district you governed, a case you argued, a dataset you built. 200–300 words.',
    },
    {
      category: 'On Reform',
      text: '"BGC believes that institutional change in India requires patience. Describe a governance reform or institutional change that you think has worked — at any level, in any domain — and explain why it succeeded where others failed."',
      hint: 'This can be a national policy, a state-level initiative, a local administrative innovation, or a quiet procedural reform you observed or participated in. 200–300 words.',
    },
    {
      category: 'Working at BGC',
      text: '"BGC is a small institution with senior practitioners and fewer resources than large think tanks. What do you expect from BGC? And what should BGC expect from you?"',
      hint: 'Be candid. We are not looking for flattery or ambition — we are looking for fit and honesty. 150–250 words.',
    },
  ],
}

const memberForm      = reactive(deepClone({ ...memberFormDefaults, ...(props.sections?.member_form ?? {}) }))
const memberFormOpen  = ref(false)
const memberFormSaving = ref(false)

function saveMemberForm() {
  memberFormSaving.value = true
  router.put('/admin/work-with-us/member_form', { data: { ...memberForm } }, {
    preserveScroll: true,
    onFinish: () => { memberFormSaving.value = false },
  })
}
function resetMemberForm() { Object.assign(memberForm, deepClone(memberFormDefaults)) }

/* ────────────────────────────────────────────
   LIFE AT BGC
──────────────────────────────────────────── */
const lifeDefaults = {
  label:          'Life at BGC',
  headline_plain: 'A Place That Respects',
  headline_gold:  'Your Intelligence',
  prose_p1: 'BGC is a small institution by design. We do not believe that governance research requires large teams, complex hierarchies, or expensive infrastructure. What it requires is careful thinking, deep reading, good writing, and honest conversation — and we build a culture that enables all four.',
  prose_p2: 'We work reasonable hours. We do not celebrate busyness. We expect people to read widely, think slowly, and write carefully — not to produce output at volume. Every person at BGC, from intern to Chairman, is treated as a professional with their own intellectual dignity.',
  prose_p3: 'BGC has a standing Committee Against Discrimination and Harassment, a formal grievance redressal mechanism, and a commitment to equal opportunity that is lived, not stated.',
  award_title: 'Best Place to Work — Not for Profit',
  award_body:  'Bharat Governance Council was recognised by Economic Times Best Workplaces 2024 in the Not-for-Profit category — awarded for its collegial intellectual culture, commitment to staff development, transparent governance, and record of employee wellbeing.',
  values: [
    { icon: '🤝', title: 'Flat, Collegial Culture',        desc: 'Everyone is addressed by name. There is no unnecessary deference to rank or seniority. Ideas are evaluated on their merits — regardless of who offers them.' },
    { icon: '📚', title: 'Intellectual Freedom',           desc: 'BGC takes no institutional positions on policy questions. Your analysis and conclusions are yours. We will support them, not shape them.' },
    { icon: '⏱️', title: 'Reasonable Hours & Flexibility', desc: 'We do not normalise overwork. Core hours are structured; the rest is flexible. Hybrid and remote arrangements are available for fellows and senior associates.' },
    { icon: '🌱', title: 'Learning & Development',         desc: 'BGC actively supports professional development — conference travel, external training, co-authorship with senior board members, and introductions to the wider governance ecosystem.' },
    { icon: '🛡️', title: 'Safe & Equitable Workspace',    desc: 'Formal POSH policy. Grievance redressal committee. Zero tolerance for discrimination on the basis of gender, caste, religion, region, or sexual orientation.' },
  ],
}

const life      = reactive(deepClone({ ...lifeDefaults, ...(props.sections?.life_at_bgc ?? {}) }))
const lifeOpen  = ref(false)
const lifeSaving = ref(false)

function saveLife() {
  lifeSaving.value = true
  router.put('/admin/work-with-us/life_at_bgc', { data: { ...life } }, {
    preserveScroll: true,
    onFinish: () => { lifeSaving.value = false },
  })
}
function resetLife() { Object.assign(life, deepClone(lifeDefaults)) }

/* ────────────────────────────────────────────
   WORK POLICIES
──────────────────────────────────────────── */
const policiesDefaults = {
  label:          'Work Policies',
  headline_plain: 'How We',
  headline_gold:  'Work',
  sub:            'BGC\'s work policies are designed to attract and retain people who value substance over form.',
  items: [
    { icon: '📋', title: 'Equal Opportunity Policy',           body: 'BGC is an equal opportunity institution. Selection and evaluation are based solely on merit, demonstrated capability, and fit. No discrimination on the basis of gender, caste, religion, region, language, disability, or sexual orientation is tolerated.' },
    { icon: '🔒', title: 'Confidentiality & Data Policy',      body: 'All staff and fellows sign confidentiality agreements covering policy deliberations and internal working documents. Personal data collected during applications is processed under BGC\'s Privacy Policy and is never shared with third parties.' },
    { icon: '💸', title: 'Transparent Remuneration',           body: 'BGC publishes its remuneration bands for all categories of staff and fellows annually. We pay fairly relative to the not-for-profit sector and do not discriminate in pay on grounds of gender or background.' },
    { icon: '🛡️', title: 'POSH & Anti-Harassment Policy',     body: 'BGC has a formal Prevention of Sexual Harassment (POSH) policy, a constituted Internal Complaints Committee, and a documented grievance redressal process. All complaints are investigated promptly and confidentially.' },
    { icon: '✍️', title: 'Intellectual Property & Publication', body: 'Research produced at BGC is attributed to the individual author(s). BGC retains institutional rights for republication and use. Fellows and researchers retain the right to publish independently — subject to standard notification to BGC\'s communications team.' },
    { icon: '🌿', title: 'Leave & Wellbeing',                  body: 'Full-time staff receive 24 days earned leave, 12 casual leave days, and 12 public holidays annually. BGC provides medical insurance for all full-time employees and fellows. Maternity and paternity leave policies exceed statutory requirements.' },
  ],
}

const policies      = reactive(deepClone({ ...policiesDefaults, ...(props.sections?.work_policies ?? {}) }))
const policiesOpen  = ref(false)
const policiesSaving = ref(false)

function savePolicies() {
  policiesSaving.value = true
  router.put('/admin/work-with-us/work_policies', { data: { ...policies } }, {
    preserveScroll: true,
    onFinish: () => { policiesSaving.value = false },
  })
}
function resetPolicies() { Object.assign(policies, deepClone(policiesDefaults)) }

const seoDefaults = {
  meta_title:       'Work With Us | Bharat Governance Council',
  meta_description: 'Join the Bharat Governance Council through our internship programme, fellowship tracks, or membership. Work on meaningful governance research and policy.',
  meta_keywords:    'work with us, internship, fellowship, membership, BGC, governance, careers',
}
const seo       = reactive(deepClone({ ...seoDefaults, ...(props.sections?.seo ?? {}) }))
const seoOpen   = ref(false)
const seoSaving = ref(false)
function saveSeo() {
  seoSaving.value = true
  router.put('/admin/work-with-us/seo', { data: { ...seo } }, {
    preserveScroll: true,
    onFinish: () => (seoSaving.value = false),
  })
}
function resetSeo() { Object.assign(seo, deepClone(seoDefaults)) }
</script>

<style scoped>
/* ─── Layout ──────────────────────────────────────── */
.admin-root {
  display: flex; min-height: 100vh;
  background: #f2f4f8; font-family: 'DM Sans', sans-serif;
}

/* ─── Sidebar ─────────────────────────────────────── */
.admin-sidebar {
  width: 220px; flex-shrink: 0;
  background: #0b1c38; color: #f5f7fa;
  display: flex; flex-direction: column;
  transition: width 0.25s ease; overflow: hidden;
  position: sticky; top: 0; height: 100vh;
}
.admin-sidebar.collapsed { width: 56px; }

.sidebar-logo {
  display: flex; align-items: center; gap: 10px;
  padding: 18px 14px 14px;
  border-bottom: 1px solid rgba(255,255,255,0.07);
}
.sidebar-logo-img { width: 28px; height: 28px; object-fit: contain; flex-shrink: 0; }
.sidebar-logo-label {
  font-size: 11px; font-weight: 700; letter-spacing: 0.18em;
  text-transform: uppercase; color: #c9a84c; white-space: nowrap;
}

.sidebar-nav {
  flex: 1; padding: 10px 8px; overflow-y: auto;
  display: flex; flex-direction: column; gap: 2px;
}
.nav-group-label {
  font-size: 9px; font-weight: 600; letter-spacing: 0.2em;
  text-transform: uppercase; color: rgba(184,197,216,0.35);
  padding: 10px 8px 4px; white-space: nowrap;
}
.nav-item {
  display: flex; align-items: center; gap: 10px;
  padding: 8px 10px; border-radius: 6px;
  font-size: 12.5px; font-weight: 400;
  color: rgba(184,197,216,0.6); text-decoration: none;
  transition: all 0.18s ease; white-space: nowrap;
}
.nav-item:hover { background: rgba(255,255,255,0.06); color: #f5f7fa; }
.nav-item.active { background: rgba(201,168,76,0.12); color: #c9a84c; }
.nav-icon { display: flex; align-items: center; flex-shrink: 0; }
.nav-icon :deep(svg) { width: 15px; height: 15px; }

.sidebar-toggle {
  margin: 0 8px 8px; padding: 7px;
  background: rgba(255,255,255,0.04); border: none;
  border-radius: 6px; cursor: pointer;
  color: rgba(184,197,216,0.5); display: flex; justify-content: center;
  transition: all 0.18s ease;
}
.sidebar-toggle:hover { background: rgba(255,255,255,0.09); color: #f5f7fa; }
.sidebar-toggle svg.flipped { transform: rotate(180deg); }

.sidebar-footer { padding: 10px 8px 16px; }
.btn-logout {
  display: flex; align-items: center; gap: 8px;
  width: 100%; padding: 8px 10px; border: none;
  border-radius: 6px; background: rgba(255,255,255,0.04);
  color: rgba(184,197,216,0.55); font-size: 12px;
  cursor: pointer; transition: all 0.18s ease;
}
.btn-logout:hover { background: rgba(220,50,50,0.12); color: #f08080; }

/* ─── Main area ───────────────────────────────────── */
.admin-main { flex: 1; display: flex; flex-direction: column; min-width: 0; }

/* ─── Topbar ──────────────────────────────────────── */
.admin-topbar {
  display: flex; align-items: center; justify-content: space-between;
  padding: 14px 28px;
  background: #fff; border-bottom: 1px solid #e8eaf0;
  position: sticky; top: 0; z-index: 10;
}
.topbar-left { display: flex; flex-direction: column; gap: 2px; }
.topbar-title { font-size: 15px; font-weight: 600; color: #0b1c38; }
.topbar-breadcrumb { font-size: 11px; color: #8a9bbf; display: flex; gap: 5px; }
.bc-sep { color: #c9c9c9; }
.bc-active { color: #c9a84c; font-weight: 500; }

.topbar-right { display: flex; align-items: center; gap: 20px; }
.topbar-live  { display: flex; align-items: center; gap: 6px; }
.live-dot {
  display: inline-block; width: 6px; height: 6px;
  border-radius: 50%; background: #22c55e;
  box-shadow: 0 0 6px rgba(34,197,94,0.6);
  animation: livePulse 2s ease-in-out infinite;
}
@keyframes livePulse { 0%,100%{opacity:1} 50%{opacity:0.4} }
.live-label { font-size: 11px; color: #22c55e; font-weight: 500; }

.topbar-admin { display: flex; align-items: center; gap: 10px; }
.admin-avatar {
  width: 30px; height: 30px; border-radius: 50%;
  background: linear-gradient(135deg, #0b1c38, #162d55);
  border: 1.5px solid rgba(201,168,76,0.4);
  display: flex; align-items: center; justify-content: center;
  font-size: 11px; font-weight: 700; color: #c9a84c;
}
.admin-info { display: flex; flex-direction: column; gap: 1px; }
.admin-name  { font-size: 12px; font-weight: 600; color: #0b1c38; }
.admin-email { font-size: 10px; color: #8a9bbf; }

/* ─── Content wrap ────────────────────────────────── */
.content-wrap {
  padding: 28px; max-width: 960px;
  opacity: 0; transform: translateY(10px);
  transition: opacity 0.4s ease, transform 0.4s ease;
}
.content-wrap.visible { opacity: 1; transform: translateY(0); }

/* ─── Flash messages ──────────────────────────────── */
.flash {
  padding: 12px 16px; border-radius: 6px;
  font-size: 13px; font-weight: 500; margin-bottom: 20px;
}
.flash-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
.flash-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

/* ─── Page header ─────────────────────────────────── */
.page-header { margin-bottom: 24px; }
.page-title { font-size: 22px; font-weight: 700; color: #0b1c38; }
.page-sub   { font-size: 13px; color: #8a9bbf; margin-top: 4px; }

/* ─── Section panel ───────────────────────────────── */
.section-panel {
  background: #fff; border: 1px solid #e8eaf0;
  border-radius: 10px; margin-bottom: 16px;
  overflow: hidden;
}
.section-panel-header {
  display: flex; align-items: center; justify-content: space-between;
  padding: 18px 22px; cursor: pointer;
  transition: background 0.18s ease;
}
.section-panel-header:hover { background: #fafbff; }
.section-panel-left { display: flex; align-items: center; gap: 16px; }
.section-num {
  font-size: 11px; font-weight: 700; letter-spacing: 0.18em;
  color: #c9a84c; font-family: 'DM Mono', monospace;
}
.section-panel-title { font-size: 14px; font-weight: 600; color: #0b1c38; }
.section-panel-desc  { font-size: 12px; color: #8a9bbf; margin-top: 2px; }
.section-chevron {
  color: #8a9bbf; transition: transform 0.25s ease; flex-shrink: 0;
}
.section-chevron.open { transform: rotate(180deg); }
.section-panel-body { padding: 0 22px 22px; border-top: 1px solid #f0f1f5; }

/* ─── Panel slide transition ──────────────────────── */
.panel-slide-enter-active,
.panel-slide-leave-active { transition: all 0.28s ease; overflow: hidden; }
.panel-slide-enter-from,
.panel-slide-leave-to { opacity: 0; max-height: 0; padding-top: 0; padding-bottom: 0; }
.panel-slide-enter-to,
.panel-slide-leave-from { opacity: 1; max-height: 4000px; }

/* ─── Tab Switcher ────────────────────────────────── */
.tab-switcher {
  display: flex; gap: 4px;
  background: #fff; border: 1px solid #e8eaf0;
  border-radius: 10px; padding: 6px;
  margin-bottom: 16px;
}
.tab-sw-btn {
  flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px;
  padding: 10px 16px; border: none; border-radius: 7px;
  font-size: 12.5px; font-weight: 500; cursor: pointer;
  color: #8a9bbf; background: transparent;
  font-family: 'DM Sans', sans-serif;
  transition: all 0.2s ease;
}
.tab-sw-btn:hover:not(.active) { background: #f5f7fa; color: #0b1c38; }
.tab-sw-btn.active {
  background: #0b1c38; color: #c9a84c;
}
.tab-sw-btn svg { flex-shrink: 0; }

/* ─── Form elements ───────────────────────────────── */
.form-group-label {
  font-size: 10px; font-weight: 700; letter-spacing: 0.18em;
  text-transform: uppercase; color: #c9a84c;
  padding: 18px 0 10px; border-bottom: 1px solid #f0f1f5; margin-bottom: 14px;
}
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 14px; }
.form-group label { font-size: 12px; font-weight: 500; color: #4a5568; }
.form-input {
  padding: 9px 12px; border: 1px solid #e2e8f0; border-radius: 6px;
  font-size: 13px; color: #0b1c38; background: #fafbff;
  font-family: 'DM Sans', sans-serif; transition: border-color 0.18s ease;
  width: 100%;
}
.form-input:focus { outline: none; border-color: #c9a84c; background: #fff; }
.form-textarea { resize: vertical; min-height: 72px; line-height: 1.6; }

/* ─── Array rows ──────────────────────────────────── */
.array-row {
  display: flex; align-items: flex-start; gap: 8px;
  background: #fafbff; border: 1px solid #e8eaf0;
  border-radius: 7px; padding: 12px 12px 12px 14px;
  margin-bottom: 8px;
}
.array-row-fields { display: flex; gap: 12px; flex: 1; }
.btn-remove-row {
  flex-shrink: 0; width: 26px; height: 26px; margin-top: 20px;
  display: flex; align-items: center; justify-content: center;
  background: rgba(220,50,50,0.06); border: 1px solid rgba(220,50,50,0.15);
  border-radius: 5px; cursor: pointer; color: #dc3232;
  transition: all 0.18s ease;
}
.btn-remove-row:hover { background: rgba(220,50,50,0.15); }
.btn-add-row {
  width: 100%; padding: 9px; border: 1px dashed #c9a84c;
  border-radius: 6px; background: rgba(201,168,76,0.04);
  color: #c9a84c; font-size: 12px; font-weight: 600;
  cursor: pointer; margin-bottom: 8px;
  transition: all 0.18s ease; font-family: 'DM Sans', sans-serif;
}
.btn-add-row:hover { background: rgba(201,168,76,0.09); }

/* ─── Member cards (for tasks) ────────────────────── */
.member-card {
  background: #fafbff; border: 1px solid #e8eaf0;
  border-radius: 8px; padding: 16px;
  margin-bottom: 10px;
}
.member-card-header {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 14px;
}
.member-card-num {
  font-size: 10px; font-weight: 700; letter-spacing: 0.16em;
  text-transform: uppercase; color: #c9a84c;
  font-family: 'DM Mono', monospace;
}
.btn-remove-card {
  font-size: 11px; color: #dc3232; background: none; border: none;
  cursor: pointer; font-weight: 500; transition: opacity 0.18s;
}
.btn-remove-card:hover { opacity: 0.7; }
.btn-add-card {
  width: 100%; padding: 10px; border: 1px dashed #c9a84c;
  border-radius: 6px; background: rgba(201,168,76,0.04);
  color: #c9a84c; font-size: 12px; font-weight: 600;
  cursor: pointer; margin-bottom: 8px;
  transition: all 0.18s ease; font-family: 'DM Sans', sans-serif;
}
.btn-add-card:hover { background: rgba(201,168,76,0.09); }

/* ─── Form actions ────────────────────────────────── */
.form-actions {
  display: flex; justify-content: flex-end; gap: 10px;
  padding-top: 16px; border-top: 1px solid #f0f1f5; margin-top: 8px;
}
.btn-reset {
  padding: 8px 16px; border: 1px solid #e2e8f0; border-radius: 6px;
  font-size: 12px; font-weight: 500; color: #8a9bbf;
  background: #fff; cursor: pointer; transition: all 0.18s ease;
}
.btn-reset:hover { border-color: #c9a84c; color: #c9a84c; }
.btn-save {
  padding: 8px 20px; border: none; border-radius: 6px;
  font-size: 12px; font-weight: 600;
  background: linear-gradient(135deg, #c9a84c, #e8cf8a);
  color: #0b1c38; cursor: pointer; transition: all 0.18s ease;
}
.btn-save:hover:not(:disabled) { opacity: 0.88; transform: translateY(-1px); }
.btn-save:disabled { opacity: 0.5; cursor: not-allowed; }

/* ─── Tab section divider ─────────────────────────── */
.tab-section-divider {
  display: flex; align-items: center; gap: 12px;
  margin: 24px 0 16px;
}
.tab-section-divider::before,
.tab-section-divider::after {
  content: ''; flex: 1; height: 1px; background: #e8eaf0;
}
.tab-section-divider span {
  font-size: 10px; font-weight: 700; letter-spacing: 0.18em;
  text-transform: uppercase; color: #b8c5d8;
  font-family: 'DM Mono', monospace; white-space: nowrap;
}
</style>
