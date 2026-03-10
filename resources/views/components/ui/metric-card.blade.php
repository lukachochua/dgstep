@props([
  'as' => 'article',
])

@php
  $tag = in_array($as, ['div', 'article', 'section'], true) ? $as : 'article';
@endphp

<{{ $tag }} {{ $attributes->class(['metric-card']) }}>
  {{ $slot }}
</{{ $tag }}>
