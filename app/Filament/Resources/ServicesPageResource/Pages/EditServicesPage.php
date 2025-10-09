<?php

namespace App\Filament\Resources\ServicesPageResource\Pages;

use App\Filament\Resources\ServicesPageResource;
use App\Models\ServicesPage;
use Filament\Resources\Pages\EditRecord;

class EditServicesPage extends EditRecord
{
    protected static string $resource = ServicesPageResource::class;

    /**
     * Filament will pass {record} from the route. We ignore it and always
     * return the singleton record so the page is truly singleton.
     */
    protected function resolveRecord($key): ServicesPage
    {
        return ServicesPage::singleton();
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
