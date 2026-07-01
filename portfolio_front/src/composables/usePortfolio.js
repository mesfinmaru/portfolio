/**
 * usePortfolio.js
 * Composable that handles fetching portfolio data from Laravel API
 * and falling back to static default data when no API is configured.
 *
 * Laravel API endpoints expected:
 *   GET    /api/portfolio            → full data object
 *   PUT    /api/portfolio/hero       → update hero section
 *   PUT    /api/portfolio/about      → update about section
 *   POST   /api/portfolio/projects   → create project
 *   PUT    /api/portfolio/projects/:id
 *   DELETE /api/portfolio/projects/:id
 *   POST   /api/portfolio/skills     → create skill
 *   PUT    /api/portfolio/skills/:id
 *   DELETE /api/portfolio/skills/:id
 *   PUT    /api/portfolio/contact    → update contact info
 */

import { ref, readonly } from 'vue'
import { defaultData }    from '@/data/defaultData.js'

const API_BASE = import.meta.env.VITE_API_URL || ''

// Reactive state (module-level singleton)
const data    = ref(JSON.parse(JSON.stringify(defaultData)))
const loading = ref(false)
const error   = ref(null)

// ─── helpers ──────────────────────────────────────────────────────────────────

function authHeaders(token) {
  const h = { 'Content-Type': 'application/json' }
  if (token) h['Authorization'] = `Bearer ${token}`
  return h
}

async function apiFetch(path, opts = {}) {
  const res = await fetch(`${API_BASE}${path}`, opts)
  if (!res.ok) throw new Error(`API ${res.status}: ${res.statusText}`)
  return res.json()
}

// ─── public composable ────────────────────────────────────────────────────────

export function usePortfolio() {

  // Load data from API or use defaults
  async function loadData() {
    if (!API_BASE) return                 // no API – static defaults stand
    loading.value = true
    error.value   = null
    try {
      const fresh = await apiFetch('/api/portfolio')
      data.value  = fresh
    } catch (e) {
      console.warn('[portfolio] API unavailable, using static data:', e.message)
      error.value = e.message
    } finally {
      loading.value = false
    }
  }

  // ── Hero ──
  async function updateHero(payload, token) {
    if (!API_BASE) { data.value.hero = { ...data.value.hero, ...payload }; return }
    const updated = await apiFetch('/api/portfolio/hero', {
      method: 'PUT',
      headers: authHeaders(token),
      body: JSON.stringify(payload)
    })
    data.value.hero = updated
  }

  // ── About ──
  async function updateAbout(payload, token) {
    if (!API_BASE) { data.value.about = { ...data.value.about, ...payload }; return }
    const updated = await apiFetch('/api/portfolio/about', {
      method: 'PUT',
      headers: authHeaders(token),
      body: JSON.stringify(payload)
    })
    data.value.about = updated
  }

  // ── Projects ──
  async function createProject(payload, token) {
    if (!API_BASE) {
      const newId = Date.now()
      data.value.projects.push({ ...payload, id: newId })
      return
    }
    const created = await apiFetch('/api/portfolio/projects', {
      method: 'POST',
      headers: authHeaders(token),
      body: JSON.stringify(payload)
    })
    data.value.projects.push(created)
  }

  async function updateProject(id, payload, token) {
    if (!API_BASE) {
      const idx = data.value.projects.findIndex(p => p.id === id)
      if (idx !== -1) data.value.projects[idx] = { ...data.value.projects[idx], ...payload }
      return
    }
    const updated = await apiFetch(`/api/portfolio/projects/${id}`, {
      method: 'PUT',
      headers: authHeaders(token),
      body: JSON.stringify(payload)
    })
    const idx = data.value.projects.findIndex(p => p.id === id)
    if (idx !== -1) data.value.projects[idx] = updated
  }

  async function deleteProject(id, token) {
    if (!API_BASE) {
      data.value.projects = data.value.projects.filter(p => p.id !== id)
      return
    }
    await apiFetch(`/api/portfolio/projects/${id}`, {
      method: 'DELETE',
      headers: authHeaders(token)
    })
    data.value.projects = data.value.projects.filter(p => p.id !== id)
  }

  // ── Skills ──
  async function createSkill(category, payload, token) {
    if (!API_BASE) {
      const newId = Date.now()
      data.value.skills[category].push({ ...payload, id: newId })
      return
    }
    const created = await apiFetch('/api/portfolio/skills', {
      method: 'POST',
      headers: authHeaders(token),
      body: JSON.stringify({ category, ...payload })
    })
    data.value.skills[category].push(created)
  }

  async function updateSkill(category, id, payload, token) {
    if (!API_BASE) {
      const idx = data.value.skills[category].findIndex(s => s.id === id)
      if (idx !== -1) data.value.skills[category][idx] = { ...data.value.skills[category][idx], ...payload }
      return
    }
    const updated = await apiFetch(`/api/portfolio/skills/${id}`, {
      method: 'PUT',
      headers: authHeaders(token),
      body: JSON.stringify(payload)
    })
    const idx = data.value.skills[category].findIndex(s => s.id === id)
    if (idx !== -1) data.value.skills[category][idx] = updated
  }

  async function deleteSkill(category, id, token) {
    if (!API_BASE) {
      data.value.skills[category] = data.value.skills[category].filter(s => s.id !== id)
      return
    }
    await apiFetch(`/api/portfolio/skills/${id}`, {
      method: 'DELETE',
      headers: authHeaders(token)
    })
    data.value.skills[category] = data.value.skills[category].filter(s => s.id !== id)
  }

  // ── Contact ──
  async function updateContact(payload, token) {
    if (!API_BASE) { data.value.contact = { ...data.value.contact, ...payload }; return }
    const updated = await apiFetch('/api/portfolio/contact', {
      method: 'PUT',
      headers: authHeaders(token),
      body: JSON.stringify(payload)
    })
    data.value.contact = updated
  }

  return {
    data: readonly(data),
    loading: readonly(loading),
    error:   readonly(error),
    loadData,
    updateHero,
    updateAbout,
    createProject,
    updateProject,
    deleteProject,
    createSkill,
    updateSkill,
    deleteSkill,
    updateContact
  }
}
