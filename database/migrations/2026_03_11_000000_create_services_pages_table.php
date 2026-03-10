<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('services_pages')) {
            Schema::create('services_pages', function (Blueprint $table) {
                $table->id();
                $table->json('title')->nullable();
                $table->json('sections')->nullable();
                $table->timestamps();
            });
        }

        Schema::table('services_pages', function (Blueprint $table) {
            if (! Schema::hasColumn('services_pages', 'hero_kicker')) {
                $table->json('hero_kicker')->nullable()->after('title');
            }

            if (! Schema::hasColumn('services_pages', 'hero_title')) {
                $table->json('hero_title')->nullable()->after('hero_kicker');
            }

            if (! Schema::hasColumn('services_pages', 'hero_lead')) {
                $table->json('hero_lead')->nullable()->after('hero_title');
            }

            if (! Schema::hasColumn('services_pages', 'hero_primary_cta')) {
                $table->json('hero_primary_cta')->nullable()->after('hero_lead');
            }

            if (! Schema::hasColumn('services_pages', 'hero_secondary_cta')) {
                $table->json('hero_secondary_cta')->nullable()->after('hero_primary_cta');
            }

            if (! Schema::hasColumn('services_pages', 'overview_heading')) {
                $table->json('overview_heading')->nullable()->after('hero_secondary_cta');
            }

            if (! Schema::hasColumn('services_pages', 'overview_body')) {
                $table->json('overview_body')->nullable()->after('overview_heading');
            }

            if (! Schema::hasColumn('services_pages', 'stat_tracks_label')) {
                $table->json('stat_tracks_label')->nullable()->after('overview_body');
            }

            if (! Schema::hasColumn('services_pages', 'stat_pain_points_label')) {
                $table->json('stat_pain_points_label')->nullable()->after('stat_tracks_label');
            }

            if (! Schema::hasColumn('services_pages', 'proof_heading')) {
                $table->json('proof_heading')->nullable()->after('stat_pain_points_label');
            }

            if (! Schema::hasColumn('services_pages', 'proof_body')) {
                $table->json('proof_body')->nullable()->after('proof_heading');
            }

            if (! Schema::hasColumn('services_pages', 'proof_items')) {
                $table->json('proof_items')->nullable()->after('proof_body');
            }

            if (! Schema::hasColumn('services_pages', 'cta_kicker')) {
                $table->json('cta_kicker')->nullable()->after('proof_items');
            }

            if (! Schema::hasColumn('services_pages', 'cta_heading')) {
                $table->json('cta_heading')->nullable()->after('cta_kicker');
            }

            if (! Schema::hasColumn('services_pages', 'cta_body')) {
                $table->json('cta_body')->nullable()->after('cta_heading');
            }

            if (! Schema::hasColumn('services_pages', 'cta_primary')) {
                $table->json('cta_primary')->nullable()->after('cta_body');
            }

            if (! Schema::hasColumn('services_pages', 'cta_secondary')) {
                $table->json('cta_secondary')->nullable()->after('cta_primary');
            }
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
            'stat_tracks_label' => json_encode([
                'en' => 'Service Tracks',
                'ka' => 'სერვისის მიმართულება',
            ]),
            'stat_pain_points_label' => json_encode([
                'en' => 'Pain Points Mapped',
                'ka' => 'დაფარული პრობლემა',
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
        ];

        if (! DB::table('services_pages')->exists()) {
            DB::table('services_pages')->insert(array_merge($defaults, [
                'sections' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        } else {
            DB::table('services_pages')
                ->whereNull('hero_title')
                ->update($defaults);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('services_pages')) {
            return;
        }

        Schema::table('services_pages', function (Blueprint $table) {
            foreach ([
                'hero_kicker',
                'hero_title',
                'hero_lead',
                'hero_primary_cta',
                'hero_secondary_cta',
                'overview_heading',
                'overview_body',
                'stat_tracks_label',
                'stat_pain_points_label',
                'proof_heading',
                'proof_body',
                'proof_items',
                'cta_kicker',
                'cta_heading',
                'cta_body',
                'cta_primary',
                'cta_secondary',
            ] as $column) {
                if (Schema::hasColumn('services_pages', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
