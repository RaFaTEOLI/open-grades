<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * required={"name", "value"},
 * @OA\Xml(name="Configuration"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="name", type="string", description="Name of the configuration", example="school-year-division"),
 * @OA\Property(property="value", type="string", description="Value of the configuration", example="4"),
 * @OA\Property(property="created_at", type="string", readOnly="true", format="date-time", description="Datetime of when configuration was created", example="2019-02-25 12:59:20"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Datetime of when configuration was updated", example="2020-02-25 13:30:00"),
 * )
 *
 * Class Configuration
 *
 */
class Configuration extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "configuration";

    protected $fillable = ["name", "value"];

    public $timestamps = true;

    public function format()
    {
        return (object) [
            "id" => $this->id,
            "name" => $this->name,
            "value" => $this->value,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
