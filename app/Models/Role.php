<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Shanmuga\LaravelEntrust\Models\EntrustRole;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Role"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="3"),
 * @OA\Property(property="name", type="string", description="Name of the role", example="student"),
 * @OA\Property(property="display_name", type="string", description="Display name of the role", example="Student"),
 * @OA\Property(property="description", type="string", description="Role description", example="Student"),
 * )
 *
 * Class Role
 *
 */
class Role extends EntrustRole
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
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "permissions" => $this->permissions()->get(),
        ];
    }

    public function formatWithoutPermissions()
    {
        return (object) [
            "id" => $this->id,
            "name" => $this->name,
            "display_name" => $this->display_name,
            "description" => $this->description,
        ];
    }
}
