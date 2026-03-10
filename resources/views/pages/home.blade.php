<x-layouts.base :title="$homePage['title']">
  <x-hero :slides="$slides" :content="$homePage['hero']" />

  <section class="py-3 md:py-6">
    <div class="section-inner">
      <x-ui.surface-card variant="soft" class="home-proof p-5 md:p-7 space-y-5">
        <div class="ltr-reveal" data-reveal-ltr>
          <span class="section-kicker">{{ $homePage['proof']['kicker'] }}</span>
          <h2 class="section-title mt-3">{{ $homePage['proof']['title'] }}</h2>
          <p class="section-lead mt-2">{{ $homePage['proof']['subtitle'] }}</p>
        </div>

        <div class="grid gap-5 md:grid-cols-3" data-reveal-ltr-group>
          <x-ui.stat-card class="ltr-reveal" data-reveal-ltr
            :label="$homePage['metrics']['focus']['label']"
            :value="$homePage['metrics']['focus']['value']"
            :description="$homePage['metrics']['focus']['description']" />
          <x-ui.stat-card class="ltr-reveal" data-reveal-ltr
            :label="$homePage['metrics']['technology']['label']"
            :value="$homePage['metrics']['technology']['value']"
            :description="$homePage['metrics']['technology']['description']" />
          <x-ui.stat-card class="ltr-reveal" data-reveal-ltr
            :label="$homePage['metrics']['approach']['label']"
            :value="$homePage['metrics']['approach']['value']"
            :description="$homePage['metrics']['approach']['description']" />
        </div>
      </x-ui.surface-card>
    </div>
  </section>

  <x-features
    :items="$featured"
    :kicker="$homePage['solutions']['kicker']"
    :title="$homePage['solutions']['title']"
    :subtitle="$homePage['solutions']['subtitle']"
    :linkLabel="$homePage['solutions']['link_label']"
  />

  <section class="section-block pt-0">
    <div class="section-inner">
      <x-ui.section-cta-card
        class="p-6 md:p-9 lg:flex lg:items-center lg:justify-between lg:gap-8 ltr-reveal"
        data-reveal-ltr
        data-reveal-ltr-group
        :kicker="$homePage['cta']['kicker']"
        :title="$homePage['cta']['title']"
        :body="$homePage['cta']['subtitle']"
      >
        <x-slot:actions>
          <div class="mt-5 flex flex-wrap gap-3 lg:mt-0 lg:shrink-0 ltr-reveal" data-reveal-ltr>
            <x-ui.button route="contact" variant="primary" size="lg">{{ $homePage['cta']['primary'] }}</x-ui.button>
            <x-ui.button route="services" variant="ghost" size="lg">{{ $homePage['cta']['secondary'] }}</x-ui.button>
          </div>
        </x-slot:actions>
      </x-ui.section-cta-card>
    </div>
  </section>
</x-layouts.base>
