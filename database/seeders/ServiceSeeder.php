<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Lang;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // We’ll seed these specific sections in a fixed order for featured slots.
        $sections = [
            'pawnshop' => [
                'featured_order' => 1,
                'display_order'  => 1,
                'cue_style'      => 'bubbles',
                'cue_label'      => ['en' => 'Ops Coverage', 'ka' => 'ოპერაციები'],
                'cue_values'     => [80, 65, 55],
            ],
            'smb' => [
                'featured_order' => 2,
                'display_order'  => 2,
                'cue_style'      => 'bars',
                'cue_label'      => ['en' => 'Workflow Fit', 'ka' => 'ვორქფლოუ'],
                'cue_values'     => [70, 60, 40, 30],
            ],
            'compliance' => [
                'featured_order' => 3,
                'display_order'  => 3,
                'cue_style'      => 'dots',
                'cue_label'      => ['en' => 'Audit Ready', 'ka' => 'აუდიტი'],
                'cue_values'     => [1, 1, 1, 0, 1],
            ],
        ];

        $locales = ['en', 'ka'];

        foreach ($sections as $slug => $config) {
            $name = [];
            $description = [];
            $descriptionExpanded = [];
            $problems = [];

            foreach ($locales as $locale) {
                // Read from language files using the provided structure
                $titleKey       = "services.sections.$slug.title";
                $descriptionKey = "services.sections.$slug.description";
                $descriptionExpandedKey = "services.sections.$slug.description_expanded";
                $problemsKey    = "services.sections.$slug.problems";

                $name[$locale]        = Lang::get($titleKey, [], $locale);
                $description[$locale] = Lang::get($descriptionKey, [], $locale);

                $expandedCopy = Lang::get($descriptionExpandedKey, [], $locale);
                $descriptionExpanded[$locale] = $expandedCopy === $descriptionExpandedKey ? '' : $expandedCopy;

                $problems[$locale] = Lang::get($problemsKey, [], $locale);

                // Ensure arrays come back as arrays even if not defined
                if (!is_array($problems[$locale])) {
                    $problems[$locale] = [];
                }
            }

            // Preserve existing record’s image fields if already set
            $existing = Service::where('slug', $slug)->first();

            Service::updateOrCreate(
                ['slug' => $slug],
                [
                    'name'            => $name,
                    'description'     => $description,
                    'description_expanded' => $descriptionExpanded,
                    'problems'        => $problems,
                    'image_path'      => $existing->image_path ?? "services/{$slug}.jpg",
                    'image_alt'       => $existing->image_alt ?? ($name['en'] ?? ucfirst($slug)),
                    'is_featured'     => true,      // feature all three for the homepage trio
                    'featured_order'  => $config['featured_order'],
                    'display_order'   => $existing->display_order ?? $config['display_order'],
                    'cue_style'       => $existing->cue_style ?? $config['cue_style'],
                    'cue_label'       => $existing->cue_label ?? $config['cue_label'],
                    'cue_values'      => $existing->cue_values ?? $config['cue_values'],
                ]
            );
        }

        // Optionally, un-feature any other services to ensure exactly three are featured.
        Service::whereNotIn('slug', array_keys($sections))
            ->update([
                'is_featured'    => false,
                'featured_order' => 0,
            ]);
    }
}
