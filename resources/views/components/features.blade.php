@props([
  'items' => collect(),
])

@php
  $locale = app()->getLocale();
  $hasDbItems = $items && $items->count() > 0;
  $fallbackCards = __('messages.features.cards');
  $fallbackImages = [
    'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=1200&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=1200&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1551434678-e076c223a692?q=80&w=1200&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=1200&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=1200&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?q=80&w=1200&auto=format&fit=crop',
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
          @endphp
          <article class="feature-card p-4 md:p-5 ltr-reveal" data-reveal-ltr>
            <img
              src="{{ $cardImage }}"
              alt="{{ $service->image_alt ?: $name }}"
              class="feature-image mb-4 h-44 w-full"
              loading="lazy"
              decoding="async"
            />

            <h3 class="text-xl font-semibold leading-tight">{{ $name }}</h3>
            <p class="mt-2 text-sm text-[color:var(--text-muted)] line-clamp-4">{{ $desc }}</p>
            <a href="{{ route('services') }}" class="mt-4 inline-flex text-sm font-semibold text-[color:var(--brand-strong)]">
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
              alt="{{ $card['title'] ?? __('services.our_key_services') }}"
              class="feature-image mb-4 h-44 w-full"
              loading="lazy"
              decoding="async"
            />
            <h3 class="text-xl font-semibold leading-tight">{{ $card['title'] ?? '' }}</h3>
            <p class="mt-2 text-sm text-[color:var(--text-muted)]">{{ $card['description'] ?? '' }}</p>
          </article>
        @endforeach
      @endif
    </div>
  </div>
</section>
