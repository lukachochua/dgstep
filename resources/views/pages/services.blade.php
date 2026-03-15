<x-layouts.base :title="$page['title']">
  <section class="section-block services-page" id="services-top">
    <div class="section-inner services-page__stack">
      <header class="services-hero reveal">
        <x-ui.surface-card as="section" variant="hero" class="services-hero__shell">
          <div class="services-hero__grid">
            <div class="services-hero__copy">
              <span class="section-kicker">{{ $page['hero_kicker'] }}</span>
              <h1 class="section-title">{{ $page['hero_title'] }}</h1>
              <p class="section-lead">{{ $page['hero_lead'] }}</p>

              <div class="services-hero__actions">
                <x-ui.button route="contact" variant="primary" size="lg">
                  {{ $page['hero_primary_cta'] }}
                </x-ui.button>
                <x-ui.button href="#services-list" variant="ghost" size="lg">
                  {{ $page['hero_secondary_cta'] }}
                </x-ui.button>
              </div>
            </div>

            <aside class="services-hero__overview">
              <p class="services-hero__overview-kicker">{{ $page['overview_heading'] }}</p>
              <p class="services-hero__overview-copy">{{ $page['overview_body'] }}</p>

              <div class="services-overview-list">
                @foreach ($services as $service)
                  <x-ui.index-link-card
                    href="#service-{{ $service['slug'] }}"
                    :index="str_pad((string) $service['index'], 2, '0', STR_PAD_LEFT)"
                    :title="$service['title']"
                    :subtitle="$service['cue_label'] !== '' ? $service['cue_label'] : null"
                  />
                @endforeach
              </div>
            </aside>
          </div>
        </x-ui.surface-card>
      </header>

      @if ($page['proof_items'] !== [])
        <section class="services-proof reveal reveal-delay-1" aria-labelledby="services-proof-title">
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
            :reversed="false"
          />
        @endforeach
      </div>

      <x-ui.section-cta-card
        class="services-cta reveal"
        aria-labelledby="services-cta-title"
        :kicker="$page['cta_kicker']"
        :title="$page['cta_heading']"
        :body="$page['cta_body']"
      >
        <x-slot:actions>
          <div class="services-cta__actions">
            <x-ui.button route="contact" variant="primary" size="lg">
              {{ $page['cta_primary'] }}
            </x-ui.button>
            <x-ui.button href="#services-top" variant="ghost" size="lg">
              {{ $page['cta_secondary'] }}
            </x-ui.button>
          </div>
        </x-slot:actions>
      </x-ui.section-cta-card>
    </div>
  </section>
</x-layouts.base>
