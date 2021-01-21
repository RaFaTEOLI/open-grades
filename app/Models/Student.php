<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'student_number', 'active'
    ];

    public $timestamps = false;

    /**
     * Get the user record associated with the student
     */
    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
}
