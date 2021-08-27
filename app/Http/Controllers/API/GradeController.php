<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Grade\GradeRequest;
use App\Http\Traits\Pagination;
use App\Repositories\Grade\GradeRepository;
use Exception;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    use Pagination;
    private $gradeRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->gradeRepository = new GradeRepository();
    }

    /**
     * @OA\Get(
     * path="/grades",
     * summary="Get Grades",
     * description="Get a list of Grades",
     * operationId="index",
     * tags={"Grade"},
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
     *         @OA\Items(ref="#/components/schemas/Grade")
     *      ),
     *    ),
     *  ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $paginated = $this->paginate($request);
            $grades = $this->gradeRepository->all($paginated["limit"], $paginated["offset"]);

            return response()->json($grades, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Post(
     * path="/grades",
     * summary="Create Grade",
     * description="Create Grade by name",
     * operationId="store",
     * tags={"Grade"},
     * security={ {"bearerAuth":{}} },
     * @OA\RequestBody(
     *    required=true,
     *    description="Send name",
     *    @OA\JsonContent(
     *       required={"name"},
     *       @OA\Property(property="name", type="string", example="Preschool"),
     *    ),
     * ),
     * @OA\Response(
     *     response=201,
     *     description="Created",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/Grade",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function store(GradeRequest $request)
    {
        try {
            $input = $request->only(["name"]);

            $grade = $this->gradeRepository->store($input);

            return response()->json($grade->format(), HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Put(
     * path="/grades/{id}",
     * summary="Update Grade",
     * description="Update Grade",
     * operationId="update",
     * security={ {"bearerAuth":{}} },
     * tags={"Grade"},
     * @OA\Parameter(
     *      name="id",
     *      description="Grade id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     *
     * @OA\RequestBody(
     *    required=true,
     *    description="Send name",
     *    @OA\JsonContent(
     *       @OA\Property(property="name", type="string", example="Preschool"),
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
            $input = $request->only(["name"]);
            $this->gradeRepository->update($id, $input);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     * path="/grades/{id}",
     * summary="Get Grade",
     * @OA\Parameter(
     *      name="id",
     *      description="Grade id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Show Grade by id",
     * operationId="show",
     * tags={"Grade"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/Grade",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function show(int $id)
    {
        try {
            $grade = $this->gradeRepository->findById($id);

            return response()->json($grade, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete(
     * path="/grades/{id}",
     * summary="Delete Grade",
     * @OA\Parameter(
     *      name="id",
     *      description="Grade id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Delete Grade by id",
     * operationId="destroy",
     * tags={"Grade"},
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
            $this->gradeRepository->delete($id);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }
}
