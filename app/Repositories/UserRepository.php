<?php

namespace App\Repositories;

use App\Repositories\UserRepositoryInterface;
use App\User;

class UserRepository implements UserRepositoryInterface {

    /*
        Get All Active Users
    */
    public function all() {
        return User::where('deleted_at', null)
            ->get()
            ->format();
    }

    /*
        Get An User By Id
    */
    public function findById($userId) {
        return User::where('id', $userId)
            ->where('deleted_at', null)
            ->get()
            ->firstOrFail()
            ->format();
    }
    
    public function findByUsername($username) {

    }

    public function update($userId) {
        $user = User::where('id', $userId)->firstOrFail();

        $user->update([]);
    }

    public function delete($userId) {
        $user = User::where('id', $userId)->delete();

        return true;
    }
}