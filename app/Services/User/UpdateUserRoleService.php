<?php

namespace App\Services\User;

use App\Http\Controllers\Auth\AdminController;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\User;
use App\Models\Role;

class UpdateUserRoleService
{
    public function execute(array $request): User
    {
        try {
            AdminController::isAdminOrFail();
            $user = DB::transaction(function () use ($request) {
                $user = User::where("id", $request["userId"])
                    ->where("deleted_at", null)
                    ->firstOrFail();

                $role = Role::find($request["roleId"]);
                $user->attachRole($role);

                return $user;
            });
            return $user;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
