<?php

namespace App\Http\Controllers;

use App\Http\Requests\Teacher\TeacherRequest;
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

        return view("teachers/teachers", [
            "teachers" => $teachers,
        ]);
    }

    public function store(TeacherRequest $request)
    {
        try {
            $input = $request->all();
            $input["type"] = "TEACHER";

            $createUserService = new CreateUserService();
            $user = $createUserService->execute($input);

            // Sends Email Verification
            $user->sendEmailVerificationNotification();

            return redirect()
                ->route("teachers")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function update($id, Request $request)
    {
        $input = $request->only(["name", "email"]);
        $this->userRepository->update($id, $input);

        return redirect()
            ->route("teachers")
            ->withSuccess(__("actions.success"));
    }

    public function show($id)
    {
        $teacher = $this->teacherRepository->findById($id);

        return view("teachers/teacher", ["teacher" => $teacher]);
    }
}
