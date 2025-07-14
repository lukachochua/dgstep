<x-layouts.base title="Forgot Password — DGstep">
    <div class="min-h-screen flex flex-col">
        <section class="flex-grow bg-gradient-to-r from-[#0b0f1a] via-[#141d2f] to-[#0b0f1a] py-24 px-6 text-white">
            <div class="max-w-md mx-auto space-y-8 text-center">
                <h1 class="text-4xl font-extrabold tracking-tight">Forgot Password?</h1>
                <p class="text-white/70">We’ll send you a reset link to your email.</p>

                @if (session('status'))
                    <div class="text-sm text-green-400 font-semibold">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6 text-left">
                    @csrf

                    <div>
                        <label class="block mb-1 font-medium">Email</label>
                        <input type="email" name="email" required
                            class="w-full px-4 py-2 rounded-md bg-white/5 border border-white/10 text-white placeholder-white/50 focus:ring-2 focus:ring-[var(--color-electric-sky)] outline-none">
                    </div>

                    <button type="submit"
                        class="w-full py-2 bg-[var(--color-electric-sky)] text-black font-bold rounded-md hover:bg-[var(--color-electric-sky-hover)] transition">
                        Send Reset Link
                    </button>
                </form>

                <p class="text-white/60 text-sm">
                    <a href="{{ route('login') }}" class="text-[var(--color-electric-sky)] hover:underline">Back to
                        Login</a>
                </p>
            </div>
        </section>
    </div>
</x-layouts.base>
