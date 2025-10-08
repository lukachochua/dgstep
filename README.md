# DGstep – Company Website

A modern, multilingual Laravel 12.x website for **DGstep** — a technology company providing software solutions for pawnshops and small-to-medium enterprises.

This site features a clean, responsive UI built with **Tailwind CSS** and **Alpine.js**, emphasizing clarity, performance, and a professional brand presence.

> **Updated:** 2025-10-08

---

## 📜 Changelog (last 7 days)

* **2025-10-08**

  * Added Google reCAPTCHA to the Contact form with graceful fallbacks when keys are missing.
  * Captured submissions in a new `contact_submissions` table with a Filament List/View resource.
  * About page hero, mission, vision, and badges now pull translated content from the CMS singleton.
  * Management team slider adds bio modals, focus traps, and height-locked transitions.
  * Hero carousel dots render the auto-play progress ring and respect reduced motion.

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

* **Contact form hardened** with Google reCAPTCHA, localized error states, and Filament inbox for submissions.
* **About page now CMS-driven** (hero copy, mission, vision, badges) with translation fallbacks to defaults.
* **Management team gallery** unlocks bios via modal, keeps slider/grid inline, and improves accessible focus flow.
* **Hero carousel** ships auto-play progress rings, reduced-motion awareness, and smarter pause/resume logic.
* **Brand assets integrated** (PNG logos from the brand book), with **light/dark auto-swap** via `[data-theme]` and CSS variables.
* **Vite asset handling fixed** for images: `import.meta.glob()` eagerly includes brand images so they appear in the manifest.
* **Mobile menu polished** (Alpine.js), unified desktop/mobile behavior, improved escape/focus handling.
* **Projects page** redesigned with translated headings/subheadings, lazy-loaded images, and consistent typography.
* **Services page** refactored with problem-solving circle layout and translations for problem lists.
* **Footer** improved with clickable email/phone, social links, and terms link.
* **Auth views** (login, register, reset, forgot) added with localized strings.

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
* **About** — CMS-driven Who we are, Mission (cards), Vision, CTA
* **Services** — problem-solving circle layout (pawnshop, SMB, compliance)
* **Projects** — responsive cards, translated headings, lazy images
* **Contact** — validated form with Alpine.js, reCAPTCHA, and server-side logging
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
    Controllers/ContactController.php
    Middleware/SetLocale.php
  Filament/
    Resources/ContactSubmissionResource.php
  Models/
    ContactSubmission.php
database/
  migrations/
    2025_10_08_140632_create_contact_submissions_table.php
```

---

## ✉️ Contact Form Validation

* `name`: required, ≤ 255
* `surname`: required, ≤ 255
* `phone`: regex `^\+?\d{7,15}$`
* `comments`: optional, ≤ 1000
* `g-recaptcha-response`: required token when reCAPTCHA is enabled; friendly fallbacks if the widget is offline

Live client-side validation (Alpine.js) + server validation. Success triggers flash message.

Submissions persist to `contact_submissions` with locale/IP context and surface in Filament.

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

Add your `RECAPTCHA_SITE_KEY` and `RECAPTCHA_SECRET_KEY` to `.env` so the contact form stays live.

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
* Swap placeholder management avatars with real photography
* Wire Contact form to outbound notifications (mail/Slack)
* Add real project case studies with images

---

## 📜 License

MIT (template). Content & assets © DGstep.
