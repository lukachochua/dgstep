<section
  x-data="{
    activeSlide: 0,
    textColH: 0,
    slides: [{
      title: '{{ __('messages.hero.slides.0.title') }}',
      highlight: '{{ __('messages.hero.slides.0.highlight') }}',
      subtitle: '{{ __('messages.hero.slides.0.subtitle') }}',
      button: { text: '{{ __('messages.hero.slides.0.button.text') }}', link: '{{ route('contact') }}' },
      image: 'https://images.unsplash.com/photo-1499428665502-503f6c608263?q=80&w=870&auto=format&fit=crop'
    },{
      title: '{{ __('messages.hero.slides.1.title') }}',
      highlight: '{{ __('messages.hero.slides.1.highlight') }}',
      subtitle: '{{ __('messages.hero.slides.1.subtitle') }}',
      button: { text: '{{ __('messages.hero.slides.1.button.text') }}', link: '{{ route('contact') }}' },
      image: 'https://images.unsplash.com/photo-1499428665502-503f6c608263?q=80&w=870&auto=format&fit=crop'
    },{
      title: '{{ __('messages.hero.slides.2.title') }}',
      highlight: '{{ __('messages.hero.slides.2.highlight') }}',
      subtitle: '{{ __('messages.hero.slides.2.subtitle') }}',
      button: { text: '{{ __('messages.hero.slides.2.button.text') }}', link: '{{ route('contact') }}' },
      image: 'https://images.unsplash.com/photo-1499428665502-503f6c608263?q=80&w=870&auto=format&fit=crop'
    }],
    next(){ this.activeSlide = (this.activeSlide + 1) % this.slides.length },
    prev(){ this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length },
    measure() {
      const nodes = this.$refs.textMeasure?.querySelectorAll('[data-measure]') || [];
      let max = 0;
      nodes.forEach(n => { max = Math.max(max, n.offsetHeight); });
      this.textColH = Math.ceil(max + 1);
    }
  }"
  x-init="
    setInterval(() => next(), 8000);
    $nextTick(() => { measure(); });
    (() => { const ro = new ResizeObserver(() => measure()); ro.observe($root); })();
  "
  style="min-height: calc(100svh - var(--navbar-h))"
  class="relative z-0 select-none overflow-hidden
         text-[color:var(--hero-ink)]
         bg-[linear-gradient(90deg,var(--hero-bg-start),var(--hero-bg-mid)_55%,var(--hero-bg-end))]"
>
  <!-- Background layer -->
  <template x-for="(slide, index) in slides" :key="'bg-'+index">
    <div
      x-show="activeSlide === index"
      x-transition:enter="transition ease-out duration-700"
      x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100"
      x-transition:leave="transition ease-in duration-500"
      x-transition:leave-start="opacity-100 scale-100"
      x-transition:leave-end="opacity-0 scale-95"
      class="pointer-events-none absolute inset-0"
    >
      <img :src="slide.image" alt=""
           class="w-full h-full object-cover
                  opacity-[var(--hero-img-opacity)]
                  mix-blend-[var(--hero-img-blend)]" />
      <div class="absolute inset-0"
           style="background: radial-gradient(70% 60% at 50% 40%, var(--hero-overlay) 0%, transparent 60%);">
      </div>
    </div>
  </template>

  <!-- Foreground content -->
  <div class="relative z-10 mx-auto max-w-[var(--container-content)] px-4 sm:px-6 md:px-8">
    <div class="grid items-center gap-10 md:gap-16 py-12 md:py-16 grid-cols-1 md:grid-cols-[1.1fr_0.9fr]">

      <!-- LEFT: Text column -->
      <div class="w-full max-w-[48ch] justify-self-start">
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
            >
              <h1 class="text-4xl md:text-5xl font-extrabold leading-tight tracking-tight drop-shadow-lg">
                <span x-text="slide.title"></span><br>
                <span class="text-[var(--color-electric-sky)]" x-text="slide.highlight"></span>
              </h1>

              <p class="mt-4 text-lg md:text-xl leading-relaxed drop-shadow-sm
                         text-[color:var(--hero-ink-muted)]"
                 x-text="slide.subtitle"></p>

              <div class="mt-6 flex items-center gap-3">
                <x-ui.button x-bind:href="slide.button.link" variant="primary" size="md">
                  <span x-text="slide.button.text"></span>
                </x-ui.button>
                <x-ui.button href="{{ route('services') }}" variant="secondary" size="md">
                  {{ __('messages.services') }}
                </x-ui.button>
              </div>
            </div>
          </template>
        </div>

        <!-- Invisible measurer -->
        <div aria-hidden="true" class="invisible absolute -left-[9999px] top-auto" x-ref="textMeasure">
          <template x-for="(slide, index) in slides" :key="'measure-'+index">
            <div class="w-[48ch]" data-measure>
              <h1 class="text-4xl md:text-5xl font-extrabold leading-tight tracking-tight">
                <span x-text="slide.title"></span><br>
                <span x-text="slide.highlight"></span>
              </h1>
              <p class="mt-4 text-lg md:text-xl leading-relaxed" x-text="slide.subtitle"></p>
              <div class="mt-6 h-10"></div>
            </div>
          </template>
        </div>
      </div>

      <!-- RIGHT: Media column -->
      <div class="hidden md:block justify-self-end w-[520px] lg:w-[600px] xl:w-[640px]">
        <a href="" class="block rounded-2xl overflow-hidden border
                          border-[color-mix(in_oklab,var(--hero-ink)_14%,transparent)]
                          shadow-[0_18px_40px_rgba(0,0,0,.35)]">
          <img
            src="{{ Vite::asset('resources/images/brand/hero_image.png') }}"
            alt="App Preview"
            class="w-full h-auto object-cover object-center"
            loading="lazy"
          />
        </a>
      </div>
    </div>
  </div>

  <!-- Prev / Next -->
  <div class="absolute top-1/2 left-4 -translate-y-1/2 z-20">
    <button @click="prev" aria-label="Previous slide" class="hero-arrow focus-ring">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
           viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
        <path d="M15 18l-6-6 6-6" />
      </svg>
    </button>
  </div>
  <div class="absolute top-1/2 right-4 -translate-y-1/2 z-20">
    <button @click="next" aria-label="Next slide" class="hero-arrow focus-ring">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
           viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
        <path d="M9 18l6-6-6-6" />
      </svg>
    </button>
  </div>

  <!-- Dots -->
  <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex space-x-2 z-20">
    <template x-for="(slide, index) in slides" :key="'dot-'+index">
      <button
        @click="activeSlide = index"
        :aria-label="`Go to slide ${index+1}`"
        class="w-3 h-3 rounded-full border transition
               border-[color:var(--hero-dot-border)]"
        :class="activeSlide === index
                ? 'bg-[color:var(--hero-dot-active)]'
                : 'bg-[color:var(--hero-dot)] hover:bg-[color:var(--hero-dot-hover)]'">
      </button>
    </template>
  </div>
</section>
