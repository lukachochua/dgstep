@props([
  'slides' => [],
  'content' => [],
])

@php
  $fallbackSlides = trans('messages.hero.slides');
  $rawSlides = !empty($slides) ? $slides : (is_array($fallbackSlides) ? $fallbackSlides : []);

  $normalizedSlides = collect($rawSlides)->map(function ($slide) {
      $buttonHref = data_get($slide, 'button_href') ?? data_get($slide, 'button.href') ?? data_get($slide, 'button.link');
      $buttonRoute = data_get($slide, 'button.route');

      if (blank($buttonHref) && filled($buttonRoute) && \Illuminate\Support\Facades\Route::has($buttonRoute)) {
          $buttonHref = route($buttonRoute);
      }

      if (blank($buttonHref)) {
          $buttonHref = route('contact');
      }

      return [
          'title' => (string) data_get($slide, 'title', ''),
          'subtitle' => (string) data_get($slide, 'subtitle', ''),
          'button_text' => (string) data_get($slide, 'button_text', data_get($slide, 'button.text', __('messages.hero.primary_cta'))),
          'button_href' => $buttonHref,
          'image' => data_get($slide, 'image'),
      ];
  })->filter(fn ($slide) => filled($slide['title']) || filled($slide['subtitle']))->values()->all();

  if (empty($normalizedSlides)) {
      $normalizedSlides[] = [
          'title' => __('messages.hero.title'),
          'subtitle' => __('messages.hero.subtitle'),
          'button_text' => __('messages.hero.primary_cta'),
          'button_href' => route('contact'),
          'image' => null,
      ];
  }

  $totalSlides = count($normalizedSlides);
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
              <p class="hero-v2__eyebrow">{{ data_get($content, 'kicker', __('messages.hero.kicker')) }}</p>

              <div class="hero-v2__grid">
                <div class="hero-v2__content">
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
                    <x-ui.button href="{{ $slide['button_href'] }}" variant="hero" size="lg">{{ $slide['button_text'] }}</x-ui.button>
                    <a href="{{ route('services') }}" class="hero-v2__secondary-link">
                      {{ data_get($content, 'secondary_cta', __('messages.hero.secondary_cta')) }}
                    </a>
                  </div>
                </div>

                <div class="hero-v2__visual">
                  <div class="hero-v2__media-shell">
                    <div class="hero-v2__media">
                      @if ($slide['image'])
                        <img
                          src="{{ $slide['image'] }}"
                          alt="{{ data_get($content, 'image_alt', __('messages.hero.image_alt')) }}"
                          width="1600"
                          height="1200"
                          @if($loop->first) loading="eager" fetchpriority="high" @else loading="lazy" @endif
                          decoding="async"
                        />
                      @else
                        <div class="hero-v2__media-fallback"></div>
                      @endif
                    </div>
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
