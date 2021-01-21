<?php

namespace App\Repositories\Telegram;

interface TelegramRepositoryInterface {
    public function all();
    public function findById($id);
    public function register($request);
}
