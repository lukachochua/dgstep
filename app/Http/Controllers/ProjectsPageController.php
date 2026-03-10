<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesLocalizedContent;
use App\Models\ProjectsPage;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProjectsPageController extends Controller
{
    use ResolvesLocalizedContent;

    public function __invoke(): View
    {
        $locale = app()->getLocale();
        $defaults = ProjectsPage::defaults();
        $page = ProjectsPage::singleton();

        $cards = collect($page->cardsForLocale($locale, $defaults))
            ->map(fn (array $card): array => [
                ...$card,
                'image' => $this->resolveCardImage($card),
            ])
            ->values()
            ->all();

        return view('pages.projects', [
            'page' => [
                'title' => $this->localizedText($page->title, $locale),
                'hero_kicker' => $this->localizedText($page->hero_kicker, $locale),
                'hero_title' => $this->localizedText($page->hero_title, $locale),
                'hero_lead' => $this->localizedText($page->hero_lead, $locale),
                'proof_heading' => $this->localizedText($page->proof_heading, $locale),
                'proof_body' => $this->localizedText($page->proof_body, $locale),
                'proof_items' => $this->localizedList($page->proof_items, $locale),
                'cta_heading' => $this->localizedText($page->cta_heading, $locale),
                'cta_description' => $this->localizedText($page->cta_description, $locale),
                'cta_label' => $this->localizedText($page->cta_label, $locale),
            ],
            'cards' => $cards,
        ]);
    }

    private function resolveCardImage(array $card): ?string
    {
        $uploadPath = $card['image_path'] ?? null;

        if ($uploadPath) {
            try {
                return url(Storage::disk('public')->url($uploadPath));
            } catch (\Throwable $exception) {
                // fall back to the configured URL when storage URL resolution fails
            }
        }

        return $card['image_url'] ?? null;
    }
}
