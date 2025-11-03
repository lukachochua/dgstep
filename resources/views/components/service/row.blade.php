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
      'service-card grid items-start gap-6 md:gap-10',
      $gridTemplate,
  ])>

  {{-- Text --}}
  <div @class([
      'service-card__body text-left space-y-4',
      'md:order-2' => $reversed,
  ])>
    <h3 class="service-card__title text-2xl md:text-3xl">
      {!! e($title) !!}
    </h3>
    <div class="service-card__excerpt text-[15.5px] leading-relaxed space-y-4">
      <p>{!! e($description) !!}</p>

      @if($hasFull)
        <div
          x-show="expanded"
          x-cloak
          x-collapse.duration.250ms
          x-transition.opacity.duration.250ms
          id="{{ $contentId }}"
          class="service-card__long space-y-4 prose prose-invert max-w-none prose-p:leading-relaxed prose-ul:pl-5">
          {!! $fullCopy !!}
        </div>

        <button
          type="button"
          @click="expanded = !expanded"
          class="service-card__toggle inline-flex items-center gap-2 text-sm font-semibold transition-colors"
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
      'service-card__media',
      'md:ml-2' => ! $reversed,
      'md:mr-2' => $reversed,
      'md:order-1' => $reversed,
  ])>
    @if($image)
      <div class="service-card__visual relative overflow-hidden h-[260px] sm:h-[300px] md:h-[400px]">
        <img
          src="{{ $image }}"
          alt="{{ $imageAlt }}"
          class="service-card__visual-img absolute inset-0 h-full w-full object-cover"
          loading="lazy"
          decoding="async"
        />
      </div>
    @else
      <div class="service-card__visual service-card__visual--fallback h-[260px] sm:h-[300px] md:h-[400px]">

        @if($cueLabel)
          <div class="service-card__cue-label">
            {{ $cueLabel }}
          </div>
        @endif

        @switch($cueStyle)
          @case('bars')
            <div class="service-card__bars">
              @foreach(array_values($cueValues) as $v)
                @php $h = max(6, min(100, (int) $v)); @endphp
                <div class="service-card__bar" style="height: {{ intval($h * 0.9) }}%"></div>
              @endforeach
            </div>
            @break

          @case('dots')
            <div class="service-card__dots">
              @foreach(array_values($cueValues) as $v)
                <div @class([
                    'service-card__dot',
                    'is-active' => (int) $v === 1,
                ])></div>
              @endforeach
            </div>
            @break

          @default
            <div class="service-card__bubbles">
              @foreach(array_values($cueValues) as $v)
                @php $s = 26 + round(max(0, min(100, (int) $v)) * 0.25); @endphp
                <div class="service-card__bubble" style="width: {{ $s }}px; height: {{ $s }}px"></div>
              @endforeach
            </div>
        @endswitch
      </div>
    @endif
  </div>
</div>
