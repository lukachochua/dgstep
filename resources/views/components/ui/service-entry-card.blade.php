@props([
  'title' => '',
  'description' => '',
  'fullDescription' => '',
  'image' => null,
  'imageAlt' => '',
  'slug' => '',
  'problems' => [],
  'index' => 1,
  'cueStyle' => 'bubbles',
  'cueLabel' => '',
  'cueValues' => [],
  'problemsHeading' => '',
  'ctaLabel' => '',
  'backToTopLabel' => '',
  'readMoreLabel' => '',
  'showLessLabel' => '',
  'reversed' => false,
])

@php
  $defaultServiceImage = 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?q=80&w=1200&auto=format&fit=crop';
  $resolvedImage = $image ?: $defaultServiceImage;
  $hasFull = $fullDescription !== '';
  $problemItems = array_slice($problems, 0, 4);
  $serviceId = $slug !== '' ? 'service-' . $slug : null;
  $displayIndex = str_pad((string) max(1, $index), 2, '0', STR_PAD_LEFT);
  $cueItems = array_slice($cueValues, 0, 5);
  $hasCue = $cueLabel !== '' && $cueItems !== [];
@endphp

<x-ui.entity-card
  variant="service"
  as="article"
  :id="$serviceId"
  {{ $attributes->class(['service-entry p-5 md:p-8 reveal']) }}
>
  <div class="service-entry__eyebrow">
    <span class="service-entry__index">{{ $displayIndex }}</span>
    @if ($cueLabel !== '')
      <span class="service-entry__cue-label">{{ $cueLabel }}</span>
    @endif
  </div>

  <div @class([
      'grid gap-6 md:gap-8 lg:grid-cols-[minmax(0,1.05fr)_minmax(280px,0.95fr)] lg:items-start',
      'lg:[&>div:first-child]:order-2 lg:[&>div:last-child]:order-1' => $reversed,
  ])>
    <div class="service-entry__copy">
      <h2 class="service-entry__title">{{ $title }}</h2>
      <p class="service-entry__lead">{{ $description }}</p>

      @if ($problemItems !== [])
        <div class="service-entry__block">
          <p class="service-entry__block-label">{{ $problemsHeading }}</p>
          <ul class="service-entry__problems" aria-label="{{ $problemsHeading }}">
            @foreach ($problemItems as $problem)
              <li class="service-problem-pill">{{ $problem }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if ($hasFull)
        <div x-data="{ open: false }" class="service-entry__block">
          <div
            x-show="open"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-1"
            class="service-entry__details"
          >
            {!! $fullDescription !!}
          </div>

          <x-ui.button
            as="button"
            type="button"
            variant="ghost"
            size="sm"
            class="service-expand-btn"
            @click="open = !open"
          >
            <span x-text="open ? @js($showLessLabel) : @js($readMoreLabel)"></span>
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

      <div class="service-entry__actions">
        <x-ui.button route="contact" variant="primary" size="sm">
          {{ $ctaLabel }}
        </x-ui.button>
        <a href="#services-top" class="service-anchor-link">{{ $backToTopLabel }}</a>
      </div>
    </div>

    <div class="service-entry__media">
      <img
        src="{{ $resolvedImage }}"
        alt="{{ $imageAlt ?: $title }}"
        class="service-image service-entry__image h-64 w-full md:h-72 lg:h-80"
        loading="lazy"
        decoding="async"
      />

      @if ($hasCue)
        <div class="service-cue-card">
          <p class="service-cue-card__label">{{ $cueLabel }}</p>

          <div class="service-cue service-cue--{{ $cueStyle }}">
            @foreach ($cueItems as $value)
              @php $normalizedValue = max(0, min(100, (int) $value)); @endphp

              @if ($cueStyle === 'bars')
                <span class="service-cue__bar">
                  <span style="width: {{ max(14, $normalizedValue) }}%"></span>
                </span>
              @elseif ($cueStyle === 'dots')
                <span class="service-cue__dot {{ $normalizedValue > 0 ? 'is-active' : '' }}"></span>
              @else
                <span
                  class="service-cue__bubble"
                  style="--cue-size: {{ max(1.8, min(3.2, 1.45 + ($normalizedValue / 42))) }}rem;"
                >
                  {{ $normalizedValue }}
                </span>
              @endif
            @endforeach
          </div>
        </div>
      @endif
    </div>
  </div>
</x-ui.entity-card>
