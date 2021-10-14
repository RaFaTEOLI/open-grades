<?php

namespace App\Http\Controllers;

use App\Repositories\Student\StudentRepository;
use App\Repositories\Teacher\TeacherRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalStudents = count((new StudentRepository())->all());
        $newStudents = (new StudentRepository())->getNewCount();
        $totalTeachers = count((new TeacherRepository())->all());

        return view('home', ["totalStudents" => $totalStudents, "newStudents" => $newStudents, "totalTeachers" => $totalTeachers]);
    }
}
