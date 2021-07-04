<?php

namespace App\Repositories\Telegram;

use App\Models\Telegram;
use App\Repositories\Telegram\TelegramRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;

class TelegramRepository implements TelegramRepositoryInterface
{

    /**
     * Get All Messages
     */
    public function all(): Collection
    {
        return Telegram::all()
            ->map->format();
    }

    /**
     * Get Message By Id
     */
    public function findById(int $id): object
    {
        return Telegram::findOrFail($id)->format();
    }

    public function update(int $id, array $set): void
    {
        try {
            $object = Telegram::findOrFail($id);

            $object->update($set);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function register(array $request): Telegram
    {
        try {
            return Telegram::create($request);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
