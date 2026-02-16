@props([
  'href' => null,
  'route' => null,
  'variant' => 'primary',
  'size' => 'md',
  'as' => 'a',
  'disabled' => false,
])

@php
  $tag = $as === 'button' ? 'button' : 'a';
  $classes = trim('btn btn-' . $size . ' btn-' . $variant);
  $resolvedHref = $href ?? ($route ? route($route) : '#');
@endphp

@if ($tag === 'button')
  <button
    type="{{ $attributes->get('type', 'button') }}"
    {{ $attributes->merge(['class' => $classes]) }}
    @if($disabled) disabled aria-disabled="true" @endif
  >
    {{ $slot }}
  </button>
@else
  <a
    href="{{ $resolvedHref }}"
    {{ $attributes->merge(['class' => $classes]) }}
    @if($disabled) aria-disabled="true" tabindex="-1" @endif
  >
    {{ $slot }}
  </a>
@endif
