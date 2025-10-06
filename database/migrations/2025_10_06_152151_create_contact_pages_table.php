<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contact_pages', function (Blueprint $table) {
            $table->id();

            // Translatable JSON columns (Spatie)
            $table->json('headline')->nullable();
            $table->json('description')->nullable();
            $table->json('feature_professional')->nullable();
            $table->json('feature_guarantees')->nullable();
            $table->json('cta_button')->nullable();

            // Non-translatable (href for tel:)
            $table->string('cta_phone_href')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_pages');
    }
};
