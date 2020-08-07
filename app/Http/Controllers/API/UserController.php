<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\API\HttpStatus;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller 
{

    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login() { 

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) { 
            $user = Auth::user();
            $success['token'] = $user->api_token; 
            return response()->json(['success' => $success], HttpStatus::SUCCESS); 
        } 
        else{ 
            return response()->json(['error'=> 'Unauthorized'], HttpStatus::UNAUTHORIZED); 
        } 
    }

    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $token = Str::random(60);

        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email|unique:users', 
            'password' => 'required',
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=> $validator->errors()], HttpStatus::BAD_REQUEST);            
        }

        $input = $request->all(); 

        $input['password'] = Hash::make($input['password']);
        $input['api_token'] = $token;
        $user = User::create($input); 

        $success['token'] =  hash('sha256', $token);
        $success['user'] = $user->format();

        return response()->json(['success'=> $success], HttpStatus::CREATED); 
    }
    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        return response()->json(['success' => Auth::user()], HttpStatus::SUCCESS); 
    } 
}