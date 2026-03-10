# Homepage Improvement Plan

This document is a code-backed audit of the current homepage and a practical plan for improving it. It is based on the current implementation in:

- `resources/views/pages/home.blade.php`
- `resources/views/components/hero.blade.php`
- `resources/views/components/features.blade.php`
- `resources/views/components/footer.blade.php`
- `resources/views/layouts/base.blade.php`
- `resources/css/app.css`
- `lang/en/messages.php`
- `lang/en/contact.php`
- `app/Http/Controllers/HeroController.php`

## Current flaws

### 1. Positioning is inconsistent

The homepage mixes three different stories:

- General SMB operations software: `lang/en/messages.php:16-18`, `lang/en/messages.php:44`
- Georgia-local operational tooling: `lang/en/messages.php:74-75`
- Pawnshop-specific product framing: `lang/en/messages.php:86-113`, `lang/en/services.php:10-20`

Result:

- The user does not get a single clear answer to "Who is this for?"
- The page sounds broad in the hero, niche in the feature set, and generic in the CTA.

### 2. The hero is visually busy but strategically weak

The hero is a full-screen autoplay slider with multiple headlines and multiple CTA targets:

- Full viewport section: `resources/css/app.css:645-649`
- Autoplay slider logic: `resources/views/components/hero.blade.php:47-282`
- Autoplay controls, dots, nav arrows: `resources/css/app.css:983-1217`
- Title sizing is modest for such a dominant section: `app/Http/Controllers/HeroController.php:79-91`, `resources/css/app.css:776-799`

Result:

- The core value proposition changes before the user has processed it.
- A full-screen first section spends too much vertical space on interaction chrome instead of proof.
- The page leads with motion and atmosphere, not confidence.

### 3. "Proof" content is not real proof

The proof section uses claims like `4-8 weeks`, `24/7 control`, and `Georgia-ready`:

- `resources/views/pages/home.blade.php:17-33`
- `lang/en/messages.php:61-83`

Result:

- These read as marketing assertions, not evidence.
- There are no case studies, screenshots, client outcomes, integrations, testimonials, or process examples to substantiate them.

### 4. The features section is shallow and low-intent

The features block shows service cards, but every card funnels to the same generic services page:

- Section structure: `resources/views/components/features.blade.php:16-75`
- Same `services` route for all cards: `resources/views/components/features.blade.php:48-50`

Result:

- There is no clear next step per service.
- Users cannot branch into a relevant path such as pawnshops vs general SMBs vs compliance.
- The section behaves like a brochure grid rather than a decision aid.

### 5. The final CTA repeats copy instead of closing the sale

The closing panel reuses generic contact language:

- `resources/views/pages/home.blade.php:40-55`
- `lang/en/contact.php:6-8`

Result:

- The page ends without a strong conversion trigger.
- It does not answer implementation risk, timeline, pricing model, or who should reach out.

### 6. Credibility leaks exist in the shell

- Generic page title: `resources/views/pages/home.blade.php:1`
- Generic meta description pattern: `resources/views/layouts/base.blade.php:6-18`, `resources/views/layouts/base.blade.php:35-48`
- Dead social links in footer: `resources/views/components/footer.blade.php:18-29`

Result:

- The page looks less finished than it should.
- Dead-end links reduce trust immediately.
- SEO/social preview positioning is weaker than the on-page messaging needs.

## Visual audit

### 1. The visual hierarchy is upside down

The first screen gives too much space to the container and motion system, and not enough to the core message.

- Full-screen hero height: `resources/css/app.css:645-649`
- Hero content is pushed into a large vertical composition with bottom-pinned actions and chips: `resources/css/app.css:729-860`
- HUD, autoplay control, dots, and arrows add interface weight: `resources/css/app.css:983-1115`

Result:

- The eye lands on atmosphere and controls before it lands on a decisive promise.
- The page feels elaborate without feeling authoritative.

### 2. The hero composition is over-layered

The hero stacks image, fallback gradient, double veil, chips, CTA group, trust chips, navigation arrows, progress bar, dots, and autoplay toggle.

- Hero media and veil layers: `resources/css/app.css:682-727`
- Hero trust chips and CTA layout: `resources/css/app.css:802-932`
- Slider behavior and controls: `resources/views/components/hero.blade.php:47-282`

Result:

- The composition is busy relative to the amount of information it communicates.
- It reads more like a showcase component than a sharp landing section.

### 3. Navigation styling is decorative but not distinctive

The navbar uses blur, glow, radial overlays, and pill links, but the brand silhouette is still fairly generic.

