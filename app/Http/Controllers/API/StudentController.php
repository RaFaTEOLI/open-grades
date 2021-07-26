<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Student\StudentRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Student\StudentRepository;
use App\Repositories\User\UserRepository;
use App\Services\User\CreateUserService;
use Exception;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    private $userRepository;
    private $studentRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->userRepository = new UserRepository();
        $this->studentRepository = new StudentRepository();
    }

    /**
     * @OA\Get(
     * path="/students",
     * summary="Get Students",
     * description="Get a list of students",
     * operationId="index",
     * tags={"Student"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/Student")
     *      ),
     *    ),
     *  ),
     * )
     */
    public function index()
    {
        $students = $this->studentRepository->all();

        return response()->json($students, HttpStatus::SUCCESS);
    }

    /**
     * @OA\Post(
     * path="/students",
     * summary="Create Student",
     * description="Create Student by name, email, password",
     * operationId="store",
     * tags={"Student"},
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
     *      ref="#/components/schemas/Student",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function store(StudentRequest $request)
    {
        try {
            $input = $request->all();
            $input["type"] = "STUDENT";

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
     * path="/students/{id}",
     * summary="Update Student",
     * description="Update Student",
     * operationId="update",
     * security={ {"bearerAuth":{}} },
     * tags={"Student"},
     * @OA\Parameter(
     *      name="id",
     *      description="Student id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     *
     * @OA\RequestBody(
     *    required=true,
     *    description="Send name, email to update student",
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
     * path="/students/{id}",
     * summary="Get Student",
     * @OA\Parameter(
     *      name="id",
     *      description="Student id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Show Student by id",
     * operationId="show",
     * tags={"Student"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/Student",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function show(int $id)
    {
        $student = $this->studentRepository->findById($id);

        return response()->json($student, HttpStatus::SUCCESS);
    }
}
