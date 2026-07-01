<template>
  <Teleport to="body">
    <!-- Login gate -->
    <AdminLogin
      v-if="!isAuthenticated"
      @success="onLoginSuccess"
      @cancel="closeAdmin"
    />

    <!-- Admin panel (after auth) -->
    <div class="admin-overlay" v-else>
      <!-- Sidebar -->
      <aside class="admin-sidebar">
        <div class="admin-brand">
          <div class="admin-brand-icon"><i class="fas fa-terminal"></i></div>
          <div>
            <div class="admin-brand-title">Admin Panel</div>
            <div class="admin-brand-sub">mes.dev</div>
          </div>
        </div>

        <nav class="admin-nav">
          <button
            v-for="tab in tabs"
            :key="tab.key"
            class="admin-nav-btn"
            :class="{ active: activeTab === tab.key }"
            @click="activeTab = tab.key"
          >
            <i :class="tab.icon"></i>
            <span>{{ tab.label }}</span>
          </button>
        </nav>

        <div class="admin-sidebar-footer">
          <div class="admin-mode-badge" v-if="!apiConnected">
            <i class="fas fa-circle" style="color:#f59e0b;font-size:0.5rem"></i>
            Standalone (no API)
          </div>
          <div class="admin-mode-badge connected" v-else>
            <i class="fas fa-circle" style="color:#10b981;font-size:0.5rem"></i>
            Laravel connected
          </div>
          <button class="logout-btn" @click="logout">
            <i class="fas fa-sign-out-alt"></i> Logout
          </button>
        </div>
      </aside>

      <!-- Main content area -->
      <main class="admin-main">
        <div class="admin-topbar">
          <div class="admin-page-title">{{ currentTab?.label }}</div>
          <button class="close-btn" @click="closeAdmin" title="Close admin panel">
            <i class="fas fa-times"></i>
          </button>
        </div>

        <div class="admin-content">
          <HeroPanel    v-if="activeTab === 'hero'"     :hero="data.hero" />
          <AboutPanel   v-if="activeTab === 'about'"    :about="data.about" />
          <ProjectsPanel v-if="activeTab === 'projects'" :projects="data.projects" />
          <SkillsPanel  v-if="activeTab === 'skills'"   :skills="data.skills" />
          <ContactPanel v-if="activeTab === 'contact'"  :contact="data.contact" />
        </div>
      </main>
    </div>
  </Teleport>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useAdmin }      from '@/composables/useAdmin.js'
import { usePortfolio }  from '@/composables/usePortfolio.js'

import AdminLogin    from './AdminLogin.vue'
import HeroPanel     from './panels/HeroPanel.vue'
import AboutPanel    from './panels/AboutPanel.vue'
import ProjectsPanel from './panels/ProjectsPanel.vue'
import SkillsPanel   from './panels/SkillsPanel.vue'
import ContactPanel  from './panels/ContactPanel.vue'

const { isAuthenticated, closeAdmin, logout } = useAdmin()
const { data } = usePortfolio()

const activeTab    = ref('hero')
const apiConnected = computed(() => !!import.meta.env.VITE_API_URL)

const tabs = [
  { key: 'hero',     label: 'Hero',     icon: 'fas fa-home' },
  { key: 'about',    label: 'About',    icon: 'fas fa-user' },
  { key: 'projects', label: 'Projects', icon: 'fas fa-code-branch' },
  { key: 'skills',   label: 'Stack',    icon: 'fas fa-layer-group' },
  { key: 'contact',  label: 'Contact',  icon: 'fas fa-address-book' }
]

const currentTab = computed(() => tabs.find(t => t.key === activeTab.value))

function onLoginSuccess() {
  activeTab.value = 'hero'
}
</script>

<style scoped>
.admin-overlay {
  position: fixed;
  inset: 0;
  z-index: 8000;
  display: flex;
  animation: overlayIn 0.25s ease;
  font-family: var(--ff-body);
}

/* ── Sidebar ────────────────────────────────────────── */
.admin-sidebar {
  width: 220px;
  flex-shrink: 0;
  background: #030914;
  border-right: 1px solid rgba(34, 211, 238, 0.12);
  display: flex;
  flex-direction: column;
  padding: 20px 0;
}

.admin-brand {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 0 20px 20px;
  border-bottom: 1px solid rgba(255,255,255,0.05);
  margin-bottom: 16px;
}
.admin-brand-icon {
  width: 38px; height: 38px;
  border-radius: 10px;
  background: rgba(34,211,238,0.1);
  border: 1px solid rgba(34,211,238,0.2);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--cyan);
  font-size: 1rem;
}
.admin-brand-title { font-family: var(--ff-head); font-size: 0.88rem; font-weight: 700; }
.admin-brand-sub   { font-family: var(--ff-mono); font-size: 0.62rem; color: var(--muted); }

