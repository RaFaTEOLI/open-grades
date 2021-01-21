<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "configuration";

    protected $fillable = [
        'name', 'value'
    ];

    public $timestamps = true;

    public function format()
    {
        return (object) [
            'id' => $this->id,
            'name' => $this->name,
            'value' => $this->value,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
