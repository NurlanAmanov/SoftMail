<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Əgər istifadəçi login olmayıbsa
        if (!Auth::check()) {
            // Login səhifəsinə yönləndir və xəbərdarlıq mesajı göndər
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        // Admin olmayan istifadəçiləri 403 səhifəsinə yönləndir
        if (Auth::user()->role !== 'admin') {
            return abort(403, 'You are not authorized to access this page.');
        }

        // Admin olduqda, istək növbəti middleware-inə ötürülür
        return $next($request);
    }
}
