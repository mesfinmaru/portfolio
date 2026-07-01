<template>
  <div class="panel">
    <div class="panel-title"><i class="fas fa-address-book"></i> Contact Info</div>

    <div class="admin-form-group">
      <label>Primary Email</label>
      <input v-model="form.email" type="email" />
    </div>
    <div class="admin-form-group">
      <label>Phone (display)</label>
      <input v-model="form.phone" type="text" placeholder="+251 92 008 9841" />
    </div>
    <div class="admin-form-group">
      <label>Phone (tel: link, no spaces)</label>
      <input v-model="form.phoneRaw" type="text" placeholder="+251920089841" />
    </div>
    <div class="admin-form-group">
      <label>GitHub URL</label>
      <input v-model="form.github" type="url" />
    </div>
    <div class="admin-form-group">
      <label>LinkedIn URL</label>
      <input v-model="form.linkedin" type="url" />
    </div>
    <div class="admin-form-group">
      <label>Telegram URL</label>
      <input v-model="form.telegram" type="url" />
    </div>
    <div class="admin-form-group">
      <label>University / Affiliation</label>
      <input v-model="form.university" type="text" />
    </div>
    <div class="admin-form-group">
      <label>Copyright Name</label>
      <input v-model="form.copyrightName" type="text" />
    </div>
    <div class="admin-form-group">
      <label>Copyright Year</label>
      <input v-model.number="form.copyrightYear" type="number" />
    </div>

    <div class="panel-actions">
      <button class="btn-primary" :disabled="saving" @click="save">
        <i class="fas fa-save"></i> {{ saving ? 'Saving…' : 'Save Contact' }}
      </button>
    </div>
    <div class="save-success" v-if="saved"><i class="fas fa-check-circle"></i> Saved successfully.</div>
  </div>
</template>

<script setup>
import { reactive, ref, watch } from 'vue'
import { usePortfolio } from '@/composables/usePortfolio.js'
import { useAdmin }     from '@/composables/useAdmin.js'

const props = defineProps({ contact: { type: Object, required: true } })

const { updateContact } = usePortfolio()
const { adminToken }    = useAdmin()

const form   = reactive({ ...props.contact })
const saving = ref(false)
const saved  = ref(false)

watch(() => props.contact, (c) => Object.assign(form, c), { deep: true })

async function save() {
  saving.value = true
  await updateContact({ ...form }, adminToken.value)
  saving.value = false
  saved.value  = true
  setTimeout(() => { saved.value = false }, 3000)
}
</script>