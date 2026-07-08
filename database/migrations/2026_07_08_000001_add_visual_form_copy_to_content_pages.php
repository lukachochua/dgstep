<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_pages', function (Blueprint $table) {
            $table->json('delivery_kicker')->nullable();
            $table->json('delivery_title')->nullable();
            $table->json('delivery_description')->nullable();
            $table->json('delivery_steps')->nullable();
        });

        Schema::table('contact_pages', function (Blueprint $table) {
            $table->json('intake_heading')->nullable();
            $table->json('intake_description')->nullable();
        });

        $aboutDefaults = \App\Models\AboutPage::defaults();
        DB::table('about_pages')->whereNull('delivery_title')->update([
            'delivery_kicker' => json_encode($aboutDefaults['delivery_kicker'], JSON_UNESCAPED_UNICODE),
            'delivery_title' => json_encode($aboutDefaults['delivery_title'], JSON_UNESCAPED_UNICODE),
            'delivery_description' => json_encode($aboutDefaults['delivery_description'], JSON_UNESCAPED_UNICODE),
            'delivery_steps' => json_encode($aboutDefaults['delivery_steps'], JSON_UNESCAPED_UNICODE),
        ]);

        $contactDefaults = \App\Models\ContactPage::defaults();
        DB::table('contact_pages')->whereNull('intake_heading')->update([
            'intake_heading' => json_encode($contactDefaults['intake_heading'], JSON_UNESCAPED_UNICODE),
            'intake_description' => json_encode($contactDefaults['intake_description'], JSON_UNESCAPED_UNICODE),
        ]);
    }

    public function down(): void
    {
        Schema::table('about_pages', function (Blueprint $table) {
            $table->dropColumn(['delivery_kicker', 'delivery_title', 'delivery_description', 'delivery_steps']);
        });

        Schema::table('contact_pages', function (Blueprint $table) {
            $table->dropColumn(['intake_heading', 'intake_description']);
        });
    }
};
