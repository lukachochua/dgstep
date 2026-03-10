@props([
  'label' => '',
  'value' => '',
  'description' => null,
  'as' => 'article',
])

<x-ui.metric-card :as="$as" {{ $attributes }}>
  @if (filled($label))
    <p class="text-xs uppercase tracking-[0.12em] text-[color:var(--text-muted)]">{{ $label }}</p>
  @endif

  @if (filled($value))
    <p class="metric-value">{{ $value }}</p>
  @endif

  @if (filled($description))
    <p class="text-sm text-[color:var(--text-muted)]">{{ $description }}</p>
  @endif

  {{ $slot }}
</x-ui.metric-card>
