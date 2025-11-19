<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authorization\RoleManageRequest;
use App\Http\Resources\Authorization\PermissionGroupResource;
use App\Http\Resources\Authorization\RoleManageResource;
use App\Models\Role;
use App\Services\Authorization\RoleManageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleManageController extends Controller
{
    protected RoleManageService $service;

    public function __construct(RoleManageService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection | JsonResponse
    {
        $roles = $this->service->getRoles($request->all());
        return RoleManageResource::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleManageRequest $request): JsonResponse
    {
        $role = $this->service->storeRole($request->validated());
        return successResponse(new RoleManageResource($role), "Successfully stored.", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): JsonResponse
    {
        $role = $this->service->getRole($role);
        return successResponse(new RoleManageResource($role));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleManageRequest $request, Role $role): JsonResponse
    {
        $role = $this->service->updateRole($request->validated(), $role);
        return successResponse(new RoleManageResource($role), "Successfully updated.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): JsonResponse
    {
        $this->service->deleteRole($role);
        return successResponse(new RoleManageResource($role), "Successfully deleted.");
    }

    /**
     * Get permission group wise permissions
     */
    public function groupWisePermissions(): JsonResponse
    {
        $permissions = $this->service->getPermissions();
        return successResponse(PermissionGroupResource::collection($permissions));
    }

    public function activeRoles(): ResourceCollection | JsonResponse
    {
        $roles = $this->service->getActiveRoles();
        return RoleManageResource::collection($roles);
    }
}
