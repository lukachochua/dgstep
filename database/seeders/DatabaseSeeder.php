<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\HeroSlide;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->syncSeederAssetsToPublicDisk();

        // Create admin user
        User::updateOrCreate(
            ['email' => 'dgstep@admin.com'],
            [
                'name' => 'DGstep Admin',
                'password' => Hash::make('password123'),
                'is_admin' => true,
            ]
        );

        // Seed hero slides
        $slides = [
            [
                'sort_order' => 1,
                'title' => [
                    'en' => 'Implement a Warehouse Management System (WMS)',
                    'ka' => 'დანერგე საწყობის მართვის სისტემა (WMS)',
                ],
                'subtitle' => [
                    'en' => "Manage the full warehouse process in one system.\nProduct ordering -> receiving -> storage -> fulfillment -> inventory -> analytics -> role management",
                    'ka' => "საწყობის სრული პროცესის მართვის კონტროლი ერთ სისტემაში\nპროდუქტის შეკვეთა → პროდუქტის მიღება → დასაწყობება → რეალიზაცია → ინვენტარიზაცია → ანალიტიკა → როლების მართვა",
                ],
                'button_text' => [
                    'en' => 'Contact us',
                    'ka' => 'დაგვიკავშირდი',
                ],
                'button_link' => '#contact',
                'link_type' => 'internal',
                'button_route' => 'contact',
                'button_params' => null,
                'image_path' => $this->resolveHeroSlideImagePath(1),
            ],
            [
                'sort_order' => 2,
                'title' => [
                    'en' => 'Increase your business efficiency',
                    'ka' => 'გაამარტივეთ და გაზარდეთ თქვენი ბიზნესის ეფექტურობა',
                ],
                'subtitle' => [
                    'en' => "We help simplify day-to-day business processes.\nIt is time to digitize your business.",
                    'ka' => "ჩვენ დაგეხმარებით ყოველდღიური ბიზნეს პროცესების გამარტივებაში.\nდროა გააციფრულო შენი ბიზნესი",
                ],
                'button_text' => [
                    'en' => 'Services',
                    'ka' => 'სერვისები',
                ],
                'button_link' => '#contact',
                'link_type' => 'internal',
                'button_route' => 'services',
                'button_params' => null,
                'image_path' => $this->resolveHeroSlideImagePath(2),
            ],
            [
                'sort_order' => 3,
                'title' => [
                    'en' => 'Save time and resources with our software',
                    'ka' => 'დაზოგე დრო და რესურსი ჩვენი პროგრამების დახმარებით',
                ],
                'subtitle' => [
                    'en' => 'We implement software tailored to your business that saves time, money, and human resources in daily operations.',
                    'ka' => 'ჩვენ ვნერგავთ თქვენზე მორგებულ პროგრამებს, რომელიც ყოველდღიურ საქმიანობაში დაგიზოგავთ დროს, ფინანსებს და ადამიანურ რესურსს.',
                ],
                'button_text' => [
                    'en' => 'Contact us',
                    'ka' => 'დაგვიკავშირდი',
                ],
                'button_link' => '#contact',
                'link_type' => 'internal',
                'button_route' => 'contact',
                'button_params' => null,
                'image_path' => $this->resolveHeroSlideImagePath(3),
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlide::updateOrCreate(
                ['sort_order' => $slide['sort_order']],
                $slide
            );
        }

        $this->call([
            AboutPageSeeder::class,
            HomePageSeeder::class,
            ServicesPageSeeder::class,
            ProjectsPageSeeder::class,
            ServiceSeeder::class,
            ContactPageSeeder::class,

        ]);
    }

    private function syncSeederAssetsToPublicDisk(): void
    {
        $this->copySeederAssetGroup(
            base_path('database/seeders/assets/hero'),
            storage_path('app/public/hero'),
        );

        $this->copySeederAssetGroup(
            base_path('database/seeders/assets/services'),
            storage_path('app/public/services'),
        );
    }

    private function copySeederAssetGroup(string $sourceDir, string $destinationDir): void
    {
        if (! File::isDirectory($sourceDir)) {
            return;
        }

        File::ensureDirectoryExists($destinationDir);

        foreach (File::files($sourceDir) as $file) {
            if (! $this->isSupportedImageExtension($file->getExtension())) {
                continue;
            }

            File::copy($file->getPathname(), $destinationDir.DIRECTORY_SEPARATOR.$file->getFilename());
        }
    }

    private function resolveHeroSlideImagePath(int $index): ?string
    {
        foreach (['jpg', 'jpeg', 'png', 'webp', 'bmp'] as $extension) {
            $relativePath = "hero/slide-{$index}.{$extension}";

            if (Storage::disk('public')->exists($relativePath)) {
                return $relativePath;
            }
        }

        return null;
    }

    private function isSupportedImageExtension(string $extension): bool
    {
        return in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp', 'bmp'], true);
    }
}
