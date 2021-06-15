<?php

namespace App\Repositories\Teacher;

use App\Repositories\Teacher\TeacherRepositoryInterface;
use App\Models\User;

class TeacherRepository implements TeacherRepositoryInterface
{
    /*
        Get All Active Teachers
    */
    public function all()
    {
        return User::where("deleted_at", null)
            ->withRole("teacher")
            ->get()
            ->map->format();
    }

    /*
        Get A Teacher By Id
    */
    public function findById($id)
    {
        return User::where("id", $id)
            ->where("deleted_at", null)
            ->first()
            ->format();
    }
}
