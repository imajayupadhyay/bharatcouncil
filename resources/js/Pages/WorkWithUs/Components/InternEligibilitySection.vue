<template>
  <div class="intern-elig-wrap">

    <!-- ══ ELIGIBILITY ══ -->
    <section id="intern-eligibility" ref="eligEl" class="section-grey">
      <div class="container">

        <div class="sec-label" :class="{ visible: eligVisible }">
          <span class="sec-label-line"/>
          <span class="sec-label-dot"/>
          <span class="sec-label-text">Eligibility &amp; Expectations</span>
        </div>

        <h2 class="section-headline" :class="{ visible: eligVisible }">
          Who We're <em class="headline-em">Looking For</em>
        </h2>

        <div class="elig-grid" :class="{ visible: eligVisible }">
          <div class="elig-col">
            <h3 class="elig-col-title">
              <span class="elig-col-icon elig-yes">✓</span>
              You should bring
            </h3>
            <ul class="elig-list">
              <li v-for="item in shouldBring" :key="item">
                <span class="check">✓</span>
                <span>{{ item }}</span>
              </li>
            </ul>
          </div>
          <div class="elig-col">
            <h3 class="elig-col-title">
              <span class="elig-col-icon elig-no">—</span>
              We do not look for
            </h3>
            <ul class="elig-list elig-list-no">
              <li v-for="item in doNotNeed" :key="item">
                <span class="dash">—</span>
                <span>{{ item }}</span>
              </li>
            </ul>
          </div>
        </div>

      </div>
    </section>

    <!-- ══ INTERNSHIP APPLICATION FORM ══ -->
    <div id="intern-form" ref="formEl" class="form-wrap">
      <div class="form-container">

        <!-- Header -->
        <div class="form-header" :class="{ visible: formVisible }">
          <div class="sec-label sec-label-light">
            <span class="sec-label-line sec-label-line-light"/>
            <span class="sec-label-dot"/>
            <span class="sec-label-text sec-label-text-light">Apply for Internship</span>
          </div>
          <h2 class="form-headline">
            Submit Your <em class="form-headline-em">Application</em>
          </h2>
          <p class="form-sub">Fill in the form below. We review applications on a rolling basis. Strong applications hear from us within 10 working days. All fields marked * are required.</p>
        </div>

        <!-- Form -->
        <form class="intern-form" :class="{ visible: formVisible }" @submit.prevent="handleSubmit">

          <!-- Personal Info -->
          <div class="form-section-title">Personal Information</div>
          <div class="form-grid">
            <div class="form-group">
              <label>Full Name *</label>
              <input v-model="form.fullName" type="text" placeholder="As per official ID" :class="{ error: errors.fullName }"/>
              <span v-if="errors.fullName" class="err-msg">{{ errors.fullName }}</span>
            </div>
            <div class="form-group">
              <label>Email Address *</label>
              <input v-model="form.email" type="email" placeholder="your@email.com" :class="{ error: errors.email }"/>
              <span v-if="errors.email" class="err-msg">{{ errors.email }}</span>
            </div>
            <div class="form-group">
              <label>Phone Number *</label>
              <input v-model="form.phone" type="tel" placeholder="+91 98765 43210"/>
            </div>
            <div class="form-group">
              <label>City / State *</label>
              <input v-model="form.city" type="text" placeholder="Delhi, Mumbai, Bengaluru..."/>
            </div>
          </div>

          <div class="form-divider"/>

          <!-- Academic Background -->
          <div class="form-section-title">Academic Background</div>
          <div class="form-grid">
            <div class="form-group">
              <label>Current Institution *</label>
              <input v-model="form.institution" type="text" placeholder="University / College name"/>
            </div>
            <div class="form-group">
              <label>Programme &amp; Year *</label>
              <input v-model="form.programme" type="text" placeholder="e.g. BA LLB 3rd Year, MA Public Policy 1st Year"/>
            </div>
            <div class="form-group">
              <label>Academic Discipline *</label>
              <select v-model="form.discipline">
                <option value="">Select your field</option>
                <option>Public Policy / Administration</option>
                <option>Law / Legal Studies</option>
                <option>Political Science</option>
                <option>Economics</option>
                <option>Social Work</option>
                <option>Journalism / Mass Communication</option>
                <option>Environmental Studies</option>
                <option>Other</option>
              </select>
            </div>
            <div class="form-group">
              <label>Expected Graduation Year *</label>
              <select v-model="form.gradYear">
                <option value="">Select year</option>
                <option>2025</option><option>2026</option><option>2027</option>
                <option>2028</option><option>2029+</option>
              </select>
            </div>
          </div>

          <div class="form-divider"/>

          <!-- Preferences -->
          <div class="form-section-title">Internship Preferences</div>
          <div class="form-grid">
            <div class="form-group">
              <label>Preferred Research Track *</label>
              <select v-model="form.track">
                <option value="">Select a track</option>
                <option>State Capacity &amp; Administrative Reform</option>
                <option>Constitutional Law &amp; Judicial Governance</option>
                <option>Public Finance &amp; Fiscal Federalism</option>
                <option>Climate &amp; Environmental Governance</option>
                <option>Civil Services Ethics &amp; Reform</option>
                <option>International Affairs &amp; South Asia</option>
                <option>Rural Development &amp; Cooperative Law</option>
                <option>Technology Policy &amp; Digital Governance</option>
              </select>
            </div>
            <div class="form-group">
              <label>Preferred Cohort *</label>
              <select v-model="form.cohort">
                <option value="">Select cohort</option>
                <option>January 2026 Cohort</option>
                <option>May 2026 Cohort</option>
                <option>September 2026 Cohort</option>
              </select>
            </div>
            <div class="form-group">
              <label>Mode Preference *</label>
              <select v-model="form.mode">
                <option value="">Select mode</option>
                <option>In-office (New Delhi)</option>
                <option>Hybrid</option>
                <option>Either is acceptable</option>
              </select>
            </div>
            <div class="form-group">
              <label>Duration Available *</label>
              <select v-model="form.duration">
                <option value="">Select duration</option>
                <option>8 weeks</option>
                <option>10 weeks</option>
                <option>12 weeks</option>
                <option>Flexible / to be discussed</option>
              </select>
            </div>
          </div>

          <div class="form-divider"/>

          <!-- Statements -->
          <div class="form-section-title">Your Statement</div>
          <div class="form-grid form-grid-single">
            <div class="form-group">
              <label>Why do you want to intern at BGC? What will you contribute? * (200–350 words)</label>
              <textarea v-model="form.statement" :class="{ error: errors.statement }" placeholder="Tell us specifically what draws you to governance research, why BGC in particular, and what you will bring to your assigned track. Avoid generic statements — we read closely."></textarea>
              <span v-if="errors.statement" class="err-msg">{{ errors.statement }}</span>
            </div>
            <div class="form-group">
              <label>A governance problem that interests you deeply (100–200 words)</label>
              <textarea v-model="form.governanceProblem" placeholder="Describe a specific governance challenge in India that you find intellectually compelling. What is the problem? Why does it persist? What would a good solution look like?"></textarea>
            </div>
          </div>

          <!-- Submit -->
          <div class="submit-row">
            <button type="submit" class="btn-submit" :disabled="submitting">
              <span v-if="!submitting && !submitted">
                <span class="btn-shimmer"/>
                Submit Application
                <svg viewBox="0 0 20 20" fill="none" width="14" height="14">
                  <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
              </span>
              <span v-else-if="submitting" class="btn-spinner">
                <span class="spinner"/>
                Submitting...
              </span>
              <span v-else class="btn-success">
                ✓ Application Submitted
              </span>
            </button>
            <span v-if="serverError" class="err-msg" style="font-size:12px">{{ serverError }}</span>
            <span v-else class="submit-note">We will acknowledge receipt within 2 working days. Reviews take up to 10 days.</span>
          </div>

        </form>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, reactive, onMounted, onUnmounted } from 'vue'
