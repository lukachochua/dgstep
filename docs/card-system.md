# Card System

This file tracks the current card primitives in the marketing site, where they are used, and why they exist.

## Primitive cards

### `x-ui.surface-card`
Used for generic surface shells and section wrappers.

Where:
- `resources/views/components/hero.blade.php`
- `resources/views/pages/home.blade.php`
- `resources/views/pages/about.blade.php`
- `resources/views/pages/projects.blade.php`
- `resources/views/pages/services.blade.php`
- `resources/views/pages/contact.blade.php`

Why:
- shared border, radius, shadow, and elevated surface treatment
- supports variants like `default`, `soft`, `hero`, and `hero-detail`

### `x-ui.metric-card`
Used as the low-level compact metric shell.

Where:
- wrapped mostly through `x-ui.stat-card`

Why:
- keeps the compact metric/pill-card styling reusable without forcing content structure

### `x-ui.entity-card`
Used as the shared shell for feature, service, team, project, legal, and auth card families.

Where:
- `resources/views/components/features.blade.php`
- `resources/views/components/service/row.blade.php`
- `resources/views/pages/about.blade.php`
- `resources/views/pages/projects.blade.php`
- `resources/views/pages/terms.blade.php`
- `resources/views/auth/*.blade.php`

Why:
- unifies the reusable “content card” visual family while allowing page-specific internals

## Structured cards

### `x-ui.stat-card`
Used for repeated “label + value + optional description” content.

Where:
- `resources/views/pages/home.blade.php`
- `resources/views/pages/services.blade.php`
- `resources/views/pages/contact.blade.php`

Why:
- these were repeated enough to justify a structured component on top of `metric-card`

### `x-ui.media-card`
Used for image-first cards with a title and description.

Where:
- `resources/views/components/features.blade.php`
- `resources/views/pages/projects.blade.php`

Why:
- feature cards and project cards were using nearly identical media + body structure

### `x-ui.section-cta-card`
Used for repeated CTA sections with copy on one side and actions on the other.

Where:
- `resources/views/pages/home.blade.php`
- `resources/views/pages/services.blade.php`
- `resources/views/pages/projects.blade.php`

Why:
- these sections shared the same content rhythm and wrapper behavior

### `x-ui.profile-card`
Used for team/member presentation in compact and lead variants.

Where:
- `resources/views/pages/about.blade.php`

Why:
- the About team area had the same profile information repeated in two layouts
- keeps the lead/member distinction while avoiding duplicated profile markup

### `x-ui.index-link-card`
Used for indexed navigation-style cards.

Where:
- `resources/views/pages/services.blade.php`

Why:
- the services overview list is a reusable “index + title + optional sublabel + link” pattern

### `x-ui.editorial-card`
Used for short editorial content blocks with label/title/body structure.

Where:
- `resources/views/pages/about.blade.php`

Why:
- mission and vision cards share the same editorial structure

### `x-ui.service-entry-card`
Used for the full services-page service row card.

Where:
- called indirectly from `resources/views/components/service/row.blade.php`

Why:
- this is the largest remaining custom marketing card
- extracting it isolates the complex service-row internals from the page layout

## Still intentionally page-specific

### Home hero slide content
Where:
- `resources/views/components/hero.blade.php`

Why:
- it is still a specialized slider composition, not a general-purpose card

### About team modal
Where:
- `resources/views/pages/about.blade.php`

Why:
- modal behavior is tightly coupled to the About team interaction

## Practical rule

Use a primitive card when only the shell is shared.

Use a structured card when:
- the markup repeats in multiple places
- the data shape is stable
- the component reduces duplication without hiding important layout intent
