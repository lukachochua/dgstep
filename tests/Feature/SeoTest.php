<?php

use App\Models\Service;
use App\Models\ServicesPage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class);

test('public pages render page level seo metadata and structured data', function () {
    app()->setLocale('en');

    $response = $this->get(route('home'));

    $response->assertOk();

    $html = $response->getContent();

    expect($html)
        ->toContain('<meta name="description"')
        ->toContain('<meta property="og:site_name" content="DGstep"')
        ->toContain('<meta property="og:title"')
        ->toContain('<link rel="canonical" href="' . route('home') . '"')
        ->toContain('hreflang="ka"')
        ->toContain('hreflang="en"')
        ->toContain('application/ld+json')
        ->toContain('"@type":"Organization"')
        ->toContain('"@type":"WebSite"')
        ->toContain('"@type":"WebPage"')
        ->toContain('"addressCountry":"GE"')
        ->toContain('"areaServed":{"@type":"Country","name":"Georgia"}');
});

test('services page exposes service schema from service records', function () {
    app()->setLocale('en');

    ServicesPage::singleton()->update([
        'title' => ['en' => 'Service SEO Page', 'ka' => 'სერვისების SEO გვერდი'],
        'overview_heading' => ['en' => 'Available service modules', 'ka' => 'ხელმისაწვდომი მოდულები'],
        'overview_body' => ['en' => 'Service page lead for search snippets.', 'ka' => 'სერვისების გვერდის აღწერა.'],
    ]);

    Service::create([
        'name' => ['en' => 'Warehouse Management', 'ka' => 'საწყობის მართვა'],
        'description' => [
            'en' => 'Control warehouse orders, stock movements, and fulfillment in one platform.',
            'ka' => 'მართეთ საწყობის შეკვეთები, მარაგი და გაცემა ერთ პლატფორმაში.',
        ],
        'description_expanded' => ['en' => '<p>Expanded.</p>', 'ka' => '<p>გაფართოებული.</p>'],
        'problems' => ['en' => ['Stock mistakes'], 'ka' => ['მარაგის შეცდომები']],
        'slug' => 'warehouse-management',
        'image_path' => 'https://example.com/warehouse.jpg',
        'image_alt' => 'Warehouse management interface',
        'is_featured' => true,
        'featured_order' => 1,
        'display_order' => 1,
    ]);

    $html = $this->get(route('services'))->assertOk()->getContent();

    expect($html)
        ->toContain('Service page lead for search snippets.')
        ->toContain('"@type":"CollectionPage"')
        ->toContain('"@type":"ItemList"')
        ->toContain('"@type":"Service"')
        ->toContain('"name":"Warehouse Management"');
});

test('sitemap lists public pages with locale alternates', function () {
    config(['app.locale' => 'ka']);
    $pageUpdatedAt = Carbon::parse('2026-05-01 10:00:00');
    $serviceUpdatedAt = Carbon::parse('2026-06-15 12:30:00');

    ServicesPage::singleton()->forceFill([
        'updated_at' => $pageUpdatedAt,
    ])->save();

    $service = Service::create([
        'name' => ['en' => 'Warehouse Management', 'ka' => 'საწყობის მართვა'],
        'description' => [
            'en' => 'Control warehouse orders, stock movements, and fulfillment in one platform.',
            'ka' => 'მართეთ საწყობის შეკვეთები, მარაგი და გაცემა ერთ პლატფორმაში.',
        ],
        'description_expanded' => ['en' => '<p>Expanded.</p>', 'ka' => '<p>გაფართოებული.</p>'],
        'problems' => ['en' => ['Stock mistakes'], 'ka' => ['მარაგის შეცდომები']],
        'slug' => 'warehouse-management',
        'image_path' => 'https://example.com/warehouse.jpg',
        'image_alt' => 'Warehouse management interface',
        'is_featured' => false,
        'featured_order' => 1,
        'display_order' => 1,
    ]);

    $service->forceFill([
        'updated_at' => $serviceUpdatedAt,
    ])->save();

    $response = $this->get(route('sitemap'));

    $response
        ->assertOk()
        ->assertHeader('Content-Type', 'application/xml');

    $xml = $response->getContent();

    expect($xml)
        ->toContain('<urlset')
        ->toContain(route('home'))
        ->toContain(route('services'))
        ->toContain(route('projects'))
        ->toContain(route('about'))
        ->toContain(route('contact'))
        ->toContain(route('terms'))
        ->toContain('hreflang="ka"')
        ->toContain('hreflang="en"')
        ->toContain('hreflang="x-default" href="' . route('home') . '?locale=ka"')
        ->toContain('<loc>' . route('services') . '</loc>')
        ->toContain('<lastmod>' . $serviceUpdatedAt->toAtomString() . '</lastmod>');
});
