<?php

namespace App\Services\RolePermission;

use App\Models\Permission;
use Exception;
use App\Models\Role;

class UpdateRolePermissionService
{
    public function execute(array $request): object
    {
        try {
            $role = Role::findOrFail($request["roleId"]);
            if (!$role) {
                throw new Exception('Invalid Request');
            }

            $permission = Permission::findOrFail($request["permissionId"]);
            $role->attachPermission($permission);

            return $role->format();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
