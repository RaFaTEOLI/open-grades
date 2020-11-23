<?php

namespace App\Repositories;

use App\Telegram;
use App\Http\Controllers\Auth\AdminController;
use App\Repositories\TelegramRepositoryInterface;
use Exception;

class TelegramRepository implements TelegramRepositoryInterface
{

    /**
     * Get All Messages
     */
    public function all()
    {
        return Telegram::all()
            ->map->format();
    }

    /**
     * Get Message By Id
     */
    public function findById($id)
    {
        return Telegram::findOrFail($id)->format();
    }

    public function update($id, $set)
    {
        try {
            $object = Telegram::findOrFail($id);

            $object->update($set);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function register($request)
    {
        try {
            AdminController::isAdminOrFail();

            return Telegram::create($request);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
