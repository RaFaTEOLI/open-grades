<?php

namespace App\Http\Controllers;

use App\Exceptions\AlreadyEnrolled;
use App\Exceptions\Forbidden;
use App\Exceptions\NotResponsible;
use App\Http\Requests\StudentClass\StudentClassRequest;
use App\Repositories\Classes\ClassRepository;
use App\Repositories\Configuration\ConfigurationRepository;
use App\Repositories\StudentClass\StudentClassRepository;
use App\Repositories\Grade\GradeRepository;
use App\Repositories\Student\StudentRepository;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\Teacher\TeacherRepository;
use App\Services\StudentClass\CreateStudentClassService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ItemNotFoundException;

class StudentClassController extends Controller
{
    private $studentClassRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->studentClassRepository = new StudentClassRepository();
    }

    public function index(int $studentId = 0)
    {
        try {
            $classes = $this->studentClassRepository->all();

            if (Auth::user()->hasRole("student")) {
                if ($studentId > 0) {
                    if ($studentId !== Auth::user()->id) {
                        throw new Forbidden('You cannot access this page!', 403);
                    }
                }
                $classes = (new StudentClassRepository())->findClassesByStudentId(Auth::user()->id);
                return view("student_classes/my_class/my_classes", [
                    "classes" => $classes,
                    "canStudentEnroll" => (new ConfigurationRepository())->findByName('can-student-enroll')
                ]);
            } else if (Auth::user()->hasRole("responsible")) {
                $classes = (new StudentClassRepository())->findClassesByStudentId($studentId);
                return view("student_classes/my_class/my_classes", [
                    "classes" => $classes,
                    "studentId" => $studentId
                ]);
            } else {
                return view("student_classes/my_class/my_classes", [
                    "classes" => $classes,
                    "studentId" => $studentId
                ]);
            }
        } catch (Forbidden $e) {
            return back()->with("error", __("exceptions.forbidden"));
        } catch (NotResponsible $nR) {
            return redirect()
                ->route("students")
                ->with("error", __("exceptions.not_responsible"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function store(StudentClassRequest $request)
    {
        try {
            if ($request->has('student_id')) {
                $input = $request->only(["class_id", "student_id"]);
            } else {
                $input = $request->only(["class_id"]);
            }

            (new CreateStudentClassService())->execute($input);

            return redirect()
                ->route("classes")
                ->withSuccess(__("actions.success"));
        } catch (AlreadyEnrolled $aR) {
            return redirect()
                ->route("students")
                ->with("error", __("exceptions.already_enrolled"));
        } catch (NotResponsible $e) {
            return redirect()
                ->route("students")
                ->with("error", __("exceptions.not_responisble"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function update(int $id, Request $request)
    {
        try {
            $input = $request->only(["class_id", "user_id", "presence", "absent", "enroll_date", "left_date"]);
            $this->studentClassRepository->update($id, $input);

            return redirect()
                ->route("classes")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function show(int $studentId, int $id = 0)
    {
        try {
            if ($studentId > 0) {
                $studentClass = $this->studentClassRepository->findClassesByStudentIdAndClassId($studentId, $id);
                $student = (new StudentRepository())->findById($studentId);
            } else {
                $studentClass = $this->studentClassRepository->findById($id);
            }

            if (Auth::user()->hasRole('student')) {
                $studentClass = $this->studentClassRepository->findById($id);
                $student = Auth::user();

                if ($studentClass->user_id !== Auth::user()->id) {
                    throw new Forbidden('You cannot access this page!', 403);
                }
            }

            $class = (new ClassRepository())->findById($studentClass->class_id);
            $grades = (new GradeRepository())->all();
            $subjects = (new SubjectRepository())->all();
            $teachers = (new TeacherRepository())->all();
            $students = (new StudentRepository())->findStudentsByClassId($class->id);

            return view("student_classes/my_class/my_class", [
                "class" => $class, "grades" => $grades,
                "subjects" => $subjects,
                "teachers" => $teachers,
                "studentClass" => $studentClass,
                "students" => $students,
                "student" => $student
            ]);
        } catch (ItemNotFoundException $e) {
            return back()->with("error", __("exceptions.item_not_found"));
        } catch (Forbidden $e) {
            return back()->with("error", __("exceptions.forbidden"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function destroy(int $studentId, int $classId = 0)
    {
        try {
            if ($classId == 0) {
                $classId = $studentId;
                $this->studentClassRepository->delete($classId);
            } else {
                $this->studentClassRepository->deleteByStudentAndClass($studentId, $classId);
            }

            return redirect()
                ->route("classes")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }
}
