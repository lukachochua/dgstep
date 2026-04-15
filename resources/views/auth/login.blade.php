<x-layouts.base :title="__('auth.login.title')">
  <section class="auth-shell">
    <x-ui.entity-card variant="auth" class="reveal">
      <span class="section-kicker">Account</span>
      <h1 class="section-title mt-3 text-[clamp(1.7rem,2.6vw,2.2rem)]">{{ __('auth.login.heading') }}</h1>
      <p class="mt-2 text-sm text-[color:var(--text-muted)]">{{ __('auth.login.subtitle') }}</p>

      @if ($errors->any())
        <div class="feedback-banner feedback-banner--error mt-4">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
        @csrf

        <div>
          <label class="field-label">{{ __('auth.login.email') }}</label>
          <input type="email" name="email" required autofocus class="field-input" value="{{ old('email') }}">
        </div>

        <div>
          <label class="field-label">{{ __('auth.login.password') }}</label>
          <input type="password" name="password" required class="field-input">
        </div>

        <div class="flex items-center justify-between text-sm">
          <label class="inline-flex items-center gap-2 text-[color:var(--text-muted)]">
            <input type="checkbox" name="remember" class="rounded border-[color:var(--border)] text-[color:var(--brand)] focus:ring-[color:var(--ring)]">
            <span>{{ __('auth.login.remember') }}</span>
          </label>

          <a href="{{ route('password.request') }}" class="text-[color:var(--brand-strong)] hover:underline">
            {{ __('auth.login.forgot') }}
          </a>
        </div>

        <button type="submit" class="btn btn-lg btn-primary w-full justify-center">
          <span class="btn__label">{{ __('auth.login.submit') }}</span>
        </button>
      </form>

      <p class="mt-6 text-sm text-[color:var(--text-muted)]">
        {{ __('auth.login.register_link') }}
        <a href="{{ route('register') }}" class="font-semibold text-[color:var(--brand-strong)] hover:underline">
          {{ __('auth.login.register_cta') }}
        </a>
      </p>
    </x-ui.entity-card>
  </section>
</x-layouts.base>
