<?php

namespace Database\Seeders;

use App\Models\AboutPage;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    public function run(): void
    {
        $translations = [
            'who_paragraph_1' => [
                'en' => 'In response to the challenges on the market, we decided to help small and medium-sized businesses to implement digital processes.',
                'ka' => 'ბაზარზე არსებული პრობლემების საპასუხოდ, გადავწყვიტეთ, რომ მცირე და საშუალო ბიზნესებს ციფრული პროცესების დანერგვაში დავეხმაროთ.',
            ],
            'who_paragraph_2' => [
                'en' => 'Our goal is to implement flexible, simple, and customer-oriented digital processes for businesses. Both the companies and their customers will be able to use the service, making everyday operations even easier and more efficient.',
                'ka' => 'ჩვენი მიზანი ბიზნესებისთვის მოქნილი, გამარტივებული და მომხმარებლებზე მორგებული ციფრული პროცესების დანერგვაა. სერვისით სარგებლობას შეძლებს როგორც ბიზნესი, ასევე მათი მომხმარებელი, რაც ყოველდღიურ საქმიანობას კიდევ უფრო გაამარტივებს და ეფექტურს გახდის.',
            ],
            'mission_description' => [
                'en' => 'To implement flexible, simple, and customer-oriented digital processes for businesses that bring benefits to both sides.',
                'ka' => 'დავნერგოთ ბიზნესებისთვის მოქნილი, გამარტივებული, მათ მომხმარებლებზე მორგებული ციფრული პროცესები, რაც ორივე მხარისთვის სარგებლის მომტანი იქნება.',
            ],
            'vision_description' => [
                'en' => 'To become a leading company in business process automation and optimization, where every process is simplified and companies can take full advantage of 21st-century digital benefits.',
                'ka' => 'ვიყოთ ბიზნეს-პროცესების ავტომატიზაციის და ოპტიმიზაციის დანერგვაში ლიდერი კომპანია, სადაც ყველა პროცესი გამარტივებული იქნება და კომპანიები 21-ე საუკუნის ციფრული უპირატესობებით სარგებლობას შეძლებენ.',
            ],
        ];

        $page = AboutPage::query()->first();

        if ($page) {
            foreach ($translations as $attribute => $values) {
                $page->setTranslations($attribute, $values);
            }

            $page->save();

            return;
        }

        $defaults = AboutPage::defaults();
        foreach ($translations as $attribute => $values) {
            $defaults[$attribute] = $values;
        }

        AboutPage::query()->create($defaults);
    }
}
