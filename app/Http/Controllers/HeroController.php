<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
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

                return [
                    'title'        => $slide->getTranslation('title', $locale),
                    'highlight'    => $slide->getTranslation('highlight', $locale),
                    'subtitle'     => $slide->getTranslation('subtitle', $locale),

                    // Keep your existing structure but send the resolved URL everywhere:
                    'button'       => [
                        'text' => $slide->getTranslation('button_text', $locale),
                        'href' => $resolvedHref,      // <— new preferred key
                        'link' => $resolvedHref,      // <— legacy key your Blade checks too
                    ],

                    // Also provide a top-level for the Blade fallback you wrote
                    'button_href'  => $resolvedHref,

                    // Images
                    'image'        => $slide->image_url,
                    'media'        => $slide->media_urls,
                ];
            })
            ->values()
            ->all();

        return view('pages.home', compact('slides'));
    }
}
