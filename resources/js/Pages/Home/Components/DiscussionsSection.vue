<template>
  <section id="discussions" ref="sectionEl">

    <!-- SVG background -->
    <svg class="disc-bg-svg" viewBox="0 0 1440 700" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <pattern id="discDots" width="24" height="24" patternUnits="userSpaceOnUse">
          <circle cx="1" cy="1" r="0.6" fill="rgba(255,255,255,0.04)"/>
        </pattern>
        <radialGradient id="discGlow" cx="50%" cy="50%" r="55%">
          <stop offset="0%"   stop-color="#c9a84c" stop-opacity="0.05"/>
          <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
        </radialGradient>
        <linearGradient id="discTopLine" x1="0%" y1="0%" x2="100%" y2="0%">
          <stop offset="0%"   stop-color="rgba(201,168,76,0)" />
          <stop offset="30%"  stop-color="rgba(201,168,76,0.2)" />
          <stop offset="70%"  stop-color="rgba(201,168,76,0.2)" />
          <stop offset="100%" stop-color="rgba(201,168,76,0)" />
        </linearGradient>
      </defs>
      <rect width="1440" height="700" fill="url(#discDots)"/>
      <rect width="1440" height="700" fill="url(#discGlow)"/>
      <rect x="0" y="0" width="1440" height="1" fill="url(#discTopLine)"/>
      <!-- Decorative rings -->
      <circle cx="200"  cy="350" r="300" fill="none" stroke="rgba(255,255,255,0.02)" stroke-width="1"/>
      <circle cx="1240" cy="350" r="240" fill="none" stroke="rgba(201,168,76,0.04)"  stroke-width="1"/>
      <circle cx="1240" cy="350" r="140" fill="none" stroke="rgba(201,168,76,0.03)"  stroke-width="1" stroke-dasharray="4 16"/>
    </svg>

    <div class="container">

      <!-- Header -->
      <div class="section-header" :class="{ visible: revealed }">
        <div class="section-label">
          <div class="section-tag"><span class="tag-line"/>Community Forum</div>
          <h2 class="section-title">Active Discussions</h2>
        </div>
        <a href="#" class="section-link">
          All Discussions
          <svg viewBox="0 0 20 20" fill="none" width="14" height="14" class="link-arrow">
            <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
          </svg>
        </a>
      </div>

      <!-- 2-col grid -->
      <div class="disc-grid">

        <!-- ── Left: Discussion list ── -->
        <div class="disc-list">
          <article
            v-for="(disc, i) in discussions"
            :key="disc.id"
            class="disc-item"
            :class="{ visible: revealed, active: activeDisc === i }"
            :style="{ transitionDelay: `${0.08 + i * 0.1}s` }"
            @click="activeDisc = activeDisc === i ? null : i"
          >
            <!-- Left gold bar on active -->
            <div class="disc-left-bar"/>

            <!-- Vote column -->
            <div class="disc-votes">
              <button
                class="vote-btn up"
                :class="{ voted: disc.userVoted }"
                @click.stop="toggleVote(disc)"
                :title="disc.userVoted ? 'Remove vote' : 'Upvote'"
              >
                <svg viewBox="0 0 12 12" fill="none" width="11" height="11">
                  <path d="M6 1L11 7H1L6 1Z" :fill="disc.userVoted ? '#c9a84c' : 'none'" stroke="#c9a84c" stroke-width="1.2" stroke-linejoin="round"/>
                </svg>
              </button>
              <span class="vote-count">{{ disc.votes }}</span>
              <span class="vote-label">votes</span>
            </div>

            <!-- Body -->
            <div class="disc-body">
              <div class="disc-top-row">
                <span class="disc-activity-dot" :class="disc.activityClass" :title="disc.lastActive"/>
                <span class="disc-activity-text">{{ disc.lastActive }}</span>
              </div>

              <h4>{{ disc.title }}</h4>
              <p>{{ disc.excerpt }}</p>

              <div class="disc-bottom-row">
                <div class="disc-tags">
                  <span v-for="tag in disc.tags" :key="tag" class="disc-tag">{{ tag }}</span>
                </div>
                <div class="disc-meta">
                  <svg viewBox="0 0 14 14" fill="none" width="11" height="11" class="replies-icon">
                    <path d="M1 1h12v9H8l-4 3V10H1V1Z" stroke="currentColor" stroke-width="1.1" stroke-linejoin="round"/>
                  </svg>
                  {{ disc.replies }} replies
                </div>
              </div>
            </div>
          </article>
        </div>

        <!-- ── Right: Join CTA panel ── -->
        <aside class="disc-join" :class="{ visible: revealed }">
          <!-- Animated SVG background inside panel -->
          <svg class="join-panel-svg" viewBox="0 0 420 480" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
            <defs>
              <radialGradient id="panelGlow" cx="50%" cy="30%" r="60%">
                <stop offset="0%"   stop-color="#c9a84c" stop-opacity="0.1"/>
                <stop offset="100%" stop-color="#c9a84c" stop-opacity="0"/>
              </radialGradient>
            </defs>
            <rect width="420" height="480" fill="url(#panelGlow)"/>
            <circle cx="210" cy="80" r="120" fill="none" stroke="rgba(201,168,76,0.08)" stroke-width="1" class="panel-ring-1"/>
            <circle cx="210" cy="80" r="70"  fill="none" stroke="rgba(201,168,76,0.06)" stroke-width="1" class="panel-ring-2"/>
          </svg>

          <div class="join-content">
            <div class="join-eyebrow">
              <span class="join-dot"/>
              <span>Join the conversation</span>
            </div>

            <h3>Shape the<br><em>conversation.</em></h3>
            <p>Join thousands of citizens, scholars, and practitioners debating the policies that shape India's future.</p>

            <!-- Stats grid -->
            <div class="disc-stats-grid">
              <div v-for="stat in communityStats" :key="stat.label" class="disc-stat">
                <div class="stat-num">{{ stat.num }}</div>
                <div class="stat-lbl">{{ stat.label }}</div>
              </div>
            </div>

            <!-- Live indicator -->
            <div class="live-indicator">
              <span class="live-pulse"/>
              <span class="live-text">{{ liveCount }} members active right now</span>
            </div>

            <a href="#" class="btn-join-disc">
              <span class="btn-shimmer"/>
              Join &amp; Participate
              <svg viewBox="0 0 20 20" fill="none" width="14" height="14">
                <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
              </svg>
            </a>

            <p class="join-note">Free to join · No spam · Cancel anytime</p>
          </div>
        </aside>

      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const sectionEl  = ref(null)
