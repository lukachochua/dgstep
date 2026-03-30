<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

class ServiceSeeder extends Seeder
{
    private const DEFAULT_SERVICE_IMAGE_PATH = 'services/compliance.jpg';

    public function run(): void
    {
        foreach ([
            'pawnshop' => 'wms',
            'smb' => 'task-manager',
            'compliance' => 'crm',
        ] as $legacySlug => $newSlug) {
            Service::where('slug', $legacySlug)->update(['slug' => $newSlug]);
        }

        // We’ll seed these specific sections in a fixed order for featured slots.
        $sections = [
            'wms' => [
                'lang_key'        => 'wms',
                'featured_order' => 1,
                'display_order'  => 1,
                'cue_style'      => 'bubbles',
                'cue_label'      => ['en' => 'Warehouse Ops', 'ka' => 'საწყობი'],
                'cue_values'     => [80, 65, 55],
                'image_path'     => 'services/pawnshop.png',
            ],
            'task-manager' => [
                'lang_key'        => 'task_manager',
                'featured_order' => 2,
                'display_order'  => 2,
                'cue_style'      => 'bars',
                'cue_label'      => ['en' => 'Workflow', 'ka' => 'ვორქფლოუ'],
                'cue_values'     => [70, 60, 40, 30],
                'image_path'     => 'services/smb.png',
            ],
            'crm' => [
                'lang_key'        => 'crm',
                'featured_order' => 3,
                'display_order'  => 3,
                'cue_style'      => 'dots',
                'cue_label'      => ['en' => 'Customer Flow', 'ka' => 'კლიენტები'],
                'cue_values'     => [1, 1, 1, 0, 1],
                'image_path'     => 'services/compliance.jpg',
            ],
            'hr' => [
                'lang_key'        => 'hr',
                'featured_order' => 0,
                'display_order'  => 4,
                'cue_style'      => 'dots',
                'cue_label'      => ['en' => 'People Ops', 'ka' => 'გუნდი'],
                'cue_values'     => [1, 1, 1, 1],
                'image_path'     => null,
            ],
        ];

        $locales = ['en', 'ka'];

        foreach ($sections as $slug => $config) {
            $name = [];
            $description = [];
            $descriptionExpanded = [];
            $problems = [];
            $langKey = $config['lang_key'] ?? $slug;
            $seededImagePath = $config['image_path'] ?? $this->resolveSeededServiceImagePath($slug);

            foreach ($locales as $locale) {
                // Read from language files using the provided structure
                $titleKey       = "services.sections.$langKey.title";
                $descriptionKey = "services.sections.$langKey.description";
                $descriptionExpandedKey = "services.sections.$langKey.description_expanded";
                $problemsKey    = "services.sections.$langKey.problems";

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

            // Preserve existing non-image fields when already set.
            $existing = Service::where('slug', $slug)->first();

            Service::updateOrCreate(
                ['slug' => $slug],
                [
                    'name'            => $name,
                    'description'     => $description,
                    'description_expanded' => $descriptionExpanded,
                    'problems'        => $problems,
                    'image_path'      => $existing?->image_path ?? $seededImagePath ?? self::DEFAULT_SERVICE_IMAGE_PATH,
                    'image_alt'       => $existing?->image_alt ?? ($name['en'] ?? ucfirst($slug)),
                    'is_featured'     => $config['featured_order'] > 0,
                    'featured_order'  => $config['featured_order'],
                    'display_order'   => $existing?->display_order ?? $config['display_order'],
                    'cue_style'       => $existing?->cue_style ?? $config['cue_style'],
                    'cue_label'       => $existing?->cue_label ?? $config['cue_label'],
                    'cue_values'      => $existing?->cue_values ?? $config['cue_values'],
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

    private function resolveSeededServiceImagePath(string $slug): ?string
    {
        foreach (['jpg', 'jpeg', 'png', 'webp', 'bmp'] as $extension) {
            $relativePath = "services/{$slug}.{$extension}";

            if (Storage::disk('public')->exists($relativePath)) {
                return $relativePath;
            }
        }

        return null;
    }
}
