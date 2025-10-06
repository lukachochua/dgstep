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
        $isKaLocale = $locale === 'ka';
        $isEnLocale = $locale === 'en';
        [$heroHeadingScale, $heroSubtitleScale] = $this->heroTypographyScale($locale);

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

        return view('pages.home', compact(
            'slides',
            'featured',
            'isKaLocale',
            'isEnLocale',
            'heroHeadingScale',
            'heroSubtitleScale'
        ));
    }

    private function heroTypographyScale(string $locale): array
    {
        if ($locale === 'ka') {
            return [
                'text-[21px] md:text-[28px] lg:text-[36px]',
                'text-[14px] md:text-[16px]',
            ];
        }

        return [
            'text-[22px] md:text-[32px] lg:text-[42px]',
            'text-[15px] md:text-[17px]',
        ];
    }
}
