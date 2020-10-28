<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use App\Http\Controllers\API\HttpStatus;
use App\Repositories\UserRepository;
use App\Rules\ValidLink;
use Exception;

class UserController extends Controller
{
    use RegistersUsers;

    private $userRepository;

    public function __construct()
    {
        $this->userRepository = (new UserRepository());
    }

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->api_token;
            return response()->json(['success' => $success], HttpStatus::SUCCESS);
        } else {
            return response()->json(['error' => 'Unauthorized'], HttpStatus::UNAUTHORIZED);
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
            $token = Str::random(60);

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'hash' => ['required', new ValidLink],
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], HttpStatus::BAD_REQUEST);
            }

            $input = $request->all();

            $input['api_token'] = $token;

            $user = $this->userRepository->register($input);
            // Sends Email Verification
            $user->sendEmailVerificationNotification();

            $success['token'] =  hash('sha256', $token);
            $success['user'] = $user->format();

            return response()->json(['success' => $success], HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], HttpStatus::SUCCESS);
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
