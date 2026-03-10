<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesLocalizedContent;
use App\Models\Service;
use App\Models\ServicesPage;
use Illuminate\View\View;

class ServicesPageController extends Controller
{
    use ResolvesLocalizedContent;

    public function __invoke(): View
    {
        $locale = app()->getLocale();
        $page = ServicesPage::singleton();

        $services = Service::ordered()
            ->get()
            ->map(function (Service $service, int $index) use ($locale): array {
                $title = $this->localizedText($service->name, $locale);

                return [
                    'slug' => $service->slug,
                    'index' => $index + 1,
                    'title' => $title,
                    'description' => $this->localizedText($service->description, $locale),
                    'full_description' => $this->localizedText($service->description_expanded, $locale),
                    'image' => $service->image_url,
                    'image_alt' => $service->image_alt ?: $title,
                    'problems' => $this->localizedList($service->problems, $locale),
                    'cue_style' => in_array($service->cue_style, ['bubbles', 'bars', 'dots'], true)
                        ? $service->cue_style
                        : 'bubbles',
                    'cue_label' => $this->localizedText($service->cue_label, $locale),
                    'cue_values' => collect($service->cue_values ?? [])
                        ->filter(fn ($value) => is_numeric($value))
                        ->map(fn ($value) => (int) $value)
                        ->values()
                        ->all(),
                ];
            })
            ->values();

        return view('pages.services', [
            'page' => [
                'title' => $this->localizedText($page->title, $locale),
                'hero_kicker' => $this->localizedText($page->hero_kicker, $locale),
                'hero_title' => $this->localizedText($page->hero_title, $locale),
                'hero_lead' => $this->localizedText($page->hero_lead, $locale),
                'hero_primary_cta' => $this->localizedText($page->hero_primary_cta, $locale),
                'hero_secondary_cta' => $this->localizedText($page->hero_secondary_cta, $locale),
                'overview_heading' => $this->localizedText($page->overview_heading, $locale),
                'overview_body' => $this->localizedText($page->overview_body, $locale),
                'stat_tracks_label' => $this->localizedText($page->stat_tracks_label, $locale),
                'stat_pain_points_label' => $this->localizedText($page->stat_pain_points_label, $locale),
                'proof_heading' => $this->localizedText($page->proof_heading, $locale),
                'proof_body' => $this->localizedText($page->proof_body, $locale),
                'proof_items' => $this->localizedList($page->proof_items, $locale),
                'cta_kicker' => $this->localizedText($page->cta_kicker, $locale),
                'cta_heading' => $this->localizedText($page->cta_heading, $locale),
                'cta_body' => $this->localizedText($page->cta_body, $locale),
                'cta_primary' => $this->localizedText($page->cta_primary, $locale),
                'cta_secondary' => $this->localizedText($page->cta_secondary, $locale),
                'card_problems_heading' => $this->localizedText($page->card_problems_heading, $locale),
                'card_cta' => $this->localizedText($page->card_cta, $locale),
                'card_back_to_top' => $this->localizedText($page->card_back_to_top, $locale),
                'read_more_label' => $this->localizedText($page->read_more_label, $locale),
                'show_less_label' => $this->localizedText($page->show_less_label, $locale),
            ],
            'services' => $services,
            'serviceCount' => $services->count(),
            'problemCount' => $services->sum(fn (array $service): int => count($service['problems'])),
        ]);
    }
}
