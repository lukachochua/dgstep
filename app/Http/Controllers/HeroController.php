<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;

class HeroController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();

        $slides = HeroSlide::query()
            ->orderBy('id')
            ->get()
            ->map(function (HeroSlide $slide) use ($locale) {
                return [
                    'title'     => $slide->getTranslation('title', $locale),
                    'highlight' => $slide->getTranslation('highlight', $locale),
                    'subtitle'  => $slide->getTranslation('subtitle', $locale),
                    'button'    => [
                        'text' => $slide->getTranslation('button_text', $locale),
                        'link' => $slide->button_link,
                    ],
                    'image'     => $slide->image_url,
                    'media'     => $slide->media_urls,
                ];
            });

        return view('pages.home', compact('slides'));
    }
}
