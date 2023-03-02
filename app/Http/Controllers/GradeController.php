<?php

namespace App\Http\Controllers;

use App\Http\Requests\Grade\GradeRequest;
use App\Repositories\Classes\ClassRepository;
use App\Repositories\Grade\GradeRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    private $gradeRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->gradeRepository = new GradeRepository();
    }

    public function index()
    {
        try {
            $grades = $this->gradeRepository->all();

            return view("grades/grades", [
                "grades" => $grades,
            ]);
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function store(GradeRequest $request)
    {
        try {
            $input = $request->only(["name"]);

            $this->gradeRepository->store($input);

            return redirect()
                ->route("grades")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function update(int $id, Request $request)
    {
        try {
            $input = $request->only(["name"]);
            $this->gradeRepository->update($id, $input);

            return redirect()
                ->route("grades")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function show(int $id)
    {
        try {
            $grade = $this->gradeRepository->findById($id);

            return view("grades/grade", ["grade" => $grade]);
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->gradeRepository->delete($id);

            return redirect()
                ->route("grades")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }
}
