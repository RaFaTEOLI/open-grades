<?php

namespace App\Repositories\Abstract;

use App\Repositories\Abstract\AbstractRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class AbstractRepository implements AbstractRepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->resolveModel();
    }

    protected function resolveModel()
    {
        return app($this->model);
    }

    public function all(): Collection | array
    {
        try {
            return $this->model->all();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function store(array $request): Model
    {
        try {
            return $this->model->create($request);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function findById(int $id): object
    {
        try {
            return $this->model->findOrFail($id);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function update(int $id, array $set): void
    {
        try {
            $obj = $this->model->findOrFail($id);

            $obj->update($set);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function delete(int $id): bool
    {
        try {
            $this->model->findOrFail($id)->delete();

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
