@props([
  'as' => 'div',
  'variant' => 'default',
])

@php
  $tag = in_array($as, ['div', 'section', 'article', 'aside', 'figure', 'button'], true) ? $as : 'div';

  $variantClasses = match ($variant) {
      'soft' => ['clipped-card', 'panel-soft'],
      'hero' => ['clipped-card', 'panel'],
      'hero-detail' => ['clipped-card', 'hero-detail-card'],
      default => ['clipped-card', 'panel'],
  };

  $attributesBag = $attributes->class($variantClasses);

  if ($tag === 'button' && ! $attributes->has('type')) {
      $attributesBag = $attributesBag->merge(['type' => 'button']);
  }
@endphp

<{{ $tag }} {{ $attributesBag }}>
  {{ $slot }}
</{{ $tag }}>
