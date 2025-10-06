<?php

namespace App\Filament\Resources\AboutPageResource\Pages;

use App\Filament\Resources\AboutPageResource;
use Filament\Resources\Pages\EditRecord;

class EditAboutPage extends EditRecord
{
    protected static string $resource = AboutPageResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $locales = array_keys(AboutPageResource::getLocales());

        $data['badges'] = collect($data['badges'] ?? [])
            ->mapWithKeys(fn ($badges, $locale) => [
                $locale => collect($badges)->filter()->values()->all(),
            ])
            ->all();

        foreach ($locales as $locale) {
            $data['badges'][$locale] = $data['badges'][$locale] ?? [];
        }

        $data['management_members'] = collect($data['management_members'] ?? [])
            ->map(function (array $member) use ($locales) {
                $member['name'] = collect($member['name'] ?? [])
                    ->only($locales)
                    ->filter()
                    ->all();

                $member['role'] = collect($member['role'] ?? [])
                    ->only($locales)
                    ->filter()
                    ->all();

                $member['image_url'] = blank($member['image_url'] ?? null)
                    ? null
                    : $member['image_url'];

                return $member;
            })
            ->filter(fn (array $member) =>
                filled($member['image_url'])
                || ! empty($member['name'])
                || ! empty($member['role'])
            )
            ->values()
            ->all();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }
}
