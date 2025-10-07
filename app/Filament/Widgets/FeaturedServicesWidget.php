<?php

namespace App\Filament\Widgets;

use App\Models\HeroSlide;
use App\Models\Service;
use Filament\Widgets\Widget;

class FeaturedServicesWidget extends Widget
{
    protected static string $view = 'filament.widgets.featured-services-widget';

    /**
     * Span the widget across both dashboard columns on wide screens so the
     * inner lists have room to sit side-by-side.
     */
    protected int | string | array $columnSpan = [
        'default' => 1,
        'xl' => 2,
    ];

    protected function getViewData(): array
    {
        $locale = app()->getLocale();

        $heroSlides = HeroSlide::query()
            ->latest()
            ->take(5)
            ->get()
            ->map(function (HeroSlide $slide) use ($locale) {
                return [
                    'title' => $slide->getTranslation('title', $locale) ?? $slide->getTranslation('title', 'en'),
                    'highlight' => $slide->getTranslation('highlight', $locale) ?? $slide->getTranslation('highlight', 'en'),
                    'route' => $slide->button_href,
                ];
            })
            ->toArray();

        $services = Service::query()
            ->orderByDesc('is_featured')
            ->orderBy('featured_order')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function (Service $service) use ($locale) {
                $names = $service->name ?? [];
                $descriptions = $service->description ?? [];

                return [
                    'name' => $names[$locale] ?? $names['en'] ?? null,
                    'description' => $descriptions[$locale] ?? $descriptions['en'] ?? null,
                    'is_featured' => (bool) $service->is_featured,
                ];
            })
            ->toArray();

        return compact('heroSlides', 'services');
    }
}
