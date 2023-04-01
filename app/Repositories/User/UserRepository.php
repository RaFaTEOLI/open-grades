<?php

namespace App\Repositories\User;

use App\Repositories\User\UserRepositoryInterface;
use App\Models\User;
use App\Models\Role;
use App\Repositories\Redis\RedisRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    /*
        Get All Active Users
    */
    public function all(int $limit = 0, int $offset = 0): Collection | array
    {
        $users = (new RedisRepository())->all("users", $limit, $offset);

        if (empty($users)) {
            $users = User::where("deleted_at", null)
                ->when($limit, function ($query, $limit) {
                    return $query->limit($limit);
                })
                ->when($offset && $limit, function ($query, $offset) {
                    return $query->offset($offset);
                })
                ->get()
                ->map->format();
        }

        return $users;
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
            $user = User::where("id", $id)->where("deleted_at", null)->firstOrFail()->format();
        }

        return $user;
    }

    public function update(int $userId, array $set): void
    {
        $user = User::findOrFail($userId);

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

    /*
        Get All Active Users Besides Admin
    */
    public function allButAdmin(): Collection
    {

        $students = User::where("deleted_at", null)
            ->withRole("student")
            ->get();

        $teachers = User::where("deleted_at", null)
            ->withRole("teacher")
            ->get();
        $merged = $students->merge($teachers);

        $responsibles = User::where("deleted_at", null)
            ->withRole("responsible")
            ->get();
        $merged = $merged->merge($responsibles);

        return $merged;
    }
}
