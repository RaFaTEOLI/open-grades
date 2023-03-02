<?php

namespace App\Repositories\Statement;

use App\Models\Statement;
use App\Repositories\Abstracts\AbstractRepository;

class StatementRepository extends AbstractRepository
{
    protected $model = Statement::class;
}
