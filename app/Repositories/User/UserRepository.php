<?php

namespace App\Repositories\User;

use App\Repositories\User\UserRepositoryInterface;
use App\Models\User;
use App\Models\Role;
use Exception;

class UserRepository implements UserRepositoryInterface
{
    /*
        Get All Active Users
    */
    public function all()
    {
        return User::where("deleted_at", null)
            ->get()
            ->map->format();
    }

    /*
        Get An User By Id
    */
    public function findById($id)
    {
        return User::findOrFail($id)
            ->where("deleted_at", null)
            ->get()
            ->first()
            ->format();
    }

    public function findByUsername($username)
    {
    }

    public function update($userId, $set)
    {
        $user = User::where("id", $userId)->first();

        $user->update($set);
    }

    public function delete($userId)
    {
        $user = User::where("id", $userId)->delete();

        return true;
    }

    public function createType($type, $userId)
    {
        $user = User::find($userId);
        $role = Role::where("name", strtolower($type))->first();

        if ($type === "TEACHER" || $type === "STUDENT") {
            $user->attachRole($role);
        } else {
            throw new Exception("No type specified");
        }
    }
}
