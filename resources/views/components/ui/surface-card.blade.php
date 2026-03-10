@props([
  'as' => 'div',
  'variant' => 'default',
])

@php
  $tag = in_array($as, ['div', 'section', 'article', 'aside', 'figure', 'button'], true) ? $as : 'div';

  $variantClasses = match ($variant) {
      'soft' => ['panel-soft'],
      'hero' => ['panel', 'hero-surface-card'],
      'hero-detail' => ['hero-detail-card'],
      default => ['panel'],
  };

  $attributesBag = $attributes->class($variantClasses);

  if ($tag === 'button' && ! $attributes->has('type')) {
      $attributesBag = $attributesBag->merge(['type' => 'button']);
  }
@endphp

<{{ $tag }} {{ $attributesBag }}>
  {{ $slot }}
</{{ $tag }}>
