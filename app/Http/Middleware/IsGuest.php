<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsGuest
{
    /**
     * Handle an incoming request.
     * Prevent authenticated users from accessing auth pages (login/register).
     * Add no-cache headers to prevent back button access.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            return redirect('/dashboard');
        }

        $response = $next($request);

        // Prevent caching to avoid back button showing auth pages
        return $response
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate, private')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
