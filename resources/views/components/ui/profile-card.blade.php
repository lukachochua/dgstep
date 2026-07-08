@props([
  'image' => '',
  'imageAlt' => '',
  'title' => '',
  'subtitle' => '',
  'description' => '',
  'layout' => 'compact',
  'as' => 'article',
])

@php
  $isLead = $layout === 'lead';
@endphp

<x-ui.entity-card :as="$as" variant="team" {{ $attributes }}>
  @if ($isLead)
    <div class="about-team-lead-media">
      <img
        src="{{ $image }}"
        alt="{{ $imageAlt }}"
        class="about-team-lead-image"
        loading="lazy"
        decoding="async"
      />
    </div>

    <div class="about-team-lead-copy">
      @if (filled($subtitle))
        <span class="section-kicker">{{ $subtitle }}</span>
      @endif
      <h3 class="profile-card__lead-title">{{ $title }}</h3>
      @if (filled($description))
        <p class="profile-card__description">{{ $description }}</p>
      @endif
    </div>
  @else
    <div class="about-member-preview">
      <img
        src="{{ $image }}"
        alt="{{ $imageAlt }}"
        class="h-16 w-16 rounded-full object-cover"
        loading="lazy"
        decoding="async"
      />
      <div>
        <h3 class="profile-card__title">{{ $title }}</h3>
        @if (filled($subtitle))
          <p class="profile-card__subtitle">{{ $subtitle }}</p>
        @endif
      </div>
    </div>

    @if (filled($description))
      <p class="profile-card__description mt-4 line-clamp-3">{{ $description }}</p>
    @endif
  @endif
</x-ui.entity-card>
