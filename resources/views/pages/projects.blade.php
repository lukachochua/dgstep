<x-layouts.base :title="__('projects.title')">
    <div class="min-h-screen flex flex-col">
        <section
            class="flex-grow bg-gradient-to-r from-[#0b0f1a] via-[#141d2f] to-[#0b0f1a] text-white py-24 select-none font-[FiraGO]">
            <div class="container mx-auto px-4 sm:px-6 md:px-8 space-y-16">

                <!-- Page Header -->
                <div class="text-center max-w-3xl mx-auto space-y-4">
                    <h1 class="text-4xl md:text-5xl font-extrabold drop-shadow-sm text-[var(--color-electric-sky)]">
                        {{ __('projects.heading') }}
                    </h1>
                    <p class="text-lg text-white/80 leading-relaxed">
                        {{ __('projects.subheading') }}
                    </p>
                </div>

                <!-- Project Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                    @foreach (__('projects.cards') as $i => $card)
                        <div
                            class="bg-white/5 p-6 rounded-xl border border-white/10 shadow-md hover:shadow-lg transition space-y-4">
                            <img @if ($i === 0) src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                @elseif($i === 1)
                                    src="https://images.unsplash.com/photo-1560264280-88b68371db39?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                @else
                                    src="https://images.unsplash.com/photo-1620825141088-a824daf6a46b?q=80&w=1032&auto=format&fit=crop" @endif
                                alt="{{ $card['title'] }}" class="rounded-md object-cover w-full h-40" loading="lazy">
                            <h3 class="text-xl font-bold text-[var(--color-electric-sky)] leading-tight">
                                {{ $card['title'] }}
                            </h3>
                            <p class="text-white/80 text-sm leading-relaxed">
                                {{ $card['description'] }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <!-- CTA -->
                <div class="text-center pt-10">
                    <a href="{{ route('contact') }}"
                        class="inline-block mt-6 px-6 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-[var(--color-electric-sky)] transition">
                        {{ __('projects.cta') }}
                    </a>
                </div>

            </div>
        </section>
    </div>
</x-layouts.base>
