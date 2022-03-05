<?php

namespace App\Repositories\StudentsResponsible;

use App\Repositories\StudentsResponsible\StudentsResponsibleRepositoryInterface;
use App\Models\StudentsResponsible;
use Exception;
use Illuminate\Support\Collection;

class StudentsResponsibleRepository implements StudentsResponsibleRepositoryInterface
{
    /*
        Get All Active Students Responsibles
    */
    public function all(): Collection
    {
        return StudentsResponsible::all()->map->format();
    }

    /*
        Get A Student Responsible By Id
    */
    public function findById(int $id): object
    {
        return StudentsResponsible::where("id", $id)
            ->first()
            ->format();
    }

    /*
        Get All Students from a Responsible Id
    */
    public function findByResponsibleId(int $id): Collection
    {
        return StudentsResponsible::where("responsible_id", $id)
            ->get()
            ->map
            ->formatStudentsOnly();
    }

    /*
        Get A Student Responsible By Id
    */
    public function findByStudentId(int $id): object
    {
        return StudentsResponsible::where("student_id", $id)->get()->map->formatResponsible();
    }

    /*
        Check if an user is responsible to a student
    */
    public function findByResponsibleIdAndStudentId(int $responsibleId, int $studentId): object | null
    {
        return StudentsResponsible::where("student_id", $studentId)->where('responsible_id', $responsibleId)
            ->first();
    }
}
