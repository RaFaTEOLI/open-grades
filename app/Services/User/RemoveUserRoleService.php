<?php

namespace App\Services\User;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\User;
use App\Models\Role;

class RemoveUserRoleService
{
    public function execute(array $request)
    {
        try {
            $user = DB::transaction(function () use ($request) {
                $user = User::where("id", $request["userId"])
                    ->where("deleted_at", null)
                    ->first();

                $role = Role::find($request["roleId"]);
                $user->detachRole($role);

                return $user;
            });
            return $user;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
