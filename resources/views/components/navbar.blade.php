@php
  $current = app()->getLocale();
  $targetLocale = $current === 'ka' ? 'en' : 'ka';
  $targetLocaleFlag = $targetLocale === 'ka' ? '🇬🇪' : '🇬🇧';
  $targetLocaleSr = $targetLocale === 'ka' ? 'Switch language to Georgian' : 'Switch language to English';

  $navLinks = [
    ['route' => 'home', 'label' => __('messages.home'), 'icon' => 'home'],
    ['route' => 'services', 'label' => __('messages.services'), 'icon' => 'layers'],
    ['route' => 'about', 'label' => __('messages.about'), 'icon' => 'nodes'],
    // ['route' => 'projects', 'label' => __('messages.projects'), 'icon' => 'grid'],
    ['route' => 'contact', 'label' => __('messages.contact'), 'icon' => 'mail'],
  ];
@endphp

@once
  @php
    $renderNavIcon = static function (string $icon): string {
        return match ($icon) {
            'home' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 10.8 12 4l9 6.8" /><path d="M6.5 9.8V20h11V9.8" /></svg>',
            'layers' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m12 4 8 4.5-8 4.5-8-4.5L12 4Z" /><path d="m4 12.5 8 4.5 8-4.5" /><path d="m4 16.5 8 4.5 8-4.5" /></svg>',
            'nodes' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="6" cy="6" r="2.2" /><circle cx="18" cy="6" r="2.2" /><circle cx="12" cy="18" r="2.2" /><path d="M8 7.4 10.7 15M16 7.4 13.3 15M8.2 6h7.6" /></svg>',
            'grid' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="4" y="4" width="6.5" height="6.5" rx="1.2" /><rect x="13.5" y="4" width="6.5" height="6.5" rx="1.2" /><rect x="4" y="13.5" width="6.5" height="6.5" rx="1.2" /><rect x="13.5" y="13.5" width="6.5" height="6.5" rx="1.2" /></svg>',
            'mail' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3.5" y="5.5" width="17" height="13" rx="2" /><path d="m5.5 8 6.5 5 6.5-5" /></svg>',
            default => '',
        };
    };
  @endphp
@endonce

<div
  class="site-nav"
  data-fonts-ready="false"
  x-data="siteNav()"
  x-bind:data-fonts-ready="fontsReady ? 'true' : 'false'"
  @keydown.window.escape="closeMenu()"
>
  <header class="nav-shell" :class="{ 'nav-shell--scrolled': desktopScrolled }">
    <div class="nav-inner">
      <a href="{{ route('home') }}" class="nav-logo" aria-label="DGstep home">
        <img
          src="{{ Vite::asset('resources/images/brand/logo-color-01.png') }}"
          alt="DGstep"
          width="160"
          height="40"
          loading="eager"
          fetchpriority="high"
          decoding="async"
        />
      </a>

      <nav class="nav-links" aria-label="Primary">
        @foreach ($navLinks as $link)
          @php $isActive = request()->routeIs($link['route']); @endphp
          <a
            href="{{ route($link['route']) }}"
            class="nav-link {{ $isActive ? 'nav-link-active' : '' }}"
            @if($isActive) aria-current="page" @endif
          >
            <span class="nav-link__icon">{!! $renderNavIcon($link['icon']) !!}</span>
            <span class="nav-link__label">{{ $link['label'] }}</span>
          </a>
        @endforeach
      </nav>

      <div class="nav-actions">
        <x-ui.icon-button
          type="button"
          @click="toggleTheme()"
          ::aria-label="theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'"
        >
          <svg x-show="theme === 'light'" x-cloak class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <circle cx="12" cy="12" r="4" />
            <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41" />
          </svg>
          <svg x-show="theme === 'dark'" x-cloak class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path d="M21 12.8A9 9 0 1 1 11.2 3a7.2 7.2 0 0 0 9.8 9.8z" />
          </svg>
        </x-ui.icon-button>

        <x-ui.icon-button
          type="button"
          class="desktop-only"
          @click="submitLocaleSwitch()"
          aria-label="{{ $targetLocaleSr }}"
        >
          <span class="text-base leading-none" aria-hidden="true">{{ $targetLocaleFlag }}</span>
          <span class="sr-only">{{ $targetLocaleSr }}</span>
        </x-ui.icon-button>

        <x-ui.icon-button type="button" class="mobile-only" @click="toggleMenu()" ::aria-expanded="open.toString()" aria-controls="mobile-nav">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path x-show="!open" x-cloak d="M4 6h16M4 12h16M4 18h16" />
            <path x-show="open" x-cloak d="M6 6l12 12M18 6 6 18" />
          </svg>
        </x-ui.icon-button>
      </div>
    </div>
  </header>

  <form id="locale-switch-form" action="{{ route('locale.switch') }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="locale" value="{{ $targetLocale }}">
  </form>

  <div
    x-show="open"
    x-cloak
    class="mobile-nav"
    id="mobile-nav"
    @click.outside="closeMenu()"
    x-transition:enter="transition ease-out duration-180"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-140"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
  >
    <div
      class="mobile-nav-panel"
      x-transition:enter="transition ease-out duration-220"
      x-transition:enter-start="opacity-0 -translate-y-2"
      x-transition:enter-end="opacity-100 translate-y-0"
      x-transition:leave="transition ease-in duration-160"
      x-transition:leave-start="opacity-100 translate-y-0"
      x-transition:leave-end="opacity-0 -translate-y-1"
    >
      <div class="mobile-nav-panel-inner">
        <div class="mobile-nav-list">
          @foreach ($navLinks as $link)
            @php $isActive = request()->routeIs($link['route']); @endphp
            <a
              href="{{ route($link['route']) }}"
              class="mobile-nav-link {{ $isActive ? 'is-active' : '' }}"
              @if($isActive) aria-current="page" @endif
              @click="closeMenu()"
            >
              <span class="nav-link__icon">{!! $renderNavIcon($link['icon']) !!}</span>
              <span class="nav-link__label">{{ $link['label'] }}</span>
            </a>
          @endforeach
        </div>

        <div class="mobile-nav-actions">
          <x-ui.icon-button
            type="button"
            @click="submitLocaleSwitch()"
            aria-label="{{ $targetLocaleSr }}"
          >
            <span class="text-base leading-none" aria-hidden="true">{{ $targetLocaleFlag }}</span>
            <span class="sr-only">{{ $targetLocaleSr }}</span>
          </x-ui.icon-button>
        </div>
      </div>
    </div>
  </div>
</div>
