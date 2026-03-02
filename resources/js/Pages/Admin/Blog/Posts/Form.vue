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
          <h2 class="topbar-title">{{ isEdit ? 'Edit Post' : 'New Post' }}</h2>
          <div class="topbar-breadcrumb">
            <span>Admin</span><span class="bc-sep">›</span>
            <Link href="/admin/blog/posts" class="bc-link">Posts</Link><span class="bc-sep">›</span>
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

        <Link href="/admin/blog/posts" class="back-link">
          <svg viewBox="0 0 14 14" fill="none" width="12" height="12"><path d="M9 2L4 7l5 5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
          Back to Posts
        </Link>

        <form @submit.prevent="submit" enctype="multipart/form-data">
          <div class="form-grid">

            <!-- ══ Main Column ══ -->
            <div class="col-main">

              <!-- Title -->
              <div class="card">
                <div class="card-body">
                  <div class="form-group">
                    <input
                      v-model="form.title"
                      @input="autoSlug"
                      type="text"
                      class="title-input"
                      :class="{ error: form.errors.title }"
                      placeholder="Post Title…"
                    />
                    <span v-if="form.errors.title" class="form-error">{{ form.errors.title }}</span>
                  </div>

                  <!-- Slug -->
                  <div class="form-group mt-12">
                    <label class="form-label">Permalink</label>
                    <div class="input-prefix-wrap">
                      <span class="input-prefix">/insights/</span>
                      <input
                        v-model="form.slug"
                        type="text"
                        class="form-input with-prefix"
                        :class="{ error: form.errors.slug }"
                        placeholder="post-slug"
                      />
                    </div>
                    <span v-if="form.errors.slug" class="form-error">{{ form.errors.slug }}</span>
                  </div>
                </div>
              </div>

              <!-- Excerpt -->
              <div class="card">
                <div class="card-header"><h4 class="card-title">Excerpt</h4></div>
                <div class="card-body">
                  <textarea
                    v-model="form.excerpt"
                    class="form-textarea"
                    :class="{ error: form.errors.excerpt }"
                    rows="3"
                    placeholder="Short summary displayed in article listings…"
                    maxlength="500"
                  ></textarea>
                  <div class="char-count">{{ form.excerpt?.length ?? 0 }} / 500</div>
                </div>
              </div>

              <!-- Content — TipTap -->
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Content</h4>
                </div>
                <div class="card-body p0">
                  <!-- Toolbar -->
                  <div class="editor-toolbar" v-if="editor">
                    <div class="toolbar-group">
                      <button type="button" @click="editor.chain().focus().toggleBold().run()" :class="{ 'tb-active': editor.isActive('bold') }" class="tb-btn" title="Bold">
                        <svg viewBox="0 0 14 14" fill="none" width="13" height="13"><path d="M4 7h4a2 2 0 000-4H4v4zM4 7h4.5a2.5 2.5 0 010 5H4V7z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/></svg>
                      </button>
                      <button type="button" @click="editor.chain().focus().toggleItalic().run()" :class="{ 'tb-active': editor.isActive('italic') }" class="tb-btn" title="Italic">
                        <svg viewBox="0 0 14 14" fill="none" width="13" height="13"><path d="M8 3H6M10 11H8M7 3l-2 8" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
                      </button>
                      <button type="button" @click="editor.chain().focus().toggleUnderline().run()" :class="{ 'tb-active': editor.isActive('underline') }" class="tb-btn" title="Underline">
                        <svg viewBox="0 0 14 14" fill="none" width="13" height="13"><path d="M4 3v4a3 3 0 006 0V3M2 12h10" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
                      </button>
                      <button type="button" @click="editor.chain().focus().toggleStrike().run()" :class="{ 'tb-active': editor.isActive('strike') }" class="tb-btn" title="Strikethrough">
                        <svg viewBox="0 0 14 14" fill="none" width="13" height="13"><path d="M2 7h10M5 4.5c0-1 .9-1.5 2-1.5s2 .5 2 1.5M5 9.5c0 1 .9 1.5 2 1.5s2-.5 2-1.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
                      </button>
                    </div>
                    <div class="toolbar-sep"/>
                    <div class="toolbar-group">
                      <button type="button" @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" :class="{ 'tb-active': editor.isActive('heading', { level: 2 }) }" class="tb-btn tb-text" title="Heading 2">H2</button>
                      <button type="button" @click="editor.chain().focus().toggleHeading({ level: 3 }).run()" :class="{ 'tb-active': editor.isActive('heading', { level: 3 }) }" class="tb-btn tb-text" title="Heading 3">H3</button>
                      <button type="button" @click="editor.chain().focus().toggleHeading({ level: 4 }).run()" :class="{ 'tb-active': editor.isActive('heading', { level: 4 }) }" class="tb-btn tb-text" title="Heading 4">H4</button>
                    </div>
                    <div class="toolbar-sep"/>
                    <div class="toolbar-group">
                      <button type="button" @click="editor.chain().focus().toggleBulletList().run()" :class="{ 'tb-active': editor.isActive('bulletList') }" class="tb-btn" title="Bullet List">
                        <svg viewBox="0 0 14 14" fill="none" width="13" height="13"><circle cx="2.5" cy="4" r="1" fill="currentColor"/><path d="M5 4h7" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/><circle cx="2.5" cy="7" r="1" fill="currentColor"/><path d="M5 7h7" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/><circle cx="2.5" cy="10" r="1" fill="currentColor"/><path d="M5 10h7" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
                      </button>
                      <button type="button" @click="editor.chain().focus().toggleOrderedList().run()" :class="{ 'tb-active': editor.isActive('orderedList') }" class="tb-btn" title="Ordered List">
                        <svg viewBox="0 0 14 14" fill="none" width="13" height="13"><path d="M2 3h1v3H2M2 3.5h1M2 6h1" stroke="currentColor" stroke-width="1" stroke-linecap="round"/><path d="M5 4h7" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/><path d="M2 9.5c.5-.5 1-.3 1 .3s-.8.7-.8.7H3M2 11h1" stroke="currentColor" stroke-width="1" stroke-linecap="round"/><path d="M5 10h7" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
                      </button>
                      <button type="button" @click="editor.chain().focus().toggleBlockquote().run()" :class="{ 'tb-active': editor.isActive('blockquote') }" class="tb-btn" title="Blockquote">
                        <svg viewBox="0 0 14 14" fill="none" width="13" height="13"><path d="M2 5h3v3H2zM2 5c0-1.1.9-2 2-2M8 5h3v3H8zM8 5c0-1.1.9-2 2-2" stroke="currentColor" stroke-width="1.2"/><path d="M5 8c0 1.1-.9 2-2 2M11 8c0 1.1-.9 2-2 2" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>
                      </button>
                      <button type="button" @click="editor.chain().focus().toggleCodeBlock().run()" :class="{ 'tb-active': editor.isActive('codeBlock') }" class="tb-btn" title="Code Block">
                        <svg viewBox="0 0 14 14" fill="none" width="13" height="13"><path d="M4.5 4L2 7l2.5 3M9.5 4L12 7l-2.5 3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                      </button>
                      <button type="button" @click="editor.chain().focus().setHorizontalRule().run()" class="tb-btn" title="Horizontal Rule">
                        <svg viewBox="0 0 14 14" fill="none" width="13" height="13"><path d="M1 7h12" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
                      </button>
                    </div>
                    <div class="toolbar-sep"/>
                    <div class="toolbar-group">
                      <button type="button" @click="setLink" :class="{ 'tb-active': editor.isActive('link') }" class="tb-btn" title="Link">
                        <svg viewBox="0 0 14 14" fill="none" width="13" height="13"><path d="M5.5 8.5a3.5 3.5 0 004.95 0l1.42-1.41a3.5 3.5 0 00-4.95-4.95L6 4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/><path d="M8.5 5.5a3.5 3.5 0 00-4.95 0L2.13 6.92a3.5 3.5 0 004.95 4.95L8 10" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
                      </button>
                      <button type="button" @click="insertImageUrl" class="tb-btn" title="Insert Image by URL">
                        <svg viewBox="0 0 14 14" fill="none" width="13" height="13"><rect x="1.5" y="2.5" width="11" height="9" rx="1" stroke="currentColor" stroke-width="1.2"/><circle cx="4.5" cy="5.5" r="1" stroke="currentColor" stroke-width="1"/><path d="M1.5 10l3-3 2 2 2-2.5 3 3.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                      </button>
                      <label class="tb-btn" title="Upload Image" style="cursor:pointer;">
                        <svg viewBox="0 0 14 14" fill="none" width="13" height="13"><path d="M7 1v8M4.5 3.5L7 1l2.5 2.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/><path d="M2 9v2a1 1 0 001 1h8a1 1 0 001-1V9" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
                        <input type="file" accept="image/*" class="hidden-file" @change="uploadEditorImage" />
                      </label>
                    </div>
                    <div class="toolbar-sep"/>
                    <div class="toolbar-group">
                      <button type="button" @click="editor.chain().focus().setTextAlign('left').run()" :class="{ 'tb-active': editor.isActive({ textAlign: 'left' }) }" class="tb-btn" title="Align Left">
                        <svg viewBox="0 0 14 14" fill="none" width="13" height="13"><path d="M1 3h12M1 6h8M1 9h12M1 12h8" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>
                      </button>
                      <button type="button" @click="editor.chain().focus().setTextAlign('center').run()" :class="{ 'tb-active': editor.isActive({ textAlign: 'center' }) }" class="tb-btn" title="Align Center">
                        <svg viewBox="0 0 14 14" fill="none" width="13" height="13"><path d="M1 3h12M3 6h8M1 9h12M3 12h8" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>
                      </button>
                      <button type="button" @click="editor.chain().focus().undo().run()" class="tb-btn" title="Undo">
                        <svg viewBox="0 0 14 14" fill="none" width="13" height="13"><path d="M3 6H9a3 3 0 010 6H5M3 6L1 4M3 6L1 8" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                      </button>
                      <button type="button" @click="editor.chain().focus().redo().run()" class="tb-btn" title="Redo">
                        <svg viewBox="0 0 14 14" fill="none" width="13" height="13"><path d="M11 6H5a3 3 0 000 6h4M11 6l2-2M11 6l2 2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                      </button>
                    </div>
                  </div>

                  <!-- Editor -->
                  <EditorContent :editor="editor" class="editor-content" />
                  <span v-if="form.errors.content" class="form-error p12">{{ form.errors.content }}</span>
                </div>
              </div>

            </div>

            <!-- ══ Sidebar Column ══ -->
            <div class="col-side">

              <!-- Publish card -->
              <div class="card">
                <div class="card-header"><h4 class="card-title">Publish</h4></div>
                <div class="card-body">
                  <!-- Status toggle -->
                  <div class="form-group">
                    <label class="form-label">Status</label>
                    <div class="status-toggle">
                      <button
                        type="button"
                        :class="['toggle-opt', form.status === 'draft' ? 'toggle-active-draft' : '']"
                        @click="form.status = 'draft'"
                      >Draft</button>
                      <button
                        type="button"
                        :class="['toggle-opt', form.status === 'published' ? 'toggle-active-pub' : '']"
                        @click="form.status = 'published'"
                      >Published</button>
                    </div>
                  </div>

                  <!-- Featured -->
                  <div class="form-group mt-14">
                    <label class="checkbox-row">
                      <input type="checkbox" v-model="form.is_featured" class="checkbox-input" />
                      <span class="checkbox-label">Featured Article</span>
                      <span class="checkbox-hint">Shows as editor's pick on the insights page</span>
                    </label>
                  </div>

                  <!-- Submit buttons -->
                  <div class="pub-actions">
                    <button type="submit" class="btn-publish" :disabled="submitting">
                      <svg viewBox="0 0 14 14" fill="none" width="12" height="12"><path d="M1 7l4 4 8-8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                      <span>{{ submitting ? 'Saving…' : (isEdit ? 'Update Post' : 'Save Post') }}</span>
                    </button>
                    <Link href="/admin/blog/posts" class="btn-cancel">Cancel</Link>
                  </div>
                </div>
              </div>

              <!-- Category -->
              <div class="card">
                <div class="card-header"><h4 class="card-title">Category</h4></div>
                <div class="card-body">
                  <div class="form-group">
                    <select v-model="form.blog_category_id" class="form-select" :class="{ error: form.errors.blog_category_id }">
                      <option :value="null">— Uncategorised —</option>
                      <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                    </select>
                    <span v-if="form.errors.blog_category_id" class="form-error">{{ form.errors.blog_category_id }}</span>
                  </div>
                </div>
              </div>

              <!-- Meta -->
              <div class="card">
                <div class="card-header"><h4 class="card-title">Post Details</h4></div>
                <div class="card-body">
                  <div class="form-group">
                    <label class="form-label">Author Name <span class="required">*</span></label>
                    <input v-model="form.author_name" type="text" class="form-input" :class="{ error: form.errors.author_name }" placeholder="BGC Editorial" />
                    <span v-if="form.errors.author_name" class="form-error">{{ form.errors.author_name }}</span>
                  </div>
                  <div class="form-group mt-14">
                    <label class="form-label">Read Time</label>
                    <input v-model="form.read_time" type="text" class="form-input" placeholder="e.g. 8 min read" />
                  </div>
                </div>
              </div>

              <!-- Featured Image -->
              <div class="card">
                <div class="card-header"><h4 class="card-title">Featured Image</h4></div>
                <div class="card-body">
                  <!-- Preview existing image -->
                  <div v-if="imagePreview || post?.featured_image_url" class="image-preview-wrap">
                    <img :src="imagePreview || post.featured_image_url" alt="Featured Image" class="image-preview" />
                    <button type="button" @click="removeImage" class="image-remove">
                      <svg viewBox="0 0 12 12" fill="none" width="10" height="10"><path d="M1 1l10 10M11 1L1 11" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
                    </button>
                  </div>

                  <label v-else class="image-upload-zone">
                    <svg viewBox="0 0 32 32" fill="none" width="28" height="28"><rect x="2" y="6" width="28" height="20" rx="2" stroke="currentColor" stroke-width="1.2"/><circle cx="10" cy="13" r="2.5" stroke="currentColor" stroke-width="1.2"/><path d="M2 23l7-7 5 5 5-6 6 8" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span>Click to upload image</span>
                    <span class="upload-hint">JPG, PNG, GIF up to 2MB</span>
                    <input type="file" accept="image/*" class="hidden-file" @change="handleFeaturedImage" />
                  </label>
                  <span v-if="form.errors.featured_image" class="form-error">{{ form.errors.featured_image }}</span>
                </div>
              </div>

              <!-- SEO -->
              <div class="card">
                <div class="card-header seo-header">
                  <h4 class="card-title">SEO &amp; Meta</h4>
                  <span class="seo-badge">Search Engine</span>
                </div>
                <div class="card-body">

                  <div class="form-group">
                    <label class="form-label">
                      Meta Title
                      <span class="label-counter" :class="{ 'counter-warn': form.meta_title?.length > 60 }">
                        {{ form.meta_title?.length ?? 0 }}/160
                      </span>
                    </label>
                    <input
                      v-model="form.meta_title"
                      type="text"
                      class="form-input"
                      :class="{ error: form.errors.meta_title }"
                      placeholder="Defaults to post title if empty"
                      maxlength="160"
                    />
                    <span class="form-hint">Ideal: 50–60 characters</span>
                    <span v-if="form.errors.meta_title" class="form-error">{{ form.errors.meta_title }}</span>
                  </div>

                  <div class="form-group mt-14">
                    <label class="form-label">
                      Meta Description
                      <span class="label-counter" :class="{ 'counter-warn': form.meta_description?.length > 155 }">
                        {{ form.meta_description?.length ?? 0 }}/320
                      </span>
                    </label>
                    <textarea
                      v-model="form.meta_description"
                      class="form-textarea"
                      :class="{ error: form.errors.meta_description }"
                      rows="3"
                      placeholder="Defaults to excerpt if empty"
                      maxlength="320"
                    ></textarea>
                    <span class="form-hint">Ideal: 120–155 characters</span>
                    <span v-if="form.errors.meta_description" class="form-error">{{ form.errors.meta_description }}</span>
                  </div>

                  <div class="form-group mt-14">
                    <label class="form-label">Meta Keywords</label>
                    <input
                      v-model="form.meta_keywords"
                      type="text"
                      class="form-input"
                      :class="{ error: form.errors.meta_keywords }"
                      placeholder="governance, policy, india (comma-separated)"
                    />
                    <span class="form-hint">Separate with commas</span>
                  </div>

                  <div class="form-group mt-14">
                    <label class="form-label">OG Image URL</label>
                    <input
                      v-model="form.og_image"
                      type="text"
                      class="form-input"
                      placeholder="https://… (defaults to featured image)"
                    />
                    <span class="form-hint">Overrides the Open Graph / Twitter card image</span>
                  </div>

                  <div class="form-group mt-14">
                    <label class="form-label">Canonical URL</label>
                    <input
                      v-model="form.canonical_url"
                      type="url"
                      class="form-input"
                      :class="{ error: form.errors.canonical_url }"
                      placeholder="https://bharatcouncil.org/insights/…"
                    />
                    <span class="form-hint">Only set if this post is a duplicate of another URL</span>
                    <span v-if="form.errors.canonical_url" class="form-error">{{ form.errors.canonical_url }}</span>
                  </div>

                  <!-- Live SERP preview -->
                  <div class="serp-preview mt-14">
                    <div class="serp-label">SERP Preview</div>
                    <div class="serp-title">{{ form.meta_title || form.title || 'Post Title' }}</div>
                    <div class="serp-url">bharatcouncil.org › insights › {{ form.slug || 'post-slug' }}</div>
                    <div class="serp-desc">{{ form.meta_description || form.excerpt || 'Meta description will appear here…' }}</div>
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
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { Link, router, useForm } from '@inertiajs/vue3'
import { navItems } from '../../navItems.js'
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Underline from '@tiptap/extension-underline'
import Image from '@tiptap/extension-image'
import TipLink from '@tiptap/extension-link'
import TextAlign from '@tiptap/extension-text-align'
import Placeholder from '@tiptap/extension-placeholder'

