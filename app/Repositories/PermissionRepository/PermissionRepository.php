<?php

namespace App\Repositories\PermissionRepository;

use App\Models\Permission;
use App\Repositories\RolesRepository\RolesRepository;
use App\Repositories\RedisRepository\RedisRepository;
use Exception;
use Illuminate\Support\Collection;

class PermissionRepository implements PermissionRepositoryInterface
{
    /**
     * Fetch All
     *
     * @return Permission
     */
    public function all(): Collection
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
    public function findPermissionsNotInRole(int $roleId): Collection
    {
        try {
            $role = (new RolesRepository())->findById($roleId);
            $rolePermissions = [];
            foreach ($role->permissions as $permission) {
                array_push($rolePermissions, $permission->id);
            }

            return Permission::whereNotIn("id", $rolePermissions)->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function store(array $request): Permission
    {
        try {
            $permissionCreated = Permission::create($request);

            (new RedisRepository())->set("permissions", $this->all()->map->format());

            return $permissionCreated;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Get By Id
     *
     * @return Permission
     * @param integer $id
     */
    public function findById(int $id): Permission
    {
        try {
            $permission = (new RedisRepository())->findById("permissions", $id);

            if (empty($permission)) {
                return Permission::find($id);
            }

            return $permission;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Update
     *
     * @return Boolean
     * @param integer $id
     * @param array $set
     */
    public function update(int $id, array $set): Permission
    {
        try {
            $obj = Permission::where("id", $id)->first();

            $obj->update($set);

            (new RedisRepository())->invalidate("permissions");

            return $obj;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Delete
     *
     * @return Boolean
     * @param integer $id
     */
    public function delete(int $id): bool
    {
        try {
            Permission::where("id", $id)->delete();
            (new RedisRepository())->invalidate("permissions");

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