- Navbar shell effects: `resources/css/app.css:223-280`
- Link and icon button styling: `resources/css/app.css:309-373`
- Navbar structure: `resources/views/components/navbar.blade.php:37-100`

Result:

- There is visual polish, but not a memorable information shape.
- The nav takes styling complexity without creating stronger orientation or brand character.

### 4. Card system is competent but visually flat

The proof cards and feature cards share the same soft bordered panel language and hover lift pattern.

- Metric cards: `resources/css/app.css:1231-1242`
- Feature cards: `resources/css/app.css:1274-1297`
- Feature section structure: `resources/views/components/features.blade.php:16-75`

Result:

- Sections blend together too easily.
- The page lacks contrast between "proof", "solutions", and "conversion" moments.

### 5. The footer is too light for a closing section

The footer uses nearly the same surface language as the rest of the site.

- Footer shell and social links: `resources/css/app.css:1335-1392`
- Footer structure: `resources/views/components/footer.blade.php:1-40`

Result:

- The page does not end with a strong visual close.
- Contact details and trust signals do not feel elevated.

### 6. Motion is doing more than it should

There is autoplay in the hero plus staggered left-to-right reveal behavior across sections.

- Hero motion logic: `resources/views/components/hero.blade.php:47-282`
- Reveal-on-scroll behavior: `resources/js/app.js:19-57`
- Reveal styling: `resources/css/app.css:1437-1454`

Result:

- Motion is part of the page identity, but it is not serving the strongest content.
- The site risks feeling more animated than intentional.

## Improvement objectives

The homepage should do five things clearly:

1. State exactly who DGstep serves.
2. Explain the product value in one stable above-the-fold story.
3. Show proof that the offer works.
4. Route visitors into the right solution path quickly.
5. Remove trust leaks and generic copy.

## Recommended direction

Use a single-message homepage with a segmented path, not a rotating-message hero.

Recommended positioning approach:

- Primary audience: Georgian businesses with operational complexity
- Strongest wedge: pawnshops and compliance-heavy SMB workflows
- Homepage framing: "Operational software built for Georgian businesses that need structure, control, and faster rollout"

This keeps the market broad enough for growth while preserving the strongest niche signal.

Visual direction:

- Reduce glassmorphism and UI chrome.
- Increase contrast between sections by purpose, not by adding more effects.
- Make the hero feel editorial and product-led, not slider-led.
- Give the footer and CTA area a stronger closing surface than the mid-page cards.

## Phased implementation plan

### Phase 1. Fix the message architecture

Goal:
Make the page understandable in 5 seconds.

Actions:

- Replace the slider with a static hero or a single non-autoplay panel.
- Reduce the hero to one headline, one supporting paragraph, one primary CTA, and one secondary CTA.
- Rewrite homepage copy so it consistently supports one positioning strategy.
- Add a segmented subnav or decision block right under the hero:
  - Pawnshops
  - Small businesses
  - Compliance/reporting

Files to change:

- `resources/views/components/hero.blade.php`
- `resources/css/app.css`
- `app/Http/Controllers/HeroController.php`
- `lang/en/messages.php`
- `lang/ka/messages.php`

Acceptance criteria:

- One stable value proposition appears on first load.
- The target audience is explicit.
- The primary CTA is unambiguous.

### Phase 2. Replace fake proof with actual proof

Goal:
Increase trust without relying on vague claims.

Actions:

- Replace the current metric trio with evidence-backed content:
  - implementation timeline range only if it is consistently true
  - types of workflows supported
  - compliance capabilities
  - support model
- Add one real proof module:
  - mini case study
  - before/after workflow
  - screenshot strip
  - "how rollout works" timeline
- Add logos, client types, or ecosystem references if available.

Files to change:

- `resources/views/pages/home.blade.php`
- `lang/en/messages.php`
- `lang/ka/messages.php`

Acceptance criteria:

- Every claim on the homepage is either demonstrated or intentionally softened.
- The user can see what the product actually changes in operations.

### Phase 3. Turn services into decision paths

Goal:
Help users self-select instead of browsing passively.

Actions:

- Convert the features grid into outcome-led solution cards.
- Give each card a specific CTA and destination.
- Make each card answer:
  - who it is for
  - what problem it solves
  - what changes after adoption
- If service detail pages are not ready, create anchored sections on `/services` and link each card directly there.

Files to change:

- `resources/views/components/features.blade.php`
- `resources/views/pages/services.blade.php`
- `lang/en/services.php`
- `lang/ka/services.php`

Acceptance criteria:

- Each homepage card leads to a distinct next step.
- The homepage supports both scanning and deliberate evaluation.

