<?php

namespace Database\Seeders;

use App\Models\ContactPage;
use Illuminate\Database\Seeder;

class ContactPageSeeder extends Seeder
{
    public function run(): void
    {
        // Avoid duplicates if already seeded/edited in admin
        if (ContactPage::query()->exists()) {
            return;
        }

        $page = new ContactPage();

        $page->setTranslations('headline', [
            'en' => 'Let’s talk about your operations',
            'ka' => 'მოდით, ვისაუბროთ თქვენს ოპერაციებზე',
        ]);

        $page->setTranslations('description', [
            'en' => 'Whether you run a pawnshop or a growing SMB, we help you streamline workflows, automate paperwork, and stay compliant.',
            'ka' => 'თუკი მართავთ ლომბარდს ან მზარდ SMB-ს, დაგეხმარებით პროცესების გამარტივებაში, დოკუმენტაციის ავტომატიზაციაში და რეგულაციებთან შესაბამისობაში.',
        ]);

        $page->setTranslations('feature_professional', [
            'en' => 'Professional support',
            'ka' => 'პროფესიონალური მხარდაჭერა',
        ]);

        $page->setTranslations('feature_guarantees', [
            'en' => 'Clear guarantees',
            'ka' => 'მკაფიო გარანტიები',
        ]);

        $page->setTranslations('cta_button', [
            'en' => 'Call DGstep',
            'ka' => 'დარეკეთ DGstep-ში',
        ]);

        $page->cta_phone_href = '+995595992837';

        $page->save();
    }
}
