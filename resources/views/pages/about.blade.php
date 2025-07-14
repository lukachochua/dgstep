<x-layouts.base :title="__('about.title')">
    <div class="min-h-screen flex flex-col">
        <!-- Hero Section: Who We Are -->
        <section
            class="flex-grow bg-gradient-to-r from-[#0b0f1a] via-[#141d2f] to-[#0b0f1a] text-white px-6 py-24 select-none">
            <div class="container mx-auto max-w-6xl text-center space-y-16">

                <!-- Top: Who We Are -->
                <div class="flex flex-col md:flex-row items-center justify-between gap-12 text-left md:text-start">
                    <!-- Text Content -->
                    <div class="md:w-1/2 space-y-6">
                        <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight leading-tight">
                            {!! __('about.who_we_are.heading') !!}
                        </h2>
                        <p class="text-white/80 text-lg leading-relaxed max-w-xl">
                            {{ __('about.who_we_are.paragraph_1') }}
                        </p>
                        <p class="text-white/80 text-base leading-relaxed max-w-xl">
                            {{ __('about.who_we_are.paragraph_2') }}
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
                        {!! __('about.mission.heading') !!}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left text-white/90">
                        @foreach (__('about.mission.cards') as $card)
                            <div class="bg-white/5 p-6 rounded-xl border border-white/10 backdrop-blur-sm">
                                <h4 class="text-xl font-semibold mb-2 text-white">
                                    {{ $card['title'] }}
                                </h4>
                                <p class="text-white/70 text-base">
                                    {{ $card['text'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- CTA Button -->
                <div>
                    <a href="{{ route('contact') }}"
                        class="inline-block px-6 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-[var(--color-electric-sky)] transition">
                        {{ __('about.cta') }}
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-layouts.base>
