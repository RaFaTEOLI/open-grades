<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Teacher\TeacherRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Teacher\TeacherRepository;
use App\Repositories\User\UserRepository;
use App\Services\User\CreateUserService;
use Exception;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    private $userRepository;
    private $teacherRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->userRepository = new UserRepository();
        $this->teacherRepository = new TeacherRepository();
    }

    public function index()
    {
        $teachers = $this->teacherRepository->all();

        return response()->json($teachers, HttpStatus::SUCCESS);
    }

    public function store(TeacherRequest $request)
    {
        try {
            $input = $request->all();
            $input["type"] = "RESPONSIBLE";

            $createUserService = new CreateUserService();
            $user = $createUserService->execute($input);

            // Sends Email Verification
            $user->sendEmailVerificationNotification();

            return response()->json($user->format(), HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    public function update($id, Request $request)
    {
        $input = $request->only(["name", "email"]);
        $this->userRepository->update($id, $input);

        return response()->noContent();
    }

    public function show($id)
    {
        $teacher = $this->teacherRepository->findById($id);

        return response()->json($teacher, HttpStatus::SUCCESS);
    }
}
