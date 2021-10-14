<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * required={"name"},
 * @OA\Xml(name="Grade"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="name", type="string", example="Preschool"),
 * )
 *
 * Class Grade
 *
 */
class Grade extends Model
{
    use HasFactory;
    protected $fillable = ["name"];
    public $timestamps = false;

    public function class()
    {
        return $this->hasMany("App\Models\Classes", "grade_id", "id");
    }

    public function format()
    {
        return (object) [
            "id" => $this->id,
            "name" => $this->name,
        ];
    }

    public function formatWithClasses()
    {
        return (object) [
            "id" => $this->id,
            "name" => $this->name,
            "classes" => $this->class->map->format()
        ];
    }
}
