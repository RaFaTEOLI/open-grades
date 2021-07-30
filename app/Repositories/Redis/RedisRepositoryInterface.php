<?php

namespace App\Repositories\Redis;

use Illuminate\Support\Collection;

interface RedisRepositoryInterface
{
    public function all(string $db, int $limit = 0, int $offset = 0): array | null;
    public function findById(string $db, int $id): array | object;
    public function set(string $db, array | Collection $request): void;
    public function invalidate(string $db): void;
}
