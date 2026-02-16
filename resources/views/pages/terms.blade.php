<x-layouts.base :title="__('terms.title')">
  <section class="section-block">
    <div class="section-inner max-w-4xl space-y-6">
      <header class="space-y-3 reveal">
        <span class="section-kicker">{{ __('terms.kicker') }}</span>
        <h1 class="section-title">{{ __('terms.title') }}</h1>
        <p class="section-lead">{{ __('terms.sections.intro') }}</p>
      </header>

      <article class="legal-card p-6 md:p-8 reveal reveal-delay-1">
        <div class="space-y-6 text-sm leading-7 text-[color:var(--text-muted)]">
          <section>
            <h2 class="text-xl font-semibold text-[color:var(--text)]">{{ __('terms.sections.1_title') }}</h2>
            <p class="mt-2">{{ __('terms.sections.1_text') }}</p>
          </section>

          <section>
            <h2 class="text-xl font-semibold text-[color:var(--text)]">{{ __('terms.sections.2_title') }}</h2>
            <p class="mt-2">{{ __('terms.sections.2_text') }}</p>
          </section>

          <section>
            <h2 class="text-xl font-semibold text-[color:var(--text)]">{{ __('terms.sections.3_title') }}</h2>
            <p class="mt-2">{{ __('terms.sections.3_text') }}</p>
          </section>

          <section>
            <h2 class="text-xl font-semibold text-[color:var(--text)]">{{ __('terms.sections.4_title') }}</h2>
            <p class="mt-2">{{ __('terms.sections.4_text') }}</p>
          </section>

          <section>
            <h2 class="text-xl font-semibold text-[color:var(--text)]">{{ __('terms.sections.5_title') }}</h2>
            <p class="mt-2">{{ __('terms.sections.5_text') }}</p>
          </section>

          <p>{{ __('terms.sections.contact') }}</p>
        </div>

        <div class="mt-7">
          <x-ui.button route="contact" variant="primary" size="md">
            {{ __('terms.sections.cta') }}
          </x-ui.button>
        </div>
      </article>
    </div>
  </section>
</x-layouts.base>
