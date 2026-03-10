@props([
  'href' => '#',
  'index' => '',
  'title' => '',
  'subtitle' => '',
])

<a href="{{ $href }}" {{ $attributes->class(['services-overview-item']) }}>
  <span class="services-overview-item__index">{{ $index }}</span>
  <span class="services-overview-item__content">
    <strong>{{ $title }}</strong>
    @if (filled($subtitle))
      <span>{{ $subtitle }}</span>
    @endif
  </span>
</a>
