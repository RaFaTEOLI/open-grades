<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\User\UserRepository;
use App\Repositories\Student\StudentRepository;
use App\Services\User\CreateUserService;
use App\Repositories\RolesRepository\RolesRepository;
use App\Http\Requests\User\UserRequest;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $userRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->userRepository = new UserRepository();
        $this->studentRepository = new StudentRepository();
    }

    public function index()
    {
        $users = $this->userRepository->all();

        return view("admin/user/users", [
            "users" => $users,
        ]);
    }

    public function store(UserRequest $request)
    {
        try {
            $input = $request->all();

            $createUserService = new CreateUserService();
            $user = $createUserService->execute($input);

            // Sends Email Verification
            $user->sendEmailVerificationNotification();

            return redirect()
                ->route("users")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function show(int $id)
    {
        try {
            $user = $this->userRepository->findById($id);
            $roles = (new RolesRepository())->findRolesNotInUser($id);

            return view("admin/user/user", ["user" => $user, "roles" => $roles]);
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
                ->route("users")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function profile()
    {
        if (Auth::user()->hasRole("student")) {
            $student = $this->studentRepository->findById(Auth::user()->id);
            return view("students/student", ["student" => $student]);
        } else {
            $user = $this->userRepository->findById(Auth::user()->id);
            return view("admin/user/user", ["user" => $user]);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->userRepository->delete($id);

            return redirect()
                ->route("users")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }
}
