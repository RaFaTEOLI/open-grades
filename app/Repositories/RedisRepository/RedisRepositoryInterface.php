<?php

namespace App\Repositories\RedisRepository;

interface RedisRepositoryInterface
{
    public function all(string $db);
    public function findById(string $db, $id);
    public function set(string $db, array $request);
}
