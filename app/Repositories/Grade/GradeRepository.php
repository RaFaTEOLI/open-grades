<?php

namespace App\Repositories\Grade;

use App\Models\Grade;
use App\Repositories\Abstract\AbstractRepository;

class GradeRepository extends AbstractRepository
{
    protected $model = Grade::class;
}
