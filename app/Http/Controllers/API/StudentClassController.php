<?php

namespace App\Http\Controllers\API;

use App\Exceptions\NotResponsible;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentClass\StudentClassRequest;
use App\Http\Traits\Pagination;
use App\Repositories\Configuration\ConfigurationRepository;
use App\Repositories\StudentClass\StudentClassRepository;
use App\Services\Class\CreateClassService;
use App\Services\StudentClass\CreateStudentClassService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentClassController extends Controller
{
    use Pagination;
    private $gradeRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->studentClassRepository = new StudentClassRepository();
    }

    /**
     * @OA\Get(
     * path="/student/{studentId}/classes",
     * summary="Get Classes from Student",
     * description="Get a list of Classes from Student",
     * operationId="index",
     * tags={"Student Class"},
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
     * @OA\Parameter(
     *      name="studentId",
     *      description="Student id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/StudentsClasses")
     *      ),
     *    ),
     *  ),
     * )
     */
    public function index(Request $request, int $studentId)
    {
        try {
            $paginated = $this->paginate($request);
            $classes = $this->studentClassRepository->all($paginated["limit"], $paginated["offset"]);

            if (Auth::user()->hasRole("student")) {
                return response()->json([
                    "classes" => $classes,
                    "canStudentEnroll" => (new ConfigurationRepository())->findByName('can-student-enroll')
                ], HttpStatus::SUCCESS);
            } else if (Auth::user()->hasRole("responsible")) {
                $classes = (new StudentClassRepository())->findClassesByStudentId($studentId);
            }
            return response()->json([
                "classes" => $classes,
                "studentId" => $studentId
            ], HttpStatus::SUCCESS);

            return response()->json($classes, HttpStatus::SUCCESS);
        } catch (NotResponsible $nR) {
            return response()->json(["message" => __("exceptions.not_responsible")], HttpStatus::BAD_REQUEST);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Post(
     * path="/student/classes",
     * summary="Enroll Student to a class",
     * description="Enroll student by class_id and student_id",
     * operationId="store",
     * tags={"Student Class"},
     * security={ {"bearerAuth":{}} },
     * @OA\RequestBody(
     *    required=true,
     *    description="Send class_id and student_id",
     *    @OA\JsonContent(
     *       required={"class_id", "student_id"},
     *       @OA\Property(property="class_id", type="integer", example="1"),
     *       @OA\Property(property="student_id", type="integer", example="1"),
     *    ),
     * ),
     * @OA\Response(
     *     response=201,
     *     description="Created",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/StudentsClasses",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function store(StudentClassRequest $request)
    {
        try {
            $input = $request->only(["class_id"]);

            $studentClass = (new CreateStudentClassService())->execute($input);

            return response()->json($studentClass->format(), HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * @OA\Put(
     * path="/student/{studentId}/classes/{classId}",
     * summary="Update Student Class",
     * description="Update Student Class",
     * operationId="update",
     * security={ {"bearerAuth":{}} },
     * tags={"Student Class"},
     * @OA\Parameter(
     *      name="classId",
     *      description="Class id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * * @OA\Parameter(
     *      name="studentId",
     *      description="Student id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Send presence, absent, left_date",
     *    @OA\JsonContent(
     *       @OA\Property(property="presence", type="integer", example="6", description="Number of times he was present"),
     *       @OA\Property(property="absent", type="integer", example="10", description="Number of times he was absent"),
     *       @OA\Property(property="left_date", type="datetime", example="2021-06-12 10:00:00", description="Date he left or finished"),
     *    ),
     * ),
     * @OA\Response(
     *     response=204,
     *     description="No Content",
     *    ),
     *  ),
     * )
     */
    public function update(int $studentId, int $classId, Request $request)
    {
        try {
            $input = $request->only(["presence", "absent", "left_date"]);
            $this->studentClassRepository->update($studentId, $classId, $input);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     * path="/student/{studentId}/classes/{classId}",
     * summary="Get Student Class",
     * @OA\Parameter(
     *      name="classId",
     *      description="Class id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * @OA\Parameter(
     *      name="studentId",
     *      description="Student id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Show Student Class by class_id and student_id",
     * operationId="show",
     * tags={"Student Class"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/StudentsClasses",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function show(int $id)
    {
        try {
            $class = $this->studentClassRepository->findById($id)->format();

            return response()->json($class, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete(
     * path="/student/{studentId}/classes/{classId}",
     * summary="Delete Student Class",
     * @OA\Parameter(
     *      name="classId",
     *      description="Class id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * @OA\Parameter(
     *      name="studentId",
     *      description="Student id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Delete Student Class by student_id and class_id",
     * operationId="destroy",
     * tags={"Student Class"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=204,
     *     description="No Content",
     *    ),
     *  ),
     * )
     */
    public function destroy(int $studentId, int $classId = 0)
    {
        try {
            if ($classId == 0) {
                $classId = $studentId;
                $this->studentClassRepository->delete($classId);
            } else {
                $this->studentClassRepository->deleteByStudentAndClass($studentId, $classId);
            }

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }
}
