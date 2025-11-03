# DGstep – Company Website

A modern, multilingual Laravel 12.x marketing site for **DGstep**—powering responsive landing pages, a Filament-powered CMS, and an automated contact pipeline for regulated service providers.

> **Updated:** 2025-11-03

---

## 🔄 Changelog (last 7 days)

* **2025-11-03**
  * Upgraded the Services CMS with expanded copy, problem statements, image previews, and unified data between the homepage cards and services detail rows.
  * Re-skinned the hero carousel with the new arrow aesthetic while keeping the progress ring and reduced-motion safeguards in sync.
* **2025-10-30**
  * Rebuilt the footer into a two-tier layout, aligned desktop navigation hover states, and tightened CTA fallback logic across hero slides.
* **2025-10-27**
  * Fixed hero slider auto-play so the first render now starts the cycle reliably.

---

## ✨ Highlights

* **Services workflow unified** — localised titles, short + expanded descriptions, problem lists, cue styles, and featured ordering all come from Filament tabs and flow to both the homepage highlights and the `/services` detail rows.
* **Contact operations** — public form validates with Google reCAPTCHA v2, stores submissions (locale + IP) and emails the HTML summary to the configurable `MAIL_OPS_TO`. Filament badges unread items and marks them read when opened. Feature tests cover success/failure paths.
* **Hero & navigation polish** — carousel respects `prefers-reduced-motion`, shows progress rings on dots, and uses CTA fallbacks per slide. Navigation ships a two-story desktop layout, theme toggle, locale switcher, and the refreshed footer shares CTA/contact details.
* **Multilingual content** — English (`en`) and Georgian (`ka`) copy is managed through Spatie Translatable across hero slides, services, about, and contact modules. `SetLocale` middleware keeps the session language in sync via the `/locale` POST toggle.
* **Brand-first design system** — Tailwind CSS (via `@tailwindcss/vite`) runs with Calibri typography, CSS custom properties for the DGstep palette, light/dark themes, and Vite-managed brand assets preloaded for predictable caching.

---

## 🧩 Content & CMS

### Filament admin quick start

* URL: `/admin`
* Default admin seeded in `DatabaseSeeder`: `dgstep@admin.com` / `password123`
* Navigation groups split into **Contact** and **Content** for clarity, reusing marketing logos in light & dark mode.

### Managed resources

* **HeroSlideResource** — localised title, highlight, subtitle, and button copy with optional manual href overrides; images/videos feed the hero carousel.
* **ServiceResource** — tabbed locale fields for name, short description, and new `description_expanded`; manage `problems`, cue style/label/values, featured + display ordering, and public storage images with live previews.
* **AboutPageResource** — edits hero imagery, captions, badges, and management roster (modal bios, ordering) with sensible defaults per locale.
* **ContactPageResource** — updates contact hero copy, feature badges, CTA label/phone, and supports DB defaults + language fallbacks.
* **ContactSubmissionResource** — read-only list with unread badge counts; viewing a record auto-calls `markAsRead()` so the nav badge stays accurate.

### Seed data

Running `php artisan migrate --seed` creates:

* Three hero slides with both locales populated.
* Pawnshop, SMB, and Compliance services complete with expanded copy, problems, cue metadata, and placeholder images (`storage/app/public/services/{slug}.jpg`).
* About and Contact defaults so the site renders out of the box.

> Remember to run `php artisan storage:link` so public asset URLs resolve for hero/services images.

---

## 📄 Pages

* **Home** — hero slider with progress rings, arrow controls, CTA fallback logic, and featured services grid sourced from the `Service` model.
* **About** — fully CMS-driven hero, mission/vision copy, badges, and management slider with modal bios, focus traps, and scroll-lock handling.
* **Services** — DB-driven rows with Alpine.js “Show more” toggles for the newly added expanded copy and image/cue fallbacks.
* **Projects** — translated headings with responsive cards and lazy-loaded Unsplash imagery.
* **Contact** — Alpine-powered validation, Google reCAPTCHA widget, success flash messaging, and graceful fallback when keys are missing.
* **Terms** — static legal content (translatable).
* **Auth** — login/register/reset templates for future auth wiring (UI only).

---

## 🌐 Localization & UX

* Locales: English (`en`) and Georgian (`ka`) via Spatie Translatable; session language is enforced by `SetLocale` (configured in `bootstrap/app.php`).
* Locale switcher posts to `/locale` and is exposed in both desktop (icon button) and mobile menus.
* Routes stay language-neutral; translations live under `lang/en` and `lang/ka` with structured arrays for services, projects, contact, etc.
* Theme toggle stores the preference under `localStorage['dg:theme']` and applies CSS tokens before paint to avoid flashes.
* The hero carousel listens to `prefers-reduced-motion`, pausing timers accordingly.

