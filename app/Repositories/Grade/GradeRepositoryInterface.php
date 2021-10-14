<?php

namespace App\Repositories\Grade;

use Illuminate\Support\Collection;

interface GradeRepositoryInterface
{
    public function all(int $limit = 0, int $offset = 0): Collection | array;
    public function findById(int $id): object;
}
