<?php

namespace App\Repositories\Subject;

use App\Models\Subject;
use App\Repositories\Abstracts\AbstractRepository;

class SubjectRepository extends AbstractRepository
{
    protected $model = Subject::class;
}
