<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRole\UsersRoleRequest;
use Illuminate\Support\Facades\Validator;
use App\Services\User\UpdateUserRoleService;
use App\Services\User\RemoveUserRoleService;
use Exception;

class UsersRoleController extends Controller
{
    public function store($userId, $roleId)
    {
        try {
            $validator = Validator::make(
                ["user_id" => $userId, "role_id" => $roleId],
                UsersRoleRequest::rules($userId),
            );

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator->errors());
            }

            $updateUserRoleService = new UpdateUserRoleService();
            $updateUserRoleService->execute(["userId" => $userId, "roleId" => $roleId]);

            return redirect()
                ->route("users.show", ["id" => $userId])
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function destroy($userId, $roleId)
    {
        try {
            $validator = Validator::make(["user_id" => $userId, "role_id" => $roleId], UsersRoleRequest::deleteRules());

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator->errors());
            }

            $removeUserRoleService = new RemoveUserRoleService();
            $removeUserRoleService->execute(["userId" => $userId, "roleId" => $roleId]);

            return redirect()
                ->route("users.show", ["id" => $userId])
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }
}
