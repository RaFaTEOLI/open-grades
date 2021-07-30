<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\API\HttpStatus;
use App\Http\Requests\User\InviteUserRequest;
use App\Http\Requests\User\UserRequest;
use App\Http\Traits\Pagination;
use App\Repositories\User\UserRepository;
use App\Services\User\CreateUserService;
use Exception;

class UserController extends Controller
{
    use Pagination;
    use RegistersUsers;

    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * @OA\Post(
     * path="/login",
     * summary="Sign in",
     * description="Login by email, password",
     * operationId="login",
     * tags={"Authentication"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="user@email.com"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="access_token", type="string", format="access_token", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTYyNjgyMzQ1OCwiZXhwIjoxNjI2ODI3MDU4LCJuYmYiOjE2MjY4MjM0NTgsImp0aSI6IkZmdWVSa21DRDVKbGJiZTUiLCJzdWIiOjEsInBydiI6IjIzd4rdsffdYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.IRcT8xxb8XqMmRCMMjEO_WZF764k6VV-gBDCXtQLBiU"),
     *       @OA\Property(property="token_type", type="string", format="string", example="bearer"),
     *       @OA\Property(property="expires_in", type="integer", format="string", example=3600),
     *       @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *    ),
     *  ),
     * )
     *
     */
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
            return response()->json(["error" => "Sorry, wrong email address or password. Please try again"], HttpStatus::UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * @OA\Post(
     * path="/register",
     * summary="Sign up",
     * description="Sign up by name, email, password",
     * operationId="register",
     * tags={"Authentication"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Send user name, email, password and hash to sign up",
     *    @OA\JsonContent(
     *       required={"name", "email","password", "hash"},
     *       @OA\Property(property="name", type="string", example="user@email.com"),
     *       @OA\Property(property="email", type="string", format="email", example="user@email.com"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *       @OA\Property(property="hash", type="string", example="2y10mQJ6icVKtp7anWURyy1WOMEDM26k7SI4CqJOFhgQcqo4bEr8RVW"),
     *    ),
     * ),
     * @OA\Response(
     *     response=201,
     *     description="Created",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/UserRoles",
     *      ),
     *    ),
     *  ),
     * )
     */
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

    /**
     * @OA\Post(
     * path="/users",
     * summary="Create User",
     * description="Create user by name, email, password",
     * operationId="register",
     * tags={"User"},
     * security={ {"bearerAuth":{}} },
     * @OA\RequestBody(
     *    required=true,
     *    description="Send email, password",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="user@email.com"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *    ),
     * ),
     * @OA\Response(
     *     response=201,
     *     description="Created",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/UserRoles",
     *      ),
     *    ),
     *  ),
     * )
     */
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
     * @OA\Get(
     * path="/logout",
     * summary="Logout",
     * description="Log the user out (Invalidate the token)",
     * operationId="logout",
     * tags={"Authentication"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *      @OA\Property(property="message", type="string", example="User successfully signed out"),
     *      ),
     *    ),
     *  ),
     * )
     */
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
            "user" => auth("api")->user()->formatSimple(),
        ]);
    }

    /**
     * @OA\Put(
     * path="/users/{id}",
     * summary="Update User",
     * description="Update User",
     * operationId="update",
     * security={ {"bearerAuth":{}} },
     * tags={"User"},
     * @OA\Parameter(
     *      name="id",
     *      description="User id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     *
     * @OA\RequestBody(
     *    required=true,
     *    description="Send name, email, photo to update user",
     *    @OA\JsonContent(
     *       @OA\Property(property="name", type="string", example="user@email.com"),
     *       @OA\Property(property="email", type="string", format="email", example="user@email.com"),
     *       @OA\Property(property="photo", type="string", example="/images/johndoe.png"),
     *    ),
     * ),
     * @OA\Response(
     *     response=204,
     *     description="No Content",
     *    ),
     *  ),
     * )
     */
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
     * @OA\Get(
     * path="/details",
     * summary="Get User Details",
     * description="Get details from the user signed in",
     * operationId="details",
     * tags={"Authentication"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/UserRoles",
     *      ),
     *    ),
     *  ),
     * )
     */
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
     * @OA\Get(
     * path="/users/{id}",
     * summary="Get User",
     * @OA\Parameter(
     *      name="id",
     *      description="User id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Show user data by id",
     * operationId="show",
     * tags={"User"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/UserRoles",
     *      ),
     *    ),
     *  ),
     * )
     */
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

    /**
     * @OA\Get(
     * path="/profile",
     * summary="Get User Profile",
     * description="Show user profile",
     * operationId="profile",
     * tags={"User"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/UserRoles",
     *      ),
     *    ),
     *  ),
     * )
     */
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
     * @OA\Delete(
     * path="/users/{id}",
     * summary="Delete User",
     * @OA\Parameter(
     *      name="id",
     *      description="User id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Delete user by id",
     * operationId="destroy",
     * tags={"User"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=204,
     *     description="No Content",
     *    ),
     *  ),
     * )
     */
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
     * @OA\Get(
     * path="/users",
     * summary="Get Users",
     * description="Get a list of users",
     * operationId="all",
     * tags={"User"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/UserRoles")
     *      ),
     *    ),
     *  ),
     * )
     */
    /**
     * Show all users
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        try {
            $paginated = $this->paginate($request);

            $user = $this->userRepository->all($paginated["limit"], $paginated["offset"]);

            return response()->json($user, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::UNAUTHORIZED);
        }
    }
}
