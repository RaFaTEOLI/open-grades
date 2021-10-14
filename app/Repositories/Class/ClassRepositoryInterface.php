<?php

namespace App\Repositories\Class;

use Illuminate\Support\Collection;

interface ClassRepositoryInterface
{
    public function all(int $limit = 0, int $offset = 0): Collection | array;
    public function findByTeacherId(int $teacherId): Collection;
}
