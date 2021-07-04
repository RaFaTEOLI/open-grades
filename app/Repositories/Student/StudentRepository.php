<?php

namespace App\Repositories\Student;

use App\Repositories\Student\StudentRepositoryInterface;
use App\Models\Student;
use Illuminate\Support\Collection;

class StudentRepository implements StudentRepositoryInterface
{
    /*
        Get All Active Students
    */
    public function all(): Collection
    {
        return Student::where("deleted_at", null)
            ->withRole("student")
            ->get()
            ->map->format();
    }

    /*
        Get A Student By Id
    */
    public function findById(int $id): object
    {

        return Student::where("id", $id)
            ->where("deleted_at", null)
            ->first()
            ->format();
    }
}
