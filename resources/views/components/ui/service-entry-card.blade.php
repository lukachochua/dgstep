@props([
  'title' => '',
  'description' => '',
  'fullDescription' => '',
  'image' => null,
  'imageAlt' => '',
  'slug' => '',
  'problems' => [],
  'index' => 1,
  'cueLabel' => '',
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
  $readMoreLength = function_exists('mb_strlen') ? mb_strlen($readMoreLabel) : strlen($readMoreLabel);
  $showLessLength = function_exists('mb_strlen') ? mb_strlen($showLessLabel) : strlen($showLessLabel);
  $expandLabelWidth = max(1, $readMoreLength, $showLessLength);
  $detailsId = $slug !== '' ? 'service-details-' . $slug : 'service-details-' . $displayIndex;
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
              <li class="service-problem-pill">
                <span class="service-problem-pill__icon" aria-hidden="true">+</span>
                <span class="service-problem-pill__text">{{ $problem }}</span>
              </li>
            @endforeach
          </ul>
        </div>
      @endif

      @if ($hasFull)
        <div x-data="{ open: false }" class="service-entry__block">
          <div
            id="{{ $detailsId }}"
            class="service-entry__details-shell"
            :class="{ 'is-open': open }"
            :aria-hidden="(!open).toString()"
          >
            <div class="service-entry__details-shell-inner">
              <div class="service-entry__details">
                {!! $fullDescription !!}
              </div>
            </div>
          </div>

          <button
            type="button"
            class="service-expand-btn"
            style="--expand-label-width: {{ $expandLabelWidth }}ch;"
            @click="open = !open"
            :aria-expanded="open.toString()"
            aria-controls="{{ $detailsId }}"
          >
            <span class="service-expand-btn__label-wrap">
              <span class="service-expand-btn__label" x-text="open ? @js($showLessLabel) : @js($readMoreLabel)"></span>
            </span>
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
          </button>
        </div>
      @endif

      <div class="service-entry__actions">
        <x-ui.button route="contact" variant="primary" size="md">
          {{ $ctaLabel }}
        </x-ui.button>
        <a href="#services-top" class="inline-accent-link service-anchor-link">{{ $backToTopLabel }}</a>
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
    </div>
  </div>
</x-ui.entity-card>
