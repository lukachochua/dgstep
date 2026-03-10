<x-layouts.base title="{{ __('messages.homepage_title') }}">
  <x-hero :slides="$slides" />

  <section class="py-3 md:py-6">
    <div class="section-inner">
      <div class="panel-soft home-proof p-5 md:p-7 space-y-5">
        <div class="ltr-reveal" data-reveal-ltr>
          <span class="section-kicker">{{ __('messages.home_proof.kicker') }}</span>
          <h2 class="section-title mt-3">{{ __('messages.home_proof.title') }}</h2>
          <p class="section-lead mt-2">{{ __('messages.home_proof.subtitle') }}</p>
        </div>

        <div class="grid gap-5 md:grid-cols-3" data-reveal-ltr-group>
          <article class="metric-card ltr-reveal" data-reveal-ltr>
            <p class="text-xs uppercase tracking-[0.12em] text-[color:var(--text-muted)]">{{ __('messages.home_metrics.focus.label') }}</p>
            <p class="metric-value">{{ __('messages.home_metrics.focus.value') }}</p>
            <p class="text-sm text-[color:var(--text-muted)]">{{ __('messages.home_metrics.focus.description') }}</p>
          </article>
          <article class="metric-card ltr-reveal" data-reveal-ltr>
            <p class="text-xs uppercase tracking-[0.12em] text-[color:var(--text-muted)]">{{ __('messages.home_metrics.technology.label') }}</p>
            <p class="metric-value">{{ __('messages.home_metrics.technology.value') }}</p>
            <p class="text-sm text-[color:var(--text-muted)]">{{ __('messages.home_metrics.technology.description') }}</p>
          </article>
          <article class="metric-card ltr-reveal" data-reveal-ltr>
            <p class="text-xs uppercase tracking-[0.12em] text-[color:var(--text-muted)]">{{ __('messages.home_metrics.approach.label') }}</p>
            <p class="metric-value">{{ __('messages.home_metrics.approach.value') }}</p>
            <p class="text-sm text-[color:var(--text-muted)]">{{ __('messages.home_metrics.approach.description') }}</p>
          </article>
        </div>
      </div>
    </div>
  </section>

  <x-features :items="$featured" />

  <section class="section-block pt-0">
    <div class="section-inner">
      <div class="panel p-6 md:p-9 lg:flex lg:items-center lg:justify-between lg:gap-8 ltr-reveal" data-reveal-ltr data-reveal-ltr-group>
        <div class="ltr-reveal" data-reveal-ltr>
          <span class="section-kicker">{{ __('messages.home_cta.kicker') }}</span>
          <h2 class="section-title mt-3">{{ __('messages.home_cta.title') }}</h2>
          <p class="section-lead mt-2">{{ __('messages.home_cta.subtitle') }}</p>
        </div>

        <div class="mt-5 flex flex-wrap gap-3 lg:mt-0 lg:shrink-0 ltr-reveal" data-reveal-ltr>
          <x-ui.button route="contact" variant="primary" size="lg">{{ __('messages.home_cta.primary') }}</x-ui.button>
          <x-ui.button route="services" variant="ghost" size="lg">{{ __('messages.home_cta.secondary') }}</x-ui.button>
        </div>
      </div>
    </div>
  </section>
</x-layouts.base>
