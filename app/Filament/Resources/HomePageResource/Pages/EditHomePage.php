<?php

namespace App\Filament\Resources\HomePageResource\Pages;

use App\Filament\Resources\HomePageResource;
use Filament\Resources\Pages\EditRecord;

class EditHomePage extends EditRecord
{
    protected static string $resource = HomePageResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $locales = array_keys(HomePageResource::getLocales());

        $data['hero_audiences'] = collect($data['hero_audiences'] ?? [])
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

        $data['hero_visual_points'] = collect($data['hero_visual_points'] ?? [])
            ->mapWithKeys(function ($items, $locale) {
                return [
                    $locale => collect($items)
                        ->map(function ($item) {
                            if (! is_array($item)) {
                                return null;
                            }

                            $label = trim((string) ($item['label'] ?? ''));
                            $value = trim((string) ($item['value'] ?? ''));

                            if ($label === '' && $value === '') {
                                return null;
                            }

                            return [
                                'label' => $label,
                                'value' => $value,
                            ];
                        })
                        ->filter()
                        ->values()
                        ->all(),
                ];
            })
            ->all();

        foreach ($locales as $locale) {
            $data['hero_audiences'][$locale] = $data['hero_audiences'][$locale] ?? [];
            $data['hero_visual_points'][$locale] = $data['hero_visual_points'][$locale] ?? [];
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }
}
