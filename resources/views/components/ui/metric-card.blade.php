@props([
  'as' => 'article',
])

@php
  $tag = in_array($as, ['div', 'article', 'section'], true) ? $as : 'article';
@endphp

<{{ $tag }} {{ $attributes->class(['clipped-card', 'metric-card']) }}>
  {{ $slot }}
</{{ $tag }}>
