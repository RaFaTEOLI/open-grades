<?php

namespace App\Repositories\Teacher;

use App\Repositories\Teacher\TeacherRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Collection;

class TeacherRepository implements TeacherRepositoryInterface
{
    /*
        Get All Active Teachers
    */
    public function all(int $limit = 0, int $offset = 0): Collection
    {
        return User::where("deleted_at", null)
            ->withRole("teacher")
            ->when($limit, function ($query, $limit) {
                return $query->limit($limit);
            })
            ->when($offset && $limit, function ($query, $offset) {
                return $query->offset($offset);
            })
            ->get()
            ->map->formatSimple();
    }

    /*
        Get A Teacher By Id
    */
    public function findById(int $id): object
    {
        return User::where("id", $id)
            ->where("deleted_at", null)
            ->first()
            ->format();
    }
}