import axios from 'axios'

const eligEl    = ref(null)
const formEl    = ref(null)
const eligVisible = ref(false)
const formVisible = ref(false)
const submitting = ref(false)
const submitted  = ref(false)
const errors     = reactive({})
const serverError = ref('')

const form = reactive({
  fullName: '', email: '', phone: '', city: '',
  institution: '', programme: '', discipline: '', gradYear: '',
  track: '', cohort: '', mode: '', duration: '',
  statement: '', governanceProblem: '',
})

const shouldBring = [
  'Enrolment in a recognised UG, PG, or doctoral programme in public policy, law, political science, economics, or related fields',
  'Strong reading habits and the ability to synthesise complex documents',
  'Clear, structured written English (Hindi-language submissions also accepted)',
  'Genuine curiosity about how India\'s government actually functions',
  'Willingness to work independently with minimal supervision',
  'Prior exposure to governance or civil society is valued but not required',
]

const doNotNeed = [
  'Specific CGPA or academic rank — we care more about the quality of your thinking than your grade sheet',
  'Prior publications or research experience — we are happy to be your first substantive research experience',
  'Attendance at prestigious institutions — we actively recruit from state universities and lesser-known colleges',
  'A fixed political or ideological orientation — BGC is non-partisan and welcomes diverse perspectives',
]

