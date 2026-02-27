<template>
  <section class="article-body-section" ref="sectionEl">

    <!-- SVG bg texture -->
    <svg class="body-bg-svg" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <pattern id="ab-dots" width="36" height="36" patternUnits="userSpaceOnUse">
          <circle cx="1" cy="1" r="0.65" fill="rgba(11,28,56,0.045)"/>
        </pattern>
      </defs>
      <rect width="1440" height="900" fill="url(#ab-dots)"/>
    </svg>

    <div class="ab-container">

      <!-- ── Main grid: article + sidebar ── -->
      <div class="ab-grid">

        <!-- ═══════════════ ARTICLE PROSE ═══════════════ -->
        <article class="article-prose" :class="{ visible: revealed }">

          <!-- Lead paragraph -->
          <p class="lead-para">
            India's federal architecture is undergoing its most consequential stress test since
            the constitutional reforms of the early 1990s. As the 16th Finance Commission begins
            its deliberations, it inherits a system where the vertical imbalance between Union
            and state governments has deepened structurally — and where the principle of
            cooperative federalism increasingly strains against fiscal realities.
          </p>

          <!-- Key Findings box -->
          <div class="key-findings-box">
            <div class="kf-header">
              <span class="kf-icon">◈</span>
              <h4>Key Findings</h4>
            </div>
            <ul class="kf-list">
              <li>States account for over 62% of total government expenditure, yet retain access to only 41% of combined tax revenues before transfers.</li>
              <li>The post-GST consolidation of indirect taxation has materially reduced states' independent revenue-raising capacity.</li>
              <li>Tied grants and Centrally Sponsored Schemes constitute nearly 35% of all central transfers, undermining genuine fiscal autonomy.</li>
              <li>Seven high-burden states — home to 40% of India's population — are systematically under-resourced relative to their developmental needs.</li>
              <li>The 16th Finance Commission must rethink both the vertical share and the conditionality architecture of central transfers.</li>
            </ul>
          </div>

          <!-- Section 1 -->
          <h2 id="section-context" class="article-h2">
            <span class="h2-num">01</span>
            The Historical Context of Fiscal Federalism
          </h2>
          <p>
            India's approach to fiscal federalism has always been a negotiated compromise between
            centralisation for macroeconomic efficiency and decentralisation for local
            accountability. The original constitution concentrated fiscal power at the Centre —
            a deliberate choice reflecting post-independence anxieties about national cohesion
            and the imperatives of planned industrialisation.
          </p>
          <p>
            The Finance Commission, established under Article 280, was designed as the primary
            institutional mechanism to correct this vertical imbalance through periodic devolution
            of central taxes to states. Over fifteen commissions spanning seven decades, this
            mechanism has broadly functioned — though not without tensions. The 14th Finance
            Commission's landmark decision to raise the states' share of the divisible pool from
            32% to 42% was widely celebrated as a move toward genuine fiscal federalism. The 15th
            Commission subsequently moderated this slightly to 41%, citing national defence needs.
          </p>
          <p>
            What has changed dramatically, however, is the composition and conditionality of
            transfers. As the Union's expenditure commitments have grown — through national
            programmes, defence modernisation, and debt servicing — the degree to which central
            transfers come attached with conditions and earmarks has multiplied. States are
            increasingly becoming implementing agencies for Union priorities rather than
            autonomous fiscal actors pursuing local development mandates.
          </p>

          <!-- Section 2 -->
          <h2 id="section-gst" class="article-h2">
            <span class="h2-num">02</span>
            How GST Reshaped the Fiscal Landscape
          </h2>
          <p>
            No single fiscal event has reshaped the Centre-state financial relationship as
            fundamentally as the introduction of the Goods and Services Tax in July 2017.
            While GST was rightly celebrated as India's most ambitious tax reform — eliminating
            the cascading effect of multiple levies and creating a genuine common market — its
            design contained embedded tensions for state fiscal autonomy.
          </p>

          <!-- Pull quote -->
          <blockquote class="pull-quote">
            <div class="pq-bar"/>
            <p>"The architecture of fiscal federalism must evolve from a transactional
            transfer system into a genuine partnership — one that trusts states as the
            primary providers of public services."</p>
            <cite>— 15th Finance Commission Dissent Note, 2021</cite>
          </blockquote>

          <p>
            States surrendered their most productive own-tax instrument — VAT on goods — in
            exchange for guaranteed compensation for five years and a share of GST revenues.
            When the compensation period ended in June 2022, several states found themselves
            exposed: GST revenues had underperformed projections, compensation had plugged the
            gap, and states now faced a structural revenue shortfall without a corresponding
            reduction in expenditure mandates. The pending compensation backlog remains a source
            of significant Centre-state friction.
          </p>

          <!-- Data callout stats -->
          <div class="data-callout">
            <div class="dc-header">
              <span class="dc-label">At a Glance</span>
              <span class="dc-rule"/>
            </div>
            <div class="dc-stats">
              <div v-for="stat in dataStats" :key="stat.label" class="dc-stat">
                <span class="dc-num">{{ stat.num }}</span>
                <span class="dc-desc">{{ stat.desc }}</span>
              </div>
            </div>
          </div>

          <!-- Section 3 -->
          <h2 id="section-commission" class="article-h2">
            <span class="h2-num">03</span>
            The 16th Finance Commission's Mandate
          </h2>
          <p>
            The 16th Finance Commission, constituted in December 2023 under the chairmanship
            of Dr. Arvind Panagariya, faces a more complex mandate than its predecessors.
            It must simultaneously address the post-GST revenue architecture, the consequences
            of elevated Union borrowing during the pandemic, growing disparities between
            high-income and low-income states, and the demands of climate-linked public
            expenditure — all while maintaining macroeconomic stability.
          </p>
          <p>
            The Commission's Terms of Reference are broader than usual. For the first time,
            the ToR explicitly asks the Commission to consider the fiscal implications of
            Disaster Risk Management and climate change adaptation — reflecting the growing
            recognition that environmental shocks are becoming a significant source of state
            fiscal stress. Cyclone-affected coastal states and drought-prone agricultural states
            now carry contingent liabilities that formal fiscal frameworks have never adequately
            addressed.
          </p>

          <!-- Inline blockquote -->
          <div class="inline-note">
            <div class="note-bar"/>
            <div class="note-content">
              <span class="note-label">Key Question</span>
              <p>Can a constitutionally-mandated body with a five-year horizon adequately address structural challenges that have accumulated over decades — and that require sustained institutional reform rather than periodic recalibration?</p>
            </div>
          </div>

          <!-- Section 4 -->
          <h2 id="section-recommendations" class="article-h2">
            <span class="h2-num">04</span>
            Recommendations
          </h2>
          <p>
            Based on our analysis of inter-governmental fiscal flows, state fiscal capacity
            assessments across fifteen states, and review of submissions to the 16th Finance
            Commission, we propose five structural interventions:
          </p>
          <ol class="article-ol">
            <li>
              <strong>Raise the vertical devolution share to 45%</strong> of the divisible
              pool, reversing the marginal reduction introduced by the 15th Commission and
              aligning with the developmental expenditure reality of states.
            </li>
            <li>
              <strong>Introduce a Development Equity Index</strong> as a horizontal devolution
              criterion, weighting allocations toward states with lower per-capita public
              service capacity — moving beyond GDP proxies that entrench existing disparities.
            </li>
            <li>
              <strong>Replace tied Centrally Sponsored Schemes</strong> with formula-based
              sector block grants, retaining only those schemes where genuine national externalities
              justify central conditionality. Ministries should be required to justify continued
              tying beyond each Commission period.
            </li>
            <li>
              <strong>Establish a permanent Centre-State Fiscal Compact</strong> — a standing
              joint committee of the Finance Ministry and state finance ministers that meets
              biannually between Commission cycles to address in-year fiscal stress and prevent
              the accumulation of compensation backlogs.
            </li>
            <li>
              <strong>Create a Climate Fiscal Risk Buffer</strong> for states, funded through
              a dedicated cess or borrowing headroom enhancement, specifically earmarked for
              climate adaptation and disaster-related expenditure overruns.
            </li>
          </ol>

          <!-- Section 5 / Conclusion -->
          <h2 id="section-conclusion" class="article-h2">
            <span class="h2-num">05</span>
            Conclusion
          </h2>
          <p>
            The 16th Finance Commission has an opportunity to reset the terms of India's
            fiscal federalism for a generation. But the changes required go beyond incremental
            adjustments to devolution formulae. What is needed is a philosophical shift —
            from a system in which states are seen as subordinate beneficiaries of Union
            largesse, to one in which they are treated as co-sovereign fiscal actors with
            the resources and autonomy commensurate with their constitutional responsibilities.
          </p>
          <p>
            India's states deliver the bulk of welfare services — schools, hospitals, rural
            employment, and urban infrastructure. Their fiscal health is not a peripheral
            concern; it is a central determinant of whether India's development aspirations
            are realised in the districts and villages where 1.4 billion people live. The
            Commission must rise to this moment.
          </p>

          <!-- Article footer -->
          <div class="article-footer-meta">
            <div class="af-divider"/>
            <div class="af-row">
              <div class="af-author-block">
                <div class="af-avatar">PM</div>
                <div class="af-author-info">
                  <span class="af-name">Dr. Priya Menon</span>
                  <span class="af-bio">Senior Fellow, Economic Policy at the Bharat Governance Council. Former advisor to the 15th Finance Commission. PhD in Public Finance, JNU.</span>
                </div>
              </div>
              <div class="af-share">
                <span class="af-share-label">Share</span>
                <a v-for="s in shareLinks" :key="s.label" href="#" class="af-share-btn" :title="s.label">
                  <span v-html="s.icon"/>
                </a>
              </div>
            </div>
          </div>

        </article>

        <!-- ═══════════════ SIDEBAR ═══════════════ -->
        <aside class="article-sidebar" :class="{ visible: revealed }">

          <!-- Author card -->
          <div class="sidebar-card">
            <div class="sb-section-label">Author</div>
            <div class="sb-author">
              <div class="sb-avatar">PM</div>
              <div class="sb-author-details">
                <h4>Dr. Priya Menon</h4>
                <p>Senior Fellow, Economic Policy</p>
              </div>
            </div>
            <p class="sb-author-bio">
              Former advisor to the 15th Finance Commission. Expert in fiscal federalism
              and public finance. PhD from JNU.
            </p>
            <div class="sb-author-social">
              <a href="#" class="sb-social-link" title="Twitter">
                <svg viewBox="0 0 20 20" fill="currentColor" width="12" height="12"><path d="M16.99 2h-2.77l-3.3 4.17L7.73 2H2l5.93 8.06L2.44 18h2.77l3.55-4.49L12.38 18H18l-6.13-8.27L16.99 2z"/></svg>
              </a>
              <a href="#" class="sb-social-link" title="LinkedIn">
                <svg viewBox="0 0 20 20" fill="currentColor" width="12" height="12"><path d="M5 3a2 2 0 110 4 2 2 0 010-4zm-2 6h4v8H3V9zm6 0h3.6v1.1h.05c.5-.95 1.73-1.95 3.55-1.95C18.96 8.15 19 10.42 19 13.04V17h-3.8v-3.3c0-1.44-.5-2.42-1.75-2.42-1.29 0-1.75.89-1.75 2.42V17H9V9z"/></svg>
              </a>
            </div>
          </div>

          <!-- Table of Contents -->
          <div class="sidebar-card sidebar-toc">
            <div class="sb-section-label">Contents</div>
            <nav>
              <ul class="toc-list">
                <li v-for="item in toc" :key="item.id">
                  <a :href="`#${item.id}`" class="toc-link">
                    <span class="toc-num">{{ item.num }}</span>
                    {{ item.title }}
                  </a>
                </li>
              </ul>
            </nav>
          </div>

          <!-- Topics -->
          <div class="sidebar-card">
            <div class="sb-section-label">Topics</div>
            <div class="sb-tags">
              <span v-for="tag in tags" :key="tag" class="sb-tag">{{ tag }}</span>
            </div>
          </div>

          <!-- Share -->
          <div class="sidebar-card sidebar-share-card">
            <div class="sb-section-label">Share Article</div>
            <div class="sb-share-btns">
              <a v-for="s in shareLinks" :key="s.label" href="#" class="sb-share-btn">
                <span v-html="s.icon"/>
                {{ s.label }}
              </a>
            </div>
          </div>

          <!-- Reading info -->
          <div class="sidebar-card reading-info-card">
            <div class="ri-row">
              <svg viewBox="0 0 16 16" fill="none" width="13" height="13" class="ri-icon">
                <circle cx="8" cy="8" r="6.5" stroke="currentColor" stroke-width="1.2"/>
                <path d="M8 4.5v4l2.5 1.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
              </svg>
              <span class="ri-label">14 min read</span>
            </div>
            <div class="ri-row">
              <svg viewBox="0 0 16 16" fill="none" width="13" height="13" class="ri-icon">
                <rect x="2" y="2" width="12" height="12" rx="1" stroke="currentColor" stroke-width="1.2"/>
                <path d="M5 7h6M5 10h4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
              </svg>
              <span class="ri-label">3,200 words</span>
            </div>
            <div class="ri-row">
              <svg viewBox="0 0 16 16" fill="none" width="13" height="13" class="ri-icon">
                <path d="M14 2.5 L10 6 M6 10 L2 13.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                <path d="M8 2l6 6-3.5 1.5L9 8l-1.5-1.5L9 3z" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/>
              </svg>
              <span class="ri-label">Peer reviewed</span>
            </div>
          </div>

        </aside>

      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const sectionEl = ref(null)
