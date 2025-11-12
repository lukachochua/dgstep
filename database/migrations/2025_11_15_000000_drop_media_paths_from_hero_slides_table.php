<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('hero_slides', 'media_paths')) {
            Schema::table('hero_slides', function (Blueprint $table) {
                $table->dropColumn('media_paths');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('hero_slides', 'media_paths')) {
            Schema::table('hero_slides', function (Blueprint $table) {
                $table->json('media_paths')->nullable()->after('image_path');
            });
        }
    }
};
