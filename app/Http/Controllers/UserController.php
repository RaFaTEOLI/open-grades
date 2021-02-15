<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Validator;
use App\Services\User\CreateUserService;
use App\Repositories\RolesRepository\RolesRepository;
use App\Http\Requests\User\UserRequest;
use Exception;

class UserController extends Controller
{
    private $userRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->userRepository = new UserRepository();
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

    public function show($id)
    {
        $user = $this->userRepository->findById($id);
        $roles = (new RolesRepository())->findRolesNotInUser($id);

        return view("admin/user/user", ["user" => $user, "roles" => $roles]);
    }

    public function update($id, Request $request)
    {
        $input = $request->only(["name", "email"]);
        $this->userRepository->update($id, $input);

        return redirect()
            ->route("users")
            ->withSuccess(__("actions.success"));
    }

    public function destroy($id)
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
