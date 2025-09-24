<x-layouts.base :title="__('contact.title')">
  <section
    class="py-16 sm:py-20 md:py-24 select-none
           text-[var(--text-default)]
           bg-[var(--bg-default)]
           [background-image:linear-gradient(180deg,transparent_0%,transparent_40%,color-mix(in_oklab,var(--color-brand-950)_6%,transparent)_100%)]
           dark:[background-image:linear-gradient(180deg,color-mix(in_oklab,var(--color-brand-950)_16%,transparent)_0%,transparent_60%,transparent_100%)]">
    <div class="container mx-auto px-4 sm:px-6 md:px-8 grid grid-cols-1 md:grid-cols-2 gap-12 items-start">

      {{-- Left Content --}}
      <div class="space-y-6">
        <span class="uppercase font-medium tracking-wide text-[12px] sm:text-[13px] text-[var(--color-electric-sky)]">
          {{ __('contact.tagline') }}
        </span>

        <h2 class="text-3xl sm:text-4xl font-extrabold leading-snug text-[color-mix(in_oklab,var(--text-default)_94%,transparent)]">
          {{ __('contact.headline') }}
        </h2>

        <p class="text-[16px] leading-relaxed text-[color-mix(in_oklab,var(--text-default)_78%,transparent)]">
          {{ __('contact.description') }}
        </p>

        {{-- Client Satisfaction --}}
        <div class="space-y-2">
          <p class="text-[14px] font-medium flex justify-between
                    text-[color-mix(in_oklab,var(--text-default)_88%,transparent)]">
            <span>{{ __('contact.metric.label') }}</span>
            <span>100%</span>
          </p>
          <div class="w-full h-2 rounded-full overflow-hidden
                      bg-[color-mix(in_oklab,var(--text-default)_10%,transparent)]">
            <div class="h-2 w-full
                        bg-[var(--color-electric-sky)]
                        shadow-[inset_0_0_6px_rgba(0,0,0,.25)]"></div>
          </div>
        </div>

        {{-- Feature Badges --}}
        <div class="flex flex-wrap gap-6 pt-4">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full grid place-items-center
                        bg-[var(--bg-elevated)]
                        ring-1 ring-[color-mix(in_oklab,var(--text-default)_12%,transparent)]">
              <svg class="w-5 h-5 text-[var(--color-electric-sky)]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 6v6l4 2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            <span class="text-sm font-medium text-[color-mix(in_oklab,var(--text-default)_90%,transparent)]">
              {{ __('contact.features.professional') }}
            </span>
          </div>

          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full grid place-items-center
                        bg-[var(--bg-elevated)]
                        ring-1 ring-[color-mix(in_oklab,var(--text-default)_12%,transparent)]">
              <svg class="w-5 h-5 text-[var(--color-electric-sky)]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 12l2 2 4-4" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            <span class="text-sm font-medium text-[color-mix(in_oklab,var(--text-default)_90%,transparent)]">
              {{ __('contact.features.guarantees') }}
            </span>
          </div>
        </div>

        {{-- Optional CTA --}}
        <div class="pt-6">
          <a href="#contact-form" class="btn btn-md btn-secondary">
            {{ __('contact.read_more') }}
          </a>
        </div>
      </div>

      {{-- Contact Form --}}
      <div class="card p-6 sm:p-8 rounded-2xl" id="contact-form">
        <form
          x-data="contactForm()"
          x-on:submit.prevent="submitForm"
          method="POST"
          action="{{ route('contact.submit') }}"
          class="space-y-6"
          id="contact-form-el"
        >
          @csrf

          @if (session('success'))
            <div class="text-[14px] font-medium
                        text-[color-mix(in_oklab,#22c55e_86%,var(--text-default))]">
              {{ session('success') }}
            </div>
          @endif

          {{-- Name --}}
          <div>
            <label for="name" class="text-[14px] font-medium
                                     text-[color-mix(in_oklab,var(--text-default)_86%,transparent)] mb-1 block">
              {{ __('contact.form.name') }} *
            </label>
            <input
              id="name"
              type="text"
              name="name"
              x-model="form.name"
              class="w-full p-3 rounded focus-ring
                     bg-[var(--bg-elevated)]
                     text-[var(--text-default)]
                     border border-[color-mix(in_oklab,var(--text-default)_16%,transparent)]
                     placeholder:text-[color-mix(in_oklab,var(--text-default)_55%,transparent)]"
              :class="{ 'border-[color-mix(in_oklab,#ef4444_90%,transparent)]': errors.name }"
              autocomplete="name"
            />
            <template x-if="errors.name">
              <p class="text-[13px] mt-1 text-[color-mix(in_oklab,#ef4444_86%,transparent)]" x-text="errors.name"></p>
            </template>
          </div>

          {{-- Surname --}}
          <div>
            <label for="surname" class="text-[14px] font-medium
                                        text-[color-mix(in_oklab,var(--text-default)_86%,transparent)] mb-1 block">
              {{ __('contact.form.surname') }} *
            </label>
            <input
              id="surname"
              type="text"
              name="surname"
              x-model="form.surname"
              class="w-full p-3 rounded focus-ring
                     bg-[var(--bg-elevated)]
                     text-[var(--text-default)]
                     border border-[color-mix(in_oklab,var(--text-default)_16%,transparent)]
                     placeholder:text-[color-mix(in_oklab,var(--text-default)_55%,transparent)]"
              :class="{ 'border-[color-mix(in_oklab,#ef4444_90%,transparent)]': errors.surname }"
              autocomplete="family-name"
            />
            <template x-if="errors.surname">
              <p class="text-[13px] mt-1 text-[color-mix(in_oklab,#ef4444_86%,transparent)]" x-text="errors.surname"></p>
            </template>
          </div>

          {{-- Phone --}}
          <div>
            <label for="phone" class="text-[14px] font-medium
                                      text-[color-mix(in_oklab,var(--text-default)_86%,transparent)] mb-1 block">
              {{ __('contact.form.phone') }} *
            </label>
            <input
              id="phone"
              type="tel"
              name="phone"
              x-model="form.phone"
              class="w-full p-3 rounded focus-ring
                     bg-[var(--bg-elevated)]
                     text-[var(--text-default)]
                     border border-[color-mix(in_oklab,var(--text-default)_16%,transparent)]
                     placeholder:text-[color-mix(in_oklab,var(--text-default)_55%,transparent)]"
              :class="{ 'border-[color-mix(in_oklab,#ef4444_90%,transparent)]': errors.phone }"
              inputmode="tel"
              autocomplete="tel"
            />
            <template x-if="errors.phone">
              <p class="text-[13px] mt-1 text-[color-mix(in_oklab,#ef4444_86%,transparent)]" x-text="errors.phone"></p>
            </template>
          </div>

          {{-- Comments --}}
          <div>
            <label for="comments" class="text-[14px] font-medium
                                         text-[color-mix(in_oklab,var(--text-default)_86%,transparent)] mb-1 block">
              {{ __('contact.form.comments') }}
            </label>
            <textarea
              id="comments"
              name="comments"
              x-model="form.comments"
              rows="4"
              class="w-full p-3 rounded focus-ring resize-y
                     bg-[var(--bg-elevated)]
                     text-[var(--text-default)]
                     border border-[color-mix(in_oklab,var(--text-default)_16%,transparent)]
                     placeholder:text-[color-mix(in_oklab,var(--text-default)_55%,transparent)]"></textarea>
          </div>

          <button type="submit" class="btn btn-lg btn-primary w-full">
            {{ __('contact.form.cta') }}
          </button>
        </form>
      </div>
    </div>
  </section>

  <script>
    function contactForm() {
      return {
        form: { name: '', surname: '', phone: '', comments: '' },
        errors: {},
        submitForm() {
          this.errors = {};

          if (!this.form.name)     this.errors.name    = '{{ __('contact.validation.name') }}';
          if (!this.form.surname)  this.errors.surname = '{{ __('contact.validation.surname') }}';

          if (!this.form.phone) {
            this.errors.phone = '{{ __('contact.validation.phone_required') }}';
          } else if (!/^\+?\d{7,15}$/.test(this.form.phone)) {
            this.errors.phone = '{{ __('contact.validation.phone_invalid') }}';
          }

          if (Object.keys(this.errors).length === 0) {
            // Submit the actual FORM element (fixes prior bug submitting a div)
            this.$el.submit();
          }
        }
      }
    }
  </script>
</x-layouts.base>
