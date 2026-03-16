<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_pages', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('hero_kicker');
            $table->json('hero_secondary_cta');
            $table->json('hero_slide_label');
            $table->json('hero_slide_announcement');
            $table->json('hero_image_alt');
            $table->json('proof_kicker');
            $table->json('proof_title');
            $table->json('proof_subtitle');
            $table->json('metric_focus_label');
            $table->json('metric_focus_value');
            $table->json('metric_focus_description');
            $table->json('metric_technology_label');
            $table->json('metric_technology_value');
            $table->json('metric_technology_description');
            $table->json('metric_approach_label');
            $table->json('metric_approach_value');
            $table->json('metric_approach_description');
            $table->json('solutions_kicker');
            $table->json('solutions_title');
            $table->json('solutions_subtitle');
            $table->json('solutions_link_label')->nullable();
            $table->json('cta_title');
            $table->json('cta_subtitle');
            $table->json('cta_primary');
            $table->json('cta_secondary');
            $table->json('floating_cta_title')->nullable();
            $table->json('floating_cta_primary')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_pages');
    }
};
