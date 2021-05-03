<?php

namespace App\Repositories\RedisRepository;

use App\Repositories\RedisRepository\RedisRepositoryInterface;
use Illuminate\Support\Facades\Redis;

class RedisRepository implements RedisRepositoryInterface
{
    /**
     * Get All
     *
     * @param string $db
     */
    public function all($db)
    {
        $redis = Redis::connection();
        return json_decode($redis->get($db));
    }

    /**
     * Get By Id
     *
     * @param string $db
     * @param integer $id
     */
    public function findById($db, $id)
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

    public function set($db, $request)
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
    public function invalidate($db)
    {
        $redis = Redis::connection();
        $redis->set($db, "");
    }
}
