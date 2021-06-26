<?php

namespace App\Repositories\Configuration;

use App\Models\Configuration;
use Illuminate\Support\Collection;

interface ConfigurationRepositoryInterface
{
    public function all(): Collection;
    public function findById(int $id): object;
    public function update(int $id, array $set): void;
    public function delete(int $id): bool;
    public function register(array $request): Configuration;
}
