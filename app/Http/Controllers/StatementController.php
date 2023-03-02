<?php

namespace App\Http\Controllers;

use App\Http\Requests\Statement\StatementRequest;
use App\Repositories\Statement\StatementRepository;
use App\Services\Statement\CreateStatementService;
use Exception;
use Illuminate\Http\Request;

class StatementController extends Controller
{
    private $statementRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->statementRepository = new StatementRepository();
    }

    public function index()
    {
        try {
            $statements = $this->statementRepository->all();

            return view("statements/statements", [
                "statements" => $statements,
            ]);
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function store(StatementRequest $request)
    {
        try {
            $input = $request->only(["subject", "statement"]);

            (new CreateStatementService())->execute($input);

            return redirect()
                ->route("statements")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function update(int $id, Request $request)
    {
        try {
            $input = $request->only(["subject", "statement"]);
            $this->statementRepository->update($id, $input);

            return redirect()
                ->route("statements")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function show(int $id)
    {
        try {
            $statement = $this->statementRepository->findById($id);

            return view("statements/statement", [
                "statement" => $statement
            ]);
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function new()
    {
        try {
            return view("statements/statement");
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->statementRepository->delete($id);

            return redirect()
                ->route("statements")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }
}
