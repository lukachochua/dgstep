<?php

namespace App\Http\Controllers\Concerns;

trait ResolvesLocalizedContent
{
    protected function localizedText(array|string|null $value, string $locale): string
    {
        if (is_array($value)) {
            return (string) ($value[$locale] ?? $value['en'] ?? '');
        }

        return trim((string) ($value ?? ''));
    }

    protected function localizedList(mixed $value, string $locale): array
    {
        if (! is_array($value)) {
            return [];
        }

        $items = $value[$locale] ?? $value['en'] ?? [];

        if (! is_array($items)) {
            return [];
        }

        return collect($items)
            ->filter(fn ($item) => filled($item))
            ->map(fn ($item) => trim((string) $item))
            ->values()
            ->all();
    }

    protected function localizedPoints(mixed $value, string $locale): array
    {
        if (! is_array($value)) {
            return [];
        }

        $items = $value[$locale] ?? $value['en'] ?? [];

        if (! is_array($items)) {
            return [];
        }

        return collect($items)
            ->map(function ($item) {
                if (! is_array($item)) {
                    return null;
                }

                $label = trim((string) ($item['label'] ?? ''));
                $copy = trim((string) ($item['value'] ?? ''));

                if ($label === '' && $copy === '') {
                    return null;
                }

                return [
                    'label' => $label,
                    'value' => $copy,
                ];
            })
            ->filter()
            ->values()
            ->all();
    }
}
