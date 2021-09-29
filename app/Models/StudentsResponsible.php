<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * required={"type"},
 * @OA\Xml(name="StudentsResponsible"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="user_id", type="integer", description="User that created the invitation", example="1"),
 * @OA\Property(property="student_id", type="integer", description="Student that is linked in the invitation", example="2"),
 * @OA\Property(property="hash", type="string", description="Hash that was created for the invitation", readOnly="true", example="2y1fAnF2c42ZiGxDkwuTu14UeU1IxnRKnSyPv8vuMIbQu13xCkvCOXS"),
 * @OA\Property(property="link", type="string", description="URL with the respective hash to be sign in", readOnly="true", example="http:\/\/localhost\/register\/?hash=2y1fAnF2c42ZiGxDkwuTu14UeU1IxnRKnSyPv8vuMIbQu13xCkvCOXS"),
 * @OA\Property(property="type", type="string", description="Type of the user's role that will be signed up through the invite. Option: [STUDENT, TEACHER, RESPONSIBLE]", readOnly="true", example="STUDENT"),
 * @OA\Property(property="used_at", type="string", format="date-time", description="Datetime of when invite was used", example="2019-04-25 12:59:20"),
 * @OA\Property(property="created_at", type="string", readOnly="true", format="date-time", description="Datetime of when invite was created", example="2019-02-25 12:59:20"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Datetime of when invite was updated", example="2019-05-25 12:59:20"),
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

    public function formatStudentsOnly()
    {
        return $this->student->formatSimple();
    }
}
