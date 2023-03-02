<?php

namespace App\Repositories\EvaluationType;

use App\Models\EvaluationType;
use App\Repositories\Abstracts\AbstractRepository;

class EvaluationTypeRepository extends AbstractRepository
{
    protected $model = EvaluationType::class;
}
