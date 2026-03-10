<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AboutPageController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\ProjectsPageController;
use App\Http\Controllers\ServicesPageController;


// Standard Routes

Route::get('/', [HeroController::class, 'index'])->name('home');


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
