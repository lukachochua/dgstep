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
            'pawnshop'   => 1,
            'smb'        => 2,
            'compliance' => 3,
        ];

        $locales = ['en', 'ka'];

        foreach ($sections as $slug => $order) {
            $name = [];
            $description = [];
            $problems = [];

            foreach ($locales as $locale) {
                // Read from language files using the provided structure
                $titleKey       = "services.sections.$slug.title";
                $descriptionKey = "services.sections.$slug.description";
                $problemsKey    = "services.sections.$slug.problems";

                $name[$locale]        = Lang::get($titleKey, [], $locale);
                $description[$locale] = Lang::get($descriptionKey, [], $locale);
                $problems[$locale]    = Lang::get($problemsKey, [], $locale);

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
                    'problems'        => $problems,
                    'image_path'      => $existing->image_path ?? "services/{$slug}.jpg",
                    'image_alt'       => $existing->image_alt ?? ($name['en'] ?? ucfirst($slug)),
                    'is_featured'     => true,      // feature all three for the homepage trio
                    'featured_order'  => $order,    // 1..3 for display order
                ]
            );
        }

        // Optionally, un-feature any other services to ensure exactly three are featured.
        Service::whereNotIn('slug', array_keys($sections))
            ->update(['is_featured' => false, 'featured_order' => 0]);
    }
}
