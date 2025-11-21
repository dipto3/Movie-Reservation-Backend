<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function login(AuthRequest $request): JsonResponse
    {
        $data = $this->service->loginWithEmail($request->validated());

        return response()->json($data, 200);
    }

    public function logout(): JsonResponse
    {
        $message = $this->service->logout();

        return response()->json([
            'message' => $message,
        ], 200);
    }

    public function check(): JsonResponse
    {
        $status = $this->service->check();

        return response()->json([
            'status' => $status,
        ], 200);
    }

    public function permissions(): JsonResponse
    {
        $permissions = $this->service->permissions();

        return response()->json([
            'permissions' => $permissions,
        ], 200);
    }
}
