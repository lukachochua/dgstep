<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->string('company_name')->nullable()->after('surname');
            $table->string('project_type', 40)->nullable()->after('phone');
            $table->string('system_area', 40)->nullable()->after('project_type');
            $table->string('timeline', 40)->nullable()->after('system_area');
        });
    }

    public function down(): void
    {
        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->dropColumn(['company_name', 'project_type', 'system_area', 'timeline']);
        });
    }
};
