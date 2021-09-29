<?php

namespace App\Repositories\StudentClass;

use Illuminate\Support\Collection;

interface StudentClassRepositoryInterface
{
    public function findClassesByStudentId(int $studentId): Collection;
    public function deleteByStudentAndClass(int $studentId, int $classId): bool;
}
