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
        'hero_primary_cta' => [
            'en' => 'Custom Hero Primary',
            'ka' => 'მორგებული hero primary',
        ],
        'hero_secondary_cta' => [
            'en' => 'Custom Hero Secondary',
            'ka' => 'მორგებული hero secondary',
        ],
        'hero_visual_label' => [
            'en' => 'Custom hero visual label',
            'ka' => 'მორგებული hero visual label',
        ],
        'hero_visual_point' => [
            'en' => 'Custom hero visual point',
            'ka' => 'მორგებული hero visual point',
        ],
        'hero_slide_label' => [
            'en' => 'Panel',
            'ka' => 'პანელი',
        ],
        'hero_slide_announcement' => [
            'en' => 'Panel :current of :total',
            'ka' => 'პანელი :current / :total',
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
        'floating_cta_title' => [
            'en' => 'Custom floating CTA',
            'ka' => 'მორგებული floating CTA',
        ],
        'floating_cta_primary' => [
            'en' => 'Custom floating button',
            'ka' => 'მორგებული floating button',
        ],
    ]);

    HeroSlide::create([
        'sort_order' => 1,
        'title' => ['en' => 'Hero Slide Title', 'ka' => 'Hero Slide Title'],
        'subtitle' => ['en' => 'Hero slide subtitle.', 'ka' => 'Hero slide subtitle.'],
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
        ->assertSeeText('Custom proof headline')
        ->assertSeeText('Custom Focus Value')
        ->assertSeeText('Hero slide subtitle.')
        ->assertSeeText('Custom Hero Primary')
        ->assertSeeText('Custom Hero Secondary')
        ->assertSeeText('Custom hero visual label')
        ->assertSeeText('Custom hero visual point')
        ->assertSeeText('Custom solutions title')
        ->assertSeeText('Custom CTA Title')
        ->assertSeeText('Featured Service')
        ->assertSeeText('Hero Slide Title')
        ->assertSeeText('Custom floating CTA')
        ->assertSeeText('Custom floating button');
});
