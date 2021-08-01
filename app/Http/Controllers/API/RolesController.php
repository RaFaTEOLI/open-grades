<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\HttpStatus;
use App\Http\Requests\Role\RoleRequest;
use App\Http\Traits\Pagination;
use App\Models\Role;
use App\Services\Role\CreateRoleService;
use App\Repositories\Roles\RolesRepository;
use Exception;

class RolesController extends Controller
{
    use Pagination;
    private $rolesRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->rolesRepository = new RolesRepository();
    }

    /**
     * @OA\Get(
     * path="/roles",
     * summary="Get Roles",
     * description="Get a list of roles",
     * operationId="index",
     * tags={"Role"},
     * security={ {"bearerAuth":{}} },
     * @OA\Parameter(
     *      name="offset",
     *      description="Offset for pagination",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * @OA\Parameter(
     *      name="limit",
     *      description="Limit of results for pagination",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/Role")
     *      ),
     *    ),
     *  ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $paginated = $this->paginate($request);
            $roles = $this->rolesRepository->allWithoutPermissions($paginated["limit"], $paginated["offset"]);

            return response()->json($roles, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    /**
     * @OA\Post(
     * path="/roles",
     * summary="Create Role",
     * description="Create Role by name, display_name, description",
     * operationId="store",
     * tags={"Role"},
     * security={ {"bearerAuth":{}} },
     * @OA\RequestBody(
     *    required=true,
     *    description="Send name, display_name, description",
     *    @OA\JsonContent(
     *       required={"name","display_name", "description"},
     *       @OA\Property(property="name", type="string", example="student"),
     *       @OA\Property(property="display_name", type="string", example="Student"),
     *       @OA\Property(property="description", type="string", example="Student"),
     *    ),
     * ),
     * @OA\Response(
     *     response=201,
     *     description="Created",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/Role",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function store(RoleRequest $request)
    {
        try {
            $input = $request->all();

            $createRoleService = new CreateRoleService();
            $role = $createRoleService->execute($input);

            return response()->json($role, HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     * path="/roles/{id}",
     * summary="Get Role",
     * @OA\Parameter(
     *      name="id",
     *      description="Role id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Show Role by id",
     * operationId="show",
     * tags={"Role"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/RolePermissions",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function show(int $id)
    {
        try {
            $role = $this->rolesRepository->findById($id);

            return response()->json($role, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    /**
     * @OA\Put(
     * path="/roles/{id}",
     * summary="Update Role",
     * description="Update Role",
     * operationId="update",
     * security={ {"bearerAuth":{}} },
     * tags={"Role"},
     * @OA\Parameter(
     *      name="id",
     *      description="Role id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     *
     * @OA\RequestBody(
     *    required=true,
     *    description="Send name, value to update role",
     *    @OA\JsonContent(
     *       required={"name","display_name", "description"},
     *       @OA\Property(property="name", type="string", example="student"),
     *       @OA\Property(property="display_name", type="string", example="Student"),
     *       @OA\Property(property="description", type="string", example="Student"),
     *    ),
     * ),
     * @OA\Response(
     *     response=204,
     *     description="No Content",
     *    ),
     *  ),
     * )
     */
    public function update(int $id, Request $request)
    {
        try {
            $input = $request->only(["name", "display_name", "description"]);
            $this->rolesRepository->update($id, $input);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete(
     * path="/roles/{id}",
     * summary="Delete Role",
     * @OA\Parameter(
     *      name="id",
     *      description="Role id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Delete role by id",
     * operationId="destroy",
     * tags={"Role"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=204,
     *     description="No Content",
     *    ),
     *  ),
     * )
     */
    public function destroy(int $id)
    {
        try {
            $this->rolesRepository->delete($id);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }
}
