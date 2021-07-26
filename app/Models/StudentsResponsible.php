<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * required={"name", "email"},
 * @OA\Xml(name="StudentsResponsible"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="name", type="string", description="Name of the user", example="John Doe"),
 * @OA\Property(property="email", type="string", format="email", description="User unique email address", example="johndoe@email.com"),
 * @OA\Property(property="photo", type="string", format="string", description="User photo", example="/images/johndoe.png"),
 * @OA\Property(property="created_at", type="string", readOnly="true", format="date-time", description="Datetime of when student was created", example="2019-02-25 12:59:20"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Datetime of when student was updated", example="2019-09-25 14:15:16"),
 * @OA\Property(property="responsibles", type="array", @OA\Items(ref="#/components/schemas/User")),
 * )
 *
 * Class StudentsResponsible
 *
 */
class StudentsResponsible extends Model
{
    use HasFactory;

    protected $table = "students_responsible";
    protected $fillable = ["student_id", "responsible_id"];

    public function responsible()
    {
        return $this->hasOne("App\Models\User", "id", "responsible_id");
    }

    public function student()
    {
        return $this->hasOne("App\Models\User", "id", "student_id");
    }

    public function format()
    {
        return (object) [
            "id" => $this->id,
            "responsible" => $this->responsible->formatSimple(),
            "student" => $this->student->formatSimple(),
        ];
    }

    public function formatResponsible()
    {
        return $this->responsible->formatSimple();
    }
}
