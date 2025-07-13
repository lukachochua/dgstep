<nav aria-label="Main Navigation"
    class="sticky top-0 z-50 backdrop-blur-md bg-[rgba(25,35,70,0.85)] dark:bg-[rgba(15,25,50,0.9)] shadow-md border-b border-gray-700 transition-colors duration-300 ease-in-out">
    <div
        class="container mx-auto px-4 sm:px-6 md:px-8 h-16 md:h-20 flex items-center justify-between font-semibold text-gray-900 dark:text-gray-200">

        <!-- Logo -->
        <a href="/" id="logo-text" aria-label="DGstep logo"
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


        <!-- Desktop Menu (Reference-Based Style) -->
        <div id="desktop-menu" class="hidden lg:flex items-center space-x-2 text-[0.95rem] font-medium tracking-wide">

            @php
                $active = 'hero'; // Change this server-side or via JS if you have scrollspy
            @endphp

            <a href="#hero"
                class="px-4 py-2 rounded-md transition font-semibold uppercase 
              {{ $active === 'hero' ? 'bg-[var(--color-electric-sky)] text-black' : 'bg-white/5 text-white hover:bg-white/10' }}">
                Home
            </a>

            <a href="#services"
                class="px-4 py-2 rounded-md transition font-semibold uppercase 
              {{ $active === 'services' ? 'bg-[var(--color-electric-sky)] text-black' : 'bg-white/5 text-white hover:bg-white/10' }}">
                Services
            </a>

            <a href="#about"
                class="px-4 py-2 rounded-md transition font-semibold uppercase 
              {{ $active === 'about' ? 'bg-[var(--color-electric-sky)] text-black' : 'bg-white/5 text-white hover:bg-white/10' }}">
                About
            </a>

            <a href="#projects"
                class="px-4 py-2 rounded-md transition font-semibold uppercase 
              {{ $active === 'projects' ? 'bg-[var(--color-electric-sky)] text-black' : 'bg-white/5 text-white hover:bg-white/10' }}">
                Projects
            </a>
        </div>

        <!-- Right: Auth + Language -->
        <div class="hidden lg:flex items-center space-x-2 text-sm font-medium tracking-wide">
            <a href="/login"
                class="px-4 py-2 rounded-md transition uppercase 
              bg-white/5 text-white hover:bg-white/10">
                Login
            </a>

            <a href="/register"
                class="px-4 py-2 rounded-md transition uppercase 
              bg-white/5 text-white hover:bg-white/10">
                Register
            </a>

            <div class="ml-3 flex items-center gap-2 group transition">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 text-white group-hover:text-[var(--color-electric-sky)] transition"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="square"
                    stroke-linejoin="miter">
                    <path d="M12 2c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zM12 2v20M2 12h20" />
                </svg>
                <select aria-label="Language switch"
                    class="bg-transparent text-white text-sm outline-none group-hover:text-[var(--color-electric-sky)] transition cursor-pointer">
                    <option class="text-black" value="ka">KA</option>
                    <option class="text-black" value="en" selected>EN</option>
                </select>
            </div>
        </div>


        <!-- Mobile Toggle -->
        <button id="menu-toggle"
            class="lg:hidden p-2 rounded-[3px] text-white hover:text-[var(--color-electric-sky)] transition"
            aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="mobile-menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor"
                stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu"
        class="hidden lg:hidden container mx-auto px-4 sm:px-6 md:px-8 pb-6 pt-4 space-y-5 text-center text-base font-medium text-white">

        <!-- Navigation Links -->
        <a href="#hero"
            class="block w-full max-w-xs mx-auto px-4 py-2 rounded-md bg-white/5 hover:bg-white/10 transition uppercase">
            Home
        </a>
        <a href="#about"
            class="block w-full max-w-xs mx-auto px-4 py-2 rounded-md bg-white/5 hover:bg-white/10 transition uppercase">
            About Us
        </a>
        <a href="#services"
            class="block w-full max-w-xs mx-auto px-4 py-2 rounded-md bg-white/5 hover:bg-white/10 transition uppercase">
            Services
        </a>
        <a href="#projects"
            class="block w-full max-w-xs mx-auto px-4 py-2 rounded-md bg-white/5 hover:bg-white/10 transition uppercase">
            Projects
        </a>

        <!-- Auth Buttons -->
        <div class="flex flex-col items-center gap-3 pt-2">
            <a href="/login"
                class="w-full max-w-xs px-4 py-2 rounded-md bg-white/5 hover:bg-white/10 transition uppercase">
                Login
            </a>
            <a href="/register"
                class="w-full max-w-xs px-4 py-2 rounded-md bg-white/5 hover:bg-white/10 transition uppercase">
                Register
            </a>
        </div>

        <!-- Language Switch -->
        <div class="flex justify-center items-center gap-2 pt-4 group transition">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 text-white group-hover:text-[var(--color-electric-sky)] transition" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="miter">
                <path d="M12 2c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zM12 2v20M2 12h20" />
            </svg>
            <select
                class="bg-transparent text-white text-sm outline-none group-hover:text-[var(--color-electric-sky)] transition cursor-pointer">
                <option class="text-black" value="ka">KA</option>
                <option class="text-black" value="en" selected>EN</option>
            </select>
        </div>
    </div>
</nav>
