<?php

use App\Models\AboutPage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();
            $table->json('title')->nullable();
            $table->json('who_heading')->nullable();
            $table->json('who_paragraph_1')->nullable();
            $table->json('who_paragraph_2')->nullable();
            $table->json('mission_heading')->nullable();
            $table->json('mission_label')->nullable();
            $table->json('mission_description')->nullable();
            $table->json('vision_heading')->nullable();
            $table->json('vision_label')->nullable();
            $table->json('vision_description')->nullable();
            $table->json('management_heading')->nullable();
            $table->json('management_view_all')->nullable();
            $table->json('management_collapse')->nullable();
            $table->json('badges')->nullable();
            $table->string('hero_image_url')->nullable();
            $table->json('hero_image_alt')->nullable();
            $table->json('hero_caption')->nullable();
            $table->json('hero_status_label')->nullable();
            $table->json('management_members')->nullable();
            $table->timestamps();
        });

        $defaults = AboutPage::defaults();

        AboutPage::query()->create($defaults);
    }

    public function down(): void
    {
        Schema::dropIfExists('about_pages');
    }
};