### Phase 4. Tighten conversion and trust details

Goal:
Make the page feel finished and ready for traffic.

Actions:

- Rewrite the closing CTA around a stronger promise:
  - book a discovery call
  - request a workflow review
  - talk about your business process
- Replace `href="#"` social links with real URLs or remove them.
- Improve homepage-specific SEO metadata.
- Add a small trust strip near the CTA:
  - response time
  - implementation support
  - local market understanding

Files to change:

- `resources/views/pages/home.blade.php`
- `resources/views/components/footer.blade.php`
- `resources/views/layouts/base.blade.php`

Acceptance criteria:

- No dead-end links remain.
- The final CTA gives the user a concrete reason to act now.
- The homepage metadata matches the actual positioning.

### Phase 5. Rebuild the visual hierarchy

Goal:
Make the homepage feel sharper, calmer, and more intentional.

Actions:

- Replace the full-screen hero with a shorter, denser first screen.
- Remove autoplay, progress UI, and side arrows from the homepage hero.
- Recompose the hero into a strong two-column or stacked layout:
  - message block
  - supporting product visual, proof strip, or workflow snapshot
- Increase headline dominance and tighten supporting copy width.
- Use one strong background system for the hero instead of multiple overlapping visual effects.

Files to change:

- `resources/views/components/hero.blade.php`
- `resources/css/app.css`
- `app/Http/Controllers/HeroController.php`

Acceptance criteria:

- The first screen communicates the value proposition before any decorative element competes for attention.
- Above-the-fold content feels denser and more intentional.
- The homepage can stand still without losing impact.

### Phase 6. Differentiate sections by purpose

Goal:
Create visual rhythm so the page is easier to scan and remember.

Actions:

- Give each major section a distinct composition:
  - hero: strong lead statement
  - proof: tighter evidence blocks or timeline
  - solutions: segmented cards with clearer affordances
  - CTA/footer: darker or more grounded closing band
- Stop reusing the same panel treatment everywhere.
- Use spacing and typography shifts to signal section changes before color/effects do.

Files to change:

- `resources/views/pages/home.blade.php`
- `resources/views/components/features.blade.php`
- `resources/views/components/footer.blade.php`
- `resources/css/app.css`

Acceptance criteria:

- Users can distinguish proof, solution, and conversion sections at a glance.
- The page reads as a sequence, not a stack of similar cards.

### Phase 7. Simplify motion and polish interaction

Goal:
Keep motion purposeful and remove ornamental behavior.

Actions:

- Limit reveal animation to a few meaningful section entrances.
- Remove any motion that compensates for weak content.
- Keep hover states crisp and restrained.
- Review focus states and touch targets while simplifying interactions.

Files to change:

- `resources/js/app.js`
- `resources/css/app.css`
- `resources/views/components/hero.blade.php`
- `resources/views/components/navbar.blade.php`

Acceptance criteria:

- Motion supports hierarchy instead of distracting from it.
- Interactive elements feel cleaner and easier to trust.

## Execution order

1. Copy and positioning rewrite
2. Hero simplification and visual hierarchy rebuild
3. Proof section rebuild
4. Services decision-path rebuild
5. CTA and footer cleanup
6. Motion simplification and visual polish
7. SEO pass

This order matters. If the positioning is not fixed first, design refinement will only polish the wrong story.

## Combined improvement strategy

The correct way to improve this homepage is:

1. Clarify the commercial story.
2. Rebuild the hero around that story.
3. Add proof that makes the story believable.
4. Re-shape the rest of the page so each section has a distinct job and visual form.

Content and style are linked here:

- Better copy without hierarchy will still feel generic.
- Better styling without clearer positioning will still feel vague.
- The win comes from making the page more specific and visually calmer at the same time.

## Suggested success metrics

Track these after launch:

- Homepage to contact-page click-through rate
- Homepage scroll depth to 50% and 75%
- Click-through rate on each solution card
- Contact form completion rate
- Bounce rate from the homepage

## Inputs needed from DGstep

To complete the redesign properly, content inputs are required:

- Primary commercial target for the next 6-12 months
- 1-3 real client stories or anonymized workflow examples
- Real implementation timeline ranges
- Real support and rollout model
- Real social links or confirmation to remove them

## Immediate quick wins

These can be done before a broader redesign:

- Remove footer placeholder links
- Replace `DGstep Landing Page` with a real homepage title
- Stop rotating the core homepage message automatically
- Rewrite the proof cards to avoid unsupported certainty
- Reduce hero height and remove non-essential hero controls
