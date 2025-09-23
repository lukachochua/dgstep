<!-- Alpine scope wraps BOTH nav + mobile menu -->
<div
  x-data="dgNav()"
  x-init="init()"
  @keydown.window.escape="open = false"
>
  <!-- Navbar -->
  <nav aria-label="Main Navigation" class="nav-surface text-[15px] tracking-tight font-medium">
    <div class="mx-auto max-w-[var(--container-content)] px-4 sm:px-6 md:px-8 h-16 md:h-20 flex items-center justify-between">
      <!-- Logo (auto-swaps by data-theme) -->
      <a href="{{ route('home') }}" id="logo-text" aria-label="DGstep logo"
         class="group flex items-center gap-2 select-none transition-transform duration-200 ease-[var(--ease-brand)] active:scale-95 focus-visible:outline-none">
        {{-- Light theme logo (shown when [data-theme="light"]) --}}
        <img
          src="{{ Vite::asset('resources/images/brand/logo-white-01.png') }}"
          alt="DGstep logo"
          class="logo-img--light h-7 md:h-8 w-auto select-none pointer-events-none"
          width="160" height="40" fetchpriority="high" decoding="async"
        />
        {{-- Dark theme logo (shown when [data-theme="dark"]) --}}
        <img
          src="{{ Vite::asset('resources/images/brand/logo-color-01.png') }}"
          alt=""
          class="logo-img--dark h-7 md:h-8 w-auto select-none pointer-events-none"
          width="160" height="40" decoding="async"
        />
      </a>

      <!-- Desktop Menu -->
      <div class="hidden lg:flex items-center gap-3 text-[15px] tracking-tight">
        @foreach (['home', 'services', 'about'] as $routeName)
          <div class="relative group rounded-[6px]">
            <x-nav.anchor-button :route="$routeName" label="{{ __('messages.' . $routeName) }}" variant="desktop" />
          </div>
        @endforeach
      </div>

      <!-- Right: Language Toggle + Theme Changer (Desktop) -->
      <!-- @php
        $current = app()->getLocale();
        $targetLocale = $current === 'ka' ? 'en' : 'ka';
        $langLabel = $current === 'ka' ? 'ENGLISH' : 'ქართული';
      @endphp -->
      <div class="hidden lg:flex items-center gap-3">
        {{-- Language --}}
        <a href="#"
          role="button"
          aria-label="Switch language to {{ strtoupper($targetLocale) }}"
          class="nav-link-desktop inline-flex items-center justify-center h-9 w-9 p-0 rounded-full cursor-pointer select-none focus-ring hover:shadow-md transition"
          onclick="document.getElementById('locale-toggle-desktop').submit(); return false;"
        >
          {{-- Show the TARGET locale flag (what you’ll switch to) --}}
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
        {{-- Theme toggle (desktop, icon-only) --}}
        <button
          type="button"
          class="nav-link-desktop relative inline-flex items-center justify-center h-9 w-9 p-0 rounded-full focus-ring
                hover:shadow-md transition-all duration-200"
          :aria-label="`Switch to ${theme === 'dark' ? 'light' : 'dark'} mode`"
          role="switch"
          :aria-checked="(theme === 'dark').toString()"
          @click="toggleTheme()"
        >
        <!-- Sun -->
        <svg class="theme-icon absolute inset-0 m-auto h-5 w-5"
            :class="theme === 'dark' ? 'icon-hidden' : 'icon-visible'"
            viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path d="M6.76 4.84l-1.8-1.79-1.41 1.41 1.79 1.8 1.42-1.42zM12 4V1h-1v3h1zm5.24.84l1.8-1.79 1.41 1.41-1.79 1.8-1.42-1.42zM20 11h3v1h-3v-1zM1 11h3v1H1v-1zm15.66 7.95l1.79 1.8 1.41-1.41-1.8-1.8-1.4 1.41zM4.24 18.95l-1.79 1.8 1.41 1.41 1.8-1.8-1.42-1.41zM12 7a5 5 0 100 10A5 5 0 0012 7z"/>
        </svg>

        <!-- Moon -->
        <svg class="theme-icon absolute inset-0 m-auto h-5 w-5"
            :class="theme === 'dark' ? 'icon-visible' : 'icon-hidden'"
            viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path d="M20.742 13.045A8 8 0 1111 3.258 7 7 0 0020.742 13.045z"/>
        </svg>
      </button>
      </div>

      <!-- Mobile Toggle (open/close menu) -->
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

    <!-- Auth Buttons -->
    <!-- <div class="flex flex-col items-center gap-3 pt-2 border-t border-white/10">
      <x-nav.anchor-button route="login"    label="{{ __('messages.login') }}"    variant="auth-mobile" />
      <x-nav.anchor-button route="register" label="{{ __('messages.register') }}" variant="auth-mobile" />
    </div> -->

    <!-- Language + Theme (Mobile) -->
    <div class="flex justify-center items-center gap-3 pt-4">
      {{-- Language --}}
        <a href="#"
          role="button"
          aria-label="Switch language to {{ strtoupper($targetLocale) }}"
          class="nav-link-mobile inline-flex items-center justify-center h-10 w-10 p-0 rounded-full cursor-pointer select-none focus-ring hover:shadow-md transition"
          onclick="document.getElementById('locale-toggle-mobile').submit(); return false;"
        >
          {{-- Show the TARGET locale flag (what you’ll switch to) --}}
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


      {{-- Theme toggle (mobile, icon-only) --}}
      <button
        type="button"
        class="nav-link-mobile relative inline-flex items-center justify-center h-10 w-10 p-0 rounded-full focus-ring
              hover:shadow-md transition-all duration-200"
        :aria-label="`Switch to ${theme === 'dark' ? 'light' : 'dark'} mode`"
        role="switch"
        :aria-checked="(theme === 'dark').toString()"
        @click="toggleTheme()"
      >
        <!-- Sun -->
        <svg class="theme-icon absolute inset-0 m-auto h-5 w-5"
            :class="theme === 'dark' ? 'icon-hidden' : 'icon-visible'"
            viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path d="M6.76 4.84l-1.8-1.79-1.41 1.41 1.79 1.8 1.42-1.42zM12 4V1h-1v3h1zm5.24.84l1.8-1.79 1.41 1.41-1.79 1.8-1.42-1.42zM20 11h3v1h-3v-1zM1 11h3v1H1v-1zm15.66 7.95l1.79 1.8 1.41-1.41-1.8-1.8-1.4 1.41zM4.24 18.95l-1.79 1.8 1.41 1.41 1.8-1.8-1.42-1.41zM12 7a5 5 0 100 10A5 5 0 0012 7z"/>
        </svg>

        <!-- Moon -->
        <svg class="theme-icon absolute inset-0 m-auto h-5 w-5"
            :class="theme === 'dark' ? 'icon-visible' : 'icon-hidden'"
            viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path d="M20.742 13.045A8 8 0 1111 3.258 7 7 0 0020.742 13.045z"/>
        </svg>
      </button>
    </div>
  </div>
