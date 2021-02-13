<?php

namespace App\Repositories\BaseRepository;

use App\Repositories\BaseRepository\BaseRepositoryInterface;

class BaseRepository implements BaseRepositoryInterface
{
    /**
     * Fetch All
     *
     * @return Model
     */
    public function all()
    {
        // return Model::all()
        //     ->get()
        //     ->map->format();
    }

    /**
     * Get By Id
     *
     * @return Model
     * @param integer $id
     */
    public function findById($id)
    {
        // return Model::where("id", $id)
        //     ->where("deleted_at", null)
        //     ->first()
        //     ->format();
    }

    /**
     * Update
     *
     * @return Boolean
     * @param integer $id
     * @param array $set
     */
    public function update($id, $set)
    {
        // $obj = Model::where('id', $id)->first();

        // $obj->update($set);

        // return true;
    }

    /**
     * Delete
     *
     * @return Boolean
     * @param integer $id
     */
    public function delete($id)
    {
        // $obj = Model::where('id', $id)->delete();

        // return true;
    }
}
