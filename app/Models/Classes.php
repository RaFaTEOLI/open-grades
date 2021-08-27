<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * required={"name"},
 * @OA\Xml(name="Classes"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="year", type="object", ref="#/components/schemas/Year"),
 * @OA\Property(property="subject", type="object", ref="#/components/schemas/Subject"),
 * @OA\Property(property="grade", type="object", ref="#/components/schemas/Grade"),
 * @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
 * )
 *
 * Class Classes
 *
 */
class Classes extends Model
{
    use HasFactory;
    protected $fillable = ["year_id", "subject_id", "grade_id", "user_id"];
    public $timestamps = false;

    public function year()
    {
        return $this->hasOne("App\Models\Year", "id", "year_id");
    }

    public function subject()
    {
        return $this->hasOne("App\Models\Subject", "id", "subject_id");
    }

    public function grade()
    {
        return $this->hasOne("App\Models\Grade", "id", "grade_id");
    }

    public function user()
    {
        return $this->hasOne("App\Models\User", "id", "user_id");
    }

    public function format()
    {
        return (object) [
            "id" => $this->id,
            "year" => $this->year->format(),
            "subject" => $this->subject->format(),
            "grade" => $this->grade->format(),
            "user" => $this->user->formatSimple(),
        ];
    }
}
