@php use Illuminate\Support\Str; @endphp

<x-filament-widgets::widget>
    <div class="grid gap-6 lg:grid-cols-2 xl:gap-8">
        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide dark:text-gray-400">Hero slides</h3>

            <ul class="divide-y divide-gray-200 overflow-hidden rounded-xl border border-gray-200 dark:divide-gray-700 dark:border-gray-700">
                @forelse ($heroSlides as $slide)
                    <li class="bg-white px-4 py-3 text-sm leading-6 dark:bg-gray-800">
                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $slide['title'] ?? '—' }}</p>
                        @if (!empty($slide['highlight']))
                            <p class="text-gray-500 dark:text-gray-400">{{ $slide['highlight'] }}</p>
                        @endif
                        @if (!empty($slide['route']))
                            <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Linked to: {{ $slide['route'] }}</p>
                        @endif
                    </li>
                @empty
                    <li class="bg-white px-4 py-3 text-sm text-gray-500 dark:bg-gray-800 dark:text-gray-400">No hero slides yet.</li>
                @endforelse
            </ul>
        </div>

        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide dark:text-gray-400">Services</h3>

            <ul class="divide-y divide-gray-200 overflow-hidden rounded-xl border border-gray-200 dark:divide-gray-700 dark:border-gray-700">
                @forelse ($services as $service)
                    <li class="bg-white px-4 py-3 text-sm leading-6 dark:bg-gray-800">
                        <p class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $service['name'] ?? '—' }}
                            @if ($service['is_featured'])
                                <span class="ml-2 inline-flex items-center rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-800 dark:bg-amber-500/20 dark:text-amber-300">Featured</span>
                            @endif
                        </p>
                        @if (!empty($service['description']))
                            <p class="text-gray-500 dark:text-gray-400">{{ Str::limit($service['description'], 120) }}</p>
                        @endif
                    </li>
                @empty
                    <li class="bg-white px-4 py-3 text-sm text-gray-500 dark:bg-gray-800 dark:text-gray-400">No services yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-filament-widgets::widget>
