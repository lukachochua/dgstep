<!-- Alpine scope wraps BOTH nav + mobile menu -->
<div
  x-data="{ open:false }"
  x-init="
    // Close menu when jumping to desktop breakpoint
    (() => {
      const mq = window.matchMedia('(min-width: 1024px)');
      const sync = () => { if (mq.matches) open = false };
      (mq.addEventListener ? mq.addEventListener('change', sync) : mq.addListener(sync));
    })()
  "
  @keydown.window.escape="open = false"
>
  <!-- Navbar (unchanged except :aria-expanded) -->
  <nav aria-label="Main Navigation" class="nav-surface text-[15px] tracking-tight font-medium">
    <div class="mx-auto max-w-[var(--container-content)] px-4 sm:px-6 md:px-8 h-16 md:h-20 flex items-center justify-between">
      <!-- Logo -->
      <a href="{{ route('home') }}" id="logo-text" aria-label="DGstep logo"
         class="group flex items-center gap-2 select-none transition-transform duration-200 ease-[var(--ease-brand)] active:scale-95 focus-visible:outline-none">
        <div class="logo-chip logo-chip-dg group-hover:scale-105">DG</div>
        <div class="logo-chip logo-chip-step group-hover:scale-105">STEP</div>
      </a>

      <!-- Desktop Menu -->
      <div class="hidden lg:flex items-center gap-3 text-[15px] tracking-tight">
        @foreach (['home', 'services', 'about'] as $routeName)
          <div class="relative group rounded-[6px]">
            <x-nav.anchor-button :route="$routeName" label="{{ __('messages.' . $routeName) }}" variant="desktop" />
          </div>
        @endforeach
      </div>

      <!-- Right: Language Toggle + Theme Toggle (Desktop) -->
      @php
        $current = app()->getLocale();
        $targetLocale = $current === 'ka' ? 'en' : 'ka';
        $langLabel = $current === 'ka' ? 'ENGLISH' : 'ქართული';
      @endphp
      <div class="hidden lg:flex items-center gap-3">
        {{-- Language --}}
        <a href="#"
           role="button"
           aria-label="Switch language to {{ $targetLocale }}"
           class="nav-link-desktop px-2 py-1 cursor-pointer select-none"
           onclick="document.getElementById('locale-toggle-desktop').submit(); return false;">
          {{ $langLabel }}
        </a>
        <form id="locale-toggle-desktop" action="{{ route('locale.switch') }}" method="POST" class="hidden">
          @csrf
          <input type="hidden" name="locale" value="{{ $targetLocale }}">
        </form>

        {{-- Theme toggle --}}
        <button
          type="button"
          class="nav-link-desktop px-2 py-1 cursor-pointer select-none"
          aria-label="Toggle theme"
          onclick="(function(btn){
            const el = document.documentElement;
            const next = el.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            el.setAttribute('data-theme', next);
            try { localStorage.setItem('dg:theme', next); } catch(e) {}
            const span = btn.querySelector('span');
            if (span) span.textContent = next === 'dark' ? 'Light' : 'Dark';
          })(this)">
          <span>Dark</span>
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
        <!-- Hamburger icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
          <path d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
  </nav>

  <!-- Mobile Menu (now inside the same Alpine scope) -->
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
    <div class="flex flex-col items-center gap-3 pt-2 border-t border-white/10">
      <x-nav.anchor-button route="login"    label="{{ __('messages.login') }}"    variant="auth-mobile" />
      <x-nav.anchor-button route="register" label="{{ __('messages.register') }}" variant="auth-mobile" />
    </div>

    <!-- Language + Theme (Mobile) -->
    <div class="flex justify-center items-center gap-3 pt-4">
      {{-- Language --}}
      <a href="#"
         role="button"
         aria-label="Switch language to {{ $targetLocale }}"
         class="nav-link-mobile w-auto px-3 py-2 cursor-pointer select-none"
         onclick="document.getElementById('locale-toggle-mobile').submit(); return false;">
        {{ $langLabel }}
      </a>
      <form id="locale-toggle-mobile" action="{{ route('locale.switch') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="locale" value="{{ $targetLocale }}">
      </form>

      {{-- Theme toggle --}}
      <button
        type="button"
        class="nav-link-mobile w-auto px-3 py-2 cursor-pointer select-none"
        aria-label="Toggle theme"
        onclick="(function(btn){
          const el = document.documentElement;
          const next = el.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
          el.setAttribute('data-theme', next);
          try { localStorage.setItem('dg:theme', next); } catch(e) {}
          const span = btn.querySelector('span');
          if (span) span.textContent = next === 'dark' ? 'Light' : 'Dark';
        })(this)">
        <span>Dark</span>
      </button>
    </div>
  </div>
</div>