const props = defineProps({
  admin:      Object,
  post:       Object,
  categories: Array,
})

const mounted          = ref(false)
const sidebarCollapsed = ref(false)
const submitting       = ref(false)
const imagePreview     = ref(null)
const isEdit           = computed(() => !!props.post)

const form = useForm({
  title:            props.post?.title            ?? '',
  slug:             props.post?.slug             ?? '',
  blog_category_id: props.post?.blog_category_id ?? null,
  excerpt:          props.post?.excerpt          ?? '',
  content:          props.post?.content          ?? '',
  author_name:      props.post?.author_name      ?? 'BGC Editorial',
  read_time:        props.post?.read_time         ?? '',
  status:           props.post?.status           ?? 'draft',
  is_featured:      props.post?.is_featured      ?? false,
  featured_image:   null,
  _remove_image:    false,
  // SEO
  meta_title:       props.post?.meta_title       ?? '',
  meta_description: props.post?.meta_description ?? '',
  meta_keywords:    props.post?.meta_keywords    ?? '',
  og_image:         props.post?.og_image         ?? '',
  canonical_url:    props.post?.canonical_url    ?? '',
})

// ── TipTap Editor ──────────────────────────────────────────
const editor = useEditor({
  content: props.post?.content ?? '',
  extensions: [
    StarterKit,
    Underline,
    TextAlign.configure({ types: ['heading', 'paragraph'] }),
    Image.configure({ allowBase64: false, inline: false }),
    TipLink.configure({ openOnClick: false }),
    Placeholder.configure({ placeholder: 'Start writing your article here…' }),
  ],
  onUpdate({ editor }) {
    form.content = editor.getHTML()
  },
})

