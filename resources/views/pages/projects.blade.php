<x-layouts.base :title="__('projects.title')">
  <div class="min-h-screen flex flex-col">
    <section
      class="flex-grow py-20 sm:py-24 select-none
             text-[var(--text-default)]
             bg-[var(--bg-default)]
             [background-image:linear-gradient(180deg,transparent_0%,transparent_40%,color-mix(in_oklab,var(--color-brand-950)_6%,transparent)_100%)]
             dark:[background-image:linear-gradient(180deg,color-mix(in_oklab,var(--color-brand-950)_16%,transparent)_0%,transparent_60%,transparent_100%)]">

      <div class="container mx-auto px-4 sm:px-6 md:px-8 space-y-16">

        <!-- Page Header -->
        <div class="text-center max-w-3xl mx-auto space-y-4">
          <h1 class="text-4xl md:text-5xl font-extrabold drop-shadow-sm
                     text-[color-mix(in_oklab,var(--color-electric-sky)_92%,var(--text-default))]">
            {{ __('projects.heading') }}
          </h1>
          <p class="text-lg leading-relaxed text-[color-mix(in_oklab,var(--text-default)_82%,transparent)]">
            {{ __('projects.subheading') }}
          </p>
        </div>

        <!-- Project Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 lg:gap-12">
          @foreach (__('projects.cards') as $i => $card)
            <div class="card p-6 space-y-4 group transition">
              <div class="overflow-hidden rounded-lg aspect-[16/9]">
                <img
                  @if ($i === 0)
                    src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0"
                  @elseif($i === 1)
                    src="https://images.unsplash.com/photo-1560264280-88b68371db39?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0"
                  @else
                    src="https://images.unsplash.com/photo-1620825141088-a824daf6a46b?q=80&w=1032&auto=format&fit=crop"
                  @endif
                  alt="{{ $card['title'] }}"
                  class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                  loading="lazy"
                >
              </div>
              <h3 class="text-xl font-bold leading-tight
                         text-[color-mix(in_oklab,var(--color-electric-sky)_90%,var(--text-default))]">
                {{ $card['title'] }}
              </h3>
              <p class="text-sm leading-relaxed text-[color-mix(in_oklab,var(--text-default)_78%,transparent)]">
                {{ $card['description'] }}
              </p>
            </div>
          @endforeach
        </div>

        <!-- CTA -->
        <div class="text-center pt-6">
          <a href="{{ route('contact') }}" class="btn btn-md btn-primary">
            {{ __('projects.cta') }}
          </a>
        </div>

      </div>
    </section>
  </div>
</x-layouts.base>
