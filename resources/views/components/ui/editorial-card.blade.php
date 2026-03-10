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
  @if (filled($label))
    <span class="editorial-card__label">{{ $label }}</span>
  @endif
  <h2 class="{{ filled($label) ? 'mt-4' : '' }} text-2xl font-semibold leading-tight">{{ $title }}</h2>
  <p class="mt-3 text-sm leading-6 text-[color:var(--text-muted)] md:text-base">{{ $body }}</p>
  {{ $slot }}
</x-ui.surface-card>
