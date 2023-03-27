<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Requests\Year\YearRequest;
use App\Http\Traits\Pagination;
use App\Repositories\Year\YearRepository;
use Exception;
use Illuminate\Http\Request;

class YearController extends Controller
{
    use Pagination;
    private $yearRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->yearRepository = new YearRepository();
    }

    /**
     * @OA\Get(
     * path="/years",
     * summary="Get Years",
     * description="Get a list of years",
     * operationId="index",
     * tags={"Year"},
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
     *         @OA\Items(ref="#/components/schemas/Year")
     *      ),
     *    ),
     *  ),
     * )
     */
    public function index(PaginationRequest $request)
    {
        try {
            $paginated = $this->paginate($request);
            $years = $this->yearRepository->all($paginated["limit"], $paginated["offset"]);

            return response()->json($years, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Post(
     * path="/years",
     * summary="Create School Year",
     * description="Create School Year by start_date and end_date",
     * operationId="store",
     * tags={"Subject"},
     * security={ {"bearerAuth":{}} },
     * @OA\RequestBody(
     *    required=true,
     *    description="Send start_date and end_date",
     *    @OA\JsonContent(
     *       required={"start_date","end_date"},
     *       @OA\Property(property="start_date", type="datetime", example="2020-01-31"),
     *       @OA\Property(property="end_date", type="datetime", example="2020-11-31"),
     *    ),
     * ),
     * @OA\Response(
     *     response=201,
     *     description="Created",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/Year",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function store(YearRequest $request)
    {
        try {
            $input = $request->only(["start_date", "end_date"]);

            $year = $this->yearRepository->store($input);

            return response()->json($year->format(), HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Put(
     * path="/years/{id}",
     * summary="Update Year",
     * description="Update Year",
     * operationId="update",
     * security={ {"bearerAuth":{}} },
     * tags={"Year"},
     * @OA\Parameter(
     *      name="id",
     *      description="Year id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     *
     * @OA\RequestBody(
     *    required=true,
     *    description="Send start_date, end_date, closed",
     *    @OA\JsonContent(
     *       @OA\Property(property="start_date", type="datetime", example="2020-01-31"),
     *       @OA\Property(property="end_date", type="datetime", example="2020-11-31"),
     *       @OA\Property(property="closed", type="boolean", example="1"),
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
            $input = $request->only(["start_date", "end_date", "closed"]);
            $this->yearRepository->update($id, $input);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     * path="/years/{id}",
     * summary="Get Year",
     * @OA\Parameter(
     *      name="id",
     *      description="Year id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Show Year by id",
     * operationId="show",
     * tags={"Year"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/Year",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function show(int $id)
    {
        try {
            $year = $this->yearRepository->findById($id);

            return response()->json($year, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete(
     * path="/years/{id}",
     * summary="Delete Year",
     * @OA\Parameter(
     *      name="id",
     *      description="Year id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Delete year by id",
     * operationId="destroy",
     * tags={"Year"},
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
            $this->yearRepository->delete($id);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }
}
