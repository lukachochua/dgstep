@php
    $headline = $headline ?? __('contact.headline');
    $desc = $desc ?? __('contact.description');
    $intakeHeading = $intakeHeading ?? __('contact.form.intake_heading');
    $intakeDescription = $intakeDescription ?? __('contact.form.intake_description');
    $ctaLabel = $ctaLabel ?? __('contact.cta_button');
    $ctaPhone = $ctaPhone ?? __('contact.cta_phone_href');
    $recaptchaSiteKey = $recaptchaSiteKey ?? config('services.recaptcha.site_key');
    $recaptchaEnabled = $recaptchaEnabled ?? (filled($recaptchaSiteKey) && filled(config('services.recaptcha.secret_key')));
    $pageTitle = __('contact.title') . ' | DGstep';
    $seoDescription = \Illuminate\Support\Str::limit(
      \Illuminate\Support\Str::squish(strip_tags($desc)),
      158,
      ''
    );

    $seo = [
      'title' => $pageTitle,
      'description' => $seoDescription,
      'og_title' => $headline,
      'og_description' => $seoDescription,
      'og_type' => 'website',
      'canonical' => route('contact'),
    ];

    $structuredData = [
      [
        '@context' => 'https://schema.org',
        '@type' => 'ContactPage',
        'name' => $pageTitle,
        'description' => $seoDescription,
        'url' => route('contact'),
        'inLanguage' => app()->getLocale(),
        'isPartOf' => ['@id' => url('/#website')],
        'mainEntity' => [
          '@type' => 'Organization',
          '@id' => url('/#organization'),
          'telephone' => $ctaPhone,
        ],
      ],
    ];
@endphp

<x-layouts.base :title="$pageTitle" :seo="$seo" :structured-data="$structuredData">

  <section class="section-block contact-page">
    <div class="section-inner grid gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:items-stretch">
      <div class="clipped-card contact-intro-panel reveal">
        <span class="section-kicker">{{ __('contact.tagline') }}</span>
        <h1 class="section-title">{{ $headline }}</h1>
        <p class="section-lead">{{ $desc }}</p>

        <div class="contact-intro-panel__action">
          <x-ui.button href="tel:{{ $ctaPhone }}" variant="secondary" size="lg">
            {{ $ctaLabel }}
          </x-ui.button>
        </div>
      </div>

      <x-ui.surface-card class="contact-form-card p-6 md:p-8 reveal reveal-delay-1" id="contact-form">
        <form
          x-data="contactForm({
            initial: {
              name: @js(old('name', '')),
              surname: @js(old('surname', '')),
              company_name: @js(old('company_name', '')),
              phone: @js(old('phone', '')),
              project_type: @js(old('project_type', '')),
              system_area: @js(old('system_area', '')),
              timeline: @js(old('timeline', '')),
              comments: @js(old('comments', '')),
            },
            messages: {
              name: @js(__('contact.validation.name')),
              surname: @js(__('contact.validation.surname')),
              phoneRequired: @js(__('contact.validation.phone_required')),
              phoneInvalid: @js(__('contact.validation.phone_invalid')),
              projectType: @js(__('contact.validation.project_type')),
              systemArea: @js(__('contact.validation.system_area')),
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

          <fieldset class="contact-intake-block">
            <legend>{{ $intakeHeading }}</legend>
            <p>{{ $intakeDescription }}</p>

            <div class="contact-intake-grid">
              <div>
                <label for="project_type" class="field-label">{{ __('contact.form.project_type') }} *</label>
                <select id="project_type" name="project_type" x-model="form.project_type" class="field-input" :class="errors.project_type ? 'border-[color:var(--danger)]' : ''" required>
                  <option value="">{{ __('contact.form.select_option') }}</option>
                  @foreach (__('contact.form.project_types') as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                  @endforeach
                </select>
                <template x-if="errors.project_type"><p class="field-error" x-text="errors.project_type"></p></template>
              </div>

              <div>
                <label for="system_area" class="field-label">{{ __('contact.form.system_area') }} *</label>
                <select id="system_area" name="system_area" x-model="form.system_area" class="field-input" :class="errors.system_area ? 'border-[color:var(--danger)]' : ''" required>
                  <option value="">{{ __('contact.form.select_option') }}</option>
                  @foreach (__('contact.form.system_areas') as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                  @endforeach
                </select>
                <template x-if="errors.system_area"><p class="field-error" x-text="errors.system_area"></p></template>
              </div>

              <div>
                <label for="company_name" class="field-label">{{ __('contact.form.company_name') }}</label>
                <input id="company_name" type="text" name="company_name" x-model="form.company_name" class="field-input" autocomplete="organization" maxlength="255" />
              </div>

              <div>
                <label for="timeline" class="field-label">{{ __('contact.form.timeline') }}</label>
                <select id="timeline" name="timeline" x-model="form.timeline" class="field-input">
                  <option value="">{{ __('contact.form.select_option') }}</option>
                  @foreach (__('contact.form.timelines') as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </fieldset>

          <div class="contact-intake-grid">
            <div>
              <label for="name" class="field-label">{{ __('contact.form.name') }} *</label>
              <input id="name" type="text" name="name" x-model="form.name" class="field-input" :class="errors.name ? 'border-[color:var(--danger)]' : ''" autocomplete="given-name" />
              <template x-if="errors.name"><p class="field-error" x-text="errors.name"></p></template>
            </div>

            <div>
              <label for="surname" class="field-label">{{ __('contact.form.surname') }} *</label>
              <input id="surname" type="text" name="surname" x-model="form.surname" class="field-input" :class="errors.surname ? 'border-[color:var(--danger)]' : ''" autocomplete="family-name" />
              <template x-if="errors.surname"><p class="field-error" x-text="errors.surname"></p></template>
            </div>
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
