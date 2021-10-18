<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * required={"name", "weight"},
 * @OA\Xml(name="EvaluationType"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="name", type="string", example="Semester Exam"),
 * @OA\Property(property="weight", type="number", example="10"),
 * )
 *
 * Class EvaluationType
 *
 */
class EvaluationType extends Model
{
    use HasFactory;
    protected $fillable = ["name", "weight"];
    public $timestamps = false;


    public function format()
    {
        return (object) [
            "id" => $this->id,
            "name" => $this->name,
            "weight" => $this->weight
        ];
    }
}