const revealed   = ref(false)
const activeDisc = ref(null)
const liveCount  = ref(18)

const discussions = ref([
  {
    id: 1,
    votes: 84, userVoted: false,
    title: 'Should India adopt a Presidential system of government?',
    excerpt: 'A foundational debate on Westminster vs. Presidential models and which better suits India\'s federal, diverse polity.',
    tags: ['Constitution', 'Federalism'],
    replies: 142,
    lastActive: '2h ago',
    activityClass: 'hot',
  },
  {
    id: 2,
    votes: 61, userVoted: false,
    title: 'Is One Nation One Election constitutionally viable?',
    excerpt: 'Legal, logistical, and federal concerns about simultaneous Lok Sabha and Vidhan Sabha elections.',
    tags: ['Electoral Reform', 'Constitutional Law'],
    replies: 98,
    lastActive: '5h ago',
    activityClass: 'warm',
  },
  {
    id: 3,
    votes: 49, userVoted: false,
    title: 'How should India regulate large language models in public services?',
    excerpt: 'Examining the risks and frameworks for deploying AI in judiciary, healthcare, and welfare delivery.',
    tags: ['AI Governance', 'Digital Policy'],
    replies: 73,
    lastActive: '1d ago',
    activityClass: 'cool',
  },
  {
    id: 4,
    votes: 37, userVoted: false,
    title: 'The case for and against privatising Air India\'s ground-handling',
    excerpt: 'Members debate the economics, strategic rationale, and labour implications of further AAI privatisation.',
    tags: ['Economic Policy', 'Privatisation'],
    replies: 51,
    lastActive: '2d ago',
    activityClass: 'cool',
  },
])

