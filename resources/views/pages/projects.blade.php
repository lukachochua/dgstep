<x-layouts.base :title="$page['title'] ?? __('projects.title')">
  <section class="section-block">
    <div class="section-inner space-y-8">
      <section class="panel projects-hero-card p-6 md:p-8 lg:p-10 reveal">
        <div class="projects-hero-grid">
          <div class="space-y-5">
            <span class="section-kicker">{{ $page['hero_kicker'] }}</span>
            <h1 class="section-title">{{ $page['hero_title'] }}</h1>
            <p class="section-lead">{{ $page['hero_lead'] }}</p>
          </div>

          <div class="projects-proof-band">
            <div class="space-y-3">
              <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[color:var(--brand-strong)]">
                {{ $page['proof_heading'] }}
              </p>
              <p class="text-sm leading-6 text-[color:var(--text-muted)] md:text-base">
                {{ $page['proof_body'] }}
              </p>
            </div>

            @if (!empty($page['proof_items']))
              <div class="projects-proof-list">
                @foreach ($page['proof_items'] as $item)
                  <span class="projects-proof-chip">{{ $item }}</span>
                @endforeach
              </div>
            @endif
          </div>
        </div>
      </section>

      <section class="projects-grid stagger">
        @foreach ($cards as $card)
          <article class="project-card projects-card p-4 md:p-5">
            @if (!empty($card['image']))
              <img
                src="{{ $card['image'] }}"
                alt="{{ $card['title'] }}"
                class="project-image h-52 w-full"
                loading="lazy"
                decoding="async"
              />
            @endif

            <div class="projects-card-copy">
              <h2 class="text-xl font-semibold leading-tight">{{ $card['title'] }}</h2>
              <p class="text-sm leading-6 text-[color:var(--text-muted)]">{{ $card['description'] }}</p>
            </div>
          </article>
        @endforeach
      </section>

      <section class="panel projects-cta p-6 md:p-8 reveal">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
          <div>
            <h2 class="text-2xl font-semibold">{{ $page['cta_heading'] }}</h2>
            <p class="mt-1 text-sm text-[color:var(--text-muted)] md:text-base">{{ $page['cta_description'] }}</p>
          </div>

          <x-ui.button route="contact" variant="primary" size="lg" class="projects-cta-button">
            {{ $page['cta_label'] }}
          </x-ui.button>
        </div>
      </section>
    </div>
  </section>
</x-layouts.base>
