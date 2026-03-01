<template>
  <Head>
    <title>{{ pageTitle }}</title>
    <meta name="description" :content="pageDescription" />
    <meta property="og:title" :content="pageTitle" />
    <meta property="og:description" :content="pageDescription" />
    <meta property="og:type" content="article" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" :content="pageTitle" />
    <meta name="twitter:description" :content="pageDescription" />
  </Head>
  <div class="page-root">

    <!-- Reading progress bar -->
    <div class="reading-progress">
      <div class="reading-progress-fill" :style="{ width: progress + '%' }"/>
    </div>

    <AppHeader />
    <main>
      <ArticleHero />
      <ArticleBody />
      <RelatedArticles />
    </main>
    <AppFooter />
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import AppHeader       from '@/Components/AppHeader.vue'
import ArticleHero     from './Components/ArticleHero.vue'
import ArticleBody     from './Components/ArticleBody.vue'
import RelatedArticles from './Components/RelatedArticles.vue'
import AppFooter       from '@/Components/AppFooter.vue'

const props = defineProps({ slug: String })

const progress = ref(0)

const pageTitle = computed(() => {
  if (!props.slug) return 'Insights | Bharat Governance Council'
  const readable = props.slug.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase())
  return `${readable} | Bharat Governance Council`
})

const pageDescription = computed(() =>
  'Read the latest policy analysis and research from the Bharat Governance Council on governance, institutional reform, and public policy in India.'
)

function updateProgress() {
  const scrollTop  = window.scrollY
  const docHeight  = document.documentElement.scrollHeight - window.innerHeight
  progress.value   = docHeight > 0 ? Math.min((scrollTop / docHeight) * 100, 100) : 0
}

onMounted(() => window.addEventListener('scroll', updateProgress, { passive: true }))
onUnmounted(() => window.removeEventListener('scroll', updateProgress))
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap');

:root {
  --navy:    #0b1c38;
  --navy-2:  #0f2347;
  --navy-3:  #162d55;
  --gold:    #c9a84c;
  --gold-lt: #e8cf8a;
  --silver:  #b8c5d8;
  --white:   #f5f7fa;
  --grey-1:  #e8eaf0;
  --grey-2:  #8a9bbf;
  --body-bg: #f2f4f8;
}

html { scroll-behavior: smooth; }

body {
  font-family: 'DM Sans', sans-serif;
  background: var(--body-bg);
  color: var(--navy);
  overflow-x: hidden;
}

::-webkit-scrollbar { width: 5px; }
::-webkit-scrollbar-track { background: var(--navy); }
::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 2px; }

* { box-sizing: border-box; margin: 0; padding: 0; }
</style>

<style scoped>
.page-root { min-height: 100vh; }

/* Reading progress bar — sits right below the fixed nav */
.reading-progress {
  position: fixed;
  top: 72px;
  left: 0; right: 0;
  height: 2px;
  background: rgba(201,168,76,0.12);
  z-index: 199;
  pointer-events: none;
}
.reading-progress-fill {
  height: 100%;
  background: linear-gradient(90deg, #c9a84c, #e8cf8a);
  transition: width 0.1s linear;
  box-shadow: 0 0 6px rgba(201,168,76,0.5);
}
</style>
