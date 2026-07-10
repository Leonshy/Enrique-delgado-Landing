<?php

namespace App\Http\Middleware;

use App\Helpers\SettingsHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceModeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (SettingsHelper::get('maintenance_mode', '0') === '1') {
            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}
