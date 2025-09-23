<section id="features"
         class="select-none py-12 md:py-14 relative overflow-hidden
                bg-[color:var(--bg-default)]
                text-[color:var(--text-default)]">

  <!-- soft wash so light mode isn’t flat; color tuned by --section-wash -->
  <div class="pointer-events-none absolute inset-0 z-0"
       style="background: var(--section-wash);"></div>

  <!-- content above wash -->
  <div class="relative z-10 mx-auto max-w-[var(--container-content)] px-4 sm:px-6 md:px-8">

    <header class="text-center mb-10 md:mb-12">
      <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight leading-tight">
        {{ __('messages.features.heading') }}
      </h2>
      <p class="mt-3 text-base md:text-lg leading-relaxed max-w-2xl mx-auto
                text-[color:var(--hero-ink-muted)]">
        {{ __('messages.features.subheading') }}
      </p>
    </header>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 md:gap-8 text-center">
      @foreach (trans('messages.features.cards') as $card)
        <article class="group rounded-xl p-5 md:p-6 h-full
                        bg-[color:var(--bg-elevated)]
                        border border-[color-mix(in_oklab,#fff_10%,transparent)]
                        shadow-[0_4px_12px_rgba(0,0,0,.14)]
                        transition-transform duration-200 ease-[var(--ease-brand)]
                        hover:-translate-y-[2px]">
          <h3 class="text-lg md:text-xl font-semibold tracking-tight
                     text-[color:var(--color-electric-sky)]">
            {{ $card['title'] }}
          </h3>
          <p class="mt-2 text-[15px] leading-relaxed max-w-sm mx-auto
                    text-[color:var(--hero-ink-muted)]">
            {{ $card['description'] }}
          </p>
        </article>
      @endforeach
    </div>

  </div>
</section>
