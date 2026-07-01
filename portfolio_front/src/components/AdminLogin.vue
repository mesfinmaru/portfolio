<template>
  <div class="admin-login-overlay" @click.self="$emit('cancel')">
    <div class="admin-login-box">
      <div class="login-header">
        <div class="login-icon"><i class="fas fa-lock"></i></div>
        <h2>Admin Access</h2>
        <p>Enter the admin password to continue.</p>
      </div>

      <div class="admin-form-group">
        <label>Password</label>
        <div class="pw-row">
          <input
            ref="pwInput"
            v-model="password"
            :type="showPw ? 'text' : 'password'"
            placeholder="Enter admin password"
            @keydown.enter="attemptLogin"
          />
          <button class="toggle-pw" @click="showPw = !showPw" tabindex="-1">
            <i :class="showPw ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
          </button>
        </div>
      </div>

      <div class="login-error" v-if="authError">
        <i class="fas fa-exclamation-circle"></i> {{ authError }}
      </div>

      <div class="login-actions">
        <button class="btn-primary" :disabled="loading" @click="attemptLogin">
          <i class="fas fa-terminal"></i>
          {{ loading ? 'Authenticating...' : 'Access Admin Panel' }}
        </button>
        <button class="btn-ghost" @click="$emit('cancel')">Cancel</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useAdmin }        from '@/composables/useAdmin.js'

const emit = defineEmits(['cancel', 'success'])

const { login, authError } = useAdmin()

const password = ref('')
const showPw   = ref(false)
const loading  = ref(false)
const pwInput  = ref(null)

onMounted(() => {
  pwInput.value?.focus()
})

async function attemptLogin() {
  if (!password.value) return
  loading.value = true
  const ok = await login(password.value)
  loading.value = false
  if (ok) emit('success')
}
</script>

<style scoped>
.admin-login-overlay {
  position: fixed;
  inset: 0;
  background: rgba(3, 7, 18, 0.88);
  backdrop-filter: blur(16px);
  z-index: 9000;
  display: flex;
  align-items: center;
  justify-content: center;
  animation: overlayIn 0.2s ease;
}

.admin-login-box {
  background: rgba(8, 16, 36, 0.98);
  border: 1px solid rgba(34, 211, 238, 0.2);
  border-radius: 16px;
  padding: 40px;
  width: min(420px, 92vw);
  animation: fadeIn 0.25s ease;
}

.login-header {
  text-align: center;
  margin-bottom: 28px;
}
.login-icon {
  width: 52px; height: 52px;
  border-radius: 14px;
  background: rgba(34, 211, 238, 0.1);
  border: 1px solid rgba(34, 211, 238, 0.2);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.3rem;
  color: var(--cyan);
  margin: 0 auto 14px;
}
.login-header h2 {
  font-family: var(--ff-head);
  font-size: 1.3rem;
  font-weight: 700;
  margin-bottom: 6px;
}
.login-header p {
  font-size: 0.85rem;
  color: var(--muted);
}

/* Password row with show/hide toggle */
.pw-row {
  position: relative;
}
.pw-row input {
  width: 100%;
  font-family: var(--ff-body);
  font-size: 0.9rem;
  background: rgba(255, 255, 255, 0.04);
  border: 1px solid var(--border-sub);
  border-radius: 8px;
  padding: 10px 40px 10px 14px;
  color: var(--text);
  outline: none;
  transition: border-color 0.2s;
}
.pw-row input:focus { border-color: var(--cyan); }
.toggle-pw {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--muted);
  font-size: 0.9rem;
  padding: 4px;
  transition: color 0.2s;
}
.toggle-pw:hover { color: var(--cyan); }

.login-error {
  font-family: var(--ff-mono);
  font-size: 0.75rem;
  color: #ef4444;
  background: rgba(239, 68, 68, 0.08);
  border: 1px solid rgba(239, 68, 68, 0.2);
  border-radius: 8px;
  padding: 10px 14px;
  margin-bottom: 16px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.login-actions {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-top: 20px;
}
.login-actions .btn-primary { justify-content: center; }
.login-actions .btn-primary:disabled {
  opacity: 0.6;
  cursor: not-allowed;
  transform: none;
}
.login-actions .btn-ghost { justify-content: center; }
</style>