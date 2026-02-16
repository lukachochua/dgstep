<x-layouts.base :title="__('auth.login.title')">
  <section class="auth-shell">
    <article class="auth-card reveal">
      <span class="section-kicker">Account</span>
      <h1 class="section-title mt-3 text-[clamp(1.7rem,2.6vw,2.2rem)]">{{ __('auth.login.heading') }}</h1>
      <p class="mt-2 text-sm text-[color:var(--text-muted)]">{{ __('auth.login.subtitle') }}</p>

      @if ($errors->any())
        <div class="mt-4 rounded-lg border border-[color:var(--danger)]/40 bg-[color:var(--danger)]/10 px-3 py-2 text-sm text-[color:var(--danger)]">
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
          {{ __('auth.login.submit') }}
        </button>
      </form>

      <p class="mt-6 text-sm text-[color:var(--text-muted)]">
        {{ __('auth.login.register_link') }}
        <a href="{{ route('register') }}" class="font-semibold text-[color:var(--brand-strong)] hover:underline">
          {{ __('auth.login.register_cta') }}
        </a>
      </p>
    </article>
  </section>
</x-layouts.base>
