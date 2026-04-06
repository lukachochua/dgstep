<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

return new class extends Migration
{
    public function up(): void
    {
        $defaults = [
            'hero_primary_cta' => [
                'en' => Lang::get('messages.hero.primary_cta', [], 'en'),
                'ka' => Lang::get('messages.hero.primary_cta', [], 'ka'),
            ],
            'hero_visual_point' => [
                'en' => Lang::get('messages.hero.visual_points.0.value', [], 'en'),
                'ka' => Lang::get('messages.hero.visual_points.0.value', [], 'ka'),
            ],
        ];

        foreach ($defaults as $column => $translations) {
            DB::table('home_pages')
                ->whereNull($column)
                ->update([
                    $column => json_encode($translations, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
                ]);
        }
    }

    public function down(): void
    {
        //
    }
};
