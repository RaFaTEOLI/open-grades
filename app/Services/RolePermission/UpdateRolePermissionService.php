<?php

namespace App\Services\RolePermission;

use App\Models\Permission;
use Exception;
use App\Models\Role;

class UpdateRolePermissionService
{
    public function execute(array $request)
    {
        try {
            $role = Role::findOrFail($request["roleId"]);

            $permission = Permission::findOrFail($request["permissionId"]);
            $role->attachPermission($permission);

            return $role;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
