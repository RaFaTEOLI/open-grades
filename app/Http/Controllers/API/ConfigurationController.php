<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Configuration\ConfigurationRequest;
use App\Repositories\Configuration\ConfigurationRepository;
use App\Services\Configuration\CreateConfigurationService;
use Illuminate\Http\Request;
use Exception;

class ConfigurationController extends Controller
{
    private $configurationRepository;

    public function __construct()
    {
        $this->configurationRepository = new ConfigurationRepository();
    }

    public function index()
    {
        $configurations = $this->configurationRepository->all();

        return response()->json($configurations, HttpStatus::SUCCESS);
    }

    public function store(ConfigurationRequest $request)
    {
        try {
            $createConfigurationService = new CreateConfigurationService();

            $input = $request->all();
            $configuration = $createConfigurationService->execute($input);

            return response()->json($configuration, HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::UNAUTHORIZED);
        }
    }

    public function show(int $id)
    {
        try {
            ValidationController::isIdValid($id);

            $configuration = $this->configurationRepository->findById($id);

            return response()->json($configuration, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    public function update(int $id, Request $request)
    {
        try {
            $input = $request->all();

            $this->configurationRepository->update($id, $input);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->configurationRepository->delete($id);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::BAD_REQUEST);
        }
    }
}
