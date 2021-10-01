<?php

namespace App\Services\StudentsResponsible;

use App\Models\StudentsResponsible;
use Exception;

class AddStudentsResponsibleService
{
    public function execute(array $request): object
    {
        try {
            return StudentsResponsible::create([
                "student_id" => $request['student_id'],
                "responsible_id" => $request['responsible_id'],
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
