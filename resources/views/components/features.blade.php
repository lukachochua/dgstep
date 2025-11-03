@props([
  'items' => collect(), 
])

@php
  $visible = $items->count() >= 2;
@endphp

@if($visible)
<section id="featured-services"
         class="select-none py-12 md:py-14 relative overflow-hidden
                bg-[color:var(--bg-default)] text-[color:var(--text-default)]">

  <!-- subtle wash using your variable system -->
  <div class="pointer-events-none absolute inset-0 z-0" style="background: var(--section-wash);"></div>

  <div class="relative z-10 mx-auto max-w-[var(--container-content)] px-4 sm:px-6 md:px-8">
    <header class="text-center mb-10 md:mb-12">
      <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight leading-tight">
        {{ __('services.our_key_services') }}
      </h2>
      <p class="mt-3 text-base md:text-lg leading-relaxed max-w-2xl mx-auto text-[color:var(--hero-ink-muted)]">
        {{ __('services.how_we_can_help') }}
      </p>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
      @foreach ($items as $svc)
        <a href="{{ url('/services') }}"  {{-- use route(...) if you have a named route --}}
          class="group relative block rounded-xl overflow-hidden bg-[color:var(--bg-elevated)]
                  shadow-[0_4px_14px_rgba(0,0,0,.18)] ring-1 ring-inset ring-[color-mix(in_oklab,#fff_10%,transparent)]
                  focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--color-electric-sky)]"
          aria-label="{{ $svc->display_name }}">

          {{-- Image --}}
          @php
            $featuredImage = $svc->featured_image_url ?? $svc->image_url;
            $imageAlt = $svc->image_alt ?: $svc->display_name;
          @endphp

          <div class="relative aspect-[16/10] overflow-hidden">
            @if($featuredImage)
              <img
                src="{{ $featuredImage }}"
                alt="{{ $imageAlt }}"
                class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-[1.03]"
                loading="lazy"
                decoding="async"
              />
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
            <div class="absolute inset-x-0 bottom-0 p-4 md:p-5">
              <div class="inline-flex items-center gap-2 rounded-full
                          bg-black/40 backdrop-blur px-3.5 py-2
                          text-white text-sm md:text-base font-semibold tracking-tight
                          shadow-[0_0_0_1px_rgba(255,255,255,.06)]">
                <span class="inline-block h-2 w-2 rounded-full bg-[var(--color-electric-sky)]"></span>
                <span>{{ $svc->display_name }}</span>
              </div>
            </div>
          </div>

          {{-- NEW: Problems preview (shows top 3 for current locale) --}}
          @php
            $locale   = app()->getLocale();
            $problems = is_array($svc->problems) ? ($svc->problems[$locale] ?? []) : [];
            $preview  = array_slice($problems, 0, 3);
          @endphp

          @if(!empty($preview))
            <div class="p-4 md:p-5 text-left">
              <ul class="space-y-2">
                @foreach ($preview as $p)
                  <li class="flex items-start gap-2 text-[15px] leading-relaxed text-[color:var(--hero-ink-muted)]">
                    <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-[var(--color-electric-sky)]"></span>
                    <span>{{ $p }}</span>
                  </li>
                @endforeach
              </ul>
            </div>
          @endif

          {{-- Thin hover accent --}}
          <div class="absolute inset-0 pointer-events-none
                      ring-1 ring-transparent group-hover:ring-[color-mix(in_oklab,var(--color-electric-sky)_35%,transparent)]
                      transition-[ring] duration-200"></div>
        </a>
      @endforeach
    </div>
  </div>
</section>
@endif
