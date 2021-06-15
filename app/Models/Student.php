<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Shanmuga\LaravelEntrust\Traits\LaravelEntrustUserTrait;

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
