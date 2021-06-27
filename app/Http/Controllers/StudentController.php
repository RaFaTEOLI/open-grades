<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\StudentRequest;
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

        return view("students/students", [
            "students" => $students,
        ]);
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

            return redirect()
                ->route("students")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function update(int $id, Request $request)
    {
        try {
            $input = $request->only(["name", "email"]);
            $this->userRepository->update($id, $input);

            return redirect()
                ->route("students")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function show(int $id)
    {
        $student = $this->studentRepository->findById($id);

        return view("students/student", ["student" => $student]);
    }
}
