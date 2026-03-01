<template>
  <div id="member-form" ref="formEl" class="member-form-wrap">
    <div class="form-container">

      <!-- Header -->
      <div class="form-header" :class="{ visible: revealed }">
        <div class="sec-label">
          <span class="sec-label-line"/><span class="sec-label-dot"/>
          <span class="sec-label-text">Member Application</span>
        </div>
        <h2 class="form-headline">
          Tell Us About <em class="form-headline-em">Yourself</em>
        </h2>
        <p class="form-sub">A three-step application. Be thorough — our Executive Committee reads every application in full. There are no shortcuts, and there is no right or wrong answer to the reflective questions.</p>
      </div>

      <!-- Progress Steps -->
      <div class="progress-bar" :class="{ visible: revealed }">
        <div
          v-for="(step, i) in steps"
          :key="i"
          class="prog-step"
          :class="{
            active: currentStep === i + 1,
            done:   currentStep > i + 1
          }"
          @click="goToStep(i + 1)"
        >
          <span class="step-indicator">
            <span v-if="currentStep > i + 1" class="step-check">✓</span>
            <span v-else>{{ String(i + 1).padStart(2, '0') }}</span>
          </span>
          {{ step }}
        </div>
      </div>

      <!-- STEP 1 — PROFILE -->
      <Transition name="step-fade" mode="out-in">
        <div v-if="currentStep === 1" key="step1" class="step-panel" :class="{ visible: revealed }">
          <div class="step-title">Your Profile</div>
          <div class="step-sub">Tell us who you are — your background, current work, and what kind of membership you are seeking.</div>

          <div class="form-grid">
            <div class="form-group">
              <label>Full Name *</label>
              <input v-model="form.fullName" type="text" placeholder="As per official documents" :class="{ error: errors.fullName }"/>
              <span v-if="errors.fullName" class="err-msg">{{ errors.fullName }}</span>
            </div>
            <div class="form-group">
              <label>Email Address *</label>
              <input v-model="form.email" type="email" placeholder="your@email.com" :class="{ error: errors.email }"/>
              <span v-if="errors.email" class="err-msg">{{ errors.email }}</span>
            </div>
            <div class="form-group">
              <label>Phone Number *</label>
              <input v-model="form.phone" type="tel" placeholder="+91 98765 43210" :class="{ error: errors.phone }"/>
              <span v-if="errors.phone" class="err-msg">{{ errors.phone }}</span>
            </div>
            <div class="form-group">
              <label>City / State of Residence *</label>
              <input v-model="form.city" type="text" placeholder="New Delhi, Lucknow, Chennai..." :class="{ error: errors.city }"/>
              <span v-if="errors.city" class="err-msg">{{ errors.city }}</span>
            </div>
            <div class="form-group">
              <label>Current Designation / Role *</label>
              <input v-model="form.designation" type="text" placeholder="e.g. Retired IAS Officer / Professor / Lawyer / Researcher" :class="{ error: errors.designation }"/>
              <span v-if="errors.designation" class="err-msg">{{ errors.designation }}</span>
            </div>
            <div class="form-group">
              <label>Current Organisation / Institution</label>
              <input v-model="form.organisation" type="text" placeholder="If applicable"/>
            </div>
            <div class="form-group">
              <label>Membership Type Sought *</label>
              <select v-model="form.membershipType" :class="{ error: errors.membershipType }">
                <option value="">Select membership type</option>
                <option>Research Fellow (1-year, full support)</option>
                <option>Senior Fellow (3-year, leadership role)</option>
                <option>Associate Member (annual, open)</option>
              </select>
              <span v-if="errors.membershipType" class="err-msg">{{ errors.membershipType }}</span>
            </div>
            <div class="form-group">
              <label>Mode Preference *</label>
              <select v-model="form.mode" :class="{ error: errors.mode }">
                <option value="">Select preference</option>
                <option>Residential — New Delhi office</option>
                <option>Non-residential (available for events &amp; remote work)</option>
                <option>Either is acceptable</option>
              </select>
              <span v-if="errors.mode" class="err-msg">{{ errors.mode }}</span>
            </div>
            <div class="form-group form-group-full">
              <label>Your Background — in approximately 300 words *</label>
              <textarea v-model="form.background" :class="{ error: errors.background }" placeholder="Tell us about your professional journey — your service history, academic background, or career path. What have you worked on? What problems have you engaged with? What distinguishes your experience? Write in first person, plainly and directly."></textarea>
              <span v-if="errors.background" class="err-msg">{{ errors.background }}</span>
            </div>
            <div class="form-group form-group-full">
              <label>Proposed Area of Contribution *</label>
              <select v-model="form.contributionArea" :class="{ error: errors.contributionArea }">
                <option value="">Select primary area</option>
                <option>State Capacity &amp; Administrative Reform</option>
                <option>Constitutional Law &amp; Judicial Governance</option>
                <option>Public Finance &amp; Fiscal Federalism</option>
                <option>Climate &amp; Environmental Governance</option>
                <option>Civil Services Ethics &amp; Reform</option>
                <option>International Affairs &amp; South Asia</option>
                <option>Rural Development &amp; Cooperative Law</option>
                <option>Security Governance &amp; Policing</option>
                <option>Technology Policy &amp; Digital Governance</option>
                <option>Social Policy &amp; Welfare</option>
                <option>Other / Interdisciplinary</option>
              </select>
              <span v-if="errors.contributionArea" class="err-msg">{{ errors.contributionArea }}</span>
            </div>
            <div class="form-group form-group-full">
              <label>Do you have an existing relationship with any BGC Board member?</label>
              <input v-model="form.boardRelation" type="text" placeholder="Name of board member, or leave blank if none"/>
            </div>
          </div>

          <div class="step-nav">
            <span/>
            <button class="btn-next" @click="nextStep">
              Next: Your Thinking
              <svg viewBox="0 0 20 20" fill="none" width="14" height="14">
                <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
              </svg>
            </button>
          </div>
        </div>
      </Transition>

      <!-- STEP 2 — REFLECTIVE QUESTIONS -->
      <Transition name="step-fade" mode="out-in">
        <div v-if="currentStep === 2" key="step2" class="step-panel" :class="{ visible: revealed }">
          <div class="step-title">Your Thinking</div>
          <div class="step-sub">Four questions. There are no right answers — only honest or generic ones. Be specific. Draw on your actual experience. We read these carefully and weight them heavily.</div>

          <div class="q-cards">
            <div v-for="(q, i) in questions" :key="i" class="q-card">
              <div class="q-label">
                <span class="q-num">{{ String(i + 1).padStart(2, '0') }}</span>
                <span class="q-category">{{ q.category }}</span>
              </div>
              <p class="q-text">{{ q.text }}</p>
              <textarea v-model="form.answers[i]" :placeholder="q.hint"></textarea>
            </div>
          </div>

          <div class="step-nav">
            <button class="btn-prev" @click="prevStep">
              <svg viewBox="0 0 20 20" fill="none" width="14" height="14">
                <path d="M16 10H4M9 5l-5 5 5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
              </svg>
              Back
            </button>
            <button class="btn-next" @click="nextStep">
              Next: Final Details
              <svg viewBox="0 0 20 20" fill="none" width="14" height="14">
                <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
              </svg>
            </button>
          </div>
        </div>
      </Transition>

      <!-- STEP 3 — DOCUMENTS -->
      <Transition name="step-fade" mode="out-in">
        <div v-if="currentStep === 3" key="step3" class="step-panel" :class="{ visible: revealed }">
          <div class="step-title">Final Details</div>
          <div class="step-sub">Provide your referees and any additional information you'd like us to consider.</div>

          <div class="form-grid form-grid-single">
            <div class="form-group">
              <label>Referees (name, designation, contact — at least one)</label>
              <textarea v-model="form.referees" placeholder="Name &amp; Designation of Referee 1&#10;Email / Phone&#10;&#10;Name &amp; Designation of Referee 2 (optional)&#10;Email / Phone" style="min-height:100px;"></textarea>
            </div>
            <div class="form-group">
              <label>Anything else you'd like us to know?</label>
              <textarea v-model="form.additionalNotes" placeholder="Optional — use this space for anything that did not fit elsewhere." style="min-height:80px;"></textarea>
            </div>
          </div>

          <div v-if="errors._server" class="server-error-banner">
            {{ errors._server }}
          </div>

          <div class="step-nav">
            <button class="btn-prev" @click="prevStep">
              <svg viewBox="0 0 20 20" fill="none" width="14" height="14">
                <path d="M16 10H4M9 5l-5 5 5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
              </svg>
              Back
            </button>
            <button class="btn-submit" :disabled="submitting" @click="handleSubmit">
              <span v-if="!submitting && !submitted">
                <span class="btn-shimmer"/>
                Submit Application
                <svg viewBox="0 0 20 20" fill="none" width="14" height="14">
                  <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
              </span>
              <span v-else-if="submitting" class="btn-spinner">
                <span class="spinner"/>Submitting...
              </span>
              <span v-else>✓ Application Submitted</span>
            </button>
          </div>
        </div>
      </Transition>

    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, onUnmounted } from 'vue'

