<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class StudentController extends Controller
{
    public function generateStudentNumber() {
        return strtoupper(substr(md5(Carbon::now()), 0, 8));
    }
}
