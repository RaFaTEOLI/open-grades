<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Teacher\TeacherRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\Pagination;
use App\Repositories\Teacher\TeacherRepository;
use App\Repositories\User\UserRepository;
use App\Services\User\CreateUserService;
use Exception;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    use Pagination;
    private $userRepository;
    private $teacherRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->userRepository = new UserRepository();
        $this->teacherRepository = new TeacherRepository();
    }

    /**
     * @OA\Get(
     * path="/teachers",
     * summary="Get Teachers",
     * description="Get a list of teachers",
     * operationId="index",
     * tags={"Teacher"},
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
     *         @OA\Items(ref="#/components/schemas/User")
     *      ),
     *    ),
     *  ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $paginated = $this->paginate($request);
            $teachers = $this->teacherRepository->all($paginated["limit"], $paginated["offset"]);

            return response()->json($teachers, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Post(
     * path="/teachers",
     * summary="Create Teacher",
     * description="Create Teacher by name, email, password",
     * operationId="store",
     * tags={"Teacher"},
     * security={ {"bearerAuth":{}} },
     * @OA\RequestBody(
     *    required=true,
     *    description="Send name, email, password",
     *    @OA\JsonContent(
     *       required={"name","email", "password"},
     *       @OA\Property(property="name", type="string", example="John Doe"),
     *       @OA\Property(property="email", type="string", example="johndoe@email.com"),
     *       @OA\Property(property="password", type="string", example="12345678"),
     *    ),
     * ),
     * @OA\Response(
     *     response=201,
     *     description="Created",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/Teacher",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function store(TeacherRequest $request)
    {
        try {
            $input = $request->all();
            $input["type"] = "TEACHER";

            $createUserService = new CreateUserService();
            $user = $createUserService->execute($input);

            // Sends Email Verification
            $user->sendEmailVerificationNotification();

            return response()->json($user->format(), HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Put(
     * path="/teachers/{id}",
     * summary="Update Teacher",
     * description="Update Teacher",
     * operationId="update",
     * security={ {"bearerAuth":{}} },
     * tags={"Teacher"},
     * @OA\Parameter(
     *      name="id",
     *      description="Teacher id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     *
     * @OA\RequestBody(
     *    required=true,
     *    description="Send name, email to update teacher",
     *    @OA\JsonContent(
     *       @OA\Property(property="name", type="string", example="John Doe"),
     *       @OA\Property(property="email", type="string", example="johndoe@email.com"),
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
            $input = $request->only(["name", "email"]);
            $this->userRepository->update($id, $input);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     * path="/teachers/{id}",
     * summary="Get Teacher",
     * @OA\Parameter(
     *      name="id",
     *      description="Teacher id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Show Teacher by id",
     * operationId="show",
     * tags={"Teacher"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/Teacher",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function show(int $id)
    {
        $teacher = $this->teacherRepository->findById($id);

        return response()->json($teacher, HttpStatus::SUCCESS);
    }
}
