<template>
  <div class="panel">
    <div class="panel-title"><i class="fas fa-code-branch"></i> Projects</div>

    <!-- Project list -->
    <div class="proj-list">
      <div
        class="proj-item"
        v-for="proj in projects"
        :key="proj.id"
        :class="{ 'is-editing': editingId === proj.id }"
      >
        <!-- Collapsed row -->
        <div class="proj-row" v-if="editingId !== proj.id">
          <div class="proj-meta">
            <div class="proj-name">{{ proj.title }}</div>
            <div class="proj-tags">
              <span class="ptag" v-for="t in proj.tags" :key="t">{{ t }}</span>
            </div>
          </div>
          <div class="proj-row-actions">
            <button class="btn-ghost icon-btn" @click="startEdit(proj)" title="Edit">
              <i class="fas fa-pen"></i>
            </button>
            <button class="btn-danger icon-btn" @click="confirmDelete(proj.id)" title="Delete">
              <i class="fas fa-trash"></i>
            </button>
          </div>
        </div>

        <!-- Expanded edit form -->
        <div class="proj-edit" v-else>
          <div class="admin-form-group">
            <label>Project Title</label>
            <input v-model="editForm.title" type="text" />
          </div>
          <div class="admin-form-group">
            <label>Tags (comma separated)</label>
            <input v-model="editTagsText" type="text" placeholder="PHP, Laravel, MySQL" />
          </div>
          <div class="admin-form-group">
            <label>Description</label>
            <textarea v-model="editForm.desc" style="min-height:80px"></textarea>
          </div>

          <div class="admin-form-group">
            <label>Code Preview (one line per row)</label>
            <textarea
              v-model="editCodeText"
              class="code-textarea"
              placeholder="import sklearn&#10;model = GradientBoosting()&#10;model.fit(X, y)"
              style="min-height:130px"
            ></textarea>
          </div>
          <div class="code-preview" v-if="editCodeText.trim()">
            <div class="code-preview-label">Preview</div>
            <div
              class="cp-line"
              v-for="(line, i) in editCodeText.split('\n')"
              :key="i"
            >
              <span class="cp-n">{{ i + 1 }}</span><span>{{ line }}</span>
            </div>
          </div>

          <div class="admin-form-group">
            <label>Link Type</label>
            <select v-model="editForm.linkType">
              <option value="github">GitHub</option>
              <option value="docs">Documentation</option>
              <option value="none">No link</option>
            </select>
          </div>
          <div class="admin-form-group" v-if="editForm.linkType !== 'none'">
            <label>Link URL</label>
            <input v-model="editForm.linkUrl" type="url" placeholder="https://..." />
          </div>
          <div class="admin-form-group" v-if="editForm.linkType !== 'none'">
            <label>Link Label</label>
            <input v-model="editForm.linkLabel" type="text" placeholder="View on GitHub" />
          </div>
          <div class="edit-actions">
            <button class="btn-primary" :disabled="saving" @click="saveEdit">
              <i class="fas fa-save"></i> {{ saving ? 'Saving…' : 'Save' }}
            </button>
            <button class="btn-ghost" @click="cancelEdit">Cancel</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Add new project -->
    <div class="add-section">
      <div class="subsection-head">Add New Project</div>
      <div class="admin-form-group">
        <label>Title</label>
        <input v-model="newForm.title" type="text" />
      </div>
      <div class="admin-form-group">
        <label>Tags (comma separated)</label>
        <input v-model="newTagsText" type="text" placeholder="PHP, Laravel" />
      </div>
      <div class="admin-form-group">
        <label>Description</label>
        <textarea v-model="newForm.desc" style="min-height:80px"></textarea>
      </div>

      <div class="admin-form-group">
        <label>Code Preview (one line per row)</label>
        <textarea
          v-model="newCodeText"
          class="code-textarea"
          placeholder="import sklearn&#10;model = GradientBoosting()&#10;model.fit(X, y)"
          style="min-height:130px"
        ></textarea>
      </div>
      <div class="code-preview" v-if="newCodeText.trim()">
        <div class="code-preview-label">Preview</div>
        <div
          class="cp-line"
          v-for="(line, i) in newCodeText.split('\n')"
          :key="i"
        >
          <span class="cp-n">{{ i + 1 }}</span><span>{{ line }}</span>
        </div>
      </div>

      <div class="admin-form-group">
        <label>Link Type</label>
        <select v-model="newForm.linkType">
          <option value="github">GitHub</option>
          <option value="docs">Documentation</option>
          <option value="none">No link</option>
        </select>
      </div>
      <div class="admin-form-group" v-if="newForm.linkType !== 'none'">
        <label>Link URL</label>
        <input v-model="newForm.linkUrl" type="url" />
      </div>
      <div class="admin-form-group" v-if="newForm.linkType !== 'none'">
        <label>Link Label</label>
        <input v-model="newForm.linkLabel" type="text" />
      </div>
      <button class="btn-primary" :disabled="adding" @click="addProject">
        <i class="fas fa-plus"></i> {{ adding ? 'Adding…' : 'Add Project' }}
      </button>
    </div>

    <!-- Delete confirm modal -->
    <div class="confirm-overlay" v-if="deleteTargetId !== null" @click.self="deleteTargetId = null">
      <div class="confirm-box">
        <div class="confirm-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <h3>Delete Project?</h3>
        <p>This action cannot be undone.</p>
        <div class="confirm-actions">
          <button class="btn-danger" @click="doDelete">Delete</button>
          <button class="btn-ghost"  @click="deleteTargetId = null">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { usePortfolio }  from '@/composables/usePortfolio.js'
