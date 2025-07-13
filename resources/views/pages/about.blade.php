<x-layouts.base title="About Us — DGstep">
    <div class="min-h-screen flex flex-col">
        <x-navbar />

        <!-- Hero Section: Who We Are -->
        <section
            class="flex-grow bg-gradient-to-r from-[#0b0f1a] via-[#141d2f] to-[#0b0f1a] text-white px-6 py-24 select-none">
            <div class="container mx-auto max-w-6xl text-center space-y-16">

                <!-- Top: Who We Are -->
                <div class="flex flex-col md:flex-row items-center justify-between gap-12 text-left md:text-start">
                    <!-- Text Content -->
                    <div class="md:w-1/2 space-y-6">
                        <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight leading-tight">
                            Who <span class="text-[var(--color-electric-sky)]">We Are</span>
                        </h2>
                        <p class="text-white/80 text-lg leading-relaxed max-w-xl">
                            DGstep is more than a tech studio. We’re strategic partners for small/medium businesses
                            across Georgia, combining software craftsmanship with deep operational knowledge —
                            especially in regulated industries like pawnshops.
                        </p>
                        <p class="text-white/80 text-base leading-relaxed max-w-xl">
                            From modernizing inventory systems to automating contracts and customer tracking,
                            our Laravel + Tailwind stack ensures performance, compliance, and elegant user experience.
                        </p>
                    </div>

                    <!-- Visual Side -->
                    <div class="md:w-1/2 flex flex-col items-center gap-6">
                        <div class="aspect-square w-52 rounded-full overflow-hidden border-4 border-white/10 shadow-lg">
                            <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?q=80&w=400&auto=format&fit=crop"
                                alt="Team working" class="w-full h-full object-cover object-center" />
                        </div>

                        <div
                            class="bg-[var(--color-electric-sky)] w-20 h-32 rounded-full flex items-center justify-center shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-black" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path d="M13 2L3 14h9l-1 8L21 10h-9l1-8z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Mission -->
                <div>
                    <h3 class="text-3xl md:text-4xl font-bold mb-10">
                        Our <span class="text-[var(--color-electric-sky)]">Mission</span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left text-white/90">
                        <div class="bg-white/5 p-6 rounded-xl border border-white/10 backdrop-blur-sm">
                            <h4 class="text-xl font-semibold mb-2 text-white">Simplify Complexity</h4>
                            <p class="text-white/70 text-base">
                                We build software that removes friction — letting owners focus on customers,
                                not paperwork or compliance chaos.
                            </p>
                        </div>
                        <div class="bg-white/5 p-6 rounded-xl border border-white/10 backdrop-blur-sm">
                            <h4 class="text-xl font-semibold mb-2 text-white">Support Local Growth</h4>
                            <p class="text-white/70 text-base">
                                Our platform adapts to Georgian legal frameworks and business culture — serving real
                                local needs, not abstract SaaS ideals.
                            </p>
                        </div>
                        <div class="bg-white/5 p-6 rounded-xl border border-white/10 backdrop-blur-sm">
                            <h4 class="text-xl font-semibold mb-2 text-white">Modern by Default</h4>
                            <p class="text-white/70 text-base">
                                Built with Laravel 12.x, Tailwind, Alpine.js — we deliver clean, fast, modern solutions
                                without legacy baggage.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- CTA Button -->
                <div>
                    <a href="{{ route('contact') }}"
                        class="inline-block px-6 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-[var(--color-electric-sky)] transition">
                        Contact Us
                    </a>
                </div>
            </div>
        </section>

        <x-footer />
    </div>
</x-layouts.base>