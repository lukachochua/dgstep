<?php

namespace Database\Seeders;

use App\Models\ProjectsPage;
use Illuminate\Database\Seeder;

class ProjectsPageSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = ProjectsPage::defaults();

        $page = ProjectsPage::query()->first();

        if ($page) {
            foreach ([
                'title',
                'hero_kicker',
                'hero_title',
                'hero_lead',
                'proof_heading',
                'proof_body',
                'cta_heading',
                'cta_description',
                'cta_label',
            ] as $attribute) {
                $page->setTranslations($attribute, $defaults[$attribute]);
            }

            $page->proof_items = $defaults['proof_items'];
            $page->project_cards = $defaults['project_cards'];
            $page->save();

            return;
        }

        ProjectsPage::query()->create($defaults);
    }
}
