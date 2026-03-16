<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;
use Spatie\Translatable\HasTranslations;

class ServicesPage extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'hero_kicker',
        'hero_title',
        'hero_lead',
        'hero_primary_cta',
        'hero_secondary_cta',
        'overview_heading',
        'overview_body',
        'proof_heading',
        'proof_body',
        'proof_items',
        'cta_kicker',
        'cta_heading',
        'cta_body',
        'cta_primary',
        'cta_secondary',
        'card_problems_heading',
        'card_cta',
        'card_back_to_top',
        'read_more_label',
        'show_less_label',
    ];

    protected $casts = [
        'proof_items' => 'array',
    ];

    public array $translatable = [
        'title',
        'hero_kicker',
        'hero_title',
        'hero_lead',
        'hero_primary_cta',
        'hero_secondary_cta',
        'overview_heading',
        'overview_body',
        'proof_heading',
        'proof_body',
        'cta_kicker',
        'cta_heading',
        'cta_body',
        'cta_primary',
        'cta_secondary',
        'card_problems_heading',
        'card_cta',
        'card_back_to_top',
        'read_more_label',
        'show_less_label',
    ];

    public static function defaults(): array
    {
        return [
            'title' => [
                'en' => Lang::get('services.title', [], 'en'),
                'ka' => Lang::get('services.title', [], 'ka'),
            ],
            'hero_kicker' => [
                'en' => Lang::get('messages.services', [], 'en'),
                'ka' => Lang::get('messages.services', [], 'ka'),
            ],
            'hero_title' => [
                'en' => Lang::get('services.hero.title', [], 'en'),
                'ka' => Lang::get('services.hero.title', [], 'ka'),
            ],
            'hero_lead' => [
                'en' => Lang::get('services.hero.lead', [], 'en'),
                'ka' => Lang::get('services.hero.lead', [], 'ka'),
            ],
            'hero_primary_cta' => [
                'en' => Lang::get('services.hero.primary_cta', [], 'en'),
                'ka' => Lang::get('services.hero.primary_cta', [], 'ka'),
            ],
            'hero_secondary_cta' => [
                'en' => Lang::get('services.hero.secondary_cta', [], 'en'),
                'ka' => Lang::get('services.hero.secondary_cta', [], 'ka'),
            ],
            'overview_heading' => [
                'en' => Lang::get('services.hero.overview_heading', [], 'en'),
                'ka' => Lang::get('services.hero.overview_heading', [], 'ka'),
            ],
            'overview_body' => [
                'en' => Lang::get('services.hero.overview_body', [], 'en'),
                'ka' => Lang::get('services.hero.overview_body', [], 'ka'),
            ],
            'proof_heading' => [
                'en' => Lang::get('services.hero.proof_heading', [], 'en'),
                'ka' => Lang::get('services.hero.proof_heading', [], 'ka'),
            ],
            'proof_body' => [
                'en' => Lang::get('services.hero.proof_body', [], 'en'),
                'ka' => Lang::get('services.hero.proof_body', [], 'ka'),
            ],
            'proof_items' => [
                'en' => Lang::get('services.sections.problems', [], 'en'),
                'ka' => Lang::get('services.sections.problems', [], 'ka'),
            ],
            'cta_kicker' => [
                'en' => Lang::get('services.cta.kicker', [], 'en'),
                'ka' => Lang::get('services.cta.kicker', [], 'ka'),
            ],
            'cta_heading' => [
                'en' => Lang::get('services.cta.heading', [], 'en'),
                'ka' => Lang::get('services.cta.heading', [], 'ka'),
            ],
            'cta_body' => [
                'en' => Lang::get('services.cta.body', [], 'en'),
                'ka' => Lang::get('services.cta.body', [], 'ka'),
            ],
            'cta_primary' => [
                'en' => Lang::get('services.cta.primary', [], 'en'),
                'ka' => Lang::get('services.cta.primary', [], 'ka'),
            ],
            'cta_secondary' => [
                'en' => Lang::get('services.cta.secondary', [], 'en'),
                'ka' => Lang::get('services.cta.secondary', [], 'ka'),
            ],
            'card_problems_heading' => [
                'en' => Lang::get('services.card.problems_heading', [], 'en'),
                'ka' => Lang::get('services.card.problems_heading', [], 'ka'),
            ],
            'card_cta' => [
                'en' => Lang::get('services.card.cta', [], 'en'),
                'ka' => Lang::get('services.card.cta', [], 'ka'),
            ],
            'card_back_to_top' => [
                'en' => Lang::get('services.card.back_to_top', [], 'en'),
                'ka' => Lang::get('services.card.back_to_top', [], 'ka'),
            ],
            'read_more_label' => [
                'en' => Lang::get('services.read_more', [], 'en'),
                'ka' => Lang::get('services.read_more', [], 'ka'),
            ],
            'show_less_label' => [
                'en' => Lang::get('services.show_less', [], 'en'),
                'ka' => Lang::get('services.show_less', [], 'ka'),
            ],
        ];
    }

    public static function singleton(): self
    {
        return static::query()->first() ?? static::create(static::defaults());
    }
}
