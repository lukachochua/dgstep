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
                'title' => [
                    'en' => 'Digitize your business’s daily operations',
                    'ka' => 'გადაიყვანეთ თქვენი ბიზნესის ყოველდღიური ოპერაციები ციფრულ რეჟიმში',
                ],
                'subtitle' => [
                    'en' => 'Automate manual workflows and connect every touchpoint into one platform.',
                    'ka' => 'დაავტომატიზეთ ხელით შესრულებული პროცესები და გააერთიანეთ ყველა სამუშაო ნაკადი ერთ პლატფორმაში.',
                ],
                'button_text' => [
                    'en' => 'Services',
                    'ka' => 'სერვისები',
                ],
                'button_link' => '#contact',
                'link_type' => 'internal',
                'button_route' => 'services',
                'button_params' => null,
                'image_path' => $this->resolveHeroSlideImagePath(1),
            ],
            [
                'title' => [
                    'en' => 'Simplify and increase the efficiency of your business',
                    'ka' => 'გაამარტივეთ და გაზარდეთ თქვენი ბიზნესის ეფექტურობა',
                ],
                'subtitle' => [
                    'en' => 'Gain visibility across teams, track KPIs in real time, and remove bottlenecks.',
                    'ka' => 'მიიღეთ სრული სურათი გუნდების მუშაობაზე, აკონტროლეთ KPI-ები რეალურ დროში და აღმოფხვერით შეფერხებები.',
                ],
                'button_text' => [
                    'en' => 'Contact Us',
                    'ka' => 'დაგვიკავშირდით',
                ],
                'button_link' => '#contact',
                'link_type' => 'internal',
                'button_route' => 'contact',
                'button_params' => null,
                'image_path' => $this->resolveHeroSlideImagePath(2),
            ],
            [
                'title' => [
                    'en' => 'Time to digitize your business.',
                    'ka' => 'დადგა დრო თქვენი ბიზნესის დიგიტალიზაციისთვის.',
                ],
                'subtitle' => [
                    'en' => 'Launch tailored software faster with a partner who understands local regulations.',
                    'ka' => 'გაუშვით მორგებული პროგრამული უზრუნველყოფა უფრო სწრაფად პარტნიორთან ერთად, რომელიც იცნობს ადგილობრივ რეგულაციებს.',
                ],
                'button_text' => [
                    'en' => 'About Us',
                    'ka' => 'ჩვენ შესახებ',
                ],
                'button_link' => '#contact',
                'link_type' => 'internal',
                'button_route' => 'about',
                'button_params' => null,
                'image_path' => $this->resolveHeroSlideImagePath(3),
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlide::updateOrCreate(
                ['button_link' => $slide['button_link'], 'title->en' => $slide['title']['en']],
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
