@props([
  'kicker' => null,
  'title' => '',
  'body' => '',
  'as' => 'section',
])

<x-ui.surface-card :as="$as" {{ $attributes }}>
  <div class="section-cta-card__copy">
    @if (filled($kicker))
      <span class="section-kicker">{{ $kicker }}</span>
    @endif
    <h2 class="section-title {{ filled($kicker) ? 'mt-3' : '' }}">{{ $title }}</h2>
    <p class="section-lead mt-2">{{ $body }}</p>
  </div>

  <div class="section-cta-card__actions">
    {{ $actions ?? '' }}
  </div>
</x-ui.surface-card>
