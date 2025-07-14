<x-layouts.base title="Register — DGstep">
    <div class="min-h-screen flex flex-col">
        <section class="flex-grow bg-gradient-to-r from-[#0b0f1a] via-[#141d2f] to-[#0b0f1a] py-24 px-6 text-white">
            <div class="max-w-md mx-auto space-y-8 text-center">
                <h1 class="text-4xl font-extrabold tracking-tight">Register</h1>
                <p class="text-white/70">Create your DGstep account.</p>

                <form method="POST" action="{{ route('register') }}" class="space-y-6 text-left">
                    @csrf

                    <div>
                        <label class="block mb-1 font-medium">Name</label>
                        <input type="text" name="name" required
                            class="w-full px-4 py-2 rounded-md bg-white/5 border border-white/10 text-white placeholder-white/50 focus:ring-2 focus:ring-[var(--color-electric-sky)] outline-none">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Email</label>
                        <input type="email" name="email" required
                            class="w-full px-4 py-2 rounded-md bg-white/5 border border-white/10 text-white placeholder-white/50 focus:ring-2 focus:ring-[var(--color-electric-sky)] outline-none">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Password</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-2 rounded-md bg-white/5 border border-white/10 text-white placeholder-white/50 focus:ring-2 focus:ring-[var(--color-electric-sky)] outline-none">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Confirm Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-4 py-2 rounded-md bg-white/5 border border-white/10 text-white placeholder-white/50 focus:ring-2 focus:ring-[var(--color-electric-sky)] outline-none">
                    </div>

                    <button type="submit"
                        class="w-full py-2 bg-[var(--color-electric-sky)] text-black font-bold rounded-md hover:bg-[var(--color-electric-sky-hover)] transition">
                        Register
                    </button>
                </form>

                <p class="text-white/60 text-sm">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-[var(--color-electric-sky)] hover:underline">Log In</a>
                </p>
            </div>
        </section>
    </div>
</x-layouts.base>
