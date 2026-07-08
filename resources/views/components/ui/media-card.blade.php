@props([
  'title' => '',
  'description' => '',
  'image' => null,
  'fallbackImage' => null,
  'imageAlt' => '',
  'variant' => 'feature',
  'as' => 'article',
])

@php
  $imageClass = $variant === 'project'
    ? 'project-image mb-4 h-44 w-full'
    : 'feature-image w-full';
@endphp

<x-ui.entity-card :as="$as" :variant="$variant" {{ $attributes }}>
  @if (filled($image))
    <img
      src="{{ $image }}"
      alt="{{ $imageAlt }}"
      @if (filled($fallbackImage))
        data-fallback-src="{{ $fallbackImage }}"
        onerror="this.onerror=null;this.src=this.dataset.fallbackSrc"
      @endif
      class="{{ $imageClass }}"
      width="1200"
      height="704"
      loading="lazy"
      decoding="async"
    />
  @endif

  <div class="{{ $variant === 'project' ? 'projects-card-copy' : ($variant === 'feature' ? 'feature-card__copy-shell' : '') }}">
    <div class="{{ $variant === 'feature' ? 'feature-card__copy-inner' : '' }}">
      <h3 class="{{ $variant === 'feature' ? 'feature-card__title' : 'media-card__title' }}">{{ $title }}</h3>
      <p class="{{ $variant === 'feature' ? 'feature-card__description' : 'media-card__description line-clamp-4' }}">{{ $description }}</p>
      {{ $slot }}
    </div>
  </div>
</x-ui.entity-card>
