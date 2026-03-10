@props([
  'href' => null,
  'route' => null,
  'as' => 'button',
  'disabled' => false,
])

@php
  $tag = $as === 'a' ? 'a' : 'button';
  $classes = 'nav-icon-btn';
  $resolvedHref = $href ?? ($route ? route($route) : '#');
@endphp

@if ($tag === 'a')
  <a
    href="{{ $resolvedHref }}"
    {{ $attributes->merge(['class' => $classes]) }}
    @if($disabled) aria-disabled="true" tabindex="-1" @endif
  >
    {{ $slot }}
  </a>
@else
  <button
    type="{{ $attributes->get('type', 'button') }}"
    {{ $attributes->merge(['class' => $classes]) }}
    @if($disabled) disabled aria-disabled="true" @endif
  >
    {{ $slot }}
  </button>
@endif
