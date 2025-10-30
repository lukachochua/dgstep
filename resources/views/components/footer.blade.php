@php
  $isKaLocale = app()->getLocale() === 'ka';
  $contactLabelTracking = $isKaLocale ? 'tracking-[0.12em]' : 'tracking-[0.28em]';
@endphp

<footer class="footer-surface select-none text-sm tracking-tight backdrop-blur-0">
  <div class="mx-auto max-w-[var(--container-content)] px-4 sm:px-6 md:px-8 py-10">
    <div class="flex flex-col gap-6">
      <div class="flex flex-wrap items-center justify-center gap-3 text-[color:var(--nav-fg-muted)] md:justify-between">
        <nav class="flex flex-wrap items-center justify-center gap-3 md:justify-start" aria-label="{{ trans('messages.footer.aria.information_links') }}">
          <a href="{{ route('about') }}" class="transition-colors hover:text-[color:var(--nav-fg)]">{{ trans('messages.footer.nav.about') }}</a>
          <span class="footer-divider" aria-hidden="true">•</span>
          <a href="{{ route('home') }}" class="transition-colors hover:text-[color:var(--nav-fg)]">{{ trans('messages.footer.nav.news') }}</a>
          <span class="footer-divider" aria-hidden="true">•</span>
          <a href="{{ route('terms') }}" class="transition-colors hover:text-[color:var(--nav-fg)]">{{ trans('messages.footer.nav.terms') }}</a>
        </nav>

        <div class="flex items-center justify-center gap-3 md:justify-end">
          <a href="https://www.facebook.com/profile.php?id=61579778014106" target="_blank" rel="noopener noreferrer" class="footer-social-icon" aria-label="Facebook">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M7 10v4h3v7h4v-7h3l1-4h-4V7a1 1 0 0 1 1-1h3V2h-3a5 5 0 0 0-5 5v3H7z" />
            </svg>
          </a>
        </div>
      </div>

      <div class="border-t border-[color:var(--nav-fg-muted)]/20 pt-6 flex flex-col items-center gap-3 text-[color:var(--nav-fg)]/85 md:flex-row md:items-center md:justify-between">
        <div class="flex flex-wrap items-center justify-center gap-3 text-[color:var(--nav-fg-muted)] md:justify-start">
          <span class="text-xs font-bold uppercase {{ $contactLabelTracking }} text-[color:var(--nav-fg)]">{{ trans('messages.footer.headings.contact') }}</span>
          <span class="footer-divider" aria-hidden="true">•</span>
          <a href="tel:+995595002837" class="text-sm transition-colors hover:text-[color:var(--nav-fg)]">595 002 837</a>
          <span class="footer-divider" aria-hidden="true">•</span>
          <a href="mailto:info@dgstep.ge" class="text-sm transition-colors hover:text-[color:var(--nav-fg)]">info@dgstep.ge</a>
        </div>

        <p class="text-xs text-[color:var(--nav-fg-muted)] opacity-80 md:text-right">
          {{ trans('messages.footer.copyright', ['year' => now()->year]) }}
        </p>
      </div>
    </div>
  </div>
</footer>
