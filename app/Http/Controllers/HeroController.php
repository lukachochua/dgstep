<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use App\Models\Service;
use Illuminate\Support\Facades\Route;

class HeroController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();

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
                ];
            })
            ->filter(fn (array $slide) => filled($slide['title']) || filled($slide['subtitle']))
            ->values()
            ->all();

        $featured = Service::featured()->get();

        return view('pages.home', compact('featured', 'slides'));
    }
}
