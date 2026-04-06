@props([
  'slides' => [],
  'content' => [],
])

@php
  $fallbackSlides = trans('messages.hero.slides');
  $rawSlides = !empty($slides) ? $slides : (is_array($fallbackSlides) ? $fallbackSlides : []);

  $normalizedSlides = collect($rawSlides)->map(function ($slide) {
      return [
          'title' => (string) data_get($slide, 'title', ''),
          'subtitle' => (string) data_get($slide, 'subtitle', ''),
          'image' => data_get($slide, 'image'),
      ];
  })->filter(fn ($slide) => filled($slide['title']) || filled($slide['subtitle']))->values()->all();

  if (empty($normalizedSlides)) {
      $normalizedSlides[] = [
          'title' => __('messages.hero.title'),
          'subtitle' => __('messages.hero.subtitle'),
          'image' => null,
      ];
  }

  $totalSlides = count($normalizedSlides);
  $fallbackVisual = asset('images/figma/cyber-lab.png');
  $primaryCta = data_get($content, 'primary_cta', __('messages.hero.primary_cta'));
  $secondaryCta = data_get($content, 'secondary_cta', __('messages.hero.secondary_cta'));
  $visualLabel = data_get($content, 'visual_label', __('messages.hero.visual_card_kicker'));
  $visualPoint = data_get($content, 'visual_point', data_get(__('messages.hero.visual_points'), '0.value', __('messages.hero.image_alt')));

  if (blank($primaryCta)) {
      $primaryCta = __('messages.hero.primary_cta');
  }

  if (blank($secondaryCta)) {
      $secondaryCta = __('messages.hero.secondary_cta');
  }

  if (blank($visualLabel)) {
      $visualLabel = __('messages.hero.visual_card_kicker');
  }

  if (blank($visualPoint)) {
      $visualPoint = data_get(__('messages.hero.visual_points'), '0.value', __('messages.hero.image_alt'));
  }
@endphp

<section
  class="hero-v2"
  data-ready="false"
  x-bind:data-ready="ready ? 'true' : 'false'"
  x-data="heroSlider({
    slideLabel: @js((string) data_get($content, 'slide_label', __('messages.hero.slide_label'))),
    announcementTemplate: @js((string) data_get($content, 'slide_announcement', __('messages.hero.slide_announcement', ['current' => ':current', 'total' => ':total']))),
    totalSlides: {{ $totalSlides }},
    fontWaitMs: 650,
  })"
>
  <div class="section-inner">
    <div class="hero-v2__frame">
      <div class="swiper hero-v2__swiper" x-ref="swiper">
        <div class="swiper-wrapper">
          @foreach ($normalizedSlides as $slide)
            <article @class([
              'swiper-slide hero-v2__slide',
              'hero-v2__slide--lead' => $loop->first,
            ])>
              <div class="hero-v2__grid">
                <div class="hero-v2__content">
                  <p class="hero-v2__eyebrow">{{ data_get($content, 'kicker', __('messages.hero.kicker')) }}</p>

                  <div class="hero-v2__copy">
                    @php $headingTag = $loop->first ? 'h1' : 'h2'; @endphp
                    <{{ $headingTag }} class="hero-v2__title">
                      {{ $slide['title'] }}
                    </{{ $headingTag }}>

                    @if (filled($slide['subtitle']))
                      <p class="hero-v2__subtitle">{{ $slide['subtitle'] }}</p>
                    @endif
                  </div>

                  <div class="hero-v2__actions">
                    <x-ui.button route="contact" variant="hero" size="lg">{{ $primaryCta }}</x-ui.button>
                    <a href="{{ route('services') }}" class="hero-v2__secondary-link">
                      {{ $secondaryCta }}
                    </a>
                  </div>
                </div>

                <div class="hero-v2__visual">
                  <div class="hero-v2__visual-accent" aria-hidden="true"></div>
                  <div class="hero-v2__media-shell">
                    <div class="hero-v2__media">
                      <img
                        src="{{ $slide['image'] ?: $fallbackVisual }}"
                        alt="{{ data_get($content, 'image_alt', __('messages.hero.image_alt')) }}"
                        width="1200"
                        height="1200"
                        @if($loop->first) loading="eager" fetchpriority="high" @else loading="lazy" @endif
                        decoding="async"
                      />
                    </div>
                  </div>

                  <div class="hero-v2__stat-card" aria-hidden="true">
                    <span>{{ $visualLabel }}</span>
                    <strong>{{ $visualPoint }}</strong>
                  </div>
                </div>
              </div>
            </article>
          @endforeach
        </div>
      </div>

      @if ($totalSlides > 1)
        <div class="hero-v2__hud">
          <div class="hero-v2__pagination" x-ref="pagination"></div>
        </div>

        <p class="sr-only" aria-live="polite" aria-atomic="true" x-text="announcement"></p>
      @endif
    </div>
  </div>
</section>
