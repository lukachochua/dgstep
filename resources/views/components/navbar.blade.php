{{-- resources/views/components/nav.blade.php --}}
@php
  $current = app()->getLocale();
  $targetLocale = $current === 'ka' ? 'en' : 'ka';
  $routes = ['home', 'services', 'about'];
@endphp

<div
  x-data="{
    /* ---------- State ---------- */
    open: false,
    theme: (() => {
      try {
        const stored = localStorage.getItem('dg:theme');
        const attr = document.documentElement.getAttribute('data-theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        return stored || attr || (prefersDark ? 'dark' : 'light');
      } catch (_) {
        return document.documentElement.getAttribute('data-theme') || 'light';
      }
    })(),

    /* Visibility / animation */
    isVisible: true,
    isHiding: false,
    transitionsEnabled: false,
    ready: false,
    mounted: false,
    userScrollIntent: false,

    /* Scroll context */
    scroller: null,
    lastY: 0,
    lastTS: 0,
    lastRevealY: 0,

    /* Behavior knobs */
    topSnap: 2,
    hideTolerance: 16,
    minHideVelocity: 0.05,
    hideOffsetDesktop: 240,
    hideOffsetMobile: 320,
    hideOffset: 240,

    /* ---------- Utils ---------- */
    toggleTheme(){
      this.theme = (this.theme === 'dark') ? 'light' : 'dark';
      document.documentElement.setAttribute('data-theme', this.theme);
      try { localStorage.setItem('dg:theme', this.theme); } catch (_) {}
    },
    getScroller(){
      const wrapper = document.querySelector('.page-wrapper');
      if (!wrapper) return window;

      try {
        const overflowY = window.getComputedStyle(wrapper).overflowY;
        const isScrollable = overflowY === 'auto' || overflowY === 'scroll';
        return isScrollable ? wrapper : window;
      } catch (_) {
        return window;
      }
    },
    getScrollY(){
      const s = this.scroller;
      return (s === window)
        ? (window.pageYOffset || document.documentElement.scrollTop || 0)
        : (s.scrollTop || 0);
    },
    now(){ return (performance && performance.now) ? performance.now() : Date.now(); },

    measureScrollbarGutter(){
      const nav = this.$refs.nav;
      if (!nav) return;

      if (this.scroller === window) {
        nav.style.right = '0px';
        return;
      }

      const s = this.scroller;
      const sbw = s.offsetWidth - s.clientWidth;
      nav.style.right = sbw > 0 ? sbw + 'px' : '0px';
    },
    lockScroll(lock){
      const s = this.scroller;
      if (s === window) {
        document.documentElement.style.overflow = lock ? 'hidden' : '';
        document.body.style.overflow = lock ? 'hidden' : '';
      } else {
        s.style.overflowY = lock ? 'hidden' : 'auto';
      }
    },
    resolveHideOffset(){
      this.hideOffset = window.matchMedia('(max-width: 767.98px)').matches
        ? this.hideOffsetMobile
        : this.hideOffsetDesktop;
    },

    /* ---------- Visibility rules ---------- */
    applyVisibility(nextY, ts){
      if (this.open) { this.isHiding = false; this.isVisible = true; return; }

      if (!this.userScrollIntent) {
        this.isHiding = false;
        this.isVisible = true;
        this.lastRevealY = nextY;
        return;
      }

      if (nextY <= this.topSnap) {
        this.isHiding = false;
        this.isVisible = true;
        this.lastRevealY = nextY;
        return;
      }

      const dy = nextY - this.lastY;
      const dt = Math.max((ts - this.lastTS), 1);
      const v  = dy / dt;

      const goingDown = dy > this.hideTolerance && v > this.minHideVelocity;
      const goingUp   = dy < -this.hideTolerance;
      const farEnough = (nextY - this.lastRevealY) >= this.hideOffset;

      if (goingDown && farEnough) {
        this.isHiding = true;
        this.isVisible = false;
      } else if (goingUp) {
        // remain hidden while going up; only snap back at very top
      }
    },

    /* ---------- Init ---------- */
    setup(){
      // Set theme immediately on document to prevent flicker
      document.documentElement.setAttribute('data-theme', this.theme);

      this.scroller = this.getScroller();
      this.resolveHideOffset();

      const y  = this.getScrollY();
      const ts = this.now();
      this.lastY = y;
      this.lastTS = ts;
      this.lastRevealY = y;
      this.applyVisibility(y, ts);

      // Mark as mounted first
      this.mounted = true;

      // Measure scrollbar after mount
      this.$nextTick(() => {
        this.measureScrollbarGutter();

        // Enable transitions after everything is rendered
        requestAnimationFrame(() => {
          requestAnimationFrame(() => {
            this.transitionsEnabled = true;
            this.ready = true;
          });
        });
      });

      const onScroll = () => {
        if (!this.mounted) return;
        const y2 = this.getScrollY();
        const t2 = this.now();
        this.applyVisibility(y2, t2);
        this.lastY = y2; this.lastTS = t2;
      };

      const onResize = () => {
        if (!this.mounted) return;
        this.resolveHideOffset();
        this.measureScrollbarGutter();
        const y2 = this.getScrollY();
        const t2 = this.now();
        this.applyVisibility(y2, t2);
        this.lastY = y2; this.lastTS = t2;
      };

      const scrollerEl = (this.scroller === window) ? window : this.scroller;

      const onKeyDown = (evt) => {
        if (this.userScrollIntent) return;
        const keys = ['ArrowUp', 'ArrowDown', 'PageUp', 'PageDown', 'Home', 'End', ' '];
        if (keys.includes(evt.key)) markUserScroll();
      };

      const markUserScroll = () => {
        if (this.userScrollIntent) return;
        this.userScrollIntent = true;
        scrollerEl.removeEventListener('wheel', markUserScroll);
        window.removeEventListener('wheel', markUserScroll);
        window.removeEventListener('touchstart', markUserScroll);
        window.removeEventListener('touchmove', markUserScroll);
        window.removeEventListener('keydown', onKeyDown);
      };

      scrollerEl.addEventListener('scroll', onScroll, { passive: true });
      if (scrollerEl !== window) {
        scrollerEl.addEventListener('wheel', markUserScroll, { passive: true });
      }

      window.addEventListener('wheel', markUserScroll, { passive: true });
      window.addEventListener('touchstart', markUserScroll, { passive: true });
      window.addEventListener('touchmove', markUserScroll, { passive: true });
      window.addEventListener('keydown', onKeyDown, { passive: true });
      window.addEventListener('resize', onResize, { passive: true });

      this.$watch('open', (v) => {
        this.lockScroll(v);
        if (v) {
          this.isHiding = false;
          this.isVisible = true;
          this.lastRevealY = this.getScrollY();
        }
        this.$nextTick(() => this.measureScrollbarGutter());
      });
    }
  }"
  x-init="setup()"
  @keydown.window.escape="open = false"
