<?php

namespace App\Repositories\Permission;

use App\Models\Permission;
use Illuminate\Support\Collection;

interface PermissionRepositoryInterface
{
    public function all(): Collection;
    public function store(array $request): Permission;
    public function findPermissionsNotInRole(int $roleId): Collection;
    public function findById(int $id): Permission;
    public function update(int $id, array $set): Permission;
    public function delete(int $id): bool;
}
