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
          'highlight' => (string) data_get($slide, 'highlight', ''),
          'subtitle' => (string) data_get($slide, 'subtitle', ''),
          'button_text' => (string) data_get($slide, 'button_text', data_get($slide, 'button.text', __('messages.hero.primary_cta'))),
          'button_href' => $buttonHref,
          'image' => data_get($slide, 'image'),
          'overlay_kicker' => (string) data_get($slide, 'overlay_kicker', ''),
          'overlay_points' => data_get($slide, 'overlay_points', []),
      ];
  })->filter(fn ($slide) => filled($slide['title']) || filled($slide['subtitle']))->values()->all();

  if (empty($normalizedSlides)) {
      $normalizedSlides[] = [
          'title' => __('messages.hero.title'),
          'highlight' => __('messages.hero.highlight'),
          'subtitle' => __('messages.hero.subtitle'),
          'button_text' => __('messages.hero.primary_cta'),
          'button_href' => route('contact'),
          'image' => null,
          'overlay_kicker' => '',
          'overlay_points' => [],
      ];
  }

  $audiences = data_get($content, 'audiences', trans('messages.hero.audiences'));
  $totalSlides = count($normalizedSlides);
@endphp

<section
  class="hero-v2"
  x-bind:data-ready="ready ? 'true' : 'false'"
  x-data="heroSlider({
    slideLabel: @js((string) data_get($content, 'slide_label', __('messages.hero.slide_label'))),
    announcementTemplate: @js((string) data_get($content, 'slide_announcement', __('messages.hero.slide_announcement', ['current' => ':current', 'total' => ':total']))),
    totalSlides: {{ $totalSlides }},
    fontWaitMs: 650,
  })"
>
  <div class="section-inner">
    <x-ui.surface-card as="div" variant="hero" class="hero-v2__frame">
      <div class="swiper hero-v2__swiper" x-ref="swiper">
        <div class="swiper-wrapper">
          @foreach ($normalizedSlides as $slide)
            <article class="swiper-slide hero-v2__slide">
              <div class="hero-v2__grid" data-reveal-ltr-group>
                <div class="hero-v2__content ltr-reveal" data-reveal-ltr>
                  <div class="hero-v2__content-main">
                    <p class="hero-v2__kicker">{{ data_get($content, 'kicker', __('messages.hero.kicker')) }}</p>

                    <div class="hero-v2__copy">
                      @php $headingTag = $loop->first ? 'h1' : 'h2'; @endphp
                      <{{ $headingTag }} class="hero-v2__title">
                        {{ $slide['title'] }}
                        @if (filled($slide['highlight']))
                          <span class="hero-highlight">{{ $slide['highlight'] }}</span>
                        @endif
                      </{{ $headingTag }}>

                      @if (filled($slide['subtitle']))
                        <p class="hero-v2__subtitle">{{ $slide['subtitle'] }}</p>
                      @endif
                    </div>
                  </div>

                  <div class="hero-v2__content-footer">
                    <div class="hero-v2__actions">
                      <x-ui.button href="{{ $slide['button_href'] }}" variant="hero" size="lg">{{ $slide['button_text'] }}</x-ui.button>
                      <span class="hero-v2__secondary-action">
                        <x-ui.button route="services" variant="ghost" size="lg">{{ data_get($content, 'secondary_cta', __('messages.hero.secondary_cta')) }}</x-ui.button>
                      </span>
                    </div>

                    @if (is_array($audiences) && count($audiences) > 0)
                      <div class="hero-v2__audience-block">
                        <p class="hero-v2__eyebrow">{{ data_get($content, 'audiences_label', __('messages.hero.audiences_label')) }}</p>
                        <ul class="hero-v2__audiences" aria-label="{{ data_get($content, 'audiences_label', __('messages.hero.audiences_label')) }}">
                          @foreach ($audiences as $audience)
                            <li>{{ $audience }}</li>
                          @endforeach
                        </ul>
                      </div>
                    @endif
                  </div>
                </div>

                <div class="hero-v2__visual ltr-reveal" data-reveal-ltr>
                  <div class="hero-v2__media-shell">
                    <div class="hero-v2__media-index" aria-hidden="true">
                      {{ str_pad((string) ($loop->iteration), 2, '0', STR_PAD_LEFT) }}
                      <span>/</span>
                      {{ str_pad((string) $totalSlides, 2, '0', STR_PAD_LEFT) }}
                    </div>

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

                    @if (is_array($slide['overlay_points'] ?? null) && count($slide['overlay_points']) > 0)
                      <x-ui.surface-card as="div" variant="hero-detail" class="hero-v2__overlay-card">
                        <p class="hero-v2__overlay-kicker">{{ $slide['overlay_kicker'] }}</p>
                        <ul class="hero-v2__overlay-list">
                          @foreach ($slide['overlay_points'] as $point)
                            <li>
                              <p class="hero-v2__overlay-title">{{ $point['label'] ?? '' }}</p>
                              <p class="hero-v2__overlay-copy">{{ $point['value'] ?? '' }}</p>
                            </li>
                          @endforeach
                        </ul>
                      </x-ui.surface-card>
                    @endif
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
    </x-ui.surface-card>
  </div>
</section>
