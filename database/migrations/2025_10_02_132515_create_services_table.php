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
            $table->json('name');         // {"en":"...","ka":"..."}
            $table->json('description');  // {"en":"...","ka":"..."}
            $table->json('problems');     // {"en":[...],"ka":[...]}

            // Meta
            $table->string('slug')->unique();
            $table->string('image_path');
            $table->string('image_alt')->nullable();

            // Featured flags
            $table->boolean('is_featured')->default(false);
            $table->unsignedTinyInteger('featured_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
