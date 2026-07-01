<template>
  <div class="panel">
    <div class="panel-title"><i class="fas fa-layer-group"></i> Tech Stack</div>

    <div v-for="cat in categories" :key="cat.key">
      <div class="subsection-head">{{ cat.label }}</div>

      <div class="skill-list">
        <div
          class="skill-item"
          v-for="skill in skills[cat.key]"
          :key="skill.id"
        >
          <div class="skill-preview">
            <i :class="skill.icon" :style="{ color: skill.iconColor }"></i>
            <span>{{ skill.label }}</span>
          </div>
          <div class="skill-item-actions">
            <button class="btn-ghost icon-btn" @click="startEdit(cat.key, skill)">
              <i class="fas fa-pen"></i>
            </button>
            <button class="btn-danger icon-btn" @click="removeSkill(cat.key, skill.id)">
              <i class="fas fa-trash"></i>
            </button>
          </div>

          <!-- Inline edit -->
          <div class="skill-edit" v-if="editing && editing.id === skill.id && editing.cat === cat.key">
            <div class="edit-fields">
              <div class="admin-form-group">
                <label>Icon Class (FontAwesome)</label>
                <input v-model="editForm.icon" type="text" placeholder="fab fa-php" />
              </div>
              <div class="admin-form-group">
                <label>Icon Color</label>
                <div class="color-row">
                  <input v-model="editForm.iconColor" type="text" placeholder="#777bb4" />
                  <input v-model="editForm.iconColor" type="color" class="color-swatch" />
                </div>
              </div>
              <div class="admin-form-group">
                <label>Label</label>
                <input v-model="editForm.label" type="text" />
              </div>
            </div>
            <div class="edit-actions">
              <button class="btn-primary" @click="saveEdit(cat.key)"><i class="fas fa-save"></i> Save</button>
              <button class="btn-ghost"  @click="editing = null">Cancel</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Add new skill in this category -->
      <div class="add-skill-row">
        <div class="add-skill-fields">
          <input
            v-model="newSkills[cat.key].icon"
            type="text"
            placeholder="fab fa-php"
            class="mini-input"
          />
          <div class="color-row">
            <input v-model="newSkills[cat.key].iconColor" type="text" placeholder="#hex" class="mini-input" />
            <input v-model="newSkills[cat.key].iconColor" type="color" class="color-swatch" />
          </div>
          <input
            v-model="newSkills[cat.key].label"
            type="text"
            placeholder="Skill label"
            class="mini-input flex-1"
          />
        </div>
        <button class="btn-ghost add-btn" @click="addSkill(cat.key)">
          <i class="fas fa-plus"></i> Add
        </button>
      </div>

      <div class="divider" v-if="cat.key !== categories[categories.length - 1].key"></div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { usePortfolio }  from '@/composables/usePortfolio.js'
import { useAdmin }      from '@/composables/useAdmin.js'

const props = defineProps({ skills: { type: Object, required: true } })

const { createSkill, updateSkill, deleteSkill } = usePortfolio()
const { adminToken } = useAdmin()

const categories = [
  { key: 'languages',      label: 'Development Languages' },
  { key: 'infrastructure', label: 'Infrastructure & Server Ecosystem' }
]

const editing  = ref(null)
const editForm = reactive({ icon: '', iconColor: '', label: '' })

const newSkills = reactive({
  languages:      { icon: '', iconColor: '#ffffff', label: '' },
  infrastructure: { icon: '', iconColor: '#ffffff', label: '' }
})

function startEdit(cat, skill) {
  editing.value = { id: skill.id, cat }
  Object.assign(editForm, { icon: skill.icon, iconColor: skill.iconColor, label: skill.label })
}

async function saveEdit(cat) {
  await updateSkill(cat, editing.value.id, { ...editForm }, adminToken.value)
  editing.value = null
}

async function addSkill(cat) {
  const n = newSkills[cat]
  if (!n.label.trim()) return
  await createSkill(cat, { icon: n.icon, iconColor: n.iconColor, label: n.label }, adminToken.value)
  Object.assign(newSkills[cat], { icon: '', iconColor: '#ffffff', label: '' })
}

async function removeSkill(cat, id) {
  await deleteSkill(cat, id, adminToken.value)
}
</script>

<style scoped>
.skill-list { display: flex; flex-direction: column; gap: 6px; margin-bottom: 12px; }
.skill-item { background: rgba(255,255,255,0.02); border: 1px solid var(--border-sub); border-radius: 8px; }
.skill-preview { display: flex; align-items: center; gap: 10px; padding: 12px 14px; }
.skill-preview i { font-size: 1.1rem; width: 20px; }
.skill-preview span { font-family: var(--ff-mono); font-size: 0.85rem; flex: 1; }
.skill-item-actions { display: flex; gap: 6px; padding: 0 14px 10px; justify-content: flex-end; }
.icon-btn { padding: 6px 9px; font-size: 0.78rem; }
.skill-edit { padding: 12px 14px; border-top: 1px solid var(--border-sub); }
.edit-fields { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px; }
.edit-actions { display: flex; gap: 8px; margin-top: 8px; }

.add-skill-row { display: flex; align-items: flex-end; gap: 8px; margin-bottom: 16px; }
.add-skill-fields { display: flex; gap: 6px; flex: 1; align-items: center; flex-wrap: wrap; }
.mini-input {
  font-family: var(--ff-body);
  font-size: 0.85rem;
  background: rgba(255,255,255,0.04);
  border: 1px solid var(--border-sub);
  border-radius: 7px;
  padding: 8px 11px;
  color: var(--text);
  outline: none;
  min-width: 100px;
}
.mini-input.flex-1 { flex: 1; }
.mini-input:focus { border-color: var(--cyan); }
.add-btn { padding: 8px 14px; font-size: 0.78rem; white-space: nowrap; }

.color-row { display: flex; align-items: center; gap: 6px; }
.color-swatch {
  width: 32px; height: 32px;
  border-radius: 6px;
  border: 1px solid var(--border-sub);
  background: none;
  cursor: pointer;
  padding: 2px;
}

.subsection-head {
  font-family: var(--ff-mono);
  font-size: 0.7rem;
  color: var(--cyan);
  text-transform: uppercase;
  letter-spacing: 2px;
  margin-bottom: 12px;
}
</style>