const communityStats = [
  { num: '5,200+', label: 'Members'      },
  { num: '840+',   label: 'Discussions'  },
  { num: '12K+',   label: 'Comments'     },
  { num: '18',     label: 'Active Today' },
]

function toggleVote(disc) {
  if (disc.userVoted) {
    disc.votes--
    disc.userVoted = false
  } else {
    disc.votes++
    disc.userVoted = true
  }
}

// Animate live count subtly
let liveTimer = null
onMounted(() => {
  liveTimer = setInterval(() => {
    const delta = Math.floor(Math.random() * 3) - 1
    liveCount.value = Math.max(12, Math.min(30, liveCount.value + delta))
  }, 4000)
})

let observer = null
onMounted(() => {
  observer = new IntersectionObserver(
    ([e]) => { if (e.isIntersecting) { revealed.value = true; observer.disconnect() } },
    { threshold: 0.08 }
  )
  if (sectionEl.value) observer.observe(sectionEl.value)
})
onUnmounted(() => {
  observer?.disconnect()
  clearInterval(liveTimer)
})
</script>

<style scoped>
/* ── Section ────────────────────────────────── */
#discussions {
  position: relative;
  background: #162d55;
  padding: 96px 0;
  overflow: hidden;
}

.disc-bg-svg {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}

.container {
  position: relative;
  z-index: 2;
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 60px;
}

/* ── Header ─────────────────────────────────── */
.section-header {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  margin-bottom: 48px;
  opacity: 0;
  transform: translateY(18px);
  transition: opacity 0.7s ease, transform 0.7s ease;
}
.section-header.visible { opacity: 1; transform: translateY(0); }
.section-label { display: flex; flex-direction: column; gap: 10px; }

