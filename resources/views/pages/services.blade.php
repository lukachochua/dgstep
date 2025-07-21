<x-layouts.base :title="__('services.title')">
    <div class="min-h-screen flex flex-col">
        <section
            class="flex-grow bg-gradient-to-r from-[#0b0f1a] via-[#141d2f] to-[#0b0f1a] text-white py-24 select-none font-[FiraGO]">
            <div class="container mx-auto px-4 sm:px-6 md:px-8 space-y-24">
                @php
                    function renderProblemCircleLayout($title, $problems)
                    {
                        $angles = [45, 135, 225, 315]; // Top-right, top-left, bottom-left, bottom-right
                        $radius = 260;

                        $html = '<div class="relative max-w-5xl mx-auto h-[660px] mt-6">';

                        // Arrows — curved paths
                        $arrowCoords = [
                            [640, 120, 570, 190],
                            [360, 120, 430, 190],
                            [360, 440, 430, 370],
                            [640, 440, 570, 370],
                        ];

                        $html .=
                            '<svg class="absolute left-0 top-0 w-full h-full pointer-events-none z-0" viewBox="0 0 1000 600">';
                        foreach ($arrowCoords as [$x, $y, $cx, $cy]) {
                            $html .=
                                '<path d="M500,280 Q' .
                                $cx .
                                ',' .
                                $cy .
                                ' ' .
                                $x .
                                ',' .
                                $y .
                                '" stroke="#00a7ff66" stroke-width="1.8" fill="none" stroke-linecap="round" />';
                        }
                        $html .= '</svg>';

                        // Center glowing circle
                        $html .=
                            '
                            <div class="absolute top-1/2 left-1/2 w-52 h-52 rounded-full bg-[#10161f] text-[var(--color-electric-sky)]
                                font-bold text-center text-base shadow-inner ring-[20px] ring-[#1b2333] border border-[#2e3a4d]
                                flex items-center justify-center transform -translate-x-1/2 -translate-y-1/2 z-10 px-4">
                                ' .
                            e($title) .
                            '
                            </div>';

                        foreach ($problems as $index => $text) {
                            $angle = deg2rad($angles[$index % 4]);
                            $x = cos($angle) * $radius;
                            $y = sin($angle) * $radius;

                            $bgClass = match ($index % 4) {
                                0, 1 => 'bg-[#f5e83f]/90 text-black font-semibold ring-[6px] ring-yellow-300/30',
                                default => 'bg-[#151d2f] text-white ring-4 ring-white/10',
                            };

                            $html .=
                                '
                                <div class="absolute w-44 h-44 rounded-full ' .
                                $bgClass .
                                ' text-sm flex items-center justify-center text-center p-4 border border-white/10 shadow-xl
                                    backdrop-blur-sm transition-transform duration-300 ease-in-out"
                                    style="left:calc(50% + ' .
                                $x .
                                'px); top:calc(50% + ' .
                                $y .
                                'px); transform:translate(-50%, -50%)">
                                    ' .
                                e($text) .
                                '
                                </div>';
                        }

                        $html .= '</div>';
                        return $html;
                    }
                @endphp

                <!-- Pawnshop Ops -->
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-extrabold mb-4 text-[var(--color-electric-sky)]">
                            {{ __('services.sections.pawnshop.title') }}
                        </h2>
                        <p class="text-white/80 text-[17px] leading-relaxed">
                            {{ __('services.sections.pawnshop.description') }}
                        </p>
                    </div>
                    <div class="flex justify-center">
                        <img src="https://plus.unsplash.com/premium_photo-1673208585690-fe33159386bd?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Pawnshop Services" class="rounded-xl shadow-lg max-w-full h-auto" loading="lazy">
                    </div>
                </div>

                {!! renderProblemCircleLayout(__('services.sections.pawnshop.title'), __('services.sections.pawnshop.problems')) !!}

                <!-- SMB Tools -->
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="md:order-2">
                        <h2 class="text-3xl md:text-4xl font-extrabold mb-4 text-[var(--color-electric-sky)]">
                            {{ __('services.sections.smb.title') }}
                        </h2>
                        <p class="text-white/80 text-[17px] leading-relaxed">
                            {{ __('services.sections.smb.description') }}
                        </p>
                    </div>
                    <div class="flex justify-center md:order-1">
                        <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="SMB Services" class="rounded-xl shadow-lg max-w-full h-auto" loading="lazy">
                    </div>
                </div>

                {!! renderProblemCircleLayout(__('services.sections.smb.title'), __('services.sections.smb.problems')) !!}

                <!-- Compliance -->
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-extrabold mb-4 text-[var(--color-electric-sky)]">
                            {{ __('services.sections.compliance.title') }}
                        </h2>
                        <p class="text-white/80 text-[17px] leading-relaxed">
                            {{ __('services.sections.compliance.description') }}
                        </p>
                    </div>
                    <div class="flex justify-center">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=815&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Compliance" class="rounded-xl shadow-lg max-w-full h-auto" loading="lazy">
                    </div>
                </div>

                {!! renderProblemCircleLayout(
                    __('services.sections.compliance.title'),
                    __('services.sections.compliance.problems'),
                ) !!}

            </div>
        </section>
    </div>
</x-layouts.base>
