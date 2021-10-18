<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvaluationType\EvaluationTypeRequest;
use App\Http\Requests\EvaluationType\UpdateEvaluationTypeRequest;
use App\Repositories\EvaluationType\EvaluationTypeRepository;
use Exception;

class EvaluationTypeController extends Controller
{
    private $evaluationTypeRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->evaluationTypeRepository = new EvaluationTypeRepository();
    }

    public function index()
    {
        try {
            $evaluationTypes = $this->evaluationTypeRepository->all();

            return view("evaluation_types/evaluation_types", [
                "evaluationTypes" => $evaluationTypes,
            ]);
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function store(EvaluationTypeRequest $request)
    {
        try {
            $input = $request->only(["name", "weight"]);

            $this->evaluationTypeRepository->store($input);

            return redirect()
                ->route("evaluation-types")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function update(int $id, UpdateEvaluationTypeRequest $request)
    {
        try {
            $input = $request->only(["name", "weight"]);
            $this->evaluationTypeRepository->update($id, $input);

            return redirect()
                ->route("evaluation-types")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function show(int $id)
    {
        try {
            $evaluationType = $this->evaluationTypeRepository->findById($id);

            return view("evaluation_types/evaluation_type", ["evaluationType" => $evaluationType]);
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->evaluationTypeRepository->delete($id);

            return redirect()
                ->route("evaluation-types")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }
}
