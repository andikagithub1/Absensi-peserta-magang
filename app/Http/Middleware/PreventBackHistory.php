<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventBackHistory
{
    /**
     * Handle an incoming request.
     * Prevent browser back button from showing cached pages.
     * Used for protected pages that shouldn't be accessible via back button.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only add no-cache headers, don't invalidate session
        return $response
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate, private')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
