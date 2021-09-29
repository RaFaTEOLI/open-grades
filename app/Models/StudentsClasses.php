<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * required={"user_id", "class_id"},
 * @OA\Xml(name="StudentsClasses"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
 * @OA\Property(property="class", type="object", ref="#/components/schemas/Classes"),
 * @OA\Property(property="presence", type="integer", example="10"),
 * @OA\Property(property="absent", type="integer", example="2"),
 * @OA\Property(property="enroll_date", type="datetime", example="2021-08-01"),
 * @OA\Property(property="left_date", type="datetime", example="2022-08-01"),
 * )
 *
 * Class StudentsClasses
 *
 */
class StudentsClasses extends Model
{
    use HasFactory;
    protected $fillable = ["user_id", "class_id", "presence", "absent"];
    public $timestamps = false;

    public function class()
    {
        return $this->hasOne("App\Models\Classes", "id", "class_id");
    }

    public function user()
    {
        return $this->hasOne("App\Models\User", "id", "user_id");
    }

    public function format()
    {
        return (object) [
            "id" => $this->id,
            "user" => $this->user->formatSimple(),
            "class" => $this->class->format(),
            "presence" => $this->presence,
            "absent" => $this->absent,
            "enroll_date" => $this->enroll_date,
            "left_date" => $this->left_date,
        ];
    }

    public function formatClassesOnly()
    {
        return $this->class->format();
    }
}
