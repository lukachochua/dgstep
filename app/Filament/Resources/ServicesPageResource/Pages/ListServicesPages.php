<?php

namespace App\Filament\Resources\ServicesPageResource\Pages;

use App\Filament\Resources\ServicesPageResource;
use App\Models\ServicesPage;
use Filament\Resources\Pages\ListRecords;

class ListServicesPages extends ListRecords
{
    protected static string $resource = ServicesPageResource::class;

    public function mount(): void
    {
        $record = ServicesPage::singleton();

        $this->redirect(ServicesPageResource::getUrl('edit', ['record' => $record]));

        return;
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
