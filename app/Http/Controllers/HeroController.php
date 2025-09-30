<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Vite;


class HeroController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::all()->map(function ($slide) {
            return [
                'title'     => $slide->getTranslation('title', app()->getLocale()),
                'highlight' => $slide->getTranslation('highlight', app()->getLocale()),
                'subtitle'  => $slide->getTranslation('subtitle', app()->getLocale()),
                'button'    => [
                    'text' => $slide->getTranslation('button_text', app()->getLocale()),
                    'link' => $slide->button_link,
                ],
                // keep using static images for now
                'image'     => 'https://images.unsplash.com/photo-1499428665502-503f6c608263?q=80&w=1800&auto=format&fit=crop',
            ];
        });

        $media = [
            Vite::asset('resources/images/brand/hero_image.png'),
            Vite::asset('resources/images/brand/hero_image_2.png'),
            Vite::asset('resources/images/brand/hero_image_3.png'),
        ];

        return view('pages.home', compact('slides', 'media'));
    }
}
