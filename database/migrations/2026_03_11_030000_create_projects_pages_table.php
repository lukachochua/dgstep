<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects_pages', function (Blueprint $table) {
            $table->id();
            $table->json('title')->nullable();
            $table->json('hero_kicker')->nullable();
            $table->json('hero_title')->nullable();
            $table->json('hero_lead')->nullable();
            $table->json('proof_heading')->nullable();
            $table->json('proof_body')->nullable();
            $table->json('proof_items')->nullable();
            $table->json('project_cards')->nullable();
            $table->json('cta_heading')->nullable();
            $table->json('cta_description')->nullable();
            $table->json('cta_label')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects_pages');
    }
};
