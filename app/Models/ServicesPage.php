<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicesPage extends Model
{
    protected $fillable = ['title', 'sections'];

    protected $casts = [
        'title'    => 'array',
        'sections' => 'array',
    ];

    /** Always have one record to edit via Filament. */
    public static function singleton(): self
    {
        return static::query()->firstOrCreate([], static::defaults());
    }

    /** Initial content (pulls from lang files if present). */
    public static function defaults(): array
    {
        return [
            'title' => [
                'en' => __('services.title'),
                'ka' => trans('services.title', [], 'ka'),
            ],
            'sections' => [
                [
                    'key'         => 'pawnshop',
                    'title'       => [
                        'en' => __('services.sections.pawnshop.title'),
                        'ka' => trans('services.sections.pawnshop.title', [], 'ka'),
                    ],
                    'description' => [
                        'en' => __('services.sections.pawnshop.description'),
                        'ka' => trans('services.sections.pawnshop.description', [], 'ka'),
                    ],
                    'cue_style'   => 'bubbles',   // bubbles | bars | dots
                    'cue_label'   => ['en' => 'Ops Coverage', 'ka' => 'ოპერაციები'],
                    'cue_values'  => [80, 65, 55],
                ],
                [
                    'key'         => 'smb',
                    'title'       => [
                        'en' => __('services.sections.smb.title'),
                        'ka' => trans('services.sections.smb.title', [], 'ka'),
                    ],
                    'description' => [
                        'en' => __('services.sections.smb.description'),
                        'ka' => trans('services.sections.smb.description', [], 'ka'),
                    ],
                    'cue_style'   => 'bars',
                    'cue_label'   => ['en' => 'Workflow Fit', 'ka' => 'ვორქფლოუ'],
                    'cue_values'  => [70, 60, 40, 30],
                ],
                [
                    'key'         => 'compliance',
                    'title'       => [
                        'en' => __('services.sections.compliance.title'),
                        'ka' => trans('services.sections.compliance.title', [], 'ka'),
                    ],
                    'description' => [
                        'en' => __('services.sections.compliance.description'),
                        'ka' => trans('services.sections.compliance.description', [], 'ka'),
                    ],
                    'cue_style'   => 'dots',
                    'cue_label'   => ['en' => 'Audit Ready', 'ka' => 'აუდიტი'],
                    'cue_values'  => [1, 1, 1, 0, 1],
                ],
            ],
        ];
    }

    /**
     * Helper to get translated values by path.
     * Examples: 'title', 'sections.0.title', etc.
     */
    public function translated(string $path, string $locale, ?array $fallback = null): ?string
    {
        $value = data_get($this->toArray(), $path);
        if (is_array($value)) {
            return $value[$locale] ?? $value['en'] ?? null;
        }
        return $value ?? data_get($fallback, $path);
    }
}
