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
     * This extends Laravel's built-in guest middleware with custom messaging.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            // Authenticated users attempting to access auth pages
            // Redirect them to dashboard
            return redirect('/dashboard')
                ->with('info', 'Anda sudah login. Silakan keluar terlebih dahulu untuk login dengan akun lain');
        }

        return $next($request);
    }
}
