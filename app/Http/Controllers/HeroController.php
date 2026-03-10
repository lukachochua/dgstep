<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesLocalizedContent;
use App\Models\HomePage;
use App\Models\HeroSlide;
use App\Models\Service;
use Illuminate\Support\Facades\Route;

class HeroController extends Controller
{
    use ResolvesLocalizedContent;

    public function index()
    {
        $locale = app()->getLocale();
        $page = HomePage::singleton();

        $slides = HeroSlide::query()
            ->orderBy('id')
            ->get()
            ->values()
            ->map(function (HeroSlide $slide, int $index) use ($locale) {
                $fallbacks = [
                    0 => ['route' => 'contact', 'label' => __('messages.hero.primary_cta', [], $locale)],
                    1 => ['route' => 'services', 'label' => __('messages.hero.secondary_cta', [], $locale)],
                    2 => ['route' => 'about', 'label' => __('messages.footer.nav.about', [], $locale)],
                ];

                $fallback = $fallbacks[$index] ?? null;
                $resolvedHref = $slide->button_href;

                if (!$resolvedHref && $fallback && Route::has($fallback['route'])) {
                    $resolvedHref = route($fallback['route']);
                }

                if (!$resolvedHref) {
                    $resolvedHref = Route::has('contact') ? route('contact') : '#';
                }

                $manualText = $slide->getTranslation('button_text', $locale);
                $fallbackLabel = $fallback['label'] ?? trans('contact.cta_button', [], $locale);

                return [
                    'title' => $slide->getTranslation('title', $locale),
                    'highlight' => $slide->getTranslation('highlight', $locale),
                    'subtitle' => $slide->getTranslation('subtitle', $locale),
                    'button_text' => blank($manualText) ? $fallbackLabel : $manualText,
                    'button_href' => $resolvedHref,
                    'image' => $slide->image_url,
                    'overlay_kicker' => $this->localizedText($slide->overlay_kicker, $locale),
                    'overlay_points' => $this->localizedPoints($slide->overlay_points, $locale),
                ];
            })
            ->filter(fn (array $slide) => filled($slide['title']) || filled($slide['subtitle']))
            ->values()
            ->all();

        $featured = Service::featured()->get();

        $homePage = [
            'title' => $this->localizedText($page->title, $locale),
            'hero' => [
                'kicker' => $this->localizedText($page->hero_kicker, $locale),
                'secondary_cta' => $this->localizedText($page->hero_secondary_cta, $locale),
                'slide_label' => $this->localizedText($page->hero_slide_label, $locale),
                'slide_announcement' => $this->localizedText($page->hero_slide_announcement, $locale),
                'audiences_label' => $this->localizedText($page->hero_audiences_label, $locale),
                'audiences' => $this->localizedList($page->hero_audiences, $locale),
                'image_alt' => $this->localizedText($page->hero_image_alt, $locale),
            ],
            'proof' => [
                'kicker' => $this->localizedText($page->proof_kicker, $locale),
                'title' => $this->localizedText($page->proof_title, $locale),
                'subtitle' => $this->localizedText($page->proof_subtitle, $locale),
            ],
            'metrics' => [
                'focus' => [
                    'label' => $this->localizedText($page->metric_focus_label, $locale),
                    'value' => $this->localizedText($page->metric_focus_value, $locale),
                    'description' => $this->localizedText($page->metric_focus_description, $locale),
                ],
                'technology' => [
                    'label' => $this->localizedText($page->metric_technology_label, $locale),
                    'value' => $this->localizedText($page->metric_technology_value, $locale),
                    'description' => $this->localizedText($page->metric_technology_description, $locale),
                ],
                'approach' => [
                    'label' => $this->localizedText($page->metric_approach_label, $locale),
                    'value' => $this->localizedText($page->metric_approach_value, $locale),
                    'description' => $this->localizedText($page->metric_approach_description, $locale),
                ],
            ],
            'solutions' => [
                'kicker' => $this->localizedText($page->solutions_kicker, $locale),
                'title' => $this->localizedText($page->solutions_title, $locale),
                'subtitle' => $this->localizedText($page->solutions_subtitle, $locale),
                'link_label' => $this->localizedText($page->solutions_link_label, $locale),
            ],
            'cta' => [
                'kicker' => $this->localizedText($page->cta_kicker, $locale),
                'title' => $this->localizedText($page->cta_title, $locale),
                'subtitle' => $this->localizedText($page->cta_subtitle, $locale),
                'primary' => $this->localizedText($page->cta_primary, $locale),
                'secondary' => $this->localizedText($page->cta_secondary, $locale),
            ],
        ];

        return view('pages.home', compact('featured', 'slides', 'homePage'));
    }
}
