@props([
  'route',
  'label',
  'variant' => 'desktop', // 'desktop' | 'mobile' | 'auth' | 'auth-mobile'
])

@php
    $cfg = config("nav.variants.{$variant}") ?? [];

    $isActive = request()->routeIs($route);

    if (in_array($variant, ['desktop', 'mobile'], true)) {
        $stateKey = $isActive ? 'active' : 'inactive';
    } elseif ($variant === 'auth') {
        $stateKey = $isActive ? 'active' : ($route === 'login' ? 'inactive-login' : 'inactive-register');
    } else {
        // 'auth-mobile'
        $stateKey = $isActive ? 'active' : ($route === 'login' ? 'inactive-login' : 'inactive-register');
    }

    $base  = $cfg['base']  ?? '';
    $state = $cfg[$stateKey] ?? '';

    $classes = trim($base . ' ' . $state);
@endphp

<a
  href="{{ route($route) }}"
  class="{{ $classes }}"
  @if($isActive) aria-current="page" @endif
  data-variant="{{ $variant }}"
  data-active="{{ $isActive ? 'true' : 'false' }}"
  {{ $attributes }}
>
  {{ $label }}
</a>
