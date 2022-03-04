<?php

namespace App\Repositories\Warning;

use App\Models\User;
use App\Repositories\Abstract\AbstractRepository;

class WarningRepository extends AbstractRepository
{
    protected $model = User::class;
}