function validate() {
  Object.keys(errors).forEach(k => delete errors[k])
  if (!form.fullName.trim()) errors.fullName = 'Full name is required'
  if (!form.email.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email))
    errors.email = 'Valid email address is required'
  if (!form.statement.trim()) errors.statement = 'Your statement is required'
  return Object.keys(errors).length === 0
}

async function handleSubmit() {
  if (!validate()) return
  submitting.value = true
  serverError.value = ''
  Object.keys(errors).forEach(k => delete errors[k])

  try {
    await axios.post('/work-with-us/intern-apply', {
      full_name:          form.fullName,
      email:              form.email,
      phone:              form.phone,
      city:               form.city,
      institution:        form.institution,
      programme:          form.programme,
      discipline:         form.discipline,
      grad_year:          form.gradYear,
      track:              form.track,
      cohort:             form.cohort,
      mode:               form.mode,
      duration:           form.duration,
      statement:          form.statement,
      governance_problem: form.governanceProblem,
    })
    submitted.value = true
  } catch (err) {
    if (err.response?.status === 422) {
      const fieldErrors = err.response.data.errors ?? {}
      const keyMap = {
        full_name: 'fullName', grad_year: 'gradYear',
        governance_problem: 'governanceProblem',
      }
      for (const [field, msgs] of Object.entries(fieldErrors)) {
        errors[keyMap[field] ?? field] = msgs[0]
      }
    } else {
      serverError.value = 'Something went wrong. Please try again later.'
    }
  } finally {
    submitting.value = false
  }
}

let observers = []
function observe(el, setter) {
  const obs = new IntersectionObserver(
    ([e]) => { if (e.isIntersecting) { setter(true); obs.disconnect() } },
    { threshold: 0.06 }
  )
  if (el) obs.observe(el)
  observers.push(obs)
}

onMounted(() => {
  observe(eligEl.value, v => eligVisible.value = v)
  observe(formEl.value, v => formVisible.value = v)
})
onUnmounted(() => observers.forEach(o => o.disconnect()))
</script>

<style scoped>
/* ── Sections ────────────────────────────────── */
.section-grey { background: #e8eaf0; padding: 96px 0; }

.container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 60px;
}

/* ── Section Label ───────────────────────────── */
.sec-label {
  display: flex; align-items: center; gap: 12px;
  margin-bottom: 28px;
  opacity: 0; transform: translateY(14px);
  transition: opacity 0.7s ease 0.05s, transform 0.7s ease 0.05s;
}
.sec-label.visible { opacity: 1; transform: translateY(0); }
.sec-label-light { opacity: 1; transform: none; }

