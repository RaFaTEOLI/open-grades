<?php

namespace App\Repositories\StudentsResponsible;

use App\Repositories\StudentsResponsible\StudentsResponsibleRepositoryInterface;
use App\Models\StudentsResponsible;
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
        Get A Student Responsible By Id
    */
    public function findByResponsibleId(int $id): object
    {
        return StudentsResponsible::where("responsible_id", $id)
            ->first()
            ->format();
    }

    /*
        Get A Student Responsible By Id
    */
    public function findByStudentId(int $id): object
    {
        return StudentsResponsible::where("student_id", $id)
            ->first()
            ->format();
    }
}
