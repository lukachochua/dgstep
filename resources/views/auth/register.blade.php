<x-layouts.base :title="__('auth.register.title')">
  <section class="auth-shell">
    <article class="auth-card reveal">
      <span class="section-kicker">Account</span>
      <h1 class="section-title mt-3 text-[clamp(1.7rem,2.6vw,2.2rem)]">{{ __('auth.register.heading') }}</h1>
      <p class="mt-2 text-sm text-[color:var(--text-muted)]">{{ __('auth.register.subtitle') }}</p>

      @if ($errors->any())
        <div class="mt-4 rounded-lg border border-[color:var(--danger)]/40 bg-[color:var(--danger)]/10 px-3 py-2 text-sm text-[color:var(--danger)]">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
        @csrf

        <div>
          <label class="field-label">{{ __('auth.register.name') }}</label>
          <input type="text" name="name" required class="field-input" value="{{ old('name') }}">
        </div>

        <div>
          <label class="field-label">{{ __('auth.register.email') }}</label>
          <input type="email" name="email" required class="field-input" value="{{ old('email') }}">
        </div>

        <div>
          <label class="field-label">{{ __('auth.register.password') }}</label>
          <input type="password" name="password" required class="field-input">
        </div>

        <div>
          <label class="field-label">{{ __('auth.register.confirm') }}</label>
          <input type="password" name="password_confirmation" required class="field-input">
        </div>

        <button type="submit" class="btn btn-lg btn-primary w-full justify-center">
          {{ __('auth.register.submit') }}
        </button>
      </form>

      <p class="mt-6 text-sm text-[color:var(--text-muted)]">
        {{ __('auth.register.login_link') }}
        <a href="{{ route('login') }}" class="font-semibold text-[color:var(--brand-strong)] hover:underline">
          {{ __('auth.register.login_cta') }}
        </a>
      </p>
    </article>
  </section>
</x-layouts.base>
