<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\Pagination;
use App\Repositories\Student\StudentRepository;
use Exception;

class ClassStudentsController extends Controller
{
    use Pagination;
    private $studentRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->studentRepository = new StudentRepository();
    }

    /**
     * @OA\Get(
     * path="/classes/{id}/students",
     * summary="Get Students from Class",
     * @OA\Parameter(
     *      name="id",
     *      description="Class id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Show Students from Class by id",
     * operationId="show",
     * tags={"Class"},
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
    public function show(int $id)
    {
        try {
            $class = $this->studentRepository->findStudentsByClassId($id);

            return response()->json($class, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }
}
