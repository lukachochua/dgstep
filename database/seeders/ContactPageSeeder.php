<?php

namespace Database\Seeders;

use App\Models\ContactPage;
use Illuminate\Database\Seeder;

class ContactPageSeeder extends Seeder
{
    public function run(): void
    {
        $translations = [
            'headline' => [
                'en' => 'Contact us to get the service you need.',
                'ka' => 'სასურველი სერვისის მისაღებად დაგვიკავშირდით',
            ],
            'description' => [
                'en' => 'If you run a business and want to simplify your daily operations, contact us, our team will take care of implementing the processes you need.',
                'ka' => 'თუ მართავ ბიზნესს და გჭირდება ყოველდღიური პროცესების გამარტივება, დაგვიკავშირდი და ჩვენი გუნდი იზრუნებს სასურველი პროცესების დანერგვაზე.',
            ],
            'feature_professional' => [
                'en' => 'Professional support',
                'ka' => 'პროფესიონალური მხარდაჭერა',
            ],
            'feature_guarantees' => [
                'en' => 'Qualified Team',
                'ka' => 'გამოცდილი გუნდი',
            ],
            'cta_button' => [
                'en' => 'Contact Us',
                'ka' => 'დაგვიკავშირდით',
            ],
        ];

        $page = ContactPage::query()->latest('id')->first();

        if ($page) {
            foreach ($translations as $attribute => $values) {
                $page->setTranslations($attribute, $values);
            }

            if (! $page->cta_phone_href) {
                $page->cta_phone_href = '+995595992837';
            }

            $page->save();

            return;
        }

        $page = new ContactPage();

        foreach ($translations as $attribute => $values) {
            $page->setTranslations($attribute, $values);
        }

        $page->cta_phone_href = '+995595992837';

        $page->save();
    }
}
