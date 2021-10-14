<?php

namespace App\Repositories\Student;

use Illuminate\Support\Collection;

interface StudentRepositoryInterface
{
    public function all(int $limit = 0, int $offset = 0): Collection;
    public function findById(int $id): object;
    public function getNewCount(): int;
}
