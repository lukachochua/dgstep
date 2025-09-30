<section
  x-data="{
    activeSlide: 0,
    textColH: 0,        // full text column height (for cross-fade container)
    textBlockH: 0,      // title+subtitle block height (keeps CTA baseline fixed)
    timer: null,
    prefersReduced: window.matchMedia('(prefers-reduced-motion: reduce)').matches,

    // Slides (from DB)
    slides: @js($slides),

    // Right-side media (PNG files next to hero_image)
    media: @js($media),

    next(){ this.activeSlide = (this.activeSlide + 1) % this.slides.length },
    prev(){ this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length },
    start(){ if (this.prefersReduced) return; this.stop(); this.timer = setInterval(() => this.next(), 7000) },
    stop(){ if (this.timer) { clearInterval(this.timer); this.timer = null } },

    // Robust measurement with clamping to the visible hero area
    measure() {
      const meas  = this.$refs.textMeasure;
      const inner = this.$refs.inner;
      if (!meas || !inner) return;

      const avail = Math.max(380, (inner.clientHeight || window.innerHeight) - 32); // safety

      // Max of all slides (title+subtitle+CTA spacer)
      let maxCol = 0;
      meas.querySelectorAll('[data-measure=slide]').forEach(n => { maxCol = Math.max(maxCol, n.offsetHeight); });

      // Max of all slides (title+subtitle only)
      let maxGroup = 0;
      meas.querySelectorAll('[data-measure=hgroup]').forEach(n => { maxGroup = Math.max(maxGroup, n.offsetHeight); });

      // Reserve ~72px for CTA row space; clamp to visible area
      const reservedCTA = 72;
      this.textColH   = Math.min(avail, Math.max(360, Math.ceil(maxCol + 1)));
      this.textBlockH = Math.min(this.textColH - reservedCTA, Math.max(220, Math.ceil(maxGroup + 1)));
    },

    init() {
      this.start();
      this.$nextTick(() => this.measure());
      const ro = new ResizeObserver(() => this.measure());
      ro.observe(this.$root);
      document.addEventListener('visibilitychange', () => document.hidden ? this.stop() : this.start());
    }
  }"
  x-init="init()"
  @mouseenter="stop" @mouseleave="start"
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
    <!-- Center vertically; give the inner area a ref for measurements -->
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
                  <h1 class="text-2xl md:text-4xl lg:text-5xl font-extrabold leading-[1.15] tracking-tight [text-wrap:balance] animate-fadeUp drop-shadow-lg">
                    <span x-text="slide.title"></span><br>
                    <span class="hero-highlight" x-text="slide.highlight"></span>
                  </h1>

                  <p class="mt-3 md:mt-4 text-base md:text-lg leading-relaxed drop-shadow-sm text-[color:var(--hero-ink-muted)] animate-fadeUp"
                     style="animation-delay:.05s" x-text="slide.subtitle"></p>
                </div>

                <div class="mt-6 md:mt-7 flex flex-wrap items-center gap-3 animate-fadeUp" style="animation-delay:.1s">
                  <x-ui.button x-bind:href="slide.button.link" variant="hero" size="lg" class="shrink-0">
                    <span x-text="slide.button.text"></span>
                  </x-ui.button>
                  <x-ui.button route="services" variant="hero" size="lg" class="shrink-0">
                    {{ __('messages.services') }}
                  </x-ui.button>
                </div>
              </div>
            </template>
          </div>

          <!-- Invisible measurer -->
          <div aria-hidden="true" class="invisible absolute -left-[9999px] top-auto" x-ref="textMeasure">
            <template x-for="(slide, index) in slides" :key="'measure-'+index">
              <div class="w-[48ch]" data-measure="slide">
                <div data-measure="hgroup">
                  <h1 class="text-2xl md:text-4xl lg:text-5xl font-extrabold leading-[1.15] tracking-tight">
                    <span x-text="slide.title"></span><br>
                    <span x-text="slide.highlight"></span>
                  </h1>
                  <p class="mt-3 md:mt-4 text-base md:text-lg leading-relaxed" x-text="slide.subtitle"></p>
                </div>
                <div class="mt-6 md:mt-7 h-11"></div>
              </div>
            </template>
          </div>
        </div>

        <!-- RIGHT: Media -->
        <div class="hidden md:block justify-self-end w-full min-w-0 relative z-0">
          <a href="#" class="block rounded-2xl overflow-hidden hero-media">
            <div class="relative aspect-[16/9] md:max-h-[82vh]">
              <template x-for="(src, i) in media" :key="'media-'+i">
                <img
                  :src="src"
                  :alt="slides[i]?.title || 'App preview'"
                  x-show="activeSlide === i"
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

  <!-- Arrows -->
  <div class="absolute top-1/2 left-5 -translate-y-1/2 z-20">
    <button type="button" @click="prev" aria-label="Previous slide" class="hero-arrow focus-ring">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M15 18l-6-6 6-6" />
      </svg>
    </button>
  </div>
  <div class="absolute top-1/2 right-5 -translate-y-1/2 z-20">
    <button type="button" @click="next" aria-label="Next slide" class="hero-arrow focus-ring">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M9 18l6-6-6-6" />
      </svg>
    </button>
  </div>

  <!-- Dots -->
  <div class="absolute bottom-7 left-1/2 -translate-x-1/2 flex space-x-3 z-20" role="tablist" aria-label="Hero slides">
    <template x-for="(slide, index) in slides" :key="'dot-'+index">
      <button
        type="button" role="tab"
        :aria-selected="activeSlide === index"
        :tabindex="activeSlide === index ? 0 : -1"
        @click="activeSlide = index"
        :aria-label="`Go to slide ${index+1}`"
        class="hero-dot transition"
        :class="activeSlide === index
                ? 'is-active bg-[color:var(--hero-dot-active)]'
                : 'bg-[color:var(--hero-dot)] hover:bg-[color:var(--hero-dot-hover)]'">
      </button>
    </template>
  </div>
</section>
