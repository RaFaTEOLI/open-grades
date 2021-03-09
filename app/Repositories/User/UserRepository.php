<?php

namespace App\Repositories\User;

use App\Repositories\User\UserRepositoryInterface;
use App\Models\User;
use App\Models\Role;
use App\Repositories\RedisRepository\RedisRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Redis;

class UserRepository implements UserRepositoryInterface
{
    /*
        Get All Active Users
    */
    public function all()
    {
        $users = (new RedisRepository())->all("users");

        if (empty($users)) {
            $users = User::where("deleted_at", null)
                ->get()
                ->map->format();
        }

        return $users;
    }

    public function store(array $request)
    {
        $userCreated = User::create($request);

        (new RedisRepository())->set("users", $this->all());

        return $userCreated;
    }

    /*
        Get An User By Id
    */
    public function findById($id)
    {
        $user = (new RedisRepository())->findById("users", $id);

        if (empty($user)) {
            $user = User::where("id", $id)
                ->where("deleted_at", null)
                ->first()
                ->format();
        }

        return $user;
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
        $this->update($userId, ["deleted_at" => Carbon::now()]);

        return true;
    }

    public function createType($type, $userId)
    {
        $user = User::find($userId);
        $role = Role::where("name", strtolower($type))->first();

        if (!empty($role)) {
            $user->attachRole($role);
        } else {
            throw new Exception("No type specified");
        }
    }
}
