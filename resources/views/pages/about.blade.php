{{-- resources/views/pages/about.blade.php --}}
<x-layouts.base :title="__('about.title')">
    <div class="min-h-screen flex flex-col">
        <style>
            /* Alpine: prevent initial flash */
            [x-cloak] { display: none !important; }

            /* Hide horizontal scrollbar/underbar just for the team strip */
            .team-scroll::-webkit-scrollbar { display: none; }
            .team-scroll { -ms-overflow-style: none; scrollbar-width: none; }
        </style>

        @php
            $locale = app()->getLocale();
            $aboutDefaults = $aboutDefaults ?? \App\Models\AboutPage::defaults();
            $aboutPage = $aboutPage ?? \App\Models\AboutPage::singleton();

            $managementHeading = $aboutPage->translated('management_heading', $locale, $aboutDefaults);
            $managementViewAll = $aboutPage->translated('management_view_all', $locale, $aboutDefaults);
            $managementCollapse = $aboutPage->translated('management_collapse', $locale, $aboutDefaults);
            $managementMembers = $aboutPage->membersForLocale($locale, $aboutDefaults);
        @endphp

        <!-- Page Surface -->
        <section
            class="flex-grow select-none
                   text-[var(--text-default)]
                   bg-[var(--bg-default)]
                   [background-image:linear-gradient(180deg,transparent_0%,transparent_40%,color-mix(in_oklab,var(--color-brand-950)_5%,transparent)_100%)]
                   dark:[background-image:linear-gradient(180deg,color-mix(in_oklab,var(--color-brand-950)_12%,transparent)_0%,transparent_60%,transparent_100%)]
                   py-22 sm:py-22 md:py-28">

            <div class="mx-auto w-full max-w-[var(--container-content)] px-4 sm:px-6 md:px-8 text-center space-y-10 md:space-y-14">

                <!-- WHO WE ARE (reduced glow, cleaner look) -->
                <div class="relative isolate">
                    <div class="pointer-events-none absolute -top-6 right-6 md:right-20 h-24 w-24 md:h-32 md:w-32 rounded-full blur-2xl opacity-20"
                         style="background: color-mix(in oklab, var(--color-electric-sky) 38%, transparent)"></div>

                    <div class="flex flex-col-reverse md:flex-row items-center md:items-start justify-between gap-8 md:gap-10 text-left md:text-start">
                        <!-- Text -->
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

                            <div class="flex flex-wrap gap-2 pt-1.5">
                                <span class="inline-flex items-center gap-1 rounded-full px-3 py-1.5 text-xs font-medium
                                             bg-[color-mix(in_oklab,var(--text-default)_10%,transparent)]/25
                                             border border-[color-mix(in_oklab,var(--text-default)_14%,transparent)]">
                                    <span class="h-1.5 w-1.5 rounded-full" style="background: color-mix(in oklab, var(--color-electric-sky) 80%, transparent)"></span>
                                    Laravel 12.x
                                </span>
                                <span class="inline-flex items-center gap-1 rounded-full px-3 py-1.5 text-xs font-medium
                                             bg-[color-mix(in_oklab,var(--text-default)_10%,transparent)]/25
                                             border border-[color-mix(in_oklab,var(--text-default)_14%,transparent)]">
                                    <span class="h-1.5 w-1.5 rounded-full" style="background: color-mix(in oklab, var(--color-electric-sky) 80%, transparent)"></span>
                                    Tailwind &amp; Alpine.js
                                </span>
                                <span class="inline-flex items-center gap-1 rounded-full px-3 py-1.5 text-xs font-medium
                                             bg-[color-mix(in_oklab,var(--text-default)_10%,transparent)]/25
                                             border border-[color-mix(in_oklab,var(--text-default)_14%,transparent)]">
                                    <span class="h-1.5 w-1.5 rounded-full" style="background: color-mix(in oklab, var(--color-electric-sky) 80%, transparent)"></span>
                                    SMB &amp; Pawn Ops
                                </span>
                            </div>
                        </div>

                        <!-- Visual -->
                        <div class="md:w-[45%] flex items-center justify-center md:justify-end">
                            <div class="relative">
                                <div class="absolute inset-0 -m-1.5 rounded-[1.6rem] p-[1.5px]
                                            [background:conic-gradient(from_140deg_at_50%_50%,_transparent_0deg,_color-mix(in_oklab,var(--color-electric-sky)_70%,transparent)_150deg,_transparent_320deg)]">
                                    <div class="h-full w-full rounded-[1.6rem] bg-[var(--bg-elevated)]"></div>
                                </div>

                                <div class="relative rounded-[1.4rem] overflow-hidden shadow-[0_16px_44px_rgba(0,0,0,.28)]
                                            bg-[var(--bg-elevated)]
                                            border border-[color-mix(in_oklab,var(--text-default)_10%,transparent)]
                                            w-[min(100%,460px)]">
                                    <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?q=80&w=1200&auto=format&fit=crop"
                                         alt="Team working"
                                         loading="eager" fetchpriority="high"
                                         class="h-64 md:h-[19rem] w-full object-cover object-center" />
                                    <div class="flex items-center justify-between px-4 py-2.5
                                                bg-[color-mix(in_oklab,var(--text-default)_6%,transparent)]/35
                                                border-t border-[color-mix(in_oklab,var(--text-default)_10%,transparent)]">
                                        <div class="text-[11px] text-[color-mix(in_oklab,var(--text-default)_70%,transparent)]">
                                            DGstep • SaaS for regulated services
                                        </div>
                                        <div class="inline-flex items-center gap-1.5 text-[11px] font-semibold
                                                    text-[color-mix(in_oklab,var(--text-default)_90%,transparent)]">
                                            <span class="h-1.5 w-1.5 rounded-full" style="background: color-mix(in oklab, var(--color-electric-sky) 80%, transparent)"></span>
                                            Live
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 md:mt-14">
                        <div class="h-px w-full bg-gradient-to-r from-transparent via-[color-mix(in_oklab,var(--color-electric-sky)_28%,transparent)] to-transparent opacity-60"></div>
                    </div>
                </div>

                <!-- Mission & Vision -->
                <section class="card px-6 sm:px-8 py-10 sm:py-12 bg-[var(--bg-elevated)]">
                    <div class="mx-auto max-w-4xl text-left space-y-8">
                        <div class="space-y-2.5">
                            <h3 class="text-xs font-semibold tracking-[0.35em] uppercase text-[color-mix(in_oklab,var(--text-default)_65%,transparent)]">
                                {{ __('about.mission.label') }}
                            </h3>
                            <p class="text-[17px] md:text-[18px] leading-relaxed text-[color-mix(in_oklab,var(--text-default)_82%,transparent)]">
                                {!! __('about.mission.description') !!}
                            </p>
                        </div>

                        <div class="pt-5 md:pt-6 border-t border-[color-mix(in_oklab,var(--text-default)_12%,transparent)] space-y-2.5">
                            <h3 class="text-xs font-semibold tracking-[0.35em] uppercase text-[color-mix(in_oklab,var(--text-default)_65%,transparent)]">
                                {{ __('about.vision.label') }}
                            </h3>
                            <p class="text-[17px] md:text-[18px] leading-relaxed text-[color-mix(in_oklab,var(--text-default)_82%,transparent)]">
                                {!! __('about.vision.description') !!}
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Management Team — horizontal only + animated View all -->
                <section
                    x-data="{
                        canLeft:false,
                        canRight:false,
                        openAll:false,
                        switcherHeight:'auto',
                        heightTimer:null,
                        toggleAll(state){
                            if (this.openAll === state) return;
                            this.lockHeight();
                            this.openAll = state;
                            this.syncHeight();
                            if (!state && this.$refs.strip) {
                                this.$refs.strip.scrollLeft = 0;
                            }
                            requestAnimationFrame(() => this.updateArrows());
                        },
                        lockHeight(){
                            const current = this.openAll ? this.$refs.gridWrap : this.$refs.stripWrap;
                            if (!current) return;
                            const height = current.offsetHeight;
                            if (height) {
                                this.switcherHeight = `${height}px`;
                            }
                        },
                        syncHeight(){
                            this.$nextTick(() => {
                                const target = this.openAll ? this.$refs.gridWrap : this.$refs.stripWrap;
                                if (!target) return;
                                const height = target.offsetHeight;
                                if (!height) return;
                                this.switcherHeight = `${height}px`;
                                clearTimeout(this.heightTimer);
                                this.heightTimer = setTimeout(() => {
                                    this.switcherHeight = 'auto';
                                    this.heightTimer = null;
                                }, 360);
                                if (!this.openAll) {
                                    requestAnimationFrame(() => this.updateArrows());
                                }
                            });
                        },
                        updateArrows(){
                            const el = this.$refs.strip;
                            if (!el || this.openAll) {
                                this.canLeft = false;
                                this.canRight = false;
                                return;
                            }
                            const max = Math.max(0, el.scrollWidth - el.clientWidth);
                            this.canLeft  = el.scrollLeft > 2;
                            this.canRight = el.scrollLeft < (max - 2);
                        },
                        init(){
                            const el = this.$refs.strip;
                            if (el) {
                                el.addEventListener('scroll', () => this.updateArrows(), { passive:true });
                            }
                            addEventListener('resize', () => {
                                this.syncHeight();
                                this.updateArrows();
                            });
                            this.$nextTick(() => {
                                this.syncHeight();
                                this.updateArrows();
                                setTimeout(() => {
                                    this.syncHeight();
                                    this.updateArrows();
                                }, 260);
                            });
                            this.$watch('openAll', () => {
                                this.syncHeight();
                                requestAnimationFrame(() => this.updateArrows());
                            });
                        },
                        nudge(px){ this.$refs.strip?.scrollBy({ left:px, behavior:'smooth' }); }
                    }"
                    class="relative"
                >
                    <h3 class="text-3xl md:text-4xl font-bold mb-4 text-[var(--text-default)]">
                        {!! $managementHeading ?? __('about.management.heading') !!}
                    </h3>

                    <!-- Strip/Grid switcher (height-locked to avoid layout jump) -->
                    <div class="relative overflow-hidden rounded-lg transition-[height] duration-300 ease-out"
                         :style="switcherHeight ? { height: switcherHeight } : null">
                        <!-- Slider viewport -->
                        <div x-ref="stripWrap" x-cloak
                             x-show="!openAll"
                             x-transition.opacity.duration.200ms
                             x-transition:leave.opacity.duration.0ms
                             class="transition duration-300 ease-out"
                             :class="openAll ? 'pointer-events-none' : 'pointer-events-auto'">
                            {{-- Limit the slider viewport to roughly three cards on wide screens --}}
                            <div class="relative h-full mx-auto w-full max-w-[59.5rem]">
                                <!-- Left fade + arrow -->
                                <div x-show="canLeft && !openAll" x-cloak x-transition.opacity
                                     class="pointer-events-none absolute inset-y-0 left-0 w-14 bg-gradient-to-r from-[color-mix(in_oklab,var(--bg-default)_85%,transparent)] to-transparent"
                                     aria-hidden="true"></div>
                                <button type="button" x-show="canLeft && !openAll" x-cloak x-transition.opacity
                                        @click="nudge(-320)"
                                        class="absolute left-2 top-1/2 -translate-y-1/2 z-10 inline-flex h-10 w-10 items-center justify-center rounded-full border
                                               backdrop-blur bg-white/10 dark:bg-black/20
                                               border-[color-mix(in_oklab,var(--text-default)_14%,transparent)]
                                               shadow-[0_8px_24px_rgba(0,0,0,.2)] hover:scale-[1.03] transition"
                                        aria-label="Scroll left">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" style="color:#5B56D6"><path fill="currentColor" d="M14.71 6.71a1 1 0 0 0-1.41 0L8.71 11.3a1 1 0 0 0 0 1.41l4.59 4.59a1 1 0 1 0 1.41-1.41L10.83 12l3.88-3.88a1 1 0 0 0 0-1.41Z"/></svg>
                                </button>

                                <!-- Right fade + arrow -->
                                <div x-show="canRight && !openAll" x-cloak x-transition.opacity
                                     class="pointer-events-none absolute inset-y-0 right-0 w-14 bg-gradient-to-l from-[color-mix(in_oklab,var(--bg-default)_85%,transparent)] to-transparent"
                                     aria-hidden="true"></div>
                                <button type="button" x-show="canRight && !openAll" x-cloak x-transition.opacity
                                        @click="nudge(320)"
                                        class="absolute right-2 top-1/2 -translate-y-1/2 z-10 inline-flex h-10 w-10 items-center justify-center rounded-full border
                                               backdrop-blur bg-white/10 dark:bg-black/20
                                               border-[color-mix(in_oklab,var(--text-default)_14%,transparent)]
                                               shadow-[0_8px_24px_rgba(0,0,0,.2)] hover:scale-[1.03] transition"
                                        aria-label="Scroll right">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" style="color:#5B56D6"><path fill="currentColor" d="M9.29 6.71a1 1 0 0 1 1.41 0l4.59 4.59a1 1 0 0 1 0 1.41l-4.59 4.59a1 1 0 1 1-1.41-1.41L13.17 12 9.29 8.12a1 1 0 0 1 0-1.41Z"/></svg>
                                </button>

                                <!-- Strip (horizontal only; vertical hidden) -->
                                <div x-ref="strip"
                                     class="team-scroll overflow-x-auto overflow-y-hidden overscroll-contain w-full
                                            [scrollbar-color:transparent_transparent] [scrollbar-gutter:stable] pr-6
                                            transition duration-300 ease-out"
                                     tabindex="0">
                                    <ul class="flex gap-6 snap-x snap-mandatory scroll-pl-1 px-2 py-1 -mb-2">
                                        @forelse ($managementMembers as $index => $member)
                                            @php
                                                $memberName = $member['name'] ?? __('Team member');
                                                $memberRole = $member['role'] ?? '';
                                                $memberImage = $member['image_url'] ?? 'https://images.unsplash.com/photo-1607746882042-944635dfe10e?w=300&h=300&fit=crop';
                                            @endphp
                                            <li class="snap-start shrink-0 w-[min(85vw,18rem)]">
                                                <div class="card p-5 h-full">
                                                    <img src="{{ $memberImage }}"
                                                         alt="{{ $memberName }}"
                                                         class="w-20 h-20 md:w-24 md:h-24 rounded-full object-cover mb-3 mx-auto
                                                                border border-[color-mix(in_oklab,var(--text-default)_18%,transparent)]">
                                                    <div class="text-center space-y-0.5">
                                                        <h4 class="text-[15px] md:text-[16px] font-semibold text-[var(--text-default)]">
                                                            {{ $memberName }}
                                                        </h4>
                                                        <p class="text-[13px] md:text-[14px] text-[color-mix(in_oklab,var(--text-default)_62%,transparent)]">
                                                            {{ $memberRole }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="snap-start shrink-0 w-[min(85vw,18rem)]">
                                                <div class="card p-5 h-full text-center text-sm text-[color-mix(in_oklab,var(--text-default)_62%,transparent)]">
                                                    {{ __('No team members found.') }}
                                                </div>
                                            </li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Expanded grid -->
                        <div x-ref="gridWrap" x-cloak
                             x-show="openAll"
                             x-transition.opacity.duration.250ms
                             class="transition duration-300 ease-out"
                             :class="openAll ? 'pointer-events-auto' : 'pointer-events-none'">
                            <div class="mt-2">
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 text-left" data-team-grid>
                                    @forelse ($managementMembers as $index => $member)
                                        @php
                                            $memberName = $member['name'] ?? __('Team member');
                                            $memberRole = $member['role'] ?? '';
                                            $memberImage = $member['image_url'] ?? 'https://images.unsplash.com/photo-1607746882042-944635dfe10e?w=300&h=300&fit=crop';
                                        @endphp
                                        <div class="card p-5 transition duration-300 ease-out transform"
                                             :class="openAll ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3'"
                                             style="transition-delay: {{ $loop->index * 45 }}ms">
                                            <img src="{{ $memberImage }}"
                                                 alt="{{ $memberName }}"
                                                 class="w-20 h-20 md:w-24 md:h-24 rounded-full object-cover mb-3 mx-auto
                                                        border border-[color-mix(in_oklab,var(--text-default)_18%,transparent)]">
                                            <div class="text-center space-y-0.5">
                                                <h4 class="text-[15px] md:text-[16px] font-semibold text-[var(--text-default)]">
                                                    {{ $memberName }}
                                                </h4>
                                                <p class="text-[13px] md:text-[14px] text-[color-mix(in_oklab,var(--text-default)_62%,transparent)]">
                                                    {{ $memberRole }}
                                                </p>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="card p-5 text-center text-sm text-[color-mix(in_oklab,var(--text-default)_62%,transparent)]">
                                            {{ __('No team members found.') }}
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-3 flex items-center justify-center gap-4">
                        <x-ui.button
                            as="button"
                            type="button"
                            size="sm"
                            variant="secondary"
                            class="font-semibold"
                            x-show="!openAll"
                            x-cloak
                            @click="toggleAll(true)"
                        >
                            {{ $managementViewAll ?? __('about.management.view_all') }}
                        </x-ui.button>
                        <x-ui.button
                            as="button"
                            type="button"
                            size="sm"
                            variant="secondary"
                            class="font-medium shadow-sm hover:shadow-md"
                            x-show="openAll"
                            x-cloak
                            @click="toggleAll(false)"
                        >
                            {{ $managementCollapse ?? __('about.management.collapse') }}
                        </x-ui.button>
                    </div>

                    <!-- Expanded grid handled inside switcher -->
                </section>

                <!-- CTA intentionally removed -->
            </div>
        </section>
    </div>
</x-layouts.base>
