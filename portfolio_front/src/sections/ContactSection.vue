<template>
  <div class="portfolio-section" id="p4">
    <div class="section-inner">
      <div class="sec-label">Secure Terminal Connection</div>
      <h2 class="sec-title">Initialize <span class="hl">Contact</span></h2>
      <div class="divider"></div>

      <div class="contact-layout">

        <!-- Left: info card -->
        <div class="contact-left">
          <p class="contact-lead">
            Have an application engineering requirement, software project design inquiry, or freelance system alignment role? Submit details to route communications immediately.
          </p>

          <div class="contact-card">
            <div class="contact-row">
              <div class="c-icon"><i class="far fa-envelope"></i></div>
              <div class="c-info">
                <div class="c-lbl">Primary Electronic Mail</div>
                <div class="c-val">{{ contact.email }}</div>
              </div>
            </div>
            <div class="contact-row">
              <div class="c-icon"><i class="fas fa-university"></i></div>
              <div class="c-info">
                <div class="c-lbl">Academic Affiliation</div>
                <div class="c-val">{{ contact.university }}</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right: contact form -->
        <div class="contact-right">
          <div class="form-wrap">

            <div class="f-group" :class="{ error: errors.name }">
              <label>Identity</label>
              <input
                v-model="form.name"
                type="text"
                placeholder="Name or Organization"
                @input="clearError('name')"
              />
              <span class="field-error">{{ errors.name }}</span>
            </div>

            <div class="f-group" :class="{ error: errors.email }">
              <label>Contact Address</label>
              <input
                v-model="form.email"
                type="email"
                placeholder="name@example.com"
                @input="clearError('email')"
              />
              <span class="field-error">{{ errors.email }}</span>
            </div>

            <div class="f-group" :class="{ error: errors.msg }">
              <label>Description</label>
              <textarea
                v-model="form.msg"
                placeholder="Please provide a brief description of your inquiry..."
                @input="clearError('msg')"
              ></textarea>
              <span class="field-error">{{ errors.msg }}</span>
            </div>

            <button class="btn-primary" @click="submitForm">
              <i class="far fa-paper-plane"></i> Send
            </button>

          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive } from 'vue'

const props = defineProps({
  contact: { type: Object, required: true }
})

const form   = reactive({ name: '', email: '', msg: '' })
const errors = reactive({ name: '', email: '', msg: '' })

function clearError(field) {
  errors[field] = ''
}

function validate() {
  let valid = true
  if (!form.name.trim()) {
    errors.name = 'Enter your name or organization.'
    valid = false
  }
  if (!form.email.trim()) {
    errors.email = 'Enter a contact email.'
    valid = false
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
    errors.email = 'Enter a valid email address.'
    valid = false
  }
  if (!form.msg.trim()) {
    errors.msg = 'Describe your request.'
    valid = false
  }
  return valid
}

function submitForm() {
  if (!validate()) return
  const subject = encodeURIComponent(`System Inquiry from ${form.name}`)
  const body    = encodeURIComponent(
    `Sender Endpoint: ${form.name}\nReturn Layer: ${form.email}\n\nContext Message:\n${form.msg}`
  )
  window.location.href = `mailto:${props.contact.email}?subject=${subject}&body=${body}`
}
</script>

<style scoped>
.contact-layout {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 50px;
}

.contact-lead {
  font-size: 0.97rem;
  color: var(--muted);
  line-height: 1.9;
  margin-bottom: 28px;
}

.contact-card {
  background: var(--bg-card);
  border: 1px solid var(--border-sub);
  border-radius: var(--radius);
  overflow: hidden;
}
.contact-row {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 16px 20px;
  border-bottom: 1px solid var(--border-sub);
}
.contact-row:last-child { border-bottom: none; }

.c-icon {
  width: 38px; height: 38px;
  border-radius: 9px;
  background: rgba(34, 211, 238, 0.08);
  border: 1px solid rgba(34, 211, 238, 0.15);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--cyan);
  flex-shrink: 0;
}
.c-info .c-lbl {
  font-family: var(--ff-mono);
  font-size: 0.62rem;
  color: var(--muted);
  text-transform: uppercase;
}
.c-info .c-val {
  font-size: 0.88rem;
  font-weight: 500;
}

/* Form */
.form-wrap { display: flex; flex-direction: column; gap: 4px; }
.f-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
  margin-bottom: 10px;
}
.f-group label {
  font-family: var(--ff-mono);
  font-size: 0.68rem;
  color: var(--muted);
  text-transform: uppercase;
}
.f-group input,
.f-group textarea {
  font-family: var(--ff-body);
  font-size: 0.9rem;
  background: rgba(255, 255, 255, 0.025);
  border: 1px solid var(--border-sub);
  border-radius: 8px;
  padding: 11px 15px;
  color: var(--text);
  outline: none;
  transition: border-color 0.2s;
}
.f-group input:focus,
.f-group textarea:focus {
  border-color: var(--cyan);
}
.f-group textarea { min-height: 90px; resize: none; }

.f-group.error input,
.f-group.error textarea {
  border-color: #ef4444;
  box-shadow: 0 0 0 1px rgba(239, 68, 68, 0.18);
}

.field-error {
  min-height: 14px;
  font-family: var(--ff-mono);
  font-size: 0.66rem;
  color: #ef4444;
  letter-spacing: 0.6px;
  text-transform: uppercase;
  opacity: 0;
  transform: translateY(-2px);
  transition: opacity 0.2s ease, transform 0.2s ease;
}
.f-group.error .field-error {
  opacity: 1;
  transform: translateY(0);
}

/* Responsive */
@media (max-width: 960px) {
  .contact-layout { grid-template-columns: 1fr; gap: 30px; }
}
</style>
