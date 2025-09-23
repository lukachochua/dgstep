<!-- Navbar -->
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

    <!-- Right: Language Switch -->
    <div class="hidden lg:flex items-center gap-3">
      <div class="ml-3 flex items-center gap-2 group transition">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-4 w-4 text-current group-hover:text-electric transition"
             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
          <path d="M12 2c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zM12 2v20M2 12h20" />
        </svg>
        <form action="{{ route('locale.switch') }}" method="POST">
          @csrf
          <select name="locale" onchange="this.form.submit()" aria-label="Language switch" class="nav-select">
            <option value="ka" {{ app()->getLocale() === 'ka' ? 'selected' : '' }}>KA</option>
            <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>EN</option>
          </select>
        </form>
      </div>
    </div>

    <!-- Mobile Toggle -->
    <button id="menu-toggle"
            class="lg:hidden p-2 rounded-[6px] hover:text-electric transition"
            aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="mobile-menu">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
           viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>
  </div>
</nav>

<!-- Mobile Menu -->
<div id="mobile-menu"
     class="hidden lg:hidden mx-auto max-w-[var(--container-content)] px-4 sm:px-6 md:px-8 pb-6 pt-4 space-y-5 text-center text-base font-medium nav-mobile-surface z-40">
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

  <!-- Language Switch -->
  <div class="flex justify-center items-center gap-2 pt-4 group transition">
    <svg xmlns="http://www.w3.org/2000/svg"
         class="h-5 w-5 text-current group-hover:text-electric transition"
         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
         stroke-linecap="square" stroke-linejoin="miter">
      <path d="M12 2c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zM12 2v20M2 12h20" />
    </svg>
    <form action="{{ route('locale.switch') }}" method="POST">
      @csrf
      <select name="locale" onchange="this.form.submit()" aria-label="Language switch" class="nav-select">
        <option value="ka" {{ app()->getLocale() === 'ka' ? 'selected' : '' }}>KA</option>
        <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>EN</option>
      </select>
    </form>
  </div>
</div>
