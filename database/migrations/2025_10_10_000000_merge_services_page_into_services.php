<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->unsignedTinyInteger('display_order')->default(0)->after('featured_order');
            $table->string('cue_style')->default('bubbles')->after('display_order');
            $table->json('cue_label')->nullable()->after('cue_style');
            $table->json('cue_values')->nullable()->after('cue_label');
        });

        if (! Schema::hasTable('services_pages')) {
            return;
        }

        $servicesPage = DB::table('services_pages')->select('sections')->first();

        if (! $servicesPage || empty($servicesPage->sections)) {
            return;
        }

        $sections = json_decode($servicesPage->sections, true);

        if (! is_array($sections)) {
            return;
        }

        foreach ($sections as $index => $section) {
            $slug = $section['key'] ?? null;

            if (! $slug) {
                continue;
            }

            $displayOrder = $index + 1;
            $cueStyle = $section['cue_style'] ?? 'bubbles';
            $cueLabel = $section['cue_label'] ?? null;

            if ($cueLabel && ! is_array($cueLabel)) {
                $cueLabel = [
                    'en' => (string) $cueLabel,
                ];
            }

            $cueValues = $section['cue_values'] ?? [];

            if (is_array($cueValues)) {
                $cueValues = array_values($cueValues);
            } else {
                $cueValues = [];
            }

            DB::table('services')
                ->where('slug', $slug)
                ->update([
                    'display_order' => $displayOrder,
                    'cue_style'     => $cueStyle,
                    'cue_label'     => $cueLabel ? json_encode($cueLabel) : null,
                    'cue_values'    => json_encode($cueValues),
                ]);
        }

        Schema::dropIfExists('services_pages');
    }

    public function down(): void
    {
        Schema::create('services_pages', function (Blueprint $table) {
            $table->id();
            $table->json('title')->nullable();
            $table->json('sections')->nullable();
            $table->timestamps();
        });

        $services = DB::table('services')
            ->orderBy('display_order')
            ->orderBy('id')
            ->get();

        $sections = [];

        foreach ($services as $service) {
            $name = json_decode($service->name, true) ?: [];
            $description = json_decode($service->description, true) ?: [];
            $cueLabel = $service->cue_label ? json_decode($service->cue_label, true) : null;
            $cueValues = $service->cue_values ? json_decode($service->cue_values, true) : [];

            $sections[] = [
                'key'         => $service->slug,
                'title'       => $name,
                'description' => $description,
                'cue_style'   => $service->cue_style ?? 'bubbles',
                'cue_label'   => $cueLabel,
                'cue_values'  => $cueValues,
            ];
        }

        DB::table('services_pages')->insert([
            'title' => json_encode([
                'en' => 'Services — DGstep',
                'ka' => 'სერვისები — DGstep',
            ]),
            'sections' => json_encode($sections),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['display_order', 'cue_style', 'cue_label', 'cue_values']);
        });
    }
};
