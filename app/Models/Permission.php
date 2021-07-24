<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Shanmuga\LaravelEntrust\Models\EntrustPermission;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Permission"),
 * required={"name", "display_name", "description"},
 * @OA\Property(property="id", type="integer", readOnly="true", example="3"),
 * @OA\Property(property="name", type="string", description="Name of the role", example="create-users"),
 * @OA\Property(property="display_name", type="string", description="Display name of the role", example="Create Users"),
 * @OA\Property(property="description", type="string", description="Role description", example="Create Users"),
 * )
 *
 * Class Permission
 *
 */
class Permission extends EntrustPermission
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["name", "display_name", "description"];

    public function format()
    {
        return (object) [
            "id" => $this->id,
            "name" => $this->name,
            "display_name" => $this->display_name,
            "description" => $this->description,
        ];
    }
}
