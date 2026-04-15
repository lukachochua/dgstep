<x-layouts.base :title="__('auth.forgot_password.title')">
  <section class="auth-shell">
    <x-ui.entity-card variant="auth" class="reveal">
      <span class="section-kicker">Account Recovery</span>
      <h1 class="section-title mt-3 text-[clamp(1.7rem,2.6vw,2.2rem)]">{{ __('auth.forgot_password.heading') }}</h1>
      <p class="mt-2 text-sm text-[color:var(--text-muted)]">{{ __('auth.forgot_password.subtitle') }}</p>

      @if (session('status'))
        <div class="feedback-banner feedback-banner--success mt-4">
          {{ session('status') }}
        </div>
      @endif

      @if ($errors->any())
        <div class="feedback-banner feedback-banner--error mt-4">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-4">
        @csrf

        <div>
          <label class="field-label">{{ __('auth.forgot_password.email') }}</label>
          <input type="email" name="email" required class="field-input" value="{{ old('email') }}">
        </div>

        <button type="submit" class="btn btn-lg btn-primary w-full justify-center">
          <span class="btn__label">{{ __('auth.forgot_password.submit') }}</span>
        </button>
      </form>

      <p class="mt-6 text-sm">
        <a href="{{ route('login') }}" class="font-semibold text-[color:var(--brand-strong)] hover:underline">
          {{ __('auth.forgot_password.back_to_login') }}
        </a>
      </p>
    </x-ui.entity-card>
  </section>
</x-layouts.base>
