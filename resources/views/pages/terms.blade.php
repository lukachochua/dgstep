<x-layouts.base :title="__('terms.title')">
  <section
    class="py-16 sm:py-20 md:py-24 select-none
           text-[var(--text-default)]
           bg-[var(--bg-default)]
           [background-image:linear-gradient(180deg,transparent_0%,transparent_40%,color-mix(in_oklab,var(--color-brand-950)_6%,transparent)_100%)]
           dark:[background-image:linear-gradient(180deg,color-mix(in_oklab,var(--color-brand-950)_16%,transparent)_0%,transparent_60%,transparent_100%)]">
    <div class="container mx-auto px-4 sm:px-6 md:px-8 max-w-3xl">

      <div class="card rounded-2xl px-6 sm:px-10 py-12 sm:py-14 space-y-10">

        <h1 class="text-4xl md:text-5xl font-extrabold text-center
                   text-[color-mix(in_oklab,var(--color-electric-sky)_92%,var(--text-default))]">
          {{ __('terms.title') }}
        </h1>

        <div class="space-y-8 leading-[1.75] text-[16px] text-[color-mix(in_oklab,var(--text-default)_86%,transparent)] text-left">
          <p>{{ __('terms.sections.intro') }}</p>

          <div class="space-y-3">
            <h2 class="text-2xl font-semibold text-[color-mix(in_oklab,var(--text-default)_96%,transparent)]">
              {{ __('terms.sections.1_title') }}
            </h2>
            <p>{{ __('terms.sections.1_text') }}</p>
          </div>

          <div class="space-y-3">
            <h2 class="text-2xl font-semibold text-[color-mix(in_oklab,var(--text-default)_96%,transparent)]">
              {{ __('terms.sections.2_title') }}
            </h2>
            <p>{{ __('terms.sections.2_text') }}</p>
          </div>

          <div class="space-y-3">
            <h2 class="text-2xl font-semibold text-[color-mix(in_oklab,var(--text-default)_96%,transparent)]">
              {{ __('terms.sections.3_title') }}
            </h2>
            <p>{{ __('terms.sections.3_text') }}</p>
          </div>

          <div class="space-y-3">
            <h2 class="text-2xl font-semibold text-[color-mix(in_oklab,var(--text-default)_96%,transparent)]">
              {{ __('terms.sections.4_title') }}
            </h2>
            <p>{{ __('terms.sections.4_text') }}</p>
          </div>

          <div class="space-y-3">
            <h2 class="text-2xl font-semibold text-[color-mix(in_oklab,var(--text-default)_96%,transparent)]">
              {{ __('terms.sections.5_title') }}
            </h2>
            <p>{{ __('terms.sections.5_text') }}</p>
          </div>

          <p>{{ __('terms.sections.contact') }}</p>
        </div>

        <div class="text-center pt-2">
          <a href="{{ route('contact') }}" class="btn btn-md btn-primary">
            {{ __('terms.sections.cta') }}
          </a>
        </div>

      </div>
    </div>
  </section>
</x-layouts.base>
