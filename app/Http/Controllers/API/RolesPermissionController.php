<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\HttpStatus;
use App\Http\Requests\RolePermission\RolePermissionRequest;
use App\Http\Requests\UserRole\UsersRoleRequest;
use App\Services\RolePermission\UpdateRolePermissionService;
use App\Services\RolePermission\RemoveRolePermissionService;
use Illuminate\Validation\Rule;
use Exception;

class RolesPermissionController extends Controller
{
    public function store(int $roleId, int $permissionId)
    {
        try {
            $validator = Validator::make(
                ["role_id" => $roleId, "permission_id" => $permissionId],
                RolePermissionRequest::rules($roleId),
            );

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()], HttpStatus::BAD_REQUEST);
            }

            $updateRolePermissionService = new UpdateRolePermissionService();
            $updateRolePermissionService->execute(["roleId" => $roleId, "permissionId" => $permissionId]);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    public function destroy(int $roleId, int $permissionId)
    {
        try {
            $validator = Validator::make(
                ["role_id" => $roleId, "permission_id" => $permissionId],
                RolePermissionRequest::deleteRules(),
            );

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()], HttpStatus::BAD_REQUEST);
            }

            $removeRolePermissionService = new RemoveRolePermissionService();
            $removeRolePermissionService->execute(["roleId" => $roleId, "permissionId" => $permissionId]);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }
}
