@props([
    'title' => $title ?? '',
    'description' => $description ?? '',
    'cueStyle' => $cueStyle ?? 'bubbles',  // bubbles | bars | dots
    'cueLabel' => $cueLabel ?? '',
    'cueValues' => $cueValues ?? [],
])

{{-- 
  Compact service row:
  - Left: text (tight spacing)
  - Right: fixed-size compact visual cue (equal size across rows)
--}}

<div class="grid md:grid-cols-[1fr_220px] items-center gap-6 md:gap-8
            rounded-xl border border-[color-mix(in_oklab,var(--text-default)_10%,transparent)]
            bg-[var(--bg-elevated)]/60 backdrop-blur
            px-4 py-5 sm:px-6 sm:py-6
            shadow-[0_6px_14px_rgba(0,0,0,.18)]">

  {{-- Text --}}
  <div class="text-left">
    <h3 class="text-2xl md:text-3xl font-extrabold mb-2 text-[var(--color-electric-sky)]">
      {!! e($title) !!}
    </h3>
    <p class="text-[15.5px] leading-relaxed text-[color-mix(in_oklab,var(--text-default)_78%,transparent)]">
      {!! e($description) !!}
    </p>
  </div>

  {{-- Fixed-size compact cue (equal height/width across all rows) --}}
  <div class="md:ml-2">
    <div class="w-[220px] h-[200px]
                rounded-lg border border-[color-mix(in_oklab,var(--text-default)_12%,transparent)]
                bg-[color-mix(in_oklab,var(--color-brand-950)_16%,transparent)]
                p-3 flex flex-col items-center justify-center select-none
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
  </div>
</div>
