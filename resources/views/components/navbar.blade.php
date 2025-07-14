<nav aria-label="Main Navigation"
    class="sticky top-0 z-50 backdrop-blur-md bg-[rgba(25,35,70,0.85)] dark:bg-[rgba(15,25,50,0.9)] shadow-md border-b border-gray-700 transition-colors duration-300 ease-in-out">
    <div
        class="container mx-auto px-4 sm:px-6 md:px-8 h-16 md:h-20 flex items-center justify-between font-semibold text-gray-900 dark:text-gray-200">

        <!-- Logo -->
        <a href="{{ route('home') }}" id="logo-text" aria-label="DGstep logo"
            class="group flex items-center space-x-2 select-none transition-transform duration-200 ease-out active:scale-95 focus-visible:outline-none">
            <div
                class="w-8 h-8 sm:w-10 sm:h-10 bg-[var(--color-electric-sky)] text-white font-extrabold text-base sm:text-lg flex items-center justify-center rounded-[3px] shadow-md transition-all duration-300 group-hover:scale-105 group-hover:bg-[var(--color-electric-sky-hover)]">
                DG
            </div>
            <div
                class="w-8 h-8 sm:w-10 sm:h-10 text-white font-extrabold text-base sm:text-lg flex items-center justify-center rounded-[3px] shadow-md transition-all duration-300 group-hover:scale-105 group-hover:text-[var(--color-electric-sky)]">
                STEP
            </div>
        </a>

        <!-- Desktop Menu -->
        <div class="hidden lg:flex items-center space-x-2 text-[0.95rem] font-medium tracking-wide">
            @foreach (['home', 'services', 'about', 'projects'] as $routeName)
                <div class="relative group rounded-[3px]">
                    <x-nav.anchor-button :route="$routeName" label="{{ __('messages.' . $routeName) }}"
                        variant="desktop" />
                </div>
            @endforeach
        </div>

        <!-- Right: Auth + Language -->
        <div class="hidden lg:flex items-center space-x-2 text-sm font-medium tracking-wide">
            <x-nav.anchor-button route="login" label="{{ __('messages.login') }}" variant="auth" />
            <x-nav.anchor-button route="register" label="{{ __('messages.register') }}" variant="auth" />

            <div class="ml-3 flex items-center gap-2 group transition">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 text-white group-hover:text-[var(--color-electric-sky)] transition" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="square"
                    stroke-linejoin="miter">
                    <path d="M12 2c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zM12 2v20M2 12h20" />
                </svg>

                <form action="{{ route('locale.switch') }}" method="POST">
                    @csrf
                    <select name="locale" onchange="this.form.submit()" aria-label="Language switch"
                        class="bg-transparent text-white text-sm outline-none group-hover:text-[var(--color-electric-sky)] transition cursor-pointer">
                        <option value="ka" {{ app()->getLocale() === 'ka' ? 'selected' : '' }}>KA</option>
                        <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>EN</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Mobile Toggle -->
        <button id="menu-toggle"
            class="lg:hidden p-2 rounded-[3px] text-white hover:text-[var(--color-electric-sky)] transition"
            aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="mobile-menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu"
        class="hidden lg:hidden container mx-auto px-4 sm:px-6 md:px-8 pb-6 pt-4 space-y-5 text-center text-base font-medium text-white">
        @foreach (['home', 'services', 'about', 'projects'] as $routeName)
            <div class="relative group rounded-[3px]">
                <x-nav.anchor-button :route="$routeName" label="{{ __('messages.' . $routeName) }}" variant="mobile" />
            </div>
        @endforeach

        <!-- Auth Buttons -->
        <div class="flex flex-col items-center gap-3 pt-2">
            <x-nav.anchor-button route="login" label="{{ __('messages.login') }}" variant="auth-mobile" />
            <x-nav.anchor-button route="register" label="{{ __('messages.register') }}" variant="auth-mobile" />
        </div>

        <!-- Language Switch -->
        <div class="flex justify-center items-center gap-2 pt-4 group transition">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 text-white group-hover:text-[var(--color-electric-sky)] transition" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="square"
                stroke-linejoin="miter">
                <path d="M12 2c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zM12 2v20M2 12h20" />
            </svg>

            <form action="{{ route('locale.switch') }}" method="POST">
                @csrf
                <select name="locale" onchange="this.form.submit()" aria-label="Language switch"
                    class="bg-transparent text-white text-sm outline-none group-hover:text-[var(--color-electric-sky)] transition cursor-pointer">
                    <option value="ka" {{ app()->getLocale() === 'ka' ? 'selected' : '' }}>KA</option>
                    <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>EN</option>
                </select>
            </form>
        </div>
    </div>
</nav>
