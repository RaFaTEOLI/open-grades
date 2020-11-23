<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telegram extends Model
{
    protected $table = "telegram";
    protected $fillable = [
        'message', 'user_id'
    ];
}
