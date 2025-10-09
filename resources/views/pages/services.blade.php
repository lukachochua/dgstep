<x-layouts.base :title="__('services.title')">
  <div class="min-h-screen flex flex-col">
    <section
      class="flex-grow select-none
             text-[var(--text-default)]
             bg-[var(--bg-default)]
             [background-image:linear-gradient(180deg,transparent_0%,transparent_40%,color-mix(in_oklab,var(--color-brand-950)_6%,transparent)_100%)]
             dark:[background-image:linear-gradient(180deg,color-mix(in_oklab,var(--color-brand-950)_16%,transparent)_0%,transparent_60%,transparent_100%)]
             py-14 sm:py-16 md:py-20">

      @php
        $locale = app()->getLocale();
        $page   = \App\Models\ServicesPage::singleton();
        $sections = $page->sections ?? [];
        if (!is_array($sections) || empty($sections)) {
            $sections = \App\Models\ServicesPage::defaults()['sections'];
        }
      @endphp

      <div class="container mx-auto max-w-6xl px-4 sm:px-6 md:px-8 space-y-8">
        <header class="text-center mb-4">
          <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">
            {{ $page->translated('title', $locale) ?? __('services.title') }}
          </h1>
        </header>

        <div class="space-y-6">
          @foreach($sections as $row)
            @php
              $t  = is_array($row['title'] ?? null) ? ($row['title'][$locale] ?? $row['title']['en'] ?? '') : ($row['title'] ?? '');
              $d  = is_array($row['description'] ?? null) ? ($row['description'][$locale] ?? $row['description']['en'] ?? '') : ($row['description'] ?? '');
              $cs = $row['cue_style']   ?? 'bubbles';
              $cl = is_array($row['cue_label'] ?? null) ? ($row['cue_label'][$locale] ?? $row['cue_label']['en'] ?? '') : ($row['cue_label'] ?? '');
              $cv = array_values($row['cue_values'] ?? []);
            @endphp

            <x-service.row
              :title="$t"
              :description="$d"
              :cue-style="$cs"
              :cue-label="$cl"
              :cue-values="$cv" />
          @endforeach
        </div>

        <div class="text-center pt-4">
          <a href="{{ route('contact') }}" class="btn btn-md btn-primary">
            {{ __('about.cta') }}
          </a>
        </div>
      </div>
    </section>
  </div>
</x-layouts.base>
