<?php

namespace App\Repositories\RedisRepository;

use App\Repositories\RedisRepository\RedisRepositoryInterface;
use Illuminate\Support\Facades\Redis;

class RedisRepository implements RedisRepositoryInterface
{
    /**
     * Get All
     *
     * @return User
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
     * @return User
     * @param string $db
     * @param integer $id
     */
    public function findById($db, $id)
    {
        $users = json_decode(Redis::get($db));

        foreach ($users as $user) {
            if ($user->id == $id) {
                return $user;
            }
        }

        return $user;
    }

    /**
     * Get All
     *
     * @return User
     * @param string $db
     */
    public function set($db, $request)
    {
        $redis = Redis::connection();
        $redis->set($db, json_encode($request));
    }
}
