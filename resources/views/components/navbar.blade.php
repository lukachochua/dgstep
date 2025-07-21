<!-- Navbar -->
<nav aria-label="Main Navigation"
    class="sticky top-0 z-50 backdrop-blur-md bg-[rgba(25,35,70,0.85)] dark:bg-[rgba(15,25,50,0.9)] shadow-md border-b border-gray-700 transition-colors duration-300 ease-in-out text-[15px] tracking-tight font-medium">
    <div
        class="container mx-auto px-4 sm:px-6 md:px-8 h-16 md:h-20 flex items-center justify-between text-gray-900 dark:text-gray-200">

        <!-- Logo -->
        <a href="{{ route('home') }}" id="logo-text" aria-label="DGstep logo"
            class="group flex items-center space-x-2 select-none transition-transform duration-200 ease-out active:scale-95 focus-visible:outline-none">
            <div
                class="w-8 h-8 sm:w-10 sm:h-10 bg-[var(--color-electric-sky)] text-white font-black text-sm sm:text-base flex items-center justify-center rounded-[3px] shadow-md group-hover:scale-105 group-hover:bg-[var(--color-electric-sky-hover)]">
                DG
            </div>
            <div
                class="w-8 h-8 sm:w-10 sm:h-10 text-white font-black text-sm sm:text-base flex items-center justify-center rounded-[3px] shadow-md group-hover:scale-105 group-hover:text-[var(--color-electric-sky)]">
                STEP
            </div>
        </a>

        <!-- Desktop Menu -->
        <div class="hidden lg:flex items-center space-x-4 text-[15px] tracking-tight">
            @foreach (['home', 'services', 'about'] as $routeName)
                <div class="relative group rounded-[3px]">
                    <x-nav.anchor-button :route="$routeName" label="{{ __('messages.' . $routeName) }}"
                        variant="desktop" />
                </div>
            @endforeach
        </div>

        <!-- Right: Language Switch -->
        <div class="hidden lg:flex items-center space-x-3">
            <div class="ml-3 flex items-center gap-2 group transition">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 text-white group-hover:text-[var(--color-electric-sky)] transition" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
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
                stroke="currentColor" stroke-width="2">
                <path d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>
</nav>
