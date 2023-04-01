<?php

namespace App\Repositories\User;

use Illuminate\Support\Collection;
use App\Models\User;

interface UserRepositoryInterface
{
    public function all(int $limit = 0, int $offset = 0): Collection | array;
    public function store(array $request): User;
    public function findById(int $id): object;
    public function update(int $userId, array $set): void;
    public function delete(int $userId): bool;
    public function createType(string $type, int $userId): void;
    public function allButAdmin(): Collection;
}
