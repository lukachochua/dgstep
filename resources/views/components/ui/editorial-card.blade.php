@props([
  'label' => null,
  'title' => '',
  'body' => '',
  'tone' => null,
  'as' => 'article',
])

@php
  $toneClass = filled($tone) ? "editorial-card editorial-card--{$tone}" : 'editorial-card';
@endphp

<x-ui.surface-card :as="$as" {{ $attributes->class([$toneClass]) }}>
  <span class="editorial-card__accent" aria-hidden="true"></span>
  @if (filled($label))
    <span class="editorial-card__label">{{ $label }}</span>
  @endif
  <h2 class="editorial-card__title {{ filled($label) ? 'mt-4' : '' }}">{{ $title }}</h2>
  <p class="editorial-card__body mt-3">{{ $body }}</p>
  {{ $slot }}
</x-ui.surface-card>
