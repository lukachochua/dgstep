@props([
  'slides' => [],
  'isKaLocale' => false,
  'isEnLocale' => false,
  'heroHeadingScale' => 'text-2xl md:text-4xl lg:text-5xl',
  'heroSubtitleScale' => 'text-base md:text-lg',
])

@php
  $fallbackHeroCta = trans('messages.footer.cta');
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
      slides: @js($slides),

      canAuto() {
        const visible = this.$root?.offsetParent !== null;
        return visible && !this.prefersReduced && this.slides.length > 1;
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
        if (!this.slides.length) return;
        this.activeSlide = (this.activeSlide + 1) % this.slides.length;
        this.resumeCycle({ reset: true });
      },

      prev() {
        if (!this.slides.length) return;
        this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length;
        this.resumeCycle({ reset: true });
      },

      goTo(index) {
        if (index === this.activeSlide) return;
        if (index >= 0 && index < this.slides.length) {
          this.activeSlide = index;
          this.resumeCycle({ reset: true });
        }
      },

      dotStyle(index) {
        if (index !== this.activeSlide) return '--hero-dot-progress:0deg;';
        const value = Math.min(1, Math.max(0, this.progress || 0));
        const angle = (value * 360).toFixed(1);
        return `--hero-dot-progress:${angle}deg;`;
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

        const reservedCTA = 72;
        this.textColH   = Math.min(avail, Math.max(360, Math.ceil(maxCol + 1)));
        this.textBlockH = Math.min(this.textColH - reservedCTA, Math.max(220, Math.ceil(maxGroup + 1)));
      },

      init() {
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

        this.$nextTick(() => {
          this.measure();
          requestAnimationFrame(() => this.resumeCycle({ reset: true }));
        });

        const ro = new ResizeObserver(() => this.measure());
        ro.observe(this.$root);

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
        };
      }
    };
  })()"
  x-init="init()"
  @keydown.arrow-right.prevent="next()" @keydown.arrow-left.prevent="prev()"
  tabindex="0" role="region" aria-roledescription="carousel" aria-label="DGstep hero"
  class="hero-surface relative z-0 select-none overflow-hidden text-[color:var(--hero-ink)]"
  style="min-height: calc(100svh)">

  <!-- Backgrounds -->
  <template x-for="(slide, index) in slides" :key="'bg-'+index">
    <div
      x-show="activeSlide === index"
      x-transition:enter="transition ease-out duration-700"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-500"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      class="pointer-events-none absolute inset-0" aria-hidden="true"
    >
      <img
        :src="slide.image"
        alt=""
        :loading="index === 0 ? 'eager' : 'lazy'"
        :fetchpriority="index === 0 ? 'high' : 'low'"
        decoding="async"
        class="hero-bgimg w-full h-full object-cover opacity-[var(--hero-img-opacity)] mix-blend-[var(--hero-img-blend)]"
      />
    </div>
  </template>

  <!-- Foreground -->
  <div class="relative mt-24 z-10 mx-auto max-w-[var(--container-content)] px-4 sm:px-6 md:px-8">
    <div x-ref="inner" class="min-h-[calc(100svh-var(--navbar-h)-1rem)] flex items-center">
      <div class="grid items-center w-full gap-8 md:gap-12 lg:gap-16 grid-cols-1 md:grid-cols-2 xl:grid-cols-[0.7fr_1.3fr]">

        <!-- LEFT: Text -->
        <div class="w-full max-w-[48ch] justify-self-start relative z-10">
          <div class="relative" :style="`height:${textColH||0}px`">
            <template x-for="(slide, index) in slides" :key="'txt-'+index">
              <div
                x-show="activeSlide === index" x-cloak
                class="absolute inset-0"
                x-transition:enter="transition ease-out duration-600"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-450"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
                role="group" aria-roledescription="slide" :aria-label="`Slide ${index+1} of ${slides.length}`"
              >
                <div :style="`min-height:${textBlockH||0}px`">
                  <h1 class="{{ $heroHeadingScale }} font-extrabold leading-[1.15] tracking-tight [text-wrap:balance] animate-fadeUp drop-shadow-lg">
                    <span x-text="slide.title"></span><br>
                    <span class="hero-highlight" x-text="slide.highlight"></span>
                  </h1>

                  <p class="mt-3 md:mt-4 {{ $heroSubtitleScale }} leading-relaxed drop-shadow-sm text-[color:var(--hero-ink-muted)] animate-fadeUp"
                     style="animation-delay:.05s" x-text="slide.subtitle"></p>
                </div>

                <div class="mt-6 md:mt-7 flex flex-wrap items-center gap-3 animate-fadeUp" style="animation-delay:.1s">
                  <x-ui.button
                    x-show="slide.button_href || slide.button?.href || slide.button?.link || slide.button_link"
                    x-bind:href="slide.button_href || slide.button?.href || slide.button?.link || slide.button_link || '#'"
                    x-on:mouseenter="stop('hover')"
                    x-on:mouseleave="start('hover')"
                    x-on:focusin="stop('focus')"
                    x-on:focusout="start('focus')"
                    variant="hero" size="lg" class="shrink-0">
                    <span x-text="slide.button?.text ?? slide.button_text ?? @js($fallbackHeroCta)"></span>
                  </x-ui.button>
                </div>
              </div>
            </template>
          </div>

          <div aria-hidden="true" class="invisible absolute -left-[9999px] top-auto" x-ref="textMeasure">
            <template x-for="(slide, index) in slides" :key="'measure-'+index">
              <div class="w-[48ch]" data-measure="slide">
                <div data-measure="hgroup">
                  <h1 class="{{ $heroHeadingScale }} font-extrabold leading-[1.15] tracking-tight">
                    <span x-text="slide.title"></span><br>
                    <span x-text="slide.highlight"></span>
                  </h1>
                  <p class="mt-3 md:mt-4 {{ $heroSubtitleScale }} leading-relaxed" x-text="slide.subtitle"></p>
                </div>
                <div class="mt-6 md:mt-7 h-11"></div>
              </div>
            </template>
          </div>
        </div>

        <!-- RIGHT: Media -->
        <div class="hidden md:block justify-self-end w-full min-w-0 relative z-0">
          <a :href="slides[activeSlide]?.button_href ?? (slides[activeSlide]?.button?.href ?? slides[activeSlide]?.button?.link ?? slides[activeSlide]?.button_link ?? '#')"
             class="block rounded-2xl overflow-hidden hero-media"
             @mouseenter="stop('hover')"
             @mouseleave="start('hover')"
             @focusin="stop('focus')"
             @focusout="start('focus')">
            <div class="relative aspect-[16/9] md:max-h-[82vh]">
              <template x-for="(src, i) in (slides[activeSlide]?.media || [])" :key="'media-'+i">
                <img
                  :src="src"
                  :alt="slides[activeSlide]?.title || 'App preview'"
                  x-show="true"
                  x-transition:enter="transition ease-out duration-500"
                  x-transition:enter-start="opacity-0 scale-[.995]"
                  x-transition:enter-end="opacity-100 scale-100"
                  x-transition:leave="transition ease-in duration-400"
                  x-transition:leave-start="opacity-100 scale-100"
                  x-transition:leave-end="opacity-0 scale-[.995]"
                  class="absolute inset-0 w-full h-full object-cover object-center"
                  loading="eager" decoding="async" fetchpriority="high"
                />
              </template>
            </div>
          </a>
        </div>

      </div>
    </div>
  </div>

  <div class="absolute top-1/2 left-5 -translate-y-1/2 z-20">
    <button type="button" @click="prev()" aria-label="Previous slide" class="hero-arrow focus-ring">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M15 18l-6-6 6-6" />
      </svg>
    </button>
  </div>
  <div class="absolute top-1/2 right-5 -translate-y-1/2 z-20">
    <button type="button" @click="next()" aria-label="Next slide" class="hero-arrow focus-ring">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M9 18l6-6-6-6" />
      </svg>
    </button>
  </div>

  <div class="absolute bottom-7 left-1/2 -translate-x-1/2 flex space-x-3 z-20" role="tablist" aria-label="Hero slides">
    <template x-for="(slide, index) in slides" :key="'dot-'+index">
      <button
        type="button" role="tab"
        :aria-selected="activeSlide === index"
        :tabindex="activeSlide === index ? 0 : -1"
        @click="goTo(index)"
        :aria-label="`Go to slide ${index+1}`"
        class="hero-dot transition"
        :style="dotStyle(index)"
        :class="{ 'is-active': activeSlide === index }">
      </button>
    </template>
  </div>
</section>
