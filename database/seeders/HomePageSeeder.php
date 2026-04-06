<?php

namespace Database\Seeders;

use App\Models\HomePage;
use Illuminate\Database\Seeder;

class HomePageSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = HomePage::defaults();

        $page = HomePage::query()->first();

        if ($page) {
            foreach ([
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
            ] as $attribute) {
                $page->setTranslations($attribute, $defaults[$attribute]);
            }
            $page->save();

            return;
        }

        HomePage::query()->create($defaults);
    }
}