// ── Slug auto-generation ───────────────────────────────────
function autoSlug() {
  if (!isEdit.value) {
    form.slug = form.title
      .toLowerCase().trim()
      .replace(/[^a-z0-9\s-]/g, '')
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-')
  }
}

// ── Featured image ─────────────────────────────────────────
function handleFeaturedImage(e) {
  const file = e.target.files[0]
  if (!file) return
  form.featured_image = file
  imagePreview.value  = URL.createObjectURL(file)
}

function removeImage() {
  form.featured_image  = null
  form._remove_image   = true
  imagePreview.value   = null
}

// ── Link helper ────────────────────────────────────────────
function setLink() {
  const prev = editor.value.getAttributes('link').href
  const url  = window.prompt('Enter URL', prev)
  if (url === null) return
  if (url === '') {
    editor.value.chain().focus().extendMarkRange('link').unsetLink().run()
  } else {
    editor.value.chain().focus().extendMarkRange('link').setLink({ href: url }).run()
  }
}

function insertImageUrl() {
  const url = window.prompt('Image URL')
  if (url) editor.value.chain().focus().setImage({ src: url }).run()
}

// ── Upload image into editor via API ──────────────────────
async function uploadEditorImage(e) {
  const file = e.target.files[0]
  if (!file) return
  const fd = new FormData()
  fd.append('image', file)
  const res = await fetch('/admin/blog/posts/upload-image', {
    method:  'POST',
    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '' },
    body:    fd,
  })
  const data = await res.json()
  if (data.url) editor.value.chain().focus().setImage({ src: data.url }).run()
  e.target.value = ''
}

