/**
 * useTyping.js
 * Composable for the animated typewriter effect in the hero section.
 */

import { ref, onMounted, onUnmounted } from 'vue'

export function useTyping(roles) {
  const typedText = ref('')
  let rIdx    = 0
  let cIdx    = 0
  let isDel   = false
  let timerId = null

  function tick() {
    const current = roles[rIdx]
    if (isDel) {
      typedText.value = current.substring(0, cIdx - 1)
      cIdx--
    } else {
      typedText.value = current.substring(0, cIdx + 1)
      cIdx++
    }

    let speed = isDel ? 30 : 70
    if (!isDel && cIdx === current.length) {
      speed  = 2000
      isDel  = true
    } else if (isDel && cIdx === 0) {
      isDel  = false
      rIdx   = (rIdx + 1) % roles.length
      speed  = 400
    }
    timerId = setTimeout(tick, speed)
  }

  onMounted(() => {
    timerId = setTimeout(tick, 500)
  })

  onUnmounted(() => {
    if (timerId) clearTimeout(timerId)
  })

  return { typedText }
}
