<?php

namespace App\Filament\Widgets;

use App\Models\HeroSlide;
use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FeaturedServicesStats extends BaseWidget
{
    protected function getStats(): array
    {
        $locale = app()->getLocale();

        $heroSlides = HeroSlide::query()->get();
        $heroSlideExamples = $heroSlides
            ->map(fn (HeroSlide $slide) => $slide->getTranslation('title', $locale) ?? $slide->getTranslation('title', 'en'))
            ->filter()
            ->take(3)
            ->implode(', ');

        $services = Service::query()->get();
        $serviceExamples = $services
            ->map(function (Service $service) use ($locale) {
                $names = $service->name ?? [];

                return $names[$locale] ?? $names['en'] ?? null;
            })
            ->filter()
            ->take(3)
            ->implode(', ');

        $featuredServicesCount = $services->where('is_featured', true)->count();

        return [
            Stat::make('Hero slides', (string) $heroSlides->count())
                ->description($heroSlides->isEmpty() ? 'No hero slides yet' : "e.g. {$heroSlideExamples}")
                ->icon('heroicon-o-photo'),

            Stat::make('Services', (string) $services->count())
                ->description($services->isEmpty() ? 'No services defined' : "e.g. {$serviceExamples}")
                ->icon('heroicon-o-briefcase'),

            Stat::make('Featured services', (string) $featuredServicesCount)
                ->description($featuredServicesCount === 0 ? 'Highlight services to feature them on the site' : 'Currently shown on the homepage')
                ->icon('heroicon-o-star'),
        ];
    }
}
