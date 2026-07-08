@php
  $pageTitle = $page['title'] ?? __('projects.title');
  $seoDescription = \Illuminate\Support\Str::limit(
    \Illuminate\Support\Str::squish(strip_tags($page['hero_lead'] ?: $page['proof_body'])),
    158,
    ''
  );

  $seo = [
    'title' => $pageTitle,
    'description' => $seoDescription,
    'og_title' => $page['hero_title'] ?: $pageTitle,
    'og_description' => $seoDescription,
    'image' => $cards[0]['image'] ?? null,
  ];

  $structuredData = [
    [
      '@context' => 'https://schema.org',
      '@type' => 'CollectionPage',
      'name' => $pageTitle,
      'description' => $seoDescription,
      'url' => route('projects'),
      'inLanguage' => app()->getLocale(),
      'isPartOf' => ['@id' => url('/#website')],
      'mainEntity' => [
        '@type' => 'ItemList',
        'itemListElement' => collect($cards)
          ->values()
          ->map(fn (array $card, int $index) => [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'item' => [
              '@type' => 'CreativeWork',
              'name' => $card['title'] ?? '',
              'description' => \Illuminate\Support\Str::squish(strip_tags($card['description'] ?? '')),
              'image' => $card['image'] ?? null,
            ],
          ])
          ->all(),
      ],
    ],
  ];
@endphp

<x-layouts.base :title="$pageTitle" :seo="$seo" :structured-data="$structuredData">
  <section class="section-block">
    <div class="section-inner space-y-8">
      <x-ui.surface-card as="section" variant="hero" class="projects-hero-card p-6 md:p-8 lg:p-10 reveal">
        <div class="projects-hero-grid">
          <div class="space-y-5">
            <span class="section-kicker">{{ $page['hero_kicker'] }}</span>
            <h1 class="section-title">{{ $page['hero_title'] }}</h1>
            <p class="section-lead">{{ $page['hero_lead'] }}</p>
          </div>

          <x-ui.surface-card as="div" variant="hero-detail" class="projects-proof-band">
            <div class="space-y-3">
              <p class="project-proof-label">
                {{ $page['proof_heading'] }}
              </p>
              <p class="project-proof-body">
                {{ $page['proof_body'] }}
              </p>
            </div>

            @if (!empty($page['proof_items']))
              <div class="projects-proof-list">
                @foreach ($page['proof_items'] as $item)
                  <span class="projects-proof-chip">{{ $item }}</span>
                @endforeach
              </div>
            @endif
          </x-ui.surface-card>
        </div>
      </x-ui.surface-card>

      <section class="projects-grid stagger">
        @foreach ($cards as $card)
          <x-ui.media-card
            variant="project"
            class="projects-card p-4 md:p-5"
            :image="$card['image']"
            :imageAlt="$card['title']"
            :title="$card['title']"
            :description="$card['description']"
          />
        @endforeach
      </section>

      <x-ui.section-cta-card
        class="projects-cta p-6 md:p-8 reveal"
        :title="$page['cta_heading']"
        :body="$page['cta_description']"
      >
        <x-slot:actions>
          <x-ui.button route="contact" variant="primary" size="lg" class="projects-cta-button">
            {{ $page['cta_label'] }}
          </x-ui.button>
        </x-slot:actions>
      </x-ui.section-cta-card>
    </div>
  </section>
</x-layouts.base>