>
  <!-- NAVBAR -->
  <nav
    x-ref="nav"
    id="site-nav"
    aria-label="Main Navigation"
    :data-ready="ready"
    class="fixed top-0 left-0 z-50
           px-4 sm:px-6 md:px-8
           flex items-center justify-between
           border-b shadow-sm"
    :class="{
      'nav-backdrop-blur': mounted && transitionsEnabled,
      'nav-no-transitions': !transitionsEnabled
    }"
    style="
      height: var(--nav-top-h);
      right: 0;
      will-change: transform, opacity;
      backface-visibility: hidden;
      -webkit-font-smoothing: antialiased;
      transform: translate3d(0,0,0);
      background-clip: padding-box;
    "
    :style="{
      transform: isVisible ? 'translate3d(0,0,0)' : 'translate3d(0,-200%,0)',
      opacity: isVisible ? 1 : 0,
      transitionProperty: transitionsEnabled ? 'transform, opacity, box-shadow, border-color, background-color' : 'none',
      transitionDuration: transitionsEnabled ? (isHiding ? '820ms' : '220ms') : '0ms',
      transitionTimingFunction: 'cubic-bezier(.16,1,.3,1)',
      background: mounted ? (
        (theme === 'dark')
          ? 'rgba(24,24,27,0.60)'
          : 'color-mix(in oklab, var(--nav-bottom-bg, #726EDB) 85%, transparent)'
      ) : 'transparent',
      borderColor: mounted ? (
        (theme === 'dark') ? 'rgba(255,255,255,0.12)' : 'rgba(255,255,255,0.12)'
      ) : 'transparent',
      boxShadow: mounted ? '0 6px 20px rgba(0,0,0,.22)' : 'none',
      color: (theme === 'dark') ? '#f3f2ff' : '#ffffff'
    }"
  >
    <div class="mx-auto w-full max-w-[var(--container-content)] flex items-center justify-between">

  <!-- Left group: Logo + Primary links inline -->
  <div class="flex items-center gap-4 md:gap-6">
    <!-- Logo (hover swap) -->
    <a href="{{ route('home') }}" aria-label="DGstep logo"
      class="group logo-swap flex items-center gap-2 select-none transition-transform duration-200 ease-[var(--ease-brand)] active:scale-95 focus-visible:outline-none">
      <img
          src="{{ Vite::asset('resources/images/brand/logo-white-01.png') }}"
          alt="DGstep logo light"
          class="logo-img--light h-6 md:h-7 w-auto select-none pointer-events-none"
          width="160" height="40" fetchpriority="high" decoding="async" />
      <img
          src="{{ Vite::asset('resources/images/brand/logo-color-01.png') }}"
          alt="DGstep logo dark"
          class="logo-img--dark h-6 md:h-7 w-auto select-none pointer-events-none"
          width="160" height="40" decoding="async" />
    </a>

    <!-- Primary links (desktop) -->
    <ul class="hidden md:flex items-center gap-2 md:gap-3 text-[13px] md:text-[15px]">
      @foreach ($routes as $routeName)
        <li class="relative">
          <x-nav.anchor-button :route="$routeName" label="{{ __('messages.' . $routeName) }}" variant="desktop" />
        </li>
      @endforeach
    </ul>
  </div>

      <!-- Right: actions -->
      <div class="flex items-center gap-1.5 md:gap-2">
        <!-- Mobile hamburger -->
        <button
          class="md:hidden inline-flex items-center justify-center h-9 w-9 rounded-full focus-ring hover:shadow-sm transition"
          :aria-expanded="open.toString()" aria-controls="mobile-menu" aria-label="Toggle navigation menu"
          @click="open = !open"
        >
          <svg x-show="!open" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
               viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
          <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
               viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path d="M6 6l12 12M6 18L18 6"/>
          </svg>
        </button>

        <!-- Language (desktop) -->
        <button
          type="button"
          aria-label="Switch language to {{ strtoupper($targetLocale) }}"
          class="nav-icon-btn hidden md:inline-flex items-center justify-center h-9 w-9 rounded-full focus-ring hover:shadow-sm transition"
          onclick="document.getElementById('locale-toggle-inline').submit(); return false;"
        >
          <span class="flag-emoji text-lg" aria-hidden="true">
            @if($targetLocale === 'ka') 🇬🇪 @else 🇬🇧 @endif
          </span>
          <span class="sr-only">
            {{ $targetLocale === 'ka' ? 'Switch to Georgian' : 'Switch to English' }}
          </span>
        </button>
        <form id="locale-toggle-inline" action="{{ route('locale.switch') }}" method="POST" class="hidden">
          @csrf
          <input type="hidden" name="locale" value="{{ $targetLocale }}">
        </form>

        <!-- Theme toggle -->
        <button
          type="button"
          class="nav-icon-btn relative inline-flex items-center justify-center h-9 w-9 rounded-full focus-ring hover:shadow-sm transition"
          :aria-label="`Switch to ${theme === 'dark' ? 'light' : 'dark'} mode`"
          role="switch"
          :aria-checked="(theme === 'dark').toString()"
          @click="toggleTheme()"
        >
          <!-- Show correct icon per theme -->
          <svg x-show="theme === 'light'" x-cloak class="theme-icon icon--sun absolute inset-0 m-auto h-5 w-5 pointer-events-none transition-transform duration-200"
               viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="4"/>
            <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>
          </svg>
          <svg x-show="theme === 'dark'" x-cloak class="theme-icon icon--moon absolute inset-0 m-auto h-5 w-5 pointer-events-none transition-transform duration-200"
               viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
          </svg>
        </button>
      </div>
    </div>
  </nav>

  <!-- MOBILE OVERLAY -->
  <div
    x-show="open" x-cloak
    class="fixed inset-0 z-40 bg-black/40"
    @click="open = false"
    x-transition.opacity
  ></div>

  <!-- MOBILE MENU PANEL -->
  <div
    id="mobile-menu"
    x-show="open" x-cloak
    class="md:hidden fixed z-50 inset-x-0"
    :style="{ top: 'var(--nav-top-h)' }"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 -translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-2"
  >
    <div class="mx-auto max-w-[var(--container-content)] px-4 sm:px-6 md:px-8 py-4
                nav-mobile-surface rounded-b-xl space-y-4 shadow-lg">
      <!-- Links -->
      <div class="grid gap-3">
        @foreach ($routes as $routeName)
          <x-nav.anchor-button :route="$routeName" label="{{ __('messages.' . $routeName) }}" variant="mobile" />
        @endforeach
      </div>

      <div class="flex justify-center items-center gap-3 pt-1">
        <!-- Language (mobile) -->
        <button
          type="button"
          aria-label="Switch language to {{ strtoupper($targetLocale) }}"
          class="nav-icon-btn inline-flex items-center justify-center h-10 w-10 p-0 rounded-full cursor-pointer select-none focus-ring hover:shadow-md transition"
          onclick="document.getElementById('locale-toggle-inline').submit(); return false;"
        >
          <span class="flag-emoji" aria-hidden="true">
            @if($targetLocale === 'ka') 🇬🇪 @else 🇬🇧 @endif
          </span>
          <span class="sr-only">
            {{ ($targetLocale === 'ka') ? 'Switch to Georgian' : 'Switch to English' }}
          </span>
        </button>

        <!-- Theme (mobile) -->
        <button
          type="button"
          class="nav-icon-btn relative inline-flex items-center justify-center h-10 w-10 p-0 rounded-full focus-ring hover:shadow-md transition-all duration-200"
          :aria-label="`Switch to ${theme === 'dark' ? 'light' : 'dark'} mode`"
          role="switch"
          :aria-checked="(theme === 'dark').toString()"
          @click="toggleTheme()"
        >
          <svg x-show="theme === 'light'" x-cloak class="theme-icon icon--sun absolute inset-0 m-auto h-6 w-6 pointer-events-none"
               viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"
               stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 3v2.25M18.364 5.636l-1.591 1.591M21 12h-2.25M18.364 18.364l-1.591-1.591M12 18.75V21M6.227 18.773l1.591-1.591M3 12h2.25M6.227 5.227l1.591 1.591M12 8.25a3.75 3.75 0 100 7.5 3.75 3.75 0 000-7.5z"/>
          </svg>
          <svg x-show="theme === 'dark'" x-cloak class="theme-icon icon--moon absolute inset-0 m-auto h-6 w-6 pointer-events-none"
               viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"
               stroke-linecap="round" stroke-linejoin="round">
            <path d="M21.752 15.002A9 9 0 1112.998 2.248 7.5 7.5 0 0021.752 15z"/>
          </svg>
        </button>
      </div>
    </div>
  </div>
</div>
