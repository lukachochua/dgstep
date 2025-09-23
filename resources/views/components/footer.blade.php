<footer
  class="select-none text-sm tracking-tight font-[FiraGO]
         border-t border-[var(--nav-border)]
         bg-[var(--mobile-nav-bg)]/95 text-[color:var(--nav-fg-muted)]
         backdrop-blur-md shadow-[0_-8px_20px_rgba(0,0,0,.25)]">
  <div class="mx-auto max-w-[var(--container-content)] px-4 sm:px-6 md:px-8 py-10
              flex flex-col md:flex-row justify-between gap-6">

    <!-- Left: Info + GitHub + Stack -->
    <div class="flex flex-col items-center md:items-start text-center md:text-left space-y-1">
      <p class="opacity-80">
        {{ trans('messages.footer.copyright', ['year' => now()->year]) }}
      </p>

      <a href="https://github.com/lukachochua/dgstep" target="_blank" rel="noopener noreferrer"
         class="inline-flex items-center gap-2 text-[color:var(--nav-fg-muted)] hover:text-[color:var(--nav-fg)]
                transition-colors">
        <span class="i-tabler-brand-github hidden" aria-hidden="true"></span>
        GitHub: lukachochua/dgstep
      </a>

      <p class="opacity-85">
        Stack: Laravel 12 / Tailwind CSS / Alpine.js
      </p>
    </div>

    <!-- Right: Terms, Contact, Email & Phone -->
    <div class="flex flex-col items-center md:items-end text-center md:text-right space-y-1">
      <a href="{{ route('terms') }}"
         class="inline-flex items-center gap-2 text-[color:var(--nav-fg-muted)] hover:text-[color:var(--nav-fg)]
                transition-colors">
        {{ __('messages.footer.nav.terms') }}
      </a>

      <a href="#contact"
         class="inline-flex items-center gap-2 text-[color:var(--nav-fg-muted)] hover:text-[color:var(--nav-fg)]
                transition-colors">
        {{ __('messages.footer.nav.contact') }}
      </a>

      <a href="mailto:info@example.com"
         class="inline-flex items-center gap-2 text-[color:var(--nav-fg)]/90 hover:text-[color:var(--nav-fg)]
                transition-colors">
        <span aria-hidden="true">📧</span> info@example.com
      </a>

      <a href="tel:+995599000000"
         class="inline-flex items-center gap-2 text-[color:var(--nav-fg)]/90 hover:text-[color:var(--nav-fg)]
                transition-colors">
        <span aria-hidden="true">📞</span> +995 599 000 000
      </a>
    </div>

  </div>
</footer>
