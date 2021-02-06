<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
        $this->configurationRepository = new ConfigurationRepository();
    }

    public function index()
    {
        $configurations = $this->configurationRepository->all();

        return response()->json($configurations, HttpStatus::SUCCESS);
    }

    public function store(Request $request)
    {
        try {
            $createConfigurationService = new CreateConfigurationService();

            $validator = Validator::make(
                $request->all(),
                Configuration::validationRules(),
            );

            if ($validator->fails()) {
                return response()->json(
                    ["error" => $validator->errors()],
                    HttpStatus::BAD_REQUEST,
                );
            }

            $input = $request->all();
            $configuration = $createConfigurationService->execute($input);

            return response()->json($configuration, HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(
                ["message" => $e->getMessage()],
                HttpStatus::UNAUTHORIZED,
            );
        }
    }

    public function show($id)
    {
        try {
            ValidationController::isIdValid($id);

            $configuration = $this->configurationRepository->findById($id);

            return response()->json($configuration, HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return response()->json(
                ["message" => $e->getMessage()],
                HttpStatus::BAD_REQUEST,
            );
        }
    }

    public function update($id, Request $request)
    {
        try {
            $input = $request->all();

            $this->configurationRepository->update($id, $input);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(
                ["message" => $e->getMessage()],
                HttpStatus::BAD_REQUEST,
            );
        }
    }

    public function destroy($id)
    {
        try {
            $this->configurationRepository->delete($id);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(
                ["message" => $e->getMessage()],
                HttpStatus::BAD_REQUEST,
            );
        }
    }
}
