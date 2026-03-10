<?php

namespace App\Filament\Resources\ProjectsPageResource\Pages;

use App\Filament\Resources\ProjectsPageResource;
use App\Models\ProjectsPage;
use Filament\Resources\Pages\ListRecords;

class ListProjectsPages extends ListRecords
{
    protected static string $resource = ProjectsPageResource::class;

    public function mount(): void
    {
        $record = ProjectsPage::singleton();

        $this->redirect(ProjectsPageResource::getUrl('edit', ['record' => $record]));

        return;
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
