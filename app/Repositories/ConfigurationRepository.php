<?php

namespace App\Repositories;

use App\Configuration;
use App\Http\Controllers\Auth\AdminController;
use App\Repositories\ConfigurationRepositoryInterface;
use Exception;

class ConfigurationRepository implements ConfigurationRepositoryInterface
{

    /**
     * Get All Configurations
     */
    public function all()
    {
        return Configuration::all()
            ->map->format();
    }

    /**
     * Get Configuration By Id
     */
    public function findById($id)
    {
        return Configuration::findOrFail($id)->format();
    }

    public function update($id, $set)
    {
        try {
            $configuration = Configuration::findOrFail($id);

            $configuration->update($set);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            Configuration::findOrFail($id)->delete();
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function register($request)
    {
        try {
            AdminController::isAdminOrFail();

            return Configuration::create($request);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
