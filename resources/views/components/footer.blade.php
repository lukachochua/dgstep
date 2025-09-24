<footer
  class="select-none text-sm tracking-tight font-[Calibri]
         border-t border-[var(--nav-border)]
         bg-[var(--mobile-nav-bg)]/95 text-[color:var(--nav-fg-muted)]
         backdrop-blur-md shadow-[0_-8px_20px_rgba(0,0,0,.25)]">
  <div class="mx-auto max-w-[var(--container-content)] px-4 sm:px-6 md:px-8 py-10
              flex flex-col md:flex-row justify-between gap-6">

    <!-- Left: Info + GitHub + Stack + Social -->
    <div class="flex flex-col items-center md:items-start text-center md:text-left space-y-1">
      <p class="opacity-80">
        {{ trans('messages.footer.copyright', ['year' => now()->year]) }}
      </p>

      <!-- GitHub -->
      <a href="https://github.com/lukachochua/dgstep" target="_blank" rel="noopener noreferrer"
         class="inline-flex items-center gap-2 text-[color:var(--nav-fg-muted)] hover:text-[color:var(--nav-fg)]
                transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M12 2C6.475 2 2 6.589 2 12.253c0 4.525 2.862 8.36 6.838 9.712.5.096.683-.222.683-.492 0-.243-.01-1.05-.015-1.905-2.781.62-3.37-1.21-3.37-1.21-.455-1.18-1.11-1.494-1.11-1.494-.907-.642.069-.63.069-.63 1.003.072 1.53 1.055 1.53 1.055.892 1.57 2.341 1.116 2.91.853.091-.663.35-1.116.636-1.373-2.221-.259-4.555-1.14-4.555-5.075 0-1.121.386-2.037 1.02-2.757-.103-.259-.442-1.303.096-2.715 0 0 .834-.27 2.734 1.054A9.313 9.313 0 0 1 12 7.48c.845.004 1.694.115 2.486.337 1.899-1.324 2.731-1.054 2.731-1.054.54 1.412.201 2.456.099 2.715.634.72 1.018 1.636 1.018 2.757 0 3.945-2.338 4.813-4.566 5.068.359.319.68.948.68 1.914 0 1.381-.013 2.494-.013 2.833 0 .272.18.592.688.491A10.022 10.022 0 0 0 22 12.253C22 6.589 17.523 2 12 2Z" />
        </svg>
        GitHub: lukachochua/dgstep
      </a>

      <!-- Social media -->
      <div class="flex items-center gap-4 pt-1" aria-label="Social media">
        <!-- Instagram -->
        <a href="https://instagram.com/yourpage" target="_blank" rel="noopener noreferrer"
           class="inline-flex items-center gap-2 text-[color:var(--nav-fg-muted)] hover:text-[color:var(--nav-fg)]
                  transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
            <line x1="17.5" y1="6.5" x2="17.5" y2="6.5"/>
          </svg>
          Instagram
        </a>

        <!-- Facebook -->
        <a href="https://facebook.com/yourpage" target="_blank" rel="noopener noreferrer"
           class="inline-flex items-center gap-2 text-[color:var(--nav-fg-muted)] hover:text-[color:var(--nav-fg)]
                  transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M7 10v4h3v7h4v-7h3l1-4h-4V7a1 1 0 0 1 1-1h3V2h-3a5 5 0 0 0-5 5v3H7z"/>
          </svg>
          Facebook
        </a>
      </div>

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
