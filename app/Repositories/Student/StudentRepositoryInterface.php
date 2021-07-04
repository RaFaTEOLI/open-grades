<?php

namespace App\Repositories\Student;

use Illuminate\Support\Collection;

interface StudentRepositoryInterface
{
    public function all(): Collection;
    public function findById(int $id): object;
}
