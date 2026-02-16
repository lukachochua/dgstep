<x-layouts.base :title="__('contact.title')">
  @php
    $headline = $headline ?? __('contact.headline');
    $desc = $desc ?? __('contact.description');
    $featPro = $featPro ?? __('contact.features.professional');
    $featGua = $featGua ?? __('contact.features.guarantees');
    $ctaLabel = $ctaLabel ?? __('contact.cta_button');
    $ctaPhone = $ctaPhone ?? __('contact.cta_phone_href');
    $recaptchaSiteKey = $recaptchaSiteKey ?? config('services.recaptcha.site_key');
  @endphp

  <section class="section-block">
    <div class="section-inner grid gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
      <div class="space-y-5 reveal">
        <span class="section-kicker">{{ __('contact.tagline') }}</span>
        <h1 class="section-title">{{ $headline }}</h1>
        <p class="section-lead">{{ $desc }}</p>

        <div class="grid gap-3 sm:grid-cols-2">
          <article class="metric-card">
            <p class="text-xs uppercase tracking-[0.12em] text-[color:var(--text-muted)]">Support</p>
            <p class="text-sm font-semibold">{{ $featPro }}</p>
          </article>
          <article class="metric-card">
            <p class="text-xs uppercase tracking-[0.12em] text-[color:var(--text-muted)]">Team</p>
            <p class="text-sm font-semibold">{{ $featGua }}</p>
          </article>
        </div>

        <x-ui.button href="tel:{{ $ctaPhone }}" variant="secondary" size="lg">
          {{ $ctaLabel }}
        </x-ui.button>
      </div>

      <div class="panel p-6 md:p-8 reveal reveal-delay-1" id="contact-form">
        <form
          x-data="contactForm()"
          x-on:submit.prevent="submitForm"
          method="POST"
          action="{{ route('contact.submit') }}"
          class="space-y-4"
          id="contact-form-el"
        >
          @csrf

          @if (session('success'))
            <div class="rounded-lg border border-[color:var(--ok)]/40 bg-[color:var(--ok)]/12 px-3 py-2 text-sm font-medium text-[color:var(--ok)]">
              {{ session('success') }}
            </div>
          @endif

          <div>
            <label for="name" class="field-label">{{ __('contact.form.name') }} *</label>
            <input id="name" type="text" name="name" x-model="form.name" class="field-input" :class="errors.name ? 'border-[color:var(--danger)]' : ''" autocomplete="name" />
            <template x-if="errors.name"><p class="field-error" x-text="errors.name"></p></template>
          </div>

          <div>
            <label for="surname" class="field-label">{{ __('contact.form.surname') }} *</label>
            <input id="surname" type="text" name="surname" x-model="form.surname" class="field-input" :class="errors.surname ? 'border-[color:var(--danger)]' : ''" autocomplete="family-name" />
            <template x-if="errors.surname"><p class="field-error" x-text="errors.surname"></p></template>
          </div>

          <div>
            <label for="phone" class="field-label">{{ __('contact.form.phone') }} *</label>
            <input id="phone" type="tel" name="phone" x-model="form.phone" class="field-input" :class="errors.phone ? 'border-[color:var(--danger)]' : ''" autocomplete="tel" />
            <template x-if="errors.phone"><p class="field-error" x-text="errors.phone"></p></template>
          </div>

          <div>
            <label for="comments" class="field-label">{{ __('contact.form.comments') }}</label>
            <textarea id="comments" name="comments" x-model="form.comments" rows="4" class="field-textarea"></textarea>
          </div>

          @if ($recaptchaSiteKey)
            <div class="flex justify-center">
              <div class="g-recaptcha" data-sitekey="{{ $recaptchaSiteKey }}"></div>
            </div>
          @else
            <p class="rounded-lg border border-[color:var(--accent)]/50 bg-[color:var(--accent-soft)] px-3 py-2 text-sm text-[color:var(--text)]">
              {{ __('contact.validation.captcha_unavailable') }}
            </p>
          @endif

          @error('g-recaptcha-response')
            <p class="field-error">{{ $message }}</p>
          @enderror

          <button type="submit" class="btn btn-lg btn-primary w-full justify-center">
            {{ __('contact.form.cta') }}
          </button>
        </form>
      </div>
    </div>
  </section>

  <script>
    function contactForm() {
      return {
        form: {
          name: @js(old('name', '')),
          surname: @js(old('surname', '')),
          phone: @js(old('phone', '')),
          comments: @js(old('comments', '')),
        },
        errors: {},
        submitForm() {
          this.errors = {};

          if (!this.form.name) this.errors.name = '{{ __('contact.validation.name') }}';
          if (!this.form.surname) this.errors.surname = '{{ __('contact.validation.surname') }}';

          if (!this.form.phone) {
            this.errors.phone = '{{ __('contact.validation.phone_required') }}';
          } else if (!/^\+?\d{7,15}$/.test(this.form.phone)) {
            this.errors.phone = '{{ __('contact.validation.phone_invalid') }}';
          }

          if (Object.keys(this.errors).length === 0) {
            this.$el.submit();
          }
        }
      };
    }
  </script>

  @if ($recaptchaSiteKey)
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  @endif
</x-layouts.base>
