<footer class="footer-shell">
  <div class="footer-inner">
    <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
      <div class="space-y-2">
        <p class="text-sm font-semibold">DGstep</p>
        <p class="text-sm text-[color:var(--text-muted)] max-w-md">
          {{ __('contact.description') }}
        </p>
      </div>

      <nav class="footer-social flex flex-row items-center gap-3" aria-label="{{ trans('messages.footer.aria.social_media') }}">
        <a href="#" class="footer-social-link" aria-label="Facebook">
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M13.5 22v-8h2.7l.4-3.2h-3.1V8.9c0-.9.2-1.5 1.6-1.5h1.7V4.6c-.3 0-1.3-.1-2.5-.1-2.5 0-4.1 1.5-4.1 4.3v2h-2.8V14h2.8v8h2.7Z"/>
          </svg>
          <span class="sr-only">Facebook</span>
        </a>
        <a href="#" class="footer-social-link" aria-label="Instagram">
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M7 2C4.2 2 2 4.2 2 7v10c0 2.8 2.2 5 5 5h10c2.8 0 5-2.2 5-5V7c0-2.8-2.2-5-5-5H7Zm10 2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h10Zm-5 3.8A5.2 5.2 0 1 0 17.2 13 5.2 5.2 0 0 0 12 7.8Zm0 2A3.2 3.2 0 1 1 8.8 13 3.2 3.2 0 0 1 12 9.8Zm5.6-3.3a1.2 1.2 0 1 0 0 2.4 1.2 1.2 0 0 0 0-2.4Z"/>
          </svg>
          <span class="sr-only">Instagram</span>
        </a>
        <a href="#" class="footer-social-link" aria-label="TikTok">
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M14.7 2h2.4c.3 1.7 1.3 3.1 2.9 3.9v2.6a7.4 7.4 0 0 1-2.9-1V14a6 6 0 1 1-6-6h.2v2.6h-.2a3.4 3.4 0 1 0 3.4 3.4V2Z"/>
          </svg>
          <span class="sr-only">TikTok</span>
        </a>
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
