<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasColumn('about_pages', 'hero_status_label')) {
            Schema::table('about_pages', function (Blueprint $table) {
                $table->dropColumn('hero_status_label');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('about_pages', 'hero_status_label')) {
            Schema::table('about_pages', function (Blueprint $table) {
                $table->json('hero_status_label')->nullable()->after('hero_caption');
            });
        }
    }
};
