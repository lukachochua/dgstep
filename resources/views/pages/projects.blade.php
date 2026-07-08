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

  $projectFallbacks = [
    Vite::asset('resources/images/placeholders/feature-ops.svg'),
    Vite::asset('resources/images/placeholders/feature-insights.svg'),
    Vite::asset('resources/images/placeholders/feature-rollout.svg'),
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

          <div class="projects-delivery-register">
            <div class="projects-delivery-register__head">
              <p class="project-proof-label">{{ __('projects.interface.delivery_register') }}</p>
              <h2>{{ $page['proof_heading'] }}</h2>
              <p class="project-proof-body">{{ $page['proof_body'] }}</p>
            </div>

            @if (!empty($page['proof_items']))
              <ol class="projects-delivery-register__rows">
                @foreach ($page['proof_items'] as $item)
                  <li>
                    <span>{{ str_pad((string) ($loop->index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                    <strong>{{ $item }}</strong>
                  </li>
                @endforeach
              </ol>
            @endif
          </div>
        </div>
      </x-ui.surface-card>

      <section class="projects-system-list" aria-label="{{ $page['hero_title'] }}">
        @foreach ($cards as $card)
          @php($fallbackImage = $projectFallbacks[$loop->index % count($projectFallbacks)])
          <article class="clipped-card project-system-record">
            <div class="project-system-record__header">
              <span>{{ __('projects.interface.project') }}</span>
              <strong>{{ str_pad((string) ($loop->index + 1), 2, '0', STR_PAD_LEFT) }}</strong>
            </div>
            <div class="project-system-record__grid">
              <img
                src="{{ $card['image'] ?: $fallbackImage }}"
                data-fallback-src="{{ $fallbackImage }}"
                onerror="this.onerror=null;this.src=this.dataset.fallbackSrc"
                alt="{{ $card['title'] }}"
                class="project-system-record__image"
                loading="lazy"
                decoding="async"
              />
              <div class="project-system-record__content">
                <p class="project-system-record__label">{{ __('projects.interface.delivered_system') }}</p>
                <h2>{{ $card['title'] }}</h2>
                <div class="project-system-record__scope">
                  <span>{{ __('projects.interface.scope') }}</span>
                  <p>{{ $card['description'] }}</p>
                </div>
              </div>
            </div>
          </article>
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
