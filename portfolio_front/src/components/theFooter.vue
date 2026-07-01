<template>
  <footer>
    <div class="footer-left">
      <!-- Copyright text is the secret admin trigger (5 clicks) -->
      <span
        class="copyright-btn"
        @click="handleAdminClick"
        :title="adminHint"
      >&copy; {{ contact.copyrightYear }} {{ contact.copyrightName }}.</span>
    </div>

    <div class="footer-right">
      <!-- Phone with hover-expand inline display -->
      <div class="phone-channel-container">
        <a
          :href="`tel:${contact.phoneRaw}`"
          class="f-chan f-chan-phone"
          title="Call Node"
        ><i class="fas fa-phone-alt"></i></a>
        <div class="phone-inline-display">{{ contact.phone }}</div>
      </div>

      <a :href="contact.github"   target="_blank" class="f-chan" title="GitHub">
        <i class="fab fa-github"></i>
      </a>
      <a :href="contact.linkedin" target="_blank" class="f-chan" title="LinkedIn">
        <i class="fab fa-linkedin-in"></i>
      </a>
      <a :href="`mailto:${contact.email}`" class="f-chan" title="Email">
        <i class="far fa-envelope"></i>
      </a>
      <a :href="contact.telegram" target="_blank" class="f-chan" title="Telegram">
        <i class="fab fa-telegram"></i>
      </a>
    </div>
  </footer>
</template>

<script setup>
import { computed } from 'vue'
import { useAdmin } from '@/composables/useAdmin.js'

const props = defineProps({
  contact: { type: Object, required: true }
})

const { handleSecretClick, isAdminVisible } = useAdmin()

// Show a subtle hint when user has started clicking (optional UX polish)
const adminHint = computed(() =>
  isAdminVisible.value ? 'Admin panel active' : ''
)

function handleAdminClick() {
  handleSecretClick()
}
</script>

<style scoped>
footer {
  position: fixed;
  bottom: 0; left: 0; right: 0;
  height: var(--footer-h);
  z-index: 1000;
  padding: 0 clamp(18px, 5vw, 80px);
  background: rgba(3, 7, 18, 0.92);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  border-top: 1px solid var(--border-sub);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* Copyright – looks like plain text, secretly clickable */
.copyright-btn {
  font-family: var(--ff-mono);
  font-size: 0.73rem;
  color: var(--muted);
  cursor: default;
  user-select: none;
  /* No hover style so it looks like static text */
  transition: none;
}

.footer-right {
  display: flex;
  gap: 10px;
  align-items: center;
}

.f-chan {
  width: 36px;
  height: 36px;
  border-radius: 8px;
  border: 1px solid var(--border-sub);
  color: var(--muted);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
  background: rgba(255, 255, 255, 0.01);
  transition: all 0.25s ease;
  text-decoration: none;
}
.f-chan:hover {
  color: var(--cyan);
  border-color: var(--cyan);
  background: var(--cyan-glow);
  transform: translateY(-2px);
}

/* Phone hover-expand mechanism */
.phone-channel-container {
  display: flex;
  align-items: center;
  order: -1;
}
.phone-inline-display {
  max-width: 0;
  overflow: hidden;
  white-space: nowrap;
  font-family: var(--ff-mono);
  font-size: 0.78rem;
  color: var(--cyan);
  background: var(--cyan-glow);
  border: 1px solid transparent;
  height: 36px;
  display: flex;
  align-items: center;
  border-radius: 0 8px 8px 0;
  padding: 0;
  transition:
    max-width 0.3s cubic-bezier(0.16, 1, 0.3, 1),
    padding 0.3s,
    border-color 0.3s;
}
.phone-channel-container:hover .phone-inline-display {
  max-width: 160px;
  padding: 0 14px;
  border-color: var(--border);
  border-left: none;
}
.phone-channel-container:hover .f-chan-phone {
  border-radius: 8px 0 0 8px !important;
  color: var(--cyan);
  border-color: var(--border);
  background: var(--cyan-glow);
}

/* Disable expand on touch devices */
@media (hover: none), (pointer: coarse) {
  .phone-inline-display { display: none; }
  .phone-channel-container:hover .f-chan-phone {
    border-radius: 8px !important;
    color: var(--muted);
    border-color: var(--border-sub);
    background: rgba(255, 255, 255, 0.01);
  }
}
</style>
