<?php

namespace App\Repositories;

interface TelegramRepositoryInterface {
    public function all();
    public function findById($id);
    public function register($request);
}
