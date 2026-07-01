<template>
  <div class="portfolio-section" id="p0">
    <div class="section-inner">
      <div class="hero-grid">

        <!-- Left: text content -->
        <div class="hero-left">
          <div class="status-pill" v-if="data.available">
            <div class="pulse"></div>
            {{ data.availableText }}
          </div>

          <h1 class="hero-unified-name">
            {{ data.name }}<span>.</span>
          </h1>

          <div class="hero-role-line">
            <span class="prompt">❯_&nbsp;</span>
            <span class="typed-word">{{ typedText }}</span>
            <span class="cur"></span>
          </div>

          <p class="hero-bio">{{ data.bio }}</p>

          <div class="hero-actions">
            <button class="btn-primary" @click="$emit('navigate', 2)">
              <i class="fas fa-code"></i> Projects Grid
            </button>
            <button class="btn-ghost" @click="$emit('navigate', 4)">
              <i class="far fa-envelope"></i> Open Connection
            </button>
          </div>
        </div>

        <!-- Right: profile image -->
        <div class="hero-profile-container">
          <div class="hero-image-frame">
            <img
              :src="data.profileImage"
              :alt="data.name"
              @error="onImgError"
            />
            <div class="hero-pic-tag" v-html="data.picTag"></div>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { useTyping } from '@/composables/useTyping.js'

const props = defineProps({
  data: { type: Object, required: true }
})

const emit = defineEmits(['navigate'])

const { typedText } = useTyping(props.data.roles)

function onImgError(e) {
  e.target.src = props.data.profileFallback
}
</script>

<style scoped>
.hero-grid {
  display: grid;
  grid-template-columns: 1.1fr 0.9fr;
  gap: 50px;
  align-items: center;
}

/* Status pill */
.status-pill {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-family: var(--ff-mono);
  font-size: 0.72rem;
  color: var(--green);
  background: rgba(16, 185, 129, 0.1);
  border: 1px solid rgba(16, 185, 129, 0.25);
  padding: 6px 14px;
  border-radius: 20px;
  margin-bottom: 22px;
}
.pulse {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: var(--green);
  animation: pGlow 2s infinite;
}

/* Name */
.hero-unified-name {
  font-family: var(--ff-head);
  font-size: clamp(2.5rem, 5.5vw, 4.2rem);
  font-weight: 800;
  line-height: 1.1;
  letter-spacing: -2px;
  margin-bottom: 16px;
  color: var(--text);
}
.hero-unified-name span { color: var(--cyan); }

/* Role typing line */
.hero-role-line {
  font-family: var(--ff-mono);
  font-size: clamp(0.85rem, 2vw, 1.05rem);
  color: var(--muted);
  margin-bottom: 22px;
}
.prompt   { color: var(--cyan); }
.typed-word { color: var(--gold); }
.cur {
  display: inline-block;
  width: 9px;
  height: 18px;
  background: var(--cyan);
  vertical-align: middle;
  animation: blk 0.85s infinite;
}

/* Bio */
.hero-bio {
  font-size: 1rem;
  color: var(--muted);
  line-height: 1.85;
  max-width: 500px;
  margin-bottom: 32px;
}

/* Action buttons row */
.hero-actions {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
  margin-bottom: 36px;
}

/* Profile image */
.hero-profile-container {
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}
.hero-image-frame {
  width:  clamp(240px, 28vw, 340px);
  height: clamp(240px, 28vw, 340px);
  border-radius: 24px;
  position: relative;
  background: #050c1a;
  border: 1px solid rgba(34, 211, 238, 0.25);
  padding: 12px;
}
.hero-image-frame img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 16px;
}
.hero-pic-tag {
  position: absolute;
  bottom: -15px;
  left: 50%;
  transform: translateX(-50%);
  background: rgba(6, 13, 31, 0.95);
  border: 1px solid var(--cyan);
  backdrop-filter: blur(12px);
  padding: 6px 20px;
  border-radius: 30px;
  font-family: var(--ff-head);
  font-size: 0.85rem;
  font-weight: 700;
  white-space: nowrap;
}
.hero-pic-tag :deep(span) { color: var(--cyan); }

/* Responsive */
@media (max-width: 960px) {
  .hero-grid {
    grid-template-columns: 1fr;
    gap: 30px;
  }
  .hero-profile-container { order: -1; }
}
</style>