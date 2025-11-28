<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PembinaRole
{
    /**
     * Handle an incoming request.
     * Ensure only pembina users can access pembina-specific routes.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Verify user is authenticated and is pembina
        if (! $user || $user->role !== 'pembina') {
            if ($request->expectsJson()) {
                return response()->json(
                    ['message' => 'Ini bukan tempat anda'],
                    Response::HTTP_FORBIDDEN
                );
            }

            abort(403, 'Ini bukan tempat anda');
        }

        return $next($request);
    }
}
