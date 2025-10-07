<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\FeaturedServicesStats;
use App\Filament\Widgets\FeaturedServicesWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    /**
     * Widgets displayed on the Filament dashboard.
     */
    public function getWidgets(): array
    {
        return [
            FeaturedServicesStats::class,
            FeaturedServicesWidget::class,
        ];
    }

    /**
     * Responsive column layout for dashboard widgets.
     */
    public function getColumns(): int|array
    {
        return [
            'md' => 1,
            'xl' => 2,
        ];
    }
}
