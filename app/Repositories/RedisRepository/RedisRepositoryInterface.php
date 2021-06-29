<?php

namespace App\Repositories\RedisRepository;

use Illuminate\Support\Collection;

interface RedisRepositoryInterface
{
    public function all(string $db): array | null;
    public function findById(string $db, int $id): array | object;
    public function set(string $db, array | Collection $request): void;
    public function invalidate(string $db): void;
}
