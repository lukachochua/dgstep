<?php

use App\Models\AboutPage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('about page renders editable singleton copy and management members', function () {
    app()->setLocale('en');

    AboutPage::singleton()->update([
        'title' => [
            'en' => 'Custom About Title',
            'ka' => 'მორგებული ჩვენს შესახებ სათაური',
        ],
        'who_heading' => [
            'en' => 'Custom About Heading',
            'ka' => 'მორგებული ჩვენს შესახებ სათაური',
        ],
        'who_paragraph_1' => [
            'en' => 'Custom paragraph one.',
            'ka' => 'მორგებული პირველი აბზაცი.',
        ],
        'who_paragraph_2' => [
            'en' => 'Custom paragraph two.',
            'ka' => 'მორგებული მეორე აბზაცი.',
        ],
        'mission_label' => [
            'en' => 'Custom Mission Label',
            'ka' => 'მორგებული მისიის ლეიბლი',
        ],
        'mission_heading' => [
            'en' => 'Mission Headline',
            'ka' => 'მისიის სათაური',
        ],
        'mission_description' => [
            'en' => 'Mission description copy.',
            'ka' => 'მისიის აღწერა.',
        ],
        'vision_label' => [
            'en' => 'Custom Vision Label',
            'ka' => 'მორგებული ხედვის ლეიბლი',
        ],
        'vision_heading' => [
            'en' => 'Vision Headline',
            'ka' => 'ხედვის სათაური',
        ],
        'vision_description' => [
            'en' => 'Vision description copy.',
            'ka' => 'ხედვის აღწერა.',
        ],
        'management_heading' => [
            'en' => 'Leadership Team',
            'ka' => 'ლიდერობის გუნდი',
        ],
        'management_view_all' => [
            'en' => 'View all leaders',
            'ka' => 'ყველა ლიდერის ნახვა',
        ],
        'management_collapse' => [
            'en' => 'Hide leaders',
            'ka' => 'ლიდერების დამალვა',
        ],
        'badges' => [
            'en' => ['Custom badge one', 'Custom badge two'],
            'ka' => ['მორგებული ბეჯი ერთი', 'მორგებული ბეჯი ორი'],
        ],
        'hero_image_url' => 'https://example.com/about.jpg',
        'hero_image_alt' => [
            'en' => 'Custom about image alt',
            'ka' => 'მორგებული about alt',
        ],
        'hero_caption' => [
            'en' => 'Custom hero caption',
            'ka' => 'მორგებული ჰირო ქაფშენი',
        ],
        'management_members' => [
            [
                'name' => ['en' => 'Lead Person', 'ka' => 'ლიდერი'],
                'role' => ['en' => 'Founder', 'ka' => 'დამფუძნებელი'],
                'bio' => ['en' => 'Lead bio copy.', 'ka' => 'ლიდერის ბიო.'],
                'image_url' => 'https://example.com/lead.jpg',
            ],
            [
                'name' => ['en' => 'Second Person', 'ka' => 'მეორე'],
                'role' => ['en' => 'Operations', 'ka' => 'ოპერაციები'],
                'bio' => ['en' => 'Operations bio.', 'ka' => 'ოპერაციების ბიო.'],
                'image_url' => 'https://example.com/ops.jpg',
            ],
            [
                'name' => ['en' => 'Third Person', 'ka' => 'მესამე'],
                'role' => ['en' => 'Compliance', 'ka' => 'კომპლაიანსი'],
                'bio' => ['en' => 'Compliance bio.', 'ka' => 'კომპლაიანსის ბიო.'],
                'image_url' => 'https://example.com/compliance.jpg',
            ],
            [
                'name' => ['en' => 'Fourth Person', 'ka' => 'მეოთხე'],
                'role' => ['en' => 'Engineering', 'ka' => 'ინჟინერია'],
                'bio' => ['en' => 'Engineering bio.', 'ka' => 'ინჟინერიის ბიო.'],
                'image_url' => 'https://example.com/engineering.jpg',
            ],
        ],
    ]);

    $response = $this->get(route('about'));

    $response
        ->assertOk()
        ->assertSeeText('Custom About Heading')
        ->assertSeeText('Custom paragraph one.')
        ->assertSeeText('Custom badge one')
        ->assertSeeText('Custom Mission Label')
        ->assertSeeText('Vision Headline')
        ->assertSeeText('Leadership Team')
        ->assertSeeText('View all leaders')
        ->assertSeeText('Lead Person')
        ->assertSeeText('Second Person')
        ->assertSeeText('Third Person')
        ->assertSeeText('Fourth Person');
});
