<?php

namespace App\Repositories;

interface ConfigurationRepositoryInterface {
    public function all();
    public function findById($id);
    public function update($id, $set);
    public function delete($id);
    public function register($request);
}
