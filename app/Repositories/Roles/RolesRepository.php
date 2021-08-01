<?php

namespace App\Repositories\Roles;

use App\Models\Role;
use App\Repositories\Roles\RolesRepositoryInterface;
use App\Repositories\User\UserRepository;
use Exception;
use Illuminate\Support\Collection;

class RolesRepository implements RolesRepositoryInterface
{
    /**
     * Fetch All
     *
     * @return Role
     */
    public function all(): Collection
    {
        return Role::all()->map->format();
    }

    /**
     * Fetch All without permissions
     *
     * @return Role
     */
    public function allWithoutPermissions(int $limit = 0, int $offset = 0): Collection
    {
        try {
            return Role::when($limit, function ($query, $limit) {
                return $query->limit($limit);
            })
                ->when($offset && $limit, function ($query, $offset) {
                    return $query->offset($offset);
                })->get()->map->formatWithoutPermissions();
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    /**
     * Fetch All roles that the specific user doesn't have
     *
     * @return Role
     */
    public function findRolesNotInUser(int $userId): Collection
    {
        $user = (new UserRepository())->findById($userId);
        $userRoles = [];
        foreach ($user->roles as $role) {
            array_push($userRoles, $role->id);
        }

        return Role::whereNotIn("id", $userRoles)
            ->get()
            ->map->formatWithoutPermissions();
    }

    /**
     * Get By Id
     *
     * @return Role
     * @param integer $id
     */
    public function findById(int $id): object
    {
        return Role::find($id)->format();
    }

    /**
     * Update
     *
     * @return Boolean
     * @param integer $id
     * @param array $set
     */
    public function update(int $id, array $set): Role
    {
        $obj = Role::where("id", $id)->first();

        $obj->update($set);

        return $obj;
    }

    /**
     * Delete
     *
     * @return Boolean
     * @param integer $id
     */
    public function delete(int $id): bool
    {
        Role::where("id", $id)->delete();

        return true;
    }
}
