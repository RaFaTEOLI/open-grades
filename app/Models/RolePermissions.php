<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Role"),
 * required={"name", "display_name", "description"},
 * @OA\Property(property="id", type="integer", readOnly="true", example="3"),
 * @OA\Property(property="name", type="string", description="Name of the role", example="student"),
 * @OA\Property(property="display_name", type="string", description="Display name of the role", example="Student"),
 * @OA\Property(property="description", type="string", description="Role description", example="Student"),
 * @OA\Property(property="permissions", type="array", @OA\Items(ref="#/components/schemas/Permission")),
 * )
 *
 * Class RolePermissions
 *
 */
class RolePermissions extends Model
{
    use HasFactory;
}
