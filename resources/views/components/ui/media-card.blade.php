@props([
  'title' => '',
  'description' => '',
  'image' => null,
  'imageAlt' => '',
  'variant' => 'feature',
  'as' => 'article',
])

<x-ui.entity-card :as="$as" :variant="$variant" {{ $attributes }}>
  @if (filled($image))
    <img
      src="{{ $image }}"
      alt="{{ $imageAlt }}"
      class="{{ $variant === 'project' ? 'project-image' : 'feature-image' }} mb-4 h-44 w-full"
      width="1200"
      height="704"
      loading="lazy"
      decoding="async"
    />
  @endif

  <div class="{{ $variant === 'project' ? 'projects-card-copy' : ($variant === 'feature' ? 'feature-card__copy-shell' : '') }}">
    <div class="{{ $variant === 'feature' ? 'feature-card__copy-inner' : '' }}">
      <h3 class="{{ $variant === 'feature' ? 'feature-card__title' : 'text-xl font-semibold leading-tight' }}">{{ $title }}</h3>
      <p class="{{ $variant === 'feature' ? 'feature-card__description' : 'mt-2 text-sm text-[color:var(--text-muted)] line-clamp-4' }}">{{ $description }}</p>
      {{ $slot }}
    </div>
  </div>
</x-ui.entity-card>
