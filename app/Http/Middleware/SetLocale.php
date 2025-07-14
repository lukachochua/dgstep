<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // If user explicitly switched
        if ($request->has('locale') && in_array($request->get('locale'), ['en', 'ka'])) {
            session(['locale' => $request->get('locale')]);
        }

        // Default to session or config/app.php
        $locale = session('locale', config('app.locale'));
        App::setLocale($locale);

        return $next($request);
    }
}
