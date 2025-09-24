@props([
  'href'    => null,          // e.g. 'https://example.com'
  'route'   => null,          // e.g. 'contact'
  'variant' => 'primary',     // 'primary' | 'secondary' | 'ghost' (extend as needed)
  'size'    => 'md',          // 'sm' | 'md' | 'lg' (maps to your existing .btn-* sizes)
  'as'      => 'a',           // 'a' | 'button'
  'disabled'=> false,
])

@php
  // If user passes :href via Alpine (dynamic), don't emit a static href attr
  $hasDynamicHref = $attributes->has(':href');

  // Pick tag (anchor by default; button if explicitly requested)
  $tag = $as === 'button' ? 'button' : 'a';

  // Compose class list to reuse your existing .btn classes
  $classes = trim("btn btn-{$size} btn-{$variant}");

  // Disabled state
  $disabledAttrs = $disabled ? [
    'aria-disabled' => 'true',
    'tabindex' => '-1',
    'class' => 'pointer-events-none opacity-60',
  ] : [];
@endphp

@if ($tag === 'a')
  <a
    {{ $attributes->merge(['class' => $classes])->class($disabledAttrs['class'] ?? '') }}
    @unless($hasDynamicHref)
      href="{{ $href ?? ($route ? route($route) : '#') }}"
    @endunless
    @if($disabled) aria-disabled="true" tabindex="-1" @endif
  >
    {{ $slot }}
  </a>
@else
  <button
    {{ $attributes->merge(['class' => $classes])->class($disabledAttrs['class'] ?? '') }}
    @if($disabled) disabled aria-disabled="true" @endif
    type="{{ $attributes->get('type', 'button') }}"
  >
    {{ $slot }}
  </button>
@endif
