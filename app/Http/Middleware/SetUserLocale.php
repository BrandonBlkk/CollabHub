<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetUserLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $preferredLanguage = strtolower((string) ($request->user()?->settings?->language ?? 'en')); // EN, En, eN => en
        $locale = in_array($preferredLanguage, ['en', 'my'], true) ? $preferredLanguage : 'en';

        app()->setLocale($locale);

        return $next($request);
    }
}