const revealed  = ref(false)

const toc = [
  { id: 'section-context',         num: '01', title: 'Historical Context'       },
  { id: 'section-gst',             num: '02', title: 'GST & the Fiscal Landscape'},
  { id: 'section-commission',      num: '03', title: '16th Finance Commission'   },
  { id: 'section-recommendations', num: '04', title: 'Recommendations'           },
  { id: 'section-conclusion',      num: '05', title: 'Conclusion'                },
]

const tags = [
  'Fiscal Policy', 'Federalism', 'Finance Commission',
  'GST', 'State Finances', 'Public Expenditure', 'Devolution',
]

const dataStats = [
  { num: '41%',       desc: 'States\' share of the divisible pool' },
  { num: '62%',       desc: 'States\' share of combined expenditure' },
  { num: '35%',       desc: 'Tied grants as % of total transfers' },
  { num: '₹2.69L Cr', desc: 'Pending GST compensation backlog' },
]

const shareLinks = [
  { label: 'Twitter / X',  icon: '<svg viewBox="0 0 20 20" fill="currentColor" width="12" height="12"><path d="M16.99 2h-2.77l-3.3 4.17L7.73 2H2l5.93 8.06L2.44 18h2.77l3.55-4.49L12.38 18H18l-6.13-8.27L16.99 2z"/></svg>' },
  { label: 'LinkedIn',     icon: '<svg viewBox="0 0 20 20" fill="currentColor" width="12" height="12"><path d="M5 3a2 2 0 110 4 2 2 0 010-4zm-2 6h4v8H3V9zm6 0h3.6v1.1h.05c.5-.95 1.73-1.95 3.55-1.95C18.96 8.15 19 10.42 19 13.04V17h-3.8v-3.3c0-1.44-.5-2.42-1.75-2.42-1.29 0-1.75.89-1.75 2.42V17H9V9z"/></svg>' },
  { label: 'WhatsApp',     icon: '<svg viewBox="0 0 20 20" fill="currentColor" width="12" height="12"><path d="M10 2C5.58 2 2 5.58 2 10c0 1.52.42 2.94 1.14 4.16L2 18l3.96-1.12A7.94 7.94 0 0010 18c4.42 0 8-3.58 8-8s-3.58-8-8-8zm3.7 10.7c-.17.48-.97.92-1.33.98-.34.05-.76.07-1.22-.08-.28-.09-.64-.22-1.1-.42-1.93-.83-3.19-2.78-3.29-2.91-.1-.13-.8-1.06-.8-2.02s.5-1.43.69-1.63c.18-.19.4-.24.53-.24l.38.01c.12 0 .29-.05.45.34.17.4.58 1.42.63 1.52.05.1.08.22.02.35-.07.13-.1.21-.2.32-.1.11-.21.24-.3.33-.1.1-.2.2-.09.4.12.2.52.85 1.12 1.38.77.68 1.42.9 1.62.99.2.09.32.08.44-.05.12-.13.5-.58.63-.78.13-.2.27-.17.45-.1.18.07 1.14.54 1.34.63.2.1.33.14.38.22.05.08.05.47-.12.95z"/></svg>' },
  { label: 'Copy Link',    icon: '<svg viewBox="0 0 20 20" fill="none" width="12" height="12"><path d="M8 12.5l4-5M9.5 14l-1.5 1.5a3.5 3.5 0 01-5-5L5 9M11 6.5l1-1a3.5 3.5 0 015 5L15.5 12" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>' },
]

