<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Warning\WarningRequest;
use App\Http\Traits\Pagination;
use App\Repositories\Warning\WarningRepository;
use App\Services\Warning\CreateWarningService;
use Exception;
use Illuminate\Http\Request;

class WarningController extends Controller
{
    use Pagination;
    private $warningRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->warningRepository = new WarningRepository();
    }

    /**
     * @OA\Get(
     * path="/warnings",
     * summary="Get Warnings",
     * description="Get a list of Warnings",
     * operationId="index",
     * tags={"Warning"},
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
     *         @OA\Items(ref="#/components/schemas/Warning")
     *      ),
     *    ),
     *  ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $paginated = $this->paginate($request);
            $warnings = $this->warningRepository->all($paginated["limit"], $paginated["offset"]);

            return response()->json($warnings, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Post(
     * path="/warnings",
     * summary="Create Warning",
     * description="Create Warning",
     * operationId="store",
     * tags={"Warning"},
     * security={ {"bearerAuth":{}} },
     * @OA\RequestBody(
     *    required=true,
     *    description="Send student_id, class_id and description",
     *    @OA\JsonContent(
     *       required={"student_id", "class_id", "description"},
     *       @OA\Property(property="student_id", type="integer", example="1"),
     *       @OA\Property(property="class_id", type="integer", example="5"),
     *       @OA\Property(property="description", type="string", example="Student was being too loud"),
     *    ),
     * ),
     * @OA\Response(
     *     response=201,
     *     description="Created",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/Warning",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function store(WarningRequest $request)
    {
        try {
            $input = $request->only(["student_id", "class_id", "reporter_id"]);

            $Warning = (new CreateWarningService())->execute($input);

            return response()->json($Warning->format(), HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Patch(
     * path="/warnings/{id}",
     * summary="Update Warning",
     * description="Update Warning",
     * operationId="update",
     * security={ {"bearerAuth":{}} },
     * tags={"Warning"},
     * @OA\Parameter(
     *      name="id",
     *      description="Warning id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     *
     * @OA\RequestBody(
     *    required=true,
     *    description="Update description",
     *    @OA\JsonContent(
     *       required={"description"},
     *       @OA\Property(property="description", type="string", example="Student was being too loud"),
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
            $input = $request->only(["description"]);
            $this->warningRepository->update($id, $input);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     * path="/warnings/{id}",
     * summary="Get Warning",
     * @OA\Parameter(
     *      name="id",
     *      description="Warning id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Show Warning by id",
     * operationId="show",
     * tags={"Warning"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/Warning",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function show(int $id)
    {
        try {
            $Warning = $this->warningRepository->findById($id)->format();

            return response()->json($Warning, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete(
     * path="/warnings/{id}",
     * summary="Delete Warning",
     * @OA\Parameter(
     *      name="id",
     *      description="Warning id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Delete Warning by id",
     * operationId="destroy",
     * tags={"Warning"},
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
            $this->warningRepository->delete($id);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }
}
