<?php

namespace App\Repositories\RolesRepository;

interface RolesRepositoryInterface
{
    public function all();
    public function findById($userId);
    public function update($userId, $set);
    public function delete($userId);
}
