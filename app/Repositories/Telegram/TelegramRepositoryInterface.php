<?php

namespace App\Repositories\Telegram;

use App\Models\Telegram;
use Illuminate\Support\Collection;

interface TelegramRepositoryInterface
{
    public function all(): Collection;
    public function findById(int $id): object;
    public function update(int $id, array $set): void;
    public function register(array $request): Telegram;
}
