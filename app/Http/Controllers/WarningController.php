<?php

namespace App\Http\Controllers;

use App\Http\Requests\Warning\WarningRequest;
use App\Repositories\Warning\WarningRepository;
use App\Repositories\Student\StudentRepository;
use App\Services\Warning\CreateWarningService;
use Exception;
use Illuminate\Http\Request;

class WarningController extends Controller
{
    private $warningRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->warningRepository = new WarningRepository();
    }

    public function index()
    {
        try {
            $warnings = $this->warningRepository->all();

            return view("warnings/warnings", [
                "warnings" => $warnings,
            ]);
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function store(WarningRequest $request)
    {
        try {
            $input = $request->only(["student_id", "reporter_id", "class_id", "description"]);

            (new CreateWarningService())->execute($input);

            return redirect()
                ->route("warnings")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function update(int $id, Request $request)
    {
        try {
            $input = $request->only(["student_id", "reporter_id", "class_id", "description"]);
            $this->warningRepository->update($id, $input);

            return redirect()
                ->route("warnings")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function show(int $id)
    {
        try {
            $warning = $this->warningRepository->findById($id);

            return view("classes/class", ["warning" => $warning]);
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function new()
    {
        try {
            $students = (new StudentRepository())->all();

            return view("warnings/warning", [
                "students" => $students,
            ]);
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->warningRepository->delete($id);

            return redirect()
                ->route("warnings")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }
}
