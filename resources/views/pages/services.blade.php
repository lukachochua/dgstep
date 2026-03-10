<x-layouts.base :title="$page['title']">
  <section class="section-block services-page" id="services-top">
    <div class="section-inner services-page__stack">
      <header class="services-hero">
        <div class="services-hero__copy reveal">
          <span class="section-kicker">{{ $page['hero_kicker'] }}</span>
          <h1 class="section-title">{{ $page['hero_title'] }}</h1>
          <p class="section-lead">{{ $page['hero_lead'] }}</p>

          <div class="services-hero__actions">
            <x-ui.button route="contact" variant="primary" size="lg">
              {{ $page['hero_primary_cta'] }}
            </x-ui.button>
            <a href="#services-list" class="btn btn-lg btn-ghost">
              {{ $page['hero_secondary_cta'] }}
            </a>
          </div>

          <div class="services-hero__stats">
            <div class="metric-card">
              <p>{{ $page['stat_tracks_label'] }}</p>
              <p class="metric-value">{{ $serviceCount }}</p>
            </div>
            <div class="metric-card">
              <p>{{ $page['stat_pain_points_label'] }}</p>
              <p class="metric-value">{{ $problemCount }}</p>
            </div>
          </div>
        </div>

        <aside class="services-hero__overview panel-soft reveal reveal-delay-1">
          <p class="services-hero__overview-kicker">{{ $page['overview_heading'] }}</p>
          <p class="services-hero__overview-copy">{{ $page['overview_body'] }}</p>

          <div class="services-overview-list">
            @foreach ($services as $service)
              <a href="#service-{{ $service['slug'] }}" class="services-overview-item">
                <span class="services-overview-item__index">
                  {{ str_pad((string) $service['index'], 2, '0', STR_PAD_LEFT) }}
                </span>
                <span class="services-overview-item__content">
                  <strong>{{ $service['title'] }}</strong>
                  @if ($service['cue_label'] !== '')
                    <span>{{ $service['cue_label'] }}</span>
                  @endif
                </span>
              </a>
            @endforeach
          </div>
        </aside>
      </header>

      @if ($page['proof_items'] !== [])
        <section class="services-proof panel reveal reveal-delay-2" aria-labelledby="services-proof-title">
          <div class="services-proof__head">
            <h2 id="services-proof-title" class="services-proof__title">{{ $page['proof_heading'] }}</h2>
            <p class="services-proof__body">{{ $page['proof_body'] }}</p>
          </div>

          <div class="services-proof__chips">
            @foreach ($page['proof_items'] as $problem)
              <span class="services-proof__chip">{{ $problem }}</span>
            @endforeach
          </div>
        </section>
      @endif

      <div id="services-list" class="services-list stagger">
        @foreach ($services as $service)
          <x-service.row
            :title="$service['title']"
            :description="$service['description']"
            :fullDescription="$service['full_description']"
            :image="$service['image']"
            :imageAlt="$service['image_alt']"
            :slug="$service['slug']"
            :problems="$service['problems']"
            :index="$service['index']"
            :cueStyle="$service['cue_style']"
            :cueLabel="$service['cue_label']"
            :cueValues="$service['cue_values']"
            :problemsHeading="$page['card_problems_heading']"
            :ctaLabel="$page['card_cta']"
            :backToTopLabel="$page['card_back_to_top']"
            :readMoreLabel="$page['read_more_label']"
            :showLessLabel="$page['show_less_label']"
            :reversed="(($service['index'] - 1) % 2) === 1"
          />
        @endforeach
      </div>

      <section class="services-cta panel reveal" aria-labelledby="services-cta-title">
        <div class="services-cta__copy">
          <span class="section-kicker">{{ $page['cta_kicker'] }}</span>
          <h2 id="services-cta-title" class="section-title">{{ $page['cta_heading'] }}</h2>
          <p class="section-lead">{{ $page['cta_body'] }}</p>
        </div>

        <div class="services-cta__actions">
          <x-ui.button route="contact" variant="primary" size="lg">
            {{ $page['cta_primary'] }}
          </x-ui.button>
          <a href="#services-top" class="btn btn-lg btn-ghost">
            {{ $page['cta_secondary'] }}
          </a>
        </div>
      </section>
    </div>
  </section>
</x-layouts.base>
