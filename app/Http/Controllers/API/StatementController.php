<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Statement\StatementRequest;
use App\Http\Traits\Pagination;
use App\Repositories\Statement\StatementRepository;
use App\Services\Statement\CreateStatementService;
use Exception;
use Illuminate\Http\Request;

class StatementController extends Controller
{
    use Pagination;
    private $statementRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->statementRepository = new StatementRepository();
    }

    /**
     * @OA\Get(
     * path="/statements",
     * summary="Get Statements",
     * description="Get a list of statements",
     * operationId="index",
     * tags={"Statement"},
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
     *         @OA\Items(ref="#/components/schemas/Statement")
     *      ),
     *    ),
     *  ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $paginated = $this->paginate($request);
            $statements = $this->statementRepository->all($paginated["limit"], $paginated["offset"]);

            return response()->json($statements, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Post(
     * path="/statements",
     * summary="Create Statement",
     * description="Create Statement",
     * operationId="store",
     * tags={"Statement"},
     * security={ {"bearerAuth":{}} },
     * @OA\RequestBody(
     *    required=true,
     *    description="Send Statement",
     *    @OA\JsonContent(
     *       required={"statement"},
     *       @OA\Property(property="subject", type="string", example="Closed School"),
     *       @OA\Property(property="statement", type="string", example="Friday the school will be closed"),
     *    ),
     * ),
     * @OA\Response(
     *     response=201,
     *     description="Created",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/Statement",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function store(StatementRequest $request)
    {
        try {
            $input = $request->only(["subject", "statement"]);

            $warning = (new CreateStatementService())->execute($input);

            return response()->json($warning, HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Put(
     * path="/statements/{id}",
     * summary="Update Statement",
     * description="Update Statement",
     * operationId="update",
     * security={ {"bearerAuth":{}} },
     * tags={"Statement"},
     * @OA\Parameter(
     *      name="id",
     *      description="Statement id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     *
     * @OA\RequestBody(
     *    required=true,
     *    description="Update statement",
     *    @OA\JsonContent(
     *       required={"statement"},
     *       @OA\Property(property="subject", type="string", example="Closed School"),
     *       @OA\Property(property="statement", type="string", example="Friday the school will be closed"),
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
            $input = $request->only(["subject", "statement"]);
            $this->statementRepository->update($id, $input);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     * path="/statements/{id}",
     * summary="Get Statement",
     * @OA\Parameter(
     *      name="id",
     *      description="Statement id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Show Statement by id",
     * operationId="show",
     * tags={"Statement"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/Statement",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function show(int $id)
    {
        try {
            $warning = $this->statementRepository->findById($id)->format();

            return response()->json($warning, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete(
     * path="/statements/{id}",
     * summary="Delete Statement",
     * @OA\Parameter(
     *      name="id",
     *      description="Warning id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Delete Statement by id",
     * operationId="destroy",
     * tags={"Statement"},
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
            $this->statementRepository->delete($id);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }
}
