<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EvaluationType\EvaluationTypeRequest;
use App\Http\Requests\EvaluationType\UpdateEvaluationTypeRequest;
use App\Http\Traits\Pagination;
use App\Repositories\EvaluationType\EvaluationTypeRepository;
use Exception;
use Illuminate\Http\Request;

class EvaluationTypeController extends Controller
{
    use Pagination;
    private $evaluationRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->evaluationRepository = new EvaluationTypeRepository();
    }

    /**
     * @OA\Get(
     * path="/evaluation-types",
     * summary="Get Evaluation Types",
     * description="Get a list of Evaluation Types",
     * operationId="index",
     * tags={"Evaluation Types"},
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
     *         @OA\Items(ref="#/components/schemas/EvaluationType")
     *      ),
     *    ),
     *  ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $paginated = $this->paginate($request);
            $evaluationTypes = $this->evaluationRepository->all($paginated["limit"], $paginated["offset"]);

            return response()->json($evaluationTypes, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Post(
     * path="/evaluation-types",
     * summary="Create Evaluation Type",
     * description="Create Evaluation Type by name",
     * operationId="store",
     * tags={"Evaluation Types"},
     * security={ {"bearerAuth":{}} },
     * @OA\RequestBody(
     *    required=true,
     *    description="Send name",
     *    @OA\JsonContent(
     *       required={"name", "weight"},
     *       @OA\Property(property="name", type="string", example="Semester Exam"),
     *       @OA\Property(property="weight", type="number", example="10"),
     *    ),
     * ),
     * @OA\Response(
     *     response=201,
     *     description="Created",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/EvaluationType",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function store(EvaluationTypeRequest $request)
    {
        try {
            $input = $request->only(["name", "weight"]);

            $evaluationType = $this->evaluationRepository->store($input);

            return response()->json($evaluationType->format(), HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Put(
     * path="/evaluation-types/{id}",
     * summary="Update Evaluation Type",
     * description="Update Evaluation Type",
     * operationId="update",
     * security={ {"bearerAuth":{}} },
     * tags={"Evaluation Types"},
     * @OA\Parameter(
     *      name="id",
     *      description="Evaluation Type id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     *
     * @OA\RequestBody(
     *    required=true,
     *    description="Send name and weight",
     *    @OA\JsonContent(
     *       @OA\Property(property="name", type="string", example="Semester Exam"),
     *       @OA\Property(property="weight", type="number", example="10"),
     *    ),
     * ),
     * @OA\Response(
     *     response=204,
     *     description="No Content",
     *    ),
     *  ),
     * )
     */
    public function update(int $id, UpdateEvaluationTypeRequest $request)
    {
        try {
            $input = $request->only(["name", "weight"]);
            $this->evaluationRepository->update($id, $input);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     * path="/evaluation-types/{id}",
     * summary="Get Evaluation Type",
     * @OA\Parameter(
     *      name="id",
     *      description="Evaluation Type id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Show Evaluation Type by id",
     * operationId="show",
     * tags={"Evaluation Types"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/EvaluationType",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function show(int $id)
    {
        try {
            $evaluationType = $this->evaluationRepository->findById($id);

            return response()->json($evaluationType, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete(
     * path="/evaluation-types/{id}",
     * summary="Delete Evaluation Type",
     * @OA\Parameter(
     *      name="id",
     *      description="Evaluation Type id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Delete Evaluation Type by id",
     * operationId="destroy",
     * tags={"Evaluation Types"},
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
            $this->evaluationRepository->delete($id);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }
}
