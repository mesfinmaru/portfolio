<template>
  <nav>
    <!-- Logo image instead of text -->
    <div class="nav-logo" @click="$emit('navigate', 0)" role="button" tabindex="0" @keydown.enter="$emit('navigate', 0)">
      <img :src="logoSrc" alt="Mesfin Maru Logo" class="nav-logo-img" @error="onLogoError" />
    </div>

    <!-- Desktop nav links -->
    <ul class="nav-links">
      <li v-for="(page, idx) in pages" :key="idx">
        <button
          :id="`nb-${idx}`"
          :class="{ active: currentPage === idx }"
          @click="$emit('navigate', idx)"
        >{{ page }}</button>
      </li>
    </ul>

    <!-- Mobile hamburger -->
    <button
      class="hamburger"
      :class="{ open: mobileOpen }"
      @click="toggleMobile"
      aria-label="Toggle menu"
    >
      <span></span><span></span><span></span>
    </button>
  </nav>

  <!-- Mobile dropdown menu -->
  <div class="mob-menu" :class="{ open: mobileOpen }">
    <button
      v-for="(page, idx) in pages"
      :key="idx"
      :class="{ active: currentPage === idx }"
      @click="mobileNavigate(idx)"
    >{{ page }}</button>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  currentPage: { type: Number, default: 0 },
  logoSrc:     { type: String, default: '/logo.png' }
})

const emit = defineEmits(['navigate'])

const pages = ['~/home', '~/about', '~/projects', '~/stack', '~/contact']
const mobileOpen = ref(false)

function toggleMobile() {
  mobileOpen.value = !mobileOpen.value
}

function mobileNavigate(idx) {
  mobileOpen.value = false
  emit('navigate', idx)
}

function onLogoError(e) {
  // Fallback to text if logo.png not found
  e.target.style.display = 'none'
  e.target.parentElement.innerHTML = `Mesfin Maru<span class="dot">.</span>`
}
</script>

<style scoped>
nav {
  position: fixed;
  top: 0; left: 0; right: 0;
  height: var(--nav-h);
  z-index: 1000;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 clamp(18px, 5vw, 80px);
  background: rgba(3, 7, 18, 0.9);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-bottom: 1px solid var(--border);
}

/* Logo image */
.nav-logo {
  cursor: pointer;
  display: flex;
  align-items: center;
  height: 40px;
}
.nav-logo-img {
  height: 38px;
  width: auto;
  object-fit: contain;
  display: block;
  filter: brightness(1.1);
}
/* Fallback text style (injected by JS on error) */
.nav-logo :deep(.dot) { color: var(--cyan); }

/* Desktop nav */
.nav-links {
  display: flex;
  gap: 4px;
  list-style: none;
}
.nav-links button {
  font-family: var(--ff-mono);
  font-size: 0.78rem;
  color: var(--muted);
  padding: 7px 14px;
  border-radius: 8px;
  border: 1px solid transparent;
  transition: all 0.25s ease;
}
.nav-links button:hover,
.nav-links button.active {
  color: var(--cyan);
  border-color: var(--border);
  background: var(--cyan-glow);
}

/* Hamburger */
.hamburger {
  display: none;
  flex-direction: column;
  gap: 5px;
  padding: 6px;
  background: none;
  border: none;
  cursor: pointer;
}
.hamburger span {
  display: block;
  width: 22px;
  height: 2px;
  background: var(--text);
  border-radius: 2px;
  transition: all 0.3s;
}
.hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.hamburger.open span:nth-child(2) { opacity: 0; }
.hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

/* Mobile menu */
.mob-menu {
  display: none;
  flex-direction: column;
  gap: 2px;
  position: fixed;
  top: var(--nav-h);
  left: 0; right: 0;
  background: rgba(3, 7, 18, 0.98);
  backdrop-filter: blur(24px);
  border-bottom: 1px solid var(--border);
  padding: 16px;
  z-index: 999;
}
.mob-menu.open { display: flex; }
.mob-menu button {
  font-family: var(--ff-mono);
  font-size: 0.88rem;
  color: var(--muted);
  text-align: left;
  padding: 12px 16px;
  border-radius: 8px;
  width: 100%;
  transition: all 0.2s;
}
.mob-menu button:hover,
.mob-menu button.active {
  color: var(--cyan);
  background: var(--cyan-glow);
}

@media (max-width: 768px) {
  .nav-links  { display: none; }
  .hamburger  { display: flex; }
}
</style>
