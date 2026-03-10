<?php

use App\Models\ProjectsPage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('projects page renders editable projects page copy and cards', function () {
    app()->setLocale('en');

    ProjectsPage::singleton()->update([
        'title' => [
            'en' => 'Custom Projects Title',
            'ka' => 'მორგებული პროექტების სათაური',
        ],
        'hero_kicker' => [
            'en' => 'Custom Projects Kicker',
            'ka' => 'მორგებული პროექტების ქიქერი',
        ],
        'hero_title' => [
            'en' => 'Custom Projects Headline',
            'ka' => 'მორგებული პროექტების სათაური',
        ],
        'hero_lead' => [
            'en' => 'Custom projects lead copy.',
            'ka' => 'მორგებული პროექტების ტექსტი.',
        ],
        'proof_heading' => [
            'en' => 'Custom Projects Proof',
            'ka' => 'მორგებული პროექტების დამადასტურებელი სათაური',
        ],
        'proof_body' => [
            'en' => 'Custom projects proof body.',
            'ka' => 'მორგებული პროექტების proof ტექსტი.',
        ],
        'proof_items' => [
            'en' => ['Custom chip one', 'Custom chip two'],
            'ka' => ['მორგებული ჩიპი ერთი', 'მორგებული ჩიპი ორი'],
        ],
        'project_cards' => [
            [
                'title' => [
                    'en' => 'Custom Project One',
                    'ka' => 'მორგებული პროექტი ერთი',
                ],
                'description' => [
                    'en' => 'Custom project one description.',
                    'ka' => 'მორგებული პირველი პროექტის აღწერა.',
                ],
                'image_url' => 'https://example.com/project-1.jpg',
            ],
            [
                'title' => [
                    'en' => 'Custom Project Two',
                    'ka' => 'მორგებული პროექტი ორი',
                ],
                'description' => [
                    'en' => 'Custom project two description.',
                    'ka' => 'მორგებული მეორე პროექტის აღწერა.',
                ],
                'image_url' => 'https://example.com/project-2.jpg',
            ],
        ],
        'cta_heading' => [
            'en' => 'Custom CTA Heading',
            'ka' => 'მორგებული CTA სათაური',
        ],
        'cta_description' => [
            'en' => 'Custom CTA description.',
            'ka' => 'მორგებული CTA აღწერა.',
        ],
        'cta_label' => [
            'en' => 'Custom CTA Label',
            'ka' => 'მორგებული CTA ლეიბლი',
        ],
    ]);

    $response = $this->get(route('projects'));

    $response
        ->assertOk()
        ->assertSeeText('Custom Projects Kicker')
        ->assertSeeText('Custom Projects Headline')
        ->assertSeeText('Custom Projects Proof')
        ->assertSeeText('Custom chip one')
        ->assertSeeText('Custom Project One')
        ->assertSeeText('Custom Project Two')
        ->assertSeeText('Custom CTA Heading')
        ->assertSeeText('Custom CTA Label');
});
