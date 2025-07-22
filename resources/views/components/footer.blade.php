<footer
    class="bg-[rgb(15,25,50)] text-white/70 py-12 select-none border-t border-white/10 dark:border-gray-700 text-sm tracking-tight font-[FiraGO]">
    <div class="container mx-auto px-4 sm:px-6 md:px-8 flex flex-col md:flex-row justify-between gap-6">

        <!-- Left: Info + GitHub + Stack -->
        <div class="flex flex-col items-center md:items-start text-center md:text-left space-y-1">
            <p class="text-white/50">
                {{ trans('messages.footer.copyright', ['year' => now()->year]) }}
            </p>
            <a href="https://github.com/lukachochua/dgstep" target="_blank" rel="noopener noreferrer"
                class="text-white/60 hover:text-white transition">
                GitHub: lukachochua/dgstep
            </a>
            <p class="text-white/60">
                Stack: Laravel 12 / Tailwind CSS / Alpine.js
            </p>
        </div>

        <!-- Right: Terms, Contact, Email & Phone -->
        <div class="flex flex-col items-center md:items-end text-center md:text-right space-y-1">
            <a href="{{ route('terms') }}" class="text-white/60 hover:text-white transition">
                {{ __('messages.footer.nav.terms') }}
            </a>
            <a href="#contact" class="text-white/60 hover:text-white transition">
                {{ __('messages.footer.nav.contact') }}
            </a>
            <a href="mailto:info@example.com" class="text-white/70 hover:text-white transition">
                📧 info@example.com
            </a>
            <a href="tel:+995599000000" class="text-white/70 hover:text-white transition">
                📞 +995 599 000 000
            </a>
        </div>

    </div>
</footer>
