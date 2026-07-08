@php
  $seoDescription = \Illuminate\Support\Str::limit(
    \Illuminate\Support\Str::squish(strip_tags(__('terms.sections.intro'))),
    158,
    ''
  );

  $seo = [
    'title' => __('terms.title') . ' | DGstep',
    'description' => $seoDescription,
    'og_title' => __('terms.title'),
    'og_description' => $seoDescription,
  ];

  $structuredData = [
    [
      '@context' => 'https://schema.org',
      '@type' => 'WebPage',
      'name' => __('terms.title'),
      'description' => $seoDescription,
      'url' => route('terms'),
      'inLanguage' => app()->getLocale(),
      'isPartOf' => ['@id' => url('/#website')],
    ],
  ];
@endphp

<x-layouts.base :title="__('terms.title')" :seo="$seo" :structured-data="$structuredData">
  <section class="section-block">
    <div class="section-inner max-w-4xl space-y-6">
      <header class="space-y-3 reveal">
        <span class="section-kicker">{{ __('terms.kicker') }}</span>
        <h1 class="section-title">{{ __('terms.title') }}</h1>
        <p class="section-lead">{{ __('terms.sections.intro') }}</p>
      </header>

      <x-ui.entity-card variant="legal" class="p-6 md:p-8 reveal reveal-delay-1">
        <div class="legal-copy space-y-6">
          <section>
            <h2 class="legal-copy__title">{{ __('terms.sections.1_title') }}</h2>
            <p class="mt-2">{{ __('terms.sections.1_text') }}</p>
          </section>

          <section>
            <h2 class="legal-copy__title">{{ __('terms.sections.2_title') }}</h2>
            <p class="mt-2">{{ __('terms.sections.2_text') }}</p>
          </section>

          <section>
            <h2 class="legal-copy__title">{{ __('terms.sections.3_title') }}</h2>
            <p class="mt-2">{{ __('terms.sections.3_text') }}</p>
          </section>

          <section>
            <h2 class="legal-copy__title">{{ __('terms.sections.4_title') }}</h2>
            <p class="mt-2">{{ __('terms.sections.4_text') }}</p>
          </section>

          <section>
            <h2 class="legal-copy__title">{{ __('terms.sections.5_title') }}</h2>
            <p class="mt-2">{{ __('terms.sections.5_text') }}</p>
          </section>

          <p>{{ __('terms.sections.contact') }}</p>
        </div>

        <div class="mt-7">
          <x-ui.button route="contact" variant="primary" size="md">
            {{ __('terms.sections.cta') }}
          </x-ui.button>
        </div>
      </x-ui.entity-card>
    </div>
  </section>
</x-layouts.base>
