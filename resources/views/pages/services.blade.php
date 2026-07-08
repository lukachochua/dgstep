@php
  $seoDescription = \Illuminate\Support\Str::limit(
    \Illuminate\Support\Str::squish(strip_tags($page['hero_lead'] ?: $page['overview_body'])),
    158,
    ''
  );

  $seo = [
    'title' => $page['title'],
    'description' => $seoDescription,
    'og_title' => $page['hero_title'] ?: $page['title'],
    'og_description' => $seoDescription,
    'image' => $services->first()['image'] ?? null,
  ];

  $structuredData = [
    [
      '@context' => 'https://schema.org',
      '@type' => 'CollectionPage',
      'name' => $page['title'],
      'description' => $seoDescription,
      'url' => route('services'),
      'inLanguage' => app()->getLocale(),
      'isPartOf' => ['@id' => url('/#website')],
    ],
    [
      '@context' => 'https://schema.org',
      '@type' => 'ItemList',
      'name' => $page['overview_heading'],
      'itemListElement' => $services
        ->values()
        ->map(fn (array $service, int $index) => [
          '@type' => 'ListItem',
          'position' => $index + 1,
          'url' => route('services') . '#service-' . $service['slug'],
          'item' => [
            '@type' => 'Service',
            'name' => $service['title'],
            'description' => \Illuminate\Support\Str::squish(strip_tags($service['description'])),
            'provider' => ['@id' => url('/#organization')],
            'areaServed' => 'Georgia',
          ],
        ])
        ->all(),
    ],
  ];
@endphp

<x-layouts.base :title="$page['title']" :seo="$seo" :structured-data="$structuredData">
  <section class="section-block services-page" id="services-top">
    <div class="section-inner services-page__stack">
      <header class="services-hero reveal">
        <x-ui.surface-card as="section" variant="hero" class="services-hero__shell">
          <div class="services-hero__grid">
            <div class="services-hero__copy">
              <span class="section-kicker">{{ $page['hero_kicker'] }}</span>
              <h1 class="section-title">{{ $page['hero_title'] }}</h1>
              <p class="section-lead whitespace-pre-line">{{ $page['hero_lead'] }}</p>

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
              <p class="services-hero__overview-copy whitespace-pre-line">{{ $page['overview_body'] }}</p>

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

      {{-- @if ($page['proof_items'] !== [])
        <section class="clipped-card services-proof reveal reveal-delay-1" aria-labelledby="services-proof-title">
          <div class="services-proof__head">
            <h2 id="services-proof-title" class="services-proof__title">{{ $page['proof_heading'] }}</h2>
            <p class="services-proof__body whitespace-pre-line">{{ $page['proof_body'] }}</p>
          </div>

          <ul class="services-proof__chips" aria-label="{{ $page['proof_heading'] }}">
            @foreach ($page['proof_items'] as $problem)
              <li class="services-proof__chip">{{ $problem }}</li>
            @endforeach
          </ul>
        </section>
      @endif --}}

      <div id="services-list" class="services-list stagger">
        @foreach ($services as $service)
          <x-service.row
            :title="$service['title']"
            :description="$service['description']"
            :fullDescription="$service['full_description']"
            :image="$service['image']"
            :imageAlt="$service['image_alt']"
            :slug="$service['slug']"
            {{-- :problems="$service['problems']" --}}
            :index="$service['index']"
            :cueLabel="$service['cue_label']"
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
        :preserveLineBreaks="true"
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
