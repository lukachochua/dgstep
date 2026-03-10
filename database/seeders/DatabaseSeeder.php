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
                'highlight' => [
                    'en' => 'Save time and resources with DG Step.',
                    'ka' => 'დაზოგეთ დრო და რესურსები DG Step-ის დახმარებით.',
                ],
                'subtitle' => [
                    'en' => 'Automate manual workflows and connect every touchpoint into one platform.',
                    'ka' => 'დაავტომატიზეთ ხელით შესრულებული პროცესები და გააერთიანეთ ყველა სამუშაო ნაკადი ერთ პლატფორმაში.',
                ],
                'button_text' => [
                    'en' => 'Services',
                    'ka' => 'სერვისები',
                ],
                'overlay_kicker' => [
                    'en' => 'Operations clarity',
                    'ka' => 'ოპერაციების სიცხადე',
                ],
                'overlay_points' => [
                    'en' => [
                        ['label' => 'Visibility', 'value' => 'Track every active loan and branch workflow in one dashboard.'],
                        ['label' => 'Speed', 'value' => 'Reduce manual handoffs across redemptions, renewals, and reporting.'],
                    ],
                    'ka' => [
                        ['label' => 'ხილვადობა', 'value' => 'ერთ დაფაზე გააკონტროლეთ აქტიური სესხები და ფილიალის პროცესები.'],
                        ['label' => 'სიჩქარე', 'value' => 'შეამცირეთ ხელით გადაცემები გამოსყიდვებს, გაგრძელებებს და ანგარიშგებას შორის.'],
                    ],
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
                'highlight' => [
                    'en' => 'We help businesses simplify their daily operations.',
                    'ka' => 'ჩვენ ვეხმარებით ბიზნესებს ყოველდღიური პროცესების გამარტივებაში.',
                ],
                'subtitle' => [
                    'en' => 'Gain visibility across teams, track KPIs in real time, and remove bottlenecks.',
                    'ka' => 'მიიღეთ სრული სურათი გუნდების მუშაობაზე, აკონტროლეთ KPI-ები რეალურ დროში და აღმოფხვერით შეფერხებები.',
                ],
                'button_text' => [
                    'en' => 'Contact Us',
                    'ka' => 'დაგვიკავშირდით',
                ],
                'overlay_kicker' => [
                    'en' => 'Decision support',
                    'ka' => 'გადაწყვეტილების მხარდაჭერა',
                ],
                'overlay_points' => [
                    'en' => [
                        ['label' => 'Reporting', 'value' => 'See live KPIs, bottlenecks, and team throughput without spreadsheet lag.'],
                        ['label' => 'Control', 'value' => 'Keep operational changes visible as teams scale across locations.'],
                    ],
                    'ka' => [
                        ['label' => 'რეპორტინგი', 'value' => 'იხილეთ KPI-ები, შეფერხებები და გუნდის გამტარუნარიანობა ცხრილების დაგვიანების გარეშე.'],
                        ['label' => 'კონტროლი', 'value' => 'გუნდების და ლოკაციების ზრდისას ცვლილებები თვალსაჩინოდ მართეთ.'],
                    ],
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
                'highlight' => [
                    'en' => 'We provide customized services and solutions for your business.',
                    'ka' => 'ჩვენ გთავაზობთ თქვენს ბიზნესზე მორგებულ სერვისებსა და გადაწყვეტილებებს.',
                ],
                'subtitle' => [
                    'en' => 'Launch tailored software faster with a partner who understands local regulations.',
                    'ka' => 'გაუშვით მორგებული პროგრამული უზრუნველყოფა უფრო სწრაფად პარტნიორთან ერთად, რომელიც იცნობს ადგილობრივ რეგულაციებს.',
                ],
                'button_text' => [
                    'en' => 'About Us',
                    'ka' => 'ჩვენ შესახებ',
                ],
                'overlay_kicker' => [
                    'en' => 'Implementation fit',
                    'ka' => 'დანერგვის შესაბამისობა',
                ],
                'overlay_points' => [
                    'en' => [
                        ['label' => 'Local context', 'value' => 'Build with Georgian workflows, compliance realities, and customer behavior in mind.'],
                        ['label' => 'Delivery', 'value' => 'Ship tailored systems with a partner who can scope, build, and support them end to end.'],
                    ],
                    'ka' => [
                        ['label' => 'ლოკალური კონტექსტი', 'value' => 'შექმენით ქართული სამუშაო პროცესების, შესაბამისობის მოთხოვნებისა და მომხმარებლის ქცევის გათვალისწინებით.'],
                        ['label' => 'მიწოდება', 'value' => 'დანერგეთ მორგებული სისტემა პარტნიორთან ერთად, რომელიც სრულ ციკლს ფარავს.'],
                    ],
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
