/**
 * usePageRouter.js
 * Manages the current page index for the horizontal carousel.
 * Supports:
 *  - Programmatic navigation (switchPage)
 *  - Keyboard arrow keys (left/right)
 *  - Touch swipe gestures (mobile)
 *  - URL hash sync (#home, #about, #projects, #stack, #contact)
 */

import { ref, onMounted, onUnmounted } from 'vue'

const PAGES = ['home', 'about', 'projects', 'stack', 'contact']
const TOTAL = PAGES.length

const currentPage = ref(0)

export function usePageRouter() {

  function switchPage(idx) {
    if (idx < 0 || idx >= TOTAL) return
    currentPage.value = idx
    history.replaceState(null, '', `#${PAGES[idx]}`)
  }

  function syncFromHash() {
    const hash = window.location.hash.replace('#', '')
    const idx  = PAGES.indexOf(hash)
    if (idx !== -1) currentPage.value = idx
  }

  // Keyboard navigation
  function onKeydown(e) {
    if (e.key === 'ArrowRight') switchPage(Math.min(currentPage.value + 1, TOTAL - 1))
    if (e.key === 'ArrowLeft')  switchPage(Math.max(currentPage.value - 1, 0))
  }

  // Touch swipe navigation
  let touchStartX = 0
  function onTouchStart(e) {
    touchStartX = e.changedTouches[0].screenX
  }
  function onTouchEnd(e) {
    const touchEndX = e.changedTouches[0].screenX
    const diff = touchStartX - touchEndX
    const threshold = 60
    if (Math.abs(diff) < threshold) return
    if (diff > 0) switchPage(Math.min(currentPage.value + 1, TOTAL - 1)) // swipe left → next
    else          switchPage(Math.max(currentPage.value - 1, 0))        // swipe right → prev
  }

  onMounted(() => {
    syncFromHash()
    window.addEventListener('hashchange', syncFromHash)
    window.addEventListener('keydown', onKeydown)
    window.addEventListener('touchstart', onTouchStart, { passive: true })
    window.addEventListener('touchend', onTouchEnd, { passive: true })
  })

  onUnmounted(() => {
    window.removeEventListener('hashchange', syncFromHash)
    window.removeEventListener('keydown', onKeydown)
    window.removeEventListener('touchstart', onTouchStart)
    window.removeEventListener('touchend', onTouchEnd)
  })

  return { currentPage, switchPage }
}