let observer = null
onMounted(() => {
  observer = new IntersectionObserver(
    ([e]) => { if (e.isIntersecting) { revealed.value = true; observer.disconnect() } },
    { threshold: 0.04 }
  )
  if (sectionEl.value) observer.observe(sectionEl.value)
})
onUnmounted(() => observer?.disconnect())
</script>

<style scoped>
/* ── Section ────────────────────────────────── */
.article-body-section {
  position: relative;
  background: #f2f4f8;
  padding: 80px 0 96px;
  overflow: hidden;
}
.body-bg-svg {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}

.ab-container {
  position: relative;
  z-index: 2;
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 60px;
}

/* ── Two-column grid ──────────────────────── */
.ab-grid {
  display: grid;
  grid-template-columns: 1fr 300px;
  gap: 60px;
  align-items: start;
}

/* ═══════════════════════════════════════════
   ARTICLE PROSE
═══════════════════════════════════════════ */
.article-prose {
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.8s ease, transform 0.8s ease;
}
.article-prose.visible { opacity: 1; transform: translateY(0); }

/* Lead paragraph */
.lead-para {
  font-family: 'DM Sans', sans-serif;
  font-size: 19px;
  font-weight: 400;
  color: #0b1c38;
  line-height: 1.78;
  margin-bottom: 44px;
  padding-left: 20px;
  border-left: 3px solid #c9a84c;
}

