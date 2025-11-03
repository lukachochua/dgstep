<x-layouts.base :title="__('services.title')">
  <div class="min-h-screen flex flex-col">
    <section
      class="flex-grow bg-[var(--bg-default)] text-[var(--text-default)] py-16 sm:py-20 select-none">

      @php
        $locale = app()->getLocale();
        $services = \App\Models\Service::ordered()->get();
      @endphp

      <div class="container mx-auto max-w-6xl px-4 sm:px-6 md:px-8 space-y-20">
        <header class="text-center mb-10">
          <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight">
            {{ __('services.title') }}
          </h1>
        </header>

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
            :full-description="$descriptionFull"
            :image="$imageUrl"
            :image-alt="$imageAlt"
            :reversed="$i % 2 !== 0" />
        @endforeach

        <div class="text-center pt-10">
          <a href="{{ route('contact') }}" class="btn btn-md btn-primary">
            {{ __('about.cta') }}
          </a>
        </div>
      </div>
    </section>
  </div>
</x-layouts.base>
