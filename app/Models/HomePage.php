<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;
use Spatie\Translatable\HasTranslations;

class HomePage extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'hero_kicker',
        'hero_primary_cta',
        'hero_secondary_cta',
        'hero_visual_label',
        'hero_visual_point',
        'hero_slide_label',
        'hero_slide_announcement',
        'hero_image_alt',
        'proof_kicker',
        'proof_title',
        'proof_subtitle',
        'metric_focus_label',
        'metric_focus_value',
        'metric_focus_description',
        'metric_technology_label',
        'metric_technology_value',
        'metric_technology_description',
        'metric_approach_label',
        'metric_approach_value',
        'metric_approach_description',
        'solutions_kicker',
        'solutions_title',
        'solutions_subtitle',
        'solutions_link_label',
        'cta_title',
        'cta_subtitle',
        'cta_primary',
        'cta_secondary',
        'floating_cta_title',
        'floating_cta_primary',
    ];

    public array $translatable = [
        'title',
        'hero_kicker',
        'hero_primary_cta',
        'hero_secondary_cta',
        'hero_visual_label',
        'hero_visual_point',
        'hero_slide_label',
        'hero_slide_announcement',
        'hero_image_alt',
        'proof_kicker',
        'proof_title',
        'proof_subtitle',
        'metric_focus_label',
        'metric_focus_value',
        'metric_focus_description',
        'metric_technology_label',
        'metric_technology_value',
        'metric_technology_description',
        'metric_approach_label',
        'metric_approach_value',
        'metric_approach_description',
        'solutions_kicker',
        'solutions_title',
        'solutions_subtitle',
        'solutions_link_label',
        'cta_title',
        'cta_subtitle',
        'cta_primary',
        'cta_secondary',
        'floating_cta_title',
        'floating_cta_primary',
    ];

    public static function defaults(): array
    {
        return [
            'title' => [
                'en' => Lang::get('messages.homepage_title', [], 'en'),
                'ka' => Lang::get('messages.homepage_title', [], 'ka'),
            ],
            'hero_kicker' => [
                'en' => Lang::get('messages.hero.kicker', [], 'en'),
                'ka' => Lang::get('messages.hero.kicker', [], 'ka'),
            ],
            'hero_primary_cta' => [
                'en' => Lang::get('messages.hero.primary_cta', [], 'en'),
                'ka' => Lang::get('messages.hero.primary_cta', [], 'ka'),
            ],
            'hero_secondary_cta' => [
                'en' => Lang::get('messages.hero.secondary_cta', [], 'en'),
                'ka' => Lang::get('messages.hero.secondary_cta', [], 'ka'),
            ],
            'hero_visual_label' => [
                'en' => Lang::get('messages.hero.visual_card_kicker', [], 'en'),
                'ka' => Lang::get('messages.hero.visual_card_kicker', [], 'ka'),
            ],
            'hero_visual_point' => [
                'en' => Lang::get('messages.hero.visual_points.0.value', [], 'en'),
                'ka' => Lang::get('messages.hero.visual_points.0.value', [], 'ka'),
            ],
            'hero_slide_label' => [
                'en' => Lang::get('messages.hero.slide_label', [], 'en'),
                'ka' => Lang::get('messages.hero.slide_label', [], 'ka'),
            ],
            'hero_slide_announcement' => [
                'en' => Lang::get('messages.hero.slide_announcement', [], 'en'),
                'ka' => Lang::get('messages.hero.slide_announcement', [], 'ka'),
            ],
            'hero_image_alt' => [
                'en' => Lang::get('messages.hero.image_alt', [], 'en'),
                'ka' => Lang::get('messages.hero.image_alt', [], 'ka'),
            ],
            'proof_kicker' => [
                'en' => Lang::get('messages.home_proof.kicker', [], 'en'),
                'ka' => Lang::get('messages.home_proof.kicker', [], 'ka'),
            ],
            'proof_title' => [
                'en' => Lang::get('messages.home_proof.title', [], 'en'),
                'ka' => Lang::get('messages.home_proof.title', [], 'ka'),
            ],
            'proof_subtitle' => [
                'en' => Lang::get('messages.home_proof.subtitle', [], 'en'),
                'ka' => Lang::get('messages.home_proof.subtitle', [], 'ka'),
            ],
            'metric_focus_label' => [
                'en' => Lang::get('messages.home_metrics.focus.label', [], 'en'),
                'ka' => Lang::get('messages.home_metrics.focus.label', [], 'ka'),
            ],
            'metric_focus_value' => [
                'en' => Lang::get('messages.home_metrics.focus.value', [], 'en'),
                'ka' => Lang::get('messages.home_metrics.focus.value', [], 'ka'),
            ],
            'metric_focus_description' => [
                'en' => Lang::get('messages.home_metrics.focus.description', [], 'en'),
                'ka' => Lang::get('messages.home_metrics.focus.description', [], 'ka'),
            ],
            'metric_technology_label' => [
                'en' => Lang::get('messages.home_metrics.technology.label', [], 'en'),
                'ka' => Lang::get('messages.home_metrics.technology.label', [], 'ka'),
            ],
            'metric_technology_value' => [
                'en' => Lang::get('messages.home_metrics.technology.value', [], 'en'),
                'ka' => Lang::get('messages.home_metrics.technology.value', [], 'ka'),
            ],
            'metric_technology_description' => [
                'en' => Lang::get('messages.home_metrics.technology.description', [], 'en'),
                'ka' => Lang::get('messages.home_metrics.technology.description', [], 'ka'),
            ],
            'metric_approach_label' => [
                'en' => Lang::get('messages.home_metrics.approach.label', [], 'en'),
                'ka' => Lang::get('messages.home_metrics.approach.label', [], 'ka'),
            ],
            'metric_approach_value' => [
                'en' => Lang::get('messages.home_metrics.approach.value', [], 'en'),
                'ka' => Lang::get('messages.home_metrics.approach.value', [], 'ka'),
            ],
            'metric_approach_description' => [
                'en' => Lang::get('messages.home_metrics.approach.description', [], 'en'),
                'ka' => Lang::get('messages.home_metrics.approach.description', [], 'ka'),
            ],
            'solutions_kicker' => [
                'en' => Lang::get('messages.home_solutions.kicker', [], 'en'),
                'ka' => Lang::get('messages.home_solutions.kicker', [], 'ka'),
            ],
            'solutions_title' => [
                'en' => Lang::get('messages.home_solutions.title', [], 'en'),
                'ka' => Lang::get('messages.home_solutions.title', [], 'ka'),
            ],
            'solutions_subtitle' => [
                'en' => Lang::get('messages.home_solutions.subtitle', [], 'en'),
                'ka' => Lang::get('messages.home_solutions.subtitle', [], 'ka'),
            ],
            'solutions_link_label' => [
                'en' => Lang::get('services.read_more', [], 'en'),
                'ka' => Lang::get('services.read_more', [], 'ka'),
            ],
            'cta_title' => [
                'en' => Lang::get('messages.home_cta.title', [], 'en'),
                'ka' => Lang::get('messages.home_cta.title', [], 'ka'),
            ],
            'cta_subtitle' => [
                'en' => Lang::get('messages.home_cta.subtitle', [], 'en'),
                'ka' => Lang::get('messages.home_cta.subtitle', [], 'ka'),
            ],
            'cta_primary' => [
                'en' => Lang::get('messages.home_cta.primary', [], 'en'),
                'ka' => Lang::get('messages.home_cta.primary', [], 'ka'),
            ],
            'cta_secondary' => [
                'en' => Lang::get('messages.home_cta.secondary', [], 'en'),
                'ka' => Lang::get('messages.home_cta.secondary', [], 'ka'),
            ],
            'floating_cta_title' => [
                'en' => Lang::get('messages.floating_cta.title', [], 'en'),
                'ka' => Lang::get('messages.floating_cta.title', [], 'ka'),
            ],
            'floating_cta_primary' => [
                'en' => Lang::get('messages.floating_cta.primary', [], 'en'),
                'ka' => Lang::get('messages.floating_cta.primary', [], 'ka'),
            ],
        ];
    }

    public static function singleton(): self
    {
        return static::query()->first() ?? static::create(static::defaults());
    }
}
