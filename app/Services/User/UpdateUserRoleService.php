<?php

namespace App\Services\User;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\DB;
use App\Repositories\RolesRepository\RolesRepository;
use Exception;
use App\Models\User;
use App\Models\Role;

class UpdateUserRoleService
{
    public function execute(array $request)
    {
        try {
            $user = DB::transaction(function () use ($request) {
                $user = User::where("id", $request["userId"])
                    ->where("deleted_at", null)
                    ->first();

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