.admin-nav { flex: 1; padding: 0 12px; display: flex; flex-direction: column; gap: 2px; }
.admin-nav-btn {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 14px;
  border-radius: 8px;
  font-family: var(--ff-mono);
  font-size: 0.8rem;
  color: var(--muted);
  transition: all 0.2s;
  text-align: left;
  width: 100%;
}
.admin-nav-btn:hover,
.admin-nav-btn.active {
  color: var(--cyan);
  background: rgba(34,211,238,0.08);
}
.admin-nav-btn.active { border-left: 2px solid var(--cyan); border-radius: 0 8px 8px 0; }
.admin-nav-btn i { width: 16px; text-align: center; }

.admin-sidebar-footer {
  padding: 16px 20px 0;
  border-top: 1px solid rgba(255,255,255,0.05);
}
.admin-mode-badge {
  display: flex;
  align-items: center;
  gap: 6px;
  font-family: var(--ff-mono);
  font-size: 0.65rem;
  color: #f59e0b;
  margin-bottom: 12px;
  padding: 6px 10px;
  background: rgba(245,158,11,0.08);
  border: 1px solid rgba(245,158,11,0.2);
  border-radius: 6px;
}
.admin-mode-badge.connected { color: var(--green); background: rgba(16,185,129,0.08); border-color: rgba(16,185,129,0.2); }

.logout-btn {
  display: flex;
  align-items: center;
  gap: 8px;
  width: 100%;
  padding: 9px 12px;
  border-radius: 8px;
  font-family: var(--ff-mono);
  font-size: 0.78rem;
  color: var(--muted);
  transition: all 0.2s;
}
.logout-btn:hover { color: #ef4444; background: rgba(239,68,68,0.08); }

/* ── Main area ──────────────────────────────────────── */
.admin-main {
  flex: 1;
  display: flex;
  flex-direction: column;
  background: rgba(5, 11, 28, 0.97);
  overflow: hidden;
}

.admin-topbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 18px 28px;
  border-bottom: 1px solid rgba(255,255,255,0.05);
  flex-shrink: 0;
}
.admin-page-title {
  font-family: var(--ff-head);
  font-size: 1.1rem;
  font-weight: 700;
}
.close-btn {
  width: 36px; height: 36px;
  border-radius: 8px;
  color: var(--muted);
  border: 1px solid var(--border-sub);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
}
.close-btn:hover { color: #ef4444; border-color: rgba(239,68,68,0.4); background: rgba(239,68,68,0.06); }

.admin-content {
  flex: 1;
  overflow-y: auto;
  padding: 24px 28px;
}

/* ── Shared panel shell styles ───────────────────────── */
/* These affect the <div class="panel"> inside each panel component */
:deep(.panel) { animation: fadeIn 0.2s ease; }
:deep(.panel-title) {
  font-family: var(--ff-head);
  font-size: 1rem;
  font-weight: 700;
  margin-bottom: 24px;
  padding-bottom: 14px;
  border-bottom: 1px solid var(--border-sub);
  display: flex;
  align-items: center;
  gap: 10px;
  color: var(--text);
}
:deep(.panel-title i) { color: var(--cyan); }
:deep(.panel-actions) { margin-top: 20px; }
:deep(.save-success) {
  margin-top: 12px;
  font-family: var(--ff-mono);
  font-size: 0.75rem;
  color: var(--green);
  display: flex;
  align-items: center;
  gap: 6px;
  animation: fadeIn 0.2s ease;
}
:deep(.divider) { height: 1px; background: var(--border-sub); margin: 20px 0; }

/* Mobile: stack sidebar on top */
@media (max-width: 640px) {
  .admin-overlay { flex-direction: column; }
  .admin-sidebar {
    width: 100%;
    flex-shrink: 0;
    padding: 12px 0;
    border-right: none;
    border-bottom: 1px solid rgba(34,211,238,0.12);
  }
  .admin-brand { padding: 0 14px 12px; }
  .admin-nav { flex-direction: row; flex-wrap: wrap; padding: 0 8px; }
  .admin-nav-btn { flex-direction: column; gap: 4px; padding: 8px 10px; font-size: 0.65rem; }
  .admin-nav-btn.active { border-left: none; border-bottom: 2px solid var(--cyan); border-radius: 8px 8px 0 0; }
  .admin-sidebar-footer { display: none; }
  .admin-content { padding: 16px; }
}
</style>
