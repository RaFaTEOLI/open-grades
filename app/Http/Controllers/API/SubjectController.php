<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subject\SubjectRequest;
use App\Http\Traits\Pagination;
use App\Repositories\Subject\SubjectRepository;
use Exception;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    use Pagination;
    private $subjectRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->subjectRepository = new SubjectRepository();
    }

    /**
     * @OA\Get(
     * path="/subjects",
     * summary="Get Subjects",
     * description="Get a list of subjects",
     * operationId="index",
     * tags={"Subject"},
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
     *         @OA\Items(ref="#/components/schemas/Subject")
     *      ),
     *    ),
     *  ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $paginated = $this->paginate($request);
            $subjects = $this->subjectRepository->all($paginated["limit"], $paginated["offset"]);

            return response()->json($subjects, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Post(
     * path="/subjects",
     * summary="Create Subject",
     * description="Create Subject by name",
     * operationId="store",
     * tags={"Subject"},
     * security={ {"bearerAuth":{}} },
     * @OA\RequestBody(
     *    required=true,
     *    description="Send name",
     *    @OA\JsonContent(
     *       required={"name",},
     *       @OA\Property(property="name", type="string", example="Math"),
     *    ),
     * ),
     * @OA\Response(
     *     response=201,
     *     description="Created",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/Subject",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function store(SubjectRequest $request)
    {
        try {
            $input = $request->only(["name"]);

            $subject = $this->subjectRepository->store($input);

            return response()->json($subject->format(), HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Put(
     * path="/subjects/{id}",
     * summary="Update Subject",
     * description="Update Subject",
     * operationId="update",
     * security={ {"bearerAuth":{}} },
     * tags={"Subject"},
     * @OA\Parameter(
     *      name="id",
     *      description="Subject id",
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
     *       @OA\Property(property="name", type="string", example="Math"),
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
            $this->subjectRepository->update($id, $input);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     * path="/subjects/{id}",
     * summary="Get Subject",
     * @OA\Parameter(
     *      name="id",
     *      description="Subject id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Show Subject by id",
     * operationId="show",
     * tags={"Subject"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/Subject",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function show(int $id)
    {
        try {
            $subject = $this->subjectRepository->findById($id);

            return response()->json($subject, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete(
     * path="/subjects/{id}",
     * summary="Delete Subject",
     * @OA\Parameter(
     *      name="id",
     *      description="Subject id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Delete subject by id",
     * operationId="destroy",
     * tags={"Subject"},
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
            $this->subjectRepository->delete($id);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }
}
