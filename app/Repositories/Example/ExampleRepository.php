<?php

namespace App\Repositories\Example;

use App\Models\User;
use App\Repositories\Abstract\AbstractRepository;

class ExampleRepository extends AbstractRepository
{
    protected $model = User::class;

    /**
     * Fetch All
     *
     * @return Model
     */
    // public function all()
    // {
    //     // return Model::all()
    //     //     ->get()
    //     //     ->map->format();
    // }

    /**
     * Get By Id
     *
     * @return Model
     * @param integer $id
     */
    // public function findById($id)
    // {
    //     // try {
    //     //     return Model::findOrFail($id)->format();
    //     // } catch (Exception $e) {
    //     //     throw new Exception($e->getMessage());
    //     // }
    // }

    /**
     * Update
     *
     * @return Boolean
     * @param integer $id
     * @param array $set
     */
    // public function update($id, $set)
    // {
    //     // $obj = Model::where('id', $id)->first();

    //     // $obj->update($set);

    //     // return true;
    // }

    /**
     * Delete
     *
     * @return Boolean
     * @param integer $id
     */
    // public function delete($id)
    // {
    //     // $obj = Model::where('id', $id)->delete();

    //     // return true;
    // }
}
