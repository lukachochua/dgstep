<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AboutPageController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\ProjectsPageController;
use App\Http\Controllers\ServicesPageController;
use App\Models\AboutPage;
use App\Models\ContactPage;
use App\Models\HeroSlide;
use App\Models\HomePage;
use App\Models\ProjectsPage;
use App\Models\Service;
use App\Models\ServicesPage;
use Illuminate\Support\Carbon;


// Standard Routes

Route::get('/', [HeroController::class, 'index'])->name('home');

Route::get('/sitemap.xml', function () {
    $defaultLocale = in_array(config('app.locale'), ['ka', 'en'], true)
        ? config('app.locale')
        : 'ka';
    $staticLastModified = fn (array $paths): Carbon => collect($paths)
        ->filter(fn (string $path): bool => file_exists($path))
        ->map(fn (string $path): Carbon => Carbon::createFromTimestamp(filemtime($path)))
        ->max() ?? now();
    $sourceLastModified = $staticLastModified([base_path('routes/web.php')]);
    $latestLastModified = fn (array $timestamps): string => (
        collect($timestamps)
            ->filter()
            ->map(fn ($timestamp): Carbon => $timestamp instanceof Carbon ? $timestamp : Carbon::parse($timestamp))
            ->max() ?? $sourceLastModified
    )->toAtomString();

    $pages = collect([
        [
            'route' => 'home',
            'priority' => '1.0',
            'changefreq' => 'weekly',
            'lastmod' => $latestLastModified([
                HomePage::query()->max('updated_at'),
                HeroSlide::query()->max('updated_at'),
                Service::query()->where('is_featured', true)->max('updated_at'),
            ]),
        ],
        [
            'route' => 'services',
            'priority' => '0.9',
            'changefreq' => 'weekly',
            'lastmod' => $latestLastModified([
                ServicesPage::query()->max('updated_at'),
                Service::query()->max('updated_at'),
            ]),
        ],
        [
            'route' => 'projects',
            'priority' => '0.8',
            'changefreq' => 'monthly',
            'lastmod' => $latestLastModified([ProjectsPage::query()->max('updated_at')]),
        ],
        [
            'route' => 'about',
            'priority' => '0.7',
            'changefreq' => 'monthly',
            'lastmod' => $latestLastModified([AboutPage::query()->max('updated_at')]),
        ],
        [
            'route' => 'contact',
            'priority' => '0.7',
            'changefreq' => 'monthly',
            'lastmod' => $latestLastModified([ContactPage::query()->max('updated_at')]),
        ],
        [
            'route' => 'terms',
            'priority' => '0.3',
            'changefreq' => 'yearly',
            'lastmod' => $staticLastModified([
                resource_path('views/pages/terms.blade.php'),
                lang_path('en/terms.php'),
                lang_path('ka/terms.php'),
            ])->toAtomString(),
        ],
    ])->map(fn (array $page): array => [
        ...$page,
        'url' => route($page['route']),
        'alternates' => [
            'ka' => route($page['route']) . '?locale=ka',
            'en' => route($page['route']) . '?locale=en',
        ],
    ]);

    return response()
        ->view('sitemap', [
            'pages' => $pages,
            'defaultLocale' => $defaultLocale,
        ])
        ->header('Content-Type', 'application/xml');
})->name('sitemap');


Route::get('/about', AboutPageController::class)->name('about');

Route::get('/services', ServicesPageController::class)->name('services');

Route::get('/projects', ProjectsPageController::class)->name('projects');


Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/logout', function () {
    return view('auth.logout');
})->name('logout');

Route::get('/pw2', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::get('/pw1', function () {
    return view('auth.reset-password');
})->name('password.reset');

Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');



Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'show'])->name('contact');
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');



// Set Locale

Route::post('/locale', function (Request $request) {
    $request->validate([
        'locale' => 'required|in:en,ka',
    ]);

    session(['locale' => $request->get('locale')]);

    return back();
})->name('locale.switch');