</div>

<!-- Alpine component -->
<script>
  function dgNav () {
    return {
      open: false,
      theme: 'light',
      init() {
        // initial theme: storage -> OS -> light
        try {
          const KEY = 'dg:theme';
          const saved = localStorage.getItem(KEY);
          if (saved === 'light' || saved === 'dark') {
            this.theme = saved;
          } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            this.theme = 'dark';
          }
        } catch (_) {}

        this.applyTheme();

        // keep Alpine state in sync if another tab changes it
        window.addEventListener('storage', (e) => {
          if (e.key === 'dg:theme' && (e.newValue === 'light' || e.newValue === 'dark')) {
            this.theme = e.newValue;
            this.applyTheme();
          }
        });

        // close menu when hitting desktop breakpoint
        const mq = window.matchMedia('(min-width: 1024px)');
        const sync = () => { if (mq.matches) this.open = false; };
        (mq.addEventListener ? mq.addEventListener('change', sync) : mq.addListener(sync));
      },
      toggleTheme() {
        this.theme = this.theme === 'dark' ? 'light' : 'dark';
        this.applyTheme(true);
      },
      applyTheme(persist = false) {
        const el = document.documentElement;
        el.setAttribute('data-theme', this.theme);
        if (persist) {
          try { localStorage.setItem('dg:theme', this.theme); } catch (_) {}
        }
      }
    }
  }
</script>
