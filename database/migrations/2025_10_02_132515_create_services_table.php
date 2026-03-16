<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            // Localized fields
            $table->json('name');
            $table->json('description');
            $table->json('description_expanded')->nullable();
            $table->json('problems');

            // Meta
            $table->string('slug')->unique();
            $table->string('image_path');
            $table->string('featured_image_path')->nullable();
            $table->string('image_alt')->nullable();

            // Featured flags
            $table->boolean('is_featured')->default(false);
            $table->unsignedTinyInteger('featured_order')->default(0);
            $table->unsignedTinyInteger('display_order')->default(0);
            $table->string('cue_style')->default('bubbles');
            $table->json('cue_label')->nullable();
            $table->json('cue_values')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
