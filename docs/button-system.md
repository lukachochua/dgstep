# Button System

This file tracks the shared button primitives in the marketing site, where they are used, and why they exist.

## Primary primitives

### `x-ui.button`
Used for standard CTA buttons and text-labeled action buttons.

Where:
- `resources/views/components/hero.blade.php`
- `resources/views/components/navbar.blade.php`
- `resources/views/components/ui/service-entry-card.blade.php`
- `resources/views/pages/home.blade.php`
- `resources/views/pages/services.blade.php`
- `resources/views/pages/about.blade.php`
- `resources/views/pages/projects.blade.php`
- `resources/views/pages/contact.blade.php`
- `resources/views/pages/terms.blade.php`

Why:
- unifies the reusable CTA/button shell across links and real form buttons
- supports the shared button variants: `primary`, `secondary`, `ghost`, and `hero`
- supports the shared button sizes: `sm`, `md`, and `lg`

Notes:
- can render as either an anchor or a real `<button>`
- supports route-based, href-based, and submit/button usage

### `x-ui.icon-button`
Used for icon-only navbar controls.

Where:
- `resources/views/components/navbar.blade.php`

Why:
- navbar icon controls have a different shape and sizing from CTA buttons
- keeps icon-only controls off the main CTA button API

## Shared style layer

Base styles live in:
- `resources/css/app.css`

Key style groups:
- `.btn`
- `.btn-sm`
- `.btn-md`
- `.btn-lg`
- `.btn-primary`
- `.btn-secondary`
- `.btn-ghost`
- `.btn-hero`
- `.nav-icon-btn`

## Intentionally not generalized

### Service expand/disclosure button
Where:
- `resources/views/components/ui/service-entry-card.blade.php`

Why:
- it is a stateful disclosure control, not a normal CTA
- it carries its own chevron animation and expand/collapse semantics

Current structure:
- uses `x-ui.button` as the base shell
- keeps `service-expand-btn` and `service-expand-btn__chevron` as local behavior styles

### Service back-to-top anchor
Where:
- `resources/views/components/ui/service-entry-card.blade.php`

Why:
- intentionally presented as a lightweight inline anchor, not a CTA button

### Navigation links
Where:
- `resources/views/components/navbar.blade.php`

Why:
- primary nav links and mobile menu links are navigation items, not action buttons

## Practical rule

Use `x-ui.button` when:
- the control is a CTA or action
- it needs shared button styling
- it can be expressed with the existing variant and size system

Use `x-ui.icon-button` when:
- the control is icon-only
- it belongs to the navbar-style circular control family

Keep it page-specific when:
- the control is really a disclosure/toggle pattern rather than a button
- the interaction semantics are different enough that a generic CTA abstraction adds noise
