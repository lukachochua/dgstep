<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use Filament\Resources\Pages\EditRecord;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $locales = ['en' => 'English', 'ka' => 'ქართული'];

        $data = ServiceResource::normalizeProblems($data, $locales);
        $data['image_alt'] = $data['image_alt'] ?? ($data['name']['en'] ?? ($data['slug'] ?? 'Service'));

        return $data;
    }
}
