<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\PermissionRequest;
use App\Repositories\Permission\PermissionRepository;
use App\Services\Permission\CreatePermissionService;
use Illuminate\Http\Request;
use Exception;

class PermissionController extends Controller
{
    private $permissionRepository;

    public function __construct()
    {
        $this->permissionRepository = new PermissionRepository();
    }

    /**
     * @OA\Get(
     * path="/permissions",
     * summary="Get Permissions",
     * description="Get a list of permissions",
     * operationId="index",
     * tags={"Permission"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/Permission")
     *      ),
     *    ),
     *  ),
     * )
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = $this->permissionRepository->all();

        return response()->json($permissions, HttpStatus::SUCCESS);
    }

    /**
     * @OA\Post(
     * path="/permissions",
     * summary="Create Permission",
     * description="Create Permission by name, description",
     * operationId="store",
     * tags={"Permission"},
     * security={ {"bearerAuth":{}} },
     * @OA\RequestBody(
     *    required=true,
     *    description="Send name, value",
     *    @OA\JsonContent(
     *       required={"name","description"},
     *       @OA\Property(property="name", type="string", example="create-users"),
     *       @OA\Property(property="description", type="string", example="Create Users"),
     *       @OA\Property(property="create", type="string", example="on"),
     *       @OA\Property(property="update", type="string", example="on"),
     *       @OA\Property(property="read", type="string", example="on"),
     *       @OA\Property(property="delete", type="string", example="on"),
     *    ),
     * ),
     * @OA\Response(
     *     response=204,
     *     description="No Content",
     *    ),
     *  ),
     * )
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        try {
            $input = $request->all();

            $createPermissionService = new CreatePermissionService();
            $createPermissionService->execute($input);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     * path="/permissions/{id}",
     * summary="Get Permission",
     * @OA\Parameter(
     *      name="id",
     *      description="Permission id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Show Permission by id",
     * operationId="show",
     * tags={"Permission"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/Permission",
     *      ),
     *    ),
     *  ),
     * )
     */
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try {
            $permission = $this->permissionRepository->findById($id);

            return response()->json($permission, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Put(
     * path="/permissions/{id}",
     * summary="Update Permission",
     * description="Update Permission",
     * operationId="update",
     * security={ {"bearerAuth":{}} },
     * tags={"Permission"},
     * @OA\Parameter(
     *      name="id",
     *      description="Permission id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     *
     * @OA\RequestBody(
     *    required=true,
     *    description="Send name or display_name or description to update permission",
     *    @OA\JsonContent(
     *       @OA\Property(property="name", type="string", example="create-users"),
     *       @OA\Property(property="display_name", type="string", example="Create Users"),
     *       @OA\Property(property="description", type="string", example="Create Users"),
     *    ),
     * ),
     * @OA\Response(
     *     response=204,
     *     description="No Content",
     *    ),
     *  ),
     * )
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        try {
            $input = $request->only(["name", "display_name", "description"]);
            $this->permissionRepository->update($id, $input);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Delete(
     * path="/permissions/{id}",
     * summary="Delete Permission",
     * @OA\Parameter(
     *      name="id",
     *      description="Permission id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Delete Permission by id",
     * operationId="destroy",
     * tags={"Permission"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=204,
     *     description="No Content",
     *    ),
     *  ),
     * )
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $this->permissionRepository->delete($id);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }
}
