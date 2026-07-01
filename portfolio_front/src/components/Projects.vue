<template>
  <div class="portfolio-section" id="p2">
    <div class="section-inner">
      <div class="sec-label">Selected Systems</div>
      <h2 class="sec-title">Production <span class="hl">Artifacts</span></h2>
      <div class="divider"></div>

      <div class="proj-grid">
        <div
          class="proj-card"
          v-for="project in projects"
          :key="project.id"
        >
          <!-- Code preview pane -->
          <div class="code-pane">
            <div
              class="cp"
              v-for="line in project.codeSnippet"
              :key="line.n"
            >
              <span class="cp-n">{{ line.n }}</span>
              <span v-html="line.html"></span>
            </div>
          </div>

          <!-- Card body -->
          <div class="card-body">
            <div class="ptags">
              <span class="ptag" v-for="tag in project.tags" :key="tag">{{ tag }}</span>
            </div>
            <h3 class="p-title">{{ project.title }}</h3>
            <p class="p-desc">{{ project.desc }}</p>

            <div class="card-link">
              <!-- GitHub link -->
              <a
                v-if="project.linkType === 'github' && project.linkUrl"
                :href="project.linkUrl"
                target="_blank"
                rel="noopener noreferrer"
                class="btn-ghost"
              >
                <i class="fab fa-github"></i> {{ project.linkLabel }}
              </a>
              <!-- Docs button -->
              <button
                v-else-if="project.linkType === 'docs'"
                class="btn-ghost"
              >
                <i class="fas fa-book"></i> {{ project.linkLabel }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  projects: { type: Array, required: true }
})
</script>

<style scoped>
.proj-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 22px;
}

/* Project card */
.proj-card {
  background: var(--bg-card);
  border: 1px solid var(--border-sub);
  border-radius: var(--radius);
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transition: all 0.3s;
}
.proj-card:hover {
  border-color: rgba(34, 211, 238, 0.35);
  transform: translateY(-4px);
}

/* Code pane */
.code-pane {
  background: #03070f;
  border-bottom: 1px solid var(--border-sub);
  padding: 18px 20px;
  font-family: var(--ff-mono);
  font-size: 0.73rem;
  line-height: 1.7;
  height: 130px;
  overflow: hidden;
  position: relative;
}
.code-pane::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(transparent 60%, #03070f);
}

.cp {
  display: flex;
  gap: 10px;
}
.cp-n    { color: #1e3050; min-width: 14px; text-align: right; }
/* Code colour classes used in v-html snippets */
:deep(.cp-kw) { color: #c792ea; }
:deep(.cp-fn) { color: var(--gold); }
:deep(.cp-ty) { color: var(--cyan); }
:deep(.cp-st) { color: var(--green); }
:deep(.cp-cm) { color: var(--muted); }
:deep(.cp-nv) { color: var(--text); }

/* Card body */
.card-body {
  padding: 20px;
  display: flex;
  flex-direction: column;
  flex: 1;
}

.ptags { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 13px; }
.ptag {
  font-family: var(--ff-mono);
  font-size: 0.62rem;
  padding: 3px 9px;
  border-radius: 5px;
  background: rgba(34, 211, 238, 0.07);
  border: 1px solid rgba(34, 211, 238, 0.15);
  color: var(--cyan);
}

.p-title {
  font-family: var(--ff-head);
  font-size: 1.05rem;
  font-weight: 700;
  margin-bottom: 8px;
}
.p-desc {
  font-size: 0.85rem;
  color: var(--muted);
  line-height: 1.7;
  flex: 1;
}
.card-link {
  margin-top: 12px;
}

/* Responsive */
@media (max-width: 1024px) {
  .proj-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
  .proj-grid { grid-template-columns: 1fr; }
}
</style>