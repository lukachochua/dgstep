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

<section class="section-block">
  <div class="section-inner space-y-8">
    <div class="ltr-reveal" data-reveal-ltr>
      <span class="section-kicker">{{ $kicker }}</span>
      <h2 class="section-title mt-3">{{ $title }}</h2>
      <p class="section-lead mt-2">{{ $subtitle }}</p>
    </div>

    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3" data-reveal-ltr-group>
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
            class="p-4 md:p-5 ltr-reveal"
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
            class="p-5 ltr-reveal"
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
