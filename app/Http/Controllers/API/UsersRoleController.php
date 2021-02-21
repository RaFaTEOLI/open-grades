<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use App\Http\Requests\UserRole\UsersRoleRequest;
use Illuminate\Support\Facades\Validator;
use App\Services\User\UpdateUserRoleService;
use App\Services\User\RemoveUserRoleService;

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
                return response()->json(["error" => $validator->errors()], HttpStatus::BAD_REQUEST);
            }

            $updateUserRoleService = new UpdateUserRoleService();
            $updateUserRoleService->execute(["userId" => $userId, "roleId" => $roleId]);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::UNAUTHORIZED);
        }
    }

    public function destroy($userId, $roleId)
    {
        try {
            $validator = Validator::make(["user_id" => $userId, "role_id" => $roleId], UsersRoleRequest::deleteRules());

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()], HttpStatus::BAD_REQUEST);
            }

            $removeUserRoleService = new RemoveUserRoleService();
            $removeUserRoleService->execute(["userId" => $userId, "roleId" => $roleId]);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }
}