/**
 * useAdmin.js
 * Handles admin panel visibility, authentication, and token management.
 *
 * Secret activation: click the copyright "©" text 5 times within 3 seconds.
 *
 * Standalone mode: password checked against VITE_ADMIN_PASSWORD env var.
 * Laravel mode:    POST /api/auth/login with { email, password } → { token }
 */

import { ref, readonly } from 'vue'

const API_BASE = import.meta.env.VITE_API_URL || ''

// Singleton state
const isAdminVisible  = ref(false)
const isAuthenticated = ref(false)
const adminToken      = ref(null)
const authError       = ref('')

// Restore session from sessionStorage
const storedToken = sessionStorage.getItem('admin_token')
if (storedToken) {
  adminToken.value      = storedToken
  isAuthenticated.value = true
}

// Secret click counter
let clickCount = 0
let clickTimer = null

export function useAdmin() {

  function handleSecretClick() {
    clickCount++
    if (clickTimer) clearTimeout(clickTimer)

    if (clickCount >= 5) {
      clickCount = 0
      isAdminVisible.value = true
    } else {
      clickTimer = setTimeout(() => { clickCount = 0 }, 3000)
    }
  }

  async function login(password) {
    authError.value = ''

    if (API_BASE) {
      // Laravel authentication
      try {
        const res = await fetch(`${API_BASE}/api/auth/login`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ email: 'admin@portfolio.com', password })
        })
        if (!res.ok) throw new Error('Invalid credentials')
        const json = await res.json()
        adminToken.value      = json.token
        isAuthenticated.value = true
        sessionStorage.setItem('admin_token', json.token)
        return true
      } catch (e) {
        authError.value = e.message || 'Login failed'
        return false
      }
    } else {
      // Standalone password check
      const expected = import.meta.env.VITE_ADMIN_PASSWORD || 'admin123'
      if (password === expected) {
        isAuthenticated.value = true
        adminToken.value      = 'standalone'
        sessionStorage.setItem('admin_token', 'standalone')
        return true
      } else {
        authError.value = 'Incorrect password.'
        return false
      }
    }
  }

  function logout() {
    isAuthenticated.value = false
    adminToken.value      = null
    isAdminVisible.value  = false
    sessionStorage.removeItem('admin_token')
  }

  function closeAdmin() {
    isAdminVisible.value = false
  }

  return {
    isAdminVisible:  readonly(isAdminVisible),
    isAuthenticated: readonly(isAuthenticated),
    adminToken:      readonly(adminToken),
    authError:       readonly(authError),
    handleSecretClick,
    login,
    logout,
    closeAdmin
  }
}
