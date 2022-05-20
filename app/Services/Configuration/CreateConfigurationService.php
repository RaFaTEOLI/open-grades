<?php

namespace App\Services\Configuration;

use App\Exceptions\UserNotAdmin;
use App\Repositories\Configuration\ConfigurationRepository;
use App\Http\Controllers\Auth\AdminController;
use App\Models\Configuration;
use Exception;

class CreateConfigurationService
{
    private $configurationRepository;

    public function __construct()
    {
        $this->configurationRepository = (new ConfigurationRepository());
    }

    public function execute(array $request): Configuration
    {
        try {
            AdminController::isAdminOrFail();
            return $this->configurationRepository->register($request);
        } catch (UserNotAdmin $e) {
            throw new UserNotAdmin($e->getMessage());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