.section-tag {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 10px;
  font-weight: 500;
  color: #c9a84c;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}
.tag-line { display: block; width: 24px; height: 1px; background: #c9a84c; }

.section-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 42px;
  font-weight: 600;
  color: #fff;
  line-height: 1.1;
}

.section-link {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 11px;
  font-weight: 500;
  color: #c9a84c;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  text-decoration: none;
  font-family: 'DM Sans', sans-serif;
  transition: gap 0.25s, color 0.2s;
}
.section-link:hover { gap: 14px; color: #e8cf8a; }
.link-arrow { transition: transform 0.25s; }
.section-link:hover .link-arrow { transform: translateX(4px); }

/* ── 2-col layout ───────────────────────────── */
.disc-grid {
  display: grid;
  grid-template-columns: 1.4fr 1fr;
  gap: 24px;
  align-items: start;
}

/* ── Discussion list ────────────────────────── */
.disc-list {
  display: flex;
  flex-direction: column;
  gap: 3px;
}

/* ── Discussion item ────────────────────────── */
.disc-item {
  position: relative;
  display: flex;
  gap: 0;
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(255,255,255,0.07);
  cursor: pointer;
  opacity: 0;
  transform: translateX(-20px);
  transition:
    opacity 0.65s ease,
    transform 0.65s ease,
    background 0.28s,
    border-color 0.28s;
}
.disc-item.visible { opacity: 1; transform: translateX(0); }
.disc-item:hover,
.disc-item.active {
  background: rgba(255,255,255,0.08);
  border-color: rgba(201,168,76,0.25);
}

/* Left gold bar */
.disc-left-bar {
  position: absolute;
  left: 0; top: 0; bottom: 0;
  width: 3px;
  background: linear-gradient(to bottom, #c9a84c, #e8cf8a);
  transform: scaleY(0);
  transform-origin: top;
  transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
}
.disc-item:hover .disc-left-bar,
.disc-item.active .disc-left-bar { transform: scaleY(1); }

/* ── Vote column ────────────────────────────── */
.disc-votes {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 3px;
  padding: 24px 20px;
  min-width: 68px;
  flex-shrink: 0;
  border-right: 1px solid rgba(255,255,255,0.05);
}

.vote-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 28px; height: 28px;
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(201,168,76,0.2);
  cursor: pointer;
  transition: background 0.2s, border-color 0.2s, transform 0.15s;
}
.vote-btn:hover { background: rgba(201,168,76,0.12); border-color: rgba(201,168,76,0.5); }
.vote-btn:active { transform: scale(0.9); }
.vote-btn.voted {
  background: rgba(201,168,76,0.18);
  border-color: #c9a84c;
}

.vote-count {
  font-family: 'Cormorant Garamond', serif;
  font-size: 26px;
  font-weight: 700;
  color: #c9a84c;
  line-height: 1;
  transition: transform 0.2s;
}
.vote-label {
  font-size: 8px;
  color: #8a9bbf;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}

/* ── Disc body ──────────────────────────────── */
.disc-body {
  flex: 1;
  padding: 20px 24px;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.disc-top-row {
  display: flex;
  align-items: center;
  gap: 7px;
}

/* Activity dot colours */
.disc-activity-dot {
  width: 7px; height: 7px;
  border-radius: 50%;
  flex-shrink: 0;
}
.disc-activity-dot.hot  { background: #e74c3c; box-shadow: 0 0 6px rgba(231,76,60,0.6); animation: dotBlink 1.4s ease-in-out infinite; }
.disc-activity-dot.warm { background: #e67e22; box-shadow: 0 0 5px rgba(230,126,34,0.5); animation: dotBlink 2s ease-in-out infinite; }
.disc-activity-dot.cool { background: #8a9bbf; }
@keyframes dotBlink {
  0%,100% { opacity: 1; }
  50%      { opacity: 0.4; }
}

.disc-activity-text {
  font-size: 10px;
  color: rgba(138,155,191,0.5);
  font-family: 'DM Mono', monospace;
  letter-spacing: 0.06em;
}

.disc-item h4 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 18px;
  font-weight: 600;
  color: #fff;
  line-height: 1.3;
  transition: color 0.2s;
}
.disc-item:hover h4 { color: #e8cf8a; }

.disc-item p {
  font-size: 13px;
  color: #8a9bbf;
  line-height: 1.6;
  font-family: 'DM Sans', sans-serif;
}

.disc-bottom-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 8px;
}

.disc-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
}
.disc-tag {
  font-size: 9px;
  color: #c9a84c;
  border: 1px solid rgba(201,168,76,0.2);
  padding: 3px 9px;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
  transition: background 0.2s, border-color 0.2s;
}
.disc-item:hover .disc-tag {
  background: rgba(201,168,76,0.08);
  border-color: rgba(201,168,76,0.4);
}

.disc-meta {
  display: flex;
  align-items: center;
  gap: 5px;
  font-size: 11px;
  color: rgba(138,155,191,0.45);
  font-family: 'DM Mono', monospace;
  white-space: nowrap;
}
.replies-icon { color: rgba(138,155,191,0.4); }

/* ── Join panel ─────────────────────────────── */
.disc-join {
  position: relative;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(201,168,76,0.18);
  overflow: hidden;
  opacity: 0;
  transform: translateX(20px);
  transition: opacity 0.8s ease 0.3s, transform 0.8s ease 0.3s;
}
.disc-join.visible { opacity: 1; transform: translateX(0); }

.join-panel-svg {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
}
.panel-ring-1 { animation: panelRingSpin 30s linear infinite; transform-origin: 210px 80px; }
.panel-ring-2 { animation: panelRingSpin 20s linear infinite reverse; transform-origin: 210px 80px; }
@keyframes panelRingSpin { to { transform: rotate(360deg); } }

.join-content {
  position: relative;
  z-index: 2;
  padding: 40px 36px 36px;
}

.join-eyebrow {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 20px;
}
.join-dot {
  display: block;
  width: 6px; height: 6px;
  border-radius: 50%;
  background: #c9a84c;
  box-shadow: 0 0 8px rgba(201,168,76,0.7);
  animation: dotBlink 2s ease-in-out infinite;
}
.join-eyebrow span:last-child {
  font-size: 10px;
  color: #c9a84c;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}

.join-content h3 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 36px;
  font-weight: 600;
  color: #fff;
  line-height: 1.15;
  margin-bottom: 14px;
}
.join-content h3 em {
  font-style: italic;
  color: #c9a84c;
}

.join-content > p {
  font-size: 14px;
  color: #8a9bbf;
  line-height: 1.7;
  margin-bottom: 28px;
  font-family: 'DM Sans', sans-serif;
}

/* Stats grid */
.disc-stats-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
  margin-bottom: 24px;
}

.disc-stat {
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.06);
  padding: 16px 18px;
  transition: background 0.25s, border-color 0.25s;
}
.disc-stat:hover {
  background: rgba(255,255,255,0.09);
  border-color: rgba(201,168,76,0.2);
}

.disc-stat .stat-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 28px;
  font-weight: 700;
  color: #c9a84c;
  line-height: 1;
  margin-bottom: 4px;
}
.disc-stat .stat-lbl {
  font-size: 10px;
  color: #8a9bbf;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}

/* Live indicator */
.live-indicator {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 24px;
}
.live-pulse {
  position: relative;
  width: 8px; height: 8px;
  border-radius: 50%;
  background: #2ecc71;
  flex-shrink: 0;
}
.live-pulse::before {
  content: '';
  position: absolute;
  inset: -4px;
  border-radius: 50%;
  background: rgba(46,204,113,0.3);
  animation: livePulse 1.8s ease-out infinite;
}
@keyframes livePulse {
  0%   { transform: scale(0.8); opacity: 1; }
  100% { transform: scale(2.2); opacity: 0; }
}
.live-text {
  font-size: 11px;
  color: rgba(138,155,191,0.6);
  font-family: 'DM Mono', monospace;
}

/* CTA button */
.btn-join-disc {
  position: relative;
  display: inline-flex;
  align-items: center;
  gap: 10px;
  background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 50%, #c9a84c 100%);
  background-size: 200% auto;
  color: #0b1c38;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  padding: 15px 32px;
  text-decoration: none;
  overflow: hidden;
  width: 100%;
  justify-content: center;
  margin-bottom: 12px;
  font-family: 'DM Sans', sans-serif;
  transition: background-position 0.5s, transform 0.2s, box-shadow 0.3s;
  box-shadow: 0 4px 20px rgba(201,168,76,0.25);
}
.btn-shimmer {
  position: absolute;
  inset: 0;
  background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.3) 50%, transparent 60%);
  transform: translateX(-100%);
}
.btn-join-disc:hover .btn-shimmer {
  transform: translateX(100%);
  transition: transform 0.5s ease;
}
.btn-join-disc:hover {
  background-position: right center;
  transform: translateY(-2px);
  box-shadow: 0 10px 32px rgba(201,168,76,0.4);
}

.join-note {
  font-size: 11px;
  color: rgba(138,155,191,0.35);
  text-align: center;
  font-family: 'DM Mono', monospace;
  letter-spacing: 0.04em;
}

/* ── Responsive ─────────────────────────────── */
@media (max-width: 1024px) {
  .container { padding: 0 32px; }
  .disc-grid  { grid-template-columns: 1fr; }
  .disc-join  { transform: translateX(0); }
}
@media (max-width: 768px) {
  .container { padding: 0 20px; }
  #discussions { padding: 64px 0; }
  .section-title { font-size: 32px; }
  .section-header { flex-direction: column; align-items: flex-start; gap: 16px; }
  .disc-votes { padding: 16px 14px; min-width: 56px; }
  .join-content { padding: 28px 24px; }
  .disc-stats-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>
