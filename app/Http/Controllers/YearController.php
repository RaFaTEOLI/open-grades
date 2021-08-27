<?php

namespace App\Http\Controllers;

use App\Http\Requests\Year\YearRequest;
use App\Repositories\Year\YearRepository;
use App\Services\Year\OpenSchoolYearService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class YearController extends Controller
{
    private $yearRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->yearRepository = new YearRepository();
    }

    public function index()
    {
        try {
            $years = $this->yearRepository->all();

            return view("years/years", [
                "years" => $years,
            ]);
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function store(YearRequest $request)
    {
        try {
            $input = $request->only(["start_date", "end_date"]);

            (new OpenSchoolYearService())->execute($input);

            return redirect()
                ->route("years")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function update(int $id, Request $request)
    {
        try {
            $input = $request->only(["start_date", "end_date", "closed"]);
            $this->yearRepository->update($id, $input);

            return redirect()
                ->route("years")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function show(int $id)
    {
        try {
            $year = $this->yearRepository->findById($id);

            return view("years/year", ["year" => $year]);
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->yearRepository->delete($id);

            return redirect()
                ->route("years")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function close(int $id)
    {
        try {
            $this->yearRepository->update($id, ["closed" => 1]);

            return redirect()
                ->route("years")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }
}
