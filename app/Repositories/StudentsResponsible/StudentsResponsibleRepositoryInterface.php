<?php

namespace App\Repositories\StudentsResponsible;

use Illuminate\Support\Collection;

interface StudentsResponsibleRepositoryInterface
{
    // public function all(): Collection;
    // public function findById(int $id): object;
    // public function findByResponsibleId(int $id): Collection;
    public function findByStudentId(int $id): object;
    public function findByResponsibleIdAndStudentId(int $responsibleId, int $studentId): object | null;
}