.sec-label-line {
  display: block; width: 32px; height: 1px;
  background: linear-gradient(90deg, transparent, #c9a84c);
}
.sec-label-line-light {
  background: linear-gradient(90deg, transparent, rgba(201,168,76,0.6));
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
.sec-label-text-light { color: rgba(201,168,76,0.75); }

/* ── Section Headline ────────────────────────── */
.section-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2rem, 3.2vw, 3rem);
  font-weight: 600; color: #0b1c38;
  line-height: 1.12; letter-spacing: -0.01em;
  margin-bottom: 40px;
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.8s ease 0.15s, transform 0.8s ease 0.15s;
}
.section-headline.visible { opacity: 1; transform: translateY(0); }
.headline-em {
  font-style: italic;
  background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 45%, #c9a84c 100%);
  background-size: 200% auto;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  animation: goldShine 4s linear infinite;
}
@keyframes goldShine { 0%{background-position:0% center} 100%{background-position:200% center} }

/* ── Eligibility Grid ────────────────────────── */
.elig-grid {
  display: grid; grid-template-columns: 1fr 1fr; gap: 48px;
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.8s ease 0.28s, transform 0.8s ease 0.28s;
}
.elig-grid.visible { opacity: 1; transform: translateY(0); }

.elig-col-title {
  display: flex; align-items: center; gap: 10px;
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.1rem; font-weight: 600;
  color: #0b1c38; margin-bottom: 20px;
}
.elig-col-icon {
  display: flex; align-items: center; justify-content: center;
  width: 22px; height: 22px; border-radius: 50%;
  font-size: 11px; font-weight: 700; flex-shrink: 0;
}
.elig-yes { background: rgba(46,204,113,0.15); color: #2ecc71; }
.elig-no  { background: rgba(138,155,191,0.15); color: #8a9bbf; }

.elig-list { list-style: none; display: flex; flex-direction: column; gap: 12px; }
.elig-list li {
  display: flex; gap: 12px; align-items: flex-start;
  font-size: 14px; color: #8a9bbf; font-weight: 300;
  line-height: 1.65; font-family: 'DM Sans', sans-serif;
}
.check { color: #2ecc71; font-weight: 700; flex-shrink: 0; margin-top: 1px; }
.dash  { color: #8a9bbf; flex-shrink: 0; margin-top: 1px; }

/* ── Form Wrap ───────────────────────────────── */
.form-wrap {
  background: #0b1c38;
  padding: 96px 0;
  position: relative;
  overflow: hidden;
}
.form-wrap::before {
  content: 'APPLY';
  position: absolute; right: -2rem; top: 50%;
  transform: translateY(-50%);
  font-family: 'Cormorant Garamond', serif;
  font-size: 18rem; font-weight: 700;
  color: rgba(255,255,255,0.018);
  pointer-events: none; white-space: nowrap; letter-spacing: -0.04em;
}

.form-container {
  max-width: 1000px;
  margin: 0 auto;
  padding: 0 60px;
}

/* ── Form Header ─────────────────────────────── */
.form-header {
  margin-bottom: 52px;
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.7s ease 0.05s, transform 0.7s ease 0.05s;
}
.form-header.visible { opacity: 1; transform: translateY(0); }

.form-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2rem, 3.5vw, 3.2rem);
  font-weight: 600; color: #f5f7fa;
  line-height: 1.1; margin-bottom: 16px;
}
.form-headline-em {
  font-style: italic; color: #c9a84c;
}
.form-sub {
  font-size: 14px; font-weight: 300;
  color: rgba(184,197,216,0.6); line-height: 1.8;
  max-width: 58ch; font-family: 'DM Sans', sans-serif;
}

/* ── Form ────────────────────────────────────── */
.intern-form {
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.8s ease 0.2s, transform 0.8s ease 0.2s;
}
.intern-form.visible { opacity: 1; transform: translateY(0); }

.form-section-title {
  font-size: 9px; font-weight: 700;
  letter-spacing: 0.22em; text-transform: uppercase;
  color: #c9a84c; font-family: 'DM Mono', monospace;
  margin-bottom: 20px; padding-top: 8px;
}

.form-grid {
  display: grid; grid-template-columns: 1fr 1fr; gap: 20px;
  margin-bottom: 28px;
}
.form-grid-single { grid-template-columns: 1fr; }

.form-group { display: flex; flex-direction: column; gap: 8px; }

label {
  font-size: 9px; font-weight: 700;
  letter-spacing: 0.16em; text-transform: uppercase;
  color: rgba(184,197,216,0.45);
  font-family: 'DM Mono', monospace;
}

input[type="text"],
input[type="email"],
input[type="tel"],
select,
textarea {
  background: rgba(255,255,255,0.055);
  border: 1px solid rgba(255,255,255,0.1);
  color: #f5f7fa; padding: 14px 16px;
  font-size: 14px; font-family: 'DM Sans', sans-serif;
  font-weight: 300; outline: none; width: 100%;
  transition: border-color 0.2s, background 0.2s;
}
input:focus, select:focus, textarea:focus {
  border-color: rgba(201,168,76,0.6);
  background: rgba(255,255,255,0.08);
}
input::placeholder, textarea::placeholder { color: rgba(184,197,216,0.3); }
input.error, textarea.error { border-color: rgba(231,76,60,0.5); }

select { cursor: pointer; }
select option { background: #0f2347; color: #f5f7fa; }

textarea { resize: vertical; min-height: 130px; line-height: 1.7; }

.err-msg {
  font-size: 10px; color: rgba(231,76,60,0.8);
  font-family: 'DM Mono', monospace;
}

.form-divider {
  height: 1px; background: rgba(255,255,255,0.07);
  margin: 8px 0 28px;
}

/* ── Submit Row ──────────────────────────────── */
.submit-row {
  display: flex; align-items: center; gap: 24px;
  margin-top: 16px;
}

.btn-submit {
  position: relative;
  display: inline-flex; align-items: center; gap: 10px;
  background: linear-gradient(135deg, #c9a84c 0%, #e8cf8a 50%, #c9a84c 100%);
  background-size: 200% auto;
  color: #0b1c38;
  font-size: 11px; font-weight: 700;
  letter-spacing: 0.2em; text-transform: uppercase;
  padding: 16px 36px; border: none; cursor: pointer;
  font-family: 'DM Sans', sans-serif;
  overflow: hidden;
  transition: background-position 0.5s ease, transform 0.2s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 20px rgba(201,168,76,0.3);
}
.btn-submit:disabled { opacity: 0.7; cursor: not-allowed; transform: none !important; }
.btn-submit:not(:disabled):hover {
  background-position: right center;
  transform: translateY(-3px);
  box-shadow: 0 10px 36px rgba(201,168,76,0.45);
}
.btn-shimmer {
  position: absolute; inset: 0;
  background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.35) 50%, transparent 60%);
  transform: translateX(-100%); transition: transform 0s;
}
.btn-submit:hover .btn-shimmer {
  transform: translateX(100%); transition: transform 0.5s ease;
}
.btn-spinner { display: flex; align-items: center; gap: 10px; }
.spinner {
  width: 14px; height: 14px; border-radius: 50%;
  border: 2px solid rgba(11,28,56,0.3);
  border-top-color: #0b1c38;
  animation: spin 0.8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }
.btn-success { color: #0b1c38; font-weight: 700; }

.submit-note {
  font-size: 11px; color: rgba(184,197,216,0.3);
  font-weight: 300; font-family: 'DM Mono', monospace;
  max-width: 36ch; line-height: 1.6;
}

/* ── Responsive ──────────────────────────────── */
@media (max-width: 1024px) {
  .elig-grid { grid-template-columns: 1fr; gap: 32px; }
}
@media (max-width: 768px) {
  .section-grey { padding: 72px 0; }
  .container { padding: 0 24px; }
  .form-wrap { padding: 72px 0; }
  .form-container { padding: 0 24px; }
  .form-grid { grid-template-columns: 1fr; }
  .submit-row { flex-direction: column; align-items: flex-start; }
  .btn-submit { width: 100%; justify-content: center; }
}
</style>
