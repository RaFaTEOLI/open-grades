<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Shanmuga\LaravelEntrust\Traits\LaravelEntrustUserTrait;

/**
 *
 * @OA\Schema(
 * required={"name", "email"},
 * @OA\Xml(name="Student"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="name", type="string", description="Name of the user", example="John Doe"),
 * @OA\Property(property="email", type="string", format="email", description="User unique email address", example="johndoe@email.com"),
 * @OA\Property(property="photo", type="string", format="string", description="User photo", example="/images/johndoe.png"),
 * @OA\Property(property="created_at", type="string", readOnly="true", format="date-time", description="Datetime of when student was created", example="2019-02-25 12:59:20"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Datetime of when student was updated", example="2019-09-25 14:15:16"),
 * @OA\Property(property="responsibles", type="array", @OA\Items(ref="#/components/schemas/User")),
 * )
 *
 * Class Student
 *
 */
class Student extends Model
{
    use HasFactory;
    use LaravelEntrustUserTrait;

    protected $table = "users";

    /**
     * Get the user record associated with the student
     */
    public function responsibles()
    {
        return $this->hasMany("App\Models\StudentsResponsible", "student_id", "id");
    }

    public function format()
    {
        return (object) [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "photo" => $this->photo,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "responsibles" => count($this->responsibles) > 0 ? $this->responsibles->map->formatResponsible() : [],
        ];
    }
}
