<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_pages', function (Blueprint $table) {
            if (! Schema::hasColumn('home_pages', 'solutions_link_label')) {
                $table->json('solutions_link_label')->nullable()->after('solutions_subtitle');
            }
        });

        Schema::table('services_pages', function (Blueprint $table) {
            if (! Schema::hasColumn('services_pages', 'card_problems_heading')) {
                $table->json('card_problems_heading')->nullable()->after('cta_secondary');
            }

            if (! Schema::hasColumn('services_pages', 'card_cta')) {
                $table->json('card_cta')->nullable()->after('card_problems_heading');
            }

            if (! Schema::hasColumn('services_pages', 'card_back_to_top')) {
                $table->json('card_back_to_top')->nullable()->after('card_cta');
            }

            if (! Schema::hasColumn('services_pages', 'read_more_label')) {
                $table->json('read_more_label')->nullable()->after('card_back_to_top');
            }

            if (! Schema::hasColumn('services_pages', 'show_less_label')) {
                $table->json('show_less_label')->nullable()->after('read_more_label');
            }
        });

        DB::table('home_pages')
            ->whereNull('solutions_link_label')
            ->update([
                'solutions_link_label' => json_encode([
                    'en' => 'Read More',
                    'ka' => 'მეტის ნახვა',
                ]),
            ]);

        DB::table('services_pages')
            ->whereNull('card_problems_heading')
            ->update([
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
            ]);
    }

    public function down(): void
    {
        if (Schema::hasTable('home_pages')) {
            Schema::table('home_pages', function (Blueprint $table) {
                if (Schema::hasColumn('home_pages', 'solutions_link_label')) {
                    $table->dropColumn('solutions_link_label');
                }
            });
        }

        if (Schema::hasTable('services_pages')) {
            Schema::table('services_pages', function (Blueprint $table) {
                foreach ([
                    'card_problems_heading',
                    'card_cta',
                    'card_back_to_top',
                    'read_more_label',
                    'show_less_label',
                ] as $column) {
                    if (Schema::hasColumn('services_pages', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
