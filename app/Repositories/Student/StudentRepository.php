<?php

namespace App\Repositories\Student;

use App\Repositories\Student\StudentRepositoryInterface;
use App\Models\Student;
use App\Models\StudentsClasses;
use App\Models\StudentsResponsible;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ItemNotFoundException;

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
        } else if (Auth::user()->hasRole('teacher')) {
            return $this->findStudentsByTeacherId(Auth::user()->id);
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
        try {
            return Student::where("id", $id)
                ->where("deleted_at", null)
                ->firstOrFail()
                ->format();
        } catch (ItemNotFoundException) {
            throw new ItemNotFoundException();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getNewCount(): int
    {
        $newStudents = Student::where("deleted_at", null)
            ->whereDate('created_at', '>', Carbon::now()->subDays(30))->get();

        return count($newStudents);
    }

    public function findStudentsByTeacherId(int $teacherId): Collection
    {
        return StudentsClasses::join('classes', 'students_classes.class_id', 'classes.id')
            ->join('users', 'users.id', 'students_classes.user_id')
            ->where('classes.user_id', $teacherId)
            ->get('students_classes.user_id')
            ->map
            ->formatStudentsOnly();
    }

    public function findStudentsByClassId(int $classId): Collection
    {
        return StudentsClasses::join('classes', 'students_classes.class_id', 'classes.id')
            ->join('users', 'users.id', 'students_classes.user_id')
            ->where('students_classes.class_id', $classId)
            ->get('students_classes.user_id')
            ->map
            ->formatStudentsOnly();
    }
}
