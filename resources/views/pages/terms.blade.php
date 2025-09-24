<x-layouts.base :title="__('terms.title')">
    <section
        class="bg-gradient-to-r from-[#0b0f1a] via-[#141d2f] to-[#0b0f1a] text-white py-20 select-none">
        <div class="container mx-auto px-4 sm:px-6 md:px-8 max-w-3xl">

            <div class="bg-white/5 rounded-xl border border-white/10 shadow-xl px-6 sm:px-10 py-14 space-y-12">

                <h1 class="text-4xl md:text-5xl font-bold text-center text-[var(--color-electric-sky)]">
                    {{ __('terms.title') }}
                </h1>

                <div class="space-y-8 text-white/80 leading-[1.75] text-[16px] text-left">
                    <p>{{ __('terms.sections.intro') }}</p>

                    <div class="space-y-4">
                        <h2 class="text-white text-2xl font-semibold">{{ __('terms.sections.1_title') }}</h2>
                        <p>{{ __('terms.sections.1_text') }}</p>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-white text-2xl font-semibold">{{ __('terms.sections.2_title') }}</h2>
                        <p>{{ __('terms.sections.2_text') }}</p>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-white text-2xl font-semibold">{{ __('terms.sections.3_title') }}</h2>
                        <p>{{ __('terms.sections.3_text') }}</p>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-white text-2xl font-semibold">{{ __('terms.sections.4_title') }}</h2>
                        <p>{{ __('terms.sections.4_text') }}</p>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-white text-2xl font-semibold">{{ __('terms.sections.5_title') }}</h2>
                        <p>{{ __('terms.sections.5_text') }}</p>
                    </div>

                    <p>{{ __('terms.sections.contact') }}</p>
                </div>

                <div class="text-center pt-6">
                    <a href="{{ route('contact') }}"
                        class="inline-block mt-4 px-6 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-[var(--color-electric-sky)] transition">
                        {{ __('terms.sections.cta') }}
                    </a>
                </div>

            </div>
        </div>
    </section>
</x-layouts.base>