const formEl  = ref(null)
const revealed = ref(false)
const currentStep = ref(1)
const submitting  = ref(false)
const submitted   = ref(false)
const errors      = reactive({})

const steps = ['Profile', 'Your Thinking', 'Final Details']

const form = reactive({
  fullName: '', email: '', phone: '', city: '',
  designation: '', organisation: '',
  membershipType: '', mode: '',
  background: '', contributionArea: '', boardRelation: '',
  answers: ['', '', '', ''],
  referees: '', additionalNotes: '',
})

const questions = [
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
]

function validate() {
  Object.keys(errors).forEach(k => delete errors[k])
  if (!form.fullName.trim())    errors.fullName = 'Required'
  if (!form.email.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email))
    errors.email = 'Valid email required'
  if (!form.phone.trim())       errors.phone = 'Required'
  if (!form.city.trim())        errors.city = 'Required'
  if (!form.designation.trim()) errors.designation = 'Required'
  if (!form.membershipType)     errors.membershipType = 'Please select a membership type'
  if (!form.mode)               errors.mode = 'Please select a mode preference'
  if (!form.background.trim())  errors.background = 'Required'
  if (!form.contributionArea)   errors.contributionArea = 'Please select an area of contribution'
  return Object.keys(errors).length === 0
}

function nextStep() {
  if (currentStep.value === 1 && !validate()) return
  if (currentStep.value < 3) currentStep.value++
}
function prevStep() { if (currentStep.value > 1) currentStep.value-- }
function goToStep(n) { if (n < currentStep.value) currentStep.value = n }

