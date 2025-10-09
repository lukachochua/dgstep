<?php

namespace App\Filament\Resources\ServicesPageResource\Pages;

use App\Filament\Resources\ServicesPageResource;
use Filament\Resources\Pages\ListRecords;

class ListServicesPages extends ListRecords
{
    protected static string $resource = ServicesPageResource::class;

    public function mount(): void
    {
        $this->redirect(ServicesPageResource::getUrl('edit'));
    }
}
