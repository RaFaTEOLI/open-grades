<?php

namespace App\Repositories\Class;

use App\Models\Classes;
use App\Repositories\Abstract\AbstractRepository;

class ClassRepository extends AbstractRepository
{
    protected $model = Classes::class;
}
