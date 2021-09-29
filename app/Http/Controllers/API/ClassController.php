<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Class\ClassRequest;
use App\Http\Traits\Pagination;
use App\Repositories\Class\ClassRepository;
use App\Services\Class\CreateClassService;
use Exception;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    use Pagination;
    private $gradeRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->classRepository = new ClassRepository();
    }

    /**
     * @OA\Get(
     * path="/classes",
     * summary="Get Classes",
     * description="Get a list of Classes",
     * operationId="index",
     * tags={"Class"},
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
     *         @OA\Items(ref="#/components/schemas/Classes")
     *      ),
     *    ),
     *  ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $paginated = $this->paginate($request);
            $classes = $this->classRepository->all($paginated["limit"], $paginated["offset"]);

            return response()->json($classes, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Post(
     * path="/classes",
     * summary="Create Class",
     * description="Create Class by name",
     * operationId="store",
     * tags={"Class"},
     * security={ {"bearerAuth":{}} },
     * @OA\RequestBody(
     *    required=true,
     *    description="Send subject_id, grade_id and user_id",
     *    @OA\JsonContent(
     *       required={"subject_id", "grade_id", "user_id"},
     *       @OA\Property(property="subject_id", type="integer", example="1"),
     *       @OA\Property(property="grade_id", type="integer", example="5"),
     *       @OA\Property(property="user_id", type="integer", example="6", description="The user that will teach the class"),
     *    ),
     * ),
     * @OA\Response(
     *     response=201,
     *     description="Created",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/Classes",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function store(ClassRequest $request)
    {
        try {
            $input = $request->only(["subject_id", "grade_id", "user_id"]);

            $class = (new CreateClassService())->execute($input);

            return response()->json($class->format(), HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Put(
     * path="/classes/{id}",
     * summary="Update Class",
     * description="Update Class",
     * operationId="update",
     * security={ {"bearerAuth":{}} },
     * tags={"Class"},
     * @OA\Parameter(
     *      name="id",
     *      description="Class id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     *
     * @OA\RequestBody(
     *    required=true,
     *    description="Send subject_id, grade_id and user_id",
     *    @OA\JsonContent(
     *       required={"subject_id", "grade_id", "user_id"},
     *       @OA\Property(property="subject_id", type="integer", example="1"),
     *       @OA\Property(property="grade_id", type="integer", example="5"),
     *       @OA\Property(property="user_id", type="integer", example="6", description="The user that will teach the class"),
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
            $input = $request->only(["subject_id", "grade_id", "user_id"]);
            $this->classRepository->update($id, $input);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     * path="/classes/{id}",
     * summary="Get Class",
     * @OA\Parameter(
     *      name="id",
     *      description="Class id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Show Class by id",
     * operationId="show",
     * tags={"Class"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/Classes",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function show(int $id)
    {
        try {
            $class = $this->classRepository->findById($id)->format();

            return response()->json($class, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete(
     * path="/classes/{id}",
     * summary="Delete Class",
     * @OA\Parameter(
     *      name="id",
     *      description="Class id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Delete Class by id",
     * operationId="destroy",
     * tags={"Class"},
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
            $this->classRepository->delete($id);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }
}
