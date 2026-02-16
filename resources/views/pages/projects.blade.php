<x-layouts.base :title="__('projects.title')">
  <section class="section-block">
    <div class="section-inner space-y-8">
      <header class="space-y-3 reveal">
        <span class="section-kicker">{{ __('messages.projects') }}</span>
        <h1 class="section-title">{{ __('projects.heading') }}</h1>
        <p class="section-lead">{{ __('projects.subheading') }}</p>
      </header>

      <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3 stagger">
        @foreach (__('projects.cards') as $i => $card)
          <article class="project-card p-4 md:p-5">
            <img
              @if ($i === 0)
                src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?q=80&w=1000&auto=format&fit=crop"
              @elseif($i === 1)
                src="https://images.unsplash.com/photo-1560264280-88b68371db39?q=80&w=1000&auto=format&fit=crop"
              @else
                src="https://images.unsplash.com/photo-1620825141088-a824daf6a46b?q=80&w=1000&auto=format&fit=crop"
              @endif
              alt="{{ $card['title'] }}"
              class="project-image h-44 w-full"
              loading="lazy"
              decoding="async"
            />

            <h2 class="mt-4 text-xl font-semibold leading-tight">{{ $card['title'] }}</h2>
            <p class="mt-2 text-sm text-[color:var(--text-muted)]">{{ $card['description'] }}</p>
          </article>
        @endforeach
      </div>

      <div class="panel p-6 md:p-8 reveal">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
          <div>
            <h2 class="text-2xl font-semibold">{{ __('projects.cta_heading') }}</h2>
            <p class="mt-1 text-sm text-[color:var(--text-muted)]">{{ __('projects.cta_description') }}</p>
          </div>

          <x-ui.button route="contact" variant="primary" size="lg">
            {{ __('projects.cta') }}
          </x-ui.button>
        </div>
      </div>
    </div>
  </section>
</x-layouts.base>
