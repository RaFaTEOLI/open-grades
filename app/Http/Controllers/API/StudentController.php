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

    public function index()
    {
        $students = $this->studentRepository->all();

        return response()->json($students, HttpStatus::SUCCESS);
    }

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

    public function show(int $id)
    {
        $student = $this->studentRepository->findById($id);

        return response()->json($student, HttpStatus::SUCCESS);
    }
}
