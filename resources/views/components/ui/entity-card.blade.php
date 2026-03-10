@props([
  'as' => 'article',
  'variant' => 'feature',
])

@php
  $tag = in_array($as, ['div', 'article', 'section', 'aside', 'button'], true) ? $as : 'article';

  $variantClasses = match ($variant) {
      'service' => ['service-card'],
      'team' => ['team-card'],
      'project' => ['project-card'],
      'legal' => ['legal-card'],
      'auth' => ['auth-card'],
      default => ['feature-card'],
  };

  $attributesBag = $attributes->class($variantClasses);

  if ($tag === 'button' && ! $attributes->has('type')) {
      $attributesBag = $attributesBag->merge(['type' => 'button']);
  }
@endphp

<{{ $tag }} {{ $attributesBag }}>
  {{ $slot }}
</{{ $tag }}>
