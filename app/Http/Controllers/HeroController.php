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
            ->values()
            ->map(function (HeroSlide $slide, int $index) use ($locale) {
                $fallbacks = [
                    0 => ['route' => 'services', 'label' => __('messages.services', [], $locale)],
                    1 => ['route' => 'contact', 'label' => __('contact.cta_button', [], $locale)],
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
                $fallbackLabel = $fallback['label'] ?? trans('messages.footer.cta', [], $locale);
                $defaultContactLabel = trans('contact.cta_button', [], $locale);

                if (blank($manualText)) {
                    $buttonText = $fallbackLabel;
                } elseif (($fallback['label'] ?? null) && $manualText === $defaultContactLabel && $fallbackLabel !== $defaultContactLabel) {
                    // Preserve older data that still uses the Contact label when route-specific copy is expected.
                    $buttonText = $fallbackLabel;
                } else {
                    $buttonText = $manualText;
                }

                return [
                    'title'       => $slide->getTranslation('title', $locale),
                    'highlight'   => $slide->getTranslation('highlight', $locale),
                    'subtitle'    => $slide->getTranslation('subtitle', $locale),
                    'button'      => [
                        'text' => $buttonText,
                        'href' => $resolvedHref,
                        'link' => $resolvedHref,
                    ],
                    'button_href' => $resolvedHref,
                    'button_text' => $buttonText,
                    'image'       => $slide->image_url,
                    'media'       => $slide->media_urls,
                ];
            })
            ->values()
            ->all();

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
