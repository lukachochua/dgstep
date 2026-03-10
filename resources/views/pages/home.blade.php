<x-layouts.base :title="$homePage['title']">
  <x-hero :slides="$slides" :content="$homePage['hero']" />

  <section class="py-3 md:py-6">
    <div class="section-inner">
      <div class="panel-soft home-proof p-5 md:p-7 space-y-5">
        <div class="ltr-reveal" data-reveal-ltr>
          <span class="section-kicker">{{ $homePage['proof']['kicker'] }}</span>
          <h2 class="section-title mt-3">{{ $homePage['proof']['title'] }}</h2>
          <p class="section-lead mt-2">{{ $homePage['proof']['subtitle'] }}</p>
        </div>

        <div class="grid gap-5 md:grid-cols-3" data-reveal-ltr-group>
          <article class="metric-card ltr-reveal" data-reveal-ltr>
            <p class="text-xs uppercase tracking-[0.12em] text-[color:var(--text-muted)]">{{ $homePage['metrics']['focus']['label'] }}</p>
            <p class="metric-value">{{ $homePage['metrics']['focus']['value'] }}</p>
            <p class="text-sm text-[color:var(--text-muted)]">{{ $homePage['metrics']['focus']['description'] }}</p>
          </article>
          <article class="metric-card ltr-reveal" data-reveal-ltr>
            <p class="text-xs uppercase tracking-[0.12em] text-[color:var(--text-muted)]">{{ $homePage['metrics']['technology']['label'] }}</p>
            <p class="metric-value">{{ $homePage['metrics']['technology']['value'] }}</p>
            <p class="text-sm text-[color:var(--text-muted)]">{{ $homePage['metrics']['technology']['description'] }}</p>
          </article>
          <article class="metric-card ltr-reveal" data-reveal-ltr>
            <p class="text-xs uppercase tracking-[0.12em] text-[color:var(--text-muted)]">{{ $homePage['metrics']['approach']['label'] }}</p>
            <p class="metric-value">{{ $homePage['metrics']['approach']['value'] }}</p>
            <p class="text-sm text-[color:var(--text-muted)]">{{ $homePage['metrics']['approach']['description'] }}</p>
          </article>
        </div>
      </div>
    </div>
  </section>

  <x-features
    :items="$featured"
    :kicker="$homePage['solutions']['kicker']"
    :title="$homePage['solutions']['title']"
    :subtitle="$homePage['solutions']['subtitle']"
    :linkLabel="$homePage['solutions']['link_label']"
  />

  <section class="section-block pt-0">
    <div class="section-inner">
      <div class="panel p-6 md:p-9 lg:flex lg:items-center lg:justify-between lg:gap-8 ltr-reveal" data-reveal-ltr data-reveal-ltr-group>
        <div class="ltr-reveal" data-reveal-ltr>
          <span class="section-kicker">{{ $homePage['cta']['kicker'] }}</span>
          <h2 class="section-title mt-3">{{ $homePage['cta']['title'] }}</h2>
          <p class="section-lead mt-2">{{ $homePage['cta']['subtitle'] }}</p>
        </div>

        <div class="mt-5 flex flex-wrap gap-3 lg:mt-0 lg:shrink-0 ltr-reveal" data-reveal-ltr>
          <x-ui.button route="contact" variant="primary" size="lg">{{ $homePage['cta']['primary'] }}</x-ui.button>
          <x-ui.button route="services" variant="ghost" size="lg">{{ $homePage['cta']['secondary'] }}</x-ui.button>
        </div>
      </div>
    </div>
  </section>
</x-layouts.base>
