<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
