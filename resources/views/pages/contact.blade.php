<x-layouts.base :title="__('contact.title')">
  @php
    $headline = $headline ?? __('contact.headline');
    $desc = $desc ?? __('contact.description');
    $featPro = $featPro ?? __('contact.features.professional');
    $featGua = $featGua ?? __('contact.features.guarantees');
    $ctaLabel = $ctaLabel ?? __('contact.cta_button');
    $ctaPhone = $ctaPhone ?? __('contact.cta_phone_href');
    $recaptchaSiteKey = $recaptchaSiteKey ?? config('services.recaptcha.site_key');
    $recaptchaEnabled = $recaptchaEnabled ?? (filled($recaptchaSiteKey) && filled(config('services.recaptcha.secret_key')));
  @endphp

  <section class="section-block contact-page">
    <div class="section-inner grid gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
      <div class="clipped-card space-y-5 reveal">
        <span class="section-kicker">{{ __('contact.tagline') }}</span>
        <h1 class="section-title">{{ $headline }}</h1>
        <p class="section-lead">{{ $desc }}</p>

        <div class="grid gap-3 sm:grid-cols-2">
          <x-ui.stat-card :label="__('contact.metrics.support')">
            <p class="text-sm font-semibold">{{ $featPro }}</p>
          </x-ui.stat-card>
          <x-ui.stat-card :label="__('contact.metrics.team')">
            <p class="text-sm font-semibold">{{ $featGua }}</p>
          </x-ui.stat-card>
        </div>

        <x-ui.button href="tel:{{ $ctaPhone }}" variant="secondary" size="lg">
          {{ $ctaLabel }}
        </x-ui.button>
      </div>

      <x-ui.surface-card class="contact-form-card p-6 md:p-8 reveal reveal-delay-1" id="contact-form">
        <form
          x-data="contactForm({
            initial: {
              name: @js(old('name', '')),
              surname: @js(old('surname', '')),
              phone: @js(old('phone', '')),
              comments: @js(old('comments', '')),
            },
            messages: {
              name: @js(__('contact.validation.name')),
              surname: @js(__('contact.validation.surname')),
              phoneRequired: @js(__('contact.validation.phone_required')),
              phoneInvalid: @js(__('contact.validation.phone_invalid')),
            },
          })"
          x-on:submit.prevent="submitForm"
          method="POST"
          action="{{ route('contact.submit') }}"
          class="space-y-4"
          id="contact-form-el"
        >
          @csrf

          @if (session('success'))
            <div class="feedback-banner feedback-banner--success">
              {{ session('success') }}
            </div>
          @endif

          @if (session('warning'))
            <div class="feedback-banner feedback-banner--warning">
              {{ session('warning') }}
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

          @if ($recaptchaEnabled)
            <div class="contact-recaptcha flex justify-center">
              <div class="g-recaptcha" data-sitekey="{{ $recaptchaSiteKey }}"></div>
            </div>
          @else
            <p class="feedback-banner feedback-banner--warning">
              {{ __('contact.validation.captcha_unavailable') }}
            </p>
          @endif

          @error('g-recaptcha-response')
            <p class="field-error">{{ $message }}</p>
          @enderror

          <x-ui.button as="button" type="submit" variant="primary" size="lg" class="w-full justify-center" :disabled="! $recaptchaEnabled">
            {{ __('contact.form.cta') }}
          </x-ui.button>
        </form>
      </x-ui.surface-card>

    </div>
  </section>

  @if ($recaptchaEnabled)
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  @endif
</x-layouts.base>
