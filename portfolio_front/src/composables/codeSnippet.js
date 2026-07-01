/**
 * codeSnippet.js
 * Converts between the project's `codeSnippet` array format
 * (used by ProjectsSection for the code-preview pane) and a plain
 * multi-line text string (used by the admin textarea).
 *
 * Admin-entered code is treated as plain text and HTML-escaped,
 * so no syntax highlighting spans — just clean monospace code.
 * (Hand-crafted highlighted snippets from the original design are
 * preserved until the project is edited and re-saved.)
 */

function escapeHtml(str) {
  return str
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
}

function stripHtml(str) {
  return str.replace(/<[^>]*>/g, '')
}

/** codeSnippet array → plain text (one line per row), for editing */
export function snippetToText(codeSnippet) {
  if (!Array.isArray(codeSnippet)) return ''
  return codeSnippet.map(line => stripHtml(line.html || '')).join('\n')
}

/** plain text → codeSnippet array, for saving */
export function textToSnippet(text) {
  if (!text || !text.trim()) return []
  return text.split('\n').map((line, i) => ({
    n: String(i + 1),
    html: escapeHtml(line)
  }))
}
