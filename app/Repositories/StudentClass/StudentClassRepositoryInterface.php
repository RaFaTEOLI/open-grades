<?php

namespace App\Repositories\StudentClass;

use Illuminate\Support\Collection;

interface StudentClassRepositoryInterface
{
    public function findClassesByStudentId(int $studentId): Collection;
    public function findClassesByStudentIdAndClassId(int $studentId, int $classId): object;
    public function deleteByStudentAndClass(int $studentId, int $classId): bool;
    public function findIdByStudentIdAndClassId(int $studentId, int $classId): int;
}
