@props([
  'items' => collect(),
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
      <h2 class="section-title">{{ __('services.our_key_services') }}</h2>
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
          <article class="feature-card p-4 md:p-5 ltr-reveal" data-reveal-ltr>
            <img
              src="{{ $cardImage }}"
              alt="{{ $imageAlt }}"
              class="feature-image mb-4 h-44 w-full"
              width="1200"
              height="704"
              loading="lazy"
              decoding="async"
            />

            <h3 class="text-xl font-semibold leading-tight">{{ $name }}</h3>
            <p class="mt-2 text-sm text-[color:var(--text-muted)] line-clamp-4">{{ $desc }}</p>
            <a href="{{ route('services') }}" class="feature-more-link mt-4 inline-flex text-sm font-semibold">
              {{ __('services.read_more') }}
            </a>
          </article>
        @endforeach
      @else
        @foreach ((is_array($fallbackCards) ? $fallbackCards : []) as $card)
          @php
            $fallbackImage = $card['image'] ?? $fallbackImages[$loop->index % count($fallbackImages)];
          @endphp
          <article class="feature-card p-5 ltr-reveal" data-reveal-ltr>
            <img
              src="{{ $fallbackImage }}"
              alt="{{ __('messages.features.image_alt', ['name' => ($card['title'] ?? __('services.our_key_services'))]) }}"
              class="feature-image mb-4 h-44 w-full"
              width="1200"
              height="704"
              loading="lazy"
              decoding="async"
            />
            <h3 class="text-xl font-semibold leading-tight">{{ $card['title'] ?? '' }}</h3>
            <p class="mt-2 text-sm text-[color:var(--text-muted)] line-clamp-4">{{ $card['description'] ?? '' }}</p>
          </article>
        @endforeach
      @endif
    </div>
  </div>
</section>
