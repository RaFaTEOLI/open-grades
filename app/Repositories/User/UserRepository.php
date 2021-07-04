<?php

namespace App\Repositories\User;

use App\Repositories\User\UserRepositoryInterface;
use App\Models\User;
use App\Models\Role;
use App\Repositories\RedisRepository\RedisRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    /*
        Get All Active Users
    */
    public function all(): Collection | array
    {
        $users = (new RedisRepository())->all("users");

        if (empty($users)) {
            $users = User::where("deleted_at", null)
                ->get()
                ->map->format();
        }

        return $users;
    }

    /*
        Get All Active Students
    */
    public function allStudents(): Collection
    {
        return User::where("deleted_at", null)
            ->withRole("student")
            ->get()
            ->map->format();
    }

    public function store(array $request): User
    {
        $userCreated = User::create($request);

        (new RedisRepository())->set("users", $this->all());

        return $userCreated;
    }

    /*
        Get An User By Id
    */
    public function findById(int $id): object
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

    public function update(int $userId, array $set): void
    {
        $user = User::where("id", $userId)->first();

        $user->update($set);
        (new RedisRepository())->invalidate("users");
    }

    public function delete(int $userId): bool
    {
        $this->update($userId, ["deleted_at" => Carbon::now()]);
        (new RedisRepository())->invalidate("users");

        return true;
    }

    public function createType(string $type, int $userId): void
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
