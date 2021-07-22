<?php

namespace App\Services\RolePermission;

use App\Models\Permission;
use Exception;
use App\Models\Role;

class RemoveRolePermissionService
{
    public function execute(array $request): Role
    {
        try {
            $role = Role::find($request["roleId"]);

            $permission = Permission::find($request["permissionId"]);
            $role->detachPermission($permission);

            return $role;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
