<x-layouts.base :title="__('about.title')">
    <div class="min-h-screen flex flex-col">

        <!-- Hero / Page Surface -->
        <section
            class="flex-grow select-none
                   text-[var(--text-default)]
                   bg-[var(--bg-default)]
                   [background-image:linear-gradient(180deg,transparent_0%,transparent_40%,color-mix(in_oklab,var(--color-brand-950)_6%,transparent)_100%)] dark:[background-image:linear-gradient(180deg,color-mix(in_oklab,var(--color-brand-950)_16%,transparent)_0%,transparent_60%,transparent_100%)]
                   px-6 py-16 sm:py-20 md:py-24">

            <div class="container mx-auto max-w-6xl text-center space-y-24">

                <!-- Top: Who We Are -->
                <div class="flex flex-col md:flex-row items-center justify-between gap-12 text-left md:text-start">
                    <!-- Left text -->
                    <div class="md:w-1/2 space-y-6">
                        <h2 class="text-4xl md:text-5xl font-bold tracking-tight leading-tight text-[var(--text-default)]">
                            {!! __('about.who_we_are.heading') !!}
                        </h2>
                        <p class="text-[17px] leading-relaxed max-w-xl text-[color-mix(in_oklab,var(--text-default)_78%,transparent)]">
                            {{ __('about.who_we_are.paragraph_1') }}
                        </p>
                        <p class="text-[15px] leading-relaxed max-w-xl text-[color-mix(in_oklab,var(--text-default)_64%,transparent)]">
                            {{ __('about.who_we_are.paragraph_2') }}
                        </p>
                    </div>

                    <!-- Right visuals -->
                    <div class="md:w-1/2 flex flex-col items-center gap-6">
                        <div class="aspect-square w-52 rounded-full overflow-hidden border border-[color-mix(in_oklab,var(--text-default)_12%,transparent)] shadow-[0_10px_24px_rgba(0,0,0,.25)] bg-[var(--bg-elevated)]">
                            <img
                                src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?q=80&w=400&auto=format&fit=crop"
                                alt="Team working"
                                class="w-full h-full object-cover object-center" />
                        </div>

                        <!-- Brand totem -->
                        <div class="w-20 h-32 rounded-[1.25rem] grid place-items-center shadow-brand
                                    bg-[var(--color-brand-500)] dark:bg-[var(--color-electric-sky)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-black/90" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M13 2L3 14h9l-1 8L21 10h-9l1-8z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Mission -->
                <section class="card px-6 sm:px-10 py-12 sm:py-14 space-y-10">
                    <h3 class="text-3xl md:text-4xl font-extrabold tracking-tight text-[var(--text-default)] text-center">
                        {!! __('about.mission.heading') !!}
                    </h3>

                    <div class="flex flex-col md:flex-row items-center gap-10 md:gap-16 max-w-6xl mx-auto">
                        <!-- Image -->
                        <a href="#"
                           class="flex-shrink-0 w-full md:w-1/2 rounded-xl overflow-hidden shadow-[0_12px_24px_rgba(0,0,0,.25)]
                                  border border-[color-mix(in_oklab,var(--text-default)_12%,transparent)]
                                  hover:brightness-105 transition">
                            <img
                                src="https://plus.unsplash.com/premium_photo-1669904022334-e40da006a0a3?q=80&w=869&auto=format&fit=crop&ixlib=rb-4.1.0"
                                alt="Mission"
                                class="w-full h-full object-cover object-center">
                        </a>

                        <!-- Text -->
                        <div class="w-full md:w-1/2 space-y-6 text-[16px] leading-[1.75]">
                            @foreach (__('about.mission.cards') as $index => $card)
                                <div class="space-y-2">
                                    <h4 class="text-[18px] font-semibold text-[color-mix(in_oklab,var(--text-default)_90%,transparent)]">
                                        {{ $card['title'] }}
                                    </h4>
                                    <p class="text-[15px] text-[color-mix(in_oklab,var(--text-default)_68%,transparent)]">
                                        {{ $card['text'] }}
                                    </p>
                                </div>
                                @if ($index < count(__('about.mission.cards')) - 1)
                                    <div class="w-1/2 h-px mx-auto my-4 bg-[color-mix(in_oklab,var(--text-default)_10%,transparent)]"></div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </section>

                <!-- Vision -->
                <section class="card px-6 sm:px-10 py-12 sm:py-14 space-y-10 mt-6 md:mt-24">
                    <h3 class="text-3xl md:text-4xl font-extrabold tracking-tight text-[var(--text-default)] text-center">
                        {!! __('about.vision.heading') !!}
                    </h3>

                    <div class="flex flex-col md:flex-row items-center gap-10 md:gap-16 max-w-6xl mx-auto">
                        <!-- Image -->
                        <a href="#"
                           class="flex-shrink-0 w-full md:w-1/2 rounded-xl overflow-hidden shadow-[0_12px_24px_rgba(0,0,0,.25)]
                                  border border-[color-mix(in_oklab,var(--text-default)_12%,transparent)]
                                  hover:brightness-105 transition">
                            <img
                                src="https://images.unsplash.com/photo-1591696205602-2f950c417cb9?q=80&w=700&auto=format&fit=crop"
                                alt="Vision"
                                class="w-full h-full object-cover object-center">
                        </a>

                        <!-- Text -->
                        <div class="w-full md:w-1/2 space-y-6 text-[16px] leading-[1.75]">
                            <p class="text-[17px] leading-relaxed text-[color-mix(in_oklab,var(--text-default)_78%,transparent)]">
                                {{ __('about.vision.text') }}
                            </p>

                            @foreach ([0, 1, 2] as $i)
                                <div class="space-y-2">
                                    <h4 class="text-[18px] font-semibold text-[color-mix(in_oklab,var(--text-default)_90%,transparent)]">
                                        {{ __('about.vision.cards.' . $i . '.title') }}
                                    </h4>
                                    <p class="text-[15px] text-[color-mix(in_oklab,var(--text-default)_68%,transparent)]">
                                        {{ __('about.vision.cards.' . $i . '.text') }}
                                    </p>
                                </div>
                                @if ($i < 2)
                                    <div class="w-1/2 h-px mx-auto my-4 bg-[color-mix(in_oklab,var(--text-default)_10%,transparent)]"></div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </section>

                <!-- Management Team -->
                <div>
                    <h3 class="text-3xl md:text-4xl font-bold mb-10 text-[var(--text-default)]">
                        {!! __('about.management.heading') !!}
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 text-left">
                        @foreach ([1, 2, 3] as $i)
                            <div class="card p-6">
                                <img
                                    src="https://images.unsplash.com/photo-1607746882042-944635dfe10e?ixid={{ $i }}&w=300&h=300&fit=crop"
                                    alt="Team Member {{ $i }}"
                                    class="w-24 h-24 rounded-full object-cover mb-4 mx-auto
                                           border border-[color-mix(in_oklab,var(--text-default)_18%,transparent)]">
                                <div class="text-center space-y-1">
                                    <h4 class="text-[16px] font-semibold text-[var(--text-default)]">
                                        {{ __('about.management.members.' . $i . '.name') }}
                                    </h4>
                                    <p class="text-[14px] text-[color-mix(in_oklab,var(--text-default)_62%,transparent)]">
                                        {{ __('about.management.members.' . $i . '.role') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- CTA -->
                <div class="pt-2">
                    <a href="{{ route('contact') }}"
                       class="btn btn-md btn-primary">
                        {{ __('about.cta') }}
                    </a>
                </div>

            </div>
        </section>
    </div>
</x-layouts.base>
