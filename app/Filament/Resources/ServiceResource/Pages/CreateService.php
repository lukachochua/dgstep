<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $locales = ['en' => 'English', 'ka' => 'ქართული'];

        $data = ServiceResource::normalizeProblems($data, $locales);
        $data = ServiceResource::normalizeCueValues($data);
        $data['image_alt'] = $data['image_alt'] ?? ($data['name']['en'] ?? ($data['slug'] ?? 'Service'));

        return $data;
    }
}
