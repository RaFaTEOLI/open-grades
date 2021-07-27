<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * required={"name", "display_name", "description"},
 * @OA\Xml(name="TeacherRoles"),
 * required={"name", "display_name", "description"},
 * @OA\Property(property="id", type="integer", readOnly="true", example="2"),
 * @OA\Property(property="name", type="string", description="Name of the role", example="teacher"),
 * @OA\Property(property="display_name", type="string", description="Display name of the role", example="Teacher"),
 * @OA\Property(property="description", type="string", description="Role description", example="Teacher"),
 * )
 *
 * Class TeacherRoles
 *
 */
class TeacherRoles extends Model
{
    use HasFactory;
}
