<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitationLink extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["user_id", "type", "hash", "used_at"];

    public $timestamps = true;

    /**
     * Get the user record associated with the student
     */
    public function user()
    {
        return $this->hasOne("App\Models\User", "id", "user_id");
    }

    /**
     * Validation Rules Array.
     *
     */
    public static function validationRules()
    {
        return [
            "type" => "required",
        ];
    }

    public function format()
    {
        return (object) [
            "id" => $this->id,
            "user" => $this->user->format(),
            "hash" => $this->hash,
            "link" => $this->getLinkFromHash($this->hash),
            "type" => $this->type,
            "created_at" => $this->created_at,
        ];
    }

    public static function getLinkFromHash($hash)
    {
        return env("APP_URL") . "/register/?hash={$hash}";
    }
}
