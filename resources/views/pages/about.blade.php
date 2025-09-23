<x-layouts.base :title="__('about.title')">
    <div class="min-h-screen flex flex-col">
        <!-- Hero Section: Who We Are -->
        <section
            class="flex-grow bg-gradient-to-r from-[#0b0f1a] via-[#141d2f] to-[#0b0f1a] text-white px-6 py-24 select-none font-[FiraGO]">
            <div class="container mx-auto max-w-6xl text-center space-y-24">

                <!-- Top: Who We Are -->
                <div class="flex flex-col md:flex-row items-center justify-between gap-12 text-left md:text-start">
                    <div class="md:w-1/2 space-y-6">
                        <h2 class="text-4xl md:text-5xl font-bold tracking-tight leading-tight">
                            {!! __('about.who_we_are.heading') !!}
                        </h2>
                        <p class="text-white/80 text-[17px] leading-relaxed max-w-xl">
                            {{ __('about.who_we_are.paragraph_1') }}
                        </p>
                        <p class="text-white/80 text-[15px] leading-relaxed max-w-xl">
                            {{ __('about.who_we_are.paragraph_2') }}
                        </p>
                    </div>

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

                <!-- Mission Section -->
                <section class="bg-white/5 rounded-xl border border-white/10 shadow-xl px-6 sm:px-10 py-14 space-y-12">
                    <h3 class="text-3xl md:text-4xl font-extrabold tracking-tight text-white text-center">
                        {!! __('about.mission.heading') !!}
                    </h3>

                    <div class="flex flex-col md:flex-row items-center gap-10 md:gap-16 max-w-6xl mx-auto">
                        <!-- Image -->
                        <a href="#"
                            class="flex-shrink-0 w-full md:w-1/2 rounded-lg overflow-hidden shadow-md ring-1 ring-white/10 hover:brightness-105 transition">
                            <img src="https://plus.unsplash.com/premium_photo-1669904022334-e40da006a0a3?q=80&w=869&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                alt="Mission" class="w-full h-full object-cover object-center rounded-lg">
                        </a>

                        <!-- Text -->
                        <div class="w-full md:w-1/2 space-y-6 text-[16px] leading-[1.75] font-[FiraGO]">
                            @foreach (__('about.mission.cards') as $index => $card)
                                <div class="space-y-2">
                                    <h4 class="text-[18px] font-semibold text-white/95">
                                        {{ $card['title'] }}
                                    </h4>
                                    <p class="text-white/70 text-[15px]">
                                        {{ $card['text'] }}
                                    </p>
                                </div>
                                @if ($index < count(__('about.mission.cards')) - 1)
                                    <div class="w-1/2 h-px bg-white/10 mx-auto my-4"></div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </section>

                <!-- Vision Section -->
                <section
                    class="bg-white/5 rounded-xl border border-white/10 shadow-xl px-6 sm:px-10 py-14 space-y-12 mt-24">
                    <h3 class="text-3xl md:text-4xl font-extrabold tracking-tight text-white text-center">
                        {!! __('about.vision.heading') !!}
                    </h3>

                    <div class="flex flex-col md:flex-row items-center gap-10 md:gap-16 max-w-6xl mx-auto">
                        <!-- Image -->
                        <a href="#"
                            class="flex-shrink-0 w-full md:w-1/2 rounded-lg overflow-hidden shadow-md ring-1 ring-white/10 hover:brightness-105 transition">
                            <img src="https://images.unsplash.com/photo-1591696205602-2f950c417cb9?q=80&w=700&auto=format&fit=crop"
                                alt="Vision" class="w-full h-full object-cover object-center rounded-lg">
                        </a>

                        <!-- Text -->
                        <div class="w-full md:w-1/2 space-y-6 text-[16px] leading-[1.75] font-[FiraGO]">
                            <p class="text-white/80 text-[17px] leading-relaxed">
                                {{ __('about.vision.text') }}
                            </p>

                            @foreach ([0, 1, 2] as $i)
                                <div class="space-y-2">
                                    <h4 class="text-[18px] font-semibold text-white/95">
                                        {{ __('about.vision.cards.' . $i . '.title') }}
                                    </h4>
                                    <p class="text-white/70 text-[15px]">
                                        {{ __('about.vision.cards.' . $i . '.text') }}
                                    </p>
                                </div>
                                @if ($i < 2)
                                    <div class="w-1/2 h-px bg-white/10 mx-auto my-4"></div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </section>

                <!-- Management Team Section (Placeholder) -->
                <div>
                    <h3 class="text-3xl md:text-4xl font-bold mb-10">
                        {!! __('about.management.heading') !!}
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 text-left">
                        @foreach ([1, 2, 3] as $i)
                            <div class="bg-white/5 p-6 rounded-xl border border-white/10 shadow-md">
                                <img src="https://images.unsplash.com/photo-1607746882042-944635dfe10e?ixid={{ $i }}&w=300&h=300&fit=crop"
                                    alt="Team Member {{ $i }}"
                                    class="w-24 h-24 rounded-full object-cover mb-4 mx-auto border-2 border-white/20">
                                <div class="text-center space-y-1">
                                    <h4 class="text-[16px] font-semibold text-white">
                                        {{ __('about.management.members.' . $i . '.name') }}</h4>
                                    <p class="text-white/60 text-[14px]">
                                        {{ __('about.management.members.' . $i . '.role') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- CTA -->
                <div>
                    <a href="{{ route('contact') }}"
                        class="inline-block px-6 py-3 border-2 border-white text-white font-medium rounded-lg hover:bg-white hover:text-[var(--color-electric-sky)] transition">
                        {{ __('about.cta') }}
                    </a>
                </div>
        </section>
    </div>
</x-layouts.base>
