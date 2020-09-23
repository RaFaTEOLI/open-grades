<?php

namespace App\Repositories;

use App\Repositories\InvitationLinkRepositoryInterface;
use App\InvitationLink;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;

class InvitationLinkRepository implements InvitationLinkRepositoryInterface {

    /**
     * Get All Active Invitation Links
     */
    public function all() {
        return InvitationLink::where('used_at', null)
            ->with('user')
            ->get()
            ->map->format();
    }

    /**
     * Get An Invitation Link By Id
     */
    public function findById($id) {
        return InvitationLink::findOrFail($id)
            ->where('used_at', null)
            ->get()
            ->first()
            ->map->format();
    }

    public function findByUserId($userId) {
        return InvitationLink::where('user_id', $userId)
        ->where('used_at', null)
        ->get()
        ->first()
        ->map->format();
    }

    public function update($id, $set) {
        $user = InvitationLink::where('id', $id)->first();

        $user->update($set);
    }

    public function delete($id) {
        $user = InvitationLink::where('id', $id)->delete();

        return true;
    }

    public function register($request) {
        try {
            // Validates if logged user is admin
            $user = User::where('id', Auth::id())->where('admin', 1)->first();

            if (!$user) throw new Exception('User is not admin');

            $request["user_id"] = $user->id;

            $request["hash"] = $this->generateHash();

            $invitation = InvitationLink::create($request);
            return $invitation;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function generateHash() {
        $hash = str_replace('$', '', Hash::make(Carbon::now()));
        $hash = str_replace('/', '', $hash);
        $hash = str_replace('.', '', $hash);

        return $hash;
    }
}
