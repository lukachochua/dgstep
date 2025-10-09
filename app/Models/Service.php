<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;


class Service extends Model
{
    protected $fillable = [
        'name', 'description', 'problems', 'slug',
        'image_path', 'image_alt', 'is_featured', 'featured_order',
        'display_order', 'cue_style', 'cue_label', 'cue_values',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
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
}
