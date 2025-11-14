@props([
  'slides' => [],
  'isKaLocale' => false,
  'isEnLocale' => false,
  'heroHeadingScale' => 'text-5xl md:text-5xl lg:text-6xl',
  'heroSubtitleScale' => 'text-2xl md:text-xl lg:text-xl',
])

@php
  $fallbackHeroCta = trans('messages.footer.cta');
  $firstSlide = $slides[0] ?? null;
  $slidesCount = count($slides);
  $slidesCountDisplay = str_pad((string) max(1, $slidesCount), 2, '0', STR_PAD_LEFT);
  $heroLocaleLabel = match (true) {
    $isKaLocale && !$isEnLocale => 'KA',
    $isEnLocale && !$isKaLocale => 'EN',
    default => 'KA · EN',
  };
  $defaultHeroSubtitle = 'DGstep orchestrates every workflow in one secure platform.';
  $heroCycleSeconds = number_format(7500 / 1000, 1);
  $slideImages = [];
  foreach ($slides as $slide) {
    $image = $slide['image'] ?? null;
    if (!empty($image)) {
      $slideImages[] = $image;
    }
  }
  $preloadImages = array_slice($slideImages, 1);
@endphp

<section
  x-data="(() => {
    const motionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');

    return {
      activeSlide: 0,
      textColH: 0,
      textBlockH: 0,
      timer: null,
      raf: null,
      progress: 0,
      elapsed: 0,
      startedAt: null,
      cycleDuration: 7500,
      prefersReduced: motionQuery.matches,
      motionQuery,
      manualPause: false,
      slideCount: {{ $slidesCount }},
      preloadImages: @js($preloadImages),
      gesture: { pointerId: null, startX: 0, startY: 0, startTime: 0, deltaX: 0, deltaY: 0, active: false },
      swipeThreshold: 48,
      swipeVerticalLimit: 80,
      pointerHandlers: null,

      canAuto() {
        const visible = this.$root?.offsetParent !== null;
        return visible && !this.prefersReduced && this.slideCount > 1;
      },

      clearTimers() {
        if (this.timer) {
          clearTimeout(this.timer);
          this.timer = null;
        }
        if (this.raf) {
          cancelAnimationFrame(this.raf);
          this.raf = null;
        }
      },

      resumeCycle({ reset = false } = {}) {
        if (!this.canAuto()) {
          this.clearTimers();
          this.progress = 0;
          this.elapsed = 0;
          this.startedAt = null;
          return;
        }

        if (reset) {
          this.elapsed = 0;
          this.progress = 0;
        }

        if (this.manualPause) return;

        this.clearTimers();

        const step = (timestamp) => {
          if (this.startedAt === null) {
            this.startedAt = timestamp - this.elapsed;
          }

          this.elapsed = timestamp - this.startedAt;
          const pct = Math.min(1, this.elapsed / this.cycleDuration);
          this.progress = Number.isFinite(pct) ? pct : 0;

          if (this.progress >= 1) return;
          this.raf = requestAnimationFrame(step);
        };

        this.startedAt = null;
        this.raf = requestAnimationFrame(step);

        const remaining = Math.max(0, this.cycleDuration - this.elapsed);
        this.timer = setTimeout(() => {
          this.elapsed = 0;
          this.progress = 0;
          this.next({ origin: 'auto' });
        }, remaining || this.cycleDuration);
      },

      pauseCycle() {
        if (!this.canAuto()) return;

        if (this.startedAt !== null) {
          const now = performance.now();
          this.elapsed = Math.min(this.cycleDuration, Math.max(0, now - this.startedAt));
        }

        this.clearTimers();
        this.startedAt = null;
      },

      start(origin = 'manual') {
        if (origin === 'hover' || origin === 'focus') this.manualPause = false;
        this.resumeCycle();
      },

      restart() {
        this.resumeCycle({ reset: true });
      },

      stop(origin = 'manual') {
        if (origin === 'hover' || origin === 'focus') this.manualPause = true;
        this.pauseCycle();
      },

      next({ origin = 'manual' } = {}) {
        if (!this.slideCount) return;
        this.activeSlide = (this.activeSlide + 1) % this.slideCount;
        this.resumeCycle({ reset: true });
      },

      prev() {
        if (!this.slideCount) return;
        this.activeSlide = (this.activeSlide - 1 + this.slideCount) % this.slideCount;
        this.resumeCycle({ reset: true });
      },

      goTo(index) {
        if (index === this.activeSlide) return;
        if (index >= 0 && index < this.slideCount) {
          this.activeSlide = index;
          this.resumeCycle({ reset: true });
        }
      },

      dotStyle(index) {
        if (index !== this.activeSlide) return '--hero-dot-progress:0;';
        const value = Math.min(1, Math.max(0, this.progress || 0));
        return `--hero-dot-progress:${value.toFixed(3)};`;
      },

      resetGesture() {
        this.gesture.pointerId = null;
        this.gesture.startX = 0;
        this.gesture.startY = 0;
        this.gesture.startTime = 0;
        this.gesture.deltaX = 0;
        this.gesture.deltaY = 0;
        this.gesture.active = false;
      },

      onPointerDown(event) {
        if (event.pointerType !== 'touch') return;

        if (event.target?.closest('button, a, input, textarea, select, [role=button], [data-hero-gesture-ignore]')) {
          this.resetGesture();
          return;
        }

        this.gesture.pointerId = event.pointerId;
        this.gesture.startX = event.clientX;
        this.gesture.startY = event.clientY;
        this.gesture.startTime = performance.now();
        this.gesture.deltaX = 0;
        this.gesture.deltaY = 0;
        this.gesture.active = true;
      },

      onPointerMove(event) {
        if (!this.gesture.active || event.pointerId !== this.gesture.pointerId) return;

        this.gesture.deltaX = event.clientX - this.gesture.startX;
        this.gesture.deltaY = event.clientY - this.gesture.startY;
      },

      onPointerUp(event) {
        if (!this.gesture.active || event.pointerId !== this.gesture.pointerId) return;

        const deltaX = event.clientX - this.gesture.startX;
        const deltaY = event.clientY - this.gesture.startY;
        const horizontal = Math.abs(deltaX);
        const vertical = Math.abs(deltaY);

        if (horizontal >= this.swipeThreshold && horizontal > vertical * 1.25 && vertical < this.swipeVerticalLimit) {
          if (deltaX < 0) {
            this.next({ origin: 'swipe' });
          } else {
            this.prev();
          }
        }

        this.resetGesture();
      },

      onPointerCancel(event) {
        if (event.pointerId !== this.gesture.pointerId) return;
        this.resetGesture();
      },

      isMobileLayout() {
        return typeof window !== 'undefined' && window.matchMedia('(max-width: 1023px)').matches;
      },

      measure() {
        const meas  = this.$refs.textMeasure;
        const inner = this.$refs.inner;
        if (!meas || !inner) return;

        const avail = Math.max(380, (inner.clientHeight || window.innerHeight) - 32);

        let maxCol = 0;
        meas.querySelectorAll('[data-measure=slide]').forEach(n => { maxCol = Math.max(maxCol, n.offsetHeight); });

        let maxGroup = 0;
        meas.querySelectorAll('[data-measure=hgroup]').forEach(n => { maxGroup = Math.max(maxGroup, n.offsetHeight); });

        const reservedCTA = 180;
        const minBlock = 320;
        const blockHeight = Math.max(minBlock, Math.ceil(maxGroup + 1));
        this.textColH = Math.max(blockHeight + reservedCTA, 520);
        this.textBlockH = this.textColH - reservedCTA;
      },

      stackHeightStyle() {
        if (this.isMobileLayout()) return '';
        const fallback = 520;
        const min = 360;
        const value = Math.max(min, this.textColH || fallback);
        return `min-height:${value}px;`;
      },

      textBlockStyle() {
        if (this.isMobileLayout()) return '';
        const fallback = 320;
        const min = 240;
        const value = Math.max(min, this.textBlockH || fallback);
        return `min-height:${value}px;height:${value}px`;
      },

      init() {
        const preloadRest = () => {
          if (!Array.isArray(this.preloadImages) || this.preloadImages.length === 0) return;
          this.preloadImages.forEach((src) => {
            if (!src) return;
            const img = new Image();
            img.src = src;
          });
        };

        preloadRest();
        const visibilityHandler = () => document.hidden ? this.pauseCycle() : this.resumeCycle();
        const motionHandler = (event) => {
          this.prefersReduced = event.matches;
          if (event.matches) {
            this.pauseCycle();
            this.progress = 0;
            this.elapsed = 0;
          } else {
            this.resumeCycle({ reset: true });
          }
        };
        let motionCleanup = null;
        const root = this.$root;

        this.$nextTick(() => {
          this.measure();
          requestAnimationFrame(() => {
            this.resumeCycle({ reset: true });
          });
        });

        const ro = new ResizeObserver(() => this.measure());
        ro.observe(this.$root);

        if (root) {
          const handlers = {
            down: (event) => this.onPointerDown(event),
            move: (event) => this.onPointerMove(event),
            up:   (event) => this.onPointerUp(event),
            cancel: (event) => this.onPointerCancel(event),
          };

          root.addEventListener('pointerdown', handlers.down, { passive: true });
          root.addEventListener('pointermove', handlers.move, { passive: true });
          root.addEventListener('pointerup', handlers.up, { passive: true });
          root.addEventListener('pointercancel', handlers.cancel, { passive: true });

          this.pointerHandlers = { root, handlers };
        }

        document.addEventListener('visibilitychange', visibilityHandler);
        if (typeof this.motionQuery.addEventListener === 'function') {
          this.motionQuery.addEventListener('change', motionHandler);
          motionCleanup = () => this.motionQuery.removeEventListener('change', motionHandler);
        } else if (typeof this.motionQuery.addListener === 'function') {
          this.motionQuery.addListener(motionHandler);
          motionCleanup = () => this.motionQuery.removeListener(motionHandler);
        }

        return () => {
          this.clearTimers();
          ro.disconnect();
          document.removeEventListener('visibilitychange', visibilityHandler);
          if (motionCleanup) motionCleanup();
          if (this.pointerHandlers?.root) {
            const { root, handlers } = this.pointerHandlers;
            root.removeEventListener('pointerdown', handlers.down);
            root.removeEventListener('pointermove', handlers.move);
            root.removeEventListener('pointerup', handlers.up);
            root.removeEventListener('pointercancel', handlers.cancel);
            this.pointerHandlers = null;
          }
        };
      }
    };
  })()"
  x-init="init()"
  @keydown.arrow-right.prevent="next()" @keydown.arrow-left.prevent="prev()"
  tabindex="0" role="region" aria-roledescription="carousel" aria-label="DGstep hero"
  class="hero-surface relative z-0 select-none overflow-hidden text-[color:var(--hero-ink)] touch-pan-y pb-16"
  style="padding-top: 0;">
  <!-- Backgrounds -->
  {{-- @foreach ($slides as $index => $slide)
    <div
      x-show="activeSlide === {{ $index }}"
      style="{{ $index === 0 ? '' : 'display:none;' }}"
      class="pointer-events-none absolute inset-0" aria-hidden="true"
    >
      @if(!empty($slide['image']))
        <img
          src="{{ $slide['image'] }}"
          alt=""
          loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
          fetchpriority="{{ $index === 0 ? 'high' : 'auto' }}"
          decoding="async"
          class="hero-bgimg w-full h-full object-cover opacity-[var(--hero-img-opacity)] mix-blend-[var(--hero-img-blend)]"
        />
      @endif
    </div>
  @endforeach --}}

  <div aria-hidden="true" class="hero-cyber-layers absolute inset-0 z-[1] pointer-events-none">
    <div class="hero-cyber-grid"></div>
    <div class="hero-cyber-gradient hero-cyber-gradient--one"></div>
    <div class="hero-cyber-gradient hero-cyber-gradient--two"></div>
    <div class="hero-cyber-scanline"></div>
  </div>

  <!-- Foreground -->
  <div class="relative mt-20 sm:mt-24 lg:mt-28 z-10 mx-auto max-w-[var(--container-content)] px-4 sm:px-6 md:px-8">
    <!-- Mobile: render hero copy inside the same card styling -->
    <div class="md:hidden">
      <div class="w-full max-w-2xl mx-auto">
        <div class="hero-mobile-systems" style="min-height: 65vh; height: 65vh; max-height: 65vh;">
          <div class="hero-mobile-systems__stack relative h-full overflow-hidden">
            @foreach ($slides as $index => $slide)
              @php
                $slideNumber = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                $slideTitle = data_get($slide, 'title');
                $slideHighlight = data_get($slide, 'highlight');
                $buttonHref = data_get($slide, 'button.href')
                  ?? data_get($slide, 'button.link')
                  ?? data_get($slide, 'button_href')
                  ?? data_get($slide, 'button_link');
                $buttonText = data_get($slide, 'button.text')
                  ?? data_get($slide, 'button_text')
                  ?? $fallbackHeroCta;
                $slideSubtitleRaw = data_get($slide, 'subtitle');
                $slideSubtitle = is_string($slideSubtitleRaw) ? trim($slideSubtitleRaw) : '';
                $systemsSubtitle = $slideSubtitle !== '' ? $slideSubtitle : $defaultHeroSubtitle;
              @endphp
              <article
                x-show="activeSlide === {{ $index }}"
                style="{{ $index === 0 ? '' : 'display:none;' }}"
                class="hero-systems-card flex flex-col h-full"
              >
                <div class="hero-systems-panel hero-systems-panel--mobile hero-systems-panel--copy">
                  <div class="hero-systems-panel__header">
                    <span class="hero-systems-chip">{{ $heroLocaleLabel }}</span>
                    <span class="hero-systems-cycle">Cycle {{ $heroCycleSeconds }}s</span>
                    <span class="hero-systems-id">Slide {{ $slideNumber }}/{{ $slidesCountDisplay }}</span>
                  </div>
                  <div class="hero-systems-panel__body hero-systems-panel__body--copy text-left">
                    <div class="hero-systems-body hero-systems-body--copy">
                      <h1 class="{{ $heroHeadingScale }} hero-heading hero-cyber-title leading-[1.08] tracking-tight [text-wrap:balance] space-y-3">
                        <span class="block">{{ $slideTitle }}</span>
                        <span class="hero-highlight block">{{ $slideHighlight }}</span>
                      </h1>
                      <p class="{{ $heroSubtitleScale }} hero-subtitle leading-relaxed">{{ $systemsSubtitle }}</p>
                    </div>
                    <div class="hero-actions hero-actions--mobile justify-start">
                      @if ($buttonHref)
                        <x-ui.button
                          href="{{ $buttonHref }}"
                          x-on:mouseenter="stop('hover')"
                          x-on:mouseleave="start('hover')"
                          x-on:focusin="stop('focus')"
                          x-on:focusout="start('focus')"
                          variant="hero" size="lg" class="shrink-0">
                          <span>{{ $buttonText }}</span>
                        </x-ui.button>
                      @endif
                    </div>
                  </div>
                </div>
              </article>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <!-- Desktop: Both sides visible -->
    <div class="hidden md:block">
      <div
        x-ref="inner"
        class="hero-cyber-layout hero-split-card min-h-[80svh]
               md:min-h-[calc(94svh-var(--navbar-h)-1.5rem)]
               grid grid-cols-1 lg:grid-cols-2
               items-stretch gap-10 md:gap-14"
      >
        <!-- Left: Text Column -->
        <div class="w-full max-w-4xl relative z-10 mx-auto flex flex-col justify-center">
          <div class="hero-info-card text-center md:text-left" :style="stackHeightStyle()">
            <div class="relative hero-slide-stack" :style="stackHeightStyle()">
              @foreach ($slides as $index => $slide)
                @php
                  $slideNumber = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                  $slideTitle = data_get($slide, 'title');
                  $slideHighlight = data_get($slide, 'highlight');
                  $buttonHref = data_get($slide, 'button.href')
                    ?? data_get($slide, 'button.link')
                    ?? data_get($slide, 'button_href')
                    ?? data_get($slide, 'button_link');
                  $buttonText = data_get($slide, 'button.text')
                    ?? data_get($slide, 'button_text')
                    ?? $fallbackHeroCta;
                  $slideSubtitleRaw = data_get($slide, 'subtitle');
                  $slideSubtitle = is_string($slideSubtitleRaw) ? trim($slideSubtitleRaw) : '';
                  $slideMetrics = data_get($slide, 'metrics');
                  $slideMetrics = is_array($slideMetrics) ? $slideMetrics : [];
                  $automationDefault = min(99.9, 88 + ($index * 3.25));
                  $slideTelemetry = [
                    'automation' => $slideMetrics['automation'] ?? number_format($automationDefault, 1) . '%',
                    'latency' => $slideMetrics['latency'] ?? number_format(0.24 + $index * 0.05, 2) . 's',
                    'throughput' => $slideMetrics['throughput'] ?? number_format(22 + $index * 4) . 'k ops',
                    'uptime' => $slideMetrics['uptime'] ?? '99.982%',
                  ];
                  $systemsSubtitle = $slideSubtitle !== '' ? $slideSubtitle : $defaultHeroSubtitle;
                @endphp
                <article
                  x-show="activeSlide === {{ $index }}"
                  style="{{ $index === 0 ? '' : 'display:none;' }}"
                  class="hero-slide-panel absolute inset-0 flex flex-col"
                  role="group"
                  aria-roledescription="slide"
                  aria-label="Slide {{ $index + 1 }} of {{ $slidesCount }}"
                  x-bind:aria-hidden="activeSlide !== {{ $index }}"
                  :class="{ 'pointer-events-none': activeSlide !== {{ $index }}, 'pointer-events-auto': activeSlide === {{ $index }} }"
                >
                  <div
                    class="hero-slide-body"
                    :style="textBlockStyle()"
                    x-show="activeSlide === {{ $index }}"
                    x-transition:enter="transition-opacity ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                  >
                    <div class="space-y-6 md:space-y-8">
                      <h1 class="{{ $heroHeadingScale }} hero-heading hero-cyber-title leading-[1.05] tracking-tight [text-wrap:balance] mx-auto md:mx-0 space-y-4">
                        <span class="block">{{ $slideTitle }}</span>
                        <span class="hero-highlight block">{{ $slideHighlight }}</span>
                      </h1>
                    </div>
                  </div>
                  <div
                    class="hero-slide-footer"
                    x-show="activeSlide === {{ $index }}"
                  >
                    <div class="hero-actions">
                      @if ($buttonHref)
                        <x-ui.button
                          href="{{ $buttonHref }}"
                          x-on:mouseenter="stop('hover')"
                          x-on:mouseleave="start('hover')"
                          x-on:focusin="stop('focus')"
                          x-on:focusout="start('focus')"
                          variant="hero" size="lg" class="shrink-0">
                          <span>{{ $buttonText }}</span>
                        </x-ui.button>
                      @endif
                    </div>
                  </div>
                </article>
              @endforeach
            </div>
          </div>

          <div aria-hidden="true" class="invisible absolute -left-[9999px] top-auto text-left md:text-left" x-ref="textMeasure">
            @foreach ($slides as $index => $slide)
              @php
                $slideNumber = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                $slideTitle = data_get($slide, 'title');
                $slideHighlight = data_get($slide, 'highlight');
                $slideSubtitleRaw = data_get($slide, 'subtitle');
                $slideSubtitle = is_string($slideSubtitleRaw) ? trim($slideSubtitleRaw) : '';
              @endphp
              <div class="w-[100ch]" data-measure="slide">
                <div data-measure="hgroup" class="space-y-7 md:space-y-8">
                  <h1 class="{{ $heroHeadingScale }} hero-heading hero-cyber-title leading-[1.1] tracking-tight space-y-4">
                    <span class="block">{{ $slideTitle }}</span>
                    <span class="hero-highlight block">{{ $slideHighlight }}</span>
                  </h1>
                </div>
                <div class="hero-actions hero-actions--measure">
                  <span class="inline-flex h-12 w-48 rounded-full border border-white/20"></span>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <!-- Right: Systems Panel -->
        <div class="hero-cyber-visual w-full max-w-xl lg:max-w-2xl mx-auto relative flex flex-col justify-center">
          <div class="hero-orb hero-orb--primary" aria-hidden="true"></div>
          <div class="hero-orb hero-orb--secondary" aria-hidden="true"></div>
          <div class="hero-cyber-frame relative w-full">
            <div class="hero-systems-stack relative w-full">
              @foreach ($slides as $index => $slide)
                @php
                  $slideNumber = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                  $slideTitle = data_get($slide, 'title');
                  $slideSubtitleRaw = data_get($slide, 'subtitle');
                  $slideSubtitle = is_string($slideSubtitleRaw) ? trim($slideSubtitleRaw) : '';
                  $systemsSubtitle = $slideSubtitle !== '' ? $slideSubtitle : $defaultHeroSubtitle;
                  $slideMetrics = data_get($slide, 'metrics');
                  $slideMetrics = is_array($slideMetrics) ? $slideMetrics : [];
                  $automationDefault = min(99.9, 88 + ($index * 3.25));
                  $slideTelemetry = [
                    'automation' => $slideMetrics['automation'] ?? number_format($automationDefault, 1) . '%',
                    'latency' => $slideMetrics['latency'] ?? number_format(0.24 + $index * 0.05, 2) . 's',
                    'throughput' => $slideMetrics['throughput'] ?? number_format(22 + $index * 4) . 'k ops',
                    'uptime' => $slideMetrics['uptime'] ?? '99.982%',
                  ];
                  $heroImage = data_get($slide, 'image');
                  $heroImageAlt = is_string($slideTitle) && trim($slideTitle) !== '' ? $slideTitle : 'DGstep hero visual';
                @endphp
                <article
                  x-show="activeSlide === {{ $index }}"
                  style="{{ $index === 0 ? '' : 'display:none;' }}"
                  class="hero-systems-card hero-systems-layer absolute inset-0 flex flex-col"
                  role="group"
                  aria-roledescription="slide"
                  aria-label="Slide {{ $index + 1 }} of {{ $slidesCount }}"
                  x-bind:aria-hidden="activeSlide !== {{ $index }}"
                  :class="{ 'pointer-events-none': activeSlide !== {{ $index }}, 'pointer-events-auto': activeSlide === {{ $index }} }"
                >
                  <div class="hero-systems-panel flex flex-col flex-1">
                    <div class="hero-systems-panel__header">
                      <span class="hero-systems-chip">{{ $heroLocaleLabel }}</span>
                      <span class="hero-systems-cycle">Cycle {{ $heroCycleSeconds }}s</span>
                      <span class="hero-systems-id">Slide {{ $slideNumber }}/{{ $slidesCountDisplay }}</span>
                    </div>
                    <div class="hero-systems-panel__body">
                      <div
                        class="hero-systems-body"
                        x-show="activeSlide === {{ $index }}"
                        x-transition:enter="transition-opacity ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition-opacity ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                      >
                        <p class="hero-systems-panel__subtitle">{{ $systemsSubtitle }}</p>

                        @if ($heroImage)
                          <div class="hero-visual-card-wrapper">
                            <figure class="hero-media hero-visual-card rounded-[28px] overflow-hidden">
                              <img
                                src="{{ $heroImage }}"
                                alt="{{ $heroImageAlt }}"
                                loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                fetchpriority="{{ $index === 0 ? 'high' : 'auto' }}"
                                decoding="async"
                                class="hero-visual-card__img"
                              />
                            </figure>
                          </div>
                        @endif
                      </div>

                      <div class="hero-systems-footer hero-systems-footer--status">
                        <div class="hero-telemetry__signal hero-telemetry__signal--solo" aria-label="Uptime status">
                          <span>Uptime</span>
                          <span>{{ $slideTelemetry['uptime'] }}</span>
                          <span class="hero-telemetry__bars" aria-hidden="true">
                            <span></span><span></span><span></span><span></span>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </article>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Navigation Arrows (Desktop) -->
  <div class="hidden md:block absolute bottom-24 left-4 translate-y-0 z-20 md:bottom-auto md:top-1/2 md:left-5 md:-translate-y-1/2">
    <button type="button" @click="prev()" aria-label="Previous slide" class="hero-arrow focus-ring" data-direction="prev">
      <span class="hero-arrow__icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14.25 6.75L8.5 12l5.75 5.25" />
        </svg>
      </span>
    </button>
  </div>
  <div class="hidden md:block absolute bottom-24 right-4 translate-y-0 z-20 md:bottom-auto md:top-1/2 md:right-5 md:-translate-y-1/2">
    <button type="button" @click="next()" aria-label="Next slide" class="hero-arrow focus-ring" data-direction="next">
      <span class="hero-arrow__icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9.75 6.75L15.5 12l-5.75 5.25" />
        </svg>
      </span>
    </button>
  </div>

  <!-- Dots Navigation (Desktop) -->
  <div class="hidden md:flex absolute bottom-7 left-1/2 -translate-x-1/2 space-x-3 z-20" role="tablist" aria-label="Hero slides">
    @foreach ($slides as $index => $slide)
      <button
        type="button" role="tab"
        :aria-selected="activeSlide === {{ $index }}"
        :tabindex="activeSlide === {{ $index }} ? 0 : -1"
        @click="goTo({{ $index }})"
        aria-label="Go to slide {{ $index + 1 }}"
        class="hero-dot transition"
        :style="dotStyle({{ $index }})"
        :class="{ 'is-active': activeSlide === {{ $index }} }">
      </button>
    @endforeach
  </div>

  <!-- Mobile Controls -->
  <div class="md:hidden px-4 sm:px-6 mt-10">
    <div class="flex items-center justify-between gap-6">
      <button type="button" @click="prev()" aria-label="Previous slide" class="hero-arrow hero-arrow--compact focus-ring" data-direction="prev">
        <span class="hero-arrow__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14.25 6.75L8.5 12l5.75 5.25" />
          </svg>
        </span>
      </button>

      <div class="flex flex-1 justify-center gap-3" role="tablist" aria-label="Hero slides">
        @foreach ($slides as $index => $slide)
          <button
            type="button" role="tab"
            :aria-selected="activeSlide === {{ $index }}"
            :tabindex="activeSlide === {{ $index }} ? 0 : -1"
            @click="goTo({{ $index }})"
            aria-label="Go to slide {{ $index + 1 }}"
            class="hero-dot transition"
            :style="dotStyle({{ $index }})"
            :class="{ 'is-active': activeSlide === {{ $index }} }">
          </button>
        @endforeach
      </div>

      <button type="button" @click="next()" aria-label="Next slide" class="hero-arrow hero-arrow--compact focus-ring" data-direction="next">
        <span class="hero-arrow__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9.75 6.75L15.5 12l-5.75 5.25" />
          </svg>
        </span>
      </button>
    </div>
  </div>
</section>
