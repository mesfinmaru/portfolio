<!-- ============================================================
     HeroPanel.vue — Edit hero section data
============================================================ -->
<template>
  <div class="panel">
    <div class="panel-title"><i class="fas fa-home"></i> Hero Section</div>

    <div class="admin-form-group">
      <label>Full Name</label>
      <input v-model="form.name" type="text" placeholder="Your Name" />
    </div>

    <div class="admin-form-group">
      <label>Bio</label>
      <textarea v-model="form.bio" placeholder="Short bio paragraph..."></textarea>
    </div>

    <div class="admin-form-group">
      <label>Roles (one per line)</label>
      <textarea
        v-model="rolesText"
        placeholder="Role 1&#10;Role 2&#10;Role 3"
        style="min-height:80px"
      ></textarea>
    </div>

    <div class="admin-form-group">
      <label>Profile Image Path</label>
      <input v-model="form.profileImage" type="text" placeholder="/me.jpg" />
    </div>

    <div class="admin-form-group">
      <label>Available for work?</label>
      <select v-model="form.available">
        <option :value="true">Yes – show status pill</option>
        <option :value="false">No – hide status pill</option>
      </select>
    </div>

    <div class="admin-form-group" v-if="form.available">
      <label>Availability Text</label>
      <input v-model="form.availableText" type="text" />
    </div>

    <div class="panel-actions">
      <button class="btn-primary" :disabled="saving" @click="save">
        <i class="fas fa-save"></i> {{ saving ? 'Saving…' : 'Save Hero' }}
      </button>
    </div>

    <div class="save-success" v-if="saved"><i class="fas fa-check-circle"></i> Saved successfully.</div>
  </div>
</template>

<script setup>
import { reactive, ref, computed, watch } from 'vue'
import { usePortfolio } from '@/composables/usePortfolio.js'
import { useAdmin }     from '@/composables/useAdmin.js'

const props = defineProps({ hero: { type: Object, required: true } })

const { updateHero } = usePortfolio()
const { adminToken } = useAdmin()

const form    = reactive({ ...props.hero })
const rolesText = ref((props.hero.roles || []).join('\n'))
const saving  = ref(false)
const saved   = ref(false)

watch(() => props.hero, (h) => {
  Object.assign(form, h)
  rolesText.value = (h.roles || []).join('\n')
}, { deep: true })

async function save() {
  saving.value = true
  saved.value  = false
  const payload = {
    ...form,
    roles: rolesText.value.split('\n').map(r => r.trim()).filter(Boolean)
  }
  await updateHero(payload, adminToken.value)
  saving.value = false
  saved.value  = true
  setTimeout(() => { saved.value = false }, 3000)
}
</script>