---

## 📬 Contact pipeline

1. **Validation** — `ContactController@submit` enforces required fields, phone regex, max lengths, and ensures a reCAPTCHA token is present.
2. **reCAPTCHA** — verifies the token server-side (5s timeout). Missing secrets surface a friendly validation message so users know to retry later.
3. **Persistence** — submissions store name, surname, phone, optional comments, locale, and IP in `contact_submissions` with timestamps.
4. **Email** — sends `ContactSubmissionReceived` to `config('mail.ops_to')` (default `dgstep2025@gmail.com`). Failures are logged but never block the user.
5. **CMS visibility** — Filament badge counts unread entries and marks them read as soon as the view page loads.
6. **Testing** — `tests/Feature/ContactFormTest.php` exercises the success path (with mocked reCAPTCHA + Mail) and the failure path to guarantee we skip DB writes and outbound mail when tokens fail.

For real mail delivery set:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=your.address@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_OPS_TO=ops@example.com
```

During development you can keep `MAIL_MAILER=log` (default in `.env.example`) to inspect messages in the log output.

---

## 🛠️ Getting Started

### Requirements

* PHP 8.2+
* Composer 2.6+
* Node.js 20+ and npm
* SQLite (default) or another Laravel-supported database

### Initial setup

```bash
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
```

Then update `.env` with:

* `APP_URL` (e.g. `http://localhost:8000`)
* `RECAPTCHA_SITE_KEY` and `RECAPTCHA_SECRET_KEY`
* `MAIL_OPS_TO` and mailer credentials (see above)

### Local development

* One command: `composer run dev` (runs `php artisan serve`, queue listener, Pail log tail, and `npm run dev` concurrently).
* Manual alternative:
  * `php artisan serve`
  * `npm run dev`

Visit `http://localhost:8000`.

### Build for production

```bash
npm run build
php artisan optimize
```

Run `php artisan config:cache` / `route:cache` as needed for your deployment target.

---

## ✅ Testing

* Run the full test suite: `composer test`
* Direct Pest execution: `./vendor/bin/pest --filter=contact` to focus on the contact-form specs
* Tests rely on the in-memory SQLite database thanks to Pest’s `RefreshDatabase` trait.

---

## 🧰 Tech Stack

* **Framework:** Laravel 12.x (2025 LTS)
* **CMS:** Filament 3.2 with Spatie Laravel Translatable
* **Runtime:** PHP 8.2+ (CLI & FPM)
* **CSS:** Tailwind CSS (via `@tailwindcss/vite`) with Calibri brand typography
* **JS:** Alpine.js 3 + bespoke components (hero, navbar, contact form)
* **Bundler:** Vite 6 with eager brand asset imports
* **Testing:** PestPHP 3 + HTTP fakes + Mail fakes

---

## 🗂️ Project Structure

```
resources/
  views/
    layouts/base.blade.php
    components/
      hero.blade.php
      navbar.blade.php
      footer.blade.php
      features.blade.php
      service/row.blade.php
    pages/
      home.blade.php
      about.blade.php
      services.blade.php
      projects.blade.php
      contact.blade.php
      terms.blade.php
    auth/
      login.blade.php
      register.blade.php
      forgot-password.blade.php
      reset-password.blade.php
lang/
  en/…  ka/…   # Localised strings pulled by Spatie Translatable + blades
app/
  Http/
    Controllers/HeroController.php
    Controllers/ContactController.php
    Middleware/SetLocale.php
  Filament/
    Resources/{HeroSlide,Service,AboutPage,ContactPage,ContactSubmission}Resource.php
    Widgets/FeaturedServicesWidget.php
    Pages/Dashboard.php
  Models/{HeroSlide,Service,AboutPage,ContactPage,ContactSubmission}.php
database/
  migrations/*.php  # includes services merge + expanded copy migrations
  seeders/{DatabaseSeeder,ServiceSeeder,AboutPageSeeder,ContactPageSeeder}.php
tests/
  Feature/ContactFormTest.php
```

Public images for services/heroes live in `storage/app/public`; ensure the storage symlink exists for them to resolve under `/storage`.

---

## 🗺️ Roadmap

* Persist the theme toggle automatically (the bootstrap snippet is scaffolded, ready to enable).
* Swap placeholder management portraits with approved photography.
* Push contact notifications to Slack or SMS alongside email delivery.
* Publish real project case studies with CMS-managed media.

---

## 📜 License

MIT (template). Content & assets © DGstep.
