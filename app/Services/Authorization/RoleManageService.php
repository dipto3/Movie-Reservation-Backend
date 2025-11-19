<?php

namespace App\Services\Authorization;

use App\Exceptions\ApiException;
use App\Models\PermissionGroup;
use App\Models\Role;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class RoleManageService
{
    const SWW = "Something was wrong!";

    public function getRoles(array $data): LengthAwarePaginator
    {
        return Role::with(['createdBy:id,name,created_at'])
            ->withCount('permissions')
            ->DataSearch($data)
            ->orderBy('id', 'DESC')
            ->paginate($data['paginate'] ?? config('app.paginate'));
    }

    public function storeRole(array $data): Role
    {
        DB::beginTransaction();
        try {
            $role = Role::create($data);
            $role->load('createdBy:id,name,created_at');
            $role->permissions()->sync($data['permissions']);
            $role->permissions_count = count(array_unique($data['permissions']));
            DB::commit();
            return $role;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception(self::SWW, 500);
        }
    }

    public function getRole($role): Role
    {
        $role->permission_id = $role->permissions()->pluck('permissions.id');
        return $role;
    }

    public function updateRole(array $data, $role): Role
    {
        DB::beginTransaction();
        try {
            $role->update($data);
            if ($role->deletable) {
                $role->permissions()->sync($data['permissions']);
            } else {
                $role->permissions()->syncWithoutDetaching($data['permissions']);
            }
            $role->load('createdBy:id,name,created_at');
            $role->permissions_count = count(array_unique($data['permissions']));
            DB::commit();
            return $role;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception(self::SWW, 500);
        }
    }

    public function deleteRole($role): string
    {
        if (!$role->deletable) {
            throw new ApiException("Could not delete!", 403);
        }
        $role->delete();
        return "Successfully deleted.";
    }

    public function getPermissions(): Collection
    {
        return PermissionGroup::with('permissions:id,permission_group_id,name')->select('id', 'name')->get();
    }

    public function getActiveRoles(): Collection
    {
        $role = Role::where('is_active', true)->where('id', '!=', 1)->where('deletable', true)->select('id', 'name')->get();
        return $role;
    }
}
