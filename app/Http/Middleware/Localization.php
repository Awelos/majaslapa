<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class Localization
{
    public function handle($request, Closure $next)
    {
        $locale = $request->getPreferredLanguage(['lv', 'en']);

        Log::info('Detected locale: ' . $locale);

        App::setLocale($locale ?? config('app.locale'));

        return $next($request);
    }
}
