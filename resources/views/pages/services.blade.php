<x-layouts.base :title="__('services.title')">
    <div class="min-h-screen flex flex-col">
        <!-- Services Section -->
        <section
            class="flex-grow bg-gradient-to-r from-[#0b0f1a] via-[#141d2f] to-[#0b0f1a] text-white py-24 select-none">
            <div class="container mx-auto px-4 sm:px-6 md:px-8 space-y-24">

                <!-- Pawnshop Ops -->
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-extrabold mb-4 text-[var(--color-electric-sky)]">
                            {{ __('services.sections.pawnshop.title') }}
                        </h2>
                        <p class="text-white/80 text-lg leading-relaxed">
                            {{ __('services.sections.pawnshop.description') }}
                        </p>
                    </div>
                    <div class="flex justify-center">
                        <img src="https://plus.unsplash.com/premium_photo-1673208585690-fe33159386bd?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Pawnshop Services" class="rounded-xl shadow-lg max-w-full h-auto" loading="lazy">
                    </div>
                </div>

                <!-- SMB Tools -->
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="md:order-2">
                        <h2 class="text-3xl md:text-4xl font-extrabold mb-4 text-[var(--color-electric-sky)]">
                            {{ __('services.sections.smb.title') }}
                        </h2>
                        <p class="text-white/80 text-lg leading-relaxed">
                            {{ __('services.sections.smb.description') }}
                        </p>
                    </div>
                    <div class="flex justify-center md:order-1">
                        <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="SMB Services" class="rounded-xl shadow-lg max-w-full h-auto" loading="lazy">
                    </div>
                </div>

                <!-- Compliance -->
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-extrabold mb-4 text-[var(--color-electric-sky)]">
                            {{ __('services.sections.compliance.title') }}
                        </h2>
                        <p class="text-white/80 text-lg leading-relaxed">
                            {{ __('services.sections.compliance.description') }}
                        </p>
                    </div>
                    <div class="flex justify-center">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=815&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Compliance" class="rounded-xl shadow-lg max-w-full h-auto" loading="lazy">
                    </div>
                </div>

                <!-- Problems We Solve -->
                <div class="bg-white/5 p-10 rounded-2xl shadow-xl border border-white/10">
                    <h2 class="text-3xl md:text-4xl font-bold mb-6 text-center">
                        {{ __('services.sections.problems_heading') }}
                    </h2>
                    <ul class="space-y-4 max-w-3xl mx-auto text-white/90 text-lg list-disc list-inside">
                        @foreach (__('services.sections.problems') as $problem)
                            <li>{{ $problem }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </section>
    </div>
</x-layouts.base>