async function handleSubmit() {
  if (!validate()) {
    currentStep.value = 1
    return
  }
  submitting.value = true
  Object.keys(errors).forEach(k => delete errors[k])

  const payload = {
    full_name:           form.fullName.trim(),
    email:               form.email.trim(),
    phone:               form.phone.trim(),
    city:                form.city.trim(),
    designation:         form.designation.trim(),
    organisation:        form.organisation.trim(),
    membership_type:     form.membershipType,
    mode:                form.mode,
    background:          form.background.trim(),
    contribution_area:   form.contributionArea,
    board_relation:      form.boardRelation.trim(),
    answer_governance:   form.answers[0],
    answer_contribution: form.answers[1],
    answer_reform:       form.answers[2],
    answer_bgc:          form.answers[3],
    referees:            form.referees,
    additional_notes:    form.additionalNotes,
  }

  try {
    await window.axios.post('/work-with-us/apply', payload)
    submitted.value = true
  } catch (err) {
    if (err.response?.status === 422 && err.response?.data?.errors) {
      const serverErrors = err.response.data.errors
      const fieldMap = {
        full_name: 'fullName', membership_type: 'membershipType',
        contribution_area: 'contributionArea', board_relation: 'boardRelation',
        additional_notes: 'additionalNotes',
      }
      Object.entries(serverErrors).forEach(([key, msgs]) => {
        errors[fieldMap[key] ?? key] = Array.isArray(msgs) ? msgs[0] : msgs
      })
      const step1Keys = ['fullName','email','phone','city','designation','membershipType','mode','background','contributionArea']
      if (step1Keys.some(k => errors[k])) {
        currentStep.value = 1
      }
    } else {
      errors._server = 'Something went wrong. Please try again.'
    }
  } finally {
    submitting.value = false
  }
}

