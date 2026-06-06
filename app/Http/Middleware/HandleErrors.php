<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class HandleErrors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (\Illuminate\Routing\Exceptions\UrlGenerationException $e) {
            // Route [login] not defined xəta mesajını yoxlayırıq
            if ($e->getMessage() === 'Route [login] not defined.') {
                return response()->view('errors.login_error'); // Burada error səhifəsinə yönləndiririk
            }

            // Digər xətaları idarə edirik
            return response()->view('errors.general_error');
        }
    }
}
