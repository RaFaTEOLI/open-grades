<?php

namespace App\Http\Controllers;

use App\Repositories\ConfigurationRepository;
use App\Services\CreateConfigurationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class ConfigurationController extends Controller
{
    private $configurationRepository;

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->configurationRepository = (new ConfigurationRepository());
    }

    public function index()
    {
        $configurations = $this->configurationRepository->all();

        return view('configuration/configurations', ["configurations" => $configurations]);
    }

    public function store(Request $request)
    {
        try {
            $createConfigurationService = new CreateConfigurationService();

            $validator = Validator::make($request->all(), [
                'name' => 'string|required',
                'value' => 'string|required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }

            $input = $request->all();

            $createConfigurationService->execute($input);

            return redirect()->route('configuration')->withSuccess(__('actions.success'));
        } catch (Exception $e) {
            return back()->with('error', __('actions.error'));
        }
    }

    public function show($id)
    {
        $configuration = $this->configurationRepository->findById($id);

        //return view('configuration/configurations', ["configuration" => $configuration]);
    }

    public function update($id, Request $request)
    {
        $input = $request->all();

        $configuration = $this->configurationRepository->update($id, $input);

        return redirect()->route('configuration')->withSuccess(__('actions.success'));
    }

    public function destroy($id)
    {
        try {
            $this->configurationRepository->delete($id);

            return redirect()->route('configuration')->withSuccess(__('actions.success'));
        } catch (Exception $e) {
            return back()->with('error', __('actions.error'));
        }
    }
}