let observer = null
onMounted(() => {
  observer = new IntersectionObserver(
    ([e]) => { if (e.isIntersecting) { revealed.value = true; observer.disconnect() } },
    { threshold: 0.06 }
  )
  if (formEl.value) observer.observe(formEl.value)
})
onUnmounted(() => observer?.disconnect())
</script>

<style scoped>
/* ── Wrap ────────────────────────────────────── */
.member-form-wrap {
  background: #f2f4f8;
  padding: 96px 0;
  position: relative;
}

.form-container {
  max-width: 1000px;
  margin: 0 auto;
  padding: 0 60px;
}

/* ── Header ──────────────────────────────────── */
.form-header {
  margin-bottom: 44px;
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.7s ease 0.05s, transform 0.7s ease 0.05s;
}
.form-header.visible { opacity: 1; transform: translateY(0); }

.sec-label { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; }
.sec-label-line {
  display: block; width: 32px; height: 1px;
  background: linear-gradient(90deg, transparent, #c9a84c);
}
.sec-label-dot {
  display: block; width: 4px; height: 4px; border-radius: 50%;
  background: #c9a84c; box-shadow: 0 0 6px rgba(201,168,76,0.7);
}
.sec-label-text {
  font-size: 10px; font-weight: 700;
  color: #c9a84c; letter-spacing: 0.28em; text-transform: uppercase;
  font-family: 'DM Sans', sans-serif;
}

.form-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2rem, 3.5vw, 3.2rem);
  font-weight: 600; color: #0b1c38;
  line-height: 1.1; margin-bottom: 14px;
}
.form-headline-em {
  font-style: italic;
  background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 45%, #c9a84c 100%);
  background-size: 200% auto;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  animation: goldShine 4s linear infinite;
}
@keyframes goldShine { 0%{background-position:0% center} 100%{background-position:200% center} }
.form-sub {
  font-size: 14px; font-weight: 300;
  color: #8a9bbf; line-height: 1.8;
  max-width: 60ch; font-family: 'DM Sans', sans-serif;
}

/* ── Progress Bar ────────────────────────────── */
.progress-bar {
  display: flex; gap: 2px; margin-bottom: 48px;
  opacity: 0; transform: translateY(16px);
  transition: opacity 0.7s ease 0.18s, transform 0.7s ease 0.18s;
}
.progress-bar.visible { opacity: 1; transform: translateY(0); }

