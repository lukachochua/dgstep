@props([
  'slides' => [],
  'isKaLocale' => false,
  'isEnLocale' => false,
  'heroHeadingScale' => 'text-4xl md:text-5xl',
  'heroSubtitleScale' => 'text-base md:text-lg',
])

@php
  $fallbackSlides = trans('messages.hero.slides');
  $usingFallbackSlides = empty($slides);
  $rawSlides = !$usingFallbackSlides ? $slides : (is_array($fallbackSlides) ? $fallbackSlides : []);

  $normalizedSlides = collect($rawSlides)->map(function ($slide) use ($usingFallbackSlides) {
      $title = (string) data_get($slide, 'title', '');
      $buttonHref = data_get($slide, 'button.href') ?? data_get($slide, 'button.link');

      if (blank($buttonHref) || ($usingFallbackSlides && is_string($buttonHref) && str_starts_with($buttonHref, '#'))) {
          $buttonHref = route('contact');
      }

      return [
          'title' => $title,
          'highlight' => (string) data_get($slide, 'highlight', ''),
          'subtitle' => (string) data_get($slide, 'subtitle', ''),
          'button_text' => (string) data_get($slide, 'button.text', __('contact.cta_button')),
          'button_href' => $buttonHref,
          'image' => data_get($slide, 'image'),
      ];
  })->filter(fn ($slide) => filled($slide['title']) || filled($slide['subtitle']))->values()->all();

  if (empty($normalizedSlides)) {
      $normalizedSlides[] = [
          'title' => __('messages.features.heading'),
          'highlight' => __('messages.features.subheading'),
          'subtitle' => __('contact.description'),
          'button_text' => __('contact.cta_button'),
          'button_href' => route('contact'),
          'image' => null,
      ];
  }

  $localeTag = $isKaLocale && ! $isEnLocale ? 'KA' : ($isEnLocale && ! $isKaLocale ? 'EN' : 'KA/EN');
  $totalSlides = count($normalizedSlides);
@endphp

<section
  class="hero-v2 reveal"
  x-data="{
    swiper: null,
    progress: {{ $totalSlides > 1 ? 0 : 100 }},
    pauseAutoplay() {
      if (!this.swiper || !this.swiper.autoplay) return;
      if (typeof this.swiper.autoplay.pause === 'function') {
        this.swiper.autoplay.pause();
        return;
      }
      if (typeof this.swiper.autoplay.stop === 'function') {
        this.swiper.autoplay.stop();
      }
    },
    resumeAutoplay() {
      if (!this.swiper || !this.swiper.autoplay) return;
      if (typeof this.swiper.autoplay.resume === 'function') {
        this.swiper.autoplay.resume();
        return;
      }
      if (typeof this.swiper.autoplay.start === 'function') {
        this.swiper.autoplay.start();
      }
    },
    init() {
      this.$nextTick(() => {
        if (!window.Swiper) return;

        const hasMany = {{ $totalSlides }} > 1;

        this.swiper = new window.Swiper(this.$refs.swiper, {
          modules: window.SwiperModules
            ? [window.SwiperModules.Navigation, window.SwiperModules.Pagination, window.SwiperModules.Autoplay]
            : [],
          slidesPerView: 1,
          loop: hasMany,
          speed: 680,
          allowTouchMove: hasMany,
          autoplay: hasMany
            ? {
                delay: 6500,
                disableOnInteraction: false,
                pauseOnMouseEnter: false,
              }
            : false,
          navigation: hasMany
            ? {
                prevEl: this.$refs.prev,
                nextEl: this.$refs.next,
              }
            : undefined,
          pagination: hasMany
            ? {
                el: this.$refs.pagination,
                clickable: true,
                bulletClass: 'hero-v2__dot',
                bulletActiveClass: 'is-active',
              }
            : undefined,
          on: {
            autoplayTimeLeft: (_swiper, _time, ratio) => {
              this.progress = (1 - ratio) * 100;
            },
          },
        });
      });
    },
  }"
