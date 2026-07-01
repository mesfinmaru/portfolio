<template>
  <div class="app-root">
    <!-- Background layers -->
    <div class="bg-layer bg-dots"></div>
    <div class="bg-layer noise"></div>

    <!-- Fixed top navigation -->
    <TheNavBar
      :current-page="currentPage"
      logo-src="/logo.png"
      @navigate="switchPage"
    />

    <!-- Horizontal carousel viewport -->
    <div class="viewport-window">
      <div
        class="horizontal-track"
        :style="{ transform: `translateX(-${currentPage * 100}vw)` }"
      >
        <HeroSection     :data="data.hero"     @navigate="switchPage" />
        <AboutSection    :data="data.about" />
        <ProjectsSection :projects="data.projects" />
        <StackSection    :skills="data.skills" />
        <ContactSection  :contact="data.contact" />
      </div>
    </div>

    <!-- Fixed bottom footer (contains hidden admin trigger) -->
    <TheFooter :contact="data.contact" />

    <!-- Admin overlay (only mounted once unlocked) -->
    <AdminOverlay v-if="isAdminVisible" />

    <!-- Loading indicator while fetching from Laravel API -->
    <div class="api-loading" v-if="loading">
      <i class="fas fa-circle-notch fa-spin"></i> Loading…
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'

import TheNavBar       from '@/components/TheNavBar.vue'
import TheFooter        from '@/components/TheFooter.vue'
import HeroSection      from '@/sections/HeroSection.vue'
import AboutSection     from '@/sections/AboutSection.vue'
import ProjectsSection  from '@/sections/ProjectsSection.vue'
import StackSection     from '@/sections/StackSection.vue'
import ContactSection   from '@/sections/ContactSection.vue'
import AdminOverlay     from '@/admin/AdminOverlay.vue'

import { usePortfolio } from '@/composables/usePortfolio.js'
import { useAdmin }     from '@/composables/useAdmin.js'
import { usePageRouter } from '@/composables/usePageRouter.js'

const { data, loading, loadData } = usePortfolio()
const { isAdminVisible }          = useAdmin()
const { currentPage, switchPage } = usePageRouter()

onMounted(() => {
  loadData()
})
</script>

<style scoped>
.app-root {
  width: 100vw;
  height: 100vh;
  overflow: hidden;
  position: relative;
}

.api-loading {
  position: fixed;
  top: calc(var(--nav-h) + 12px);
  right: 20px;
  z-index: 1500;
  font-family: var(--ff-mono);
  font-size: 0.72rem;
  color: var(--cyan);
  background: rgba(8, 16, 36, 0.9);
  border: 1px solid var(--border);
  padding: 8px 14px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  gap: 8px;
  backdrop-filter: blur(10px);
}
</style>
