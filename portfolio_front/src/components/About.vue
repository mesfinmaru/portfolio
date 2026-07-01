<template>
  <div class="portfolio-section" id="p1">
    <div class="section-inner">
      <div class="sec-label">Architecture Background</div>
      <h2 class="sec-title">Bridging Business &amp; <span class="hl">Logic</span></h2>
      <div class="divider"></div>

      <div class="about-grid">

        <!-- Left: text + chips -->
        <div class="about-text">
          <p v-for="(para, i) in data.paragraphs" :key="i">{{ para }}</p>

          <div class="info-chips">
            <div class="chip" v-for="chip in data.chips" :key="chip.label">
              <span class="c-lbl">{{ chip.label }}</span>
              <span class="c-val">{{ chip.value }}</span>
            </div>
          </div>
        </div>

        <!-- Right: timeline -->
        <div class="about-timeline">
          <div class="timeline">
            <div
              class="tl-item"
              v-for="item in data.timeline"
              :key="item.id"
            >
              <div class="tl-date">{{ item.date }}</div>
              <div class="tl-ttl">{{ item.title }}</div>
              <div class="tl-desc">{{ item.desc }}</div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  data: { type: Object, required: true }
})
</script>

<style scoped>
.about-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
}

/* Text column */
.about-text p {
  color: var(--muted);
  font-size: 0.97rem;
  line-height: 1.9;
  margin-bottom: 16px;
}

/* Info chips */
.info-chips {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
  margin-top: 28px;
}
.chip {
  background: var(--bg-card);
  border: 1px solid var(--border-sub);
  border-radius: 10px;
  padding: 13px 16px;
  display: flex;
  flex-direction: column;
  gap: 3px;
}
.chip .c-lbl {
  font-family: var(--ff-mono);
  font-size: 0.62rem;
  color: var(--muted);
  text-transform: uppercase;
  letter-spacing: 1px;
}
.chip .c-val {
  font-size: 0.88rem;
  font-weight: 500;
}

/* Timeline */
.timeline {
  padding-left: 18px;
  position: relative;
}
.timeline::before {
  content: '';
  position: absolute;
  left: 0;
  top: 8px;
  bottom: 8px;
  width: 1px;
  background: linear-gradient(to bottom, var(--cyan), transparent);
}
.tl-item {
  position: relative;
  padding-left: 22px;
  padding-bottom: 30px;
}
.tl-item::before {
  content: '';
  position: absolute;
  left: -4px;
  top: 7px;
  width: 9px;
  height: 9px;
  border-radius: 50%;
  background: var(--cyan);
  box-shadow: 0 0 10px var(--cyan);
}
.tl-date {
  font-family: var(--ff-mono);
  font-size: 0.68rem;
  color: var(--cyan);
  margin-bottom: 4px;
}
.tl-ttl {
  font-family: var(--ff-head);
  font-size: 0.98rem;
  font-weight: 700;
  margin-bottom: 5px;
}
.tl-desc {
  font-size: 0.84rem;
  color: var(--muted);
  line-height: 1.65;
}

/* Responsive */
@media (max-width: 960px) {
  .about-grid { grid-template-columns: 1fr; gap: 30px; }
}
@media (max-width: 480px) {
  .info-chips { grid-template-columns: 1fr; }
}
</style>