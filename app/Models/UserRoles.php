<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * required={"password"},
 * @OA\Xml(name="UserRoles"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="name", type="string", description="Name of the user", example="John Doe"),
 * @OA\Property(property="email", type="string", format="email", description="User unique email address", example="johndoe@email.com"),
 * @OA\Property(property="photo", type="string", format="string", description="User photo", example="/images/johndoe.png"),
 * @OA\Property(property="created_at", type="string", readOnly="true", format="date-time", description="Datetime of when user was created", example="2019-02-25 12:59:20"),
 * @OA\Property(property="roles", type="object", ref="#/components/schemas/Role"),
 * )
 *
 * Class UserRoles
 *
 */
class UserRoles extends Model
{
    use HasFactory;
}
