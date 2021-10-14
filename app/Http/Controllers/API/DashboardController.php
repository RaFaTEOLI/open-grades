<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Student\StudentRepository;
use App\Repositories\Teacher\TeacherRepository;
use Exception;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
    }

    /**
     * @OA\Get(
     * path="/dashboard",
     * summary="Get Dashboard Data",
     * description="Get all dashboard data",
     * operationId="index",
     * tags={"Dashboard"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/Dashboard")
     *      ),
     *    ),
     *  ),
     * )
     */
    public function index()
    {
        try {
            $totalStudents = count((new StudentRepository())->all());
            $newStudents = (new StudentRepository())->getNewCount();
            $totalTeachers = count((new TeacherRepository())->all());

            return response()->json(["totalStudents" => $totalStudents, "newStudents" => $newStudents, "totalTeachers" => $totalTeachers], HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }
}
