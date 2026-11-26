<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Support\Facades\FilamentTimezone;
use Illuminate\Http\Request;

/**
 * The physiotherapy panel is always in Italian, whatever the website locale is,
 * and shows dates in the practice time zone (they are stored in UTC).
 */
class SetPanelLocale
{
    public function handle(Request $request, Closure $next)
    {
        app()->setLocale('it');
        FilamentTimezone::set(config('gestionale.timezone'));

        return $next($request);
    }
}
