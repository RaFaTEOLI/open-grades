<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\API\HttpStatus;
use App\Http\Requests\User\InviteUserRequest;
use App\Http\Requests\User\UserRequest;
use App\Repositories\User\UserRepository;
use App\Services\User\CreateUserService;
use Exception;

class UserController extends Controller
{
    use RegistersUsers;

    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        $userLoginAttempt = auth("api")->attempt([
            "email" => request("email"),
            "password" => request("password"),
        ]);

        if ($userLoginAttempt) {
            return $this->createNewToken($userLoginAttempt);
        } else {
            return response()->json(["error" => "Unauthorized"], HttpStatus::UNAUTHORIZED);
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(InviteUserRequest $request)
    {
        try {
            $input = $request->all();

            $createUserService = new CreateUserService();
            $user = $createUserService->execute($input);

            // Sends Email Verification
            $user->sendEmailVerificationNotification();

            return response()->json($user->format(), HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    public function store(UserRequest $request)
    {
        try {
            $input = $request->all();

            $createUserService = new CreateUserService();
            $user = $createUserService->execute($input);

            // Sends Email Verification
            $user->sendEmailVerificationNotification();

            return response()->json($user->format(), HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth("api")->logout();

        return response()->json(["message" => "User successfully signed out"]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth("api")->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken(string $token)
    {
        return response()->json([
            "access_token" => $token,
            "token_type" => "bearer",
            "expires_in" =>
            auth("api")
                ->factory()
                ->getTTL() * 60,
            "user" => auth("api")->user(),
        ]);
    }

    /**
     * update user by id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, Request $request)
    {
        try {
            $input = $request->all();

            $this->userRepository->update($id, $input);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user()->format();
        return response()->json($user, HttpStatus::SUCCESS);
    }

    /**
     * Show an user by id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try {
            $user = $this->userRepository->findById($id);

            return response()->json($user, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    public function profile()
    {
        if (Auth::user()->hasRole("student")) {
            $student = $this->studentRepository->findById(Auth::user()->id);
            return response()->json($student, HttpStatus::SUCCESS);
        } else {
            $user = $this->userRepository->findById(Auth::user()->id);
            return response()->json($user, HttpStatus::SUCCESS);
        }
    }

    /**
     * Remove an user
     *
     * @return void
     */
    public function destroy(int $id)
    {
        try {
            $this->userRepository->delete($id);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::UNAUTHORIZED);
        }
    }

    /**
     * Show all users
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $user = $this->userRepository->all();

        return response()->json($user, HttpStatus::SUCCESS);
    }
}
