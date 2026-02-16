@php
  use Illuminate\Support\HtmlString;
@endphp

<x-layouts.base :title="__('services.title')">
  <section class="section-block">
    <div class="section-inner space-y-8">
      <header class="space-y-3 reveal">
        <span class="section-kicker">{{ __('messages.services') }}</span>
        <h1 class="section-title">{{ __('services.our_key_services') }}</h1>
        <p class="section-lead">{{ __('services.how_we_can_help') }}</p>
      </header>

      @php
        $locale = app()->getLocale();
        $services = \App\Models\Service::ordered()->get();
      @endphp

      <div class="space-y-6">
        @foreach($services as $i => $service)
          @php
            $names = $service->name ?? [];
            $descriptions = $service->description ?? [];
            $expanded = $service->description_expanded ?? [];

            $title = is_array($names) ? ($names[$locale] ?? $names['en'] ?? '') : (string) $names;
            $description = is_array($descriptions) ? ($descriptions[$locale] ?? $descriptions['en'] ?? '') : (string) $descriptions;
            $descriptionFull = is_array($expanded) ? ($expanded[$locale] ?? $expanded['en'] ?? '') : (string) $expanded;

            $imageUrl = $service->image_url ?? null;
            $imageAlt = $service->image_alt ?: $title;
          @endphp

          <x-service.row
            :title="$title"
            :description="$description"
            :fullDescription="new HtmlString($descriptionFull)"
            :image="$imageUrl"
            :imageAlt="$imageAlt"
            :reversed="($i % 2) === 1"
          />
        @endforeach
      </div>

      <div class="panel p-6 md:p-8 reveal">
        <h2 class="text-2xl font-semibold">{{ __('services.sections.problems_heading') }}</h2>
        <ul class="mt-4 grid gap-3 md:grid-cols-2">
          @foreach (__('services.sections.problems') as $problem)
            <li class="panel-soft px-4 py-3 text-sm text-[color:var(--text-muted)]">
              {{ $problem }}
            </li>
          @endforeach
        </ul>

        <div class="mt-6">
          <x-ui.button route="contact" variant="primary" size="lg">
            {{ __('about.cta') }}
          </x-ui.button>
        </div>
      </div>
    </div>
  </section>
</x-layouts.base>
