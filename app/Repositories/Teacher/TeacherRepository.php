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
    public function all(): Collection
    {
        return User::where("deleted_at", null)
            ->withRole("teacher")
            ->get()
            ->map->format();
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
