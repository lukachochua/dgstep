<?php

namespace App\Filament\Resources\AboutPageResource\Pages;

use App\Filament\Resources\AboutPageResource;
use App\Models\AboutPage;
use Filament\Resources\Pages\ListRecords;

class ListAboutPages extends ListRecords
{
    protected static string $resource = AboutPageResource::class;

    public function mount(): void
    {
        $record = AboutPage::singleton();

        $this->redirect(AboutPageResource::getUrl('edit', ['record' => $record]));

        return;
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
