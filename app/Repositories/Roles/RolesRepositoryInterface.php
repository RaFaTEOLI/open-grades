<?php

namespace App\Repositories\Roles;

use App\Models\Role;
use Illuminate\Support\Collection;

interface RolesRepositoryInterface
{
    public function all(): Collection;
    public function allWithoutPermissions(int $limit = 0, int $offset = 0): Collection;
    public function findRolesNotInUser(int $userId): Collection;
    public function findById(int $userId): object;
    public function update(int $userId, array $set): Role;
    public function delete(int $userId): bool;
}
