# DGstep – Company Website

A modern, multilingual Laravel 12.x website for **DGstep** — a technology company providing software solutions for pawnshops and small-to-medium enterprises.

This site features a clean, responsive UI built with **Tailwind CSS** and **Alpine.js**, emphasizing clarity, performance, and a professional brand presence.

> **Updated:** 2025-09-24

---

## 📜 Changelog (last 7 days)

* **2025-09-24**

  * Integrated Spatie for translations (English + Georgian).
  * Completed About page translations with mission cards.
  * Services page refactored with problem-solving circle layout.
  * Projects page redesigned (lazy images, translated headings).
  * Contact form: Alpine.js client-side + server-side validation.
  * Auth views (login, register, reset, forgot) localized.
  * Footer: added clickable contact info + terms link.
  * Fixed Vite asset handling for logos (import.meta.glob).

---

## 🔧 What’s new

* **Brand assets integrated** (PNG logos from the brand book), with **light/dark auto-swap** via `[data-theme]` and CSS variables.
* **Vite asset handling fixed** for images: `import.meta.glob()` eagerly includes brand images so they appear in the manifest.
* **Mobile menu polished** (Alpine.js), unified desktop/mobile behavior, improved escape/focus handling.
* **Services page refactored** with problem-solving circle layout and translations for problem lists .
* **Projects page** redesigned with translated headings/subheadings, lazy-loaded images, and consistent typography .
* **Contact form** fully validated (name, surname, phone regex, comments) with Alpine.js live validation and session flash success.
* **About page** translation completed with mission cards rendered via foreach loop.
* **Auth views** (login, register, reset, forgot) added with localized strings.
* **Footer** improved with clickable email/phone, social links, and terms link.

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
* **Palette tokens:** implemented as CSS custom properties; dark/light themes applied via `:root[data-theme]`.
* **Logo switching:** dark/light logo variants swap automatically based on theme.
* **Non-selectable UI text:** navigation/decorative text uses `select-none`.

---

## 🌐 Localization (Spatie)

* **Locales:** English (`en`) and Georgian (`ka`)
* **Package:** [Spatie Laravel Translatable](https://spatie.be/docs/laravel-translatable)
* **Middleware:** `SetLocale` applied globally
* **Switcher:** POST to `/locale` with `{ locale: 'en'|'ka' }`
* **Translations:** structured in `lang/en/`, `lang/ka/` (about, services, projects, terms, contact, auth, etc.)

> Routes are **not** prefixed with locale. Language is session-based.

---

## 🧭 Navigation & UX

* **Active states:** `request()->routeIs()`
* **Keyboard:** `Esc` closes mobile menu
* **Responsive:** mobile menu closes automatically at desktop breakpoint
* **Buttons/links:** unified variants (desktop & mobile) with hover borders and subtle Electric Sky glow

---

## 📄 Pages

* **Home** — hero slider (3 slides), separators, features grid
* **About** — Who we are, Mission (cards), Vision, CTA
* **Services** — problem-solving circle layout (pawnshop, SMB, compliance)
* **Projects** — responsive cards, translated headings, lazy images
* **Contact** — validated form with Alpine.js + server-side
* **Terms** — legal copy with CTA
* **Auth** — login, register, forgot, reset (UI only)

---

## 🗂️ Project Structure

```
resources/
  views/
    components/       # Navbar, footer, features, etc.
    layouts/          # base.blade.php
    pages/            # home, about, services, projects, terms, contact
    auth/             # login, register, forgot, reset
lang/
  en/, ka/           # Spatie translations (auth, about, services, projects...)
routes/
  web.php            # routes + locale switch POST
app/
  Http/
    Middleware/SetLocale.php
    Controllers/ContactController.php
```

---

## ✉️ Contact Form Validation

* `name`: required, ≤ 255
* `surname`: required, ≤ 255
* `phone`: regex `^\+?\d{7,15}$`
* `comments`: optional, ≤ 1000

Live client-side validation (Alpine.js) + server validation. Success triggers flash message.

---

## 🧩 Vite & Assets

* **Entries:** `resources/js/app.js`, `resources/css/app.css`
* **Logos/Images:** must be imported so they appear in the manifest:

```js
// resources/js/app.js
const brandImages = import.meta.glob('../images/brand/*', { eager: true });
```

---

## 🧪 Tests

* Feature test for homepage 200 response
* PestPHP 3 configured

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
php artisan migrate
```

### Run (concurrent dev)

```bash
composer run dev
```

### Build

```bash
npm run build
```

---

## 🗺️ Roadmap

* Theme switcher (persist localStorage)
* Replace placeholder avatars with management bios
* Connect Contact form to mailer & DB
* Add real project case studies with images

---

## 📜 License

MIT (template). Content & assets © DGstep.
