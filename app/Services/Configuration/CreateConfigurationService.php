<?php

namespace App\Services;

use App\Repositories\ConfigurationRepository;
use App\Configuration;
use App\Http\Controllers\Auth\AdminController;
use Exception;

class CreateConfigurationService
{
    private $configurationRepository;

    public function __construct()
    {
        $this->configurationRepository = (new ConfigurationRepository());
    }

    public function execute(array $request) {
        try {
            AdminController::isAdminOrFail();
            return $this->configurationRepository->register($request);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
