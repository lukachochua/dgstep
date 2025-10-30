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
    closing: false,
    get menuActive(){ return this.open }, // close is instant
    scrollbarWidth: 0,

    // Guards to prevent flicker on close and on anchor jumps
    suppressHideUntil: 0,
    freezeNavUntil: 0,

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
    transitionsEnabled: true,
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

    computeScrollbarWidth(){
      return Math.max(0, window.innerWidth - document.documentElement.clientWidth);
    },

    /* >>> FIX: Only apply right gutter while menu is open <<< */
    measureScrollbarGutter(){
      const nav = this.$refs.nav;
      if (!nav) return;

      if (this.scroller === window) {
        const current = this.computeScrollbarWidth();
        // Snapshot latest width
        this.scrollbarWidth = current;

        // Apply gutter ONLY when mobile menu is active; otherwise keep flush to right:0
        const width = this.menuActive ? this.scrollbarWidth : 0;
        nav.style.right = width ? width + 'px' : '0px';
        return;
      }

      // Custom scroller case (page wrapper)
      const s = this.scroller;
      const sbw = s.offsetWidth - s.clientWidth;
      nav.style.right = this.menuActive && sbw > 0 ? (sbw + 'px') : '0px';
    },

    resolveHideOffset(){
      this.hideOffset = window.matchMedia('(max-width: 767.98px)').matches
        ? this.hideOffsetMobile
        : this.hideOffsetDesktop;
    },

    freezeNav(ms = 700){
      const t = this.now() + ms;
      this.freezeNavUntil = Math.max(this.freezeNavUntil, t);
      // Keep visible and reset reveal baseline so large jumps don't meet farEnough
      const y = this.getScrollY();
      this.isHiding = false;
      this.isVisible = true;
      this.lastRevealY = y;
    },

    toggleMenu(){
      if (this.open) { this.closeMenu(); return; }
      this.scrollbarWidth = this.computeScrollbarWidth(); // snapshot before body locking
      this.open = true;
      this.$nextTick(() => this.measureScrollbarGutter());
    },
    closeMenu(){
      // Instant close: no closing state, no leave transitions, no waiting
      this.open = false;
      this.closing = false;

      // Prevent scroll-hide logic from running immediately post-close
      this.suppressHideUntil = this.now() + 300;

      // Recompute gutter right away (body unlock) and remove forced right gutter
      this.scrollbarWidth = this.computeScrollbarWidth();
      this.measureScrollbarGutter();

      // Keep navbar visible immediately after close
      this.isHiding = false;
      this.isVisible = true;
    },
    forceClose(){ this.closeMenu(); },

    /* ---------- Visibility rules ---------- */
    applyVisibility(nextY, ts){
      // Lock visible while menu is open
      if (this.menuActive) { this.isHiding = false; this.isVisible = true; return; }

      // Guards after close and during anchor jumps
      if (ts < this.suppressHideUntil || ts < this.freezeNavUntil) {
        this.isHiding = false;
        this.isVisible = true;
        this.lastRevealY = nextY; // keep baseline in sync during freeze
        return;
      }

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
      // Set theme immediately to prevent paint flash
      document.documentElement.setAttribute('data-theme', this.theme);

      this.scroller = this.getScroller();
      this.scrollbarWidth = this.computeScrollbarWidth();
      this.resolveHideOffset();

      const y  = this.getScrollY();
      const ts = this.now();
      this.lastY = y; this.lastTS = ts; this.lastRevealY = y;
      this.applyVisibility(y, ts);

      this.mounted = true;

      this.$nextTick(() => {
        this.measureScrollbarGutter();
        this.transitionsEnabled = true;
        this.ready = true;
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

      // Detect same-page anchor clicks to freeze nav during jump scroll
      const onAnchorClick = (e) => {
        const a = e.target.closest && e.target.closest('a[href]');
        if (!a) return;
        const href = a.getAttribute('href');
        if (!href) return;

        // Same-document hash (#id) OR same-path with hash
        const isHashOnly = href.startsWith('#');
        let isSamePathHash = false;
        if (!isHashOnly) {
          try {
            const url = new URL(href, location.href);
            isSamePathHash = (url.pathname === location.pathname) && !!url.hash;
          } catch (_) {}
        }

        if (isHashOnly || isSamePathHash) {
          this.freezeNav(700);
        }
      };

      document.addEventListener('click', onAnchorClick, true);
      window.addEventListener('hashchange', () => this.freezeNav(700), { passive: true });

      scrollerEl.addEventListener('scroll', onScroll, { passive: true });
      if (scrollerEl !== window) scrollerEl.addEventListener('wheel', markUserScroll, { passive: true });
      window.addEventListener('wheel', markUserScroll, { passive: true });
      window.addEventListener('touchstart', markUserScroll, { passive: true });
      window.addEventListener('touchmove', markUserScroll, { passive: true });
      window.addEventListener('keydown', onKeyDown, { passive: true });
      window.addEventListener('resize', onResize, { passive: true });

      this.$watch('open', (v) => {
        if (v) {
          this.isHiding = false;
          this.isVisible = true;
          this.lastRevealY = this.getScrollY();
        }
        this.$nextTick(() => this.measureScrollbarGutter());
      });
    }
  }"
  x-trap.noscroll="menuActive"
  x-init="setup()"
  @keydown.window.escape.prevent="forceClose()"
  @keydown.window.arrow-up.prevent="closeMenu()"
  @keydown.window.arrow-down.prevent="closeMenu()"
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
      borderColor: mounted ? 'rgba(255,255,255,0.12)' : 'transparent',
      boxShadow: mounted ? '0 6px 20px rgba(0,0,0,.22)' : 'none',
      color: (theme === 'dark') ? '#f3f2ff' : '#ffffff'
    }"
  >
    <div class="mx-auto w-full max-w-[var(--container-content)] flex items-center justify-between gap-3 md:grid md:grid-cols-[auto_1fr_auto] md:items-center md:gap-6">

      <!-- Logo (hover swap) -->
      <div class="flex items-center gap-3 md:gap-4">
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
      </div>

      <!-- Centered links (desktop) -->
      <div class="hidden md:flex justify-center">
        <ul class="flex items-center gap-2 md:gap-3 text-[13px] md:text-[15px]">
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
          @click="toggleMenu()"
          style="contain: layout paint; /* isolate icon crossfade */"
        >
          <span class="relative block h-6 w-6">
            <!-- Hamburger -->
            <svg
              class="absolute inset-0 m-auto h-6 w-6 pointer-events-none transition-opacity duration-150 ease-out"
              :class="open ? 'opacity-0' : 'opacity-100'"
              xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
              fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <!-- Close -->
            <svg
              class="absolute inset-0 m-auto h-6 w-6 pointer-events-none transition-opacity duration-150 ease-out"
              :class="open ? 'opacity-100' : 'opacity-0'"
              xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
              fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path d="M6 6l12 12M6 18L18 6"/>
            </svg>
          </span>
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
          style="contain: layout paint;"
        >
          <span class="relative block h-5 w-5">
            <svg
              class="absolute inset-0 m-auto h-5 w-5 pointer-events-none transition-opacity duration-200"
              :class="theme === 'light' ? 'opacity-100' : 'opacity-0'"
              viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="4"/>
              <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>
            </svg>
            <svg
              class="absolute inset-0 m-auto h-5 w-5 pointer-events-none transition-opacity duration-200"
              :class="theme === 'dark' ? 'opacity-100' : 'opacity-0'"
              viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
            </svg>
          </span>
        </button>
      </div>
    </div>
  </nav>

  <!-- MOBILE OVERLAY -->
  <div
    x-cloak
    x-show="open"
    :class="{ 'hidden': !open }"
    :aria-hidden="(!open).toString()"
    class="fixed inset-0 z-40 bg-[rgba(15,17,35,0.65)] backdrop-blur-sm"
    @click="closeMenu()"
    x-transition:enter="ease-[var(--ease-brand)] duration-220"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    style="transition-property: opacity;"
  ></div>

  <!-- MOBILE MENU PANEL -->
  <div
    id="mobile-menu"
    x-cloak
    x-show="open"
    :class="{ 'hidden': !open }"
    :aria-hidden="(!open).toString()"
    class="md:hidden fixed inset-x-0 z-50 origin-top"
    :style="{ top: 'var(--nav-top-h)' }"
    x-transition:enter="transition ease-[var(--ease-brand)] duration-220"
    x-transition:enter-start="opacity-0 -translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-ref="drawer"
    @click.stop
    style="transition-property: opacity, transform;"
  >
    <div class="mx-auto max-w-[var(--container-content)] px-5 sm:px-6 md:px-8 py-6
                nav-mobile-surface space-y-5 rounded-b-3xl border border-white/10
                bg-[color-mix(in_oklab,var(--bg-default)_88%,transparent)]/92 backdrop-blur-lg
                shadow-[0_28px_60px_rgba(15,17,35,.35)] transition-[background,box-shadow,border-color] duration-200 ease-[var(--ease-brand)]">
      <!-- Links -->
      <div class="grid gap-3.5">
        @foreach ($routes as $routeName)
          <x-nav.anchor-button
              :route="$routeName"
              label="{{ __('messages.' . $routeName) }}"
              variant="mobile"
          />
        @endforeach
      </div>

      <div class="flex justify-center pt-2">
        <div
          x-cloak
          x-show="open"
          :class="{ 'hidden': !open }"
          :aria-hidden="(!open).toString()"
          class="flex items-center gap-3 rounded-2xl border border-white/12 bg-white/8 px-3.5 py-2
                 shadow-[0_12px_30px_rgba(15,17,35,.16)] transition-[background,border-color,box-shadow] duration-200 ease-[var(--ease-brand)]"
          x-transition:enter="delay-75 duration-200 ease-out"
          x-transition:enter-start="opacity-0 translate-y-2"
          x-transition:enter-end="opacity-100 translate-y-0"
        >
          <!-- Language (mobile) -->
          <button
            type="button"
            aria-label="Switch language to {{ strtoupper($targetLocale) }}"
            class="nav-icon-btn inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/14
                   bg-white/10 p-0 text-lg focus-ring hover:bg-white/16 hover:shadow-md transition"
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
            class="nav-icon-btn relative inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/14
                   bg-white/10 p-0 focus-ring hover:bg-white/16 hover:shadow-md transition-all duration-200"
            :aria-label="`Switch to ${theme === 'dark' ? 'light' : 'dark'} mode`"
            role="switch"
            :aria-checked="(theme === 'dark').toString()"
            @click="toggleTheme()"
            style="contain: layout paint;"
          >
            <span class="relative block h-6 w-6">
              <svg
                class="absolute inset-0 m-auto h-6 w-6 pointer-events-none transition-opacity duration-200"
                :class="theme === 'light' ? 'opacity-100' : 'opacity-0'"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 3v2.25M18.364 5.636l-1.591 1.591M21 12h-2.25M18.364 18.364l-1.591-1.591M12 18.75V21M6.227 18.773l1.591-1.591M3 12h2.25M6.227 5.227l1.591 1.591M12 8.25a3.75 3.75 0 100 7.5 3.75 3.75 0 000-7.5z"/>
              </svg>
              <svg
                class="absolute inset-0 m-auto h-6 w-6 pointer-events-none transition-opacity duration-200"
                :class="theme === 'dark' ? 'opacity-100' : 'opacity-0'"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M21.752 15.002A9 9 0 1112.998 2.248 7.5 7.5 0 0021.752 15z"/>
              </svg>
            </span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
