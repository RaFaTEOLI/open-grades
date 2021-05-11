<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function all();
    public function allStudents();
    public function findById($userId);
    public function findByUsername($username);
    public function update($userId, $set);
    public function delete($userId);
    public function createType($type, $userId);
}
