<?php

namespace App\Repositories\StudentsResponsible;

use App\Repositories\StudentsResponsible\StudentsResponsibleRepositoryInterface;
use App\Models\StudentsResponsible;

class StudentsResponsibleRepository implements StudentsResponsibleRepositoryInterface
{
    /*
        Get All Active Students Responsibles
    */
    public function all()
    {
        return StudentsResponsible::all()->map->format();
    }

    /*
        Get A Student Responsible By Id
    */
    public function findById($id)
    {
        return StudentsResponsible::where("id", $id)
            ->first()
            ->format();
    }

    /*
        Get A Student Responsible By Id
    */
    public function findByResponsibleId($id)
    {
        return StudentsResponsible::where("responsible_id", $id)
            ->first()
            ->format();
    }

    /*
        Get A Student Responsible By Id
    */
    public function findByStudentId($id)
    {
        return StudentsResponsible::where("student_id", $id)
            ->first()
            ->format();
    }
}
