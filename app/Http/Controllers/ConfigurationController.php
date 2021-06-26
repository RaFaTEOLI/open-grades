<?php

namespace App\Http\Controllers;

use App\Http\Requests\Configuration\ConfigurationRequest;
use App\Models\Configuration;
use App\Repositories\Configuration\ConfigurationRepository;
use App\Services\Configuration\CreateConfigurationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class ConfigurationController extends Controller
{
    private $configurationRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->configurationRepository = new ConfigurationRepository();
    }

    public function index()
    {
        $configurations = $this->configurationRepository->all();

        return view("admin/configuration/configurations", [
            "configurations" => $configurations,
        ]);
    }

    public function store(ConfigurationRequest $request)
    {
        try {
            $createConfigurationService = new CreateConfigurationService();

            $input = $request->all();

            $createConfigurationService->execute($input);

            return redirect()
                ->route("configuration")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function show(int $id)
    {
        $configuration = $this->configurationRepository->findById($id);

        //return view('configuration/configurations', ["configuration" => $configuration]);
    }

    public function update(int $id, Request $request)
    {
        $input = $request->all();

        $this->configurationRepository->update($id, $input);

        return redirect()
            ->route("configuration")
            ->withSuccess(__("actions.success"));
    }

    public function destroy(int $id)
    {
        try {
            $this->configurationRepository->delete($id);

            return redirect()
                ->route("configuration")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }
}
