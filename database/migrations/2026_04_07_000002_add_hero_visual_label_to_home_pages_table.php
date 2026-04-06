<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_pages', function (Blueprint $table) {
            $table->json('hero_visual_label')->nullable();
        });

        DB::table('home_pages')
            ->whereNull('hero_visual_label')
            ->update([
                'hero_visual_label' => json_encode([
                    'en' => Lang::get('messages.hero.visual_card_kicker', [], 'en'),
                    'ka' => Lang::get('messages.hero.visual_card_kicker', [], 'ka'),
                ], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
            ]);
    }

    public function down(): void
    {
        Schema::table('home_pages', function (Blueprint $table) {
            $table->dropColumn('hero_visual_label');
        });
    }
};
