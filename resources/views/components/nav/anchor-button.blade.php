@props(['route', 'label', 'variant' => 'desktop'])

@php
    $cfg = config("nav.variants.{$variant}");
    $isActive = request()->routeIs($route);

    if (in_array($variant, ['desktop', 'mobile'])) {
        $stateKey = $isActive ? 'active' : 'inactive';
    } elseif ($variant === 'auth') {
        $stateKey = $isActive ? 'active' : ($route === 'login' ? 'inactive-login' : 'inactive-register');
    } else {
        // auth-mobile
        $stateKey = $isActive ? 'active' : ($route === 'login' ? 'inactive-login' : 'inactive-register');
    }

    $base  = $cfg['base'] ?? '';
    $state = $cfg[$stateKey] ?? '';
@endphp

<a href="{{ route($route) }}" class="{{ $base }} {{ $state }}">
    {{ $label }}
</a>
