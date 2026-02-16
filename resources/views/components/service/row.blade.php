@props([
    'title' => '',
    'description' => '',
    'image' => null,
    'imageAlt' => '',
    'fullDescription' => '',
    'reversed' => false,
])

@php
    $fullCopy = '';
    $defaultServiceImage = 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?q=80&w=1200&auto=format&fit=crop';
    $resolvedImage = $image ?: $defaultServiceImage;

    if ($fullDescription instanceof \Illuminate\Contracts\Support\Htmlable) {
        $fullCopy = trim($fullDescription->toHtml());
    } elseif (is_string($fullDescription)) {
        $fullCopy = trim($fullDescription);
    }

    $hasFull = $fullCopy !== '';
@endphp

<article class="service-card p-5 md:p-8 reveal">
  <div @class([
      'grid gap-6 md:gap-8 lg:grid-cols-2 lg:items-start',
      'lg:[&>div:first-child]:order-2 lg:[&>div:last-child]:order-1' => $reversed,
  ])>
    <div class="space-y-4">
      <h3 class="text-2xl font-semibold leading-tight md:text-3xl">{{ $title }}</h3>
      <p class="text-[color:var(--text-muted)]">{{ $description }}</p>

      @if ($hasFull)
        <div x-data="{ open: false }" class="space-y-3">
          <div
            x-show="open"
            x-collapse
            x-cloak
            class="rounded-xl border border-[color:var(--border)] bg-[color:var(--bg-muted)]/45 p-4 text-sm text-[color:var(--text-muted)]"
          >
            {!! $fullCopy !!}
          </div>

          <x-ui.button
            as="button"
            type="button"
            variant="ghost"
            size="sm"
            class="service-expand-btn"
            @click="open = !open"
          >
            <span x-text="open ? @js(__('services.show_less')) : @js(__('services.read_more'))"></span>
            <svg
              class="service-expand-btn__chevron"
              :class="{ 'is-open': open }"
              width="14"
              height="14"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
              aria-hidden="true"
            >
              <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </x-ui.button>
        </div>
      @endif
    </div>

    <div>
      <img
        src="{{ $resolvedImage }}"
        alt="{{ $imageAlt ?: $title }}"
        class="service-image h-64 w-full md:h-72 lg:h-80"
        loading="lazy"
        decoding="async"
      />
    </div>
  </div>
</article>
