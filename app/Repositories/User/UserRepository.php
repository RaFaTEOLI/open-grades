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
        try {
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
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    /*
        Get All Active Students
    */
    public function allStudents(): Collection
    {
        try {
            return User::where("deleted_at", null)
                ->withRole("student")
                ->get()
                ->map->format();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function store(array $request): User
    {
        try {
            $userCreated = User::create($request);

            (new RedisRepository())->set("users", $this->all());

            return $userCreated;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /*
        Get An User By Id
    */
    public function findById(int $id): object
    {
        try {
            $user = (new RedisRepository())->findById("users", $id);

            if (empty($user)) {
                $user = User::where("id", $id)->where("deleted_at", null)->firstOrFail()->format();
            }

            return $user;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function update(int $userId, array $set): void
    {
        try {
            $user = User::findOrFail($userId);

            $user->update($set);
            (new RedisRepository())->invalidate("users");
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function delete(int $userId): bool
    {
        try {
            $this->update($userId, ["deleted_at" => Carbon::now()]);
            (new RedisRepository())->invalidate("users");

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
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
        Get All Active Responsibles
    */
    public function allResponsibles(): Collection
    {
        try {
            return User::where("deleted_at", null)
                ->withRole("responsible")
                ->get()
                ->map->format();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /*
        Get All Active Users Besides Admin
    */
    public function allButAdmin(): Collection
    {
        try {
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
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
