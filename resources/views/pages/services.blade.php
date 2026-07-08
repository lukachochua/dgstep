@php
  $seoDescription = \Illuminate\Support\Str::limit(
    \Illuminate\Support\Str::squish(strip_tags($page['overview_body'])),
    158,
    ''
  );

  $seo = [
    'title' => $page['title'],
    'description' => $seoDescription,
    'og_title' => $page['title'],
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
      <section id="services-system-map" class="services-system-map reveal" aria-labelledby="services-system-map-title">
        <div class="services-system-map__head">
          <div>
            <span class="section-kicker">{{ __('services.interface.system_map') }}</span>
            <h2 id="services-system-map-title" class="services-system-map__title">{{ $page['overview_heading'] }}</h2>
          </div>
          <p class="whitespace-pre-line">{{ $page['overview_body'] }}</p>
        </div>

        <ol class="services-system-map__modules">
          @foreach ($services as $service)
            <li>
              <a href="#service-{{ $service['slug'] }}">
                <span>{{ str_pad((string) $service['index'], 2, '0', STR_PAD_LEFT) }}</span>
                <strong>{{ $service['title'] }}</strong>
                @if ($service['cue_label'] !== '')
                  <small>{{ $service['cue_label'] }}</small>
                @endif
              </a>
            </li>
          @endforeach
        </ol>

        <ol class="services-implementation-flow" aria-label="{{ __('services.interface.system_map') }}">
          @foreach (__('services.interface.flow') as $stage)
            <li>
              <span>{{ str_pad((string) ($loop->index + 1), 2, '0', STR_PAD_LEFT) }}</span>
              <strong>{{ $stage }}</strong>
            </li>
          @endforeach
        </ol>

      </section>

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
