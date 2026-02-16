<footer class="footer-shell">
  <div class="footer-inner">
    <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
      <div class="space-y-2">
        <p class="text-sm font-semibold">DGstep</p>
        <p class="text-sm text-[color:var(--text-muted)] max-w-md">
          {{ __('contact.description') }}
        </p>
      </div>

      <nav class="flex flex-wrap items-center gap-4 text-sm" aria-label="{{ trans('messages.footer.aria.information_links') }}">
        <a href="{{ route('home') }}" class="footer-link">{{ __('messages.home') }}</a>
        <a href="{{ route('services') }}" class="footer-link">{{ __('messages.services') }}</a>
        <a href="{{ route('about') }}" class="footer-link">{{ __('messages.about') }}</a>
        <a href="{{ route('terms') }}" class="footer-link">{{ __('messages.footer.nav.terms') }}</a>
        <a href="{{ route('contact') }}" class="footer-link">{{ __('messages.contact') }}</a>
      </nav>
    </div>

    <div class="mt-6 flex flex-col gap-2 border-t border-[color:var(--border)] pt-5 text-xs text-[color:var(--text-muted)] md:flex-row md:items-center md:justify-between">
      <p>{{ trans('messages.footer.copyright', ['year' => now()->year]) }}</p>
      <div class="flex items-center gap-4">
        <a href="tel:+995595002837" class="footer-link">595 002 837</a>
        <a href="mailto:info@dgstep.ge" class="footer-link">info@dgstep.ge</a>
      </div>
    </div>
  </div>
</footer>
