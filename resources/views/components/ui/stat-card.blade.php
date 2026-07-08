@props([
  'label' => '',
  'value' => '',
  'description' => null,
  'as' => 'article',
])

<x-ui.metric-card :as="$as" {{ $attributes }}>
  @if (filled($label))
    <p class="metric-label">{{ $label }}</p>
  @endif

  @if (filled($value))
    <p class="metric-value">{{ $value }}</p>
  @endif

  @if (filled($description))
    <p class="metric-description">{{ $description }}</p>
  @endif

  {{ $slot }}
</x-ui.metric-card>
