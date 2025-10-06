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
                    'en' => 'Contact Us',
                    'ka' => 'დაგვიკავშირდით',
                ],
                'button_link' => '#contact',
                'secondary_button_text' => [
                    'en' => 'Services',
                    'ka' => 'სერვისები',
                ],
                'secondary_link_type' => 'internal',
                'secondary_button_route' => 'services',
                'secondary_button_params' => null,
                'secondary_button_url' => null,
                'secondary_button_link' => null,
                'image_path' => null,
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
                'button_link' => '#contact',
                'secondary_button_text' => [
                    'en' => 'Services',
                    'ka' => 'სერვისები',
                ],
                'secondary_link_type' => 'internal',
                'secondary_button_route' => 'services',
                'secondary_button_params' => null,
                'secondary_button_url' => null,
                'secondary_button_link' => null,
                'image_path' => null,
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
                    'en' => 'Contact Us',
                    'ka' => 'დაგვიკავშირდით',
                ],
                'button_link' => '#contact',
                'secondary_button_text' => [
                    'en' => 'Services',
                    'ka' => 'სერვისები',
                ],
                'secondary_link_type' => 'internal',
                'secondary_button_route' => 'services',
                'secondary_button_params' => null,
                'secondary_button_url' => null,
                'secondary_button_link' => null,
                'image_path' => null,
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlide::updateOrCreate(
                ['button_link' => $slide['button_link'], 'title->en' => $slide['title']['en']],
                $slide
            );
        }

        $this->call([
            ServiceSeeder::class,
        ]);
    }
}
