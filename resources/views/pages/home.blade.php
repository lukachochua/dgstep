<x-layouts.base :title="$homePage['title']">
  <x-hero :slides="$slides" :content="$homePage['hero']" />

  <section class="home-proof section-block pt-0">
    <div class="section-inner">
      <div class="clipped-card home-proof__frame">
        <div class="home-proof__intro">
          <p class="home-proof__eyebrow">{{ $homePage['proof']['kicker'] }}</p>
          <h2 class="section-title">{{ $homePage['proof']['title'] }}</h2>
          <p class="section-lead whitespace-pre-line">{{ $homePage['proof']['subtitle'] }}</p>
        </div>

        <div class="home-proof__list" data-reveal-ltr-group>
          @foreach (['focus', 'technology', 'approach'] as $metricKey)
            <article class="home-proof__item ltr-reveal" data-reveal-ltr>
              <p class="home-proof__item-label">{{ $homePage['metrics'][$metricKey]['label'] }}</p>
              <p class="home-proof__item-value">{{ $homePage['metrics'][$metricKey]['value'] }}</p>
              <p class="home-proof__item-copy whitespace-pre-line">{{ $homePage['metrics'][$metricKey]['description'] }}</p>
            </article>
          @endforeach
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

  <section class="section-block pt-0 home-cta-section">
    <div class="section-inner">
      <x-ui.section-cta-card
        class="home-cta p-6 md:p-8 lg:flex lg:items-center lg:justify-between lg:gap-8 ltr-reveal"
        data-reveal-ltr
        :title="$homePage['cta']['title']"
        :body="$homePage['cta']['subtitle']"
      >
        <x-slot:actions>
          <div class="home-cta__actions ltr-reveal" data-reveal-ltr>
            <x-ui.button route="contact" variant="primary" size="lg">{{ $homePage['cta']['primary'] }}</x-ui.button>
            <a href="{{ route('services') }}" class="home-cta__secondary-link">{{ $homePage['cta']['secondary'] }}</a>
          </div>
        </x-slot:actions>
      </x-ui.section-cta-card>
    </div>
  </section>

  <x-ui.floating-cta
    :title="$homePage['floating_cta']['title']"
    :primaryLabel="$homePage['floating_cta']['primary']"
  />
</x-layouts.base>
