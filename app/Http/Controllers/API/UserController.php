<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\API\HttpStatus;
use App\Repositories\User\UserRepository;
use App\Services\User\CreateUserService;
use Exception;
use App\Models\User;

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
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), User::validationRules());

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()], HttpStatus::BAD_REQUEST);
            }

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
    protected function createNewToken($token)
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
    public function update($id, Request $request)
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
    public function show($id)
    {
        $user = $this->userRepository->findById($id);

        return response()->json($user, HttpStatus::SUCCESS);
    }

    /**
     * Remove an user
     *
     * @return void
     */
    public function destroy($id)
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
