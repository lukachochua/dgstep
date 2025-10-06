<footer class="footer-surface select-none text-sm tracking-tight backdrop-blur-0">
  <div class="mx-auto max-w-[var(--container-content)] px-4 sm:px-6 md:px-8 py-12">
    <div class="grid gap-12 md:grid-cols-2">
      <section class="space-y-4 text-center md:text-left">
        <h3 class="text-xs font-semibold uppercase tracking-[0.3em] text-[color:var(--nav-fg-muted)]">{{ trans('messages.footer.headings.information') }}</h3>
        <nav class="flex flex-col items-center md:items-start space-y-2 text-[color:var(--nav-fg-muted)]" aria-label="{{ trans('messages.footer.aria.information_links') }}">
          <a href="{{ route('about') }}" class="transition-colors hover:text-[color:var(--nav-fg)]">{{ trans('messages.footer.nav.about') }}</a>
          <a href="{{ route('home') }}" class="transition-colors hover:text-[color:var(--nav-fg)]">{{ trans('messages.footer.nav.news') }}</a>
          <a href="{{ route('terms') }}" class="transition-colors hover:text-[color:var(--nav-fg)]">{{ trans('messages.footer.nav.terms') }}</a>
        </nav>
      </section>

      <section class="space-y-4 text-center md:text-right">
        <h3 class="text-xs font-semibold uppercase tracking-[0.3em] text-[color:var(--nav-fg-muted)]">{{ trans('messages.footer.headings.contact') }}</h3>
        <div class="space-y-2 text-[color:var(--nav-fg)]/90">
          <a href="tel:+995595002837" class="block transition-colors hover:text-[color:var(--nav-fg)]">+995 595 002837</a>
          <a href="mailto:info@dgstep.ge" class="block transition-colors hover:text-[color:var(--nav-fg)]">info@dgstep.ge</a>
        </div>
        <a href="{{ route('contact') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-[color:var(--nav-fg)] px-6 py-2 text-[color:var(--nav-bg)] font-medium transition-transform transition-colors hover:scale-[1.02] hover:bg-[color:var(--nav-fg)]/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[color:var(--nav-fg)]">{{ trans('messages.footer.cta') }}</a>
      </section>
    </div>

    <div class="mt-10 flex flex-col gap-4 border-t border-[color:var(--nav-fg-muted)]/20 pt-6 md:flex-row md:items-center md:justify-between">
      <p class="opacity-90 text-center md:text-left">
        {{ trans('messages.footer.copyright', ['year' => now()->year]) }}
      </p>
      <div class="flex items-center justify-center gap-4" aria-label="{{ trans('messages.footer.aria.social_media') }}">
        <a href="https://www.facebook.com/profile.php?id=61579778014106" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-[color:var(--nav-fg-muted)] hover:text-[color:var(--nav-fg)] transition-colors" aria-label="Facebook">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M7 10v4h3v7h4v-7h3l1-4h-4V7a1 1 0 0 1 1-1h3V2h-3a5 5 0 0 0-5 5v3H7z"/>
          </svg>
        </a>
      </div>
    </div>
  </div>
</footer>
