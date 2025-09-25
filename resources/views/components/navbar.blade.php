<div
  x-data="dgNav()"
  x-init="init()"
  @keydown.window.escape="open = false"
>
  <!-- Navbar -->
  <nav id="site-nav" aria-label="Main Navigation" class="nav-surface text-[15px] tracking-tight font-medium max-w-full">
    <div class="mx-auto px-4 sm:px-6 md:px-8">

      <!-- STORY 1: Top bar (logo left, controls right) -->
      <!-- height now comes from CSS var: .nav-story-top { height: var(--nav-top-h) } -->
      <div class="nav-story-top nav-bleed flex items-center justify-between">
        <!-- Logo (auto-swaps by data-theme) -->
        <a href="{{ route('home') }}" id="logo-text" aria-label="DGstep logo"
           class="group flex items-center gap-2 select-none transition-transform duration-200 ease-[var(--ease-brand)] active:scale-95 focus-visible:outline-none">
          <!-- Light -->
          <img
            src="{{ Vite::asset('resources/images/brand/logo-white-01.png') }}"
            alt="DGstep logo"
            class="logo-img--light h-7 md:h-8 w-auto select-none pointer-events-none"
            width="160" height="40" fetchpriority="high" decoding="async"
          />
          <!-- Dark -->
          <img
            src="{{ Vite::asset('resources/images/brand/logo-color-01.png') }}"
            alt=""
            class="logo-img--dark  h-7 md:h-8 w-auto select-none pointer-events-none"
            width="160" height="40" decoding="async"
          />
        </a>

        <!-- Right: Language Toggle + Theme Changer (Desktop) -->
        @php
          $current = app()->getLocale();
          $targetLocale = $current === 'ka' ? 'en' : 'ka';
        @endphp
        <div class="hidden lg:flex items-center gap-3">
          <!-- Language -->
          <a href="#"
             role="button"
             aria-label="Switch language to {{ strtoupper($targetLocale) }}"
             class="nav-link-desktop inline-flex items-center justify-center h-9 w-9 p-0 rounded-full cursor-pointer select-none focus-ring hover:shadow-md transition"
             onclick="document.getElementById('locale-toggle-desktop').submit(); return false;"
          >
            <span class="flag-emoji" aria-hidden="true">
              @if($targetLocale === 'ka') 🇬🇪 @else 🇬🇧 @endif
            </span>
            <span class="sr-only">
              {{ $targetLocale === 'ka' ? 'Switch to Georgian' : 'Switch to English' }}
            </span>
          </a>

          <form id="locale-toggle-desktop" action="{{ route('locale.switch') }}" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="locale" value="{{ $targetLocale }}">
          </form>

          <!-- Theme toggle (desktop) -->
          <button
            type="button"
            class="nav-link-desktop relative inline-flex items-center justify-center h-9 w-9 p-0 rounded-full focus-ring hover:shadow-md transition-all duration-200"
            :aria-label="`Switch to ${theme === 'dark' ? 'light' : 'dark'} mode`"
            role="switch"
            :aria-checked="(theme === 'dark').toString()"
            @click="toggleTheme()"
          >
            <svg class="theme-icon icon--sun absolute inset-0 m-auto h-6 w-6 pointer-events-none"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"
                 stroke-linecap="round" stroke-linejoin="round" shape-rendering="geometricPrecision">
              <path d="M12 3v2.25M18.364 5.636l-1.591 1.591M21 12h-2.25M18.364 18.364l-1.591-1.591M12 18.75V21M6.227 18.773l1.591-1.591M3 12h2.25M6.227 5.227l1.591 1.591M12 8.25a3.75 3.75 0 100 7.5 3.75 3.75 0 000-7.5z"/>
            </svg>
            <svg class="theme-icon icon--moon absolute inset-0 m-auto h-6 w-6 pointer-events-none"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"
                 stroke-linecap="round" stroke-linejoin="round" shape-rendering="geometricPrecision">
              <path d="M21.752 15.002A9 9 0 1112.998 2.248 7.5 7.5 0 0021.752 15z"/>
            </svg>
          </button>
        </div>

        <!-- Mobile Toggle -->
        <button
          class="lg:hidden p-2 rounded-[6px] hover:text-electric transition"
          aria-label="Toggle navigation menu"
          :aria-expanded="open.toString()"
          aria-controls="mobile-menu"
          @click="open = !open"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
               viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>

      <!-- Divider between stories -->
      <!-- height now comes from CSS var: .nav-story-divider { height: var(--nav-divider-h) } -->
      <div class="hidden lg:block nav-story-divider nav-divider-bleed"></div>

      <!-- STORY 2: Bottom bar (primary links on their own line) -->
      <!-- height now comes from CSS var: .nav-story-bottom { height: var(--nav-bottom-h) } -->
      <div class="nav-story-bottom nav-bleed hidden lg:flex items-center justify-center gap-3 text-[15px] tracking-tight">
        @foreach (['home', 'services', 'about'] as $routeName)
          <div class="relative group rounded-[6px]">
            <x-nav.anchor-button :route="$routeName" label="{{ __('messages.' . $routeName) }}" variant="desktop" />
          </div>
        @endforeach
      </div>

    </div>
  </nav>

  <!-- Mobile Menu -->
  <div
    id="mobile-menu"
    x-cloak
    x-show="open"
    x-transition.origin.top
    @click.outside="open = false"
    class="lg:hidden mx-auto max-w-[var(--container-content)] px-4 sm:px-6 md:px-8 pb-6 pt-4 space-y-5 text-center text-base font-medium nav-mobile-surface z-40"
  >
    @foreach (['home', 'services', 'about'] as $routeName)
      <div class="relative group rounded-[6px]">
        <x-nav.anchor-button :route="$routeName" label="{{ __('messages.' . $routeName) }}" variant="mobile" />
      </div>
    @endforeach

    <!-- Language + Theme (Mobile) -->
    <div class="flex justify-center items-center gap-3 pt-4">
      <a href="#"
         role="button"
         aria-label="Switch language to {{ strtoupper($targetLocale) }}"
         class="nav-link-mobile inline-flex items-center justify-center h-10 w-10 p-0 rounded-full cursor-pointer select-none focus-ring hover:shadow-md transition"
         onclick="document.getElementById('locale-toggle-mobile').submit(); return false;"
      >
        <span class="flag-emoji" aria-hidden="true">
          @if($targetLocale === 'ka') 🇬🇪 @else 🇬🇧 @endif
        </span>
        <span class="sr-only">
          {{ $targetLocale === 'ka' ? 'Switch to Georgian' : 'Switch to English' }}
        </span>
      </a>

      <form id="locale-toggle-mobile" action="{{ route('locale.switch') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="locale" value="{{ $targetLocale }}">
      </form>

      <button
        type="button"
        class="nav-link-mobile relative inline-flex items-center justify-center h-10 w-10 p-0 rounded-full focus-ring hover:shadow-md transition-all duration-200"
        :aria-label="`Switch to ${theme === 'dark' ? 'light' : 'dark'} mode`"
        role="switch"
        :aria-checked="(theme === 'dark').toString()"
        @click="toggleTheme()"
      >
        <svg class="theme-icon icon--sun absolute inset-0 m-auto h-6 w-6 pointer-events-none"
             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"
             stroke-linecap="round" stroke-linejoin="round" shape-rendering="geometricPrecision">
          <path d="M12 3v2.25M18.364 5.636l-1.591 1.591M21 12h-2.25M18.364 18.364l-1.591-1.591M12 18.75V21M6.227 18.773l1.591-1.591M3 12h2.25M6.227 5.227l1.591 1.591M12 8.25a3.75 3.75 0 100 7.5 3.75 3.75 0 000-7.5z"/>
        </svg>
        <svg class="theme-icon icon--moon absolute inset-0 m-auto h-6 w-6 pointer-events-none"
             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"
             stroke-linecap="round" stroke-linejoin="round" shape-rendering="geometricPrecision">
          <path d="M21.752 15.002A9 9 0 1112.998 2.248 7.5 7.5 0 0021.752 15z"/>
        </svg>
      </button>
    </div>
  </div>
</div>

<script>
  function dgNav () {
    return {
      open: false,
      theme: document.documentElement.getAttribute('data-theme') || 'light',
      init() {
        window.addEventListener('storage', (e) => {
          if (e.key === 'dg:theme' && (e.newValue === 'light' || e.newValue === 'dark')) {
            this.theme = e.newValue;
            document.documentElement.setAttribute('data-theme', this.theme);
          }
        });
        const mq = window.matchMedia('(min-width: 1024px)');
        const sync = () => { if (mq.matches) this.open = false; };
        (mq.addEventListener ? mq.addEventListener('change', sync) : mq.addListener(sync));
      },
      toggleTheme() {
        this.theme = this.theme === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', this.theme);
        try { localStorage.setItem('dg:theme', this.theme); } catch (_) {}
      },
    }
  }
</script>
