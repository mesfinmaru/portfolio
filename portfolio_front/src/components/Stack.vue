<template>
  <div class="portfolio-section" id="p3">
    <div class="section-inner">
      <div class="sec-label">Technical Matrix</div>
      <h2 class="sec-title">Languages &amp; <span class="hl">Environments</span></h2>
      <div class="divider"></div>

      <div class="skills-layout">

        <!-- Development Languages -->
        <div>
          <div class="sk-col-head">Development Languages</div>
          <div class="badges-list-grid">
            <div
              class="badge-card"
              v-for="skill in skills.languages"
              :key="skill.id"
            >
              <i :class="skill.icon" :style="{ color: skill.iconColor }"></i>
              <span>{{ skill.label }}</span>
            </div>
          </div>
        </div>

        <!-- Infrastructure -->
        <div>
          <div class="sk-col-head">Infrastructure &amp; Server Ecosystem</div>
          <div class="badges-list-grid">
            <div
              class="badge-card"
              v-for="skill in skills.infrastructure"
              :key="skill.id"
            >
              <i :class="skill.icon" :style="{ color: skill.iconColor }"></i>
              <span>{{ skill.label }}</span>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  skills: { type: Object, required: true }
})
</script>

<style scoped>
.skills-layout {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 40px;
}

.sk-col-head {
  font-family: var(--ff-mono);
  font-size: 0.72rem;
  color: var(--muted);
  letter-spacing: 2px;
  text-transform: uppercase;
  padding-bottom: 12px;
  margin-bottom: 22px;
  border-bottom: 1px solid var(--border-sub);
}

.badges-list-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 12px;
}

.badge-card {
  background: rgba(255, 255, 255, 0.02);
  border: 1px solid var(--border-sub);
  border-radius: 10px;
  padding: 18px 20px;
  display: flex;
  align-items: center;
  gap: 14px;
  font-family: var(--ff-mono);
  font-size: 0.85rem;
  color: var(--text);
  transition: all 0.25s;
}
.badge-card i {
  font-size: 1.4rem;
  width: 24px;
  text-align: center;
}
.badge-card:hover {
  border-color: var(--cyan);
  background: var(--cyan-glow);
  color: var(--cyan);
  transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 960px) {
  .skills-layout { grid-template-columns: 1fr; gap: 30px; }
}
@media (max-width: 768px) {
  .badges-list-grid { grid-template-columns: 1fr; }
}
</style>