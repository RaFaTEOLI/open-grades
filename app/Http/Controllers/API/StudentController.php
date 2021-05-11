<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;

class StudentController extends Controller
{
    private $userRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->userRepository = new UserRepository();
    }

    public function index()
    {
        $students = $this->userRepository->allStudents();

        return response()->json($students, HttpStatus::SUCCESS);
    }
}
