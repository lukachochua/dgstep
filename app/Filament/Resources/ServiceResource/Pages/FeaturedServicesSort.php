<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use Filament\Resources\Pages\Page;

class FeaturedServicesSort extends Page
{
    protected static string $resource = ServiceResource::class;

    protected static string $view = 'filament.resources.service-resource.pages.featured-services-sort';
}
