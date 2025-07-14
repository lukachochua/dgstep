# DGstep – Company Website

A modern, multilingual Laravel 12.x website for DGstep – a technology company providing software solutions for pawnshops and small-to-medium enterprises.  
This site features a clean, responsive UI built with Tailwind CSS and Alpine.js, emphasizing clarity, performance, and a professional brand presence.

---

## 🚀 Tech Stack

- **Framework:** Laravel 12.x (2025 LTS)
- **CSS Framework:** Tailwind CSS (JIT mode)
- **JS Layer:** Alpine.js (lightweight interactivity)
- **Languages:** PHP 8.3+, HTML5, JavaScript (ES6+)
- **Blade Components:** x-components for UI modularity
- **Routing:** Locale-prefixed routes (`/en`, `/ka`)
- **i18n:** Laravel translation system (`lang/{locale}/`)
- **Middleware:** Locale detection via route prefix

---

## 🌐 Localization System

- Language switcher with support for Georgian and English
- Route prefixes: `/ka/...`, `/en/...`  
- `SetLocale` middleware registered via `bootstrap/app.php`
- Translations handled via `__('key')` helpers
- Navbar links dynamically switch languages while maintaining page
- Active route states handled using `request()->routeIs()`

---

## 🧱 Structure

```bash
resources/
├── views/
│   ├── components/       # Blade UI components (navbar, footer, features, etc.)
│   ├── layouts/          # Layout templates (base.blade.php)
│   ├── pages/            # Route-specific pages (home, about, services, etc.)
│   └── auth/             # Custom authentication views (login, register, etc.)
├── lang/
│   ├── en/               # English translations
│   └── ka/               # Georgian translations
routes/
└── web.php               # Locale-aware route definitions
