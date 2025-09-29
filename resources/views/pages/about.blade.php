<x-layouts.base :title="__('about.title')">
    <div class="min-h-screen flex flex-col">

        <!-- Page Surface -->
        <section
            class="flex-grow select-none
                   text-[var(--text-default)]
                   bg-[var(--bg-default)]
                   [background-image:linear-gradient(180deg,transparent_0%,transparent_40%,color-mix(in_oklab,var(--color-brand-950)_6%,transparent)_100%)] dark:[background-image:linear-gradient(180deg,color-mix(in_oklab,var(--color-brand-950)_16%,transparent)_0%,transparent_60%,transparent_100%)]
                   py-10 sm:py-12 md:py-28">

            <!-- Match navbar width + paddings -->
            <div class="mx-auto w-full max-w-[var(--container-content)] px-4 sm:px-6 md:px-8 text-center space-y-12 md:space-y-16">

                <!-- ─────────────────────────────────────────────────────────────
                     WHO WE ARE — tighter vertical rhythm + balanced centering
                ────────────────────────────────────────────────────────────── -->
                <div class="relative isolate">
                    <!-- soft glow accent behind the photo -->
                    <div class="pointer-events-none absolute -top-10 right-6 md:right-20 h-36 w-36 md:h-48 md:w-48 rounded-full blur-3xl opacity-35"
                         style="background: color-mix(in oklab, var(--color-electric-sky) 48%, transparent);"></div>

                    <div class="flex flex-col-reverse md:flex-row items-center md:items-start justify-between gap-8 md:gap-10 text-left md:text-start">
                        <!-- Left: Text block -->
                        <div class="md:w-[55%] space-y-5">
                            <div class="space-y-2.5">
                                <h2 class="text-4xl md:text-5xl font-bold tracking-tight leading-tight text-[var(--text-default)]">
                                    {!! __('about.who_we_are.heading') !!}
                                </h2>
                                <p class="text-[17px] leading-relaxed text-[color-mix(in_oklab,var(--text-default)_78%,transparent)] max-w-prose">
                                    {!! __('about.who_we_are.paragraph_1') !!}
                                </p>
                                <p class="text-[15px] leading-relaxed text-[color-mix(in_oklab,var(--text-default)_64%,transparent)] max-w-prose">
                                    {!! __('about.who_we_are.paragraph_2') !!}
                                </p>
                            </div>

                            <!-- small feature chips for visual rhythm -->
                            <div class="flex flex-wrap gap-2 pt-1.5">
                                <span class="inline-flex items-center gap-1 rounded-full px-3 py-1.5 text-xs font-medium
                                             bg-[color-mix(in_oklab,var(--text-default)_10%,transparent)]/30
                                             border border-[color-mix(in_oklab,var(--text-default)_16%,transparent)]">
                                    <span class="h-1.5 w-1.5 rounded-full"
                                          style="background: color-mix(in oklab, var(--color-electric-sky) 88%, transparent)"></span>
                                    Laravel 12.x
                                </span>
                                <span class="inline-flex items-center gap-1 rounded-full px-3 py-1.5 text-xs font-medium
                                             bg-[color-mix(in_oklab,var(--text-default)_10%,transparent)]/30
                                             border border-[color-mix(in_oklab,var(--text-default)_16%,transparent)]">
                                    <span class="h-1.5 w-1.5 rounded-full"
                                          style="background: color-mix(in oklab, var(--color-electric-sky) 88%, transparent)"></span>
                                    Tailwind &amp; Alpine.js
                                </span>
                                <span class="inline-flex items-center gap-1 rounded-full px-3 py-1.5 text-xs font-medium
                                             bg-[color-mix(in_oklab,var(--text-default)_10%,transparent)]/30
                                             border border-[color-mix(in_oklab,var(--text-default)_16%,transparent)]">
                                    <span class="h-1.5 w-1.5 rounded-full"
                                          style="background: color-mix(in oklab, var(--color-electric-sky) 88%, transparent)"></span>
                                    SMB &amp; Pawn Ops
                                </span>
                            </div>
                        </div>

                        <!-- Right: Visual block (elevated portrait with ring) -->
                        <div class="md:w-[45%] flex items-center justify-center md:justify-end">
                            <div class="relative">
                                <!-- gradient ring -->
                                <div class="absolute inset-0 -m-2 rounded-[2rem] p-[2px]
                                            [background:conic-gradient(from_140deg_at_50%_50%,_transparent_0deg,_color-mix(in_oklab,var(--color-electric-sky)_85%,transparent)_140deg,_transparent_320deg)]">
                                    <div class="h-full w-full rounded-[2rem] bg-[var(--bg-elevated)]"></div>
                                </div>

                                <!-- card -->
                                <div class="relative rounded-[1.6rem] overflow-hidden shadow-[0_16px_44px_rgba(0,0,0,.32)]
                                            bg-[var(--bg-elevated)]
                                            border border-[color-mix(in_oklab,var(--text-default)_12%,transparent)]
                                            w-[min(100%,460px)]">
                                    <img
                                        src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?q=80&w=1200&auto=format&fit=crop"
                                        alt="Team working"
                                        class="h-64 md:h-[19rem] w-full object-cover object-center" />
                                    <!-- subtle footer bar -->
                                    <div class="flex items-center justify-between px-4 py-2.5
                                                bg-[color-mix(in_oklab,var(--text-default)_6%,transparent)]/40
                                                border-t border-[color-mix(in_oklab,var(--text-default)_12%,transparent)]">
                                        <div class="text-[11px] text-[color-mix(in_oklab,var(--text-default)_70%,transparent)]">
                                            DGstep • SaaS for regulated services
                                        </div>
                                        <div class="inline-flex items-center gap-1.5 text-[11px] font-semibold
                                                    text-[color-mix(in_oklab,var(--text-default)_92%,transparent)]">
                                            <span class="h-1.5 w-1.5 rounded-full"
                                                  style="background: color-mix(in oklab, var(--color-electric-sky) 86%, transparent)"></span>
                                            Live
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- hairline divider aligning to content width -->
                    <div class="mt-10 md:mt-14">
                        <div class="h-px w-full bg-gradient-to-r from-transparent via-[color-mix(in_oklab,var(--color-electric-sky)_35%,transparent)] to-transparent opacity-70"></div>
                    </div>
                </div>

                <!-- ─────────────────────────────────────────────────────────────
                     Mission / Vision (unified Alpine card)
                ────────────────────────────────────────────────────────────── -->
                <section
                    x-data="{ tab: 'mission' }"
                    class="card px-6 sm:px-8 py-10 sm:py-12 space-y-4 md:space-y-5">

                    <!-- Tabs -->
                    <div class="flex items-center justify-center">
                        <div class="inline-flex items-center rounded-full border
                                    border-[color-mix(in_oklab,var(--text-default)_14%,transparent)]
                                    bg-[color-mix(in_oklab,var(--bg-elevated)_82%,transparent)]/70
                                    backdrop-blur px-1.5 py-1 shadow-[inset_0_1px_0_rgba(255,255,255,.05)]">
                            <button
                                type="button"
                                class="min-w-24 px-3.5 py-1.5 rounded-full text-[13px] md:text-sm font-medium tracking-tight transition focus-ring
                                       data-[active=true]:bg-[color-mix(in_oklab,var(--color-electric-sky)_30%,transparent)]
                                       data-[active=true]:text-black data-[active=true]:shadow-sm
                                       hover:text-[var(--text-default)]
                                       text-[color-mix(in_oklab,var(--text-default)_78%,transparent)]"
                                :data-active="(tab==='mission')"
                                @click="tab='mission'"
                                aria-controls="panel-mission"
                            >{!! __('about.mission.heading') !!}</button>

                            <button
                                type="button"
                                class="min-w-24 px-3.5 py-1.5 rounded-full text-[13px] md:text-sm font-medium tracking-tight transition focus-ring
                                       data-[active=true]:bg-[color-mix(in_oklab,var(--color-electric-sky)_30%,transparent)]
                                       data-[active=true]:text-black data-[active=true]:shadow-sm
                                       hover:text-[var(--text-default)]
                                       text-[color-mix(in_oklab,var(--text-default)_78%,transparent)]"
                                :data-active="(tab==='vision')"
                                @click="tab='vision'"
                                aria-controls="panel-vision"
                            >{!! __('about.vision.heading') !!}</button>
                        </div>
                    </div>

                    <!-- Titles (preserve HTML in translations) -->
                    <div class="text-center">
                        <h3 x-show="tab==='mission'" x-cloak
                            class="text-[26px] md:text-[32px] font-extrabold tracking-tight text-[var(--text-default)]">
                            {!! __('about.mission.heading') !!}
                        </h3>
                        <h3 x-show="tab==='vision'" x-cloak
                            class="text-[26px] md:text-[32px] font-extrabold tracking-tight text-[var(--text-default)]">
                            {!! __('about.vision.heading') !!}
                        </h3>
                    </div>

                    <!-- Panels -->
                    <div class="max-w-6xl mx-auto">
                        <!-- Mission -->
                        <div id="panel-mission"
                             x-show="tab==='mission'" x-cloak x-transition.opacity
                             class="flex flex-col md:flex-row items-center gap-8 md:gap-12">
                            <a href="#"
                               class="flex-shrink-0 w-full md:w-1/2 rounded-xl overflow-hidden shadow-[0_12px_24px_rgba(0,0,0,.25)]
                                      border border-[color-mix(in_oklab,var(--text-default)_12%,transparent)]
                                      hover:brightness-105 transition">
                                <img
                                    src="https://plus.unsplash.com/premium_photo-1669904022334-e40da006a0a3?q=80&w=1200&auto=format&fit=crop&ixlib=rb-4.1.0"
                                    alt="Mission"
                                    class="w-full h-full object-cover object-center">
                            </a>

                            <div class="w-full md:w-1/2 space-y-5 text-[16px] leading-[1.75] text-left">
                                @php $missionCards = __('about.mission.cards'); @endphp
                                @foreach ($missionCards as $index => $card)
                                    <div class="space-y-1.5">
                                        <h4 class="text-[17px] md:text-[18px] font-semibold text-[color-mix(in_oklab,var(--text-default)_90%,transparent)]">
                                            {!! $card['title'] !!}
                                        </h4>
                                        <p class="text-[14.5px] md:text-[15px] text-[color-mix(in_oklab,var(--text-default)_68%,transparent)]">
                                            {!! $card['text'] !!}
                                        </p>
                                    </div>
                                    @if ($index < count($missionCards) - 1)
                                        <div class="w-3/5 h-px mx-auto my-3 bg-[color-mix(in_oklab,var(--text-default)_10%,transparent)]"></div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Vision -->
                        <div id="panel-vision"
                             x-show="tab==='vision'" x-cloak x-transition.opacity
                             class="flex flex-col md:flex-row items-center gap-8 md:gap-12">
                            <a href="#"
                               class="flex-shrink-0 w-full md:w-1/2 rounded-xl overflow-hidden shadow-[0_12px_24px_rgba(0,0,0,.25)]
                                      border border-[color-mix(in_oklab,var(--text-default)_12%,transparent)]
                                      hover:brightness-105 transition">
                                <img
                                    src="https://images.unsplash.com/photo-1591696205602-2f950c417cb9?q=80&w=1000&auto=format&fit=crop"
                                    alt="Vision"
                                    class="w-full h-full object-cover object-center">
                            </a>

                            <div class="w-full md:w-1/2 space-y-5 text-[16px] leading-[1.75] text-left">
                                <p class="text-[16px] md:text-[17px] leading-relaxed text-[color-mix(in_oklab,var(--text-default)_78%,transparent)]">
                                    {!! __('about.vision.text') !!}
                                </p>

                                @foreach ([0, 1, 2] as $i)
                                    <div class="space-y-1.5">
                                        <h4 class="text-[17px] md:text-[18px] font-semibold text-[color-mix(in_oklab,var(--text-default)_90%,transparent)]">
                                            {!! __('about.vision.cards.' . $i . '.title') !!}
                                        </h4>
                                        <p class="text-[14.5px] md:text-[15px] text-[color-mix(in_oklab,var(--text-default)_68%,transparent)]">
                                            {!! __('about.vision.cards.' . $i . '.text') !!}
                                        </p>
                                    </div>
                                    @if ($i < 2)
                                        <div class="w-3/5 h-px mx-auto my-3 bg-[color-mix(in_oklab,var(--text-default)_10%,transparent)]"></div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ─────────────────────────────────────────────────────────────
                     Management Team
                ────────────────────────────────────────────────────────────── -->
                <div>
                    <h3 class="text-3xl md:text-4xl font-bold mb-6 text-[var(--text-default)]">
                        {!! __('about.management.heading') !!}
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 text-left">
                        @foreach ([1, 2, 3] as $i)
                            <div class="card p-5">
                                <img
                                    src="https://images.unsplash.com/photo-1607746882042-944635dfe10e?ixid={{ $i }}&w=300&h=300&fit=crop"
                                    alt="Team Member {{ $i }}"
                                    class="w-20 h-20 md:w-24 md:h-24 rounded-full object-cover mb-3 mx-auto
                                           border border-[color-mix(in_oklab,var(--text-default)_18%,transparent)]">
                                <div class="text-center space-y-0.5">
                                    <h4 class="text-[15px] md:text-[16px] font-semibold text-[var(--text-default)]">
                                        {{ __('about.management.members.' . $i . '.name') }}
                                    </h4>
                                    <p class="text-[13px] md:text-[14px] text-[color-mix(in_oklab,var(--text-default)_62%,transparent)]">
                                        {{ __('about.management.members.' . $i . '.role') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- CTA -->
                <div class="pt-1">
                    <a href="{{ route('contact') }}" class="btn btn-md btn-primary">
                        {{ __('about.cta') }}
                    </a>
                </div>

            </div>
        </section>
    </div>
</x-layouts.base>
