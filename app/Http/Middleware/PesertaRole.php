<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PesertaRole
{
    /**
     * Handle an incoming request.
     * Ensure only peserta users can access peserta-specific routes.
     * Add no-cache headers to prevent back button access.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role !== 'peserta') {
            return redirect('/dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        $response = $next($request);

        // Prevent caching and back button access
        return $response
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate, private')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
