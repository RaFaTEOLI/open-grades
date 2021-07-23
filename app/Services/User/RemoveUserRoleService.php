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
            if ($request["userId"] == 1 && $request["roleId"] == 1) {
                throw new Exception(__("role.user_is_admin"), 400);
            }
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
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }
}
