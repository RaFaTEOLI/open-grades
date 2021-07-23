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
    /**
     * @OA\Patch(
     * path="/users/{userId}/role/{roleId}",
     * summary="Update Role",
     * description="Pass the role id to be added to the user",
     * operationId="store",
     * tags={"User"},
     * security={ {"bearerAuth":{}} },
     * @OA\Parameter(
     *      name="userId",
     *      description="Id of the user you want to add the role",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * @OA\Parameter(
     *      name="roleId",
     *      description="Id of the role that will be added to the user",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * * @OA\Response(
     *     response=204,
     *     description="No Content",
     *    ),
     *   ),
     *  ),
     * )
     */
    public function store(int $userId, int $roleId)
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

    /**
     * @OA\Delete(
     * path="/users/{userId}/role/{roleId}",
     * summary="Remove Role",
     * description="Pass the role id to be remove from the user",
     * operationId="destroy",
     * tags={"User"},
     * security={ {"bearerAuth":{}} },
     * @OA\Parameter(
     *      name="userId",
     *      description="Id of the user you want to remove the role",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * @OA\Parameter(
     *      name="roleId",
     *      description="Id of the role that will be removed from the user",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * * @OA\Response(
     *     response=204,
     *     description="No Content",
     *    ),
     *   ),
     *  ),
     * )
     */
    public function destroy(int $userId, int $roleId)
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
            return response()->json(["message" => $e->getMessage()], $e->getCode() ? $e->getCode() : HttpStatus::SERVER_ERROR);
        }
    }
}
