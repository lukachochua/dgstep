# DGstep – Company Website

A modern, multilingual Laravel 12.x website for **DGstep** — a technology company providing software solutions for pawnshops and small-to-medium enterprises.

This site features a clean, responsive UI built with **Tailwind CSS** and **Alpine.js**, emphasizing clarity, performance, and a professional brand presence.

> **Updated:** 2025‑09‑24

---

## 🔧 What’s new (last 4 days)

* **Brand assets integrated** (PNG logos from the brand book), with **light/dark auto‑swap** via `[data-theme]` and CSS variables.
* **Vite asset handling fixed** for images: use `import.meta.glob()` to eagerly include brand images so they appear in the build manifest.
* **Mobile menu polished** (Alpine.js), unified desktop/mobile behavior, and improved focus/escape handling.
* **Projects page**: refined grid and layout; consistent gradient background & typography across pages.
* **Features section (light mode)**: contrast tuned to stay within brand palette.
* **Footer**: clickable email/phone, social links, and tidy terms link.

---

## 🚀 Tech Stack

* **Framework:** Laravel 12.x (2025 LTS)
* **Runtime:** PHP 8.2+ (CLI & FPM)
* **CSS Framework:** Tailwind CSS (JIT)
* **JS Layer:** Alpine.js (lightweight interactivity)
* **Bundler:** Vite 6 + Laravel Vite Plugin
* **Testing:** PestPHP 3

---

## 🎨 Branding & Theming

* **Primary brand color:** `#5B56D6` ("Electric Sky")
* **Palette tokens:** implemented as CSS custom properties; dark/light themes applied via `:root[data-theme="dark"|"light"]`.
* **Logo switching:** dark/light logo variants swap automatically based on the root `[data-theme]` attribute.
* **Non-selectable UI text:** critical navigational and decorative text uses `select-none` to reduce accidental highlights.

### Example (theme tokens)

```css
:root[data-theme="light"] {
  --bg-default: #faf9ff;
  --text-default: var(--neutral-900);
  --bg-elevated: #ffffff;
  /* brand */
  --color-electric-sky: #5b56d6;
}
:root[data-theme="dark"] {
  --bg-default: #0b0f1a;
  --text-default: #e6e8ef;
  --bg-elevated: #141d2f;
  --color-electric-sky: #5b56d6;
}
```

---

## 🌐 Localization (i18n)

* **Locales:** English (`en`) and Georgian (`ka`)
* **Mode:** Session‑based locale powered by a `SetLocale` middleware
* **Switcher:** POST to `/locale` with `{ locale: 'en'|'ka' }`
* **Usage:** `__('messages.home')`, page‑specific files under `lang/{locale}/`

> We do **not** currently use locale‑prefixed routes; URLs remain unprefixed and the session determines language.

---

## 🧭 Navigation & UX

* **Active states:** `request()->routeIs()`
* **Keyboard:** `Esc` closes mobile menu
* **Responsive behavior:** when crossing the desktop breakpoint (≥ `lg`), the mobile menu auto‑closes.
* **Buttons/links:** unified variants for desktop and mobile (
  hover/active borders, subtle glow using the Electric Sky color).

---

## 📄 Pages

* **Home** — hero slider (3 slides), soft separators, features grid.
* **About** — Who we are, Mission, Vision (with card highlights), Management (placeholder avatars).
* **Services** — left text / right graphic; "What problems do we solve?" circle layout.
* **Projects** — grid of project cards, tidy responsive spacing.
* **Contact** — two‑column layout; validated form (name, surname, phone, message); success flash.
* **Terms** — basic legal copy with CTA link to Contact.
* **Auth (UI only)** — login, register, forgot, reset (no backend logic yet).

---

## 🗂️ Project Structure (high level)

```
resources/
  views/
    components/       # Blade UI components (navbar, footer, features, etc.)
    layouts/          # base.blade.php
    pages/            # home, about, services, projects, terms, contact
    auth/             # login, register, forgot, reset
lang/
  en/, ka/           # translations (messages, about, services, projects, terms, contact)
routes/
  web.php            # web routes + locale switch POST
app/
  Http/
    Middleware/SetLocale.php
    Controllers/ContactController.php
```

---

## ✉️ Contact form

Validated server‑side; phone supports optional leading `+` and 7–15 digits.

**Rules:**

* `name`: required, string ≤ 255
* `surname`: required, string ≤ 255
* `phone`: required, regex `^\+?\d{7,15}$`
* `comments`: optional, string ≤ 1000

Success shows a session flash message.

---

## 🧩 Vite & Assets

### JavaScript/CSS entries

* `resources/js/app.js`
* `resources/css/app.css`

### Images & logos

Vite only bundles assets that are imported. To ensure brand logos (light/dark) are available in production builds, import them in JS:

```js
// resources/js/app.js
// Eagerly include brand images so they appear in manifest and can be referenced by URL
const brandImages = import.meta.glob('../images/brand/*', { eager: true });
```

Use `data-theme` on the root element and swap `<img>` `src` or `background-image` via CSS/JS as needed.

---

## 🧪 Tests

* Basic feature test to ensure `/` returns HTTP 200
* PestPHP configured; run with `php artisan test`

---

## 🛠️ Development

### Requirements

* PHP 8.2+
* Composer, Node.js 20+

### Setup

```bash
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan migrate --graceful
```

### Run (concurrent dev)

```bash
composer run dev
```

This concurrently starts: Laravel server, queue listener, log viewer, and Vite.

### Build

```bash
npm run build
```

---

## 🔎 Known gotchas

* **Images not in manifest?** Vite won’t include static images unless imported. Use `import.meta.glob()` or reference them via CSS `url()` from a file that’s part of the dependency graph.
* **Mobile menu stuck open after resize?** Ensure the resize watcher (via `matchMedia('(min-width: 1024px)')`) closes the menu when entering desktop.
* **Light mode feature contrast:** keep within brand palette; avoid overly bright grays.

---

## 🗺️ Roadmap (near‑term)

* Theme switcher UI (persisted in localStorage)
* Replace management placeholders with real photos & bios
* Hook Contact form to mailer + database
* Project cards → real case studies with links and hero images

---

## 📜 License

MIT (project template). Content and brand assets © DGstep.
