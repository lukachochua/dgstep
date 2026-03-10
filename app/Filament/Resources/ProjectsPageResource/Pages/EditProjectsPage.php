<?php

namespace App\Filament\Resources\ProjectsPageResource\Pages;

use App\Filament\Resources\ProjectsPageResource;
use Filament\Resources\Pages\EditRecord;

class EditProjectsPage extends EditRecord
{
    protected static string $resource = ProjectsPageResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }
}
