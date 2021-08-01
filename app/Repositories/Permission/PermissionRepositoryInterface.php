<?php

namespace App\Repositories\Permission;

use App\Models\Permission;
use Illuminate\Support\Collection;

interface PermissionRepositoryInterface
{
    public function all(int $limit = 0, int $offset = 0): Collection;
    public function store(array $request): Permission;
    public function findPermissionsNotInRole(int $roleId): Collection;
    public function findById(int $id): object;
    public function update(int $id, array $set): Permission;
    public function delete(int $id): bool;
}
