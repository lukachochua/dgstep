<x-layouts.base title="DGstep Landing Page">
  <main id="content"
        class="relative flex min-h-screen flex-col
               bg-[color:var(--bg-default)]
               text-[color:var(--text-default)]">

    <x-hero />

    <!-- Soft separator -->
    <div class="md:my-2">
      <div class="h-px w-full
                  bg-gradient-to-r
                  from-transparent
                  via-[color-mix(in_oklab,var(--color-electric-sky)_35%,transparent)]
                  to-transparent
                  opacity-60"></div>
    </div>

    <!-- Features with distinct bg -->
    <section class="relative bg-[color:var(--features-surface)]">
      <x-features />
    </section>
  </main>
</x-layouts.base>
