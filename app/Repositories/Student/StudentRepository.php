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
    public function all(int $limit = 0, int $offset = 0): Collection
    {
        return Student::where("deleted_at", null)
            ->withRole("student")
            ->when($limit, function ($query, $limit) {
                return $query->limit($limit);
            })
            ->when($offset && $limit, function ($query, $offset) {
                return $query->offset($offset);
            })
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
