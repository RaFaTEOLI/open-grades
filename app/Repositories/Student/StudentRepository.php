<?php

namespace App\Repositories\Student;

use App\Repositories\Student\StudentRepositoryInterface;
use App\Models\Student;

class StudentRepository implements StudentRepositoryInterface
{
    /*
        Get All Active Students
    */
    public function all()
    {
        return Student::where("deleted_at", null)
            ->withRole("student")
            ->get()
            ->map->format();
    }

    /*
        Get A Student By Id
    */
    public function findById($id)
    {
        if (empty($user)) {
            $user = Student::where("id", $id)
                ->where("deleted_at", null)
                ->first()
                ->format();
        }

        return $user;
    }
}
