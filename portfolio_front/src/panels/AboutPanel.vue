<template>
  <div class="panel">
    <div class="panel-title"><i class="fas fa-user"></i> About Section</div>

    <!-- Bio paragraphs -->
    <div class="subsection-head">Bio Paragraphs</div>
    <div
      class="para-row"
      v-for="(para, idx) in form.paragraphs"
      :key="idx"
    >
      <div class="admin-form-group" style="flex:1">
        <label>Paragraph {{ idx + 1 }}</label>
        <textarea v-model="form.paragraphs[idx]" style="min-height:70px"></textarea>
      </div>
      <button class="btn-danger remove-btn" @click="removeParagraph(idx)" title="Remove">
        <i class="fas fa-trash"></i>
      </button>
    </div>
    <button class="btn-ghost add-btn" @click="addParagraph">
      <i class="fas fa-plus"></i> Add Paragraph
    </button>

    <div class="divider"></div>

    <!-- Info chips -->
    <div class="subsection-head">Info Chips</div>
    <div
      class="chip-row"
      v-for="(chip, idx) in form.chips"
      :key="idx"
    >
      <div class="admin-form-group" style="flex:1">
        <label>Label</label>
        <input v-model="form.chips[idx].label" type="text" />
      </div>
      <div class="admin-form-group" style="flex:1">
        <label>Value</label>
        <input v-model="form.chips[idx].value" type="text" />
      </div>
      <button class="btn-danger remove-btn" @click="removeChip(idx)">
        <i class="fas fa-trash"></i>
      </button>
    </div>
    <button class="btn-ghost add-btn" @click="addChip">
      <i class="fas fa-plus"></i> Add Chip
    </button>

    <div class="divider"></div>

    <!-- Timeline -->
    <div class="subsection-head">Timeline</div>
    <div
      class="tl-edit-row"
      v-for="(item, idx) in form.timeline"
      :key="item.id"
    >
      <div class="tl-fields">
        <div class="admin-form-group">
          <label>Date Range</label>
          <input v-model="form.timeline[idx].date" type="text" placeholder="2024 - Present" />
        </div>
        <div class="admin-form-group">
          <label>Title</label>
          <input v-model="form.timeline[idx].title" type="text" />
        </div>
        <div class="admin-form-group">
          <label>Description</label>
          <textarea v-model="form.timeline[idx].desc"></textarea>
        </div>
      </div>
      <button class="btn-danger remove-btn" @click="removeTlItem(idx)">
        <i class="fas fa-trash"></i>
      </button>
    </div>
    <button class="btn-ghost add-btn" @click="addTlItem">
      <i class="fas fa-plus"></i> Add Timeline Item
    </button>

    <div class="panel-actions">
      <button class="btn-primary" :disabled="saving" @click="save">
        <i class="fas fa-save"></i> {{ saving ? 'Saving…' : 'Save About' }}
      </button>
    </div>
    <div class="save-success" v-if="saved"><i class="fas fa-check-circle"></i> Saved successfully.</div>
  </div>
</template>

<script setup>
import { reactive, ref, watch } from 'vue'
import { usePortfolio } from '@/composables/usePortfolio.js'
import { useAdmin }     from '@/composables/useAdmin.js'

const props = defineProps({ about: { type: Object, required: true } })

const { updateAbout } = usePortfolio()
const { adminToken }  = useAdmin()

const form   = reactive(JSON.parse(JSON.stringify(props.about)))
const saving = ref(false)
const saved  = ref(false)

watch(() => props.about, (a) => { Object.assign(form, JSON.parse(JSON.stringify(a))) }, { deep: true })

function addParagraph()  { form.paragraphs.push('') }
function removeParagraph(i) { form.paragraphs.splice(i, 1) }
function addChip()  { form.chips.push({ label: '', value: '' }) }
function removeChip(i) { form.chips.splice(i, 1) }
function addTlItem()  { form.timeline.push({ id: Date.now(), date: '', title: '', desc: '' }) }
function removeTlItem(i) { form.timeline.splice(i, 1) }

async function save() {
  saving.value = true
  await updateAbout({ ...form }, adminToken.value)
  saving.value = false
  saved.value  = true
  setTimeout(() => { saved.value = false }, 3000)
}
</script>

<style scoped>
.para-row, .chip-row, .tl-edit-row {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  margin-bottom: 8px;
}
.tl-fields { flex: 1; background: rgba(255,255,255,0.02); border: 1px solid var(--border-sub); border-radius: 8px; padding: 14px; }
.remove-btn { margin-top: 22px; padding: 8px 10px; flex-shrink: 0; }
.add-btn { margin-bottom: 16px; font-size: 0.78rem; padding: 8px 14px; }
.subsection-head {
  font-family: var(--ff-mono);
  font-size: 0.7rem;
  color: var(--cyan);
  text-transform: uppercase;
  letter-spacing: 2px;
  margin-bottom: 12px;
}
</style>