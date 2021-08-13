<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * required={"name"},
 * @OA\Xml(name="Subject"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="name", type="string", readOnly="true", example="Math"),
 * )
 *
 * Class Subject
 *
 */
class Subject extends Model
{
    use HasFactory;
    protected $fillable = ["name"];
    public $timestamps = false;

    public function format()
    {
        return (object) [
            "id" => $this->id,
            "name" => $this->name,
        ];
    }
}
