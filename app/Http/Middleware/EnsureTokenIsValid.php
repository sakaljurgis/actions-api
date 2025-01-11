<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requestToken = $request->header('token') ?? $request->input('token');
        $token = env('API_AUTH_TOKEN');
        if (!$requestToken || !$token || $requestToken !== $token) {
            return (new JsonResponse(['error' => 'Unauthorized']))->setStatusCode(Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
