<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('admin-api')->check()) {
            return response()->json(['error' => 'Unauthenticated'], 403);
        }

        $admin = auth('admin-api')->user();
        if (!$admin->is_active) {
            auth('admin-api')->user()->token()->revoke();
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return $next($request);
    }
}
