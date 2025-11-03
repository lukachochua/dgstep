<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;


class Service extends Model
{
    protected $fillable = [
        'name', 'description', 'description_expanded', 'problems', 'slug',
        'image_path', 'featured_image_path', 'image_alt', 'is_featured', 'featured_order',
        'display_order', 'cue_style', 'cue_label', 'cue_values',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'description_expanded' => 'array',
        'problems' => 'array',
        'is_featured' => 'bool',
        'cue_label' => 'array',
        'cue_values' => 'array',
    ];

    public function getDisplayNameAttribute(): string
    {
        $locale = App::getLocale();
        return $this->name[$locale] ?? $this->name['en'] ?? '';
    }

    public function scopeFeatured($q)
    {
        return $q->where('is_featured', true)->orderBy('featured_order')->limit(3);
    }

    public function scopeOrdered($q)
    {
        return $q->orderBy('display_order')->orderBy('id');
    }

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

    public function getFeaturedImageUrlAttribute(): ?string
    {
        if (! $this->featured_image_path) {
            return $this->image_url;
        }

        if (str_starts_with($this->featured_image_path, 'http://') || str_starts_with($this->featured_image_path, 'https://')) {
            return $this->featured_image_path;
        }

        return url(Storage::disk('public')->url($this->featured_image_path));
    }
}
