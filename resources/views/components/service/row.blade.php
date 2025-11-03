@props([
    'title' => $title ?? '',
    'description' => $description ?? '',
    'cueStyle' => $cueStyle ?? 'bubbles',  // bubbles | bars | dots
    'cueLabel' => $cueLabel ?? '',
    'cueValues' => $cueValues ?? [],
    'image' => null,
    'imageAlt' => '',
    'fullDescription' => '',
    'reversed' => false,
])

{{-- 
  Compact service row:
  - Left: text with expandable long-form copy
  - Right: service image (large) or fallback cue box
--}}

@php
    $fullCopy = is_string($fullDescription) ? trim($fullDescription) : '';
    $hasFull = $fullCopy !== '';
    $contentId = 'svc-full-' . uniqid();
    $gridTemplate = $reversed
        ? 'md:grid-cols-[minmax(0,440px)_minmax(0,1fr)]'
        : 'md:grid-cols-[minmax(0,1fr)_minmax(0,440px)]';
@endphp

<div
  x-data="{ expanded: false }"
  @class([
      'grid items-start gap-6 md:gap-10',
      $gridTemplate,
      'rounded-xl border border-[color-mix(in_oklab,var(--text-default)_10%,transparent)]',
      'bg-[var(--bg-elevated)]/60 backdrop-blur',
      'px-4 py-5 sm:px-6 sm:py-6',
      'shadow-[0_6px_14px_rgba(0,0,0,.18)]',
  ])>

  {{-- Text --}}
  <div @class([
      'text-left space-y-4',
      'md:order-2' => $reversed,
  ])>
    <h3 class="text-2xl md:text-3xl font-extrabold mb-2 text-[var(--color-electric-sky)]">
      {!! e($title) !!}
    </h3>
    <div
      class="text-[15.5px] leading-relaxed text-[color-mix(in_oklab,var(--text-default)_78%,transparent)] space-y-4">
      <p>{!! e($description) !!}</p>

      @if($hasFull)
        <div
          x-show="expanded"
          x-cloak
          x-collapse.duration.250ms
          x-transition.opacity.duration.250ms
          id="{{ $contentId }}"
          class="space-y-4 prose prose-invert max-w-none prose-p:leading-relaxed prose-ul:pl-5">
          {!! $fullCopy !!}
        </div>

        <button
          type="button"
          @click="expanded = !expanded"
          class="inline-flex items-center gap-2 text-sm font-semibold text-[var(--color-electric-sky)] hover:text-[color-mix(in_oklab,var(--color-electric-sky)_80%,white_20%)] transition-colors"
          :aria-expanded="expanded.toString()"
          aria-controls="{{ $contentId }}"
        >
          <span x-show="!expanded" x-cloak>{{ __('services.read_more') }}</span>
          <span x-show="expanded" x-cloak>{{ __('services.show_less') }}</span>
        </button>
      @endif
    </div>
  </div>

  {{-- Media / Cue --}}
  <div @class([
      'md:ml-2' => ! $reversed,
      'md:mr-2' => $reversed,
      'md:order-1' => $reversed,
  ])>
    @if($image)
      <div class="relative w-full h-[260px] sm:h-[300px] md:h-[400px] overflow-hidden
                  rounded-lg border border-[color-mix(in_oklab,var(--text-default)_12%,transparent)]
                  bg-[color-mix(in_oklab,var(--color-brand-950)_16%,transparent)]
                  transition-transform duration-200
                  hover:brightness-110 hover:-translate-y-[1px]">
        <img
          src="{{ $image }}"
          alt="{{ $imageAlt }}"
          class="absolute inset-0 h-full w-full object-cover"
          loading="lazy"
          decoding="async"
        />
      </div>
    @else
      <div class="w-full h-[260px] sm:h-[300px] md:h-[400px]
                  rounded-lg border border-[color-mix(in_oklab,var(--text-default)_12%,transparent)]
                  bg-[color-mix(in_oklab,var(--color-brand-950)_16%,transparent)]
                  p-4 flex flex-col items-center justify-center select-none
                  transition-transform duration-200
                  hover:brightness-110 hover:-translate-y-[1px]">

        @if($cueLabel)
          <div class="text-xs uppercase tracking-wide
                      text-[color-mix(in_oklab,var(--text-default)_70%,transparent)] mb-3 text-center">
            {{ $cueLabel }}
          </div>
        @endif

        @switch($cueStyle)
          @case('bars')
            {{-- Bars live inside a fixed area to keep overall card height equal --}}
            <div class="flex items-end justify-center gap-2 w-full h-[96px]">
              @foreach(array_values($cueValues) as $v)
                @php $h = max(6, min(100, (int) $v)); @endphp
                <div class="w-3 flex-1 rounded-t
                            bg-[color-mix(in_oklab,var(--color-electric-sky)_72%,transparent)]
                            ring-1 ring-[color-mix(in_oklab,#000_12%,transparent)]"
                     style="height: {{ intval($h * 0.9) }}%"></div>
              @endforeach
            </div>
            @break

          @case('dots')
            {{-- Dots grid auto-fills without changing outer card height --}}
            <div class="grid grid-cols-3 gap-2 justify-items-center">
              @foreach(array_values($cueValues) as $v)
                <div class="size-3 rounded-full
                            @if((int)$v === 1)
                              bg-[var(--color-electric-sky)]
                            @else
                              bg-[color-mix(in_oklab,var(--text-default)_18%,transparent)]
                            @endif"></div>
              @endforeach
            </div>
            @break

          @default
            {{-- Bubbles: scale slightly so they never exceed the fixed card area --}}
            <div class="flex flex-wrap justify-center gap-2 max-w-[190px]">
              @foreach(array_values($cueValues) as $v)
                @php $s = 26 + round(max(0, min(100, (int) $v)) * 0.25); @endphp
                <div class="rounded-full
                            bg-[color-mix(in_oklab,var(--color-electric-sky)_68%,transparent)]
                            ring-1 ring-[color-mix(in_oklab,#000_20%,transparent)]"
                     style="width: {{ $s }}px; height: {{ $s }}px"></div>
              @endforeach
            </div>
        @endswitch
      </div>
    @endif
  </div>
</div>
