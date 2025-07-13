<x-layouts.base title="Projects — DGstep">
    <div class="min-h-screen flex flex-col">
        <x-navbar />

        <section
            class="flex-grow bg-gradient-to-r from-[#0b0f1a] via-[#141d2f] to-[#0b0f1a] text-white py-24 select-none">
            <div class="container mx-auto px-4 sm:px-6 md:px-8 space-y-16">

                <!-- Page Header -->
                <div class="text-center max-w-3xl mx-auto space-y-4">
                    <h1 class="text-4xl md:text-5xl font-extrabold drop-shadow-sm text-[var(--color-electric-sky)]">
                        Selected Projects
                    </h1>
                    <p class="text-lg text-white/80">
                        We work with local and regional businesses to design, build, and scale digital tools.
                        Here are a few of the platforms and partnerships we’ve delivered.
                    </p>
                </div>

                <!-- Project Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                    <!-- Card 1 -->
                    <div
                        class="bg-white/5 p-6 rounded-xl border border-white/10 shadow-md hover:shadow-lg transition space-y-4">
                        <img src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Pawnshop ERP" class="rounded-md object-cover w-full h-40">
                        <h3 class="text-xl font-bold text-[var(--color-electric-sky)]">Pawnshop ERP</h3>
                        <p class="text-white/80 text-sm leading-relaxed">
                            Multi-branch pawn management system with loan tracking, redemptions, accounting export, and
                            SMS integrations — compliant with Georgian law.
                        </p>
                    </div>

                    <!-- Card 2 -->
                    <div
                        class="bg-white/5 p-6 rounded-xl border border-white/10 shadow-md hover:shadow-lg transition space-y-4">
                        <img src="https://images.unsplash.com/photo-1560264280-88b68371db39?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Locksmith App" class="rounded-md object-cover w-full h-40">
                        <h3 class="text-xl font-bold text-[var(--color-electric-sky)]">Locksmith Booking App</h3>
                        <p class="text-white/80 text-sm leading-relaxed">
                            Real-time dispatch platform for locksmith teams. Customers book, track, and rate visits.
                            Admins manage availability.
                        </p>
                    </div>

                    <!-- Card 3 -->
                    <div
                        class="bg-white/5 p-6 rounded-xl border border-white/10 shadow-md hover:shadow-lg transition space-y-4">
                        <img src="https://images.unsplash.com/photo-1620825141088-a824daf6a46b?q=80&w=1032&auto=format&fit=crop"
                            alt="DGstep Tools" class="rounded-md object-cover w-full h-40">
                        <h3 class="text-xl font-bold text-[var(--color-electric-sky)]">DGstep Core Toolkit</h3>
                        <p class="text-white/80 text-sm leading-relaxed">
                            Reusable Laravel packages with permission control, team-based roles, and branch-aware data
                            access across projects.
                        </p>
                    </div>
                </div>

                <!-- CTA -->
                <div class="text-center pt-10">
                    <a href="{{ route('contact') }}"
                        class="inline-block mt-6 px-6 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-[var(--color-electric-sky)] transition">
                        Start a Project with Us
                    </a>
                </div>

            </div>
        </section>

        <x-footer />
    </div>
</x-layouts.base>
