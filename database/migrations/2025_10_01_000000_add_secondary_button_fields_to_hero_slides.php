<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hero_slides', function (Blueprint $table) {
            $table->json('secondary_button_text')->nullable()->after('button_text');
            $table->string('secondary_button_link')->nullable()->after('button_link');
            $table->string('secondary_link_type')->default('legacy')->after('link_type');
            $table->string('secondary_button_route')->nullable()->after('button_route');
            $table->json('secondary_button_params')->nullable()->after('button_params');
            $table->string('secondary_button_url')->nullable()->after('button_url');
        });
    }

    public function down(): void
    {
        Schema::table('hero_slides', function (Blueprint $table) {
            $table->dropColumn([
                'secondary_button_text',
                'secondary_button_link',
                'secondary_link_type',
                'secondary_button_route',
                'secondary_button_params',
                'secondary_button_url',
            ]);
        });
    }
};
