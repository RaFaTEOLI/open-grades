<?php

namespace App\Repositories\Warning;

use App\Models\Warning;
use App\Repositories\Abstract\AbstractRepository;

class WarningRepository extends AbstractRepository
{
    protected $model = Warning::class;
}
