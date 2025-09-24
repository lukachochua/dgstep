<x-layouts.base :title="__('services.title')">
    <div class="min-h-screen flex flex-col">

        <section
            class="flex-grow select-none
                   text-[var(--text-default)]
                   bg-[var(--bg-default)]
                   [background-image:linear-gradient(180deg,transparent_0%,transparent_40%,color-mix(in_oklab,var(--color-brand-950)_6%,transparent)_100%)]
                   dark:[background-image:linear-gradient(180deg,color-mix(in_oklab,var(--color-brand-950)_16%,transparent)_0%,transparent_60%,transparent_100%)]
                   py-16 sm:py-20 md:py-24">
            <div class="container mx-auto max-w-6xl px-4 sm:px-6 md:px-8 space-y-24 text-center">

                @php
                    /**
                     * Render the “problem circle” layout using theme tokens.
                     * - No hard-coded white/black; uses var(--*) + color-mix for borders/ink.
                     * - Brand accent bubbles alternate with neutral bubbles for contrast.
                     */
                    function renderProblemCircleLayout($title, $problems)
                    {
                        $angles = [45, 135, 225, 315]; // TR, TL, BL, BR
                        $radius = 260;

                        $html  = '<div class="relative max-w-5xl mx-auto h-[660px] mt-6">';

                        // Arrows (curved) — use electric-sky with opacity
                        $arrowCoords = [
                            [640, 120, 570, 190],
                            [360, 120, 430, 190],
                            [360, 440, 430, 370],
                            [640, 440, 570, 370],
                        ];
                        $html .= '<svg class="absolute left-0 top-0 w-full h-full pointer-events-none z-0" viewBox="0 0 1000 600">';
                        foreach ($arrowCoords as [$x, $y, $cx, $cy]) {
                            $html .= '<path d="M500,280 Q' . $cx . ',' . $cy . ' ' . $x . ',' . $y . '"
                                       stroke="color-mix(in oklab, var(--color-electric-sky) 65%, transparent)"
                                       stroke-width="1.8" fill="none" stroke-linecap="round" />';
                        }
                        $html .= '</svg>';

                        // Center chip
                        $html .= '
                            <div class="absolute top-1/2 left-1/2 w-52 h-52 rounded-full
                                        bg-[var(--bg-elevated)]
                                        text-[var(--color-electric-sky)]
                                        font-semibold text-center text-base
                                        ring-[16px] ring-[color-mix(in_oklab,var(--text-default)_6%,transparent)]
                                        border border-[color-mix(in_oklab,var(--text-default)_16%,transparent)]
                                        shadow-[0_14px_28px_rgba(0,0,0,.25)]
                                        flex items-center justify-center transform -translate-x-1/2 -translate-y-1/2 z-10 px-4">
                                ' . e($title) . '
                            </div>';

                        // Bubbles around
                        foreach ($problems as $index => $text) {
                            $angle = deg2rad($angles[$index % 4]);
                            $x = cos($angle) * $radius;
                            $y = sin($angle) * $radius;

                            // Alternate brand / neutral bubbles for clear contrast in both themes
                            $isBrand = ($index % 2) === 0;

                            if ($isBrand) {
                                // Brand bubble: filled brand with light ink on both themes
                                $bubble = 'bg-[var(--color-brand-500)] text-white
                                           ring-4 ring-[color-mix(in_oklab,#000_10%,transparent)]
                                           hover:brightness-105';
                            } else {
                                // Neutral bubble: elevated surface with subtle border
                                $bubble = 'bg-[var(--bg-elevated)] text-[var(--text-default)]
                                           ring-4 ring-[color-mix(in_oklab,var(--text-default)_10%,transparent)]
                                           border border-[color-mix(in_oklab,var(--text-default)_12%,transparent)]
                                           hover:brightness-[1.03]';
                            }

                            $html .= '
                                <div class="absolute w-44 h-44 rounded-full ' . $bubble . '
                                            text-sm flex items-center justify-center text-center p-4
                                            shadow-[0_12px_24px_rgba(0,0,0,.25)]
                                            backdrop-blur-[2px]
                                            transition-transform duration-300 ease-[var(--ease-brand)]
                                            hover:-translate-y-0.5"
                                     style="left:calc(50% + ' . $x . 'px); top:calc(50% + ' . $y . 'px); transform:translate(-50%, -50%)">
                                    ' . e($text) . '
                                </div>';
                        }

                        $html .= '</div>';
                        return $html;
                    }
                @endphp

                <!-- Pawnshop Ops -->
                <div class="grid md:grid-cols-2 gap-12 items-center text-left md:text-start">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-extrabold mb-4 text-[var(--color-electric-sky)]">
                            {{ __('services.sections.pawnshop.title') }}
                        </h2>
                        <p class="text-[17px] leading-relaxed text-[color-mix(in_oklab,var(--text-default)_78%,transparent)]">
                            {{ __('services.sections.pawnshop.description') }}
                        </p>
                    </div>
                    <div class="flex justify-center">
                        <img src="https://plus.unsplash.com/premium_photo-1673208585690-fe33159386bd?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0"
                             alt="Pawnshop Services"
                             class="rounded-xl shadow-[0_12px_24px_rgba(0,0,0,.25)]
                                    ring-1 ring-[color-mix(in_oklab,var(--text-default)_10%,transparent)]
                                    hover:brightness-105 transition max-w-full h-auto"
                             loading="lazy">
                    </div>
                </div>

                <div class="card px-6 sm:px-10 py-12 sm:py-14 space-y-10">
                    {!! renderProblemCircleLayout(__('services.sections.pawnshop.title'), __('services.sections.pawnshop.problems')) !!}
                </div>

                <!-- SMB Tools -->
                <div class="grid md:grid-cols-2 gap-12 items-center text-left md:text-start">
                    <div class="md:order-2">
                        <h2 class="text-3xl md:text-4xl font-extrabold mb-4 text-[var(--color-electric-sky)]">
                            {{ __('services.sections.smb.title') }}
                        </h2>
                        <p class="text-[17px] leading-relaxed text-[color-mix(in_oklab,var(--text-default)_78%,transparent)]">
                            {{ __('services.sections.smb.description') }}
                        </p>
                    </div>
                    <div class="flex justify-center md:order-1">
                        <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0"
                             alt="SMB Services"
                             class="rounded-xl shadow-[0_12px_24px_rgba(0,0,0,.25)]
                                    ring-1 ring-[color-mix(in_oklab,var(--text-default)_10%,transparent)]
                                    hover:brightness-105 transition max-w-full h-auto"
                             loading="lazy">
                    </div>
                </div>

                <div class="card px-6 sm:px-10 py-12 sm:py-14 space-y-10">
                    {!! renderProblemCircleLayout(__('services.sections.smb.title'), __('services.sections.smb.problems')) !!}
                </div>

                <!-- Compliance -->
                <div class="grid md:grid-cols-2 gap-12 items-center text-left md:text-start">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-extrabold mb-4 text-[var(--color-electric-sky)]">
                            {{ __('services.sections.compliance.title') }}
                        </h2>
                        <p class="text-[17px] leading-relaxed text-[color-mix(in_oklab,var(--text-default)_78%,transparent)]">
                            {{ __('services.sections.compliance.description') }}
                        </p>
                    </div>
                    <div class="flex justify-center">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=815&auto=format&fit=crop&ixlib=rb-4.1.0"
                             alt="Compliance"
                             class="rounded-xl shadow-[0_12px_24px_rgba(0,0,0,.25)]
                                    ring-1 ring-[color-mix(in_oklab,var(--text-default)_10%,transparent)]
                                    hover:brightness-105 transition max-w-full h-auto"
                             loading="lazy">
                    </div>
                </div>

                <div class="card px-6 sm:px-10 py-12 sm:py-14 space-y-10">
                    {!! renderProblemCircleLayout(__('services.sections.compliance.title'), __('services.sections.compliance.problems')) !!}
                </div>

                <!-- CTA -->
                <div class="text-center mt-4">
                    <a href="{{ route('contact') }}" class="btn btn-md btn-primary">
                        {{ __('about.cta') }}
                    </a>
                </div>

            </div>
        </section>
    </div>
</x-layouts.base>
