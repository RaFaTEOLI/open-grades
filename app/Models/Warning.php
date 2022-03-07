<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * required={"student_id", "class_id", "description"},
 * @OA\Xml(name="Warning"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="student", type="object", ref="#/components/schemas/Student"),
 * @OA\Property(property="reporter", type="object", ref="#/components/schemas/User"),
 * @OA\Property(property="class", type="object", ref="#/components/schemas/Classes"),
 * @OA\Property(property="description", type="string", example="Student was being too loud"),
 * )
 *
 * Class Warning
 *
 */
class Warning extends Model
{
    use HasFactory;
    protected $fillable = ["student_id", "class_id", "reporter_id", "description"];
    public $timestamps = true;

    public function student()
    {
        return $this->hasOne("App\Models\Student", "id", "student_id");
    }

    public function class()
    {
        return $this->hasOne("App\Models\Classes", "id", "class_id");
    }

    public function user()
    {
        return $this->hasOne("App\Models\User", "id", "reporter_id");
    }

    public function format()
    {
        return (object) [
            "id" => $this->id,
            "student" => $this->student->format(),
            "class" => $this->class->format(),
            "reporter" => $this->user->format(),
            "description" => $this->description,
        ];
    }
}
