<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * required={"type"},
 * @OA\Xml(name="InvitationLink"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="user", type="object", description="User that created the invitation", ref="#/components/schemas/User"),
 * @OA\Property(property="student", type="boolean", description="Student that used the link", example=null),
 * @OA\Property(property="hash", type="string", description="Hash that was created for the invitation", readOnly="true", example="2y1fAnF2c42ZiGxDkwuTu14UeU1IxnRKnSyPv8vuMIbQu13xCkvCOXS"),
 * @OA\Property(property="link", type="string", description="URL with the respective hash to be sign in", readOnly="true", example="http:\/\/localhost\/register\/?hash=2y1fAnF2c42ZiGxDkwuTu14UeU1IxnRKnSyPv8vuMIbQu13xCkvCOXS"),
 * @OA\Property(property="type", type="string", description="Type of the user's role that will be signed up through the invite. Option: [STUDENT, TEACHER, RESPONSIBLE]", readOnly="true", example="STUDENT"),
 * @OA\Property(property="used_at", type="string", format="date-time", description="Datetime of when invite was used", example="2019-04-25 12:59:20"),
 * @OA\Property(property="created_at", type="string", readOnly="true", format="date-time", description="Datetime of when invite was created", example="2019-02-25 12:59:20"),
 * )
 *
 * Class InvitationLink
 *
 */
class InvitationLink extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["user_id", "type", "student_id", "hash", "used_at"];

    public $timestamps = true;

    /**
     * Get the user record associated with the user
     */
    public function user()
    {
        return $this->hasOne("App\Models\User", "id", "user_id");
    }

    /**
     * Get the user record associated with the student
     */
    public function student()
    {
        return $this->hasOne("App\Models\User", "id", "student_id");
    }

    public function format()
    {
        return (object) [
            "id" => $this->id,
            "user" => $this->user->formatSimple(),
            "student" => $this->student_id ? $this->student->formatSimple() : null,
            "hash" => $this->hash,
            "link" => $this->getLinkFromHash($this->hash),
            "type" => $this->type,
            "used_at" => $this->used_at,
            "created_at" => $this->created_at,
        ];
    }

    public static function getLinkFromHash($hash)
    {
        return env("APP_URL") . "/register/?hash={$hash}";
    }
}
