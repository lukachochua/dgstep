<x-layouts.base title="Login — DGstep">
    <div class="min-h-screen flex flex-col">
        <section class="flex-grow bg-gradient-to-r from-[#0b0f1a] via-[#141d2f] to-[#0b0f1a] py-24 px-6 text-white">
            <div class="max-w-md mx-auto space-y-8 text-center">
                <h1 class="text-4xl font-extrabold tracking-tight">Log In</h1>
                <p class="text-white/70">Access your dashboard and tools.</p>

                <form method="POST" action="{{ route('login') }}" class="space-y-6 text-left">
                    @csrf

                    <div>
                        <label class="block mb-1 font-medium">Email</label>
                        <input type="email" name="email" required autofocus
                            class="w-full px-4 py-2 rounded-md bg-white/5 border border-white/10 text-white placeholder-white/50 focus:ring-2 focus:ring-[var(--color-electric-sky)] outline-none">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Password</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-2 rounded-md bg-white/5 border border-white/10 text-white placeholder-white/50 focus:ring-2 focus:ring-[var(--color-electric-sky)] outline-none">
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center space-x-2 text-sm text-white/70">
                            <input type="checkbox" name="remember" class="form-checkbox">
                            <span>Remember me</span>
                        </label>
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-[var(--color-electric-sky)] hover:underline">Forgot Password?</a>
                    </div>

                    <button type="submit"
                        class="w-full py-2 bg-[var(--color-electric-sky)] text-black font-bold rounded-md hover:bg-[var(--color-electric-sky-hover)] transition">
                        Log In
                    </button>
                </form>

                <p class="text-white/60 text-sm">
                    Don’t have an account?
                    <a href="{{ route('register') }}"
                        class="text-[var(--color-electric-sky)] hover:underline">Register</a>
                </p>
            </div>
        </section>
    </div>
</x-layouts.base>
