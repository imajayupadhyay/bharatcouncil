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
            :class="{ active: item.id === 'who-we-are' }"
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
          <h2 class="topbar-title">Who We Are Manager</h2>
          <div class="topbar-breadcrumb">
            <span>Admin</span><span class="bc-sep">›</span>
            <span class="bc-active">Who We Are</span>
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
            <h1 class="page-title">Who We Are Sections</h1>
            <p class="page-sub">Manage the content displayed on the Who We Are page. Edit each section below.</p>
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
                <p class="section-panel-desc">Main headline and quote card</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: heroOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>

          <Transition name="panel-slide">
            <div v-if="heroOpen" class="section-panel-body">
              <form @submit.prevent="saveHero">

                <div class="form-group-label">Eyebrow & Headline</div>
                <div class="form-group">
                  <label>Eyebrow Text</label>
                  <input v-model="hero.eyebrow_text" type="text" class="form-input" placeholder="Who We Are" />
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Headline Line 1</label>
                    <input v-model="hero.headline_line1" type="text" class="form-input" placeholder="Bridging Decades of" />
                  </div>
                  <div class="form-group">
                    <label>Headline Line 2 (gold italic)</label>
                    <input v-model="hero.headline_line2" type="text" class="form-input" placeholder="Public Service" />
                  </div>
                </div>

                <div class="form-group">
                  <label>Subtext</label>
                  <textarea v-model="hero.subtext" class="form-input form-textarea" rows="3" placeholder="The Bharat Governance Council..."></textarea>
                </div>

                <div class="form-group-label">Quote Card</div>
                <div class="form-group">
                  <label>Quote Text</label>
                  <textarea v-model="hero.quote_text" class="form-input form-textarea" rows="2" placeholder="Quote text"></textarea>
                </div>
                <div class="form-group">
                  <label>Quote Author</label>
                  <input v-model="hero.quote_author" type="text" class="form-input" placeholder="Dr. Kush Verma" />
                </div>
                <div class="form-group">
                  <label>Quote Role</label>
                  <input v-model="hero.quote_role" type="text" class="form-input" placeholder="Founder & Chairman, BGC" />
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

        <!-- ══════════ STORY SECTION ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="storyOpen = !storyOpen">
            <div class="section-panel-left">
              <span class="section-num">02</span>
              <div>
                <h3 class="section-panel-title">Story Section</h3>
                <p class="section-panel-desc">Our story, pullquote, and onboarding stats</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: storyOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>

          <Transition name="panel-slide">
            <div v-if="storyOpen" class="section-panel-body">
              <form @submit.prevent="saveStory">

                <div class="form-group-label">Headline</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Headline Line 1</label>
                    <input v-model="story.headline_line1" type="text" class="form-input" placeholder="Born from a" />
                  </div>
                  <div class="form-group">
                    <label>Headline Line 2 (gold italic)</label>
                    <input v-model="story.headline_line2" type="text" class="form-input" placeholder="Shared Conviction" />
                  </div>
                </div>

                <div class="form-group-label">Prose Content</div>
                <div class="form-group">
                  <label>Paragraph 1</label>
                  <textarea v-model="story.paragraph1" class="form-input form-textarea" rows="3"></textarea>
                </div>
                <div class="form-group">
                  <label>Paragraph 2</label>
                  <textarea v-model="story.paragraph2" class="form-input form-textarea" rows="3"></textarea>
                </div>
                <div class="form-group">
                  <label>Paragraph 3</label>
                  <textarea v-model="story.paragraph3" class="form-input form-textarea" rows="3"></textarea>
                </div>

                <div class="form-group-label">Pullquote</div>
                <div class="form-group">
                  <label>Quote Text</label>
                  <textarea v-model="story.pullquote_text" class="form-input form-textarea" rows="2"></textarea>
                </div>
                <div class="form-group">
                  <label>Quote Citation</label>
                  <input v-model="story.pullquote_cite" type="text" class="form-input" placeholder="— BGC Founding Charter, 2023" />
                </div>

                <div class="form-group-label">Onboard Box</div>
                <div class="form-group">
                  <label>Number</label>
                  <input v-model="story.onboard_number" type="text" class="form-input" placeholder="100" />
                </div>
                <div class="form-group">
                  <label>Title</label>
                  <input v-model="story.onboard_title" type="text" class="form-input" placeholder="Younger Bureaucrats Onboarded Each Year" />
                </div>
                <div class="form-group">
                  <label>Description</label>
                  <textarea v-model="story.onboard_desc" class="form-input form-textarea" rows="2"></textarea>
                </div>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetStory">Reset to Default</button>
                  <button type="submit" class="btn-save" :disabled="storySaving">
                    {{ storySaving ? 'Saving...' : 'Save Story Section' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

        <!-- ══════════ FOUNDING TEAM SECTION ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="teamOpen = !teamOpen">
            <div class="section-panel-left">
              <span class="section-num">03</span>
              <div>
                <h3 class="section-panel-title">Founding Team Section</h3>
                <p class="section-panel-desc">Team header and members (managed in component)</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: teamOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>

          <Transition name="panel-slide">
            <div v-if="teamOpen" class="section-panel-body">
              <form @submit.prevent="saveTeam">

                <div class="form-group-label">Section Header</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Headline Line 1</label>
                    <input v-model="team.headline_line1" type="text" class="form-input" placeholder="The" />
                  </div>
                  <div class="form-group">
                    <label>Headline Line 2 (gold italic)</label>
                    <input v-model="team.headline_line2" type="text" class="form-input" placeholder="Architects" />
                  </div>
                  <div class="form-group">
                    <label>Headline Line 3</label>
                    <input v-model="team.headline_line3" type="text" class="form-input" placeholder="of BGC" />
                  </div>
                </div>

                <div class="form-group">
                  <label>Section Subtext</label>
                  <textarea v-model="team.subtext" class="form-input form-textarea" rows="2"></textarea>
                </div>

                <!-- Chairman Section -->
                <div class="form-group-label">Chairman Details</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Initials</label>
                    <input v-model="team.chairman.initials" type="text" class="form-input" placeholder="KV" />
                  </div>
                  <div class="form-group">
                    <label>Name</label>
                    <input v-model="team.chairman.name" type="text" class="form-input" placeholder="Dr. Kush Verma" />
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Service</label>
                    <input v-model="team.chairman.service" type="text" class="form-input" placeholder="IAS · 1979 · UP Cadre" />
                  </div>
                  <div class="form-group">
                    <label>Batch</label>
                    <input v-model="team.chairman.batch" type="text" class="form-input" placeholder="IAS 1979 · Uttar Pradesh Cadre" />
                  </div>
                </div>
                <div class="form-group">
                  <label>Biography Paragraph 1</label>
                  <textarea v-model="team.chairman.bio1" class="form-input form-textarea" rows="3"></textarea>
                </div>
                <div class="form-group">
                  <label>Biography Paragraph 2</label>
                  <textarea v-model="team.chairman.bio2" class="form-input form-textarea" rows="2"></textarea>
                </div>
                
                <div class="form-group">
                  <label>Tags</label>
                  <div v-for="(tag, idx) in team.chairman.tags" :key="idx" class="array-item">
                    <input v-model="team.chairman.tags[idx]" type="text" class="form-input" placeholder="Tag" />
                    <button type="button" @click="removeChairmanTag(idx)" class="btn-remove">×</button>
                  </div>
                  <button type="button" @click="addChairmanTag" class="btn-add">+ Add Tag</button>
                </div>

                <div class="form-group-label">Chairman Photo</div>
                <div class="ch-photo-row">
                  <div class="ch-photo-preview">
                    <img v-if="team.chairman.image" :src="team.chairman.image" class="ch-photo-img" alt="Chairman" />
                    <div v-else class="ch-photo-placeholder">
                      <span>{{ team.chairman.initials || 'KV' }}</span>
                    </div>
                  </div>
                  <div class="ch-photo-right">
                    <p class="ch-photo-label">Chairman Photo</p>
                    <p class="ch-photo-hint">Portrait orientation recommended (3:4). PNG/JPG/WebP, max 4 MB.</p>
                    <div class="ch-photo-btns">
                      <label class="btn-upload-voice" :class="{ 'btn-uploading': chairmanPhotoUploading }">
                        <input
                          type="file"
                          accept="image/png,image/jpeg,image/jpg,image/webp"
                          style="display:none"
                          :disabled="chairmanPhotoUploading"
                          @change="uploadChairmanPhoto"
                        />
                        <svg viewBox="0 0 16 16" fill="none" width="12" height="12">
                          <path d="M8 3v8M4 7l4-4 4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M2 13h12" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                        </svg>
                        {{ chairmanPhotoUploading ? 'Uploading…' : (team.chairman.image ? 'Change Photo' : 'Upload Photo') }}
                      </label>
                      <button
                        v-if="team.chairman.image"
                        type="button"
                        class="btn-remove-voice-img"
                        :disabled="chairmanPhotoRemoving"
                        @click="removeChairmanPhoto"
                      >
                        <svg viewBox="0 0 16 16" fill="none" width="11" height="11">
                          <path d="M3 3l10 10M13 3L3 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        {{ chairmanPhotoRemoving ? 'Removing…' : 'Remove Photo' }}
                      </button>
                    </div>
                  </div>
                </div>

                <!-- Members Section -->
                <div class="form-group-label">Team Members</div>
                <div v-for="(member, idx) in team.members" :key="idx" class="member-card">
                  <div class="member-card-header">
                    <span>Member {{ idx + 1 }}</span>
                    <button type="button" @click="removeMember(idx)" class="btn-remove-card">Remove</button>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Initials</label>
                      <input v-model="member.initials" type="text" class="form-input" placeholder="SO" />
                    </div>
                    <div class="form-group">
                      <label>Name</label>
                      <input v-model="member.name" type="text" class="form-input" placeholder="Sh. Sunil Oberoi" />
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Service</label>
                      <input v-model="member.service" type="text" class="form-input" placeholder="IAS · 1984" />
                    </div>
                    <div class="form-group">
                      <label>Role</label>
                      <input v-model="member.role" type="text" class="form-input" placeholder="Co-Founder" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Description (HTML allowed)</label>
                    <textarea v-model="member.desc" class="form-input form-textarea" rows="2"></textarea>
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
                        <label class="btn-upload-voice" :class="{ 'btn-uploading': memberPhotoUploading[idx] }">
                          <input
                            type="file"
                            accept="image/png,image/jpeg,image/jpg,image/webp"
                            style="display:none"
                            :disabled="memberPhotoUploading[idx]"
                            @change="uploadMemberPhoto(idx, $event)"
                          />
                          <svg viewBox="0 0 16 16" fill="none" width="12" height="12">
                            <path d="M8 3v8M4 7l4-4 4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 13h12" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                          </svg>
                          {{ memberPhotoUploading[idx] ? 'Uploading…' : (member.image ? 'Change Photo' : 'Upload Photo') }}
                        </label>
                        <button
                          v-if="member.image"
                          type="button"
                          class="btn-remove-voice-img"
                          :disabled="memberPhotoRemoving[idx]"
                          @click="removeMemberPhoto(idx)"
                        >
                          <svg viewBox="0 0 16 16" fill="none" width="11" height="11">
                            <path d="M3 3l10 10M13 3L3 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                          </svg>
                          {{ memberPhotoRemoving[idx] ? 'Removing…' : 'Remove Photo' }}
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <button type="button" @click="addMember" class="btn-add-card">+ Add Member</button>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetTeam">Reset to Default</button>
                  <button type="submit" class="btn-save" :disabled="teamSaving">
                    {{ teamSaving ? 'Saving...' : 'Save Team Section' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

        <!-- ══════════ ACADEMICS SECTION ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="academicsOpen = !academicsOpen">
            <div class="section-panel-left">
              <span class="section-num">04</span>
              <div>
                <h3 class="section-panel-title">Academics Section</h3>
                <p class="section-panel-desc">Academic associates header</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: academicsOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>

          <Transition name="panel-slide">
            <div v-if="academicsOpen" class="section-panel-body">
              <form @submit.prevent="saveAcademics">

                <div class="form-group-label">Section Header</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Headline Line 1</label>
                    <input v-model="academics.headline_line1" type="text" class="form-input" placeholder="Scholars Who" />
                  </div>
                  <div class="form-group">
                    <label>Headline Line 2 (gold italic)</label>
                    <input v-model="academics.headline_line2" type="text" class="form-input" placeholder="Ground Our Work" />
                  </div>
                </div>

                <div class="form-group">
                  <label>Section Subtext</label>
                  <textarea v-model="academics.subtext" class="form-input form-textarea" rows="2"></textarea>
                </div>

                <!-- Academics List -->
                <div class="form-group-label">Academic Associates</div>
                <div v-for="(academic, idx) in academics.academics" :key="idx" class="member-card">
                  <div class="member-card-header">
                    <span>Academic {{ idx + 1 }}</span>
                    <button type="button" @click="removeAcademic(idx)" class="btn-remove-card">Remove</button>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Initials</label>
                      <input v-model="academic.initials" type="text" class="form-input" placeholder="PB" />
                    </div>
                    <div class="form-group">
                      <label>Institution</label>
                      <input v-model="academic.institution" type="text" class="form-input" placeholder="JNU" />
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Name</label>
                      <input v-model="academic.name" type="text" class="form-input" placeholder="Prof. Name" />
                    </div>
                    <div class="form-group">
                      <label>Specialisation</label>
                      <input v-model="academic.specialisation" type="text" class="form-input" placeholder="Field of study" />
                    </div>
                  </div>
                </div>
                <button type="button" @click="addAcademic" class="btn-add-card">+ Add Academic</button>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetAcademics">Reset to Default</button>
                  <button type="submit" class="btn-save" :disabled="academicsSaving">
                    {{ academicsSaving ? 'Saving...' : 'Save Academics Section' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

        <!-- ══════════ MANDATE SECTION ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="mandateOpen = !mandateOpen">
            <div class="section-panel-left">
              <span class="section-num">05</span>
              <div>
                <h3 class="section-panel-title">Mandate Section</h3>
                <p class="section-panel-desc">Our mandate items</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: mandateOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>

          <Transition name="panel-slide">
            <div v-if="mandateOpen" class="section-panel-body">
              <form @submit.prevent="saveMandate">

                <div class="form-group-label">Section Header</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Headline Line 1</label>
                    <input v-model="mandate.headline_line1" type="text" class="form-input" placeholder="Our" />
                  </div>
                  <div class="form-group">
                    <label>Headline Line 2 (gold italic)</label>
                    <input v-model="mandate.headline_line2" type="text" class="form-input" placeholder="Mandate" />
                  </div>
                </div>

                <!-- Mandate Items -->
                <div class="form-group-label">Mandate Items</div>
                <div v-for="(item, idx) in mandate.mandates" :key="idx" class="member-card">
                  <div class="member-card-header">
                    <span>Mandate Item {{ idx + 1 }}</span>
                    <button type="button" @click="removeMandate(idx)" class="btn-remove-card">Remove</button>
                  </div>
                  <div class="form-group">
                    <label>Title</label>
                    <input v-model="item.title" type="text" class="form-input" placeholder="Mandate title" />
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <textarea v-model="item.body" class="form-input form-textarea" rows="3" placeholder="Mandate description"></textarea>
                  </div>
                </div>
                <button type="button" @click="addMandate" class="btn-add-card">+ Add Mandate Item</button>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetMandate">Reset to Default</button>
                  <button type="submit" class="btn-save" :disabled="mandateSaving">
                    {{ mandateSaving ? 'Saving...' : 'Save Mandate Section' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

        <!-- ══════════ IMPACT SECTION ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="impactOpen = !impactOpen">
            <div class="section-panel-left">
              <span class="section-num">06</span>
              <div>
                <h3 class="section-panel-title">Impact Section</h3>
                <p class="section-panel-desc">Impact statistics</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: impactOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>

          <Transition name="panel-slide">
            <div v-if="impactOpen" class="section-panel-body">
              <form @submit.prevent="saveImpact">

                <div class="form-group-label">Section Header</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Headline Line 1</label>
                    <input v-model="impact.headline_line1" type="text" class="form-input" placeholder="Measuring" />
                  </div>
                  <div class="form-group">
                    <label>Headline Line 2 (gold italic)</label>
                    <input v-model="impact.headline_line2" type="text" class="form-input" placeholder="What Matters" />
                  </div>
                </div>

                <div class="form-group-label">Impact Stats</div>
                <div v-for="(stat, i) in impact.stats" :key="i" class="stat-row">
                  <span class="stat-row-num">{{ i + 1 }}</span>
                  <div class="form-group">
                    <label>Number</label>
                    <input v-model="stat.num" type="text" class="form-input" />
                  </div>
                  <div class="form-group">
                    <label>Label</label>
                    <input v-model="stat.label" type="text" class="form-input" />
                  </div>
                </div>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetImpact">Reset to Default</button>
                  <button type="submit" class="btn-save" :disabled="impactSaving">
                    {{ impactSaving ? 'Saving...' : 'Save Impact Section' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

        <!-- ══════════ VALUES SECTION ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="valuesOpen = !valuesOpen">
            <div class="section-panel-left">
              <span class="section-num">07</span>
              <div>
                <h3 class="section-panel-title">Values Section</h3>
                <p class="section-panel-desc">Our values and commitments</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: valuesOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>

          <Transition name="panel-slide">
            <div v-if="valuesOpen" class="section-panel-body">
              <form @submit.prevent="saveValues">

                <div class="form-group-label">Section Header</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Headline Line 1</label>
                    <input v-model="values.headline_line1" type="text" class="form-input" placeholder="What BGC" />
                  </div>
                  <div class="form-group">
                    <label>Headline Line 2 (gold italic)</label>
                    <input v-model="values.headline_line2" type="text" class="form-input" placeholder="Stands For" />
                  </div>
                </div>

                <div class="form-group">
                  <label>Section Subtext</label>
                  <textarea v-model="values.subtext" class="form-input form-textarea" rows="2"></textarea>
                </div>

                <!-- Values Items -->
                <div class="form-group-label">Core Values</div>
                <div v-for="(value, idx) in values.values" :key="idx" class="member-card">
                  <div class="member-card-header">
                    <span>Value {{ idx + 1 }}</span>
                    <button type="button" @click="removeValue(idx)" class="btn-remove-card">Remove</button>
                  </div>
                  <div class="form-group">
                    <label>Title</label>
                    <input v-model="value.title" type="text" class="form-input" placeholder="Value title" />
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <textarea v-model="value.desc" class="form-input form-textarea" rows="3" placeholder="Value description"></textarea>
                  </div>
                </div>
                <button type="button" @click="addValue" class="btn-add-card">+ Add Value</button>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetValues">Reset to Default</button>
                  <button type="submit" class="btn-save" :disabled="valuesSaving">
                    {{ valuesSaving ? 'Saving...' : 'Save Values Section' }}
                  </button>
                </div>
              </form>
            </div>
          </Transition>
        </div>

        <!-- ══════════ PARTNERS SECTION ══════════ -->
        <div class="section-panel">
          <div class="section-panel-header" @click="partnersOpen = !partnersOpen">
            <div class="section-panel-left">
              <span class="section-num">08</span>
              <div>
                <h3 class="section-panel-title">Partners Section</h3>
                <p class="section-panel-desc">Collaborators and partners</p>
              </div>
            </div>
            <svg class="section-chevron" :class="{ open: partnersOpen }" viewBox="0 0 16 16" fill="none" width="16" height="16">
              <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>

          <Transition name="panel-slide">
            <div v-if="partnersOpen" class="section-panel-body">
              <form @submit.prevent="savePartners">

                <div class="form-group-label">Section Header</div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Headline Line 1</label>
                    <input v-model="partners.headline_line1" type="text" class="form-input" placeholder="Supported by" />
                  </div>
                  <div class="form-group">
                    <label>Headline Line 2 (gold italic)</label>
                    <input v-model="partners.headline_line2" type="text" class="form-input" placeholder="Purpose-Aligned" />
                  </div>
                  <div class="form-group">
                    <label>Headline Line 3</label>
                    <input v-model="partners.headline_line3" type="text" class="form-input" placeholder="Institutions" />
                  </div>
                </div>

                <div class="form-group">
                  <label>Section Subtext</label>
                  <textarea v-model="partners.subtext" class="form-input form-textarea" rows="2"></textarea>
                </div>

                <!-- Partners List -->
                <div class="form-group-label">Partner Institutions</div>
                <div class="form-group">
                  <div v-for="(partner, idx) in partners.partners" :key="idx" class="array-item">
                    <input v-model="partners.partners[idx]" type="text" class="form-input" placeholder="Partner institution name" />
                    <button type="button" @click="removePartner(idx)" class="btn-remove">×</button>
                  </div>
                  <button type="button" @click="addPartner" class="btn-add">+ Add Partner</button>
                </div>

                <div class="form-actions">
                  <button type="button" class="btn-reset" @click="resetPartners">Reset to Default</button>
                  <button type="submit" class="btn-save" :disabled="partnersSaving">
                    {{ partnersSaving ? 'Saving...' : 'Save Partners Section' }}
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
  admin:    Object,
  sections: Object,
})

const mounted          = ref(false)
const sidebarCollapsed = ref(false)
const heroOpen         = ref(true)
const heroSaving       = ref(false)
const storyOpen        = ref(false)
const storySaving      = ref(false)
const teamOpen              = ref(false)
const teamSaving            = ref(false)
const chairmanPhotoUploading = ref(false)
const chairmanPhotoRemoving  = ref(false)
const memberPhotoUploading   = reactive({})
const memberPhotoRemoving    = reactive({})
const academicsOpen    = ref(false)
const academicsSaving  = ref(false)
const mandateOpen      = ref(false)
const mandateSaving    = ref(false)
const impactOpen       = ref(false)
const impactSaving     = ref(false)
const valuesOpen       = ref(false)
const valuesSaving     = ref(false)
const partnersOpen     = ref(false)
const partnersSaving   = ref(false)

// ── Hero defaults ────────────────────────────────────────
const heroDefaults = {
  eyebrow_text: 'Who We Are',
  headline_line1: 'Bridging Decades of',
  headline_line2: 'Public Service',
  subtext: `The Bharat Governance Council (BGC) was founded by a distinguished group of retired civil servants — spanning the IAS, IPS, IFS, IFoS, and IRS — who together bring centuries of combined experience in governance, policy, and public administration.`,
  quote_text: 'Public service does not end with retirement. It evolves into mentorship, institutional memory, and a duty to guide the next generation.',
  quote_author: 'Dr. Kush Verma',
  quote_role: 'Founder & Chairman, BGC',
}

const savedHero = props.sections?.hero || {}
const hero = reactive({ ...heroDefaults, ...savedHero })

function saveHero() {
  heroSaving.value = true
  router.put('/admin/who-we-are/hero', { data: hero }, {
    preserveScroll: true,
    onFinish: () => { heroSaving.value = false },
  })
}

function resetHero() {
  Object.assign(hero, { ...heroDefaults })
}

// ── Story defaults ───────────────────────────────────────
const storyDefaults = {
  headline_line1: 'Born from a',
  headline_line2: 'Shared Conviction',
  paragraph1: `Bharat Governance Council was founded in 2023 by a distinguished group of retired officers spanning the Indian Administrative Service, Indian Police Service, Indian Foreign Service, Indian Forest Service, and Indian Revenue Service — officers who, combined, have served in some of the most consequential roles in the Government of India and across its states.`,
  paragraph2: `The founders shared a conviction: that the institutional memory, policy wisdom, and administrative experience accumulated over their combined centuries of public service should not simply retire with them. India's youngest civil servants — stepping into complex roles in a world shaped by technology, climate change, and rapid social transformation — needed structured guidance from those who had lived these challenges from the inside.`,
  paragraph3: `BGC was thus conceived not as a conventional think tank issuing reports from a distance, but as a living bridge between seasoned governance experience and emerging administrative talent. Every year, BGC onboards 100+ younger officers into this knowledge network.`,
  pullquote_text: `India has millions of rules. What it needs is men and women who understand, beyond the rules, what governance is fundamentally for.`,
  pullquote_cite: '— BGC Founding Charter, 2023',
  onboard_number: '100',
  onboard_title: 'Younger Bureaucrats Onboarded Each Year',
  onboard_desc: `BGC's mentorship programme connects younger IAS, IPS, IFS and allied service officers with our founding members — officers who have held the same roles and faced the same dilemmas, decades earlier.`,
}

const savedStory = props.sections?.story || {}
const story = reactive({ ...storyDefaults, ...savedStory })

function saveStory() {
  storySaving.value = true
  router.put('/admin/who-we-are/story', { data: story }, {
    preserveScroll: true,
    onFinish: () => { storySaving.value = false },
  })
}

function resetStory() {
  Object.assign(story, { ...storyDefaults })
}

// ── Team defaults ────────────────────────────────────────
const teamDefaults = {
  headline_line1: 'The',
  headline_line2: 'Architects',
  headline_line3: 'of BGC',
  subtext: `Between them, BGC's founders have governed districts, commanded borders, represented India abroad, conserved its forests, and reformed its revenues. This is the council they chose to build after retiring.`,
  chairman: {
    initials: 'KV',
    name: 'Dr. Kush Verma',
    service: 'IAS · 1979 · UP Cadre',
    batch: 'IAS 1979 · Uttar Pradesh Cadre',
    bio1: `A retired IAS officer of the 1979 Batch, UP Cadre, Dr. Verma served as the first Director General of the National Centre for Good Governance (NCGG), Government of India — the apex institution for administrative excellence and civil service capacity building. Prior to that, he was Director General of the National Institute of Administrative Research (NIAR) at Lal Bahadur Shastri National Academy of Administration, Mussoorie.`,
    bio2: `He holds a Doctorate from Jamia Millia Islamia on 'Redesigning India's Civil Services'. He is the author of A-Z of The Civil Services — a widely read account of bureaucratic India.`,
    tags: ['Civil Service Reform', 'Good Governance', 'Decentralisation', 'Administrative Ethics', 'NCGG · LBSNAA', 'Author']
  },
  members: [
    { initials: 'SO', name: 'Sh. Sunil Oberoi', service: 'IAS · 1984 · Co-Founder', role: 'Co-Founder', desc: 'Worked on <strong>Civil Services Reforms with UNDP and DoPT</strong>. Government nominee on UPSC interview boards; induction trainer for new civil service entrants. Expert in ethics and administrative values.' },
    { initials: 'SG', name: 'Sh. Somesh Goel', service: 'IPS · 1984 (Retd.) · Co-Founder', role: 'Co-Founder', desc: '<strong>Deputy Inspector General of Police, Himachal Pradesh (Retd.)</strong> Served in law enforcement, intelligence, and internal security. Expertise in policing reform and disaster response.' },
    { initials: 'MB', name: 'Sh. Manoj Kumar Bharti', service: 'IFS · 1988 (Retd.) · Co-Founder', role: 'Co-Founder', desc: 'Former <strong>Ambassador of India to Indonesia, UAE</strong> and <strong>Myanmar</strong>. Previously Special Secretary, Ministry of External Affairs. Career diplomat spanning Southeast and West Asia.' },
    { initials: 'SK', name: 'Sh. Sanjay Kumar', service: 'IFoS · 1984 · Jharkhand (Retd.)', role: 'Founding Trustee', desc: 'Former <strong>Director General of Forests &amp; Special Secretary</strong>, MoEFCC. Currently <strong>Chief Policy Advisor, Climate Parliament</strong> (UN-affiliated). Renewable energy and forest conservation advocate.' },
    { initials: 'AG', name: 'Sh. Anmol Goel', service: 'Social Psychologist · Educationist', role: 'Founding Trustee', desc: 'Educationist, Social Psychologist, and Philanthropist. Key architect of BGC\'s mentorship and outreach model. Expertise in human capital development and behavioural science.' },
    { initials: 'NJ', name: 'Sh. Nikhilesh Jha', service: 'IAS · 1984 (Retd.)', role: 'Founding Trustee', desc: '<strong>Director General, Himachal Pradesh</strong>. Former Director, LAWDA. Extensive experience in land administration, public welfare infrastructure, and state-level governance.' },
    { initials: 'SS', name: 'Sh. Sandeep Silas', service: 'IRTS · 1984 (Retd.)', role: 'Member', desc: '<strong>Indian Railway Traffic Service, 1984 batch (Retd.)</strong> Strategist and Management Expert with decades of experience in large-scale public logistics and institutional reform.' },
    { initials: 'AC', name: 'Sh. A.K. Chauhan', service: 'IRS · 1984 (Retd.)', role: 'Member', desc: '<strong>Principal Chief Commissioner of Income Tax, Madhya Pradesh (Retd.)</strong> Senior tax administrator with expertise in fiscal administration and revenue reform.' },
    { initials: 'RD', name: 'Smt. Riva Das', service: 'IFS · 1986 (Retd.)', role: 'Member', desc: 'Former <strong>High Commissioner of India to Bangladesh</strong>. Seasoned diplomat with specialisation in South Asian affairs, bilateral trade, and cultural diplomacy.' },
    { initials: 'AS', name: 'Sh. Arvind Singh', service: 'IAS · 1988 (Retd.)', role: 'Member', desc: 'Managing Director, <strong>Provincial Co-operative Federation, Lucknow</strong>. Specialises in cooperative governance, agricultural finance, and rural institutional reform.' },
    { initials: 'SSi', name: 'Sh. Sanjay Sinha', service: 'IPS · 1978 (Retd.)', role: 'Member', desc: 'Former <strong>Member, Union Public Service Commission (UPSC) Panel</strong>. One of BGC\'s most senior voices on civil services selection, police reform, and constitutional governance.' }
  ]
}

const savedTeam = props.sections?.founding_team || {}
const team = reactive({
  ...teamDefaults,
  ...savedTeam,
  chairman: { 
    ...teamDefaults.chairman, 
    ...(savedTeam.chairman || {}),
    tags: savedTeam.chairman?.tags?.length ? [...savedTeam.chairman.tags] : [...teamDefaults.chairman.tags]
  },
  members: savedTeam.members?.length ? savedTeam.members.map(m => ({ ...m })) : teamDefaults.members.map(m => ({ ...m }))
})

function saveTeam() {
  teamSaving.value = true
  router.put('/admin/who-we-are/founding_team', { data: team }, {
    preserveScroll: true,
    onFinish: () => { teamSaving.value = false },
  })
}

function resetTeam() {
  Object.assign(team, {
    ...teamDefaults,
    chairman: { ...teamDefaults.chairman },
    members: teamDefaults.members.map(m => ({ ...m }))
  })
}

function uploadChairmanPhoto(e) {
  const file = e.target.files?.[0]
  if (!file) return
  chairmanPhotoUploading.value = true
  const formData = new FormData()
  formData.append('image', file)
  router.post('/admin/who-we-are/chairman/upload-photo', formData, {
    forceFormData:  true,
    preserveScroll: true,
    onSuccess: () => {
      const updated = props.sections?.founding_team?.chairman
      if (updated) {
        team.chairman.image       = updated.image       || null
        team.chairman.stored_path = updated.stored_path || null
      }
    },
    onFinish: () => { chairmanPhotoUploading.value = false },
  })
}

function removeChairmanPhoto() {
  chairmanPhotoRemoving.value = true
  router.post('/admin/who-we-are/chairman/remove-photo', {}, {
    preserveScroll: true,
    onSuccess: () => {
      team.chairman.image       = null
      team.chairman.stored_path = null
    },
    onFinish: () => { chairmanPhotoRemoving.value = false },
  })
}

function uploadMemberPhoto(index, e) {
  const file = e.target.files?.[0]
  if (!file) return
  memberPhotoUploading[index] = true
  const formData = new FormData()
  formData.append('image', file)
  formData.append('index', index)
  router.post('/admin/who-we-are/members/upload-photo', formData, {
    forceFormData:  true,
    preserveScroll: true,
    onSuccess: () => {
      const updated = props.sections?.founding_team?.members?.[index]
      if (updated) {
        team.members[index].image       = updated.image       || null
        team.members[index].stored_path = updated.stored_path || null
      }
    },
    onFinish: () => { memberPhotoUploading[index] = false },
  })
}

function removeMemberPhoto(index) {
  memberPhotoRemoving[index] = true
  router.post('/admin/who-we-are/members/remove-photo', { index }, {
    preserveScroll: true,
    onSuccess: () => {
      team.members[index].image       = null
      team.members[index].stored_path = null
    },
    onFinish: () => { memberPhotoRemoving[index] = false },
  })
}

function addMember() {
  team.members.push({ initials: '', name: '', service: '', role: '', desc: '', image: null, stored_path: null })
}

function removeMember(index) {
  if (confirm('Are you sure you want to remove this member?')) {
    team.members.splice(index, 1)
  }
}

function addChairmanTag() {
  team.chairman.tags.push('')
}

function removeChairmanTag(index) {
  team.chairman.tags.splice(index, 1)
}

// ── Academics defaults ───────────────────────────────────
const academicsDefaults = {
  headline_line1: 'Scholars Who',
  headline_line2: 'Ground Our Work',
  subtext: `BGC's practitioner wisdom is complemented by academic associates from India's foremost universities and law schools — ensuring our research is empirically rigorous and theoretically grounded.`,
  academics: [
    { initials: 'PB', institution: 'JNU', name: 'Prof. Pratap Bhanu Mehta', specialisation: 'Political Theory & Comparative Politics' },
    { initials: 'YY', institution: 'Ashoka', name: 'Prof. Yamini Aiyar', specialisation: 'Public Policy & Governance' },
    { initials: 'DM', institution: 'CPR', name: 'Dr. Devesh Kapur', specialisation: 'Political Economy & Development' },
    { initials: 'NJ', institution: 'NLSIU', name: 'Prof. Nick Robinson', specialisation: 'Constitutional Law & Courts' },
    { initials: 'SM', institution: 'TISS', name: 'Prof. Sukhadeo Thorat', specialisation: 'Social Justice & Inclusion' },
    { initials: 'RK', institution: 'IIM-A', name: 'Prof. Rakesh Basant', specialisation: 'Industrial Economics' },
    { initials: 'AS', institution: 'Delhi', name: 'Prof. Amita Singh', specialisation: 'Federalism & Decentralisation' },
    { initials: 'VK', institution: 'LSE', name: 'Dr. Vikram Kumar Chand', specialisation: 'Comparative Administration' }
  ]
}

const savedAcademics = props.sections?.academics || {}
const academics = reactive({
  ...academicsDefaults,
  ...savedAcademics,
  academics: savedAcademics.academics?.length ? savedAcademics.academics.map(a => ({ ...a })) : academicsDefaults.academics.map(a => ({ ...a }))
})

function saveAcademics() {
  academicsSaving.value = true
  router.put('/admin/who-we-are/academics', { data: academics }, {
    preserveScroll: true,
    onFinish: () => { academicsSaving.value = false },
  })
}

function resetAcademics() {
  Object.assign(academics, {
    ...academicsDefaults,
    academics: academicsDefaults.academics.map(a => ({ ...a }))
  })
}

function addAcademic() {
  academics.academics.push({ initials: '', institution: '', name: '', specialisation: '' })
}

function removeAcademic(index) {
  if (confirm('Are you sure you want to remove this academic?')) {
    academics.academics.splice(index, 1)
  }
}

// ── Mandate defaults ─────────────────────────────────────
const mandateDefaults = {
  headline_line1: 'Our',
  headline_line2: 'Mandate',
  mandates: [
    { title: 'Mentorship for Younger Civil Servants', body: `BGC connects serving officers — IAS, IPS, IFS, and allied services — with retired civil servants who have held similar roles, providing structured guidance, institutional memory, and real-world insight unavailable in any manual.` },
    { title: 'Custodians of Institutional Memory', body: `India's bureaucracy has accumulated decades of hard-won policy wisdom. BGC formalises the transfer of this knowledge — not as folklore, but as structured institutional memory that younger officers can query, learn from, and build on.` },
    { title: 'Research & Policy Analysis', body: `BGC produces independent research on governance reform — civil service structures, decentralisation, ethics enforcement, digitisation — grounded in decades of administrative experience and complemented by academic rigour.` },
    { title: 'Non-Partisan, Evidence-Based', body: `BGC does not endorse political parties or candidates. Our members retain full intellectual independence. We analyse governance structures, not political choices. Our commitment is to democratic institutions — regardless of who governs.` },
    { title: 'Convening Practitioners & Scholars', body: `BGC hosts closed-door roundtables, workshops, and policy dialogues — bringing together serving bureaucrats, retired officers, and scholars. These are not public spectacles. They are working sessions designed to produce actionable insight.` },
    { title: 'Building the Next Generation', body: `BGC is not a think tank producing papers for shelves. It is a living knowledge network — training younger officers, archiving institutional memory, and ensuring that India's governance capacity deepens with each cohort.` }
  ]
}

const savedMandate = props.sections?.mandate || {}
const mandate = reactive({
  ...mandateDefaults,
  ...savedMandate,
  mandates: savedMandate.mandates?.length ? savedMandate.mandates.map(m => ({ ...m })) : mandateDefaults.mandates.map(m => ({ ...m }))
})

function saveMandate() {
  mandateSaving.value = true
  router.put('/admin/who-we-are/mandate', { data: mandate }, {
    preserveScroll: true,
    onFinish: () => { mandateSaving.value = false },
  })
}

function resetMandate() {
  Object.assign(mandate, {
    ...mandateDefaults,
    mandates: mandateDefaults.mandates.map(m => ({ ...m }))
  })
}

function addMandate() {
  mandate.mandates.push({ title: '', body: '' })
}

function removeMandate(index) {
  if (confirm('Are you sure you want to remove this mandate item?')) {
    mandate.mandates.splice(index, 1)
  }
}

// ── Impact defaults ──────────────────────────────────────
const impactDefaults = {
  headline_line1: 'Measuring',
  headline_line2: 'What Matters',
  stats: [
    { num: '100+', label: 'Young Officers Onboarded Per Year' },
    { num: '15+',  label: 'Founding Members Across 6 Services' },
    { num: '8',    label: 'Academic Partner Institutions' },
    { num: '30+',  label: 'Avg. Years Service per Founder' },
    { num: '6',    label: 'All India Services Represented' },
  ],
}

const savedImpact = props.sections?.impact || {}
const impact = reactive({
  ...impactDefaults,
  ...savedImpact,
  stats: savedImpact.stats?.length ? savedImpact.stats.map(s => ({ ...s })) : impactDefaults.stats.map(s => ({ ...s })),
})

function saveImpact() {
  impactSaving.value = true
  router.put('/admin/who-we-are/impact', { data: impact }, {
    preserveScroll: true,
    onFinish: () => { impactSaving.value = false },
  })
}

function resetImpact() {
  Object.assign(impact, {
    ...impactDefaults,
    stats: impactDefaults.stats.map(s => ({ ...s })),
  })
}

// ── Values defaults ──────────────────────────────────────
const valuesDefaults = {
  headline_line1: 'What BGC',
  headline_line2: 'Stands For',
  subtext: `BGC does not take institutional positions on political questions. Our members retain full intellectual independence. But we are not neutral about what good governance demands — and these commitments are non-negotiable.`,
  values: [
    { title: 'Constitutional Supremacy', desc: `India's Constitution is not a suggestion. It is the ultimate authority. BGC's work begins and ends with constitutional values — rule of law, federalism, fundamental rights, and separation of powers.` },
    { title: 'Institutional Integrity Over Political Convenience', desc: `Civil services, the judiciary, election machinery, and regulatory bodies must remain independent. When institutions are politicised, democracy dies in increments.` },
    { title: 'Evidence Over Ideology', desc: `Good governance is not left-wing or right-wing. It is what works. BGC evaluates policies on outcomes, not on whether they align with any political orthodoxy.` },
    { title: 'Transparency & Accountability', desc: `Power without accountability is tyranny. BGC advocates for stronger RTI enforcement, independent anti-corruption bodies, asset declaration norms, and ethics oversight — not as inconveniences, but as democratic necessities.` }
  ]
}

const savedValues = props.sections?.values || {}
const values = reactive({
  ...valuesDefaults,
  ...savedValues,
  values: savedValues.values?.length ? savedValues.values.map(v => ({ ...v })) : valuesDefaults.values.map(v => ({ ...v }))
})

function saveValues() {
  valuesSaving.value = true
  router.put('/admin/who-we-are/values', { data: values }, {
    preserveScroll: true,
    onFinish: () => { valuesSaving.value = false },
  })
}

function resetValues() {
  Object.assign(values, {
    ...valuesDefaults,
    values: valuesDefaults.values.map(v => ({ ...v }))
  })
}

function addValue() {
  values.values.push({ title: '', desc: '' })
}

function removeValue(index) {
  if (confirm('Are you sure you want to remove this value?')) {
    values.values.splice(index, 1)
  }
}

// ── Partners defaults ────────────────────────────────────
const partnersDefaults = {
  headline_line1: 'Supported by',
  headline_line2: 'Purpose-Aligned',
  headline_line3: 'Institutions',
  subtext: `BGC collaborates with institutions that share its commitment to evidence-based governance reform and civil service excellence.`,
  partners: [
    'National Centre for Good Governance (NCGG)',
    'Lal Bahadur Shastri National Academy of Administration',
    'Centre for Policy Research',
    'Ashoka University',
    'Jawaharlal Nehru University',
    'National Law School of India University',
    'Indian Institute of Public Administration',
    'Tata Institute of Social Sciences',
    'Indian Institute of Management Ahmedabad',
    'Delhi School of Economics',
    'London School of Economics (India Programme)',
    'Observer Research Foundation'
  ]
}

const savedPartners = props.sections?.partners || {}
const partners = reactive({
  ...partnersDefaults,
  ...savedPartners,
  partners: savedPartners.partners?.length ? [...savedPartners.partners] : [...partnersDefaults.partners]
})

function savePartners() {
  partnersSaving.value = true
  router.put('/admin/who-we-are/partners', { data: partners }, {
    preserveScroll: true,
    onFinish: () => { partnersSaving.value = false },
  })
}

function resetPartners() {
  Object.assign(partners, {
    ...partnersDefaults,
    partners: [...partnersDefaults.partners]
  })
}

function addPartner() {
  partners.partners.push('')
}

function removePartner(index) {
  if (confirm('Are you sure you want to remove this partner?')) {
    partners.partners.splice(index, 1)
  }
}

// ── Logout ───────────────────────────────────────────────
function logout() {
  if (confirm('Are you sure you want to logout?')) {
    router.post('/admin/logout')
  }
}

const seoDefaults = {
  meta_title:       'Who We Are | Bharat Governance Council',
  meta_description: 'Learn about the Bharat Governance Council — our story, founding team, values, and mandate to strengthen democratic governance and public policy in India.',
  meta_keywords:    'who we are, BGC, Bharat Governance Council, founding team, governance, public policy',
}
const savedSeo  = props.sections?.seo ?? {}
const seo       = reactive({ ...seoDefaults, ...savedSeo })
const seoOpen   = ref(false)
const seoSaving = ref(false)
function saveSeo() {
  seoSaving.value = true
  router.put('/admin/who-we-are/seo', { data: { ...seo } }, {
    preserveScroll: true,
    onFinish: () => (seoSaving.value = false),
  })
}
function resetSeo() { Object.assign(seo, { ...seoDefaults }) }

onMounted(() => { setTimeout(() => { mounted.value = true }, 50) })
</script>

<style scoped>
/* ══════════════════════════════════════════════════════════
   ADMIN ROOT
   ══════════════════════════════════════════════════════════ */
.admin-root{display:flex;min-height:100vh;background:#f2f4f8;font-family:'DM Sans',sans-serif;}

/* ── Sidebar ──────────────────────────────────────────── */
.admin-sidebar{width:260px;background:#0b1c38;color:#f5f7fa;display:flex;flex-direction:column;transition:width 0.3s;position:relative;border-right:1px solid rgba(201,168,76,0.1);}
.admin-sidebar.collapsed{width:72px;}
.sidebar-logo{display:flex;align-items:center;gap:12px;padding:24px 20px;border-bottom:1px solid rgba(255,255,255,0.06);}
.sidebar-logo-img{width:32px;height:32px;object-fit:contain;}
.sidebar-logo-label{font-family:'Cormorant Garamond',serif;font-size:1.25rem;font-weight:600;color:#c9a84c;white-space:nowrap;}
.admin-sidebar.collapsed .sidebar-logo-label{display:none;}

.sidebar-nav{flex:1;padding:24px 12px;overflow-y:auto;}
.nav-group-label{font-size:9px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;color:rgba(184,197,216,0.4);margin-bottom:12px;padding:0 12px;}
.nav-item{display:flex;align-items:center;gap:12px;padding:10px 12px;color:rgba(245,247,250,0.6);text-decoration:none;border-radius:6px;transition:background 0.2s,color 0.2s;margin-bottom:4px;}
.nav-item:hover{background:rgba(255,255,255,0.04);color:#f5f7fa;}
.nav-item.active{background:linear-gradient(135deg,rgba(201,168,76,0.15),rgba(201,168,76,0.08));color:#e8cf8a;border-left:3px solid #c9a84c;}
.nav-icon{flex-shrink:0;width:16px;height:16px;opacity:0.7;}
.nav-item.active .nav-icon{opacity:1;}
.nav-label{font-size:14px;font-weight:400;white-space:nowrap;}
.admin-sidebar.collapsed .nav-label{display:none;}

.sidebar-toggle{position:absolute;bottom:80px;right:-12px;width:24px;height:24px;border-radius:50%;background:#0b1c38;border:2px solid rgba(201,168,76,0.2);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.25s;}
.sidebar-toggle:hover{background:#c9a84c;border-color:#c9a84c;}
.sidebar-toggle svg{transition:transform 0.3s;}
.sidebar-toggle svg.flipped{transform:rotate(180deg);}

.sidebar-footer{padding:16px 12px;border-top:1px solid rgba(255,255,255,0.06);}
.btn-logout{display:flex;align-items:center;gap:10px;width:100%;padding:10px 12px;background:transparent;border:1px solid rgba(201,168,76,0.2);color:rgba(245,247,250,0.7);border-radius:6px;cursor:pointer;font-size:13px;transition:all 0.25s;}
.btn-logout:hover{background:rgba(201,168,76,0.1);border-color:#c9a84c;color:#e8cf8a;}
.admin-sidebar.collapsed .btn-logout span{display:none;}

/* ── Main ─────────────────────────────────────────────── */
.admin-main{flex:1;display:flex;flex-direction:column;}

/* ── Topbar ───────────────────────────────────────────── */
.admin-topbar{height:72px;background:#fff;border-bottom:1px solid #e8eaf0;display:flex;align-items:center;justify-content:space-between;padding:0 32px;}
.topbar-left{display:flex;flex-direction:column;gap:2px;}
.topbar-title{font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-weight:600;color:#0b1c38;}
.topbar-breadcrumb{display:flex;align-items:center;gap:6px;font-size:12px;color:#8a9bbf;}
.bc-sep{color:#c9a84c;}
.bc-active{color:#0b1c38;font-weight:500;}

.topbar-right{display:flex;align-items:center;gap:20px;}
.topbar-live{display:flex;align-items:center;gap:8px;padding:6px 12px;background:rgba(34,197,94,0.08);border-radius:20px;}
.live-dot{width:6px;height:6px;border-radius:50%;background:#22c55e;box-shadow:0 0 8px rgba(34,197,94,0.6);animation:pulse 2s infinite;}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:0.5}}
.live-label{font-size:11px;font-weight:600;color:#16a34a;letter-spacing:0.03em;}

.topbar-admin{display:flex;align-items:center;gap:12px;}
.admin-avatar{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#c9a84c,#e8cf8a);display:flex;align-items:center;justify-content:center;font-family:'Cormorant Garamond',serif;font-size:16px;font-weight:700;color:#0b1c38;flex-shrink:0;}
.admin-info{display:flex;flex-direction:column;}
.admin-name{font-size:13px;font-weight:600;color:#0b1c38;}
.admin-email{font-size:11px;color:#8a9bbf;}

/* ── Content ── */
.content-wrap{flex:1;overflow-y:auto;padding:32px;opacity:0;transform:translateY(12px);transition:opacity 0.4s,transform 0.4s;}
.content-wrap.visible{opacity:1;transform:translateY(0);}

.flash{padding:14px 20px;border-radius:8px;margin-bottom:24px;font-size:14px;animation:slideIn 0.3s;}
.flash-success{background:#d1fae5;color:#065f46;border:1px solid #86efac;}
.flash-error{background:#fee2e2;color:#991b1b;border:1px solid #fca5a5;}
@keyframes slideIn{from{opacity:0;transform:translateY(-10px)}to{opacity:1;transform:translateY(0)}}

.page-header{margin-bottom:32px;}
.page-title{font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:600;color:#0b1c38;margin-bottom:6px;}
.page-sub{font-size:14px;color:#8a9bbf;}

/* ── Section Panel ────────────────────────────────────── */
.section-panel{background:#fff;border:1px solid #e8eaf0;border-radius:12px;margin-bottom:16px;overflow:hidden;transition:box-shadow 0.25s;}
.section-panel:hover{box-shadow:0 4px 16px rgba(11,28,56,0.06);}

.section-panel-header{display:flex;align-items:center;justify-content:space-between;padding:20px 24px;cursor:pointer;user-select:none;transition:background 0.2s;}
.section-panel-header:hover{background:#f9fafb;}

.section-panel-left{display:flex;align-items:center;gap:16px;}
.section-num{font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-weight:700;color:#c9a84c;min-width:36px;}
.section-panel-title{font-family:'Cormorant Garamond',serif;font-size:1.15rem;font-weight:600;color:#0b1c38;margin-bottom:2px;}
.section-panel-desc{font-size:13px;color:#8a9bbf;}

.section-chevron{transition:transform 0.3s;color:#8a9bbf;}
.section-chevron.open{transform:rotate(180deg);}

.section-panel-body{padding:0 24px 24px 24px;border-top:1px solid #e8eaf0;}

/* Panel slide transition */
.panel-slide-enter-active,.panel-slide-leave-active{transition:all 0.3s ease;}
.panel-slide-enter-from{opacity:0;max-height:0;padding-top:0;padding-bottom:0;}
.panel-slide-enter-to{opacity:1;max-height:2000px;}
.panel-slide-leave-from{opacity:1;max-height:2000px;}
.panel-slide-leave-to{opacity:0;max-height:0;padding-top:0;padding-bottom:0;}

/* Form elements */
.form-group-label{font-size:10px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#c9a84c;margin-top:24px;margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid #e8eaf0;}
.form-row{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;}
.form-group{display:flex;flex-direction:column;gap:6px;margin-bottom:16px;}
.form-group label{font-size:12px;font-weight:600;color:#0b1c38;}
.form-input,.form-textarea{padding:10px 14px;border:1px solid #d1d5db;border-radius:6px;font-size:14px;font-family:inherit;color:#0b1c38;transition:all 0.2s;}
.form-input:focus,.form-textarea:focus{outline:none;border-color:#c9a84c;box-shadow:0 0 0 3px rgba(201,168,76,0.1);}
.form-textarea{resize:vertical;line-height:1.6;}
.form-note{font-size:13px;color:#8a9bbf;font-style:italic;margin:12px 0;padding:12px;background:#f9fafb;border-left:3px solid #c9a84c;border-radius:4px;}

.stat-row{display:grid;grid-template-columns:40px 1fr 120px 100px;gap:12px;align-items:end;margin-bottom:12px;padding:12px;background:#f9fafb;border-radius:6px;}
.stat-row-num{font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-weight:700;color:#c9a84c;align-self:center;}
.form-group-sm{min-width:80px;}

/* Form actions */
.form-actions{display:flex;gap:12px;justify-content:flex-end;margin-top:24px;padding-top:24px;border-top:1px solid #e8eaf0;}
.btn-reset,.btn-save{padding:10px 20px;border-radius:6px;font-size:14px;font-weight:600;cursor:pointer;transition:all 0.2s;border:none;}
.btn-reset{background:#f3f4f6;color:#6b7280;border:1px solid #d1d5db;}
.btn-reset:hover{background:#e5e7eb;color:#374151;}
.btn-save{background:linear-gradient(135deg,#c9a84c,#e8cf8a);color:#0b1c38;box-shadow:0 2px 8px rgba(201,168,76,0.25);}
.btn-save:hover{transform:translateY(-2px);box-shadow:0 4px 12px rgba(201,168,76,0.35);}
.btn-save:disabled{opacity:0.6;cursor:not-allowed;transform:none;}

/* Array management */
.array-item{display:flex;gap:8px;margin-bottom:8px;align-items:center;}
.array-item input{flex:1;}
.btn-remove{padding:6px 12px;background:#ef4444;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:18px;line-height:1;transition:background 0.2s;}
.btn-remove:hover{background:#dc2626;}
.btn-add{padding:8px 16px;background:#10b981;color:#fff;border:none;border-radius:6px;cursor:pointer;font-size:13px;font-weight:600;margin-top:8px;transition:all 0.2s;}
.btn-add:hover{background:#059669;transform:translateY(-1px);}

.member-card{background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;padding:20px;margin-bottom:16px;}
.member-card-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;padding-bottom:12px;border-bottom:2px solid #e5e7eb;}
.member-card-header span{font-size:14px;font-weight:700;color:#0b1c38;font-family:'Cormorant Garamond',serif;}
.btn-remove-card{padding:6px 14px;background:#ef4444;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:12px;font-weight:600;transition:background 0.2s;}
.btn-remove-card:hover{background:#dc2626;}
.btn-add-card{padding:10px 20px;background:#3b82f6;color:#fff;border:none;border-radius:6px;cursor:pointer;font-size:14px;font-weight:600;margin-bottom:20px;transition:all 0.2s;display:inline-block;}
.btn-add-card:hover{background:#2563eb;transform:translateY(-2px);}

/* ── Photo upload UI ──────────────────────────── */
.ch-photo-row {
  display: flex; gap: 20px; align-items: flex-start;
  padding: 16px; background: #f8f9fc;
  border: 1px solid #e2e6f0; border-radius: 8px;
  margin-bottom: 16px;
}
.ch-photo-preview {
  width: 80px; height: 100px; border-radius: 4px;
  background: #e8eaf0; flex-shrink: 0;
  overflow: hidden; position: relative;
  display: flex; align-items: center; justify-content: center;
}
.ch-photo-img {
  width: 100%; height: 100%;
  object-fit: cover; object-position: center top;
}
.ch-photo-placeholder {
  width: 100%; height: 100%;
  display: flex; align-items: center; justify-content: center;
  background: #e8eaf0;
}
.ch-photo-placeholder span {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.4rem; font-weight: 700; color: #8a9bbf;
}
.ch-photo-right { flex: 1; }
.ch-photo-label {
  font-size: 13px; font-weight: 600; color: #0b1c38;
  margin-bottom: 4px; font-family: 'DM Sans', sans-serif;
}
.ch-photo-hint {
  font-size: 11px; color: #8a9bbf; margin-bottom: 12px;
  font-family: 'DM Sans', sans-serif; line-height: 1.5;
}
.ch-photo-btns { display: flex; gap: 8px; flex-wrap: wrap; }
.btn-upload-voice {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 7px 14px; border-radius: 5px; cursor: pointer;
  font-size: 12px; font-weight: 600;
  background: #0b1c38; color: #fff;
  border: none; transition: background 0.2s;
  font-family: 'DM Sans', sans-serif;
}
.btn-upload-voice:hover { background: #162d54; }
.btn-upload-voice.btn-uploading { opacity: 0.6; cursor: not-allowed; }
.btn-remove-voice-img {
  display: inline-flex; align-items: center; gap: 5px;
  padding: 7px 12px; border-radius: 5px; cursor: pointer;
  font-size: 12px; font-weight: 600;
  background: transparent; color: #ef4444;
  border: 1px solid #ef4444; transition: all 0.2s;
  font-family: 'DM Sans', sans-serif;
}
.btn-remove-voice-img:hover { background: #ef4444; color: #fff; }
.btn-remove-voice-img:disabled { opacity: 0.5; cursor: not-allowed; }
</style>
