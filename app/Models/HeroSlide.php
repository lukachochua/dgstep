<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
        'image_path',
    ];

    public array $translatable = [
        'title',
        'highlight',
        'subtitle',
        'button_text',
    ];
}
