<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations; // correct namespace for v6+

class HeroSlide extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'highlight',
        'subtitle',
        'button_text',
        'button_link',
        'image_path',
        'media_paths',
    ];

    /**
     * Translatable JSON attributes handled by Spatie.
     */
    public array $translatable = [
        'title',
        'highlight',
        'subtitle',
        'button_text',
    ];

    /**
     * Casts.
     */
    protected $casts = [
        'media_paths' => 'array',
    ];

    /**
     * Background image URL (left-side) as an absolute URL.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return null;
        }

        // If already absolute, return as-is.
        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }

        // Ensure absolute URL with correct host:port
        return url(Storage::disk('public')->url($this->image_path));
    }

    /**
     * Right-side media image URLs (array) as absolute URLs.
     */
    public function getMediaUrlsAttribute(): array
    {
        $paths = $this->media_paths ?? [];

        return collect($paths)
            ->map(function (?string $path) {
                if (!$path) {
                    return null;
                }

                if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                    return $path;
                }

                return url(Storage::disk('public')->url($path));
            })
            ->filter()
            ->values()
            ->all();
    }
}
