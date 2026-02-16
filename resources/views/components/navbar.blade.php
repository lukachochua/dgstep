@php
  $current = app()->getLocale();
  $targetLocale = $current === 'ka' ? 'en' : 'ka';
  $targetLocaleFlag = $targetLocale === 'ka' ? '🇬🇪' : '🇬🇧';
  $targetLocaleSr = $targetLocale === 'ka' ? 'Switch language to Georgian' : 'Switch language to English';

  $navLinks = [
    ['route' => 'home', 'label' => __('messages.home')],
    ['route' => 'services', 'label' => __('messages.services')],
    ['route' => 'about', 'label' => __('messages.about')],
    ['route' => 'projects', 'label' => __('messages.projects')],
    ['route' => 'contact', 'label' => __('messages.contact')],
  ];
@endphp

<div
  x-data="{
    open: false,
    theme: 'light',
    init() {
      const attr = document.documentElement.getAttribute('data-theme');
      this.theme = (attr === 'dark' || attr === 'light') ? attr : 'light';
    },
    toggleTheme() {
      this.theme = this.theme === 'dark' ? 'light' : 'dark';
      document.documentElement.setAttribute('data-theme', this.theme);
      try { localStorage.setItem('dg:theme', this.theme); } catch (_) {}
    },
    closeMenu() {
      this.open = false;
    }
  }"
  x-init="init()"
  @keydown.window.escape="closeMenu()"
>
  <header class="nav-shell">
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
            {{ $link['label'] }}
          </a>
        @endforeach
      </nav>

      <div class="nav-actions">
        <button
          type="button"
          class="nav-icon-btn"
          @click="toggleTheme()"
          :aria-label="theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'"
        >
          <svg x-show="theme === 'light'" x-cloak class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <circle cx="12" cy="12" r="4" />
            <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41" />
          </svg>
          <svg x-show="theme === 'dark'" x-cloak class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path d="M21 12.8A9 9 0 1 1 11.2 3a7.2 7.2 0 0 0 9.8 9.8z" />
          </svg>
        </button>

        <button
          type="button"
          class="nav-icon-btn desktop-only"
          onclick="document.getElementById('locale-switch-form').submit(); return false;"
          aria-label="{{ $targetLocaleSr }}"
        >
          <span class="text-base leading-none" aria-hidden="true">{{ $targetLocaleFlag }}</span>
          <span class="sr-only">{{ $targetLocaleSr }}</span>
        </button>

        <a href="{{ route('contact') }}" class="btn btn-md btn-primary desktop-only">
          {{ __('contact.cta_button') }}
        </a>

        <button type="button" class="nav-icon-btn mobile-only" @click="open = !open" :aria-expanded="open.toString()" aria-controls="mobile-nav">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path x-show="!open" x-cloak d="M4 6h16M4 12h16M4 18h16" />
            <path x-show="open" x-cloak d="M6 6l12 12M18 6 6 18" />
          </svg>
        </button>
      </div>
    </div>
  </header>

  <form id="locale-switch-form" action="{{ route('locale.switch') }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="locale" value="{{ $targetLocale }}">
  </form>

  <div x-show="open" x-cloak class="mobile-nav" id="mobile-nav" @click.outside="closeMenu()">
    <div class="mobile-nav-panel space-y-2">
      @foreach ($navLinks as $link)
        @php $isActive = request()->routeIs($link['route']); @endphp
        <a href="{{ route($link['route']) }}" @if($isActive) aria-current="page" @endif @click="closeMenu()">
          {{ $link['label'] }}
        </a>
      @endforeach

      <div class="pt-2 flex items-center gap-2">
        <button
          type="button"
          class="btn btn-sm btn-ghost"
          onclick="document.getElementById('locale-switch-form').submit(); return false;"
          aria-label="{{ $targetLocaleSr }}"
        >
          <span class="text-base leading-none" aria-hidden="true">{{ $targetLocaleFlag }}</span>
          <span class="sr-only">{{ $targetLocaleSr }}</span>
        </button>

        <a href="{{ route('contact') }}" class="btn btn-sm btn-primary flex-1 text-center" @click="closeMenu()">
          {{ __('contact.cta_button') }}
        </a>
      </div>
    </div>
  </div>
</div>