/* Key Findings Box */
.key-findings-box {
  background: #0b1c38;
  border: 1px solid rgba(201,168,76,0.25);
  padding: 32px 36px;
  margin-bottom: 52px;
  position: relative;
  overflow: hidden;
}
.key-findings-box::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 2px;
  background: linear-gradient(90deg, #c9a84c, #e8cf8a, rgba(201,168,76,0.2));
}
.kf-header {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 20px;
}
.kf-icon {
  font-size: 14px;
  color: #c9a84c;
  letter-spacing: 0.1em;
}
.kf-header h4 {
  font-family: 'DM Sans', sans-serif;
  font-size: 10px;
  font-weight: 700;
  color: #c9a84c;
  letter-spacing: 0.3em;
  text-transform: uppercase;
}
.kf-list {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 12px;
}
.kf-list li {
  font-family: 'DM Sans', sans-serif;
  font-size: 14px;
  color: #b8c5d8;
  line-height: 1.65;
  padding-left: 20px;
  position: relative;
}
.kf-list li::before {
  content: '◇';
  position: absolute;
  left: 0;
  top: 1px;
  font-size: 8px;
  color: rgba(201,168,76,0.6);
}

/* Article H2 */
.article-h2 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 32px;
  font-weight: 600;
  color: #0b1c38;
  line-height: 1.15;
  margin-bottom: 22px;
  margin-top: 52px;
  display: flex;
  align-items: baseline;
  gap: 14px;
}
.h2-num {
  font-family: 'DM Mono', monospace;
  font-size: 11px;
  font-weight: 500;
  color: #c9a84c;
  letter-spacing: 0.1em;
  padding: 3px 8px;
  border: 1px solid rgba(201,168,76,0.3);
  flex-shrink: 0;
  position: relative;
  top: -2px;
}

