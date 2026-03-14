@props([
  'items' => collect(),
  'kicker' => '',
  'title' => '',
  'subtitle' => '',
  'linkLabel' => '',
])

@php
  $locale = app()->getLocale();
  $hasDbItems = $items && $items->count() > 0;
  $fallbackCards = __('messages.features.cards');
  $fallbackImages = [
    Vite::asset('resources/images/placeholders/feature-ops.svg'),
    Vite::asset('resources/images/placeholders/feature-insights.svg'),
    Vite::asset('resources/images/placeholders/feature-rollout.svg'),
  ];
@endphp

<section class="section-block home-features">
  <div class="section-inner">
    <div class="features-header ltr-reveal" data-reveal-ltr>
      <div class="features-header__copy">
        <span class="section-kicker">{{ $kicker }}</span>
        <h2 class="section-title mt-3">{{ $title }}</h2>
      </div>
      <p class="section-lead">{{ $subtitle }}</p>
    </div>

    <div class="feature-grid" data-reveal-ltr-group>
      @if ($hasDbItems)
        @foreach ($items as $service)
          @php
            $name = $service->name[$locale] ?? ($service->name['en'] ?? $service->display_name);
            $desc = $service->description[$locale] ?? ($service->description['en'] ?? '');
            $img = $service->featured_image_url ?? $service->image_url;
            $cardImage = $img ?: $fallbackImages[$loop->index % count($fallbackImages)];
            $imageAlt = trim((string) ($service->image_alt ?? ''));
            if ($imageAlt === '') {
              $imageAlt = __('messages.features.image_alt', ['name' => $name]);
            }
          @endphp
          <x-ui.media-card
            variant="feature"
            class="{{ $loop->first ? 'feature-card--lead p-5 md:p-6' : 'feature-card--support p-4 md:p-5' }} ltr-reveal"
            data-reveal-ltr
            :image="$cardImage"
            :imageAlt="$imageAlt"
            :title="$name"
            :description="$desc"
          >
            <a href="{{ route('services') }}" class="feature-more-link mt-4 inline-flex text-sm font-semibold">
              {{ $linkLabel }}
            </a>
          </x-ui.media-card>
        @endforeach
      @else
        @foreach ((is_array($fallbackCards) ? $fallbackCards : []) as $card)
          @php
            $fallbackImage = $card['image'] ?? $fallbackImages[$loop->index % count($fallbackImages)];
          @endphp
          <x-ui.media-card
            variant="feature"
            class="{{ $loop->first ? 'feature-card--lead p-5 md:p-6' : 'feature-card--support p-4 md:p-5' }} ltr-reveal"
            data-reveal-ltr
            :image="$fallbackImage"
            :imageAlt="__('messages.features.image_alt', ['name' => ($card['title'] ?? __('services.our_key_services'))])"
            :title="$card['title'] ?? ''"
            :description="$card['description'] ?? ''"
          />
        @endforeach
      @endif
    </div>
  </div>
</section>
