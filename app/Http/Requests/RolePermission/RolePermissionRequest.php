<?php

namespace App\Http\Requests\RolePermission;

use Illuminate\Validation\Rule;

class RolePermissionRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules($roleId)
    {
        return [
            "role_id" => "required|exists:roles,id",
            "permission_id" => [
                "required",
                "exists:permissions,id",
                Rule::unique("permission_role")->where(function ($query) use ($roleId) {
                    return $query->where("role_id", $roleId);
                }),
            ],
        ];
    }

    public static function deleteRules()
    {
        return [
            "role_id" => "required|exists:roles,id",
            "permission_id" => "required|exists:permissions,id",
        ];
    }
}
