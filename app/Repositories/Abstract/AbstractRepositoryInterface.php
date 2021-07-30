<?php

namespace App\Repositories\Abstract;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface AbstractRepositoryInterface
{
    public function all(): Collection | array;
    public function store(array $request): Model | object;
    public function findById(int $id): object;
    public function update(int $id, array $set): void;
    public function delete(int $id): bool;
}
