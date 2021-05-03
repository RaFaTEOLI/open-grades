<?php

namespace App\Repositories\PermissionRepository;

use App\Models\Permission;
use App\Repositories\RolesRepository\RolesRepository;
use App\Repositories\RedisRepository\RedisRepository;

class PermissionRepository implements PermissionRepositoryInterface
{
    /**
     * Fetch All
     *
     * @return Permission
     */
    public function all()
    {
        $permissions = (new RedisRepository())->all("permissions");

        if (empty($permissions)) {
            return Permission::all();
        }

        return $permissions;
    }

    /**
     * Fetch All Permissions that the specific role doesn't have
     *
     * @return Permission
     */
    public function findPermissionsNotInRole($roleId)
    {
        $role = (new RolesRepository())->findById($roleId);
        $rolePermissions = [];
        foreach ($role->permissions as $permission) {
            array_push($rolePermissions, $permission->id);
        }

        return Permission::whereNotIn("id", $rolePermissions)->get();
    }

    public function store(array $request)
    {
        $permissionCreated = Permission::create($request);

        (new RedisRepository())->set("permissions", $this->all()->map->format());

        return $permissionCreated;
    }

    /**
     * Get By Id
     *
     * @return Permission
     * @param integer $id
     */
    public function findById($id)
    {
        $permission = (new RedisRepository())->findById("permissions", $id);

        if (empty($permission)) {
            return Permission::find($id);
        }

        return $permission;
    }

    /**
     * Update
     *
     * @return Boolean
     * @param integer $id
     * @param array $set
     */
    public function update($id, $set)
    {
        $obj = Permission::where("id", $id)->first();

        $obj->update($set);

        (new RedisRepository())->invalidate("permissions");

        return $obj;
    }

    /**
     * Delete
     *
     * @return Boolean
     * @param integer $id
     */
    public function delete($id)
    {
        Permission::where("id", $id)->delete();
        (new RedisRepository())->invalidate("permissions");

        return true;
    }
}
