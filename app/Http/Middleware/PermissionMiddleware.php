<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        $method = $request->method();
        switch ($method) {
            case 'GET':
                $permission .= '.access';
                break;
            case 'POST':
                $permission .= '.create';
                break;
            case 'PUT':
            case 'PATCH':
                $permission .= '.edit';
                break;
            case 'DELETE':
                $permission .= '.destroy';
                break;
            default:
                return $this->errorMessage();
        }

        if (!auth()->user()->check($permission)) {
            return $this->errorMessage();
        }

        return $next($request);
    }

    public function errorMessage()
    {
        return response()->json([
            'error' => 'Authorization failed.'
        ], 403);
    }
}
