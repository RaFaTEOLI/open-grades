<?php

namespace App\Repositories\Teacher;

use Illuminate\Support\Collection;

interface TeacherRepositoryInterface
{
    public function all(int $limit = 0, int $offset = 0): Collection;
    public function findById(int $id): object;
}
