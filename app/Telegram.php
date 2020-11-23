<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telegram extends Model
{
    protected $table = "telegram";
    protected $fillable = [
        'message', 'user_id'
    ];

     /**
     * Get the user record associated with the message
     */
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function format()
    {
        return (object) [
            'id' => $this->id,
            'message' => $this->message,
            'user' => $this->user->format(),
            'created_at' => $this->created_at,
        ];
    }
}
