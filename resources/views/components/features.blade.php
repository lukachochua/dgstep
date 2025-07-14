<section id="features" class="bg-white dark:bg-gray-950 py-16 select-none">
    <div class="container mx-auto px-4 sm:px-6 md:px-8">

        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800 dark:text-white drop-shadow-sm tracking-tight">
                {{ __('messages.features.heading') }}
            </h2>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                {{ __('messages.features.subheading') }}
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-12 text-center">
            @foreach (trans('messages.features.cards') as $card)
                <div class="space-y-4">
                    <h3 class="text-xl font-bold text-[var(--color-electric-sky)]">
                        {{ $card['title'] }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 text-base max-w-sm mx-auto">
                        {{ $card['description'] }}
                    </p>
                </div>
            @endforeach
        </div>

    </div>
</section>
