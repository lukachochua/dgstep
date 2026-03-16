<?php

use App\Models\Service;
use App\Models\ServicesPage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('services page renders localized service content and cues', function () {
    app()->setLocale('en');

    ServicesPage::singleton()->update([
        'title' => [
            'en' => 'Custom Services Page',
            'ka' => 'მორგებული სერვისების გვერდი',
        ],
        'hero_kicker' => [
            'en' => 'Custom Kicker',
            'ka' => 'მორგებული ქიქერი',
        ],
        'hero_title' => [
            'en' => 'Editable hero title',
            'ka' => 'რედაქტირებადი ჰედერი',
        ],
        'hero_lead' => [
            'en' => 'Editable services lead copy.',
            'ka' => 'რედაქტირებადი წამყვანი ტექსტი.',
        ],
        'hero_primary_cta' => [
            'en' => 'Primary CTA',
            'ka' => 'პირველი CTA',
        ],
        'hero_secondary_cta' => [
            'en' => 'Secondary CTA',
            'ka' => 'მეორე CTA',
        ],
        'overview_heading' => [
            'en' => 'Overview Heading',
            'ka' => 'მიმოხილვის სათაური',
        ],
        'overview_body' => [
            'en' => 'Overview body copy.',
            'ka' => 'მიმოხილვის ტექსტი.',
        ],
        'proof_heading' => [
            'en' => 'Proof Heading',
            'ka' => 'დამადასტურებელი სათაური',
        ],
        'proof_body' => [
            'en' => 'Proof body copy.',
            'ka' => 'დამადასტურებელი ტექსტი.',
        ],
        'proof_items' => [
            'en' => ['Editable proof chip'],
            'ka' => ['რედაქტირებადი ჩიპი'],
        ],
        'cta_kicker' => [
            'en' => 'CTA Kicker',
            'ka' => 'CTA ქიქერი',
        ],
        'cta_heading' => [
            'en' => 'CTA Heading',
            'ka' => 'CTA სათაური',
        ],
        'cta_body' => [
            'en' => 'CTA body copy.',
            'ka' => 'CTA ტექსტი.',
        ],
        'cta_primary' => [
            'en' => 'Contact now',
            'ka' => 'დაგვიკავშირდით',
        ],
        'cta_secondary' => [
            'en' => 'Back up',
            'ka' => 'ზემოთ',
        ],
    ]);

    Service::create([
        'name' => [
            'en' => 'Pawnshop Operations',
            'ka' => 'ლომბარდის ოპერაციები',
        ],
        'description' => [
            'en' => 'Streamline renewals, redemptions, and inventory in one place.',
            'ka' => 'განახლებები, ამოღებები და მარაგი ერთ სისტემაში.',
        ],
        'description_expanded' => [
            'en' => '<p>Detailed service copy.</p>',
            'ka' => '<p>დეტალური აღწერა.</p>',
        ],
        'problems' => [
            'en' => ['Lost pawn tickets', 'Manual inventory mistakes'],
            'ka' => ['დაკარგული ბილეთები', 'მარაგის ხელით შეცდომები'],
        ],
        'slug' => 'pawnshop',
        'image_path' => 'https://example.com/pawnshop.jpg',
        'image_alt' => 'Pawnshop dashboard',
        'is_featured' => true,
        'featured_order' => 1,
        'display_order' => 1,
        'cue_label' => [
            'en' => 'Ops Coverage',
            'ka' => 'ოპერაციები',
        ],
    ]);

    Service::create([
        'name' => [
            'en' => 'Compliance & Reporting',
            'ka' => 'შესაბამისობა და რეპორტინგი',
        ],
        'description' => [
            'en' => 'Keep audit trails and export-ready reporting in sync.',
            'ka' => 'აუდიტის ლოგები და ანგარიშგება სინქრონიზებულია.',
        ],
        'description_expanded' => [
            'en' => '<p>Audit-ready workflows.</p>',
            'ka' => '<p>აუდიტისთვის მზა პროცესები.</p>',
        ],
        'problems' => [
            'en' => ['Paper reporting', 'Unlogged employee activity'],
            'ka' => ['ქაღალდზე ანგარიშგება', 'არალოგირებული ქმედებები'],
        ],
        'slug' => 'compliance',
        'image_path' => 'https://example.com/compliance.jpg',
        'image_alt' => 'Compliance logs',
        'is_featured' => false,
        'featured_order' => 0,
        'display_order' => 2,
        'cue_label' => [
            'en' => 'Audit Ready',
            'ka' => 'აუდიტი',
        ],
    ]);

    $response = $this->get(route('services'));

    $response
        ->assertOk()
        ->assertSeeText('Editable hero title')
        ->assertSeeText('Editable proof chip')
        ->assertSeeText('Pawnshop Operations')
        ->assertSeeText('Ops Coverage')
        ->assertSeeText('Lost pawn tickets')
        ->assertSeeText('Compliance & Reporting')
        ->assertSeeInOrder(['Pawnshop Operations', 'Compliance & Reporting']);
});
