<?php

namespace App\Repositories\Telegram;

use App\Models\Telegram;
use App\Repositories\Abstracts\AbstractRepository;

class TelegramRepository extends AbstractRepository
{
    protected $model = Telegram::class;
}
