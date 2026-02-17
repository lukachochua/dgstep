@props([
  'slides' => [],
  'heroHeadingScale' => 'clamp(1.48rem, 2.7vw, 2.75rem)',
  'heroSubtitleScale' => 'clamp(0.9rem, 1.1vw, 1rem)',
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

  $totalSlides = count($normalizedSlides);
@endphp

<section
  class="hero-v2 reveal"
  style="--hero-title-size: {{ $heroHeadingScale }}; --hero-subtitle-size: {{ $heroSubtitleScale }};"
  x-data="{
    swiper: null,
    visibilityHandler: null,
    progress: {{ $totalSlides > 1 ? 0 : 100 }},
    autoplayEnabled: {{ $totalSlides > 1 ? 'true' : 'false' }},
    userPaused: false,
    manualNavigation: false,
    announcement: '',
    slideLabel: @js(__('messages.hero.ui.slide_label')),
    slideAnnouncementTemplate: @js(__('messages.hero.ui.slide_announcement', ['current' => ':current', 'total' => ':total'])),
    pauseButtonLabel: @js(__('messages.hero.ui.pause_autoplay')),
    playButtonLabel: @js(__('messages.hero.ui.play_autoplay')),
    markManualNavigation() {
      this.manualNavigation = true;
    },
    announceSlide(currentIndex) {
      this.announcement = this.slideAnnouncementTemplate
        .replace(':current', String(currentIndex))
        .replace(':total', String({{ $totalSlides }}));
    },
    pauseAutoplay(userInitiated = false) {
      if (!this.autoplayEnabled || !this.swiper || !this.swiper.autoplay) return;
      if (typeof this.swiper.autoplay.pause === 'function') {
        this.swiper.autoplay.pause();
      } else if (typeof this.swiper.autoplay.stop === 'function') {
        this.swiper.autoplay.stop();
      }
      if (userInitiated) this.userPaused = true;
    },
    resumeAutoplay(force = false) {
      if (!this.autoplayEnabled || !this.swiper || !this.swiper.autoplay) return;
      if (this.userPaused && !force) return;
      if (typeof this.swiper.autoplay.resume === 'function') {
        this.swiper.autoplay.resume();
      } else if (typeof this.swiper.autoplay.start === 'function') {
        this.swiper.autoplay.start();
      }
      if (force) this.userPaused = false;
    },
    toggleAutoplay() {
      if (!this.autoplayEnabled) return;
      if (this.userPaused) {
        this.resumeAutoplay(true);
        return;
      }
      this.pauseAutoplay(true);
    },
    init() {
      this.$nextTick(() => {
        if (!window.Swiper) return;

        const hasMany = {{ $totalSlides }} > 1;
        const reducedMotionQuery = window.matchMedia ? window.matchMedia('(prefers-reduced-motion: reduce)') : null;

        this.autoplayEnabled = hasMany && !(reducedMotionQuery && reducedMotionQuery.matches);

        if (!this.autoplayEnabled) {
          this.progress = 100;
        }

        this.swiper = new window.Swiper(this.$refs.swiper, {
          modules: window.SwiperModules
            ? [window.SwiperModules.Navigation, window.SwiperModules.Pagination, window.SwiperModules.Autoplay]
            : [],
          slidesPerView: 1,
          loop: hasMany,
          speed: 680,
          allowTouchMove: hasMany,
          autoplay: this.autoplayEnabled
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
                renderBullet: (index, className) => `<button type='button' class='${className}' aria-label='${this.slideLabel} ${index + 1}'></button>`,
              }
            : undefined,
          on: {
            touchStart: () => {
              this.markManualNavigation();
            },
            slideChange: (swiper) => {
              if (!this.manualNavigation) return;
              const currentIndex = (swiper.realIndex ?? 0) + 1;
              this.announceSlide(currentIndex);
              this.manualNavigation = false;
            },
            autoplayTimeLeft: (_swiper, _time, ratio) => {
              this.progress = (1 - ratio) * 100;
            },
          },
        });

        if (hasMany) {
          this.visibilityHandler = () => {
            if (document.hidden) {
              this.pauseAutoplay();
              return;
            }

            this.resumeAutoplay();
          };

          document.addEventListener('visibilitychange', this.visibilityHandler);
          this.$refs.pagination?.addEventListener('click', () => this.markManualNavigation());
        }
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
                <img
                  src="{{ $slide['image'] }}"
                  alt=""
                  width="1920"
                  height="1080"
                  @if($loop->first) loading="eager" fetchpriority="high" @else loading="lazy" @endif
                  decoding="async"
                />
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
                    {{ __('messages.hero.ui.kicker') }}
                  </p>

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
        x-on:click="markManualNavigation()"
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
        x-on:click="markManualNavigation()"
        x-on:mouseenter="pauseAutoplay()"
        x-on:mouseleave="resumeAutoplay()"
        x-on:focusin="pauseAutoplay()"
        x-on:focusout="resumeAutoplay()"
      >
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M9 6l6 6-6 6" />
        </svg>
      </button>

      <button
        type="button"
        class="hero-v2__autoplay-toggle"
        x-show="autoplayEnabled"
        x-cloak
        x-on:click="toggleAutoplay()"
        :aria-label="userPaused ? playButtonLabel : pauseButtonLabel"
      >
        <svg x-show="!userPaused" x-cloak class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <rect x="6" y="5" width="4" height="14" rx="1"></rect>
          <rect x="14" y="5" width="4" height="14" rx="1"></rect>
        </svg>
        <svg x-show="userPaused" x-cloak class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path d="M8 5v14l11-7z"></path>
        </svg>
        <span class="sr-only" x-text="userPaused ? playButtonLabel : pauseButtonLabel"></span>
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

      <p class="sr-only" aria-live="polite" aria-atomic="true" x-text="announcement"></p>
    @endif
  </div>
</section>
