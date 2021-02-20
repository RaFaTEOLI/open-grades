<?php

namespace App\Repositories\PermissionRepository;

interface PermissionRepositoryInterface
{
    public function all();
    public function findById($id);
    public function update($id, $set);
    public function delete($id);
}