// ── Form submit ────────────────────────────────────────────
function submit() {
  submitting.value = true
  const url = isEdit.value
    ? `/admin/blog/posts/${props.post.id}`
    : '/admin/blog/posts'

  form.transform((data) => {
    const fd = new FormData()
    Object.entries(data).forEach(([key, val]) => {
      if (val === null || val === undefined) return
      if (typeof val === 'boolean') { fd.append(key, val ? '1' : '0') }
      else { fd.append(key, val) }
    })
    if (isEdit.value) fd.append('_method', 'PUT')
    return fd
  }).post(url, {
    onFinish: () => { submitting.value = false },
  })
}

function logout() { router.post('/admin/logout') }

onMounted(() => requestAnimationFrame(() => setTimeout(() => { mounted.value = true }, 60)))
onBeforeUnmount(() => editor.value?.destroy())
</script>

<style>
/* TipTap placeholder */
.tiptap p.is-editor-empty:first-child::before {
  color: #a0abc0;
  content: attr(data-placeholder);
  float: left;
  height: 0;
  pointer-events: none;
}
/* TipTap base prose */
.editor-content .tiptap {
  outline: none;
  min-height: 340px;
  padding: 20px 24px;
  font-family: 'DM Sans', sans-serif;
  font-size: 14px;
  line-height: 1.7;
  color: #2a3a52;
}
.editor-content .tiptap h2 { font-size: 1.3em; font-weight: 700; margin: 1.2em 0 .5em; color: #0b1c38; }
.editor-content .tiptap h3 { font-size: 1.1em; font-weight: 700; margin: 1em 0 .4em; color: #0b1c38; }
.editor-content .tiptap h4 { font-size: 1em;   font-weight: 700; margin: .9em 0 .4em; color: #0b1c38; }
.editor-content .tiptap p  { margin: .6em 0; }
.editor-content .tiptap ul, .editor-content .tiptap ol { padding-left: 1.4em; margin: .6em 0; }
.editor-content .tiptap li { margin: .25em 0; }
.editor-content .tiptap blockquote {
  border-left: 3px solid #c9a84c;
  padding: 8px 16px;
  margin: 1em 0;
  background: rgba(201,168,76,.05);
  font-style: italic;
  color: #5a6a82;
}
.editor-content .tiptap code {
  background: #f0f2f5;
  padding: 2px 6px;
  font-family: 'DM Mono', monospace;
  font-size: .85em;
}
.editor-content .tiptap pre {
  background: #0b1c38;
  color: #c9a84c;
  padding: 16px;
  font-family: 'DM Mono', monospace;
  font-size: .85em;
  overflow-x: auto;
  margin: 1em 0;
}
.editor-content .tiptap pre code { background: none; padding: 0; color: inherit; }
.editor-content .tiptap hr { border: none; border-top: 1px solid rgba(11,28,56,.12); margin: 1.5em 0; }
.editor-content .tiptap a { color: #c9a84c; text-decoration: underline; }
.editor-content .tiptap img { max-width: 100%; height: auto; margin: 1em 0; display: block; }
</style>

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

/* ── Grid layout ── */
.form-grid{display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;}
@media(max-width:1100px){.form-grid{grid-template-columns:1fr;}.col-side{display:grid;grid-template-columns:1fr 1fr;gap:16px;}}
@media(max-width:640px){.col-side{grid-template-columns:1fr;}}

/* ── Cards ── */
.card{background:#fff;border:1px solid rgba(11,28,56,.07);box-shadow:0 2px 10px rgba(11,28,56,.04);margin-bottom:16px;}
.card-header{padding:16px 20px;border-bottom:1px solid rgba(11,28,56,.07);}
.card-title{font-family:'Cormorant Garamond',serif;font-size:15px;font-weight:600;color:#0b1c38;}
.card-body{padding:20px;}
.card-body.p0{padding:0;}
.col-side .card{margin-bottom:14px;}

/* ── Title input ── */
.title-input{width:100%;padding:8px 0;border:none;border-bottom:2px solid rgba(11,28,56,.12);font-family:'Cormorant Garamond',serif;font-size:26px;font-weight:600;color:#0b1c38;outline:none;background:transparent;transition:border-color .2s;}
.title-input:focus{border-color:#c9a84c;}
.title-input.error{border-color:#e74c3c;}
.title-input::placeholder{color:#c0c8d4;}

/* ── Form elements ── */
.mt-12{margin-top:12px;}
.mt-14{margin-top:14px;}
.form-group{display:flex;flex-direction:column;gap:5px;}
.form-label{font-size:10px;font-weight:700;color:#0b1c38;letter-spacing:.12em;text-transform:uppercase;}
.required{color:#e74c3c;}
.form-input{padding:9px 12px;border:1px solid rgba(11,28,56,.15);background:#fff;font-size:13px;font-family:'DM Sans',sans-serif;color:#0b1c38;outline:none;width:100%;transition:border-color .2s,box-shadow .2s;}
.form-input:focus{border-color:#c9a84c;box-shadow:0 0 0 3px rgba(201,168,76,.1);}
.form-input.error{border-color:#e74c3c;}
.form-input.with-prefix{border-left:none;flex:1;}
.form-select{width:100%;padding:9px 12px;border:1px solid rgba(11,28,56,.15);background:#fff;font-size:13px;font-family:'DM Sans',sans-serif;color:#0b1c38;outline:none;cursor:pointer;}
.form-select:focus{border-color:#c9a84c;}
.form-textarea{width:100%;padding:10px 12px;border:1px solid rgba(11,28,56,.15);background:#fff;font-size:13px;font-family:'DM Sans',sans-serif;color:#0b1c38;outline:none;resize:vertical;transition:border-color .2s;line-height:1.6;}
.form-textarea:focus{border-color:#c9a84c;box-shadow:0 0 0 3px rgba(201,168,76,.1);}
.input-prefix-wrap{display:flex;}
.input-prefix{display:flex;align-items:center;padding:9px 12px;background:#fafbfc;border:1px solid rgba(11,28,56,.15);border-right:none;font-size:11px;color:#8a9bbf;font-family:'DM Mono',monospace;white-space:nowrap;}
.char-count{font-size:10px;color:#a0abc0;text-align:right;margin-top:4px;}
.form-error{font-size:11px;color:#e74c3c;}
.form-error.p12{padding:8px 12px;}

/* ── Editor toolbar ── */
.editor-toolbar{display:flex;align-items:center;flex-wrap:wrap;gap:2px;padding:10px 12px;border-bottom:1px solid rgba(11,28,56,.08);background:#fafbfc;}
.toolbar-group{display:flex;align-items:center;gap:1px;}
.toolbar-sep{width:1px;height:20px;background:rgba(11,28,56,.1);margin:0 6px;}
.tb-btn{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;padding:0;background:none;border:1px solid transparent;color:#5a6a82;cursor:pointer;transition:background .15s,color .15s,border-color .15s;}
.tb-btn:hover{background:rgba(11,28,56,.06);color:#0b1c38;}
.tb-btn.tb-active{background:rgba(201,168,76,.15);color:#9a7a2e;border-color:rgba(201,168,76,.3);}
.tb-text{font-size:11px;font-weight:700;font-family:'DM Sans',sans-serif;width:auto;padding:0 8px;}
.hidden-file{display:none;}

/* ── Status toggle ── */
.status-toggle{display:flex;border:1px solid rgba(11,28,56,.15);overflow:hidden;}
.toggle-opt{flex:1;padding:9px;font-size:12px;font-weight:600;font-family:'DM Sans',sans-serif;background:none;border:none;cursor:pointer;color:#8a9bbf;transition:background .15s,color .15s;}
.toggle-opt:not(:last-child){border-right:1px solid rgba(11,28,56,.15);}
.toggle-active-draft{background:#fafbfc;color:#5a6a82;}
.toggle-active-pub{background:rgba(39,174,96,.1);color:#27ae60;}

/* ── Checkbox ── */
.checkbox-row{display:flex;flex-wrap:wrap;align-items:flex-start;gap:8px;cursor:pointer;}
.checkbox-input{width:15px;height:15px;accent-color:#c9a84c;margin-top:2px;flex-shrink:0;}
.checkbox-label{font-size:13px;color:#0b1c38;font-weight:500;}
.checkbox-hint{width:100%;font-size:11px;color:#8a9bbf;margin-left:23px;}

/* ── Publish actions ── */
.pub-actions{display:flex;flex-direction:column;gap:8px;margin-top:18px;}
.btn-publish{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:11px;background:#0b1c38;color:#c9a84c;border:1px solid rgba(201,168,76,.3);font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;cursor:pointer;transition:background .2s;}
.btn-publish:hover:not(:disabled){background:#162d55;}
.btn-publish:disabled{opacity:.6;cursor:not-allowed;}
.btn-cancel{display:flex;align-items:center;justify-content:center;width:100%;padding:10px;background:none;border:1px solid rgba(11,28,56,.12);color:#8a9bbf;font-size:12px;text-decoration:none;text-align:center;transition:border-color .2s;}
.btn-cancel:hover{border-color:rgba(11,28,56,.3);}

/* ── Featured image ── */
.image-upload-zone{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;padding:24px;border:2px dashed rgba(11,28,56,.15);background:#fafbfc;cursor:pointer;transition:border-color .2s;color:#8a9bbf;font-size:12px;text-align:center;}
.image-upload-zone:hover{border-color:#c9a84c;color:#9a7a2e;}
.upload-hint{font-size:10px;color:#a0abc0;}
.image-preview-wrap{position:relative;display:inline-block;width:100%;}
.image-preview{width:100%;height:140px;object-fit:cover;display:block;border:1px solid rgba(11,28,56,.1);}
.image-remove{position:absolute;top:6px;right:6px;width:24px;height:24px;background:rgba(231,76,60,.9);border:none;color:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background .15s;}
.image-remove:hover{background:#c0392b;}

/* ── SEO card ── */
.seo-header{display:flex;align-items:center;justify-content:space-between;}
.seo-badge{font-size:9px;font-weight:700;letter-spacing:.18em;text-transform:uppercase;color:#2980b9;background:rgba(41,128,185,.1);padding:3px 8px;border:1px solid rgba(41,128,185,.2);}
.label-counter{float:right;font-size:10px;font-weight:400;color:#a0abc0;text-transform:none;letter-spacing:0;font-family:'DM Mono',monospace;}
.counter-warn{color:#e07b39;}

/* ── SERP preview ── */
.serp-preview{background:#fafbfc;border:1px solid rgba(11,28,56,.08);padding:14px 16px;}
.serp-label{font-size:9px;font-weight:700;color:#a0abc0;letter-spacing:.2em;text-transform:uppercase;margin-bottom:10px;}
.serp-title{font-size:14px;font-weight:600;color:#1a0dab;line-height:1.3;margin-bottom:3px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
.serp-url{font-size:11px;color:#006621;margin-bottom:4px;font-family:'DM Mono',monospace;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
.serp-desc{font-size:12px;color:#545454;line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
</style>
