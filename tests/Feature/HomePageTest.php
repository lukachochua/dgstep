<?php

use App\Models\HomePage;
use App\Models\HeroSlide;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('home page renders editable home copy while keeping featured services data-driven', function () {
    app()->setLocale('en');

    HomePage::singleton()->update([
        'title' => [
            'en' => 'Custom Home Title',
            'ka' => 'მორგებული მთავარი სათაური',
        ],
        'hero_kicker' => [
            'en' => 'Custom Hero Kicker',
            'ka' => 'მორგებული ჰირო ქიქერი',
        ],
        'hero_secondary_cta' => [
            'en' => 'Custom Hero CTA',
            'ka' => 'მორგებული გმირის CTA',
        ],
        'hero_slide_label' => [
            'en' => 'Panel',
            'ka' => 'პანელი',
        ],
        'hero_slide_announcement' => [
            'en' => 'Panel :current of :total',
            'ka' => 'პანელი :current / :total',
        ],
        'hero_audiences_label' => [
            'en' => 'Custom Audiences',
            'ka' => 'მორგებული აუდიტორიები',
        ],
        'hero_audiences' => [
            'en' => ['Pawn teams', 'Operations leads'],
            'ka' => ['ლომბარდის გუნდები', 'ოპერაციების ლიდერები'],
        ],
        'hero_visual_card_kicker' => [
            'en' => 'Custom Improvements',
            'ka' => 'მორგებული გაუმჯობესებები',
        ],
        'hero_visual_points' => [
            'en' => [
                ['label' => 'Visibility', 'value' => 'Custom dashboard clarity.'],
            ],
            'ka' => [
                ['label' => 'ხილვადობა', 'value' => 'მორგებული დაფის სიცხადე.'],
            ],
        ],
        'hero_image_alt' => [
            'en' => 'Custom hero image alt',
            'ka' => 'მორგებული alt ტექსტი',
        ],
        'proof_kicker' => [
            'en' => 'Custom Proof Kicker',
            'ka' => 'მორგებული proof kicker',
        ],
        'proof_title' => [
            'en' => 'Custom proof headline',
            'ka' => 'მორგებული proof headline',
        ],
        'proof_subtitle' => [
            'en' => 'Custom proof subtitle.',
            'ka' => 'მორგებული proof subtitle.',
        ],
        'metric_focus_label' => [
            'en' => 'Custom Focus Label',
            'ka' => 'მორგებული ფოკუსის ლეიბლი',
        ],
        'metric_focus_value' => [
            'en' => 'Custom Focus Value',
            'ka' => 'მორგებული ფოკუსის მნიშვნელობა',
        ],
        'metric_focus_description' => [
            'en' => 'Custom focus description.',
            'ka' => 'მორგებული ფოკუსის აღწერა.',
        ],
        'metric_technology_label' => [
            'en' => 'Custom Tech Label',
            'ka' => 'მორგებული ტექნოლოგიის ლეიბლი',
        ],
        'metric_technology_value' => [
            'en' => 'Custom Tech Value',
            'ka' => 'მორგებული ტექნოლოგიის მნიშვნელობა',
        ],
        'metric_technology_description' => [
            'en' => 'Custom tech description.',
            'ka' => 'მორგებული ტექნოლოგიის აღწერა.',
        ],
        'metric_approach_label' => [
            'en' => 'Custom Approach Label',
            'ka' => 'მორგებული მიდგომის ლეიბლი',
        ],
        'metric_approach_value' => [
            'en' => 'Custom Approach Value',
            'ka' => 'მორგებული მიდგომის მნიშვნელობა',
        ],
        'metric_approach_description' => [
            'en' => 'Custom approach description.',
            'ka' => 'მორგებული მიდგომის აღწერა.',
        ],
        'solutions_kicker' => [
            'en' => 'Custom Solutions Kicker',
            'ka' => 'მორგებული solutions kicker',
        ],
        'solutions_title' => [
            'en' => 'Custom solutions title',
            'ka' => 'მორგებული solutions title',
        ],
        'solutions_subtitle' => [
            'en' => 'Custom solutions subtitle.',
            'ka' => 'მორგებული solutions subtitle.',
        ],
        'cta_kicker' => [
            'en' => 'Custom CTA Kicker',
            'ka' => 'მორგებული CTA kicker',
        ],
        'cta_title' => [
            'en' => 'Custom CTA Title',
            'ka' => 'მორგებული CTA სათაური',
        ],
        'cta_subtitle' => [
            'en' => 'Custom CTA subtitle.',
            'ka' => 'მორგებული CTA subtitle.',
        ],
        'cta_primary' => [
            'en' => 'Custom CTA Primary',
            'ka' => 'მორგებული CTA primary',
        ],
        'cta_secondary' => [
            'en' => 'Custom CTA Secondary',
            'ka' => 'მორგებული CTA secondary',
        ],
    ]);

    HeroSlide::create([
        'title' => ['en' => 'Hero Slide Title', 'ka' => 'Hero Slide Title'],
        'highlight' => ['en' => 'Hero Highlight', 'ka' => 'Hero Highlight'],
        'subtitle' => ['en' => 'Hero slide subtitle.', 'ka' => 'Hero slide subtitle.'],
        'button_text' => ['en' => 'Hero Button', 'ka' => 'Hero Button'],
        'link_type' => 'internal',
        'button_route' => 'contact',
        'button_params' => [],
        'button_link' => '/contact',
        'button_url' => null,
        'image_path' => null,
    ]);

    Service::create([
        'name' => ['en' => 'Featured Service', 'ka' => 'Featured Service'],
        'description' => ['en' => 'Featured service description.', 'ka' => 'Featured service description.'],
        'description_expanded' => ['en' => '<p>Expanded.</p>', 'ka' => '<p>Expanded.</p>'],
        'problems' => ['en' => ['One'], 'ka' => ['ერთი']],
        'slug' => 'featured-service',
        'image_path' => 'https://example.com/service.jpg',
        'image_alt' => 'Featured service image',
        'is_featured' => true,
        'featured_order' => 1,
        'display_order' => 1,
        'cue_style' => 'bubbles',
        'cue_label' => ['en' => 'Fit', 'ka' => 'Fit'],
        'cue_values' => [80, 60],
    ]);

    $response = $this->get(route('home'));

    $response
        ->assertOk()
        ->assertSeeText('Custom Hero Kicker')
        ->assertSeeText('Custom Hero CTA')
        ->assertSeeText('Custom proof headline')
        ->assertSeeText('Custom Focus Value')
        ->assertSeeText('Custom solutions title')
        ->assertSeeText('Custom CTA Title')
        ->assertSeeText('Featured Service')
        ->assertSeeText('Hero Slide Title');
});
