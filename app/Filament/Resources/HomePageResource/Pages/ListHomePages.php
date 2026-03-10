<?php

namespace App\Filament\Resources\HomePageResource\Pages;

use App\Filament\Resources\HomePageResource;
use App\Models\HomePage;
use Filament\Resources\Pages\ListRecords;

class ListHomePages extends ListRecords
{
    protected static string $resource = HomePageResource::class;

    public function mount(): void
    {
        $record = HomePage::singleton();

        $this->redirect(HomePageResource::getUrl('edit', ['record' => $record]));

        return;
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
