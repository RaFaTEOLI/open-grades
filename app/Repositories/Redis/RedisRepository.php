<?php

namespace App\Repositories\Redis;

use App\Repositories\Redis\RedisRepositoryInterface;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Collection;

class RedisRepository implements RedisRepositoryInterface
{
    /**
     * Get All
     *
     * @param string $db
     */
    public function all(string $db, int $limit = 0, int $offset = 0): array | null
    {
        $redis = Redis::connection();
        $result = json_decode($redis->get($db));
        if (!$result) return null;

        $newResult = [];

        if ($limit) {
            $limit--;
            if ($offset > $limit) {
                $limit = $offset - $limit;
            }
            for ($i = $offset; $i <= $limit; $i++) {
                array_push($newResult, $result[$i]);
            }
        } else {
            $newResult = $result;
        }

        return $newResult;
    }

    /**
     * Get By Id
     *
     * @param string $db
     * @param integer $id
     */
    public function findById(string $db, int $id): array | object
    {
        $objects = json_decode(Redis::get($db));
        $obj = [];
        if (!empty($objects)) {
            foreach ($objects as $obj) {
                if ($obj->id == $id) {
                    return $obj;
                }
            }
        }

        return $obj;
    }

    public function set(string $db, array | Collection $request): void
    {
        $redis = Redis::connection();
        $redis->set($db, json_encode($request));
    }

    /**
     * Invalidate
     *
     * @return User
     * @param string $db
     */
    public function invalidate(string $db): void
    {
        $redis = Redis::connection();
        $redis->set($db, "");
    }
}