import { useAdmin }      from '@/composables/useAdmin.js'
import { snippetToText, textToSnippet } from '@/composables/codeSnippet.js'

const props = defineProps({ projects: { type: Array, required: true } })

const { createProject, updateProject, deleteProject } = usePortfolio()
const { adminToken } = useAdmin()

// Edit state
const editingId    = ref(null)
const editForm     = reactive({})
const editTagsText = ref('')
const editCodeText = ref('')
const saving       = ref(false)

// New project state
const newForm     = reactive({ title: '', desc: '', linkType: 'github', linkUrl: '', linkLabel: 'View on GitHub' })
const newTagsText = ref('')
const newCodeText = ref('')
const adding      = ref(false)

// Delete state
const deleteTargetId = ref(null)

function startEdit(proj) {
  editingId.value = proj.id
  Object.assign(editForm, { ...proj })
  editTagsText.value = proj.tags.join(', ')
  editCodeText.value = snippetToText(proj.codeSnippet)
}
function cancelEdit() { editingId.value = null }

async function saveEdit() {
  saving.value = true
  const payload = {
    ...editForm,
    tags: editTagsText.value.split(',').map(t => t.trim()).filter(Boolean),
    codeSnippet: textToSnippet(editCodeText.value)
  }
  await updateProject(editingId.value, payload, adminToken.value)
  saving.value   = false
  editingId.value = null
}

async function addProject() {
  if (!newForm.title.trim()) return
  adding.value = true
  const payload = {
    ...newForm,
    tags: newTagsText.value.split(',').map(t => t.trim()).filter(Boolean),
    codeSnippet: textToSnippet(newCodeText.value)
  }
  await createProject(payload, adminToken.value)
  adding.value = false
  Object.assign(newForm, { title: '', desc: '', linkType: 'github', linkUrl: '', linkLabel: 'View on GitHub' })
  newTagsText.value = ''
  newCodeText.value = ''
}

function confirmDelete(id) { deleteTargetId.value = id }
async function doDelete() {
  await deleteProject(deleteTargetId.value, adminToken.value)
  deleteTargetId.value = null
}
</script>

<style scoped>
.proj-list { display: flex; flex-direction: column; gap: 8px; margin-bottom: 24px; }
.proj-item { background: rgba(255,255,255,0.02); border: 1px solid var(--border-sub); border-radius: 10px; overflow: hidden; }
.proj-item.is-editing { border-color: rgba(34,211,238,0.3); }
.proj-row { display: flex; align-items: center; gap: 12px; padding: 14px 16px; }
.proj-meta { flex: 1; }
.proj-name { font-family: var(--ff-head); font-size: 0.95rem; font-weight: 600; margin-bottom: 4px; }
.proj-tags { display: flex; gap: 5px; flex-wrap: wrap; }
.ptag { font-family: var(--ff-mono); font-size: 0.6rem; padding: 2px 7px; border-radius: 4px; background: rgba(34,211,238,0.07); border: 1px solid rgba(34,211,238,0.15); color: var(--cyan); }
.proj-row-actions { display: flex; gap: 6px; }
.icon-btn { padding: 7px 10px; font-size: 0.8rem; }
.proj-edit { padding: 16px; border-top: 1px solid var(--border-sub); }
.edit-actions { display: flex; gap: 8px; margin-top: 4px; }
.add-section { background: rgba(34,211,238,0.03); border: 1px solid rgba(34,211,238,0.12); border-radius: 10px; padding: 20px; }
.subsection-head { font-family: var(--ff-mono); font-size: 0.7rem; color: var(--cyan); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 16px; }

/* Code snippet editor */
.code-textarea {
  font-family: var(--ff-mono) !important;
  font-size: 0.78rem !important;
  line-height: 1.7 !important;
  white-space: pre;
  tab-size: 2;
}
.code-preview {
  background: #03070f;
  border: 1px solid var(--border-sub);
  border-radius: 8px;
  padding: 14px 16px;
  font-family: var(--ff-mono);
  font-size: 0.73rem;
  line-height: 1.7;
  color: var(--text);
  margin: -8px 0 16px;
  max-height: 160px;
  overflow-y: auto;
}
.code-preview-label {
  font-family: var(--ff-mono);
  font-size: 0.6rem;
  color: var(--muted);
  text-transform: uppercase;
  letter-spacing: 2px;
  margin-bottom: 8px;
}
.cp-line { display: flex; gap: 10px; white-space: pre; }
.cp-line .cp-n { color: #1e3050; min-width: 14px; text-align: right; flex-shrink: 0; }

/* Delete confirm */
.confirm-overlay { position: fixed; inset: 0; background: rgba(3,7,18,0.8); backdrop-filter: blur(8px); z-index: 9900; display: flex; align-items: center; justify-content: center; }
.confirm-box { background: rgba(8,16,36,0.98); border: 1px solid rgba(239,68,68,0.3); border-radius: 14px; padding: 32px; width: min(360px, 90vw); text-align: center; animation: fadeIn 0.2s ease; }
.confirm-icon { font-size: 2rem; color: #ef4444; margin-bottom: 12px; }
.confirm-box h3 { font-family: var(--ff-head); font-size: 1.1rem; margin-bottom: 6px; }
.confirm-box p  { font-size: 0.85rem; color: var(--muted); margin-bottom: 20px; }
.confirm-actions { display: flex; gap: 10px; justify-content: center; }
</style>
