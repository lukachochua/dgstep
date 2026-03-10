<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hero_slides', function (Blueprint $table) {
            if (! Schema::hasColumn('hero_slides', 'overlay_kicker')) {
                $table->json('overlay_kicker')->nullable()->after('button_text');
            }

            if (! Schema::hasColumn('hero_slides', 'overlay_points')) {
                $table->json('overlay_points')->nullable()->after('overlay_kicker');
            }
        });

        Schema::table('home_pages', function (Blueprint $table) {
            if (Schema::hasColumn('home_pages', 'hero_visual_card_kicker')) {
                $table->dropColumn('hero_visual_card_kicker');
            }

            if (Schema::hasColumn('home_pages', 'hero_visual_points')) {
                $table->dropColumn('hero_visual_points');
            }
        });
    }

    public function down(): void
    {
        Schema::table('home_pages', function (Blueprint $table) {
            if (! Schema::hasColumn('home_pages', 'hero_visual_card_kicker')) {
                $table->json('hero_visual_card_kicker')->nullable()->after('hero_audiences');
            }

            if (! Schema::hasColumn('home_pages', 'hero_visual_points')) {
                $table->json('hero_visual_points')->nullable()->after('hero_visual_card_kicker');
            }
        });

        Schema::table('hero_slides', function (Blueprint $table) {
            if (Schema::hasColumn('hero_slides', 'overlay_points')) {
                $table->dropColumn('overlay_points');
            }

            if (Schema::hasColumn('hero_slides', 'overlay_kicker')) {
                $table->dropColumn('overlay_kicker');
            }
        });
    }
};
