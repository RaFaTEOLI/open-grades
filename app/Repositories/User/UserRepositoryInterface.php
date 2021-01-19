<?php

namespace App\Repositories;

interface UserRepositoryInterface {
    public function all();
    public function findById($userId);
    public function findByUsername($username);
    public function update($userId, $set);
    public function delete($userId);
    public function createType($type, $userId);
    public function createStudent($userId);
    public function createTeacher($userId);
}
