<footer
    class="bg-[rgb(15,25,50)] text-white/70 py-12 select-none border-t border-white/10 dark:border-gray-700 transition-colors duration-300">
    <div
        class="container mx-auto px-4 sm:px-6 md:px-8 flex flex-col md:flex-row justify-between items-center gap-4 md:gap-6 text-sm font-light">

        <!-- Left: Copyright -->
        <p class="text-white/60">&copy; {{ now()->year }} <span class="font-semibold text-white">DGstep</span>. Built
            with Laravel 12 + Tailwind CSS.</p>

        <!-- Right: Footer Nav -->
        <nav class="flex flex-wrap justify-center gap-4 text-white/60">
            <a href="#features" class="hover:text-[var(--color-electric-sky)] transition">Features</a>
            <a href="#pricing" class="hover:text-[var(--color-electric-sky)] transition">Pricing</a>
            <a href="#contact" class="hover:text-[var(--color-electric-sky)] transition">Contact</a>
            <a href="https://github.com/yourrepo" target="_blank" rel="noopener noreferrer"
                class="hover:text-[var(--color-electric-sky)] transition">GitHub</a>
        </nav>
    </div>
</footer>
