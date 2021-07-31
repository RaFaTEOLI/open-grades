<?php

namespace App\Repositories\Configuration;

use App\Models\Configuration;
use Illuminate\Support\Collection;

interface ConfigurationRepositoryInterface
{
    public function all(int $limit = 0, int $offset = 0): Collection;
    public function findById(int $id): object;
    public function update(int $id, array $set): void;
    public function delete(int $id): bool;
    public function register(array $request): Configuration;
}
