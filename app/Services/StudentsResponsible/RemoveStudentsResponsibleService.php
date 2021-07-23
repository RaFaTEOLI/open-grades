<?php

namespace App\Services\StudentsResponsible;

use App\Models\StudentsResponsible;
use Exception;

class RemoveStudentsResponsibleService
{
    public function execute(array $request): bool
    {
        try {
            $responsible = StudentsResponsible::where($request);
            $responsible->delete();

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
