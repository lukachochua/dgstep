<x-layouts.base :title="__('auth.reset_password.title')">
    <div class="min-h-screen flex flex-col">
        <section class="flex-grow bg-gradient-to-r from-[#0b0f1a] via-[#141d2f] to-[#0b0f1a] py-24 px-6 text-white">
            <div class="max-w-md mx-auto space-y-8 text-center">
                <h1 class="text-4xl font-extrabold tracking-tight">{{ __('auth.reset_password.heading') }}</h1>
                <p class="text-white/70">{{ __('auth.reset_password.subtitle') }}</p>

                <form method="POST" action="{{ route('password.update') }}" class="space-y-6 text-left">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ request()->email }}">

                    <div>
                        <label class="block mb-1 font-medium">{{ __('auth.reset_password.new_password') }}</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-2 rounded-md bg-white/5 border border-white/10 text-white placeholder-white/50 focus:ring-2 focus:ring-[var(--color-electric-sky)] outline-none">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">{{ __('auth.reset_password.confirm_password') }}</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-4 py-2 rounded-md bg-white/5 border border-white/10 text-white placeholder-white/50 focus:ring-2 focus:ring-[var(--color-electric-sky)] outline-none">
                    </div>

                    <button type="submit"
                        class="w-full py-2 bg-[var(--color-electric-sky)] text-black font-bold rounded-md hover:bg-[var(--color-electric-sky-hover)] transition">
                        {{ __('auth.reset_password.submit') }}
                    </button>
                </form>
            </div>
        </section>
    </div>
</x-layouts.base>
