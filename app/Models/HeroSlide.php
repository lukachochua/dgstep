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
        'secondary_button_text',

        // Legacy field (plain URL)
        'button_link',
        'secondary_button_link',

        // New, route-aware linking
        'link_type',       // 'internal' | 'external' | 'legacy'
        'button_route',    // route name (e.g., 'projects.show')
        'button_params',   // json array of route params
        'button_url',      // external URL (e.g., 'https://example.com')
        'secondary_link_type',
        'secondary_button_route',
        'secondary_button_params',
        'secondary_button_url',

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
        'secondary_button_text',
    ];

    /**
     * Casts.
     */
    protected $casts = [
        'media_paths'   => 'array',
        'button_params' => 'array', // new
        'secondary_button_params' => 'array',
    ];

    protected $appends = [
        'button_href',
        'secondary_button_href',
        'image_url',
        'media_urls',
    ];

    protected static function booted(): void
    {
        static::saving(function (HeroSlide $slide): void {
            // Primary CTA should always lead to the Contact page when persisted.
            $slide->link_type = 'internal';
            $slide->button_route = 'contact';
            $slide->button_params = [];
        });
    }
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
        return $this->resolveButtonHref(
            $this->link_type,
            $this->button_route,
            $this->button_params,
            $this->button_url,
            $this->button_link,
        );
    }

    public function getSecondaryButtonHrefAttribute(): ?string
    {
        return $this->resolveButtonHref(
            $this->secondary_link_type,
            $this->secondary_button_route,
            $this->secondary_button_params,
            $this->secondary_button_url,
            $this->secondary_button_link,
        );
    }

    protected function resolveButtonHref(?string $type, ?string $routeName, $params, ?string $url, ?string $legacy): ?string
    {
        $type = $type ?: null;

        if ($type === 'internal' && !empty($routeName)) {
            try {
                return route($routeName, (array) ($params ?? []));
            } catch (\Throwable $e) {
                // Ignore and fall through to other options when route fails
            }
        }

        if ($type === 'external' && !empty($url)) {
            return $url;
        }

        if (!empty($legacy)) {
            return $legacy;
        }

        return null;
    }
}
