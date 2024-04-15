<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiToken = config('auth.api_token');
        $barerToken = $request->bearerToken();
        if ($barerToken && $barerToken == $apiToken) {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
