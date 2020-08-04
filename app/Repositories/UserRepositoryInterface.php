<?php

namespace App\Repositories;

interface UserRepositoryInterface {
    public function all();
    public function findById($userId);
    public function findByUsername($username);
    public function update($userId);
    public function delete($userId);
}