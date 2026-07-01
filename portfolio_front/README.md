# Mesfin Maru — Portfolio (Vue 3)

A 1:1 Vue 3 rebuild of the original single-page HTML portfolio, with a built-in
admin interface for editing all content — designed to be plugged into a
Laravel backend with zero rewrites.

---

## ✨ Features

- Identical horizontal-carousel UI/UX to the original HTML (`~/home`, `~/about`,
  `~/projects`, `~/stack`, `~/contact`)
- Fully responsive (desktop, tablet, mobile) — keyboard arrows + touch swipe
  navigation included
- Logo image (`logo.png`) in the navbar instead of text, with text fallback
- Profile photo (`me.jpg`) with automatic fallback avatar
- **Hidden admin panel** — click the `© 2026 Mesfin Maru.` text in the footer
  **5 times within 3 seconds** to reveal the admin login. Regular visitors
  never see any "Admin" button.
- Admin panel lets you edit/add/delete:
  - Hero (name, bio, typed roles, profile image, availability status)
  - About (paragraphs, info chips, timeline entries)
  - Projects (add / edit / delete, tags, links, descriptions)
  - Tech stack badges (add / edit / delete, icon + color + label)
  - Contact info (email, phone, social links, copyright text)
- Works **standalone** (no backend — data lives in browser session) **or**
  connected to a **Laravel REST API** (see below).

---

## 🚀 Quick start (standalone, no backend)

```bash
npm install
npm run dev
```

Open the printed local URL. The portfolio runs entirely on the bundled static
data (`src/data/defaultData.js`). Edits made via the admin panel persist only
for the current browser session (in-memory) — perfect for previewing/testing.

**Default admin password:** `admin123`
(change via `VITE_ADMIN_PASSWORD` in a `.env` file — copy `.env.example` → `.env`)

To open the admin panel: scroll/navigate to the **Contact** page (or any page —
the footer is always visible), then click the small `© 2026 Mesfin Maru.` text
in the bottom-left **5 times quickly**.

---

## 🖼️ Add your images

Drop these into the `public/` folder:

| File           | Purpose                                  |
|----------------|-------------------------------------------|
| `me.jpg`       | Your profile photo (square recommended)   |
| `logo.png`     | Navbar logo (transparent PNG, ~38px tall) |
| `favicon.png`  | Browser tab icon                          |

If a file is missing, sensible fallbacks are shown automatically.

---

## 🔌 Connecting to Laravel

Set `VITE_API_URL` in your `.env` file to your Laravel app's URL, e.g.:

```env
VITE_API_URL=http://localhost:8000
```

Once set, the app automatically:
- Fetches all content from `GET /api/portfolio` on load
- Sends admin edits to the appropriate REST endpoints (with Bearer token auth)
- Falls back to static data if the API is unreachable (with a console warning)

### Required Laravel API endpoints

| Method | Endpoint                       | Purpose                     |
|--------|---------------------------------|------------------------------|
| POST   | `/api/auth/login`               | `{ email, password }` → `{ token }` |
| GET    | `/api/portfolio`                | Returns the full data object (see shape below) |
| PUT    | `/api/portfolio/hero`           | Update hero section          |
| PUT    | `/api/portfolio/about`          | Update about section         |
| POST   | `/api/portfolio/projects`       | Create a project              |
| PUT    | `/api/portfolio/projects/{id}`  | Update a project              |
| DELETE | `/api/portfolio/projects/{id}`  | Delete a project              |
| POST   | `/api/portfolio/skills`         | Create a skill badge (`{ category, icon, iconColor, label }`) |
| PUT    | `/api/portfolio/skills/{id}`    | Update a skill badge          |
| DELETE | `/api/portfolio/skills/{id}`    | Delete a skill badge          |
| PUT    | `/api/portfolio/contact`        | Update contact info           |

All `PUT`/`POST`/`DELETE` requests are sent with:
```
Authorization: Bearer <token>
Content-Type: application/json
```

### Data shape (`GET /api/portfolio` response)

See `src/data/defaultData.js` for the exact JSON shape — your Laravel API
should return data matching this structure exactly (same keys), e.g.:

```json
{
  "hero": { "name": "...", "roles": ["..."], "bio": "...", "available": true, ... },
  "about": { "paragraphs": ["..."], "chips": [...], "timeline": [...] },
  "projects": [ { "id": 1, "title": "...", "tags": [...], ... } ],
  "skills": { "languages": [...], "infrastructure": [...] },
  "contact": { "email": "...", "phone": "...", ... }
}
```

A typical Laravel setup: one `PortfolioController` with a single JSON column
(or related tables for `projects`/`skills`), plus Sanctum for the
`/api/auth/login` token issuance.

---

## 📦 Build for production

```bash
npm run build
```

Output goes to `dist/`. To serve from Laravel's `public/` folder directly,
either:

- Copy `dist/*` into Laravel's `public/` directory, or
- Set `build.outDir` in `vite.config.js` to `'../public/vue'` and adjust your
  Laravel route/blade view to load the built `index.html` assets.

---

## 🗂️ Project structure

```
src/
├── App.vue                  — root component (carousel + nav + footer)
├── main.js                  — entry point
├── components/
│   ├── TheNavBar.vue        — fixed header (logo + nav links + hamburger)
│   └── TheFooter.vue        — fixed footer (social links + hidden admin trigger)
├── sections/
│   ├── HeroSection.vue       — ~/home
│   ├── AboutSection.vue      — ~/about
│   ├── ProjectsSection.vue   — ~/projects
│   ├── StackSection.vue      — ~/stack
│   └── ContactSection.vue    — ~/contact
├── admin/
│   ├── AdminLogin.vue        — password gate
│   ├── AdminOverlay.vue      — admin shell (sidebar + tabs)
│   └── panels/
│       ├── HeroPanel.vue
│       ├── AboutPanel.vue
│       ├── ProjectsPanel.vue
│       ├── SkillsPanel.vue
│       └── ContactPanel.vue
├── composables/
│   ├── usePortfolio.js       — data fetching/mutation (API or static)
│   ├── useAdmin.js            — auth state + secret-click trigger
│   ├── usePageRouter.js       — carousel navigation (keyboard/swipe/hash)
│   └── useTyping.js           — hero typewriter effect
├── data/
│   └── defaultData.js         — static fallback content (matches API shape)
└── assets/css/main.css        — design tokens + global/shared styles
```

---

## ⌨️ Navigation

- **Desktop:** click nav links, or use **← / →** arrow keys
- **Mobile:** hamburger menu, or **swipe left/right**
- URL hash updates automatically (`#home`, `#about`, `#projects`, `#stack`, `#contact`) — shareable/bookmarkable links