/* Body paragraphs */
.article-prose p {
  font-family: 'DM Sans', sans-serif;
  font-size: 16px;
  font-weight: 300;
  color: #3a4a62;
  line-height: 1.85;
  margin-bottom: 22px;
}

/* Pull quote */
.pull-quote {
  margin: 44px 0;
  padding: 28px 36px;
  position: relative;
  background: #fff;
  border: 1px solid rgba(201,168,76,0.18);
  box-shadow: 0 4px 24px rgba(11,28,56,0.06);
}
.pq-bar {
  position: absolute;
  top: 0; left: 0;
  width: 4px; height: 100%;
  background: linear-gradient(to bottom, #c9a84c, #e8cf8a);
}
.pull-quote p {
  font-family: 'Cormorant Garamond', serif !important;
  font-size: 22px !important;
  font-weight: 500 !important;
  font-style: italic;
  color: #0b1c38 !important;
  line-height: 1.55 !important;
  margin-bottom: 14px !important;
}
.pull-quote cite {
  display: block;
  font-family: 'DM Mono', monospace;
  font-size: 11px;
  color: #8a9bbf;
  letter-spacing: 0.06em;
  font-style: normal;
}

/* Data callout */
.data-callout {
  background: #fff;
  border: 1px solid rgba(11,28,56,0.07);
  padding: 28px 32px;
  margin: 44px 0;
  box-shadow: 0 2px 16px rgba(11,28,56,0.05);
}
.dc-header {
  display: flex;
  align-items: center;
  gap: 14px;
  margin-bottom: 24px;
}
.dc-label {
  font-size: 9px;
  font-weight: 700;
  color: #c9a84c;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
  white-space: nowrap;
}
.dc-rule {
  flex: 1;
  height: 1px;
  background: linear-gradient(90deg, rgba(201,168,76,0.3), transparent);
}
.dc-stats {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 24px;
}
.dc-stat {
  display: flex;
  flex-direction: column;
  gap: 6px;
}
.dc-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 34px;
  font-weight: 700;
  color: #0b1c38;
  line-height: 1;
}
.dc-desc {
  font-size: 11px;
  color: #8a9bbf;
  line-height: 1.4;
  font-family: 'DM Sans', sans-serif;
}

