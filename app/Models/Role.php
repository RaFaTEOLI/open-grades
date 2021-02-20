<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Shanmuga\LaravelEntrust\Models\EntrustRole;

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
