<?php

namespace App\Repositories\Telegram;

use App\Models\Telegram;
use App\Repositories\Abstract\AbstractRepository;

class TelegramRepository extends AbstractRepository
{
    protected $model = Telegram::class;
}
