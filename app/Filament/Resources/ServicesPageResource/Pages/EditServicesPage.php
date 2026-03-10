<?php

namespace App\Filament\Resources\ServicesPageResource\Pages;

use App\Filament\Resources\ServicesPageResource;
use Filament\Resources\Pages\EditRecord;

class EditServicesPage extends EditRecord
{
    protected static string $resource = ServicesPageResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $locales = array_keys(ServicesPageResource::getLocales());

        $data['proof_items'] = collect($data['proof_items'] ?? [])
            ->mapWithKeys(function ($items, $locale) {
                return [
                    $locale => collect($items)
                        ->map(fn ($item) => is_array($item) ? ($item['value'] ?? null) : $item)
                        ->filter()
                        ->values()
                        ->all(),
                ];
            })
            ->all();

        foreach ($locales as $locale) {
            $data['proof_items'][$locale] = $data['proof_items'][$locale] ?? [];
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }
}
