@props([
    'route', // Laravel route name
    'label', // Button text
    'variant' => 'desktop', // desktop | mobile | auth | auth-mobile
])

<a href="{{ route($route) }}" @class([
    // ─── Common ───
    'rounded-[3px] transition-colors duration-300' => true,
    'group' => $variant === 'desktop',
    // ─── Desktop Nav ───
    'relative z-10 px-3 py-2 shadow-[0_0_4px_var(--color-electric-sky)]' =>
        $variant === 'desktop',
    'bg-[var(--color-electric-sky)] text-black border border-[var(--color-electric-sky)] group-hover:shadow-[0_0_8px_var(--color-electric-sky-hover)]' =>
        $variant === 'desktop' && request()->routeIs($route),
    'bg-transparent text-white border border-transparent hover:border-[var(--color-electric-sky)] hover:bg-white/5 hover:text-[var(--color-electric-sky)]' =>
        $variant === 'desktop' && !request()->routeIs($route),

    // ─── Mobile Nav ───
    'block max-w-xs mx-auto px-4 py-2 rounded-md border shadow-[0_0_4px_var(--color-electric-sky)]' =>
        $variant === 'mobile',
    'bg-[var(--color-electric-sky)] text-black border-[var(--color-electric-sky)] hover:shadow-[0_0_8px_var(--color-electric-sky-hover)]' =>
        $variant === 'mobile' && request()->routeIs($route),
    'bg-white/5 text-white border-transparent hover:bg-white/10' =>
        $variant === 'mobile' && !request()->routeIs($route),

    // ─── Desktop Auth ───
    'px-3 py-2 border' => $variant === 'auth',
    'bg-[var(--color-electric-sky)] text-black border-[var(--color-electric-sky)] shadow-[0_0_4px_var(--color-electric-sky)]' =>
        $variant === 'auth' && request()->routeIs($route),
    'text-white border-white hover:bg-[var(--color-electric-sky)] hover:text-black hover:border-transparent' =>
        $variant === 'auth' &&
        $route === 'login' &&
        !request()->routeIs($route),
    'text-[var(--color-electric-sky)] border-[var(--color-electric-sky)] hover:bg-[var(--color-electric-sky)] hover:text-black hover:border-transparent' =>
        $variant === 'auth' &&
        $route === 'register' &&
        !request()->routeIs($route),

    // ─── Mobile Auth ───
    'w-full max-w-xs px-4 py-2 border rounded-md transition' =>
        $variant === 'auth-mobile',
    'bg-[var(--color-electric-sky)] text-black border-[var(--color-electric-sky)]' =>
        $variant === 'auth-mobile' && request()->routeIs($route),
    'text-white border-white hover:bg-[var(--color-electric-sky)] hover:text-black active:bg-[var(--color-electric-sky)] active:text-black' =>
        $variant === 'auth-mobile' &&
        $route === 'login' &&
        !request()->routeIs($route),
    'text-[var(--color-electric-sky)] border-[var(--color-electric-sky)] hover:bg-[var(--color-electric-sky)] hover:text-black active:bg-[var(--color-electric-sky)] active:text-black' =>
        $variant === 'auth-mobile' &&
        $route === 'register' &&
        !request()->routeIs($route),
])>
    {{ $label }}
</a>