>
  <div class="hero-v2__frame">
    <div class="swiper hero-v2__swiper" x-ref="swiper">
      <div class="swiper-wrapper">
        @foreach ($normalizedSlides as $slide)
          <article class="swiper-slide hero-v2__slide">
            <div class="hero-v2__media" aria-hidden="true">
              @if (!empty($slide['image']))
                <img src="{{ $slide['image'] }}" alt="" loading="lazy" decoding="async" />
              @else
                <div class="hero-v2__media-fallback"></div>
              @endif
            </div>

            <div class="hero-v2__veil" aria-hidden="true"></div>

            <div class="hero-v2__content">
              <div class="hero-v2__layout">
                <div class="hero-v2__primary">
                  <p class="hero-v2__kicker">
                    <span class="inline-flex h-1.5 w-1.5 rounded-full bg-[color:var(--brand)]"></span>
                    {{ $localeTag }} DGstep SaaS
                  </p>

                  <h1 class="hero-v2__title">
                    {{ $slide['title'] }}
                    @if (filled($slide['highlight']))
                      <span class="hero-highlight">{{ $slide['highlight'] }}</span>
                    @endif
                  </h1>

                  @if (filled($slide['subtitle']))
                    <p class="hero-v2__subtitle">{{ $slide['subtitle'] }}</p>
                  @endif

                  <div class="hero-v2__actions">
                    <x-ui.button
                      href="{{ $slide['button_href'] }}"
                      variant="hero"
                      size="lg"
                      x-on:mouseenter="pauseAutoplay()"
                      x-on:mouseleave="resumeAutoplay()"
                      x-on:focusin="pauseAutoplay()"
                      x-on:focusout="resumeAutoplay()"
                    >
                      {{ $slide['button_text'] }}
                    </x-ui.button>
                    <x-ui.button
                      route="services"
                      variant="ghost"
                      size="lg"
                      x-on:mouseenter="pauseAutoplay()"
                      x-on:mouseleave="resumeAutoplay()"
                      x-on:focusin="pauseAutoplay()"
                      x-on:focusout="resumeAutoplay()"
                    >
                      {{ __('messages.services') }}
                    </x-ui.button>
                  </div>
                </div>

                <aside class="hero-v2__insights" aria-label="{{ __('messages.hero.ui.insights_aria') }}">
                  <article class="hero-v2__insight hero-v2__insight--lead">
                    <p class="hero-v2__insight-label">{{ __('messages.hero.ui.slide_label') }}</p>
                    <p class="hero-v2__insight-value">
                      {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}/{{ str_pad((string) $totalSlides, 2, '0', STR_PAD_LEFT) }}
                    </p>
                  </article>

                  <div class="hero-v2__insight-grid">
                    <article class="hero-v2__insight">
                      <p class="hero-v2__insight-label">{{ __('messages.hero.ui.coverage_label') }}</p>
                      <p class="hero-v2__insight-value">{{ __('messages.hero.ui.coverage_value') }}</p>
                    </article>
                    <article class="hero-v2__insight">
                      <p class="hero-v2__insight-label">{{ __('messages.hero.ui.delivery_label') }}</p>
                      <p class="hero-v2__insight-value">{{ __('messages.hero.ui.delivery_value') }}</p>
                    </article>
                  </div>

                  <div class="hero-v2__insight-tags">
                    <span>{{ __('messages.hero.ui.tag_workflow') }}</span>
                    <span>{{ __('messages.hero.ui.tag_compliance') }}</span>
                    <span>{{ __('messages.hero.ui.tag_smb') }}</span>
                  </div>
                </aside>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    </div>

    @if ($totalSlides > 1)
      <button
        type="button"
        class="hero-v2__nav hero-v2__nav--prev"
        x-ref="prev"
        aria-label="{{ __('messages.hero.ui.prev_slide') }}"
        x-on:mouseenter="pauseAutoplay()"
        x-on:mouseleave="resumeAutoplay()"
        x-on:focusin="pauseAutoplay()"
        x-on:focusout="resumeAutoplay()"
      >
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M15 18l-6-6 6-6" />
        </svg>
      </button>

      <button
        type="button"
        class="hero-v2__nav hero-v2__nav--next"
        x-ref="next"
        aria-label="{{ __('messages.hero.ui.next_slide') }}"
        x-on:mouseenter="pauseAutoplay()"
        x-on:mouseleave="resumeAutoplay()"
        x-on:focusin="pauseAutoplay()"
        x-on:focusout="resumeAutoplay()"
      >
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M9 6l6 6-6 6" />
        </svg>
      </button>

      <div class="hero-v2__hud">
        <div class="hero-v2__progress" aria-hidden="true">
          <span class="hero-v2__progress-fill" :style="{ width: `${Math.min(100, Math.max(0, progress))}%` }"></span>
        </div>
        <div
          class="hero-v2__pagination"
          x-ref="pagination"
          x-on:mouseenter="pauseAutoplay()"
          x-on:mouseleave="resumeAutoplay()"
        ></div>
      </div>
    @endif
  </div>
</section>