/* Inline note */
.inline-note {
  display: flex;
  gap: 0;
  margin: 40px 0;
  background: rgba(201,168,76,0.05);
  border: 1px solid rgba(201,168,76,0.18);
}
.note-bar {
  width: 3px;
  background: linear-gradient(to bottom, #c9a84c, #e8cf8a);
  flex-shrink: 0;
}
.note-content {
  padding: 20px 24px;
}
.note-label {
  display: block;
  font-size: 9px;
  font-weight: 700;
  color: #c9a84c;
  letter-spacing: 0.28em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
  margin-bottom: 10px;
}
.note-content p {
  font-family: 'DM Sans', sans-serif;
  font-size: 14px;
  color: #4a5a74;
  line-height: 1.7;
  margin-bottom: 0 !important;
}

/* Ordered list */
.article-ol {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 18px;
  margin: 28px 0 40px;
  counter-reset: article-ol;
}
.article-ol li {
  counter-increment: article-ol;
  font-family: 'DM Sans', sans-serif;
  font-size: 15px;
  font-weight: 300;
  color: #3a4a62;
  line-height: 1.75;
  padding-left: 48px;
  position: relative;
}
.article-ol li::before {
  content: counter(article-ol, decimal-leading-zero);
  position: absolute;
  left: 0;
  top: 0;
  font-family: 'DM Mono', monospace;
  font-size: 11px;
  font-weight: 500;
  color: #c9a84c;
  background: rgba(201,168,76,0.1);
  border: 1px solid rgba(201,168,76,0.25);
  width: 30px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  letter-spacing: 0.04em;
}
.article-ol li strong {
  font-weight: 600;
  color: #0b1c38;
}

/* Article footer */
.article-footer-meta {
  margin-top: 64px;
}
.af-divider {
  height: 1px;
  background: linear-gradient(90deg, rgba(11,28,56,0.12), transparent);
  margin-bottom: 36px;
}
.af-row {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 32px;
  flex-wrap: wrap;
}
.af-author-block {
  display: flex;
  align-items: flex-start;
  gap: 16px;
  flex: 1;
}
.af-avatar {
  width: 52px; height: 52px;
  border-radius: 50%;
  background: rgba(201,168,76,0.12);
  border: 1.5px solid rgba(201,168,76,0.35);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Cormorant Garamond', serif;
  font-size: 18px;
  font-weight: 600;
  color: #c9a84c;
  flex-shrink: 0;
}
.af-author-info { display: flex; flex-direction: column; gap: 6px; }
.af-name {
  font-size: 16px;
  font-weight: 600;
  color: #0b1c38;
  font-family: 'DM Sans', sans-serif;
}
.af-bio {
  font-size: 13px;
  color: #6b7a94;
  line-height: 1.6;
  max-width: 420px;
  font-family: 'DM Sans', sans-serif;
}
.af-share {
  display: flex;
  align-items: center;
  gap: 8px;
  flex-shrink: 0;
}
.af-share-label {
  font-size: 9px;
  font-weight: 700;
  color: #8a9bbf;
  letter-spacing: 0.28em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}
.af-share-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 32px; height: 32px;
  background: rgba(11,28,56,0.06);
  border: 1px solid rgba(11,28,56,0.1);
  color: #8a9bbf;
  text-decoration: none;
  transition: background 0.2s, border-color 0.2s, color 0.2s, transform 0.2s;
}
.af-share-btn:hover {
  background: rgba(201,168,76,0.1);
  border-color: rgba(201,168,76,0.3);
  color: #c9a84c;
  transform: translateY(-2px);
}

