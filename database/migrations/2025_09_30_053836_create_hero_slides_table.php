<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();

            // Translatable JSON fields
            $table->json('title')->nullable();
            $table->json('highlight')->nullable();
            $table->json('subtitle')->nullable();
            $table->json('button_text')->nullable();

            // Legacy link (kept for backward compatibility)
            $table->string('button_link')->nullable();

            // Route-aware linking
            $table->string('link_type')->default('legacy'); // 'internal' | 'external' | 'legacy'
            $table->string('button_route')->nullable();     // e.g. 'contact', 'projects.show'
            $table->json('button_params')->nullable();      // e.g. {"slug":"my-project"}
            $table->string('button_url')->nullable();       // external URL

            // Media
            $table->string('image_path')->nullable();       // background image path

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
