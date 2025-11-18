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
    if (!empty($image)) $slideImages[] = $image;
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
      isSwitching: false,

      gesture: { pointerId: null, startX: 0, startY: 0, startTime: 0, deltaX: 0, deltaY: 0, active: false },
      swipeThreshold: 48,
      swipeVerticalLimit: 80,
      pointerHandlers: null,

      canAuto() {
        const visible = this.$root?.offsetParent !== null;
        return visible && !this.prefersReduced && this.slideCount > 1;
      },

      clearTimers() {
        if (this.timer) { clearTimeout(this.timer); this.timer = null; }
        if (this.raf) { cancelAnimationFrame(this.raf); this.raf = null; }
      },

      resumeCycle({ reset = false } = {}) {
        if (!this.canAuto()) {
          this.clearTimers(); this.progress = 0; this.elapsed = 0; this.startedAt = null; return;
        }
        if (reset) { this.elapsed = 0; this.progress = 0; }
        if (this.manualPause) return;

        this.clearTimers();

        const step = (ts) => {
          if (this.startedAt === null) this.startedAt = ts - this.elapsed;
          this.elapsed = ts - this.startedAt;
          const pct = Math.min(1, this.elapsed / this.cycleDuration);
          this.progress = Number.isFinite(pct) ? pct : 0;
          if (this.progress >= 1) return;
          this.raf = requestAnimationFrame(step);
        };
        this.startedAt = null;
        this.raf = requestAnimationFrame(step);

        const remaining = Math.max(0, this.cycleDuration - this.elapsed);
        this.timer = setTimeout(() => {
          this.elapsed = 0; this.progress = 0;
          this.next({ origin: 'auto' });
        }, remaining || this.cycleDuration);
      },

      pauseCycle() {
        if (!this.canAuto()) return;
        if (this.startedAt !== null) {
          const now = performance.now();
          this.elapsed = Math.min(this.cycleDuration, Math.max(0, now - this.startedAt));
        }
        this.clearTimers(); this.startedAt = null;
      },

      start(origin = 'manual') { if (origin === 'hover' || origin === 'focus') this.manualPause = false; this.resumeCycle(); },
      restart() { this.resumeCycle({ reset: true }); },
      stop(origin = 'manual') { if (origin === 'hover' || origin === 'focus') this.manualPause = true; this.pauseCycle(); },

      next({ origin = 'manual' } = {}) {
        if (!this.slideCount) return;
        this.isSwitching = true;
        this.$nextTick(() => {
          this.activeSlide = (this.activeSlide + 1) % this.slideCount;
          this.$nextTick(() => { this.isSwitching = false; this.resumeCycle({ reset: true }); });
        });
      },

      prev() {
        if (!this.slideCount) return;
        this.isSwitching = true;
        this.$nextTick(() => {
          this.activeSlide = (this.activeSlide - 1 + this.slideCount) % this.slideCount;
          this.$nextTick(() => { this.isSwitching = false; this.resumeCycle({ reset: true }); });
        });
      },

      goTo(i) {
        if (i === this.activeSlide) return;
        if (i >= 0 && i < this.slideCount) {
          this.isSwitching = true;
          this.$nextTick(() => {
            this.activeSlide = i;
            this.$nextTick(() => { this.isSwitching = false; this.resumeCycle({ reset: true }); });
          });
        }
      },

      dotStyle(i) {
        if (i !== this.activeSlide) return '--hero-dot-progress:0;';
        const v = Math.min(1, Math.max(0, this.progress || 0));
        return `--hero-dot-progress:${v.toFixed(3)};`;
      },

      resetGesture() { this.gesture = { pointerId:null, startX:0, startY:0, startTime:0, deltaX:0, deltaY:0, active:false }; },
      onPointerDown(e){ if (e.pointerType!=='touch') return;
        if (e.target?.closest('button,a,input,textarea,select,[role=button],[data-hero-gesture-ignore]')) { this.resetGesture(); return; }
        this.gesture = { pointerId:e.pointerId, startX:e.clientX, startY:e.clientY, startTime:performance.now(), deltaX:0, deltaY:0, active:true };
      },
      onPointerMove(e){ if (!this.gesture.active || e.pointerId !== this.gesture.pointerId) return;
        this.gesture.deltaX = e.clientX - this.gesture.startX; this.gesture.deltaY = e.clientY - this.gesture.startY;
      },
      onPointerUp(e){ if (!this.gesture.active || e.pointerId !== this.gesture.pointerId) return;
        const dx = e.clientX - this.gesture.startX; const dy = e.clientY - this.gesture.startY;
        const h = Math.abs(dx), v = Math.abs(dy);
        if (h >= this.swipeThreshold && h > v * 1.25 && v < this.swipeVerticalLimit) (dx < 0) ? this.next({origin:'swipe'}) : this.prev();
        this.resetGesture();
      },
      onPointerCancel(e){ if (e.pointerId !== this.gesture.pointerId) return; this.resetGesture(); },

      isMobileLayout(){ return typeof window !== 'undefined' && window.matchMedia('(max-width: 1023px)').matches; },

      measure() {
        if (this.isSwitching) return; // prevent jitter mid-transition
        const meas  = this.$refs.textMeasure;
        const inner = this.$refs.inner;
        if (!meas || !inner) return;

        let maxCol = 0;
        meas.querySelectorAll('[data-measure=slide]').forEach(n => { maxCol = Math.max(maxCol, n.offsetHeight); });
        let maxGroup = 0;
        meas.querySelectorAll('[data-measure=hgroup]').forEach(n => { maxGroup = Math.max(maxGroup, n.offsetHeight); });

        const reservedCTA = 180;
        const minBlock = 320;
        const blockHeight = Math.max(minBlock, Math.ceil(maxGroup + 1));
        const newColH = Math.max(blockHeight + reservedCTA, 520);
        const newBlockH = newColH - reservedCTA;

        if (this.textColH !== newColH) this.textColH = newColH;
        if (this.textBlockH !== newBlockH) this.textBlockH = newBlockH;
      },

      stackHeightStyle() {
        if (this.isMobileLayout()) return '';
        const fallback = 520, min = 360;
        const value = Math.max(min, this.textColH || fallback);
        return `min-height:${value}px;`;
      },

      textBlockStyle() {
        if (this.isMobileLayout()) return '';
        const fallback = 320, min = 240;
        const value = Math.max(min, this.textBlockH || fallback);
        return `min-height:${value}px;height:${value}px`;
      },

      init() {
        const preloadRest = () => {
          if (!Array.isArray(this.preloadImages) || this.preloadImages.length === 0) return;
          this.preloadImages.forEach((src) => { if (!src) return; const img = new Image(); img.src = src; });
        };

        preloadRest();
        const visibilityHandler = () => document.hidden ? this.pauseCycle() : this.resumeCycle();
        const motionHandler = (e) => { this.prefersReduced = e.matches; e.matches ? (this.pauseCycle(), this.progress=0, this.elapsed=0) : this.resumeCycle({reset:true}); };
        let motionCleanup = null;

        this.$nextTick(() => {
          this.measure();
          requestAnimationFrame(() => this.resumeCycle({ reset: true }));
        });

        const ro = new ResizeObserver(() => this.measure());
        ro.observe(this.$root);

        const root = this.$root;
        if (root) {
          const handlers = {
            down: (ev) => this.onPointerDown(ev),
            move: (ev) => this.onPointerMove(ev),
            up:   (ev) => this.onPointerUp(ev),
            cancel: (ev) => this.onPointerCancel(ev),
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
  class="hero-surface relative z-0 select-none overflow-hidden text-[color:var(--hero-ink)] touch-pan-y pb-32 md:pb-36"
  style="padding-top: 0;"
>
  <!-- Backgrounds kept disabled -->

  <div aria-hidden="true" class="hero-cyber-layers absolute inset-0 z-[1] pointer-events-none">
    <div class="hero-cyber-grid"></div>
    <div class="hero-cyber-gradient hero-cyber-gradient--one"></div>
    <div class="hero-cyber-gradient hero-cyber-gradient--two"></div>
    <div class="hero-cyber-scanline"></div>
  </div>

  <!-- Foreground -->
  <div class="relative hero-stack-offset z-10 mx-auto max-w-[var(--container-content)] px-4 sm:px-6 md:px-8 mt-32">
    <!-- Mobile -->
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
                role="group"
                aria-roledescription="slide"
                aria-label="Slide {{ $index + 1 }} of {{ $slidesCount }}"
                x-bind:aria-hidden="activeSlide !== {{ $index }}"
              >
                <div class="hero-systems-panel hero-systems-panel--mobile hero-systems-panel--copy">
                  <div class="hero-systems-panel__header">
                    <span class="hero-systems-chip">{{ $heroLocaleLabel }}</span>
                    <span class="hero-systems-cycle">Cycle {{ $heroCycleSeconds }}s</span>
                    <span class="hero-systems-id">Slide {{ $slideNumber }}/{{ $slidesCountDisplay }}</span>
                  </div>

                  <!-- ABSOLUTE TEXT FRAME: no layout shift -->
                  <div class="hero-systems-panel__body hero-systems-panel__body--copy text-left relative min-h-[260px]">
                    <div class="absolute inset-0 grid place-items-center"
                         x-transition:enter="transition ease-out duration-450"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0">
                      <div class="hero-systems-body hero-systems-body--copy">
                        <div class="flex items-center gap-3 text-xs uppercase tracking-[0.28em] text-[color:var(--hero-ink-muted)]">
                          <span class="inline-flex h-2 w-2 rounded-full bg-[color:var(--color-electric-sky)] shadow-[0_0_0_8px_rgba(111,120,255,0.14)]"></span>
                          <span>Tbilisi noise · Global focus</span>
                        </div>
                        <h1 class="{{ $heroHeadingScale }} hero-heading hero-cyber-title leading-[1.08] tracking-tight [text-wrap:balance] space-y-3 text-center">
                          <span class="block">{{ $slideTitle }}</span>
                          <span class="hero-highlight block">{{ $slideHighlight }}</span>
                        </h1>
                        <p class="{{ $heroSubtitleScale }} hero-subtitle leading-relaxed text-center">{{ $systemsSubtitle }}</p>
                      </div>
                    </div>

                    <!-- Static CTA row below the absolute frame -->
                    <div class="mt-auto pt-4 relative z-[1]">
                      <div class="flex flex-wrap items-center gap-3 text-xs uppercase tracking-[0.24em] text-[color:var(--hero-ink-muted)]">
                        <span class="inline-flex h-px w-10 bg-gradient-to-r from-white/10 via-white/60 to-white/10"></span>
                        <span>Made for day/night shifts</span>
                      </div>
                      <div class="hero-actions hero-actions--mobile justify-start mt-4">
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
                </div>
              </article>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <!-- Desktop -->
    <div class="hidden md:block">
      <div
        x-ref="inner"
        class="hero-cyber-layout hero-split-card min-h-[82svh]
               md:min-h-[calc(76svh-var(--navbar-h))]
               lg:min-h-[calc(76svh-var(--navbar-h))]
               grid grid-cols-1 items-stretch gap-10 md:gap-14"
        style="min-height:calc(76svh - var(--navbar-h,4.5rem));"
      >
        <div class="w-full max-w-5xl relative z-10 mx-auto flex flex-col justify-center">
          <div class="hero-info-card text-center" :style="stackHeightStyle()">
            <div class="relative hero-slide-stack min-h-[520px] md:min-h-[560px]" :style="stackHeightStyle()">
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
                  $heroImage = data_get($slide, 'image');
                  $heroImageAlt = is_string($slideTitle) && trim($slideTitle) !== '' ? $slideTitle : 'DGstep hero visual';
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
                  <!-- Absolute text frame to avoid flow changes -->
                  <div
                    class="hero-slide-body flex flex-col flex-1 pb-8 md:pb-10 relative"
                    :style="textBlockStyle()"
                    x-show="activeSlide === {{ $index }}"
                  >
                    <div class="absolute inset-0 grid place-items-center"
                         x-transition:enter="transition ease-out duration-500 delay-75"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0">
                      <div class="flex flex-col items-center justify-center gap-6 md:gap-8 text-center">
                        <div class="flex items-center justify-center gap-3 text-xs uppercase tracking-[0.28em] text-[color:var(--hero-ink-muted)]">
                          <span class="inline-flex h-2 w-2 rounded-full bg-[color:var(--color-electric-sky)] shadow-[0_0_0_8px_rgba(111,120,255,0.14)]"></span>
                          <span>Tbilisi noise · Global focus</span>
                        </div>
                        <h1 class="{{ $heroHeadingScale }} hero-heading hero-cyber-title leading-[1.05] tracking-tight [text-wrap:balance] mx-auto space-y-4 text-center mt-6 md:mt-8">
                          <span class="block">{{ $slideTitle }}</span>
                          <span class="hero-highlight block">{{ $slideHighlight }}</span>
                        </h1>
                        <div class="flex flex-wrap items-center justify-center gap-3 text-xs uppercase tracking-[0.24em] text-[color:var(--hero-ink-muted)]">
                          <span class="inline-flex h-px w-10 bg-gradient-to-r from-white/10 via-white/60 to-white/10"></span>
                        </div>
                        <p class="{{ $heroSubtitleScale }} hero-subtitle leading-relaxed text-[color:var(--hero-ink-muted)] max-w-3xl mx-auto text-center mt-4 md:mt-5">
                          {{ $systemsSubtitle }}
                        </p>
                      </div>
                    </div>
                  </div>

                  @if ($heroImage)
                    <div class="relative max-w-4xl mx-auto w-full overflow-hidden rounded-[28px] border border-white/10 min-h-[320px] md:min-h-[360px]">
                      <img
                        src="{{ $heroImage }}"
                        alt="{{ $heroImageAlt }}"
                        loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                        fetchpriority="{{ $index === 0 ? 'high' : 'auto' }}"
                        decoding="async"
                        class="absolute inset-0 h-full w-full object-cover opacity-60"
                      />
                      <div class="absolute inset-0 bg-[color:var(--hero-overlay)]/35 backdrop-blur-xl" aria-hidden="true"></div>
                    </div>
                  @endif

                  <div class="hero-slide-footer pt-4 md:pt-6" x-show="activeSlide === {{ $index }}">
                    <div class="flex flex-col items-center gap-4">
                      <div class="hero-actions">
                        @if ($buttonHref)
                          <x-ui.button
                            href="{{ $buttonHref }}"
                            x-on:mouseenter="stop('hover')"
                            x-on:mouseleave="start('hover')"
                            x-on:focusin="stop('focus')"
                            x-on:focusout="start('focus')"
                            variant="hero" size="lg" class="shrink-0 mx-auto">
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

          <!-- Invisible measurer (unchanged) -->
          <div aria-hidden="true" class="invisible absolute -left-[9999px] top-auto text-center" x-ref="textMeasure">
            @foreach ($slides as $index => $slide)
              @php
                $slideTitle = data_get($slide, 'title');
                $slideHighlight = data_get($slide, 'highlight');
                $slideSubtitleRaw = data_get($slide, 'subtitle');
                $slideSubtitle = is_string($slideSubtitleRaw) ? trim($slideSubtitleRaw) : '';
                $systemsSubtitle = $slideSubtitle !== '' ? $slideSubtitle : $defaultHeroSubtitle;
              @endphp
              <div class="w-[100ch]" data-measure="slide">
                <div data-measure="hgroup" class="space-y-7 md:space-y-8 text-center">
                  <h1 class="{{ $heroHeadingScale }} hero-heading hero-cyber-title leading-[1.1] tracking-tight space-y-4">
                    <span class="block">{{ $slideTitle }}</span>
                    <span class="hero-highlight block">{{ $slideHighlight }}</span>
                  </h1>
                  <div class="flex flex-wrap items-center justify-center gap-3 text-xs uppercase tracking-[0.24em] text-[color:var(--hero-ink-muted)]">
                    <span class="inline-flex h-px w-10 bg-gradient-to-r from-white/10 via-white/60 to-white/10"></span>
                  </div>
                  <p class="text-base text-[color:var(--hero-ink-muted)] mt-2">{{ $systemsSubtitle }}</p>
                  <div class="flex items-center justify-center gap-3 text-xs uppercase tracking-[0.28em] text-[color:var(--hero-ink-muted)]">
                    <span class="inline-flex h-2 w-2 rounded-full bg-[color:var(--color-electric-sky)] shadow-[0_0_0_8px_rgba(111,120,255,0.14)]"></span>
                    <span>Tokyo calm · Global focus</span>
                  </div>
                </div>
                <div class="hero-actions hero-actions--measure justify-center">
                  <span class="inline-flex h-12 w-48 rounded-full border border-white/20"></span>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Navigation Arrows (Desktop) -->
  <div class="hidden md:block absolute bottom-14 left-4 translate-y-0 z-20 md:top-1/2 md:left-5 md:-translate-y-1/2">
    <button type="button" @click="prev()" aria-label="Previous slide" class="hero-arrow focus-ring" data-direction="prev">
      <span class="hero-arrow__icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14.25 6.75L8.5 12l5.75 5.25" />
        </svg>
      </span>
    </button>
  </div>
  <div class="hidden md:block absolute bottom-14 right-4 translate-y-0 z-20 md:top-1/2 md:right-5 md:-translate-y-1/2">
    <button type="button" @click="next()" aria-label="Next slide" class="hero-arrow focus-ring" data-direction="next">
      <span class="hero-arrow__icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9.75 6.75L15.5 12l-5.75 5.25" />
        </svg>
      </span>
    </button>
  </div>

  <!-- Dots Navigation (Desktop) -->
  <div class="hidden md:flex absolute bottom-6 left-1/2 -translate-x-1/2 space-x-3 z-20" role="tablist" aria-label="Hero slides">
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
