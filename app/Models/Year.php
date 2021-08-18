<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * required={"start_date", "end_date"},
 * @OA\Xml(name="Year"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="start_date", type="datetime", example="2020-01-27"),
 * @OA\Property(property="end_date", type="datetime", example="2020-12-10"),
 * @OA\Property(property="closed", type="integer", example="0"),
 * )
 *
 * Class Year
 *
 */
class Year extends Model
{
    use HasFactory;
    protected $fillable = ["start_date", "end_date", "closed"];
    public $timestamps = false;

    public function format()
    {
        return (object) [
            "id" => $this->id,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "closed" => $this->closed,
        ];
    }
}
