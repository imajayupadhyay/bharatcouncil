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
            :class="{ active: item.id === 'governing-board' }"
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
          <h2 class="topbar-title">Governing Board Manager</h2>
          <div class="topbar-breadcrumb">
            <span>Admin</span><span class="bc-sep">›</span>
            <span class="bc-active">Governing Board</span>
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
            <h1 class="page-title">Governing Board Sections</h1>
            <p class="page-sub">Manage the content displayed on the Governing Board page. Edit each section below.</p>
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
                <p class="section-panel-desc">Headline, subtext, and stats</p>
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
                <div class="form-group">
                  <label>Eyebrow Text</label>
                  <input v-model="hero.eyebrow_text" type="text" class="form-input" placeholder="About BGC" />
                </div>

                <div class="form-group-label">Headline</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Headline Line 1</label>
                    <input v-model="hero.headline_line1" type="text" class="form-input" placeholder="Governing" />
                  </div>
                  <div class="form-group">
                    <label>Headline Line 2 (gold italic)</label>
                    <input v-model="hero.headline_line2" type="text" class="form-input" placeholder="Board" />
                  </div>
                </div>

                <div class="form-group">
                  <label>Subtext</label>
                  <textarea v-model="hero.subtext" class="form-input form-textarea" rows="3"></textarea>
                </div>

                <div class="form-group-label">Stats</div>
                <div v-for="(stat, i) in hero.stats" :key="i" class="stat-row">
                  <span class="stat-row-num">{{ i + 1 }}</span>
                  <div class="form-group">
                    <label>Number</label>
                    <input v-model="stat.num" type="text" class="form-input" placeholder="15+" />
                  </div>
                  <div class="form-group">
                    <label>Label</label>
                    <input v-model="stat.label" type="text" class="form-input" placeholder="Board Members" />
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

        <!-- ══════════ CHAIRMAN SECTION ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="chairmanOpen = !chairmanOpen">
            <div class="section-panel-left">
              <span class="section-num">02</span>
              <div>
                <h3 class="section-panel-title">Chairman Section</h3>
                <p class="section-panel-desc">Profile details, responsibilities, and tags</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: chairmanOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>

          <Transition name="panel-slide">
            <div v-if="chairmanOpen" class="section-panel-body">
              <form @submit.prevent="saveChairman">
                <div class="form-group-label">Section Label</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Section Eyebrow</label>
                    <input v-model="chairman.section_label" type="text" class="form-input" placeholder="Chairman" />
                  </div>
                  <div class="form-group">
                    <label>Badge Text</label>
                    <input v-model="chairman.badge_text" type="text" class="form-input" placeholder="Chairman" />
                  </div>
                </div>

                <div class="form-group-label">Photo</div>
                <!-- Chairman photo upload -->
                <div class="ch-photo-row">
                  <div class="ch-photo-preview">
                    <img v-if="chairman.image" :src="chairman.image" class="ch-photo-img" alt="Chairman" />
                    <div v-else class="ch-photo-placeholder">
                      <span>{{ chairman.initials || 'KV' }}</span>
                    </div>
                  </div>
                  <div class="ch-photo-right">
                    <p class="ch-photo-label">Chairman Photo</p>
                    <p class="ch-photo-hint">Fills the full card rectangle. Portrait orientation (e.g. 3:4) works best. PNG/JPG/WebP, max 4 MB.</p>
                    <div class="ch-photo-btns">
                      <label class="btn-upload-voice" :class="{ 'btn-uploading': chairmanUploading }">
                        <input
                          type="file"
                          accept="image/png,image/jpeg,image/jpg,image/webp"
                          style="display:none"
                          :disabled="chairmanUploading"
                          @change="uploadChairmanImage"
                        />
                        <svg viewBox="0 0 16 16" fill="none" width="12" height="12">
                          <path d="M8 3v8M4 7l4-4 4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M2 13h12" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                        </svg>
                        {{ chairmanUploading ? 'Uploading…' : (chairman.image ? 'Change Photo' : 'Upload Photo') }}
                      </label>
                      <button
                        v-if="chairman.image"
                        type="button"
                        class="btn-remove-voice-img"
                        :disabled="chairmanRemoving"
                        @click="removeChairmanImage"
                      >
                        <svg viewBox="0 0 16 16" fill="none" width="11" height="11">
                          <path d="M3 3l10 10M13 3L3 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        {{ chairmanRemoving ? 'Removing…' : 'Remove Photo' }}
                      </button>
                    </div>
                  </div>
                </div>

                <div class="form-group-label" style="margin-top:20px">Badge Overlay (shown on photo)</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Initials (shown in badge)</label>
                    <input v-model="chairman.initials" type="text" class="form-input" placeholder="KV" />
                  </div>
                  <div class="form-group">
                    <label>Service Line (shown in badge)</label>
                    <input v-model="chairman.avatar_service" type="text" class="form-input" placeholder="IAS · 1979 · UP Cadre" />
                  </div>
                </div>

                <div class="form-group-label">Profile Details</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Position Line</label>
                    <input v-model="chairman.position" type="text" class="form-input" placeholder="Chairman, Bharat Governance Council" />
                  </div>
                  <div class="form-group">
                    <label>Name</label>
                    <input v-model="chairman.name" type="text" class="form-input" placeholder="Dr. Kush Verma" />
                  </div>
                </div>
                <div class="form-group">
                  <label>Service Description</label>
                  <input v-model="chairman.service" type="text" class="form-input" placeholder="Indian Administrative Service, 1979 Batch · Uttar Pradesh Cadre (Retd.)" />
                </div>

                <div class="form-group-label">Biography</div>
                <div v-for="(bio, index) in chairman.bios" :key="index" class="form-group">
                  <label>Bio Paragraph {{ index + 1 }}</label>
                  <textarea v-model="chairman.bios[index]" class="form-input form-textarea" rows="3"></textarea>
                </div>
                <button type="button" class="btn-add" @click="addChairmanBio">+ Add Bio Paragraph</button>

                <div class="form-group-label">Responsibilities</div>
                <div v-for="(resp, index) in chairman.responsibilities" :key="index" class="form-group">
                  <label>Responsibility {{ index + 1 }}</label>
                  <div class="form-row">
                    <input v-model="chairman.responsibilities[index]" type="text" class="form-input" />
                    <button type="button" class="btn-remove" @click="removeChairmanResponsibility(index)">×</button>
                  </div>
                </div>
                <button type="button" class="btn-add" @click="addChairmanResponsibility">+ Add Responsibility</button>

                <div class="form-group-label">Tags</div>
                <div v-for="(tag, index) in chairman.tags" :key="index" class="form-group">
                  <label>Tag {{ index + 1 }}</label>
                  <div class="form-row">
                    <input v-model="chairman.tags[index]" type="text" class="form-input" />
                    <button type="button" class="btn-remove" @click="removeChairmanTag(index)">×</button>
                  </div>
                </div>
                <button type="button" class="btn-add" @click="addChairmanTag">+ Add Tag</button>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetChairman">Reset to Default</button>
                  <button type="submit" class="btn-save" :disabled="chairmanSaving">
                    {{ chairmanSaving ? 'Saving...' : 'Save Chairman Section' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

        <!-- ══════════ EXECUTIVE OFFICERS SECTION ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="execOpen = !execOpen">
            <div class="section-panel-left">
              <span class="section-num">03</span>
              <div>
                <h3 class="section-panel-title">Executive Officers</h3>
                <p class="section-panel-desc">Section headline and officer profiles</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: execOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>

          <Transition name="panel-slide">
            <div v-if="execOpen" class="section-panel-body">
              <form @submit.prevent="saveExecutiveOfficers">
                <div class="form-group-label">Section Header</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Section Label</label>
                    <input v-model="executiveOfficers.section_label" type="text" class="form-input" />
                  </div>
                  <div class="form-group">
                    <label>Headline Before</label>
                    <input v-model="executiveOfficers.headline_before" type="text" class="form-input" />
                  </div>
                  <div class="form-group">
                    <label>Headline Emphasis</label>
                    <input v-model="executiveOfficers.headline_emphasis" type="text" class="form-input" />
                  </div>
                </div>
                <div class="form-group">
                  <label>Subtext</label>
                  <textarea v-model="executiveOfficers.subtext" class="form-input form-textarea" rows="2"></textarea>
                </div>

                <div class="form-group-label">Executive Officers</div>
                <div v-for="(officer, index) in executiveOfficers.officers" :key="index" class="card-edit-block">
                  <div class="card-edit-header">
                    <span class="card-edit-num">Officer {{ index + 1 }}</span>
                    <button type="button" class="btn-remove" @click="removeExecutiveOfficer(index)">Remove</button>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Initials</label>
                      <input v-model="officer.initials" type="text" class="form-input" />
                    </div>
                    <div class="form-group">
                      <label>Service Badge</label>
                      <input v-model="officer.svcBadge" type="text" class="form-input" />
                    </div>
                    <div class="form-group">
                      <label>Position</label>
                      <input v-model="officer.position" type="text" class="form-input" />
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Name</label>
                      <input v-model="officer.name" type="text" class="form-input" />
                    </div>
                    <div class="form-group">
                      <label>Service</label>
                      <input v-model="officer.service" type="text" class="form-input" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Bio (HTML allowed)</label>
                    <textarea v-model="officer.bio" class="form-input form-textarea" rows="3"></textarea>
                  </div>

                  <div class="form-group-label" style="margin-top:12px">Photo</div>
                  <div class="ch-photo-row">
                    <div class="ch-photo-preview" style="width:72px;height:90px">
                      <img v-if="officer.image" :src="officer.image" class="ch-photo-img" alt="Officer" />
                      <div v-else class="ch-photo-placeholder">
                        <span>{{ officer.initials || '?' }}</span>
                      </div>
                    </div>
                    <div class="ch-photo-right">
                      <p class="ch-photo-label">Officer Photo</p>
                      <p class="ch-photo-hint">Portrait orientation recommended (e.g. 3:4). PNG/JPG/WebP, max 4 MB.</p>
                      <div class="ch-photo-btns">
                        <label class="btn-upload-voice" :class="{ 'btn-uploading': officerUploading[index] }">
                          <input
                            type="file"
                            accept="image/png,image/jpeg,image/jpg,image/webp"
                            style="display:none"
                            :disabled="officerUploading[index]"
                            @change="uploadOfficerImage(index, $event)"
                          />
                          <svg viewBox="0 0 16 16" fill="none" width="12" height="12">
                            <path d="M8 3v8M4 7l4-4 4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 13h12" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                          </svg>
                          {{ officerUploading[index] ? 'Uploading…' : (officer.image ? 'Change Photo' : 'Upload Photo') }}
                        </label>
                        <button
                          v-if="officer.image"
                          type="button"
                          class="btn-remove-voice-img"
                          :disabled="officerRemoving[index]"
                          @click="removeOfficerImage(index)"
                        >
                          <svg viewBox="0 0 16 16" fill="none" width="11" height="11">
                            <path d="M3 3l10 10M13 3L3 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                          </svg>
                          {{ officerRemoving[index] ? 'Removing…' : 'Remove Photo' }}
                        </button>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Tags</label>
                    <div v-for="(tag, tagIndex) in officer.tags" :key="tagIndex" class="form-row">
                      <input v-model="officer.tags[tagIndex]" type="text" class="form-input" />
                      <button type="button" class="btn-remove" @click="removeOfficerTag(index, tagIndex)">×</button>
                    </div>
                    <button type="button" class="btn-add" @click="addOfficerTag(index)">+ Add Tag</button>
                  </div>
                </div>
                <button type="button" class="btn-add" @click="addExecutiveOfficer">+ Add Officer</button>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetExecutiveOfficers">Reset to Default</button>
                  <button type="submit" class="btn-save" :disabled="execSaving">
                    {{ execSaving ? 'Saving...' : 'Save Executive Officers' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

        <!-- ══════════ BOARD MEMBERS SECTION ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="boardOpen = !boardOpen">
            <div class="section-panel-left">
              <span class="section-num">04</span>
              <div>
                <h3 class="section-panel-title">Board Members</h3>
                <p class="section-panel-desc">All 9 board member cards</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: boardOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>

          <Transition name="panel-slide">
            <div v-if="boardOpen" class="section-panel-body">
              <form @submit.prevent="saveBoardMembers">
                <div class="form-group-label">Section Header</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Section Label</label>
                    <input v-model="boardMembers.section_label" type="text" class="form-input" />
                  </div>
                  <div class="form-group">
                    <label>Headline Before</label>
                    <input v-model="boardMembers.headline_before" type="text" class="form-input" />
                  </div>
                  <div class="form-group">
                    <label>Headline Emphasis</label>
                    <input v-model="boardMembers.headline_emphasis" type="text" class="form-input" />
                  </div>
                </div>
                <div class="form-group">
                  <label>Subtext</label>
                  <textarea v-model="boardMembers.subtext" class="form-input form-textarea" rows="2"></textarea>
                </div>

                <div class="form-group-label">Board Members (9)</div>
                <div v-for="(member, index) in boardMembers.members" :key="index" class="card-edit-block">
                  <div class="card-edit-header">
                    <span class="card-edit-num">Member {{ index + 1 }}</span>
                    <button type="button" class="btn-remove" @click="removeBoardMember(index)">Remove</button>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Initials</label>
                      <input v-model="member.initials" type="text" class="form-input" />
                    </div>
                    <div class="form-group">
                      <label>Position</label>
                      <input v-model="member.position" type="text" class="form-input" />
                    </div>
                    <div class="form-group">
                      <label>Name</label>
                      <input v-model="member.name" type="text" class="form-input" />
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Service</label>
                      <input v-model="member.service" type="text" class="form-input" />
                    </div>
                    <div class="form-group">
                      <label>Area Tag</label>
                      <input v-model="member.area" type="text" class="form-input" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Bio (HTML allowed)</label>
                    <textarea v-model="member.bio" class="form-input form-textarea" rows="3"></textarea>
                  </div>

                  <div class="form-group-label" style="margin-top:12px">Photo</div>
                  <div class="ch-photo-row">
                    <div class="ch-photo-preview" style="width:60px;height:60px;border-radius:50%">
                      <img v-if="member.image" :src="member.image" class="ch-photo-img" style="border-radius:50%" alt="Member" />
                      <div v-else class="ch-photo-placeholder">
                        <span>{{ member.initials || '?' }}</span>
                      </div>
                    </div>
                    <div class="ch-photo-right">
                      <p class="ch-photo-label">Member Photo</p>
                      <p class="ch-photo-hint">Square or portrait image. PNG/JPG/WebP, max 4 MB.</p>
                      <div class="ch-photo-btns">
                        <label class="btn-upload-voice" :class="{ 'btn-uploading': memberUploading[index] }">
                          <input
                            type="file"
                            accept="image/png,image/jpeg,image/jpg,image/webp"
                            style="display:none"
                            :disabled="memberUploading[index]"
                            @change="uploadMemberImage(index, $event)"
                          />
                          <svg viewBox="0 0 16 16" fill="none" width="12" height="12">
                            <path d="M8 3v8M4 7l4-4 4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 13h12" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                          </svg>
                          {{ memberUploading[index] ? 'Uploading…' : (member.image ? 'Change Photo' : 'Upload Photo') }}
                        </label>
                        <button
                          v-if="member.image"
                          type="button"
                          class="btn-remove-voice-img"
                          :disabled="memberRemoving[index]"
                          @click="removeMemberImage(index)"
                        >
                          <svg viewBox="0 0 16 16" fill="none" width="11" height="11">
                            <path d="M3 3l10 10M13 3L3 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                          </svg>
                          {{ memberRemoving[index] ? 'Removing…' : 'Remove Photo' }}
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <button type="button" class="btn-add" @click="addBoardMember">+ Add Board Member</button>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetBoardMembers">Reset to Default</button>
                  <button type="submit" class="btn-save" :disabled="boardSaving">
                    {{ boardSaving ? 'Saving...' : 'Save Board Members' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

        <!-- ══════════ JOIN CTA SECTION ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="joinOpen = !joinOpen">
            <div class="section-panel-left">
              <span class="section-num">05</span>
              <div>
                <h3 class="section-panel-title">Join CTA</h3>
                <p class="section-panel-desc">CTA text and links</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: joinOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>

          <Transition name="panel-slide">
            <div v-if="joinOpen" class="section-panel-body">
              <form @submit.prevent="saveJoinCta">
                <div class="form-group-label">Section Header</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Section Label</label>
                    <input v-model="joinCta.section_label" type="text" class="form-input" />
                  </div>
                  <div class="form-group">
                    <label>Watermark Text</label>
                    <input v-model="joinCta.watermark" type="text" class="form-input" />
                  </div>
                  <div class="form-group">
                    <label>Headline Before</label>
                    <input v-model="joinCta.headline_before" type="text" class="form-input" />
                  </div>
                  <div class="form-group">
                    <label>Headline Emphasis</label>
                    <input v-model="joinCta.headline_emphasis" type="text" class="form-input" />
                  </div>
                </div>
                <div class="form-group">
                  <label>Subtext</label>
                  <textarea v-model="joinCta.subtext" class="form-input form-textarea" rows="3"></textarea>
                </div>

                <div class="form-group-label">CTA Cards</div>
                <div v-for="(card, index) in joinCta.cards" :key="index" class="card-edit-block">
                  <div class="card-edit-header">
                    <span class="card-edit-num">Card {{ index + 1 }}</span>
                    <button type="button" class="btn-remove" @click="removeJoinCard(index)">Remove</button>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Type</label>
                      <input v-model="card.type" type="text" class="form-input" />
                    </div>
                    <div class="form-group">
                      <label>Title</label>
                      <input v-model="card.title" type="text" class="form-input" />
                    </div>
                    <div class="form-group">
                      <label>Button Text</label>
                      <input v-model="card.cta" type="text" class="form-input" />
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Button Link</label>
                      <input v-model="card.href" type="text" class="form-input" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <textarea v-model="card.desc" class="form-input form-textarea" rows="3"></textarea>
                  </div>
                </div>
                <button type="button" class="btn-add" @click="addJoinCard">+ Add CTA Card</button>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetJoinCta">Reset to Default</button>
                  <button type="submit" class="btn-save" :disabled="joinSaving">
                    {{ joinSaving ? 'Saving...' : 'Save Join CTA' }}
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
import { navGroups } from '../navItems.js'

const props = defineProps({
  admin: Object,
  sections: Object,
})

const mounted = ref(false)
const sidebarCollapsed = ref(false)
const heroOpen = ref(true)
const heroSaving = ref(false)
const chairmanOpen = ref(false)
const chairmanSaving = ref(false)
const execOpen = ref(false)
const execSaving = ref(false)
const boardOpen = ref(false)
const boardSaving = ref(false)
const joinOpen = ref(false)
const joinSaving = ref(false)

const heroDefaults = {
  eyebrow_text: 'About BGC',
  headline_line1: 'Governing',
  headline_line2: 'Board',
  subtext: `The Bharat Governance Council is guided by a Governing Board of distinguished retired officers of India's All India Services and allied cadres — men and women who have, collectively, governed at the highest levels of the Indian state. They bring to BGC not theory, but lived administrative experience across every domain of public governance.`,
  stats: [
    { num: '15+', label: 'Board Members' },
    { num: '6', label: 'All India Services' },
    { num: '30+', label: 'Avg. Years of Service' },
    { num: '2023', label: 'Year Established' },
  ],
}

const savedHero = props.sections?.hero || {}
const hero = reactive({
  ...heroDefaults,
  ...savedHero,
  stats: savedHero.stats?.length ? savedHero.stats.map(stat => ({ ...stat })) : heroDefaults.stats.map(stat => ({ ...stat })),
})

const chairmanDefaults = {
  section_label: 'Chairman',
  badge_text: 'Chairman',
  initials: 'KV',
  avatar_service: 'IAS · 1979 · UP Cadre',
  position: 'Chairman, Bharat Governance Council',
  name: 'Dr. Kush Verma',
  service: 'Indian Administrative Service, 1979 Batch · Uttar Pradesh Cadre (Retd.)',
  bios: [
    `Dr. Kush Verma is a retired IAS officer of the 1979 Batch, UP Cadre, and the founder-Chairman of Bharat Governance Council. He served as the <strong>first Director General of the National Centre for Good Governance (NCGG)</strong>, Government of India — the apex institution mandated to build administrative excellence and civil service capacity across India and partner nations. Prior to NCGG, he was <strong>Director General of the National Institute of Administrative Research (NIAR)</strong>, playing a key role in modernising civil service training.`,
    `Over a long and distinguished career, Dr. Verma served as Commissioner of the National Capital Region (UP side) and held senior positions in the Governments of India and Uttar Pradesh across rural development, tribal affairs, food security, and law & order. He holds a <strong>Doctorate from Jamia Millia Islamia</strong> on 'Redesigning India's Civil Services', and is the author of <em>A-Z of The Civil Services</em> (Manas Publications, 2019).`,
    `As Chairman of BGC, Dr. Verma provides overall strategic leadership, sets the Council's research agenda, and personally oversees the flagship mentorship programme for younger civil servants.`,
  ],
  responsibilities: [
    'Overall strategic direction and governance of the Council',
    'Chair, Governing Board meetings and Executive Committee',
    'Lead convener, Annual Civil Governance Dialogue',
    'Oversee mentorship programme for younger IAS / IPS / IFS officers',
    'Institutional partnerships with LBSNAA, NCGG, and academic bodies',
    'Represent BGC in national and international governance forums',
  ],
  tags: [
    'Civil Service Reform', 'Good Governance', 'Decentralisation',
    'Administrative Ethics', 'NCGG · LBSNAA', 'Author & Scholar',
  ],
}

const savedChairman = props.sections?.chairman || {}
const chairman = reactive({
  ...chairmanDefaults,
  ...savedChairman,
  image:       savedChairman.image       || null,
  stored_path: savedChairman.stored_path || null,
  bios: savedChairman.bios?.length ? savedChairman.bios.map(bio => bio) : chairmanDefaults.bios.map(bio => bio),
  responsibilities: savedChairman.responsibilities?.length
    ? savedChairman.responsibilities.map(item => item)
    : chairmanDefaults.responsibilities.map(item => item),
  tags: savedChairman.tags?.length ? savedChairman.tags.map(tag => tag) : chairmanDefaults.tags.map(tag => tag),
})

const execDefaults = {
  section_label: 'Executive Officers',
  headline_before: 'Senior',
  headline_emphasis: 'Leadership',
  subtext: 'Two founding leaders who carry specific executive portfolios alongside their board responsibilities.',
  officers: [
    {
      initials: 'SK',
      svcBadge: 'IFoS · 1984',
      position: 'Vice Chairman & Chief Advisor — Climate & Environment',
      name: 'Sh. Sanjay Kumar',
      service: 'Indian Forest Service, 1984 · Jharkhand Cadre (Retd.) · Founding Trustee',
      bio: 'Former <strong>Director General of Forests &amp; Special Secretary</strong>, Ministry of Environment, Forest &amp; Climate Change, Government of India — the highest forestry position in the country. Currently serves as <strong>Chief Policy Advisor to the Climate Parliament</strong>, a United Nations–affiliated international network of legislators working on climate and energy transition. As Vice Chairman of BGC, Sh. Kumar leads the Council\'s Climate &amp; Environmental Governance programme and advises on sustainability-focused policy research.',
      tags: ['Climate Governance', 'Forest & Biodiversity Policy', 'Green Federalism', 'UN Climate Parliament', 'Vice Chairman'],
    },
    {
      initials: 'AG',
      svcBadge: 'Trustee',
      position: 'Trustee & Director — Outreach, Fellowships & Philanthropy',
      name: 'Sh. Anmol Goel',
      service: 'Social Psychologist · Educationist · Philanthropist · Founding Trustee',
      bio: 'Educationist, Social Psychologist, and Philanthropist, Sh. Anmol Goel is the key architect of <strong>BGC\'s mentorship and outreach model</strong> for younger civil servants. He brings deep expertise in human capital development and behavioural science as applied to governance institutions. As Director of Outreach, he oversees the design and execution of the annual onboarding programme for 100+ young officers, fundraising and philanthropic partnerships, and BGC\'s fellowship and internship pipeline.',
      tags: ['Mentorship Design', 'Fellow & Intern Programme', 'Philanthropic Partnerships', 'Human Capital', 'Outreach Strategy'],
    },
  ],
}

const savedExec = props.sections?.executive_officers || {}
const executiveOfficers = reactive({
  ...execDefaults,
  ...savedExec,
  officers: savedExec.officers?.length
    ? savedExec.officers.map(officer => ({ ...officer, tags: officer.tags ?? [] }))
    : execDefaults.officers.map(officer => ({ ...officer })),
})

const boardDefaults = {
  section_label: 'Board Members',
  headline_before: 'The',
  headline_emphasis: 'Full Board',
  subtext: "Each board member holds a specific portfolio aligned with their career expertise — bringing focused, credible leadership to every domain of BGC's work.",
  members: [
    {
      initials: 'SO',
      position: 'Director, Civil Services Mentorship & Training',
      name: 'Sh. Sunil Oberoi',
      service: 'IAS · 1984 Batch (Retd.)',
      bio: 'Worked on <strong>Civil Services Reforms with UNDP and DoPT</strong>. Government nominee on UPSC interview boards; induction and in-service trainer at LBSNAA, Mussoorie. Academic Head, 99Notes. As Director of Mentorship &amp; Training, he leads the design of BGC\'s structured learning curriculum for younger IAS and allied service officers.',
      area: 'Civil Service Reform & Ethics',
    },
    {
      initials: 'SG',
      position: 'Director, Security Governance & Policing Reform',
      name: 'Sh. Somesh Goel',
      service: 'IPS · 1984 Batch (Retd.)',
      bio: '<strong>Deputy Inspector General of Police, Himachal Pradesh (Retd.)</strong> Extensive experience in law enforcement, intelligence, and internal security in hill-state conditions. As Director of Security Governance, he leads BGC\'s work on policing reform, disaster response frameworks, and the security dimensions of democratic governance.',
      area: 'Security Governance & Law Enforcement',
    },
    {
      initials: 'MB',
      position: 'Director, International Engagement & Diplomacy',
      name: 'Sh. Manoj Kumar Bharti',
      service: 'IFS · 1988 Batch (Retd.)',
      bio: 'Former <strong>Ambassador of India to Indonesia, UAE</strong>, and <strong>Myanmar</strong>; previously Special Secretary, Ministry of External Affairs. As Director of International Engagement, he leads BGC\'s outreach to international governance networks, facilitates comparative governance learning from the Global South, and heads diplomatic knowledge-sharing programmes.',
      area: 'International Affairs & Diplomacy',
    },
    {
      initials: 'NJ',
      position: 'Director, Land Administration & State Governance',
      name: 'Sh. Nikhilesh Jha',
      service: 'IAS · 1984 Batch (Retd.)',
      bio: '<strong>Director General, Himachal Pradesh; Former Director, LAWDA</strong> (Land Acquisition, Welfare &amp; Development Authority). Deep expertise in land administration and rights, public welfare infrastructure, and hill-state governance. Leads BGC\'s research programme on land governance, federalism in hill states, and subnational administrative capacity.',
      area: 'Land Governance & Federalism',
    },
    {
      initials: 'SS',
      position: 'Director, Strategic Operations & Institutional Management',
      name: 'Sh. Sandeep Silas',
      service: 'IRTS · 1984 Batch (Retd.)',
      bio: '<strong>Indian Railway Traffic Service, 1984 Batch (Retd.)</strong> Strategist and Management Expert with decades of experience in large-scale public logistics and institutional reform. As Director of Strategic Operations, he oversees BGC\'s internal governance, programme management, and the operational efficiency of the Council\'s activities.',
      area: 'Operations & Institutional Management',
    },
    {
      initials: 'AC',
      position: 'Director, Public Finance & Revenue Policy',
      name: 'Sh. A.K. Chauhan',
      service: 'IRS · 1984 Batch (Retd.)',
      bio: '<strong>Principal Chief Commissioner of Income Tax, Madhya Pradesh (Retd.)</strong> Indian Revenue Service, 1984 Batch. A senior tax administrator with expertise in fiscal administration, revenue reform, and compliance architecture. Leads BGC\'s work on public finance governance, tax administration reform, and fiscal capacity of subnational governments.',
      area: 'Public Finance & Revenue Administration',
    },
    {
      initials: 'RD',
      position: 'Director, South Asia Affairs & Neighbourhood Policy',
      name: 'Smt. Riva Das',
      service: 'IFS · 1986 Batch (Retd.)',
      bio: 'Former <strong>High Commissioner of India to Bangladesh</strong>, Indian Foreign Service, 1986 Batch. Seasoned diplomat with deep specialisation in South Asian bilateral relations, sub-regional connectivity, and cultural diplomacy. Leads BGC\'s Neighbourhood Policy track, examining how India\'s foreign policy intersects with subnational governance and border-area administration.',
      area: 'South Asia & Neighbourhood Policy',
    },
    {
      initials: 'AS',
      position: 'Director, Rural Development & Cooperative Governance',
      name: 'Sh. Arvind Singh',
      service: 'IAS · 1988 Batch (Retd.)',
      bio: 'Managing Director, <strong>Provincial Co-operative Federation, Lucknow</strong>. IAS, 1988 Batch. Specialist in cooperative governance, agricultural finance, and rural institutional reform in Uttar Pradesh. Leads BGC\'s research on rural governance, cooperative law reform, and the institutional architecture of India\'s agriculture economy.',
      area: 'Rural Development & Cooperative Law',
    },
    {
      initials: 'SSi',
      position: 'Senior Advisor & Director, Civil Services Ethics & Selection',
      name: 'Sh. Sanjay Sinha',
      service: 'IPS · 1978 Batch (Retd.)',
      bio: 'Former <strong>Member, Union Public Service Commission (UPSC) Panel</strong>. IPS, 1978 Batch — BGC\'s most senior member by seniority of service. Brings unmatched authority on civil services selection standards, police reform, and constitutional governance. Leads BGC\'s work on civil services ethics, conduct standards, and the reform of selection processes.',
      area: 'Civil Services Ethics & UPSC Policy',
    },
  ],
}

const savedBoard = props.sections?.board_members || {}
const boardMembers = reactive({
  ...boardDefaults,
  ...savedBoard,
  members: savedBoard.members?.length
    ? savedBoard.members.map(member => ({ ...member }))
    : boardDefaults.members.map(member => ({ ...member })),
})

const joinDefaults = {
  section_label: 'Work With Us',
  watermark: 'JOIN',
  headline_before: 'Join the',
  headline_emphasis: "Council's Work",
  subtext: "BGC is built on the conviction that India's next generation of governance thinkers must be found, nurtured, and put to work. Whether you are a student, a researcher, a practitioner, or a policy voice — there is a place for you here.",
  cards: [
    {
      type: 'Engage as an',
      title: 'Intern',
      href: '/work-with-us',
      desc: 'Undergraduate and postgraduate students with an interest in public policy, governance, law, or administrative studies. Internships are 8–12 weeks, project-based, and mentored by a BGC board member or senior fellow. Openings across research, communications, and programme support.',
      cta: 'Apply Now',
    },
    {
      type: 'Engage as a',
      title: 'Fellow',
      href: '/work-with-us',
      desc: 'One-year residential or non-residential fellowships for mid-career professionals — academics, serving or retired officers, lawyers, or policy practitioners — to pursue a focused governance research project under BGC\'s mentorship. Fellowship holders join the BGC network permanently.',
      cta: 'Learn More',
    },
    {
      type: 'Join as a',
      title: 'Researcher',
      href: '/work-with-us',
      desc: 'Full-time or part-time research positions for doctoral scholars and policy researchers. BGC researchers work on long-horizon projects across our programme areas — state capacity, fiscal federalism, climate governance, civil service reform — with direct access to the Council\'s senior members as interlocutors.',
      cta: 'View Openings',
    },
    {
      type: 'Write as a',
      title: 'Contributor',
      href: '/work-with-us',
      desc: 'Practitioners, scholars, and informed citizens who wish to contribute essays, analysis, op-eds, or policy commentaries to BGC\'s publications. We welcome voices from across India\'s governance ecosystem — especially those with first-hand administrative or legal experience to share.',
      cta: 'Submit a Piece',
    },
  ],
}

const savedJoin = props.sections?.join_cta || {}
const joinCta = reactive({
  ...joinDefaults,
  ...savedJoin,
  cards: savedJoin.cards?.length
    ? savedJoin.cards.map(card => ({ ...card }))
    : joinDefaults.cards.map(card => ({ ...card })),
})

function saveHero() {
  heroSaving.value = true
  router.put('/admin/governing-board/hero', {
    data: {
      eyebrow_text: hero.eyebrow_text,
      headline_line1: hero.headline_line1,
      headline_line2: hero.headline_line2,
      subtext: hero.subtext,
      stats: hero.stats,
    },
  }, {
    preserveScroll: true,
    onFinish: () => { heroSaving.value = false },
  })
}

function resetHero() {
  Object.assign(hero, {
    ...heroDefaults,
    stats: heroDefaults.stats.map(stat => ({ ...stat })),
  })
}

const chairmanUploading = ref(false)
const chairmanRemoving  = ref(false)
const officerUploading  = reactive({})
const officerRemoving   = reactive({})
const memberUploading   = reactive({})
const memberRemoving    = reactive({})

function uploadChairmanImage(e) {
  const file = e.target.files?.[0]
  if (!file) return
  chairmanUploading.value = true
  const formData = new FormData()
  formData.append('image', file)
  router.post('/admin/governing-board/chairman/upload-image', formData, {
    forceFormData:  true,
    preserveScroll: true,
    onSuccess: () => {
      const updated = props.sections?.chairman
      if (updated) {
        chairman.image       = updated.image       || null
        chairman.stored_path = updated.stored_path || null
      }
    },
    onFinish: () => { chairmanUploading.value = false },
  })
}

function removeChairmanImage() {
  chairmanRemoving.value = true
  router.post('/admin/governing-board/chairman/remove-image', {}, {
    preserveScroll: true,
    onSuccess: () => {
      chairman.image       = null
      chairman.stored_path = null
    },
    onFinish: () => { chairmanRemoving.value = false },
  })
}

function uploadOfficerImage(index, e) {
  const file = e.target.files?.[0]
  if (!file) return
  officerUploading[index] = true
  const formData = new FormData()
  formData.append('image', file)
  formData.append('index', index)
  router.post('/admin/governing-board/officers/upload-image', formData, {
    forceFormData:  true,
    preserveScroll: true,
    onSuccess: () => {
      const updated = props.sections?.executive_officers?.officers?.[index]
      if (updated) {
        executiveOfficers.officers[index].image       = updated.image       || null
        executiveOfficers.officers[index].stored_path = updated.stored_path || null
      }
    },
    onFinish: () => { officerUploading[index] = false },
  })
}

function removeOfficerImage(index) {
  officerRemoving[index] = true
  router.post('/admin/governing-board/officers/remove-image', { index }, {
    preserveScroll: true,
    onSuccess: () => {
      executiveOfficers.officers[index].image       = null
      executiveOfficers.officers[index].stored_path = null
    },
    onFinish: () => { officerRemoving[index] = false },
  })
}

function uploadMemberImage(index, e) {
  const file = e.target.files?.[0]
  if (!file) return
  memberUploading[index] = true
  const formData = new FormData()
  formData.append('image', file)
  formData.append('index', index)
  router.post('/admin/governing-board/members/upload-image', formData, {
    forceFormData:  true,
    preserveScroll: true,
    onSuccess: () => {
      const updated = props.sections?.board_members?.members?.[index]
      if (updated) {
        boardMembers.members[index].image       = updated.image       || null
        boardMembers.members[index].stored_path = updated.stored_path || null
      }
    },
    onFinish: () => { memberUploading[index] = false },
  })
}

function removeMemberImage(index) {
  memberRemoving[index] = true
  router.post('/admin/governing-board/members/remove-image', { index }, {
    preserveScroll: true,
    onSuccess: () => {
      boardMembers.members[index].image       = null
      boardMembers.members[index].stored_path = null
    },
    onFinish: () => { memberRemoving[index] = false },
  })
}

function saveChairman() {
  chairmanSaving.value = true
  router.put('/admin/governing-board/chairman', {
    data: {
      section_label: chairman.section_label,
      badge_text:    chairman.badge_text,
      initials:      chairman.initials,
      avatar_service:chairman.avatar_service,
      image:         chairman.image        || null,
      stored_path:   chairman.stored_path  || null,
      position:      chairman.position,
      name:          chairman.name,
      service:       chairman.service,
      bios:          chairman.bios,
      responsibilities: chairman.responsibilities,
      tags:          chairman.tags,
    },
  }, {
    preserveScroll: true,
    onFinish: () => { chairmanSaving.value = false },
  })
}

function resetChairman() {
  Object.assign(chairman, {
    ...chairmanDefaults,
    bios: chairmanDefaults.bios.map(bio => bio),
    responsibilities: chairmanDefaults.responsibilities.map(item => item),
    tags: chairmanDefaults.tags.map(tag => tag),
  })
}

function addChairmanBio() {
  chairman.bios.push('')
}

function addChairmanResponsibility() {
  chairman.responsibilities.push('')
}

function removeChairmanResponsibility(index) {
  chairman.responsibilities.splice(index, 1)
}

function addChairmanTag() {
  chairman.tags.push('')
}

function removeChairmanTag(index) {
  chairman.tags.splice(index, 1)
}

function saveExecutiveOfficers() {
  execSaving.value = true
  router.put('/admin/governing-board/executive_officers', {
    data: {
      section_label: executiveOfficers.section_label,
      headline_before: executiveOfficers.headline_before,
      headline_emphasis: executiveOfficers.headline_emphasis,
      subtext: executiveOfficers.subtext,
      officers: executiveOfficers.officers.map(o => ({
        ...o,
        image:       o.image       || null,
        stored_path: o.stored_path || null,
      })),
    },
  }, {
    preserveScroll: true,
    onFinish: () => { execSaving.value = false },
  })
}

function resetExecutiveOfficers() {
  Object.assign(executiveOfficers, {
    ...execDefaults,
    officers: execDefaults.officers.map(officer => ({ ...officer, tags: [...officer.tags] })),
  })
}

function addExecutiveOfficer() {
  executiveOfficers.officers.push({
    initials: '',
    svcBadge: '',
    position: '',
    name: '',
    service: '',
    bio: '',
    tags: [],
    image: null,
    stored_path: null,
  })
}

function removeExecutiveOfficer(index) {
  executiveOfficers.officers.splice(index, 1)
}

function addOfficerTag(index) {
  executiveOfficers.officers[index].tags.push('')
}

function removeOfficerTag(officerIndex, tagIndex) {
  executiveOfficers.officers[officerIndex].tags.splice(tagIndex, 1)
}

function saveBoardMembers() {
  boardSaving.value = true
  router.put('/admin/governing-board/board_members', {
    data: {
      section_label: boardMembers.section_label,
      headline_before: boardMembers.headline_before,
      headline_emphasis: boardMembers.headline_emphasis,
      subtext: boardMembers.subtext,
      members: boardMembers.members.map(m => ({
        ...m,
        image:       m.image       || null,
        stored_path: m.stored_path || null,
      })),
    },
  }, {
    preserveScroll: true,
    onFinish: () => { boardSaving.value = false },
  })
}

function resetBoardMembers() {
  Object.assign(boardMembers, {
    ...boardDefaults,
    members: boardDefaults.members.map(member => ({ ...member })),
  })
}

function addBoardMember() {
  boardMembers.members.push({
    initials: '',
    position: '',
    name: '',
    service: '',
    bio: '',
    area: '',
    image: null,
    stored_path: null,
  })
}

function removeBoardMember(index) {
  boardMembers.members.splice(index, 1)
}

function saveJoinCta() {
  joinSaving.value = true
  router.put('/admin/governing-board/join_cta', {
    data: {
      section_label: joinCta.section_label,
      watermark: joinCta.watermark,
      headline_before: joinCta.headline_before,
      headline_emphasis: joinCta.headline_emphasis,
      subtext: joinCta.subtext,
      cards: joinCta.cards,
    },
  }, {
    preserveScroll: true,
    onFinish: () => { joinSaving.value = false },
  })
}

function resetJoinCta() {
  Object.assign(joinCta, {
    ...joinDefaults,
    cards: joinDefaults.cards.map(card => ({ ...card })),
  })
}

function addJoinCard() {
  joinCta.cards.push({
    type: '',
    title: '',
    href: '',
    desc: '',
    cta: '',
  })
}

function removeJoinCard(index) {
  joinCta.cards.splice(index, 1)
}

function logout() {
  if (confirm('Are you sure you want to logout?')) {
    router.post('/admin/logout')
  }
}

const seoDefaults = {
  meta_title:       'Governing Board | Bharat Governance Council',
  meta_description: 'Meet the Governing Board of the Bharat Governance Council, including our Chairman, Executive Officers, and distinguished Board Members leading India\'s governance reform agenda.',
  meta_keywords:    'governing board, BGC, Bharat Governance Council, chairman, board members, governance',
}
const savedSeo  = props.sections?.seo ?? {}
const seo       = reactive({ ...seoDefaults, ...savedSeo })
const seoOpen   = ref(false)
const seoSaving = ref(false)
function saveSeo() {
  seoSaving.value = true
  router.put('/admin/governing-board/seo', { data: { ...seo } }, {
    preserveScroll: true,
    onFinish: () => (seoSaving.value = false),
  })
}
function resetSeo() { Object.assign(seo, { ...seoDefaults }) }

onMounted(() => { setTimeout(() => { mounted.value = true }, 50) })
</script>

<style scoped>
.admin-root{min-height:100vh;background:#f4f6fb;display:flex;}
.admin-sidebar{width:250px;background:#0b1c38;color:#fff;display:flex;flex-direction:column;position:relative;transition:width .3s;}
.admin-sidebar.collapsed{width:78px;}
.sidebar-logo{display:flex;align-items:center;gap:12px;padding:22px 20px;border-bottom:1px solid rgba(255,255,255,.08);}
.sidebar-logo-img{width:34px;height:34px;object-fit:contain;}
.sidebar-logo-label{font-family:'Cormorant Garamond',serif;font-size:18px;font-weight:600;letter-spacing:.04em;}
.sidebar-nav{flex:1;padding:18px 12px;display:flex;flex-direction:column;gap:6px;}
.nav-group-label{font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,255,255,.35);padding:0 12px 4px;}
.nav-item{display:flex;align-items:center;gap:12px;padding:10px 12px;border-radius:10px;color:rgba(255,255,255,.75);text-decoration:none;transition:background .2s,color .2s;}
.nav-item:hover{background:rgba(255,255,255,.08);color:#fff;}
.nav-item.active{background:rgba(201,168,76,.15);color:#fff;}
.nav-icon{display:inline-flex;width:18px;height:18px;}
.nav-label{font-size:13px;font-weight:500;}
.sidebar-toggle{background:none;border:none;color:rgba(255,255,255,.6);padding:14px 0;border-top:1px solid rgba(255,255,255,.08);cursor:pointer;}
.sidebar-toggle svg{transition:transform .2s;}
.sidebar-toggle svg.flipped{transform:rotate(180deg);}
.sidebar-footer{padding:16px;border-top:1px solid rgba(255,255,255,.08);}
.btn-logout{background:none;border:none;color:rgba(255,255,255,.7);display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;}
.btn-logout:hover{color:#fff;}

.admin-main{flex:1;padding:24px 28px;}
.admin-topbar{display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;}
.topbar-title{font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:600;color:#0b1c38;}
.topbar-breadcrumb{font-size:12px;color:#8a9bbf;margin-top:4px;display:flex;gap:6px;align-items:center;}
.bc-sep{color:#c9a84c;}
.bc-active{color:#0b1c38;font-weight:500;}
.topbar-right{display:flex;align-items:center;gap:18px;}
.topbar-live{display:flex;align-items:center;gap:6px;font-size:12px;color:#8a9bbf;}
.live-dot{width:8px;height:8px;border-radius:50%;background:#30c48d;box-shadow:0 0 6px rgba(48,196,141,.6);}
.topbar-admin{display:flex;align-items:center;gap:12px;}
.admin-avatar{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#c9a84c,#e8cf8a);display:flex;align-items:center;justify-content:center;font-family:'Cormorant Garamond',serif;font-size:16px;font-weight:700;color:#0b1c38;flex-shrink:0;}
.admin-info{display:flex;flex-direction:column;}
.admin-name{font-size:13px;color:#0b1c38;font-weight:600;}
.admin-email{font-size:11px;color:#8a9bbf;}

.content-wrap{opacity:0;transform:translateY(8px);transition:opacity .4s ease,transform .4s ease;}
.content-wrap.visible{opacity:1;transform:translateY(0);}
.page-header{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:20px;}
.page-title{font-family:'Cormorant Garamond',serif;font-size:28px;font-weight:600;color:#0b1c38;}
.page-sub{font-size:13px;color:#8a9bbf;max-width:520px;margin-top:4px;}

.flash{padding:10px 14px;border-radius:8px;margin-bottom:14px;font-size:13px;}
.flash-success{background:rgba(48,196,141,.12);color:#167a52;}
.flash-error{background:rgba(220,38,38,.12);color:#b91c1c;}

.section-panel{background:#fff;border:1px solid rgba(11,28,56,.07);box-shadow:0 2px 12px rgba(11,28,56,.04);margin-bottom:12px;overflow:hidden;}
.section-panel-header{display:flex;align-items:center;justify-content:space-between;padding:18px 24px;cursor:pointer;transition:background .2s;user-select:none;}
.section-panel-header:hover{background:rgba(11,28,56,.015);}
.section-panel-left{display:flex;align-items:center;gap:16px;}
.section-num{font-family:'DM Mono',monospace;font-size:11px;color:#c9a84c;letter-spacing:.1em;}
.section-panel-title{font-family:'Cormorant Garamond',serif;font-size:18px;font-weight:600;color:#0b1c38;line-height:1.2;}
.section-panel-desc{font-size:12px;color:#8a9bbf;margin-top:2px;}
.section-chevron{transition:transform .2s;color:#0b1c38;}
.section-chevron.open{transform:rotate(180deg);}
.section-panel-body{padding:0 24px 24px;}

.form-group-label{margin-top:18px;margin-bottom:10px;font-size:11px;text-transform:uppercase;letter-spacing:.14em;color:#8a9bbf;font-weight:600;}
.form-row{display:flex;gap:14px;flex-wrap:wrap;}
.form-group{flex:1;min-width:220px;display:flex;flex-direction:column;gap:6px;margin-bottom:12px;}
.form-input{padding:10px 12px;border:1px solid rgba(11,28,56,.12);border-radius:8px;font-size:13px;font-family:'DM Sans',sans-serif;color:#0b1c38;background:#fff;}
.form-textarea{resize:vertical;min-height:80px;}
.form-input:focus{outline:none;border-color:#c9a84c;box-shadow:0 0 0 2px rgba(201,168,76,.15);}

.stat-row{display:grid;grid-template-columns:24px repeat(2,1fr);gap:12px;align-items:end;margin-bottom:12px;}
.stat-row-num{font-family:'DM Mono',monospace;font-size:11px;color:#c9a84c;}

.form-actions{display:flex;gap:12px;margin-top:8px;flex-wrap:wrap;}
.btn-reset,.btn-save,.btn-add,.btn-remove{padding:10px 16px;border-radius:8px;border:1px solid transparent;font-size:13px;font-weight:600;cursor:pointer;}
.btn-reset{background:#eef1f6;color:#0b1c38;border-color:rgba(11,28,56,.1);}
.btn-save{background:linear-gradient(135deg,#c9a84c,#e8cf8a);color:#0b1c38;}
.btn-save:disabled{opacity:.6;cursor:not-allowed;}
.btn-add{background:#0b1c38;color:#fff;border-color:#0b1c38;margin-bottom:12px;}
.btn-remove{background:#fff;border-color:rgba(11,28,56,.2);color:#8a9bbf;padding:8px 12px;}
.btn-remove:hover{border-color:#c9a84c;color:#c9a84c;}

.panel-slide-enter-active,.panel-slide-leave-active{transition:all .2s ease;}
.panel-slide-enter-from,.panel-slide-leave-to{opacity:0;transform:translateY(-6px);}

@media (max-width: 900px){
  .admin-root{flex-direction:column;}
  .admin-sidebar{width:100%;height:auto;flex-direction:row;flex-wrap:wrap;}
  .sidebar-nav{flex-direction:row;flex-wrap:wrap;}
  .admin-main{padding:20px;}
}

/* ── Chairman photo upload ───────────────────── */
.ch-photo-row{display:flex;gap:20px;padding:16px;background:rgba(201,168,76,0.03);border:1px solid rgba(201,168,76,0.1);border-radius:8px;margin-bottom:4px;align-items:flex-start;}
.ch-photo-preview{width:80px;height:100px;flex-shrink:0;overflow:hidden;background:linear-gradient(135deg,#162d55,#0b1c38);border:1px solid rgba(201,168,76,0.2);border-radius:4px;display:flex;align-items:center;justify-content:center;}
.ch-photo-img{width:100%;height:100%;object-fit:cover;}
.ch-photo-placeholder{display:flex;align-items:center;justify-content:center;width:100%;height:100%;}
.ch-photo-placeholder span{font-family:'Cormorant Garamond',serif;font-size:28px;font-weight:600;color:#c9a84c;}
.ch-photo-right{flex:1;display:flex;flex-direction:column;gap:6px;}
.ch-photo-label{font-size:12px;font-weight:600;color:#e8eaf0;}
.ch-photo-hint{font-size:11px;color:rgba(138,155,191,0.4);line-height:1.5;}
.ch-photo-btns{display:flex;gap:8px;flex-wrap:wrap;margin-top:4px;}
.btn-upload-voice{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;background:rgba(201,168,76,0.07);border:1px solid rgba(201,168,76,0.25);border-radius:6px;color:rgba(201,168,76,0.8);font-size:12px;font-weight:500;cursor:pointer;transition:background 0.15s,color 0.15s;font-family:'DM Sans',sans-serif;}
.btn-upload-voice:hover{background:rgba(201,168,76,0.13);color:#c9a84c;}
.btn-upload-voice.btn-uploading{opacity:0.6;cursor:not-allowed;}
.btn-remove-voice-img{display:inline-flex;align-items:center;gap:5px;padding:7px 12px;background:rgba(231,76,60,0.07);border:1px solid rgba(231,76,60,0.18);border-radius:6px;color:rgba(231,76,60,0.65);font-size:12px;cursor:pointer;transition:background 0.15s,color 0.15s;font-family:'DM Sans',sans-serif;}
.btn-remove-voice-img:hover{background:rgba(231,76,60,0.14);color:#e74c3c;}
.btn-remove-voice-img:disabled{opacity:0.5;cursor:not-allowed;}
</style>
