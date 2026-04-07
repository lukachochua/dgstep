@props([
  'as' => 'article',
  'variant' => 'feature',
])

@php
  $tag = in_array($as, ['div', 'article', 'section', 'aside', 'button', 'a'], true) ? $as : 'article';

  $variantClasses = match ($variant) {
      'service' => ['clipped-card', 'service-card'],
      'team' => ['clipped-card', 'team-card'],
      'project' => ['clipped-card', 'project-card'],
      'legal' => ['clipped-card', 'legal-card'],
      'auth' => ['clipped-card', 'auth-card'],
      default => ['clipped-card', 'feature-card'],
  };

  $attributesBag = $attributes->class($variantClasses);

  if ($tag === 'button' && ! $attributes->has('type')) {
      $attributesBag = $attributesBag->merge(['type' => 'button']);
  }
@endphp

<{{ $tag }} {{ $attributesBag }}>
  {{ $slot }}
</{{ $tag }}>
