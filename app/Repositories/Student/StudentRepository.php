<?php

namespace App\Repositories\Student;

use App\Repositories\Student\StudentRepositoryInterface;
use App\Models\Student;
use App\Models\StudentsResponsible;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class StudentRepository implements StudentRepositoryInterface
{
    /*
        Get All Active Students
    */
    public function all(int $limit = 0, int $offset = 0): Collection
    {
        if (Auth::user()->hasRole('responsible')) {
            return StudentsResponsible::where("responsible_id", Auth::user()->id)
                ->get()
                ->map
                ->formatStudentsOnly();
        }
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

    public function getNewCount(): int
    {
        $newStudents = Student::where("deleted_at", null)
            ->whereDate('created_at', '>', Carbon::now()->subDays(30))->get();

        return count($newStudents);
    }
}
