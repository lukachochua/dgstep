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
        'button_link',
        'link_type',
        'button_route',
        'button_params',
        'button_url',
        'image_path',
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

    protected $casts = [
        'button_params'           => 'array',
    ];

    protected $appends = [
        'button_href',
        'image_url',
    ];

    protected static function booted(): void
    {
        static::saving(function (HeroSlide $slide): void {
            if (!$slide->link_type) {
                $slide->link_type = 'internal';
            }

            if ($slide->link_type === 'internal' && !$slide->button_route) {
                $slide->button_route = 'contact';
            }

            if ($slide->button_params === null) {
                $slide->button_params = [];
            }
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

        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }

        return url(Storage::disk('public')->url($this->image_path));
    }

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
