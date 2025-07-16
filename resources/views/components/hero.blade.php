<section x-data="{
    activeSlide: 0,
    slides: [{
            title: '{{ __('messages.hero.slides.0.title') }}',
            highlight: '{{ __('messages.hero.slides.0.highlight') }}',
            subtitle: '{{ __('messages.hero.slides.0.subtitle') }}',
            button: {
                text: '{{ __('messages.hero.slides.0.button.text') }}',
                link: '{{ route('contact') }}'
            },
            image: 'https://images.unsplash.com/photo-1499428665502-503f6c608263?q=80&w=870&auto=format&fit=crop'
        },
        {
            title: '{{ __('messages.hero.slides.1.title') }}',
            highlight: '{{ __('messages.hero.slides.1.highlight') }}',
            subtitle: '{{ __('messages.hero.slides.1.subtitle') }}',
            button: {
                text: '{{ __('messages.hero.slides.1.button.text') }}',
                link: '{{ route('contact') }}'
            },
            image: 'https://images.unsplash.com/photo-1499428665502-503f6c608263?q=80&w=870&auto=format&fit=crop'
        },
        {
            title: '{{ __('messages.hero.slides.2.title') }}',
            highlight: '{{ __('messages.hero.slides.2.highlight') }}',
            subtitle: '{{ __('messages.hero.slides.2.subtitle') }}',
            button: {
                text: '{{ __('messages.hero.slides.2.button.text') }}',
                link: '{{ route('contact') }}'
            },
            image: 'https://images.unsplash.com/photo-1499428665502-503f6c608263?q=80&w=870&auto=format&fit=crop'
        }
    ],
    next() {
        this.activeSlide = (this.activeSlide + 1) % this.slides.length
    },
    prev() {
        this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length
    }
}" x-init="setInterval(() => next(), 8000)" style="min-height: calc(100vh - 5rem);"
    class="relative pt-20 bg-gradient-to-r from-[#0b0f1a] via-[#141d2f] to-[#0b0f1a] text-white overflow-hidden flex items-center z-0 select-none">

    <template x-for="(slide, index) in slides" :key="'bg-' + index">
        <div x-show="activeSlide === index" x-transition:enter="transition ease-out duration-700 transform"
            x-transition:enter-start="opacity-0 translate-x-6 scale-95"
            x-transition:enter-end="opacity-100 translate-x-0 scale-100"
            x-transition:leave="transition ease-in duration-500 transform"
            x-transition:leave-start="opacity-100 translate-x-0 scale-100"
            x-transition:leave-end="opacity-0 -translate-x-6 scale-95" class="absolute inset-0">
            <img :src="slide.image" alt=""
                class="w-full h-full object-cover opacity-10 mix-blend-lighten" />
        </div>
    </template>

    <div
        class="container mx-auto px-4 sm:px-6 md:px-8 z-10 relative flex flex-col md:flex-row items-center justify-between gap-12">

        <div class="relative w-full md:w-1/2 flex-shrink-0 md:pr-8"> <template x-for="(slide, index) in slides"
                :key="'content-' + index">
                <div x-show="activeSlide === index"
                    x-transition:enter="transition ease-out duration-700 transform origin-top"
                    x-transition:enter-start="opacity-0 translate-y-10"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-500 transform origin-top"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-10"
                    class="absolute md:relative inset-0 md:inset-auto">
                    <h1 class="text-4xl md:text-5xl font-extrabold leading-tight tracking-tight drop-shadow-lg">
                        <span x-text="slide.title"></span><br>
                        <span class="text-[var(--color-electric-sky)]" x-text="slide.highlight"></span>
                    </h1>
                    <p class="mt-4 text-lg md:text-xl text-white/80 drop-shadow-sm" x-text="slide.subtitle"></p>
                    <div class="mt-6">
                        <a :href="slide.button.link"
                            class="inline-block border-2 border-white text-white font-semibold px-6 py-3 rounded-lg hover:bg-white hover:text-[var(--color-electric-sky)] transition">
                            <span x-text="slide.button.text"></span>
                        </a>
                    </div>
                </div>
            </template>
        </div>

        <div class="w-full max-w-lg aspect-[16/9] rounded-xl overflow-hidden shadow-lg md:w-1/2">
            <img src="https://plus.unsplash.com/premium_photo-1666997726532-33f671ca24c8?q=80&w=821&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="App Preview" class="w-full h-full object-cover object-center" loading="lazy" />
        </div>
    </div>

    <div class="absolute top-1/2 left-4 transform -translate-y-1/2 z-20">
        <button @click="prev"
            class="bg-white/10 text-white hover:text-[var(--color-electric-sky)] p-2 rounded-full transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 18l-6-6 6-6" />
            </svg>
        </button>
    </div>

    <div class="absolute top-1/2 right-4 transform -translate-y-1/2 z-20">
        <button @click="next"
            class="bg-white/10 text-white hover:text-[var(--color-electric-sky)] p-2 rounded-full transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 18l6-6-6-6" />
            </svg>
        </button>
    </div>

    <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-2 z-20">
        <template x-for="(slide, index) in slides" :key="'dot-' + index">
            <button @click="activeSlide = index" class="w-3 h-3 rounded-full border border-white transition"
                :class="activeSlide === index ? 'bg-white' : 'bg-white/30'"></button>
        </template>
    </div>
</section>
