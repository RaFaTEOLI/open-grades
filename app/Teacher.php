<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'teacher_number', 'active'
    ];

    public $timestamps = false;

     /**
     * Get the user record associated with the teacher
     */
    public function user()
    {
        return $this->hasOne('App\User');
    }
}
