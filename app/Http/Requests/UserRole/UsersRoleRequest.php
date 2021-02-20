<?php

namespace App\Http\Requests\UserRole;

use Illuminate\Validation\Rule;

class UsersRoleRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules($userId)
    {
        return [
            "user_id" => "required|exists:users,id",
            "role_id" => [
                "required",
                "exists:roles,id",
                Rule::unique("role_user")->where(function ($query) use ($userId) {
                    return $query->where("user_id", $userId);
                }),
            ],
        ];
    }

    public static function deleteRules()
    {
        return [
            "user_id" => "required|exists:users,id",
            "role_id" => "required|exists:roles,id",
        ];
    }
}
