<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subject\SubjectRequest;
use App\Repositories\Subject\SubjectRepository;
use Exception;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    private $subjectRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->subjectRepository = new SubjectRepository();
    }

    public function index()
    {
        try {
            $subjects = $this->subjectRepository->all();

            return view("subjects/subjects", [
                "subjects" => $subjects,
            ]);
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function store(SubjectRequest $request)
    {
        try {
            $input = $request->only(["name"]);

            $this->subjectRepository->store($input);

            return redirect()
                ->route("subjects")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function update(int $id, Request $request)
    {
        try {
            $input = $request->only(["name"]);
            $this->subjectRepository->update($id, $input);

            return redirect()
                ->route("subjects")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function show(int $id)
    {
        try {
            $subject = $this->subjectRepository->findById($id);

            return view("subjects/subject", ["subject" => $subject]);
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->subjectRepository->delete($id);

            return redirect()
                ->route("subjects")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }
}
