import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { fileURLToPath, URL } from 'node:url'

export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  },
  build: {
    outDir: 'dist',
    // For Laravel integration: output directly into Laravel's public folder
    // outDir: '../public/vue'
  },
  server: {
    proxy: {
      // Proxy API calls to Laravel dev server
      '/api': {
        target: 'http://localhost:8000',
        changeOrigin: true
      }
    }
  }
})
