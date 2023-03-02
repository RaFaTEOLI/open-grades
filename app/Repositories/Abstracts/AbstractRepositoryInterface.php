<?php

namespace App\Repositories\Abstracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface AbstractRepositoryInterface
{
    public function all(int $limit = 0, int $offset = 0): Collection | array;
    public function store(array $request): Model;
    public function findById(int $id): object;
    public function update(int $id, array $set): void;
    public function delete(int $id): bool;
}
