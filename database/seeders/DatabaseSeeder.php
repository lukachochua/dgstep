<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\HeroSlide;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
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
                    'en' => 'Simplify Pawnshop Operations',
                    'ka' => 'გაამარტივეთ ლომბარდის ოპერაციები',
                ],
                'highlight' => [
                    'en' => 'with DG STEP',
                    'ka' => 'DG STEP-ით',
                ],
                'subtitle' => [
                    'en' => 'From records to renewals — manage it all with one tool.',
                    'ka' => 'ჩაწერიდან განახლებამდე — მართეთ ყველაფერი ერთ ხელსაწყოთი.',
                ],
                'button_text' => [
                    'en' => 'Contact Us',
                    'ka' => 'დაგვიკავშირდით',
                ],
                'button_link' => '#contact',
                'image_path' => null,
            ],
            [
                'title' => [
                    'en' => 'Boost Business Efficiency',
                    'ka' => 'გაზარდეთ ბიზნესის ეფექტურობა',
                ],
                'highlight' => [
                    'en' => 'across all industries',
                    'ka' => 'ყველა ინდუსტრიაში',
                ],
                'subtitle' => [
                    'en' => 'We help small businesses serve faster, smarter, and better.',
                    'ka' => 'ჩვენ ვეხმარებით მცირე ბიზნესებს სწრაფ, ჭკვიან და ხარისხიან მომსახურებაში.',
                ],
                'button_text' => [
                    'en' => 'Get in Touch',
                    'ka' => 'დაგვიკავშირდით',
                ],
                'button_link' => '#contact',
                'image_path' => null,
            ],
            [
                'title' => [
                    'en' => 'Built for Georgian Businesses',
                    'ka' => 'შექმნილია ქართული ბიზნესებისთვის',
                ],
                'highlight' => [
                    'en' => 'Local + Compliant',
                    'ka' => 'ადგილობრივი + შესაბამისი',
                ],
                'subtitle' => [
                    'en' => 'Tailored tools for your workflow and regulations.',
                    'ka' => 'ინსტრუმენტები მორგებული თქვენს სამუშაო ნაკადსა და რეგულაციებს.',
                ],
                'button_text' => [
                    'en' => 'Start Now',
                    'ka' => 'დაიწყეთ ახლა',
                ],
                'button_link' => '#contact',
                'image_path' => null,
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlide::updateOrCreate(
                ['button_link' => $slide['button_link'], 'title->en' => $slide['title']['en']],
                $slide
            );
        }
    }
}
