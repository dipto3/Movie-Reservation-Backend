<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\Permission;
use Illuminate\Support\Collection;

class AuthService
{
    const ERROR_SOMETHING_WAS_WRONG = 'Something was wrong!';

    public function loginWithEmail(array $data): array
    {
        if (auth('admin')->attempt(['email' => $data['email'], 'password' => $data['password'], 'is_active' => true])) {
            $admin = auth('admin')->user();

            return [
                'data' => $this->setCredential($admin),
                'message' => 'Successfully logged in',
            ];
        }
        throw new ApiException('Credential did not match!', 404);
    }

    public function logout(): string
    {
        auth('admin-api')->user()->token()->revoke();

        return 'Successfully logged out.';
    }

    private function setCredential(object $admin): array
    {
        $data = [];
        $data['role'] = $admin->role?->name;
        $data['name'] = $admin->name;
        $data['email'] = $admin->email;
        $data['image'] = $admin->image ? asset($admin->image) : asset('seeder-images/S-Admin.png');
        $data['token'] = $admin->createToken('tokenName', ['admin'])->accessToken;

        return $data;
    }

    public function check(): bool
    {
        if (auth('admin-api')->check()) {
            return true;
        }

        return false;
    }

    public function permissions(): Collection
    {
        return Permission::whereHas('roles', function ($q) {
            $q->where('permission_role.role_id', auth('admin-api')->user()->role_id);
        })->select('slug')->get();
    }
}
