<?php

namespace App\Repositories\Configuration;

use App\Models\Configuration;
use App\Repositories\Configuration\ConfigurationRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;


class ConfigurationRepository implements ConfigurationRepositoryInterface
{

    /**
     * Get All Configurations
     */
    public function all(int $limit = 0, int $offset = 0): Collection
    {
        try {
            return Configuration::when($limit, function ($query, $limit) {
                return $query->limit($limit);
            })
                ->when($offset && $limit, function ($query, $offset) {
                    return $query->offset($offset);
                })
                ->get()
                ->map->format();
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    /**
     * Get Configuration By Id
     */
    public function findById(int $id): object
    {
        try {
            return Configuration::findOrFail($id)->format();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function update(int $id, array $set): void
    {
        try {
            $configuration = Configuration::findOrFail($id);

            $configuration->update($set);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function delete(int $id): bool
    {
        try {
            Configuration::findOrFail($id)->delete();
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function register(array $request): Configuration
    {
        try {
            return Configuration::create($request);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
