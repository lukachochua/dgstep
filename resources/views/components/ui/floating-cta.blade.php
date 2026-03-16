@props([
  'title' => __('messages.floating_cta.title'),
  'primaryLabel' => __('messages.floating_cta.primary'),
])

<x-ui.surface-card
  as="aside"
  class="floating-cta"
  x-data="floatingCta({ delayMs: 7200 })"
  x-cloak
  x-show="isVisible"
  x-transition:enter="transition duration-420 ease-[cubic-bezier(.22,1,.36,1)]"
  x-transition:enter-start="translate-y-3 opacity-0 scale-[0.985]"
  x-transition:enter-end="translate-y-0 opacity-100 scale-100"
  x-transition:leave="transition duration-260 ease-[cubic-bezier(.4,0,.2,1)]"
  x-transition:leave-start="translate-y-0 opacity-100"
  x-transition:leave-end="translate-y-2 opacity-0 scale-[0.99]"
  @keydown.escape.window="dismiss()"
  aria-labelledby="floating-cta-title"
>
  <div class="floating-cta__header">
    <h2 id="floating-cta-title" class="floating-cta__title">{{ $title }}</h2>

    <button
      type="button"
      class="floating-cta__dismiss"
      @click="dismiss()"
      aria-label="{{ __('messages.floating_cta.dismiss') }}"
    >
      <svg viewBox="0 0 16 16" aria-hidden="true" focusable="false">
        <path d="M4 4l8 8M12 4 4 12" />
      </svg>
    </button>
  </div>

  <div class="floating-cta__actions">
    <x-ui.button
      href="{{ route('contact') }}"
      variant="primary"
      size="md"
      class="floating-cta__primary"
      @click="markConverted()"
    >
      {{ $primaryLabel }}
    </x-ui.button>
  </div>
</x-ui.surface-card>
