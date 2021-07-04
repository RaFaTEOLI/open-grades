<?php

namespace App\Repositories\Teacher;

use Illuminate\Support\Collection;

interface TeacherRepositoryInterface
{
    public function all(): Collection;
    public function findById(int $id): object;
}
