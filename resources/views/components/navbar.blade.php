<nav
    class="sticky top-0 z-50 backdrop-blur-md bg-[rgba(25,35,70,0.85)] dark:bg-[rgba(15,25,50,0.9)] shadow-md border-b border-gray-700 transition-colors duration-300 ease-in-out">
    <div
        class="container mx-auto px-4 sm:px-6 md:px-8 h-16 md:h-20 flex items-center justify-between font-semibold text-gray-900 dark:text-gray-200">
        <!-- Logo -->
        <a href="/" id="logo-text" aria-label="DGstep logo"
            class="flex items-center space-x-2 group select-none transition-all duration-300">
            <div
                class="w-10 h-10 sm:w-12 sm:h-12 bg-[var(--color-electric-sky)] text-white font-extrabold text-base sm:text-lg flex items-center justify-center rounded-md shadow-md transition-all duration-300 group-hover:scale-105 group-hover:bg-[var(--color-electric-sky-hover)]">
                DG
            </div>
            <span
                class="font-extrabold text-base sm:text-lg text-[var(--color-electric-sky-hover)] dark:text-[var(--color-electric-sky)] tracking-wide uppercase transition-colors duration-300 group-hover:text-white">
                STEP
            </span>
        </a>

        <!-- Menu -->
        <div id="desktop-menu" class="hidden lg:flex space-x-8 text-base items-center">
            <a href="#hero" class="text-white hover:text-[var(--color-electric-sky)] transition">Home</a>
            <a href="#about" class="text-white hover:text-[var(--color-electric-sky)] transition">About</a>
            <a href="#services" class="text-white hover:text-[var(--color-electric-sky)] transition">Services</a>
            <a href="#projects" class="text-white hover:text-[var(--color-electric-sky)] transition">Projects</a>
        </div>

        <!-- Right -->
        <div class="hidden lg:flex items-center space-x-4 text-sm">
            <a href="/login" class="text-white hover:text-[var(--color-electric-sky)] transition">Login</a>
            <span class="text-gray-400">|</span>
            <a href="/register" class="text-white hover:text-[var(--color-electric-sky)] transition">Register</a>
            <select aria-label="Language switch" class="ml-4 bg-transparent text-white text-sm outline-none">
                <option class="text-black" value="ka">KA</option>
                <option class="text-black" value="en" selected>EN</option>
            </select>
        </div>

        <!-- Mobile toggle -->
        <button id="menu-toggle"
            class="lg:hidden p-2 rounded-md text-white hover:text-[var(--color-electric-sky)] transition"
            aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="mobile-menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor"
                stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <div id="mobile-menu"
        class="hidden lg:hidden container mx-auto px-4 sm:px-6 md:px-8 pb-6 pt-2 space-y-4 text-center text-base font-medium text-white">
        <a href="#hero" class="block hover:text-[var(--color-electric-sky)] transition">Home</a>
        <a href="#about" class="block hover:text-[var(--color-electric-sky)] transition">About</a>
        <a href="#services" class="block hover:text-[var(--color-electric-sky)] transition">Services</a>
        <a href="#projects" class="block hover:text-[var(--color-electric-sky)] transition">Projects</a>
        <a href="/login" class="block hover:text-[var(--color-electric-sky)] transition">Login</a>
        <a href="/register" class="block hover:text-[var(--color-electric-sky)] transition">Register</a>
        <select class="mt-2 bg-transparent text-white text-sm outline-none">
            <option class="text-black" value="ka">KA</option>
            <option class="text-black" value="en" selected>EN</option>
        </select>
    </div>
</nav>
