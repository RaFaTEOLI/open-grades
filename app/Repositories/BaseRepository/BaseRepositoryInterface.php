<?php

namespace App\Repositories\BaseRepository;

interface BaseRepositoryInterface {
    public function all();
    public function findById($userId);
    public function update($userId, $set);
    public function delete($userId);
}
