<x-layouts.base :title="__('auth.reset_password.title')">
  <section class="auth-shell">
    <article class="auth-card reveal">
      <span class="section-kicker">Account Recovery</span>
      <h1 class="section-title mt-3 text-[clamp(1.7rem,2.6vw,2.2rem)]">{{ __('auth.reset_password.heading') }}</h1>
      <p class="mt-2 text-sm text-[color:var(--text-muted)]">{{ __('auth.reset_password.subtitle') }}</p>

      @if ($errors->any())
        <div class="mt-4 rounded-lg border border-[color:var(--danger)]/40 bg-[color:var(--danger)]/10 px-3 py-2 text-sm text-[color:var(--danger)]">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-4">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ request()->email }}">

        <div>
          <label class="field-label">{{ __('auth.reset_password.new_password') }}</label>
          <input type="password" name="password" required class="field-input">
        </div>

        <div>
          <label class="field-label">{{ __('auth.reset_password.confirm_password') }}</label>
          <input type="password" name="password_confirmation" required class="field-input">
        </div>

        <button type="submit" class="btn btn-lg btn-primary w-full justify-center">
          {{ __('auth.reset_password.submit') }}
        </button>
      </form>
    </article>
  </section>
</x-layouts.base>
