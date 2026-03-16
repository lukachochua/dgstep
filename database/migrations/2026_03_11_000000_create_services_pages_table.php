<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services_pages', function (Blueprint $table) {
            $table->id();
            $table->json('title')->nullable();
            $table->json('hero_kicker')->nullable();
            $table->json('hero_title')->nullable();
            $table->json('hero_lead')->nullable();
            $table->json('hero_primary_cta')->nullable();
            $table->json('hero_secondary_cta')->nullable();
            $table->json('overview_heading')->nullable();
            $table->json('overview_body')->nullable();
            $table->json('proof_heading')->nullable();
            $table->json('proof_body')->nullable();
            $table->json('proof_items')->nullable();
            $table->json('cta_kicker')->nullable();
            $table->json('cta_heading')->nullable();
            $table->json('cta_body')->nullable();
            $table->json('cta_primary')->nullable();
            $table->json('cta_secondary')->nullable();
            $table->json('card_problems_heading')->nullable();
            $table->json('card_cta')->nullable();
            $table->json('card_back_to_top')->nullable();
            $table->json('read_more_label')->nullable();
            $table->json('show_less_label')->nullable();
            $table->timestamps();
        });

        $defaults = [
            'title' => json_encode([
                'en' => 'Our Services',
                'ka' => 'ჩვენი სერვისები',
            ]),
            'hero_kicker' => json_encode([
                'en' => 'Services',
                'ka' => 'სერვისები',
            ]),
            'hero_title' => json_encode([
                'en' => 'Service tracks shaped around the way Georgian teams actually operate.',
                'ka' => 'სერვისები, რომლებიც მორგებულია იმაზე, თუ როგორ მუშაობენ ქართული გუნდები რეალურად.',
            ]),
            'hero_lead' => json_encode([
                'en' => 'DGstep helps businesses replace scattered spreadsheets, chats, and manual reporting with one practical workflow system built for day-to-day operations.',
                'ka' => 'DGstep ბიზნესებს ეხმარება ცალკეული ექსელების, ჩატების და ხელით ანგარიშგების ნაცვლად ერთ პრაქტიკულ სამუშაო სისტემაზე გადავიდნენ.',
            ]),
            'hero_primary_cta' => json_encode([
                'en' => 'Book a consultation',
                'ka' => 'კონსულტაციის დაჯავშნა',
            ]),
            'hero_secondary_cta' => json_encode([
                'en' => 'Explore service tracks',
                'ka' => 'სერვისების ნახვა',
            ]),
            'overview_heading' => json_encode([
                'en' => 'Where we help most',
                'ka' => 'სად ვეხმარებით ყველაზე მეტად',
            ]),
            'overview_body' => json_encode([
                'en' => 'Each service track is built around a specific operating model, so the page should help visitors quickly identify the closest fit.',
                'ka' => 'თითოეული სერვისი აგებულია კონკრეტულ სამუშაო მოდელზე, რათა ვიზიტორმა სწრაფად იპოვოს მის ბიზნესთან ყველაზე ახლოს მდგომი მიმართულება.',
            ]),
            'proof_heading' => json_encode([
                'en' => 'Common gaps we remove',
                'ka' => 'რომელ პრობლემებს ვხსნით',
            ]),
            'proof_body' => json_encode([
                'en' => 'These are the operational blockers we see repeatedly across service-heavy and compliance-heavy teams.',
                'ka' => 'ეს არის ოპერაციული ბარიერები, რომლებსაც ყველაზე ხშირად ვხვდებით სერვისულ და შესაბამისობაზე ორიენტირებულ გუნდებში.',
            ]),
            'proof_items' => json_encode([
                'en' => [
                    'Disorganized records across notebooks and spreadsheets',
                    'Difficulty tracking loan history and inventory items',
                    'Slow customer service due to fragmented tools',
                    'Manual, error-prone reporting processes',
                    'Lack of mobile-first access for staff',
                ],
                'ka' => [
                    'ინფორმაცია ფურცლებზე და ექსელშია მიმოფანტული',
                    'სესხებისა და ნივთების ისტორიის თვალყურის დევნა რთულია',
                    'მომხმარებლის მომსახურება ნელია',
                    'ანგარიშგება ხორციელდება ხელით და არაზუსტად',
                    'თანამშრომლებისთვის მობილური წვდომა არ არსებობს',
                ],
            ]),
            'cta_kicker' => json_encode([
                'en' => 'Next Step',
                'ka' => 'შემდეგი ნაბიჯი',
            ]),
            'cta_heading' => json_encode([
                'en' => 'Need a workflow that matches your business instead of forcing you into generic software?',
                'ka' => 'გჭირდებათ სამუშაო პროცესი, რომელიც თქვენს ბიზნესს ერგება და არა გენერიკულ პროგრამას?',
            ]),
            'cta_body' => json_encode([
                'en' => 'We can review the process you already run, identify the weak spots, and shape the right DGstep setup without changing your existing admin flow.',
                'ka' => 'შეგვიძლია თქვენი მიმდინარე პროცესი ერთად განვიხილოთ, სუსტი ადგილები გამოვკვეთოთ და შესაბამისი DGstep კონფიგურაცია შევარჩიოთ ისე, რომ არსებული ადმინისტრირების ლოგიკა არ დაგერღვეს.',
            ]),
            'cta_primary' => json_encode([
                'en' => 'Start the conversation',
                'ka' => 'დავიწყოთ საუბარი',
            ]),
            'cta_secondary' => json_encode([
                'en' => 'Return to top',
                'ka' => 'დასაწყისში დაბრუნება',
            ]),
            'card_problems_heading' => json_encode([
                'en' => 'Typical Gaps',
                'ka' => 'ტიპური სირთულეები',
            ]),
            'card_cta' => json_encode([
                'en' => 'Talk about this service',
                'ka' => 'ამ სერვისზე საუბარი',
            ]),
            'card_back_to_top' => json_encode([
                'en' => 'Back to top',
                'ka' => 'ზემოთ დაბრუნება',
            ]),
            'read_more_label' => json_encode([
                'en' => 'Read More',
                'ka' => 'მეტის ნახვა',
            ]),
            'show_less_label' => json_encode([
                'en' => 'Show Less',
                'ka' => 'დამალვა',
            ]),
        ];

        DB::table('services_pages')->insert(array_merge($defaults, [
            'created_at' => now(),
            'updated_at' => now(),
        ]));
    }

    public function down(): void
    {
        Schema::dropIfExists('services_pages');
    }
};
