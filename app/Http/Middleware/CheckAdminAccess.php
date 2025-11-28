<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminAccess
{
    /**
     * Handle an incoming request.
     * Check admin access regardless of authentication status.
     * If not admin, return 403 (whether guest or wrong role).
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Not authenticated OR not admin role
        if (! $user || $user->role !== 'admin') {
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