/* ═══════════════════════════════════════════
   SIDEBAR
═══════════════════════════════════════════ */
.article-sidebar {
  position: sticky;
  top: calc(72px + 24px);
  display: flex;
  flex-direction: column;
  gap: 16px;
  opacity: 0;
  transform: translateX(16px);
  transition: opacity 0.8s ease 0.2s, transform 0.8s ease 0.2s;
}
.article-sidebar.visible { opacity: 1; transform: translateX(0); }

.sidebar-card {
  background: #fff;
  border: 1px solid rgba(11,28,56,0.07);
  padding: 22px 20px;
  box-shadow: 0 2px 12px rgba(11,28,56,0.04);
}

.sb-section-label {
  font-size: 9px;
  font-weight: 700;
  color: #c9a84c;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
  margin-bottom: 16px;
  display: flex;
  align-items: center;
  gap: 8px;
}
.sb-section-label::after {
  content: '';
  flex: 1;
  height: 1px;
  background: rgba(201,168,76,0.2);
}

/* Author card */
.sb-author {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 12px;
}
.sb-avatar {
  width: 40px; height: 40px;
  border-radius: 50%;
  background: rgba(201,168,76,0.12);
  border: 1px solid rgba(201,168,76,0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Cormorant Garamond', serif;
  font-size: 14px;
  font-weight: 600;
  color: #c9a84c;
  flex-shrink: 0;
}
.sb-author-details h4 {
  font-size: 14px;
  font-weight: 600;
  color: #0b1c38;
  font-family: 'DM Sans', sans-serif;
  margin-bottom: 2px;
}
.sb-author-details p {
  font-size: 11px;
  color: #8a9bbf;
  font-family: 'DM Mono', monospace;
}
.sb-author-bio {
  font-size: 12px;
  color: #6b7a94;
  line-height: 1.6;
  margin-bottom: 14px;
  font-family: 'DM Sans', sans-serif;
}
.sb-author-social {
  display: flex;
  gap: 6px;
}
.sb-social-link {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 28px; height: 28px;
  background: rgba(11,28,56,0.05);
  border: 1px solid rgba(11,28,56,0.08);
  color: #8a9bbf;
  text-decoration: none;
  transition: background 0.2s, color 0.2s, border-color 0.2s;
}
.sb-social-link:hover {
  background: rgba(201,168,76,0.1);
  border-color: rgba(201,168,76,0.3);
  color: #c9a84c;
}

/* TOC */
.toc-list {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 2px;
}
.toc-link {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 12px;
  color: #6b7a94;
  text-decoration: none;
  font-family: 'DM Sans', sans-serif;
  padding: 7px 0;
  border-bottom: 1px solid rgba(11,28,56,0.05);
  transition: color 0.2s, gap 0.2s;
}
.toc-link:hover { color: #0b1c38; gap: 14px; }
.toc-num {
  font-family: 'DM Mono', monospace;
  font-size: 9px;
  color: rgba(201,168,76,0.5);
  flex-shrink: 0;
}
.toc-link:hover .toc-num { color: #c9a84c; }

/* Tags */
.sb-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
}
.sb-tag {
  font-size: 9px;
  font-weight: 500;
  color: rgba(201,168,76,0.7);
  background: rgba(201,168,76,0.08);
  border: 1px solid rgba(201,168,76,0.2);
  padding: 4px 9px;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
  cursor: pointer;
  transition: background 0.2s, color 0.2s;
}
.sb-tag:hover {
  background: rgba(201,168,76,0.15);
  color: #c9a84c;
}

/* Share card */
.sb-share-btns {
  display: flex;
  flex-direction: column;
  gap: 6px;
}
.sb-share-btn {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  font-size: 11px;
  font-weight: 500;
  color: #6b7a94;
  text-decoration: none;
  padding: 8px 12px;
  background: rgba(11,28,56,0.03);
  border: 1px solid rgba(11,28,56,0.07);
  font-family: 'DM Sans', sans-serif;
  transition: color 0.2s, background 0.2s, border-color 0.2s;
}
.sb-share-btn:hover {
  color: #0b1c38;
  background: rgba(201,168,76,0.07);
  border-color: rgba(201,168,76,0.2);
}

/* Reading info */
.reading-info-card { padding: 16px 20px; }
.ri-row {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 6px 0;
  border-bottom: 1px solid rgba(11,28,56,0.05);
}
.ri-row:last-child { border-bottom: none; }
.ri-icon { color: #c9a84c; flex-shrink: 0; }
.ri-label {
  font-size: 12px;
  color: #6b7a94;
  font-family: 'DM Sans', sans-serif;
}

/* ═══════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════ */
@media (max-width: 1100px) {
  .ab-container { padding: 0 32px; }
  .ab-grid { grid-template-columns: 1fr 260px; gap: 40px; }
  .dc-stats { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 900px) {
  .ab-grid { grid-template-columns: 1fr; }
  .article-sidebar {
    position: static;
    opacity: 1; transform: none;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
  }
}
@media (max-width: 768px) {
  .ab-container { padding: 0 20px; }
  .article-body-section { padding: 56px 0 64px; }
  .lead-para { font-size: 17px; }
  .dc-stats { grid-template-columns: repeat(2, 1fr); gap: 16px; }
  .dc-num { font-size: 26px; }
  .article-sidebar { grid-template-columns: 1fr; }
  .af-row { flex-direction: column; }
}
</style>
