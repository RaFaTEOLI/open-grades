<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\RolePermission\UpdateRolePermissionService;
use App\Services\RolePermission\RemoveRolePermissionService;
use App\Http\Requests\RolePermission\RolePermissionRequest;
use Illuminate\Support\Facades\Validator;

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
                return redirect()
                    ->back()
                    ->withErrors($validator->errors());
            }

            $updateRolePermissionService = new UpdateRolePermissionService();
            $updateRolePermissionService->execute(["roleId" => $roleId, "permissionId" => $permissionId]);

            return redirect()
                ->route("roles.show", ["id" => $roleId])
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
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
                dd($validator->errors());
                return redirect()
                    ->back()
                    ->withErrors($validator->errors());
            }

            $removeRolePermissionService = new RemoveRolePermissionService();
            $removeRolePermissionService->execute(["roleId" => $roleId, "permissionId" => $permissionId]);

            return redirect()
                ->route("roles.show", ["id" => $roleId])
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }
}
