<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class HeroSlide extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'highlight',
        'subtitle',
        'button_text',

        // Legacy field (plain URL)
        'button_link',

        // New, route-aware linking
        'link_type',       // 'internal' | 'external' | 'legacy'
        'button_route',    // route name (e.g., 'projects.show')
        'button_params',   // json array of route params
        'button_url',      // external URL (e.g., 'https://example.com')

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
        'media_paths'   => 'array',
        'button_params' => 'array', // new
    ];

    protected $appends = [
        'button_href',
        'image_url',
        'media_urls',
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

    /**
     * Resolve the final button href with precedence:
     * 1) internal route (button_route + button_params)
     * 2) external URL (button_url)
     * 3) legacy (button_link)
     */
    public function getButtonHrefAttribute(): ?string
    {
        $type = $this->link_type ?? null;

        // Internal route
        if ($type === 'internal' && !empty($this->button_route)) {
            try {
                return route($this->button_route, (array) ($this->button_params ?? []));
            } catch (\Throwable $e) {
                // Unknown route or missing params → fall through safely
            }
        }

        // External URL
        if ($type === 'external' && !empty($this->button_url)) {
            return $this->button_url;
        }

        // Legacy plain URL
        if (!empty($this->button_link)) {
            return $this->button_link;
        }

        return null;
    }
}
