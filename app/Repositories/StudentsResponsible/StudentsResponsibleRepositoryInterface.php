<?php

namespace App\Repositories\StudentsResponsible;

interface StudentsResponsibleRepositoryInterface
{
    public function all();
    public function findById($id);
    public function findByResponsibleId($id);
    public function findByStudentId($id);
}
