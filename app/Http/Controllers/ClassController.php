<?php

namespace App\Http\Controllers;

use App\Http\Requests\Class\ClassRequest;
use App\Repositories\Class\ClassRepository;
use App\Repositories\Configuration\ConfigurationRepository;
use App\Repositories\Grade\GradeRepository;
use App\Repositories\Student\StudentRepository;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\Teacher\TeacherRepository;
use App\Services\Class\CreateClassService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    private $classRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->classRepository = new ClassRepository();
    }

    public function index()
    {
        try {
            $classes = $this->classRepository->all();

            if (Auth::user()->hasRole("student")) {
                return view("student_classes/class/classes", [
                    "classes" => $classes,
                    "canStudentEnroll" => (new ConfigurationRepository())->findByName('can-student-enroll')
                ]);
            } else if (Auth::user()->hasRole("responsible")) {
                return view("student_classes/class/classes", [
                    "classes" => $classes,
                    "students" => (new StudentRepository())->all()
                ]);
            }

            return view("classes/classes", [
                "classes" => $classes,
            ]);
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function store(ClassRequest $request)
    {
        try {
            $input = $request->only(["subject_id", "grade_id", "user_id"]);

            (new CreateClassService())->execute($input);

            return redirect()
                ->route("classes")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function update(int $id, Request $request)
    {
        try {
            $input = $request->only(["subject_id", "grade_id", "user_id"]);
            $this->classRepository->update($id, $input);

            return redirect()
                ->route("classes")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function show(int $id)
    {
        try {
            $class = $this->classRepository->findById($id);
            $grades = (new GradeRepository())->all();
            $subjects = (new SubjectRepository())->all();
            $teachers = (new TeacherRepository())->all();

            $response = [
                "class" => $class, "grades" => $grades,
                "subjects" => $subjects,
                "teachers" => $teachers
            ];

            if (Auth::user()->hasRole(['admin', 'teacher'])) {
                $response["students"] = (new StudentRepository())->findStudentsByClassId($id);
            }

            return view("classes/class", $response);
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function new()
    {
        try {
            $grades = (new GradeRepository())->all();
            $subjects = (new SubjectRepository())->all();
            $teachers = (new TeacherRepository())->all();

            return view("classes/class", [
                "grades" => $grades,
                "subjects" => $subjects,
                "teachers" => $teachers
            ]);
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->classRepository->delete($id);

            return redirect()
                ->route("classes")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }
}