.prog-step {
  flex: 1; display: flex; align-items: center; gap: 10px;
  padding: 14px 20px;
  font-size: 9px; font-weight: 700;
  letter-spacing: 0.14em; text-transform: uppercase;
  background: #e8eaf0; color: #b8c5d8;
  cursor: pointer; transition: all 0.22s;
  font-family: 'DM Mono', monospace;
  border-bottom: 3px solid transparent;
}
.prog-step:hover { background: #dfe2ea; color: #8a9bbf; }
.prog-step.active {
  background: #0b1c38; color: #f5f7fa;
  border-bottom-color: #c9a84c;
}
.prog-step.done {
  background: rgba(201,168,76,0.1); color: #c9a84c;
  border-bottom-color: rgba(201,168,76,0.4);
}

.step-indicator {
  display: flex; align-items: center; justify-content: center;
  width: 20px; height: 20px; border-radius: 50%;
  background: rgba(255,255,255,0.1);
  font-size: 9px; flex-shrink: 0;
}
.prog-step.active .step-indicator { background: rgba(201,168,76,0.2); color: #c9a84c; }
.prog-step.done .step-indicator  { background: #c9a84c; color: #0b1c38; font-weight: 900; }
.step-check { font-weight: 900; }

/* ── Step Panels ─────────────────────────────── */
.step-panel {
  opacity: 0; transform: translateY(16px);
  transition: opacity 0.6s ease 0.28s, transform 0.6s ease 0.28s;
}
.step-panel.visible { opacity: 1; transform: translateY(0); }

.step-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.7rem; font-weight: 600;
  color: #0b1c38; margin-bottom: 8px;
}
.step-sub {
  font-size: 14px; font-weight: 300;
  color: #8a9bbf; max-width: 64ch;
  line-height: 1.75; margin-bottom: 36px;
  font-family: 'DM Sans', sans-serif;
}

/* ── Form Elements ───────────────────────────── */
.form-grid {
  display: grid; grid-template-columns: 1fr 1fr; gap: 20px;
  margin-bottom: 32px;
}
.form-grid-single { grid-template-columns: 1fr; }

.form-group { display: flex; flex-direction: column; gap: 8px; }
.form-group-full { grid-column: 1 / -1; }

label {
  font-size: 9px; font-weight: 700;
  letter-spacing: 0.16em; text-transform: uppercase;
  color: #8a9bbf; font-family: 'DM Mono', monospace;
}

input[type="text"],
input[type="email"],
input[type="tel"],
select,
textarea {
  background: #fff;
  border: 1px solid #e8eaf0;
  color: #0b1c38; padding: 13px 16px;
  font-size: 14px; font-family: 'DM Sans', sans-serif;
  font-weight: 300; outline: none; width: 100%;
  transition: border-color 0.2s, box-shadow 0.2s;
}
input:focus, select:focus, textarea:focus {
  border-color: rgba(201,168,76,0.5);
  box-shadow: 0 0 0 3px rgba(201,168,76,0.08);
}
input::placeholder, textarea::placeholder { color: #b8c5d8; }
input.error, textarea.error, select.error { border-color: rgba(231,76,60,0.4); }

select { cursor: pointer; }
select option { background: #fff; color: #0b1c38; }
textarea { resize: vertical; min-height: 140px; line-height: 1.7; }

.err-msg { font-size: 10px; color: rgba(231,76,60,0.75); font-family: 'DM Mono', monospace; }

.server-error-banner {
  background: rgba(231,76,60,0.07);
  border: 1px solid rgba(231,76,60,0.2);
  color: rgba(231,76,60,0.85);
  padding: 12px 16px;
  font-size: 12px;
  font-family: 'DM Sans', sans-serif;
  margin-bottom: 16px;
  line-height: 1.5;
}

/* ── Question Cards ──────────────────────────── */
.q-cards { display: flex; flex-direction: column; gap: 20px; margin-bottom: 32px; }

.q-card {
  background: #fff; border: 1px solid #e8eaf0;
  padding: 28px; transition: border-color 0.22s, box-shadow 0.22s;
}
.q-card:hover { border-color: rgba(201,168,76,0.3); box-shadow: 0 4px 20px rgba(11,28,56,0.06); }

.q-label {
  display: flex; align-items: center; gap: 12px;
  margin-bottom: 14px;
}
.q-num {
  display: flex; align-items: center; justify-content: center;
  width: 24px; height: 24px; border-radius: 50%;
  background: #c9a84c; color: #0b1c38;
  font-size: 9px; font-weight: 900;
  font-family: 'DM Mono', monospace; flex-shrink: 0;
}
.q-category {
  font-size: 9px; font-weight: 700;
  letter-spacing: 0.22em; text-transform: uppercase;
  color: #c9a84c; font-family: 'DM Mono', monospace;
}
.q-text {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.08rem; font-weight: 600; font-style: italic;
  color: #0b1c38; margin-bottom: 16px; line-height: 1.4;
}
.q-card textarea { min-height: 110px; }

/* ── Step Nav ────────────────────────────────── */
.step-nav {
  display: flex; justify-content: space-between; align-items: center;
  margin-top: 8px; padding-top: 28px;
  border-top: 1px solid #e8eaf0;
}

.btn-prev {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 13px 24px; border: 1px solid #e8eaf0;
  background: transparent; color: #8a9bbf;
  font-size: 10px; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase;
  font-family: 'DM Mono', monospace; cursor: pointer;
  transition: border-color 0.22s, color 0.22s;
}
.btn-prev:hover { border-color: #0b1c38; color: #0b1c38; }

.btn-next {
  display: inline-flex; align-items: center; gap: 10px;
  padding: 14px 32px; background: #0b1c38;
  color: #f5f7fa; border: none; cursor: pointer;
  font-size: 10px; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase;
  font-family: 'DM Mono', monospace;
  transition: background 0.22s, transform 0.22s;
}
.btn-next:hover { background: #c9a84c; color: #0b1c38; transform: translateY(-2px); }

.btn-submit {
  position: relative;
  display: inline-flex; align-items: center; gap: 10px;
  background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 50%, #c9a84c 100%);
  background-size: 200% auto;
  color: #0b1c38; border: none; cursor: pointer;
  font-size: 10px; font-weight: 700; letter-spacing: 0.18em; text-transform: uppercase;
  padding: 14px 36px; font-family: 'DM Mono', monospace;
  overflow: hidden;
  transition: background-position 0.5s ease, transform 0.2s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 20px rgba(201,168,76,0.28);
}
.btn-submit:disabled { opacity: 0.7; cursor: not-allowed; }
.btn-submit:not(:disabled):hover {
  background-position: right center;
  transform: translateY(-2px);
  box-shadow: 0 10px 32px rgba(201,168,76,0.4);
}
.btn-shimmer {
  position: absolute; inset: 0;
  background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.32) 50%, transparent 60%);
  transform: translateX(-100%); transition: transform 0s;
}
.btn-submit:hover .btn-shimmer { transform: translateX(100%); transition: transform 0.5s ease; }

.btn-spinner { display: flex; align-items: center; gap: 10px; }
.spinner {
  width: 13px; height: 13px; border-radius: 50%;
  border: 2px solid rgba(11,28,56,0.2); border-top-color: #0b1c38;
  animation: spin 0.8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ── Step transitions ────────────────────────── */
.step-fade-enter-active, .step-fade-leave-active { transition: opacity 0.25s ease, transform 0.25s ease; }
.step-fade-enter-from, .step-fade-leave-to { opacity: 0; transform: translateX(12px); }

/* ── Responsive ──────────────────────────────── */
@media (max-width: 768px) {
  .member-form-wrap { padding: 72px 0; }
  .form-container { padding: 0 24px; }
  .form-grid { grid-template-columns: 1fr; }
  .form-group-full { grid-column: 1; }
  .progress-bar { flex-direction: column; gap: 2px; }
  .prog-step { border-bottom: none; border-left: 3px solid transparent; }
  .prog-step.active { border-left-color: #c9a84c; }
  .step-nav { flex-direction: column; gap: 12px; align-items: stretch; }
  .btn-prev, .btn-next, .btn-submit { justify-content: center; }
}
</style>
