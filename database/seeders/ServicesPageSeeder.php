<?php

namespace Database\Seeders;

use App\Models\ServicesPage;
use Illuminate\Database\Seeder;

class ServicesPageSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = ServicesPage::defaults();

        $page = ServicesPage::query()->first();

        if ($page) {
            foreach ([
                'title',
                'hero_kicker',
                'hero_title',
                'hero_lead',
                'hero_primary_cta',
                'hero_secondary_cta',
                'overview_heading',
                'overview_body',
                'stat_tracks_label',
                'stat_pain_points_label',
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
            ] as $attribute) {
                $page->setTranslations($attribute, $defaults[$attribute]);
            }

            $page->proof_items = $defaults['proof_items'];
            $page->save();

            return;
        }

        ServicesPage::query()->create($defaults);
    }
}
