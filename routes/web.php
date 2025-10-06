<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HeroController;
use App\Models\AboutPage;
use App\Models\Service;
use App\Http\Controllers\ContactPageController;


// Standard Routes

Route::get('/', [HeroController::class, 'index'])->name('home');


Route::get('/about', function () {
    $aboutPage = AboutPage::singleton();
    $aboutDefaults = AboutPage::defaults();

    return view('pages.about', compact('aboutPage', 'aboutDefaults'));
})->name('about');

Route::get('/services', function () {
    return view('pages.services');
})->name('services');

Route::get('/projects', function () {
    return view('pages.projects');
})->name('projects');


Route::get('/contact', [ContactPageController::class, 'show'])->name('contact');
Route::post('/contact', [ContactPageController::class, 'submit'])->name('contact.submit');


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
