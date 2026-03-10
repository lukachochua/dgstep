<x-layouts.base :title="__('auth.forgot_password.title')">
  <section class="auth-shell">
    <x-ui.entity-card variant="auth" class="reveal">
      <span class="section-kicker">Account Recovery</span>
      <h1 class="section-title mt-3 text-[clamp(1.7rem,2.6vw,2.2rem)]">{{ __('auth.forgot_password.heading') }}</h1>
      <p class="mt-2 text-sm text-[color:var(--text-muted)]">{{ __('auth.forgot_password.subtitle') }}</p>

      @if (session('status'))
        <div class="mt-4 rounded-lg border border-[color:var(--ok)]/40 bg-[color:var(--ok)]/10 px-3 py-2 text-sm text-[color:var(--ok)]">
          {{ session('status') }}
        </div>
      @endif

      @if ($errors->any())
        <div class="mt-4 rounded-lg border border-[color:var(--danger)]/40 bg-[color:var(--danger)]/10 px-3 py-2 text-sm text-[color:var(--danger)]">
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
          {{ __('auth.forgot_password.submit') }}
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
