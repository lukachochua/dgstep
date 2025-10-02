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
            ->map(function (HeroSlide $slide) use ($locale) {
                // Resolve final href (internal route / external URL / legacy)
                $resolvedHref = $slide->button_href
                    ?: (Route::has('contact') ? route('contact') : '#');

                $secondaryHref = $slide->secondary_button_href
                    ?: (Route::has('services') ? route('services') : '#');

                return [
                    'title'        => $slide->getTranslation('title', $locale),
                    'highlight'    => $slide->getTranslation('highlight', $locale),
                    'subtitle'     => $slide->getTranslation('subtitle', $locale),
                    'button'       => [
                        'text' => $slide->getTranslation('button_text', $locale),
                        'href' => $resolvedHref,
                        'link' => $resolvedHref,
                    ],
                    'button_href'  => $resolvedHref,
                    'secondary_button' => [
                        'text' => $slide->getTranslation('secondary_button_text', $locale) ?: __('messages.services'),
                        'href' => $secondaryHref,
                        'link' => $secondaryHref,
                    ],
                    'secondary_button_href' => $secondaryHref,
                    'image'        => $slide->image_url,
                    'media'        => $slide->media_urls,
                ];
            })
            ->values()
            ->all();

        // NEW: pull exactly three featured services (scope enforces limit/order)
        $featured = Service::featured()->get();

        return view('pages.home', compact('slides', 'featured'));
    }
}
