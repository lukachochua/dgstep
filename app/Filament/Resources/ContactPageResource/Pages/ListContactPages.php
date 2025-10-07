<?php

namespace App\Filament\Resources\ContactPageResource\Pages;

use App\Filament\Resources\ContactPageResource;
use App\Models\ContactPage;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactPages extends ListRecords
{
    protected static string $resource = ContactPageResource::class;

    public function mount(): void
    {
        $record = ContactPage::query()->latest('id')->first();

        if ($record) {
            $this->redirect(ContactPageResource::getUrl('edit', ['record' => $record]));

            return;
        }

        $this->redirect(ContactPageResource::getUrl('create'));
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn() => ! ContactPage::query()->exists()),
        ];
    }
}
